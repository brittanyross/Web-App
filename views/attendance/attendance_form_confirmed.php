<?php

authorizedPage();

global $db;
require ('attendance_utilities.php');
include('header.php');

$success = false;
//kill the page if we don't have any information
if(!isset($_SESSION['serializedInfo'])) {
    die(); //slow and painful
}

$selected_class = $_POST['classes'];
$selected_curr = $_POST['curr'];
$selected_date = $_POST['date-input'];
$selected_time = $_POST['time-input'];
$selected_site = $_POST['site'];
$selected_lang = $_POST['lang'];

//get the corresponding curriculumId from the curriculum name
$curr_result = $db->no_param_query("select cur.curriculumid id from curricula cur where cur.curriculumname = '"
    . escape_apostrophe($selected_curr) . "';");
$selected_curr_num = pg_fetch_result($curr_result, 'id');

$serializedInfo = $_SESSION['serializedInfo'];
$attendanceInfo = deserializeParticipantMatrix($serializedInfo);

//loop through and search for unregistered participants
for($i = 0; $i < count($attendanceInfo); $i++) {
    if($attendanceInfo[$i]['firstClass'] && $attendanceInfo[$i]['present']){ //first class ever and present
        //run function to insert them into the system
        $resultInsert = $db->no_param_query(
                "SELECT createOutOfHouseParticipant( ".
                "participantFirstName := '{$attendanceInfo[$i]['fn']}'::text, " .
                "participantMiddleInit := '{$attendanceInfo[$i]['mi']}'::varchar, " .
                "participantLastName := '{$attendanceInfo[$i]['ln']}'::text, " .
                "participantAge   := {$attendanceInfo[$i]['dob']}::int, " .
                "participantRace   := '{$attendanceInfo[$i]['race']}'::race, " .
                //TODO: change employeeID when DB sorts it out
                "employeeID := 1::int " .

                "array( 'PARTICIPANT_FIRST_NAME', " .
                "'PARTICIPANT_MIDDLE_INITIAL', " .
                "'PARTICIPANT_LAST_NAME', " .
                "PARTICIPANT_AGE, " .
                "'PARTICIPANT_RACE', " .
                "EMPLOYEE_ID " .
                "));"
        );
        //update row information with those values
        $personId = pg_fetch_result($resultInsert, '');
        $attendanceInfo[$i]['pid'] = $personId;
    }
}
//loop through attendanceInfo and insert records into the database

//create one classOffering entry
$db -> no_param_query(
        "SELECT createClassOffering( " .
        "offeringTopicName := '{$selected_class}'::text, " .
        "offeringTopicDate := '{$selected_date}'::timestamp, " .
        "offeringSiteName := '{$selected_site}'::text, " .
        "offeringLanguage := '{$selected_lang}'::text, " .
        "offeringCurriculumId := {$selected_curr_num}::int, " .

        "array( " .
        "'OFFERING_TOPIC_NAME', " .
        "'OFFERING_TOPIC_DATE', " .
        "'OFFERING_SITE_NAME', " .
        "'OFFERING_LANGUAGE', " .
        "OFFERING_CURRICULUM_ID " .
        "));"
);

//create one facilitatorClassAttendance entry
//TODO: waiting on db team
$db -> no_param_query(
    "SELECT createFacilitatorClassAttendance( " .
    "" .
    ""
);


//loop through participants and create many participantClassAttendance entries
for($i = 0; $i < count($attendanceInfo); $i++) {

}


?>

    <div class="container">

        <div class="card">
            <div class="card-block p-2">
                <?php
                if($success){
                    echo "<h4 class=\"card-title\" style=\"text-align: center;\"><i class=\"fa fa-thumbs-up\" aria-hidden=\"true\" style=\"color:green;\"></i> Success!</h4>";
                    echo "<h6 class=\"card-subtitle mb-2 text-muted\" style=\"text-align: center;\">Attendance Submitted Successfully. Good job!</h6>";
                } else{
                    echo "<h4 class=\"card-title\" style=\"text-align: center;\"><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\" style='color: red;'></i> Error</h4>";
                    echo "<h6 class=\"card-subtitle mb-2 text-muted\" style=\"text-align: center;\">There was an error inputting the form. Please " .
                        " try again or contact your system administrator</h6>";
                }

                //unset previous class session information
                if(isset($_SESSION['serializedInfo'])) {
                    unset($_SESSION['serializedInfo']);
                }
                ?>


            </div>
        </div>
    </div>
<?php
include('footer.php');
?>