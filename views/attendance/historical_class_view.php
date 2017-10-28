<?php

authorizedPage();

global $db;
require("attendance_utilities.php");

//TODO: make query dynamic so that it changes based on which user is logged in
$peopleid = 1;
//TODO make dynamic
$class_topic = 'How to be a good parent';
$site_name = 'Dutchess County Jail';
$class_date = '2017-09-23 05:22:21.649491';

//TODO: add ' for classtopic and location as it may interfere with some queries
$result = $db->no_param_query(
        "select participantfirstname pfn, participantmiddleinit pmi, participantlastname pln, numchildren nc, comments c" .
        "from classattendancedetails" .
        "where classtopic = '" . escape_apostrophe($class_topic) ."'" .
        "and sitename = '" . escape_apostrophe($site_name) ."'" .
        "and classdate = '{$class_date}';"
);

include('header.php');

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


                                <tr class="m-0">
                                    <td>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input">
                                            <span class="custom-control-indicator"></span>
                                        </label>
                                    </td>
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