<?php

authorizedPage();

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

//make sure that information was entered into form
if(isset($_POST['curr'])) $selected_curr = $_POST['curr'];
else
{
    echo "<div class='container'>";
    echo "<p>Error: Please first pick a class to take attendance for.</p>";
    echo "<p><a href='new-class'>Class Selection Link</a></p>";
    echo "</div>";
    include('footer.php');
    die;
}


$selected_class = $_POST['classes'];

?>

    <div class="container-fluid">
        <div class="row flex-column">
            <!-- Default container contents -->
            <div class="h2 text-center">
                <?php
                    echo "{$selected_class}: Class Roster";
                ?>
            </div>

            <div class="card">
                <div class="card-block">
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr class="m-0">
                                    <th class="w-25">Present</th>
                                    <th class="w-50">Name</th>
                                    <th class="w-25"></th>
                                </tr>
                            </thead>
                            <tbody>


                            <tr class="m-0">
                                <td class="w-25"">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input">
                                        <span class="custom-control-indicator"></span>
                                    </label>
                                </td>
                                <td class="w-50"">Jimmy Neutron</td>
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

        <div class="row flex-column">
            <div class="d-flex justify-content-start">
                <button type="button" class="btn btn-default" style="margin-top: 15px">New Attendee</button>
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
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                            </label>
                                        </td>
                                        <td class="w-50">Shaquille O'Neal</td>
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