<?php

authorizedPage();

$_SESSION['employeeid'] = 5;

//generic db script copied and pasted
/*
global $db, $params;
$peopleid = $params[0];

$result = $db->query("SELECT participants.participantid, participants.dateofbirth, participants.race, people.firstname, people.lastname, people.middleinit " .
    "FROM participants " .
    "INNER JOIN people ON participants.participantid = people.peopleid WHERE people.peopleid=$1", [$peopleid]);

$participant = pg_fetch_assoc($result);

*/

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
                                <table class="table table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>Present</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Zip</th>
                                        <th>Number of children under 18</th>
                                        <th></th>
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