<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome!</title>
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
		<h2>Welcome !</h2>
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

		<div id="register" class="col-md-6">
			<form action="/users/register" method="post">
				<fieldset>
					<legend>
						New User? Register
					</legend>
					<div class="form-group">
						<label>Email Address:</label>
						<input type="text" name="email" placeholder="Email" class="form-control">
					</div>
					<div class="form-group">
						<label>Name:</label>
						<input type="text" name="user_name" placeholder="First Name" class="form-control">
					</div>
					<div class="form-group">
						<label>Password:</label>
						<input type="password" name="password" placeholder="Password" class="form-control">
						<p>Password must be atleast 8 characters</p>
					</div>
					<div class="form-group">
						<label>Password Confirmation:</label>
						<input type="password" name="confpassword" placeholder="Confirm Password" class="form-control">
					</div>
					<div class="form-group">
						<label>Date of Birth:</label>
						<input type="text" name="date_of_birth" class="form-control" placeholder="mm/dd/yyyy" id="datepicker">
					</div>
					<input type="submit" value="Register" class="btn btn-success" id="sign_in_button">
				</fieldset>
			</form>
		</div>

		<div id="sign-in">
			<form action="/users/signin" method="post">
				<fieldset>
					<legend>
						Sign in
					</legend>
					<div class="form-group">
						<label for="InputEmail">Email Address:</label>
						<input type="text" name="email" placeholder="Email" id="InputEmail" class="form-control">
					</div>
					<div class="form-group">
						<label for="InputPassword">Password:</label>
						<input type="password" name="password" placeholder="Password" id="InputPassword" class="form-control">
					</div>
					<input type="submit" value="Sign in!" class="btn btn-success" id="sign_in_button">
				</fieldset>
			</form>
		<div>


</body>
</html>