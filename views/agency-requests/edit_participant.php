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
<div class="d-flex justify-content-center">
<form class="mt-5 d-flex flex-column w-50 edit-form p-5 rounded">
  <div class="form-group">
    <label for="fname-update">First Name</label>
    <input type="text" class="form-control" id="fname-update" placeholder="Enter email">
    <label for="mname-update">Middle Name</label>
    <input type="text" class="form-control" id="mname-update" placeholder="Enter email">
    <label for="lname-update">Last Name</label>
    <input type="text" class="form-control" id="lname-update" placeholder="Enter email">
   </div>
  <div class="form-group">
    <label for="status-update">Status</label>
    <select class="form-control" id="status-update">
		<option value="active">active</option>
		<option value="inactive">inactive</option>
		<option value="active">active</option>
	</select>
  </div>
  <div class="form-group">
    <label for="fname-update">First Name</label>
    <input type="phone" class="form-control" id="fname-update" placeholder="Enter email">
    <label for="mname-update">Middle Name</label>
    <input type="phone" class="form-control" id="mname-update" placeholder="Enter email">
   </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>	
</div>

</div>


<?php
include('footer.php');
?>