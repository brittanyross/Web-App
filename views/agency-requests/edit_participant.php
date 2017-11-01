<?php
authorizedPage();

include('header.php');
global $db, $params;

# Get people id from params
$peopleid = rawurldecode(implode('/', $params));
//$params[1] = $peopleid;


$result = $db->query("SELECT participants.participantid, participants.dateofbirth, participants.race, people.firstname, people.lastname, people.middleinit " .
					"FROM participants " .
					"INNER JOIN people ON participants.participantid = people.peopleid WHERE people.peopleid=$1", [$peopleid]);

$participant = pg_fetch_assoc($result);

// print_r($participant);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$fname = $mname = $lname = null;
	
	if(isset($_POST["fname-update"])){
		$fname = $_POST["fname-update"];
		$update = $db->query("UPDATE people SET firstname = $1 WHERE peopleid = $2",[$fname, $peopleid]);
		
	}
	
	if(isset($_POST["mname-update"])){
		$mname = $_POST["mname-update"];
		$update = $db->query("UPDATE people SET middleinit = $1 WHERE peopleid = $2",[$mname, $peopleid]);
	}
	if(isset($_POST["lname-update"])){
		$lname = $_POST["lname-update"];
		$update = $db->query("UPDATE people SET lastname = $1 WHERE peopleid = $2",[$lname, $peopleid]);
	}
	echo(isset($_POST["fname-update"]));
	
}


?>
<div class="d-flex flex-column w-100" style="height: fit-content;">
    <a href="/back"><button class="cpca btn"><i class="fa fa-arrow-left"></i> Back</button></a>
<div class="d-flex justify-content-center">
<form class="mt-5 d-flex flex-column w-50 edit-form p-5 rounded" method="POST" action= "">
  <div class="form-group">
    <label for="fname-update">First Name</label>
    <input name ="fname-update" type="text" class="form-control" id="fname-update" value="<?= $participant['firstname']?>">
    <label for="mname-update">Middle Name</label>
    <input name ="mname-update"  type="text" class="form-control" id="mname-update" placeholder="Enter middle initial" value="<?= $participant['middleinit']?>">
    <label for="lname-update">Last Name</label>
    <input name ="lname-update"  type="text" class="form-control" id="lname-update" value="<?= $participant['lastname']?>">
   </div>
  <div class="form-group">
    <label for="status-update">Status</label>
    <select name ="status-update"  class="form-control" id="status-update">
		<option value="active">active</option>
		<option value="inactive">inactive</option>
		<option value="active">active</option>
	</select>
  </div>
  <div class="form-group">
    <label for="hphone-update">Home Phone</label>
    <input name ="hphone-update"  type="phone" class="form-control" id="hphone-update" placeholder="Enter home phone">
    <label for="mphone-update">Cell Phone</label>
    <input name ="mphone-update"  type="phone" class="form-control" id="mphone-update" placeholder="Enter cell phone">
   </div>
  <input type="submit" value="submit" class="btn btn-primary">
</form>	
</div>

</div>


<?php
include('footer.php');
?>