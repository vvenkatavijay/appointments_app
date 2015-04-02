<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Your appointments</title>
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
</head>
<script type="text/javascript">
		$(document).ready(function(){
			$('#datepicker').datepicker();
		});
</script>
<body>
	<div class="container">

<?php
		if ($errors) { 
?>
		<div class="alert alert-danger">
			<?=$errors?>
		</div>

<?php
		}
?>

<?php
		if ($success_message) { 
?>
		<div class="alert alert-success">
			<?=$success_message?>
		</div>

<?php
		}
?>
        
		<h3>Hello, <?=$user_details['user_name']?></h3>
		<p class="pull-right"><a href="/users/logout">Log out</a></p>
		<p>Here are your appointments for today <?=$today?></p>
		<table class="table table-striped table-condensed">
			<thead>
				<tr>
					<th>Tasks</th>
					<th>Time</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
<?php
			if ($current_appointments)
				foreach ($current_appointments as $appointment) {
?>
				<tr>
					<td><?=$appointment['name']?></td>
					<td><?=$appointment['time']?></td>
					<td><?=$appointment['status']?></td>
					<td>
						<a href="/users/edit_appointment/<?=$appointment['id']?>">Edit</a> 
						<a href="/users/remove_appointment/<?=$appointment['id']?>">Remove</a>
					</td>
<?php 
			}
?>
				</tr>
			</tbody>
		</table>
		<div class="col-md-6">
			<p>Your other appointments</p>
			<table class="table table-striped table-condensed">
				<thead>
					<tr>
						<th>Tasks</th>
						<th>Date</th>
						<th>Time</th>
					</tr>
				</thead>
				<tbody>
<?php
				if ($future_appointments)
					foreach ($future_appointments as $appointment) {
?>
						<tr>
							<td><?=$appointment['name']?></td>
							<td><?=$appointment['date']?></td>
						<td><?=$appointment['time']?></td>
<?php 
					}
?>
				</tbody>
			</table>
		<div>

		<div>
			<p>Add Appointment</p>
			<form action="/users/add_appointment" method="post">
				<div class="form-group">
					<label>Date:</label>
					<input type="text" name="date_of_appointment" class="form-control" placeholder="mm/dd/yyyy" id="datepicker">
				</div>
				<div class="form-group">
					<label>Time:</label>
					<input type="text" name="time_of_appointment" class="form-control" placeholder="hh:mm">
				</div>
				<div class="form-group">
					<label>Tasks:</label>
					<input type="text" name="task" class="form-control" placeholder="What do you plan to do?">
				</div>
				<input type="submit" value="Add" class="btn btn-success">
			</form>
		</div>

	</div>
</body>
</html>