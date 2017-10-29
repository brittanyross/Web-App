<?php

authorizedPage();

global $db;

require("attendance_utilities.php");

include('header.php');

//TODO: make query dynamic so that it changes based on which user is logged in
$peopleid = 1;
//TODO make dynamic
$class_topic = 'How to be a good parent';
$site_name = 'Dutchess County Jail';
$class_date = '2017-09-23 05:22:21.649491';
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
                    <h4>Attendance: <?php echo $displayDate; ?> </h4>
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


    </div>

<?php
include('footer.php');
?>