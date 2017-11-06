<?php

//some curricula and other parts of the have apostrophe's
// in their name that need to be escaped when using it for a query
function escape_apostrophe($input){
    return str_replace("'","''", $input);
}

//input: a specified time in the formats ('x days', or 'y years')
//output: formatted date for sql subtracted day from now
function date_subtraction($sub_this_time){
    //date subtraction for view
    $today = new DateTime('now');
    $sub_date = $today->sub(DateInterval::createFromDateString($sub_this_time));
    return $sub_date->format('Y-m-d');
}

//input: raw sql date right from the DB in mm-dd-yyyy format
//output: age of person born on that date
function calculate_age($raw_sqlDate) {
    //stack overflow next level stuff
    //explode the date to get month, day and year
    $birthDate = explode("-", $raw_sqlDate);
    //reformat to fit the mm-dd-yyyy format
    $birthDateFormatted = array($birthDate[1], $birthDate[2], $birthDate[0]);
    //get age from date or birthdate
    $age = (date("md", date("U", mktime(0, 0, 0, $birthDateFormatted[0], $birthDateFormatted[1], $birthDateFormatted[2]))) > date("md")
        ? ((date("Y") - $birthDateFormatted[2]) - 1)
        : (date("Y") - $birthDateFormatted[2]));

    return $age;
}

//input: ray sql timestamp
//output: nicely formatted date and time
function formatSQLDate($sqlDate) {
    //for some reason, if a timestamp is H:i:s.000000, fetching the row drops the microseconds.
    //  this is a workaround
    $sqlDateString = (string) $sqlDate;
    if(strpos($sqlDateString, '.') == false) {
        //period not found, must add
        $sqlDateString .= ".000000";
    }

    $convertDate = DateTime::createFromFormat('Y-m-d H:i:s.u', $sqlDateString);
    $formattedDate = $convertDate->format('l, F jS g:i A');

    return $formattedDate;
}

//input: date in 'Y-m-d' and time in 'H:i'
//output: sql timestamp 'Y-m-d H:i:00.000000'
//description: create timestamp from specific date format
function makeTimestamp($inputDate, $inputTime){
    $convertDate = DateTime::createFromFormat('Y-m-d H:i', (string)$inputDate . " " . $inputTime);
    //the one preserves the milliseconds for the function formatSQLDate(timestamp) to work properly
    $timestamp = $convertDate->format('Y-m-d H:i:00.000000');
    return $timestamp;
}


function serializeParticipantMatrix($matrix) {
    return base64_encode(serialize($matrix));
}

function deserializeParticipantMatrix($encodedMatrix) {
    return unserialize(base64_decode($encodedMatrix));
}

//input: class information matrix
//output: updated class information matrix
function handleAttendanceSheetInfo($classInformation){
    //get the post information and match it with people in the roster
    for($i = 0; $i < count($classInformation); $i++){
        //set the important intake fields (present, comment)
        //each row's post name is made up index and field name
        $classInformation[$i]['present'] = isset($_POST[((string)$i . "-check")]);
        $classInformation[$i]['comments'] = isset($_POST[((string)$i . "-comment")]) ? ($_POST[((string)$i . "-comment")]) : null ;
    }



    return $classInformation;
}

//input: none (from session variable)
//output: none (updates session info)
//description: deserializes session info, calls function to update,
//  reserializes and sets session variable
function updateSessionClassInformation(){
    //get serialized class information
    $serializedClassInfo = $_SESSION['serializedInfo'];
    //deserialize info
    $deserializeClassInfo = deserializeParticipantMatrix($serializedClassInfo);
    //update info with handle class attendance function
    $updatedInfo = handleAttendanceSheetInfo($deserializeClassInfo);
    //serialize this new information
    $updatedInfoSerialize = serializeParticipantMatrix($updatedInfo);
    //update the session info with this new value
    $_SESSION['serializedInfo'] = $updatedInfoSerialize;
}

//validation functions (occur after JS validation so
// if they're not valid, it's malicious or they aren't running JS

//input: first or last name
//output: (boolean)isValid
function validateName($name) {
    if(empty($name)){
        return false;
    } else{
        //returns true if matched, validates for a-z and A-Z
        return preg_match("/^[A-Za-z]+$/", $name);
    }
}

//input: middle initial
//output: true if empty or letter
function validateMiddle($middle) {
    if(empty($middle)){
        return true; //not required
    } else{
        //returns true if matched, validates for a-z and A-Z max one character
        return preg_match("/^[A-Za-z]$/", $middle);
    }
}

//input: race
//output: true if valid race
function validateRace($race) {
    if(empty($race)){
        return false;
    } else{
        $raceArray = $_SESSION['races'];
        return in_array($race, $raceArray);
    }
}

//input: age
//output: true if numeric and [18 to 100]
function validateAge($age) {
    if(empty($age)){
        return false;
    } else{
        //returns true if age in valid range 18-100
        return( is_numeric($age) && (($age >= 18) && ($age <= 100)));
    }
}

//input: number of children
//output: true if not empty, numeric, and [0 to 25]
function validateNumChildren($num) {
    if(empty($num)){
        return false;
    } else{
        //returns true if a valid number of children
        return(is_numeric($num) && (($num >= 0) && ($num <= 25)));
    }

}

//input: zip code
//output: true if valid 5 digit US zip
function validateZip($zip) {
    if(empty($zip)){
        return false;
    } else {
        //validate zip code (from stackoverflow)
        return preg_match("/(^\d{5}$)|(^\d{5}-\d{4}$)/", $zip);
    }
}
