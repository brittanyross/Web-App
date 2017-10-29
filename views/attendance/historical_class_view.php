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

$query = "select firstname fn, middleinit mi, lastname ln, numchildren nc, comments c, participantid pid " .
        "from classattendancedetails " .
        "where topicname = '" . escape_apostrophe($class_topic) ."' " .
        "and sitename = '" . escape_apostrophe($site_name) ."' " .
        "and date = '{$class_date}';";

$result = $db->no_param_query($query);



?>

    <div class="container-fluid">
        <div class="row flex-column">
            <!-- Default container contents -->
            <div class="h3 text-center">

            </div>

            <form action ="record-attendance" method="post">
                <div class="card">
                    <div class="card-block">
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
                                            echo "<td></td>";

                                    }

                                ?>

                                <tr class="m-0">
                                    <td>Jimmy Neutron</td>
                                    <td>25</td>
                                    <td>12601</td>
                                    <td>8</td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- /Table -->
                        </div>
                    </div>
                </div>
        </div>

        <div class="row flex-column">
            <div class="d-flex justify-content-start">
                <button type="button" class="btn btn-danger" style="margin-top: 15px">Edit</button>
            </div>

            <br/>
            <div class="d-flex justify-content-start">
                <button type="button" class="btn btn-success">Confirm</button>
            </div>
        </div>
        </form>

    </div>

<?php
include('footer.php');
?>