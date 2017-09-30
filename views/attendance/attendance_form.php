<?php

authorizedPage();

include('header.php');

?>

    <div class="container col-12">
            <!-- Default container contents -->
            <div class="h2 text-center">Stop the Beatdown: Class Roster</div>

        <div class="card">
            <div class="card-block">
                <!-- Table -->
                <div class="table">
                    <table class="table-responsive table-hover table-striped">
                        <colgroup>
                            <col class="col-2">
                            <col class="col-8">
                            <col class="col-2">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Present</th>
                                <th>Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        //TODO: pull info from DB
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-inline" aria-label="present">
                            </td>
                            <td>Jimmy Neutron</td>
                            <td>
                                <a href="#">More Details...</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!-- /Table -->
                </div>
            </div>
        </div>


        <div class="row col-12">
            <div class="col-9"></div>
            <button type="button" class="btn btn-default col-3">New attendee</button>
        </div>

        <div class="panel-group col-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapse1">Other Attendees</a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse">
                    <!-- Table -->
                    <table class="table row table-hover table-bordered table-striped">
                        <colgroup>
                            <col class="col-2">
                            <col class="col-8">
                            <col class="col-2">
                        </colgroup>
                        <tbody>
                        <tr>
                            <th>Present</th>
                            <th>Name</th>
                            <th></th>
                        </tr>
                        <?php
                        #TODO: pull info from DB

                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-inline" aria-label="present">
                            </td>
                            <td>Shaquille O'Neil</td>
                            <td>
                                <a href="#">More Details...</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
include('footer.php');
?>