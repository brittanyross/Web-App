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

//make sure that information was entered into form
if(!isset($_POST['curr']))
{
    echo "<div class='container'>";
    echo "<p>Error: Please first pick a class to take attendance for.</p>";
    echo "<p><a href='new-class'>Class Selection Link</a></p>";
    echo "</div>";
    include('footer.php');
    die;
}

$selected_class = $_POST['classes'];
$selected_curr = $_POST['curr'];
$selected_date = $_POST['date-input'];
$selected_time = $_POST['time-input'];



$convert_date = DateTime::createFromFormat('Y-m-d', $selected_date);
$display_date = $convert_date->format('l, F jS');

$convert_time = DateTime::createFromFormat('H:i:00', $selected_time);
$display_time = $convert_time->format('g:i A');

?>

    <div class="container-fluid">
        <div class="row flex-column">
            <!-- Default container contents -->
            <div class="h3 text-center">
                <?php
                    echo "{$selected_curr} : {$selected_class}";
                ?>
            </div>
            <div class="h6 text-center">
                <?php
                    echo "Class Time: {$display_time} - {$display_date}";
                ?>
            </div>

            <form action ="attendance-form-confirmation" method="post">
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
                                    <td>
                                        <a href="#">Edit</a>
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

            <br/>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-success">Submit Attendance</button>
            </div>
        </div>
        </form>

        <div class="row">
            <div class="jumbotron" style="max-width: 700px; width: 100%; margin: 10px auto" >
                <h4 class="secondary-title">Search for Participants</h4>
                <br />
                <form class="search-agency" method="POST" action="/agency-requests">
                    <div class="form-group">
                        <input type="text" class="form-control" name="searchquery" placeholder="Begin typing participant's name...">
                    </div>
                    <button type="submit" class="btn cpca form-control">Submit</button>
                </form>
            </div>
        </div>
    </div>


<?php
include('footer.php');
?>