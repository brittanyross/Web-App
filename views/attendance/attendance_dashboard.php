<?php

authorizedPage();

global $db;
include('header.php');


//TODO: make query dynamic so that it changes based on which user is logged in
$peopleid = 1;

//TODO: add option to edit last class' attendance
$result = $db->no_param_query("select fca.topicname, fca.date, co.sitename " .
"from facilitatorclassattendance fca, classoffering co " .
"where fca.topicname = co.topicname " .
"and fca.sitename = co.sitename " .
"and fca.date = co.date " .
"and fca.facilitatorid = {$peopleid} " .
"order by fca.date desc " .
"limit 20; ");


?>

    <script src="/js/attendance-scripts/historical-class-view.js"></script>

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
                        <form action = "historical-class-view" method="post" name="classView">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Class</th>
                                        <th>Site Name</th>
                                        <th>Date/Time</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $counter = 0;
                                    while($row = pg_fetch_assoc($result)) {
                                        echo "<tr>";
                                            echo "<td>{$row['topicname']}</td>";
                                            echo "<td>{$row['sitename']}</td>";
                                            //you guessed it, right off of stack overflow
                                            $time = strtotime($row['date']);
                                            $myFormatDate = date("m/d/y", $time);
                                            $myFormatTime = date("h:i A", $time);
                                            echo "<td>{$myFormatDate} <em>{$myFormatTime}</em></td>";
                                            //echo "<td><a href=\"#\" type=\"submit\" name=\"action\" value="{$counter}">More details...</a> </td>";
                                            echo "<td><button href=\"#\" class=\"btn btn-link\" type=\"submit\" onclick=\"changeHiddenFormFieldValue({$counter})\">More details...</button></td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                ?>
                                </tbody>
                            </table>

                            <!-- The hidden field -->
                            <input type="hidden" id="whichButton" name="whichButton" value="" />
                        </form>
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