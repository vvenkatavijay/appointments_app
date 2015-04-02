<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Edit appointment</title>
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
		<p> Edit this appointment </p>
		<form action="/users/process_edit" method="post">
				<div class="form-group">
					<label>Date:</label>
					<input type="text" name="date_of_appointment" class="form-control" value="<?=$date?>" id="datepicker">
				</div>
				<div class="form-group">
					<label>Time:</label>
					<input type="text" name="time_of_appointment" class="form-control" value="<?=$time?>">
				</div>
				<div class="form-group">
					<label>Tasks:</label>
					<input type="text" name="task" class="form-control" value="<?=$name?>">
				</div>
				<input type="hidden" name="id" value="<?=$id?>">
				<input type="submit" value="Edit" class="btn btn-success">
		</form>
	</div>
</body>
</html>