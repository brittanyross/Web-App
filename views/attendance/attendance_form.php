<?php

authorizedPage();

$_SESSION['employeeid'] = 1;

//generic db script copied and pasted

global $db;

require "attendance_utilities.php";

/*$params;
$peopleid = $params[0];

$result = $db->query("SELECT participants.participantid, participants.dateofbirth, participants.race, people.firstname, people.lastname, people.middleinit " .
    "FROM participants " .
    "INNER JOIN people ON participants.participantid = people.peopleid WHERE people.peopleid=$1", [$peopleid]);

$participant = pg_fetch_assoc($result);

*/

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

$employee_id = $_SESSION['employeeid'];

$get_races = $db->no_param_query("SELECT unnest(enum_range(NULL::race));");

$threeWeeksAgo = date_subtraction('22 days');

$fullQuery = "select * from classattendancedetails " .
    " where curriculumname = '" . escape_apostrophe($selected_curr) . "' " .
    "and facilitatorid = {$employee_id} " .
    "and date >= '{$threeWeeksAgo}';";

//query the view
$get_participants = $db->no_param_query($fullQuery);

$convert_date = DateTime::createFromFormat('Y-m-d', $selected_date);
$display_date = $convert_date->format('l, F jS');

$convert_time = DateTime::createFromFormat('H:i', $selected_time);
$display_time = $convert_time->format('g:i A');

?>
    <script src="/js/attendance-scripts/attendance-form-add-new-person.js"></script>

    <div class="container-fluid">
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

            <form action ="attendance-form-confirmation" method="post">
                <div class="card">
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
                                while($row = pg_fetch_assoc($get_participants)){
                                echo "<tr class=\"m-0\" id=\"{$row['participantid']}\">";
                                    echo "<td>";
                                        echo "<label class=\"custom-control custom-checkbox\">";
                                            echo "<input type=\"checkbox\" class=\"custom-control-input\">";
                                            echo "<span class=\"custom-control-indicator\"></span>";
                                        echo "</label>";
                                    echo "</td>";
                                    echo "<td>{$row['firstname']} {$row['middleinit']} {$row['lastname']}</td>";

                                    $age = calculate_age($row['dateofbirth']);

                                    echo "<td>{$age}</td>";
                                    //TODO: zip is being added to the view
                                    echo "<td>{$row['zipcode']}</td>";
                                    echo "<td>{$row['numchildren']}</td>";
                                    echo "<td>";
                                        echo "<div class=\"form-group\">";
                                            echo "<div class=\"col-10\">";
                                                echo "<textarea class=\"form-control\" type=\"textarea\" rows=\"2\" value=\"\" id=\"example-text-input\" placeholder=\"enter comments here...\"></textarea>";
                                            echo "</div>";
                                        echo "</div>";
                                        echo "</td>";
                                    echo "<td>";
                                        echo "<a href=\"#\">Edit</a>";
                                    echo "</td>";
                                echo "</tr>";
                                }
                                    ?>
                                </tbody>
                            </table>
                            <!-- /Table -->
                        </div>
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

                            <form class="search-agency" target="_blank">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="searchquery" placeholder="Begin typing participant's name...">
                                </div>
                                <button type="button" class="btn cpca form-control">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" role="tab" id="headingTwo">
                        <h5 class="mb-0">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                New Person In System
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
                                    <input class="form-control" type="text" value="" id="new-person-first" placeholder="enter first name...">
                                </div>
                            </div>
                            <!-- middle initial -->
                            <div class="form-group row">
                                <label for="new-person-middle" class="col-3 col-form-label">Middle Initial</label>
                                <div class="col-9">
                                    <input class="form-control" type="text" value="" id="new-person-middle" placeholder="enter middle initial...">
                                </div>
                            </div>
                            <!-- last -->
                            <div class="form-group row">
                                <label for="new-person-last" class="col-3 col-form-label">Last <div style="color:red; display:inline">*</div></label>
                                <div class="col-9">
                                    <input class="form-control" type="text" value="" id="new-person-last" placeholder="enter last name...">
                                </div>
                            </div>
                            <!-- race
                            TODO: dynamically get races
                            -->
                            <div class="form-group row">
                                <label for="race-select" class="col-3 col-form-label">Race <div style="color:red; display:inline">*</div></label>
                                    <div class="col-9">
                                    <select id="race-select" class="form-control">
                                        <option>Select Race...</option>
                                        <?php
                                        while($row = pg_fetch_assoc($get_races)){
                                            echo "<option>{$row['unnest']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Age -->
                            <div class="form-group row">
                                <label for="age-input" class="col-3 col-form-label">Age <div style="color:red; display:inline">*</div></label>
                                <div class="col-9">
                                    <input class="form-control" type="number" value="" id="age-input" placeholder="please enter age...">
                                </div>
                            </div>
                            <!-- Number of children under 18 -->
                            <div class="form-group row">
                                <label for="num-children-input" class="col-3 col-form-label">Number of children under 18 <div style="color:red; display:inline">*</div></label>
                                <div class="col-9">
                                    <input class="form-control" type="number" value="" id="num-children-input" placeholder="please enter number of children...">
                                </div>
                            </div>
                            <!-- Zip code -->
                            <fieldset disabled>
                                <div class="form-group row">
                                    <label for="zip-input" class="col-3 col-form-label">Zip code</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="12601" id="zip-input" placeholder="enter zip code...">
                                    </div>
                                </div>
                            </fieldset>

                            <!-- validate and add to list above -->
                            <div class = "row">
                                <button type="button" class="btn btn-primary" style="margin-left:15px" onclick="addPersonToTable()">Add Person</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br/>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-success">Submit Attendance</button>
            </div>
        </div>
        </form>
    </div>


<?php
include('footer.php');
?>