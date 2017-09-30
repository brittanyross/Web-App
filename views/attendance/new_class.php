<?php

authorizedPage();

global $db;

$result_curriculum = $db->no_param_query("SELECT c.curriculumid, c.curriculumname FROM curricula c ORDER BY c.curriculumname ASC;");

include('header.php');

?>

    <div class="container">
        <!--
            cirriculum dropdown
            class dropdown
            next page
        -->

        <div class="card">
            <div class="card-block p-2">
                <h4 class="card-title">Class Information</h4>
                <h6 class="card-subtitle mb-2 text-muted">What class would you like to take attendance for?</h6>

                <form>
                    <div class="form-group">
                        <label for="disabledSelect">Curriculum</label>
                        <select id="disabledSelect" class="form-control">
                            <option>Select Curriculum</option>
                            <?php
                                while($row = pg_fetch_assoc($result_curriculum)){
                                    echo "<option id='{$row['curriculumid']}'>{$row['curriculumname']}</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <fieldset disabled>
                        <div class="form-group">
                            <label for="disabledSelect">Class Selection</label>
                            <select id="disabledSelect" class="form-control">
                                <option></option>
                            </select>
                        </div>
                    </fieldset>

                    <fieldset disabled>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
<?php
include('footer.php');
?>