<?php

//TODO: modify for custom facilitator selection
$_SESSION['employeeid'] = 1;
$selected_facilitator = $_SESSION['employeeid'];

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



$timestamp = makeTimestamp($selected_date, $selected_time);

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

        //this converts the age that was converted in attendance form so it can be converted again in the proc
        //WARNING: if, by some miracle it's this person's birthday and their age changes in the nanoseconds that this
        //  takes to run, then there may be an issue ¯\_(ツ)_/¯
        $age = calculate_age($attendanceInfo[$i]['dob']);

        $resultInsert = $db->no_param_query(
                "SELECT createOutOfHouseParticipant( ".
                "participantFirstName := '{$attendanceInfo[$i]['fn']}'::text, " .
                "participantMiddleInit := '{$attendanceInfo[$i]['mi']}'::varchar, " .
                "participantLastName := '{$attendanceInfo[$i]['ln']}'::text, " .
                "participantAge   := {$age}::int, " .
                "participantRace   := '{$attendanceInfo[$i]['race']}'::race, " .
                //TODO: change employeeID when DB sorts it out
                "employeeID := 1::int " .
                "); "
        );
        //update row information with those values
        $personId = pg_fetch_result($resultInsert, 'createOutOfHouseParticipant');
        $attendanceInfo[$i]['pid'] = $personId;
    }
}
//loop through attendanceInfo and insert records into the database

//create one classOffering entry
$db -> no_param_query(
        "SELECT createClassOffering( " .
        "offeringTopicName := '{$selected_class}'::text, " .
        "offeringTopicDescription := NULL::text, " .
        "offeringTopicDate := '{$timestamp}'::timestamp, " .
        "offeringSiteName := '{$selected_site}'::text, " .
        "offeringLanguage := '{$selected_lang}'::text, " .
        "offeringCurriculumId := {$selected_curr_num}::int) "
);

//create one facilitatorClassAttendance entry
$db -> no_param_query(
    "INSERT INTO facilitatorclassattendance( " .
    "topicName, date, siteName, facilitatorId ) " .
    "VALUES ('{$selected_class}', '{$timestamp}', '{$selected_site}', {$selected_facilitator});"
);


//loop through participants and create many participantClassAttendance entries
for($i = 0; $i < count($attendanceInfo); $i++) {

    if($attendanceInfo[$i]['present']) {
        $tfString = ($attendanceInfo[$i]['isNew'] ? "true" : "false");

        //adjust query to put default fields in for numChildren and zip if empty
        $numChildrenValue = $attendanceInfo[$i]['numChildren'];
        if(is_null($numChildrenValue)){
            $numChildrenValue = "0";
        }
        $zipCodeValue = $attendanceInfo[$i]['zip'];
        if(is_null($zipCodeValue)){
            $zipCodeValue = "12601";
        }

        $db->no_param_query(
            "INSERT INTO participantclassattendance( " .
            "topicname, " .
            "date, ".
            "participantId, " .
            "comments, ".
            "numChildren, ".
            "isNew, " .
            "zipCode, " .
            "siteName ".
            ") " .
            "VALUES(" .
            "'{$selected_class}', ".
            "'{$timestamp}', ".
            "{$attendanceInfo[$i]['pid']}, " .
            "'{$attendanceInfo[$i]['comments']}', " .
            " {$numChildrenValue}, " .
            "'{$tfString}',  ".
            "{$zipCodeValue}, " .
            "'{$selected_site}'" .
            "); "
        );
    }

}

$success = true;

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