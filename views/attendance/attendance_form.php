<?php

authorizedPage();

$_SESSION['employeeid'] = 1;

//generic db script copied and pasted

global $db;

require "attendance_utilities.php";

include('header.php');

//make sure that information was entered into form
if(!isset($_POST['curr']))
{
    echo "<div class='container'>";
    echo "<p>Error: Please first pick a class to take attendance for.</p>";
    echo "<p><a href='new-class'>Class Selection Link</a></p>";
    echo "</div>";
    include('footer.php');
    die;
}

$selected_class = $_POST['classes'];
$selected_curr = $_POST['curr'];
$selected_date = $_POST['date-input'];
$selected_time = $_POST['time-input'];
$selected_site = $_POST['site'];
$selected_lang = $_POST['lang'];

$employee_id = $_SESSION['employeeid'];

$pageInformation = array();

$successAddingPerson = false;

//if we have previous information passed to us from lookup form or add person form,
//  then display this information instead of db information
if(isset($_SESSION['serializedInfo'])) {
    //we're coming from the attendance-form-confirmation page or the edit-participant page
    if(isset($_POST['fromConfirmPage']) || isset($_POST['fromEditParticipant'])) {
        $_SESSION['duplicatePostAddPerson'] = false;
        $pageInformation = deserializeParticipantMatrix($_SESSION['serializedInfo']);
    }
    else if(isset($_POST['lookupId'])){
        $pageInformation = deserializeParticipantMatrix($_SESSION['serializedInfo']);
        //TODO: Vallie is working on search from this page
        //query against the name and add details to page
    }
    //we're coming from the current page and posting new participant info
    else if((isset($_POST['fromAddPerson'])) && ($_POST['fromAddPerson'] == 1)){ //avoid reload page error
        $firstTimeSubmitting = true;
        if(isset($_SESSION['duplicatePostAddPerson'])){ //avoid duplicate entries on page reload
            if($_SESSION['duplicatePostAddPerson']){
                $pageInformation = deserializeParticipantMatrix($_SESSION['serializedInfo']);
                $firstTimeSubmitting = false;
            }
        }

        if($firstTimeSubmitting){
            //ensure no duplicate entries
            $_SESSION['duplicatePostAddPerson'] = true;

            //update our posted information
            updateSessionClassInformation();
            $pageInformation = deserializeParticipantMatrix($_SESSION['serializedInfo']);

            $fn = $_POST['new-person-first'];
            $mi = $_POST['new-person-middle'];
            $ln = $_POST['new-person-last'];
            $race = $_POST['race-select'];
            $ageInput = $_POST['age-input'];
            $numC = $_POST['num-children-input'];
            $zipInput = $_POST['zip-input'];

            //validate input
            if(
                validateName($fn) &&
                validateMiddle($mi) &&
                validateName($ln) &&
                validateRace($race) &&
                validateAge($ageInput) &&
                validateNumChildren($numC) &&
                validateZip($zipInput)
            )
            {
                //add to participantMatrix
                $pageInformation[] = array(
                    "pid"           => 0, //will be changed later from function
                    "fn"            => $fn,
                    "mi"            => $mi,
                    "ln"            => $ln,
                    "dob"           => date_subtraction((string) $ageInput . " years"),
                    "zip"           => $zipInput,
                    "numChildren"   => $numC,
                    "race"          => $race,
                    "comments"      => null,
                    "present"       => true,
                    "isNew"         => true, //isNew field from DB
                    //people who haven't completed the intake forms and just filled out info in the "no intake form" section
                    "firstClass"    => true
                );

                $successAddingPerson = true;
            }
        }


    }
    else{
        //default, just load the page
        $pageInformation = deserializeParticipantMatrix($_SESSION['serializedInfo']);
    }

}
//else grab information from the db and format it into the associative array format
else {
    //ensure no duplicate entries
    $_SESSION['duplicatePostAddPerson'] = false;

    $threeWeeksAgo = date_subtraction('22 days');

    $fullQuery = "select * from classattendancedetails " .
        " where curriculumname = '" . escape_apostrophe($selected_curr) . "' " .
        "and facilitatorid = {$employee_id} " .
        "and date >= '{$threeWeeksAgo}';";

    //query the view
    $get_participants = $db->no_param_query($fullQuery);

    while($row = pg_fetch_assoc($get_participants)){

        $pageInformation[] = array(
            "pid"           => $row['participantid'],
            "fn"            => $row['firstname'],
            "mi"            => $row['middleinit'],
            "ln"            => $row['lastname'],
            "dob"           => $row['dateofbirth'],
            "zip"           => $row['zipcode'],
            "numChildren"   => $row['numchildren'],
            "race"          => null,
            "comments"      => null,
            "present"       => false,
            "isNew"         => false, //isNew field from DB
            //people who haven't completed the intake forms and just filled out info in the "no intake form" section
            "firstClass"    => false
    );
    }
}


