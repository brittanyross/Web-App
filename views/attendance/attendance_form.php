<?php

authorizedPage();

include('header.php');

?>

    <div class="container-fluid">
        <div class="row flex-column">
            <!-- Default container contents -->
            <div class="h2 text-center">Stop the Beatdown: Class Roster</div>

            <div class="card">
                <div class="card-block">
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr class="m-0">
                                    <th class="w-10">Present</th>
                                    <th class="w-65">Name</th>
                                    <th class="w-25"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            //TODO: pull info from DB
                            ?>
                            <tr class="m-0">
                                <td class="w-25">
                                    <input type="checkbox" aria-label="present">
                                </td>
                                <td class="w-50">Jimmy Neutron</td>
                                <td class="w-25">
                                    <a href="#">More Details...</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- /Table -->
                    </div>
                </div>
            </div>
        </div>


        <div class="row flex-column" style = "margin-top: 15px;">
            <div>
                <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                        <h5 class="mb-0">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Other Attendees
                            </a>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-block">
                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                    <tr class="m-0">
                                        <th class="w-10">Present</th>
                                        <th class="w-65">Name</th>
                                        <th class="w-25"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //TODO: pull info from DB
                                    ?>
                                    <tr class="m-0">
                                        <td class="w-25">
                                            <input type="checkbox" aria-label="present">
                                        </td>
                                        <td class="w-50">Jimmy Neutron</td>
                                        <td class="w-25">
                                            <a href="#">More Details...</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!-- /Table -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


<?php
include('footer.php');
?>