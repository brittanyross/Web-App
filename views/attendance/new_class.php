<?php

authorizedPage();

global $db;

$result_curriculum = $db->no_param_query("SELECT c.curriculumid, c.curriculumname FROM curricula c ORDER BY c.curriculumname ASC;");

$result_classes = $db->no_param_query("SELECT cc.curriculumid, cc.topicname from curriculumclasses cc ORDER BY cc.curriculumid;");

include('header.php');

?>

<script>
    //js for holding all the class choices
    var classesMatrix = [
        <?php
            while($row = pg_fetch_assoc($result_curriculum)){
                echo "[{$row['curriculumid']},{$row['topicname']}],";
            }
        ?>
        ];

</script>

<script>
    //js for controlling the disabled selection of class section
    function enableSecondSelection() {

        //enable selection
        document.getElementById("classSelection").disabled = false;

        /* Display the proper classes */

        //clear the current selection
        
        //get current input of curriculum

        //add new options

    }
    
    function enableSumbmitButton() {
        
    }
</script>
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
                        <select id="disabledSelect" class="form-control" onchange="enableSecondSelection()">
                            <option disabled selected="selected" name="classList">Select Curriculum</option>
                            <?php
                                while($row = pg_fetch_assoc($result_curriculum)){
                                    echo "<option id='{$row['curriculumid']}'>{$row['curriculumname']}</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <fieldset disabled="disabled" id="classSelection">
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