$get_races = $db->no_param_query("SELECT unnest(enum_range(NULL::race));");

$convert_date = DateTime::createFromFormat('Y-m-d', $selected_date);
$display_date = $convert_date->format('l, F jS');

$convert_time = DateTime::createFromFormat('H:i', $selected_time);
$display_time = $convert_time->format('g:i A');

?>
    <script src="/js/attendance-scripts/attendance-form-add-new-person.js"></script>

    <script>

        //name of the only form on the page
        var pageFormName = 'whole-page-form';

        //input: page the form redirects to
        //output: none
        function setFormAction(action){
            document.getElementById(pageFormName).action = action;
        }

        function submitAttendance() {
            setFormAction('attendance-form-confirmation');
            document.getElementById(pageFormName).submit();
        }

        function editPerson(){
            setFormAction('edit-participant');
            document.getElementById(pageFormName).submit();
        }

        //TODO: handle logic (Vallie is working on this page)
        function searchForPerson() {
            //setFormAction('');
            //document.getElementById(pageFormName).submit();
        }

        function addPerson() {
            //TODO: handle submission logic
            if(jsValidateTable() === true){
                setFormAction('attendance-form');
                document.getElementById('fromAddPerson').value = 1; //helps to identify that we just added someone
                document.getElementById(pageFormName).submit();
            }
        }
    </script>

    <div class="container-fluid">
        <form action="" method="post" id="whole-page-form">
        <div class="row flex-column">
            <!-- Default container contents -->
            <div class="h3 text-center">
                <?php
                    echo "{$selected_curr} : {$selected_class}";
                ?>
            </div>
            <div class="h6 text-center">
                <?php
                    echo "Class Time: {$display_time} - {$display_date}";
                ?>
            </div>

            <?php

            if($successAddingPerson){
                echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\"> ";
                echo        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"> ";
                echo        "<span aria-hidden=\"true\">&times;</span> ";
                echo        "</button>";
                echo        "<div style = 'text-align: center;'><strong>Success!</strong> Participant added to list. </div>";
                echo    "</div>";
            }

            ?>

                <div class="card" style="margin-bottom: 10px;">
                    <div class="card-block">

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" id="class-list">
                                    <thead>
                                    <tr>
                                        <th>Present</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Zip</th>
                                        <th>Number of </br> children under 18</th>
                                        <th>Comments</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <tr class="m-0">
                                    <?php
                                    for($i = 0; $i < count($pageInformation); $i++) {
                                        //field names - unique field names for individuals which are checked upon post
                                        $presentName =      (string) $i . "-" . "check";
                                        $commentName =      (string) $i . "-" . "comment";

                                        echo "<tr class=\"m-0\" id=\"{$i}\">";
                                        echo "<td>";
                                        echo "<label class=\"custom-control custom-checkbox\">";
                                        //checkbox checked option
                                        $checked = null;
                                        $pageInformation[$i]['present'] ? $checked = "checked=\"checked\"" : $checked = "";
                                        echo "<input type=\"checkbox\" class=\"custom-control-input\" {$checked} name='{$presentName}'>";
                                        echo "<span class=\"custom-control-indicator\"></span>";
                                        echo "</label>";
                                        echo "</td>";
                                        echo "<td>{$pageInformation[$i]['fn']} {$pageInformation[$i]['mi']} {$pageInformation[$i]['ln']}</td>";

                                        $age = calculate_age($pageInformation[$i]['dob']);
                                        echo "<td>{$age}</td>";
                                        echo "<td>{$pageInformation[$i]['zip']}</td>";
                                        echo "<td>{$pageInformation[$i]['numChildren']}</td>";
                                        echo "<td>";
                                        echo "<div class=\"form-group\">";
                                        echo "<div class=\"col-10\">";
                                        //pre-fill comment if exists
                                        $comment = null;
                                        (is_null($pageInformation[$i]['comments'])) ? $comment = "" : $comment = $pageInformation[$i]['comments'];
                                        echo "<textarea class=\"form-control\" type=\"textarea\" rows=\"2\" placeholder=\"enter comments here...\" name='{$commentName}'>{$comment}</textarea>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</td>";
                                        echo "<td>";
                                        echo "<button class='btn btn-link' onclick='editPerson()'>Edit</button>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    //update the session information
                                    $_SESSION['serializedInfo'] = serializeParticipantMatrix($pageInformation);
                                        ?>
                                    </tbody>
                                </table>
                                <!-- /Table -->
                            </div>
                            <?php
                            //hidden form values

                            //class information
                            echo "<input type=\"hidden\" id=\"classes\" name=\"classes\" value=\"{$selected_class}\" />";
                            echo "<input type=\"hidden\" id=\"curr\" name=\"curr\" value=\"{$selected_curr}\" />";
                            echo "<input type=\"hidden\" id=\"date-input\" name=\"date-input\" value=\"{$selected_date}\" />";
                            echo "<input type=\"hidden\" id=\"time-input\" name=\"time-input\" value=\"{$selected_time}\" />";
                            echo "<input type=\"hidden\" id=\"site\" name=\"site\" value=\"{$selected_site}\" />";
                            echo "<input type=\"hidden\" id=\"lang\" name=\"lang\" value=\"{$selected_lang}\" />";

                            //helps identify if we've just added a person
                            echo "<input type=\"hidden\" id=\"fromAddPerson\" name=\"fromAddPerson\" value=\"0\" />";

                            //edit button information
                            echo "<input type=\"hidden\" id=\"editButton\" name=\"editButton\" value=\"\" />";
                            ?>
                    </div>
                </div>
        </div>

        <div class="row flex-column">

            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="card">
                        <div class="card-header" role="tab" id="headingOne">
                            <h5 class="mb-0">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Search for Person
                                </a>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                            <div class="card-block" style="padding: 10px;">
                                <p>
                                    If a person is not shown here but has already filled out the intake packet,
                                    please search for them here.
                                </p>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="searchquery" onclick="searchForPerson()" placeholder="Begin typing participant's name...">
                                    </div>
                                    <button type="button" class="btn cpca form-control" onclick="">Submit</button>
                            </div>
                        </div>
                </div>
                <div class="card">
                    <div class="card-header" role="tab" id="headingTwo">
                        <h5 class="mb-0">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                No Intake Form
                            </a>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="card-block" style="padding: 10px">
                                <div class="form-group row" style="margin-left: 10px">
                                    <p>If a person has not filled out intake forms, please enter their information below.</p>
                                </div>
                                <div id = "alert-box"></div>
                                <!-- first -->
                                <div class="form-group row">
                                    <label for="new-person-first" class="col-3 col-form-label">First <div style="color:red; display:inline">*</div></label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="" id="new-person-first" name="new-person-first" placeholder="enter first name...">
                                    </div>
                                </div>
                                <!-- middle initial -->
                                <div class="form-group row">
                                    <label for="new-person-middle" class="col-3 col-form-label">Middle Initial</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="" id="new-person-middle" name="new-person-middle" placeholder="enter middle initial...">
                                    </div>
                                </div>
                                <!-- last -->
                                <div class="form-group row">
                                    <label for="new-person-last" class="col-3 col-form-label">Last <div style="color:red; display:inline">*</div></label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="" id="new-person-last" name="new-person-last" placeholder="enter last name...">
                                    </div>
                                </div>
                                <!-- race
                                TODO: dynamically get races
                                -->
                                <div class="form-group row">
                                    <label for="race-select" class="col-3 col-form-label">Race <div style="color:red; display:inline">*</div></label>
                                        <div class="col-9">
                                        <select id="race-select" name="race-select" class="form-control">
                                            <option>Select Race...</option>
                                            <?php
                                            //need to keep track of different races for form validation
                                            $race_array = array();

                                            while($row = pg_fetch_assoc($get_races)){
                                                $raceOption = $row['unnest'];
                                                echo "<option>{$raceOption}</option>";
                                                $race_array[] = $raceOption;
                                            }

                                            //set a session variable so we can validate races after post
                                            $_SESSION['races'] = $race_array;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- Age -->
                                <div class="form-group row">
                                    <label for="age-input" class="col-3 col-form-label">Age <div style="color:red; display:inline">*</div></label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" value="" id="age-input" name="age-input" placeholder="please enter age...">
                                    </div>
                                </div>
                                <!-- Number of children under 18 -->
                                <div class="form-group row">
                                    <label for="num-children-input" class="col-3 col-form-label">Number of children under 18 <div style="color:red; display:inline">*</div></label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" value="" id="num-children-input" name="num-children-input" placeholder="please enter number of children...">
                                    </div>
                                </div>
                                <!-- Zip code -->
                                <div class="form-group row">
                                    <label for="zip-input" class="col-3 col-form-label">Zip code</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="12601" id="zip-input" name="zip-input" placeholder="enter zip code...">
                                    </div>
                                </div>

                                <!-- validate and add to list above -->
                                <div class = "row">

                                    <button type="button" class="btn btn-primary" style="margin-left:15px" onclick="addPerson()">Add Person</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <br/>
            <div class="d-flex justify-content-start">
                <button type="button" class="btn btn-success" onclick="submitAttendance()">Submit Attendance</button>
            </div>
        </div>
        </form>
    </div>


<?php
include('footer.php');
?>