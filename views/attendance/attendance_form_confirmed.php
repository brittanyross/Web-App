<?php

authorizedPage();

global $db;

//unset previous class session information
if(isset($_SESSION['serializedInfo'])) {
    unset($_SESSION['serializedInfo']);
}

$success = false;

//call the functions and stored procedures


include('header.php');


?>

    <div class="container">

        <div class="card">
            <div class="card-block p-2">
                <?php
                if($success){
                    echo "<h4 class=\"card-title\">Success!</h4>";
                    echo "<h6 class=\"card-subtitle mb-2 text-muted\">Good job!</h6>";
                } else{
                    echo "<h4 class=\"card-title\">Error</h4>";
                    echo "<h6 class=\"card-subtitle mb-2 text-muted\">There was an error inputting the form. Please " .
                        " try again or contact your system administrator</h6>";
                }

                ?>
                <h4 class="card-title">Success!</h4>
                <h6 class="card-subtitle mb-2 text-muted">Good job!</h6>


            </div>
        </div>
    </div>
<?php
include('footer.php');
?>