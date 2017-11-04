<?php

authorizedPage();

global $db;

//unset previous class session information
if(isset($_SESSION['serializedInfo'])) {
    unset($_SESSION['serializedInfo']);
}

$result_curriculum = $db->no_param_query("SELECT c.curriculumid, c.curriculumname FROM curricula c ORDER BY c.curriculumname ASC;");

$result_classes = $db->no_param_query("SELECT cc.curriculumid, cc.topicname from curriculumclasses cc ORDER BY cc.curriculumid;");

$result_sites = $db->no_param_query("select s.sitename from sites s;");

$result_languages = $db->no_param_query("select * from languages;");

include('header.php');


echo "<script>console.log(" . date('d-m-Y') . ")</script>"

?>

<script>
    //js for holding all the class choices
    var classesMatrix = [
        <?php
            while($row = pg_fetch_assoc($result_classes)){
                echo "[{$row['curriculumid']},\"{$row['topicname']}\"],";
            }
        ?>
        ];

    //js for controlling the disabled selection of class section
    function enableSecondSelection() {

        //disable submit button in case first class was changed
        document.getElementById("sub").disabled = true;

        //enable selection
        document.getElementById("classSelection").disabled = false;

        /* Display the proper classes */

        //clear the current class selection
        var classesElement = document.getElementById("classes");

        while(classesElement.firstChild){
            classesElement.removeChild(classesElement.firstChild);
        }

        //get current input of curriculum
        var curriculumNumberSelected;
        var currElement = document.getElementById("curr"); //curriculum element
        var optionSelected = currElement.value; //string
        for(var i = 1; i < currElement.length; i++){ //loop through children
            if(currElement[i].value === optionSelected) {
                curriculumNumberSelected = currElement[i].id; //id of class (aka class num)
                break;
            }
        }




        //add new options

        var node = document.createElement("OPTION");
        node.selected = true;
        node.disabled = true;
        node.innerHTML = "Select Class";
        classesElement.appendChild(node);

        console.log(classesMatrix.length);
        for(var i = 0; i < classesMatrix.length; i++){
            if(classesMatrix[i][0].toString() === curriculumNumberSelected){ //same course number
                console.log("got here");
                var classNode = document.createElement("OPTION");
                classNode.innerHTML = classesMatrix[i][1];
                classesElement.appendChild(classNode);
            }
        }

    }
    
    function enableSubmitButton() {
        document.getElementById("sub").disabled = false;
    }

</script>
    <div class="container">

        <div class="card">
            <div class="card-block p-2">
                <h4 class="card-title">Class Information</h4>
                <h6 class="card-subtitle mb-2 text-muted">What class would you like to take attendance for?</h6>

                <form action="attendance-form" method="post">
                    <div class="form-group">
                        <label for="curr">Curriculum</label>
                        <select id="curr" class="form-control" onchange="enableSecondSelection()" name="curr">
                            <option disabled selected="selected" name="classList">Select Curriculum</option>
                            <?php
                                while($row = pg_fetch_assoc($result_curriculum)){
                                    echo "<option id='{$row['curriculumid']}'>{$row['curriculumname']}</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <fieldset disabled="disabled" id="classSelection" >
                        <div class="form-group">
                            <label for="classes">Class Selection</label>
                            <select id="classes" class="form-control" name="classes" onchange="enableSubmitButton()">
                                <option></option>
                            </select>
                        </div>
                    </fieldset>

                    <div class="form-group">
                        <label for="site">Site Selection</label>
                        <select id="site" class="form-control" name="site" onchange="">
                            <?php
                            while($row = pg_fetch_assoc($result_sites)){
                                echo "<option>{$row['sitename']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="language">Language Selection</label>
                        <select id="language" class="form-control" name="lang" onchange="">
                            <?php
                            while($row = pg_fetch_assoc($result_languages)){
                                echo "<option>{$row['lang']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="date-input" class="col-2 col-form-label">Date</label>
                        <div class="col-10">
                            <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="date-input" name = "date-input">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="time-input" class="col-2 col-form-label">Time</label>
                        <div class="col-10">
                            <input class="form-control" type="time" value="<?php echo date('H:i') ?>" id="time-input" name = "time-input">
                        </div>
                    </div>

                    <fieldset disabled="disabled" id="sub">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
<?php
include('footer.php');
?>