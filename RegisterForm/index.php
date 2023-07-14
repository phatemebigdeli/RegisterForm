<?php
include_once './controller/methods.php';
if(isset($_POST['signup_btn'])){
	$data = $_POST['frm'];
	signup($data);

}

if(isset($_POST['login_btn'])){
   $data = $_POST['frm'];
   login($data);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Slide Navbar</title>
	<link rel="stylesheet" type="text/css" href="slide navbar style.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./assets/style.css">
<script src = "//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
	<?php Semej::alert(); ?>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form method='POST' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
					<label for="chk" aria-hidden="true">Sign up</label>
					<input type="text" name="frm[username]" placeholder="User name" required="">
					<input type="email" name="frm[email]" placeholder="Email" required="">
					<input type="password" name="frm[password]" placeholder="Password" required="">
					<input type="password" name="frm[passwordConfirm]" placeholder="Password Confirm" required="">
					<input type="submit" value="Sign up" name='signup_btn'>
				</form>
			</div>

			<div class="login">
				<form method='POST' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
					<label for="chk" aria-hidden="true">Login</label>
					<input type="email" name="frm[email]" placeholder="Email" required="">
					<input type="password" name="frm[password]" placeholder="Password" required="">
					<input type="submit" value="Login" name='login_btn'>
				</form>
			</div>
	</div>
</body>
</html>