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

//
function formatSQLDate($sqlDate) {
    $convert_date = DateTime::createFromFormat('Y-m-d H:i:s.u', $sqlDate);
    $formatted_date = $convert_date->format('l, F jS g:i A');

    return $formatted_date;
}