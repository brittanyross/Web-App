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

$convert_time = DateTime::createFromFormat('H:i', $selected_time);
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

            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                        <h5 class="mb-0">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Search for Person
                            </a>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-block" style="padding: 10px;">
                            <p>
                                If a person is not shown here but has already filled out the intake packet,
                                please search for them here.
                            </p>

                            <form class="search-agency" target="_blank">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="searchquery" placeholder="Begin typing participant's name...">
                                </div>
                                <button type="button" class="btn cpca form-control">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" role="tab" id="headingTwo">
                        <h5 class="mb-0">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                New Person In System
                            </a>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="card-block" style="padding: 10px">
                            <!-- first -->
                            <div class="form-group row">
                                <label for="new-person-first" class="col-2 col-form-label">First</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" value="" id="new-person-first" placeholder="enter first name...">
                                </div>
                            </div>
                            <!-- middle initial -->
                            <div class="form-group row">
                                <label for="new-person-middle" class="col-2 col-form-label">Middle Initial</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" value="" id="new-person-middle">
                                </div>
                            </div>
                            <!-- last -->
                            <div class="form-group row">
                                <label for="new-person-last" class="col-2 col-form-label">Last</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" value="" id="new-person-last" placeholder="enter last name...">
                                </div>
                            </div>
                            <!-- race
                            TODO: dynamically get races
                            -->
                            <div class="form-group row">
                                <label for="race-select" class="col-2 col-form-label">Race</label>
                                    <div class="col-10">
                                    <select id="race-select" class="form-control">
                                        <option>Select Race...</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Age -->
                            <div class="form-group row">
                                <label for="age-input" class="col-2 col-form-label">Age</label>
                                <div class="col-10">
                                    <input class="form-control" type="number" value="0" id="age-input">
                                </div>
                            </div>
                            <!-- Number of children under 18 -->
                            <div class="form-group row">
                                <label for="num-children-input" class="col-2 col-form-label">Number of children under 18</label>
                                <div class="col-10">
                                    <input class="form-control" type="number" value="" id="num-children-input">
                                </div>
                            </div>
                            <!-- Zip code -->
                            <div class="form-group row">
                                <label for="zip-input" class="col-2 col-form-label">Zip code</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" value="" id="zip-input" placeholder="enter zip code...">
                                </div>
                            </div>

                            <!-- validate and add to list above -->
                            <div class = "row">
                                <button type="button" class="btn btn-primary" style="margin-left:15px">Add Person</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br/>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-success">Submit Attendance</button>
            </div>
        </div>
        </form>
    </div>


<?php
include('footer.php');
?>