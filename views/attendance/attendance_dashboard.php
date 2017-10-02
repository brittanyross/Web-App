<?php

authorizedPage();

global $db, $params;
$peopleid = $params[0];

//TODO: make query dynamic so that it changes based on which user is logged in
//TODO: add option to edit last class' attendance
$result = $db->query("select fca.topicname, fca.date " .
 "from facilitators f, facilitatorclassattendance fca, employees e " .
 "where e.employeeid = f.facilitatorid " .
 " and f.facilitatorid = fca.facilitatorid;", [$peopleid]);

$participant = pg_fetch_assoc($result);

include('header.php');

?>

    <div class="container col-12">
        <div class="row col-12">
            <?php
                //TODO: fix button so that it uses proper php linking
                //TODO: fix float and panel without borders
                //TODO: responsive page navigation
            ?>

            <div class="card col-12">

                <div class="card-block">

                    <h4 class="card-title" style="margin-top: 15px;">My Recent Classes</h4>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Stop the beat-down</td>
                                    <td>9/30/2017</td>
                                    <td><a href="#">More details...</a> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <nav aria-label="Previous classes">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>


            <button type="button" class="btn btn-default col-12" style="margin-top: 15px" onclick="window.location.href='./new-class'">Record Attendance For New Class</button>
        </div>

    </div>
<?php
include('footer.php');
?>