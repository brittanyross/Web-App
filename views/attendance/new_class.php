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
            console.log(currElement[i].value + " === " + optionSelected );
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
        <!--
            cirriculum dropdown
            class dropdown
            next page
        -->

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
                            <select id="classes" class="form-control" onchange="enableSubmitButton()" name="classes">
                                <option></option>
                            </select>
                        </div>
                    </fieldset>

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