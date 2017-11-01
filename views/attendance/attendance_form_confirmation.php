<?php

authorizedPage();

$_SESSION['employeeid'] = 1;

require ('attendance_utilities.php');

include('header.php');

$selected_class = $_POST['classes'];
$selected_curr = $_POST['curr'];
$selected_date = $_POST['date-input'];
$selected_time = $_POST['time-input'];

$employee_id = $_SESSION['employeeid'];

$pageInformation = null;

//if we have previous information passed to us from lookup form or add person form,
//  then display this information instead of db information
if(isset($_SESSION['serializedInfo'])) {
    //update class information from previous form
    updateSessionClassInformation();
    $pageInformation = deserializeParticipantMatrix($_SESSION['serializedInfo']);
} else { //you shouldn't be here
    die; //quick and painful
}

$convert_date = DateTime::createFromFormat('Y-m-d', $selected_date);
$display_date = $convert_date->format('l, F jS');

$convert_time = DateTime::createFromFormat('H:i', $selected_time);
$display_time = $convert_time->format('g:i A');

?>

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

        <div class="card">
            <div class="card-block">
                <form action="" method="post" id="attendance-sheet">
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
                            </tr>
                            </thead>
                            <tbody>


                            <tr class="m-0">
                                <?php
                                for($i = 0; $i < count($pageInformation); $i++) {
                                    $tf = $pageInformation[$i]['present'] ? "true" : "false";

                                    //field names - unique field names for individuals which are checked upon post
                                    $presentName =      (string) $i . "-" . "check";
                                    $commentName =      (string) $i . "-" . "comment";

                                    echo "<tr class=\"m-0\" id=\"{$i}\">";
                                    echo "<td>";
                                    echo "<label class=\"custom-control custom-checkbox\">";
                                    echo "<fieldset disabled>"; //disable checkbox
                                    //checkbox checked option
                                    $checked = null;
                                    $tf ? $checked = "checked=\"checked\"" : $checked = "";
                                    echo "<input type=\"checkbox\" class=\"custom-control-input\" {$checked} name='{$presentName}'>";
                                    echo "<span class=\"custom-control-indicator\"></span>";
                                    echo "</fieldset>";
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
                                    echo "<fieldset disabled>"; //disable comments
                                    //pre-fill comment if exists
                                    $comment = null;
                                    $placeholder = null; //disable placeholder
                                    (is_null($pageInformation[$i]['comments'])) ? $comment = "" : $comment = $pageInformation[$i]['comments'];
                                    (is_null($pageInformation[$i]['comments'])) ? $placeholder = "" : $placeholder = "placeholder=\"enter comments here...\"";
                                    echo "<textarea class=\"form-control\" type=\"textarea\" rows=\"2\" {$placeholder} name='{$commentName}'>{$comment}</textarea>";
                                    echo "</fieldset>";
                                    echo "</div>";
                                    echo "</div>";
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

                    //edit button information
                    echo "<input type=\"hidden\" id=\"editButton\" name=\"editButton\" value=\"\" />";
                    ?>
                </form>

            </div>
        </div>
        <div class="row flex-column">
            <div class="d-flex">
                <div class="justify-content-between">
                    <button type="button" class="btn btn-danger d-flex justify-content-start">Edit Attendance</button>
                </div>
                <div class="justify-content-between">
                    <button type="button" class="btn btn-success d-flex justify-content-end">Submit Attendance</button>
                </div>
            </div>
        </div>

    </div>
    </div>


<?php
include('footer.php');
?>