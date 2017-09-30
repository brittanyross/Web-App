<?php

authorizedPage();

include('header.php');

?>

    <div class="container col-12">
        <div class="row col-12">
            <?php
                //TODO: fix button so that it uses proper php linking
                //TODO: fix float and panel without borders
            ?>

            <div class="panel panel-default">

                <div class="panel-heading float-left">My Recent Classes</div>

                <div class="panel-body">
                    <br/><br/>
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

                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li>
                            <a href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li>
                            <a href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>


            <button type="button" class="btn btn-default col-12" onclick="window.location.href='./attendance-form'">Record Attendance For New Class</button>
        </div>

    </div>
<?php
include('footer.php');
?>