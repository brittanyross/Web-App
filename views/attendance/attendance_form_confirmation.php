<?php

authorizedPage();

$_SESSION['employeeid'] = 1;

require ('attendance_utilities.php');

//update class information from previous form
updateSessionClassInformation();

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