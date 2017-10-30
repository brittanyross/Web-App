z<?php

authorizedPage();

global $db;

require("attendance_utilities.php");

include('header.php');

//what result number was the post
$classN = $_POST["whichButton"];

//TODO: make query dynamic so that it changes based on which user is logged in
$peopleid = 1;

//grab the specific class we clicked
$resultClassInfo = $db->no_param_query("select fca.topicname, fca.date, co.sitename " .
    "from facilitatorclassattendance fca, classoffering co " .
    "where fca.topicname = co.topicname " .
    "and fca.sitename = co.sitename " .
    "and fca.date = co.date " .
    "and fca.facilitatorid = {$peopleid} " .
    "order by fca.date desc " .
    "limit 20; ");

//loop through to desired result
for($i = 0; $i < $classN; $i++){
    pg_fetch_assoc($resultClassInfo);
}
$row = pg_fetch_assoc($resultClassInfo); //actual row we want

$class_topic = $row['topicname'];
$site_name = $row['sitename'];
$class_date = $row['date'];
$displayDate = formatSQLDate($class_date);

$query = "select firstname fn, middleinit mi, lastname ln, numchildren nc, comments c, participantid pid " .
        "from classattendancedetails " .
        "where topicname = '" . escape_apostrophe($class_topic) ."' " .
        "and sitename = '" . escape_apostrophe($site_name) ."' " .
        "and date = '{$class_date}' " .
        "order by ln asc;";

$result = $db->no_param_query($query);





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
            <button type="button" class="btn btn-primary" onclick="location.href = '/record-attendance'">Back to previous page</button>
        </div>


    </div>

<?php
include('footer.php');
?>