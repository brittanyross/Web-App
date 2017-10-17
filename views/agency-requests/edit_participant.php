<?php
authorizedPage();

include('header.php');
global $db, $params;
$peopleid = $params[0];

$result = $db->query("SELECT participants.participantid, participants.dateofbirth, participants.race, people.firstname, people.lastname, people.middleinit " .
					"FROM participants " .
					"INNER JOIN people ON participants.participantid = people.peopleid WHERE people.peopleid=$1", [$peopleid]);

$participant = pg_fetch_assoc($result);

?>
<div class="d-flex flex-column w-100" style="height: fit-content;">
    <a href="/back"><button class="cpca btn"><i class="fa fa-arrow-left"></i> Back</button></a>
    <div class="card" style="max-width: 700px; width: 100%; margin: 0 auto;">
        <div class="card-header">
            <h4 class="modal-title"><?= $participant['firstname']." ".$participant['middleinit']." ".$participant['lastname']?></h4>
        </div>
        <div class="card-body">
            <div class="w-100 text-center">
                <img class="icon-img" src="/img/default_av.jpg">
            </div>
            <h4 class="thin-title">Information</h4>
            <hr>
            <div class="pl-3">
                <b>Name: </b>
				<form class='form changeName'>
				<input class="form-control" name="participant_f_name" value ='<?= $participant['firstname']?>'>
				<input type='text' class= 'form-control'  name="participant_m_name" value='<?=$participant['middleinit'] ?>'>
				<input type='text' class= 'form-control'  name="participant_l_name" value='<?=$participant['lastname'] ?>'>
				<input type='submit' class='btn cpca form-control' value="Update Participant Name" >
				</form>

				
                <p class="participant_status"><b>Status: </b>
				<span class="badge badge-success">active</span> 
				</p>

                <p class="participant_notes"><b>Notes: </b> <p class="pl-3">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p></p>
                <p class="participant_other"><b>Other: </b> Other items to note</p>
				
                <p class="participant_contact">
				<b>Contact: </b>
				</p>
                <p class="participant_status"><b>Status: </b><span class="status-view badge badge-success">active</button>
				<form class='form'>
					<select class="status-selector">
					<option value = "active">active</option>
					<option value = "inactive" >inactive</option>
					<option  value = "graduate">graduate</option>
					</select>
					<script>
					$(document).ready(function(){
						var statView = $(".status-view");
						$( ".status-selector" ).change(function() {
						console.log("it changed, look at that wow");
						var value= $(this).val();
						
						switch(value){
							case "active":
							statView.removeClass();
							statView.addClass("status-view badge badge-success");
							break;
							case "inactive":
							statView.removeClass();
							statView.addClass("status-view badge badge-secondary");
							break;
							case "graduate":
							statView.removeClass();
							statView.addClass("status-view badge badge-primary glypico");
							break;
							default:
							console.log("nope");
						}
						
							
						})
					});
					</script>
				<input type='submit' value="Update Status" class='btn cpca form-control'>
				</form>
				</p>
				
                <p class="participant_notes"><b>Notes: </b> <p class="pl-3">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p></p>
                <p class="participant_other"><b>Other: </b> Other items to note</p>
                <p class="participant_contact"><b>Contact: (click to edit)</b></p>
                <div class="d-flex justify-content-center">
                    <div class="display-stack">
                        <div class="display-top">
						<input type='phone' value='(123) 456-7890' readonly></div>
                        <div class="display-split"></div>
                        <div class="display-bottom">Home Phone</div>
                    </div>
                    <div class="display-stack">
                        <div class="display-top">
						<input type='phone' value='(800) 867-5309' readonly></div>
                        <div class="display-split"></div>
                        <div class="display-bottom">Cell Phone</div>
                    </div>
                </div>
            </div>
            <br>
            <h4 class="thin-title">Family Info</h4>
            <hr>

            <!-- <button type="button" class="btn cpca">Download as PDF</button>-->
<?php  
$familyInfo = $params[0];

$familyResult = $db->query("SELECT participants.participantid, participants.dateofbirth, participants.race, people.firstname, people.lastname, people.middleinit " .
					"FROM participants " .
					"INNER JOIN people ON participants.participantid = people.peopleid WHERE people.peopleid=$1", [$familyInfo]);

$participant = pg_fetch_assoc($familyResult);
?>
            <table class="table table-striped">
                <tr><th>Col 1</th><th>Col 2</th><th>Col 3</th></tr>
                <tr><td>Data</td><td>Data</td><td>Data</td></tr>
                <tr><td>Data</td><td>Data</td><td>Data</td></tr>
                <tr><td>Data</td><td>Data</td><td>Data</td></tr>
                <tr><td>Data</td><td>Data</td><td>Data</td></tr>
                <tr><td>Data</td><td>Data</td><td>Data</td></tr>
                <tr><td>Data</td><td>Data</td><td>Data</td></tr>
            </table>
        </div>
        <div class="card-footer text-center">
            <a href="/intake-packet/<?= $participant['participantid'] ?>">
                <button class="btn btn-outline-secondary">View Intake Packet </button>
            </a>
            <a href="#">
                <button class="btn btn-outline-secondary">View Attendence Record</button>
            </a>
            <a href="#">
                <button class="btn btn-outline-secondary">View Current Assigned Curriculum</button>
            </a>
        </div>
    </div>
</div>


<?php
include('footer.php');
?>