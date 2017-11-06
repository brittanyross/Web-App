z<?php

authorizedPage();

global $db;

require("attendance_utilities.php");

include('header.php');

//TODO: make query dynamic so that it changes based on which user is logged in
$_SESSION['employeeid'] = 1;
$peopleid = $_SESSION['employeeid'];

$classN = null;
$queryClassList = null;
$whatPageWeCameFrom = null;

//check to see where the post came from
if(isset ($_POST["whichButton"])) {
    $whatPageWeCameFrom = "dashboard";
    $classN = $_POST["whichButton"];
    echo "<h1>{$classN}</h1>";
    $queryClassList  = "select fca.topicname, fca.date, co.sitename " .
        "from facilitatorclassattendance fca, classoffering co " .
        "where fca.topicname = co.topicname " .
        "and fca.sitename = co.sitename " .
        "and fca.date = co.date " .
        "and fca.facilitatorid = {$peopleid} " .
        "order by fca.date desc " .
        "limit 20; ";
}
else if(isset($_POST["whichButtonHistoricalSearch"])){
    $whatPageWeCameFrom = "historicalLookup";
    $classN = $_POST["whichButtonHistoricalSearch"];
    $classListDate = $_POST["input-date"];
    $queryClassList = "select fca.topicname, fca.date, co.sitename " .
        "from facilitatorclassattendance fca, classoffering co, curricula cu, " .
        "facilitators fac, employees emp, people peop " .
        "where fca.topicname = co.topicname " .
        "and fca.sitename = co.sitename " .
        "and fca.date = co.date " .
        "and co.curriculumid = cu.curriculumid " .
        "and fca.facilitatorid = fac.facilitatorid " .
        "and fac.facilitatorid = emp.employeeid " .
        "and emp.employeeid = peop.peopleid " .
        "and to_char(co.date, 'YYYY-MM-DD') = '{$classListDate}';";
}
else{ //shouldn't be here
    die;
}




//grab the specific class we clicked
$resultClassInfo = $db->no_param_query($queryClassList);

//loop through to desired result
for($i = 0; $i < $classN; $i++){
    pg_fetch_assoc($resultClassInfo);
}
$row = pg_fetch_assoc($resultClassInfo); //actual row we want

$class_topic = $row['topicname'];
$site_name = $row['sitename'];
$class_date = $row['date'];
$displayDate = formatSQLDate($class_date);

$queryClassInformation = "select firstname fn, middleinit mi, lastname ln, numchildren nc, comments c, participantid pid " .
        "from classattendancedetails " .
        "where topicname = '" . escape_apostrophe($class_topic) ."' " .
        "and sitename = '" . escape_apostrophe($site_name) ."' " .
        "and date = '{$class_date}' " .
        "order by ln asc;";

$result = $db->no_param_query($queryClassInformation);




?>

    <div class="container-fluid">
        <div class="row flex-column">
            <!-- Default container contents -->
            <div class="h3 text-center">

            </div>

            <div class="card">
                <div class="card-block">
                    <h4 class="card-title" style="margin-top: 10px; margin-left: 10px; text-align: center;">Attendance: <?php echo $displayDate; ?> </h4>
                    <h6 style="text-align: center;"><?php echo $site_name . " : " . $class_topic?></h6>
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Number of children under 18</th>
                                <th>Comments</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                                while($row = pg_fetch_assoc($result)) {
                                    echo "<tr class=\"m-0\">";
                                        echo "<td>{$row['fn']} {$row['mi']} {$row['ln']}</td>";
                                        echo "<td>{$row['nc']}</td>";
                                        echo "<td>{$row['c']}</td>";
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

        <div class="row flex-column" style="margin-top: 10px">
            <?php
            //back to previous page depends on whether or not came from historical class lookup or dashboard
            if($whatPageWeCameFrom == "dashboard"){
                echo "<button type=\"button\" class=\"btn btn-primary\" onclick=\"location.href = '/record-attendance'\">Back To Dashboard</button>";
            } else { //historicalLookup
                echo "<button type=\"button\" class=\"btn btn-primary\" onclick=\"location.href = '/record-attendance'\">Back To Dashboard</button>";
                echo "<button type=\"button\" class=\"btn btn-secondary\" onclick=\"location.href = '/historical-class-search'\" style='margin-top: 10px;'>Search New Day</button>";
            }
            ?>
        </div>


    </div>

<?php
include('footer.php');
?>