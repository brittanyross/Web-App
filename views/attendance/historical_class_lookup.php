<?php

authorizedPage();

global $db;

include('header.php');

?>
    <div class="container">

        <div class="card">
            <div class="card-block p-2">
                <h4 class="card-title">Attendance Search</h4>
                <h6 class="card-subtitle mb-2 text-muted">What day would you like to view attendance for?</h6>

                <form action="historical-class-search-results" method="post">

                    <div class="form-group row">
                        <label for="date-input" class="col-2 col-form-label">Date</label>
                        <div class="col-10">
                            <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="date-input" name = "date-input">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
<?php
include('footer.php');
?>