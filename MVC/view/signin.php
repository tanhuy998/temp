<?php
	class SigninView {
		
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sign in</title>
	<link rel="stylesheet" type="text/css" href="<?php echo 'http://'.DOMAIN.'public/style/signin.css'?>">
	<style> 
	body {
		background-image: url(<?php echo 'http://'.DOMAIN.'public/img/BG1.png'?>);
	}	
	</style>
</head>
<body>
	<div id="lable">SIGN IN</div>
	<div id="form">
		<form method="POST" action="<?php ECHO 'http://'.DOMAIN.$_GET['target']?>" >
		<table>
			<?php 
				if (isset($_GET['error'])) {
					echo'<tr><td colspan="2" id="signup">wrong user</td></tr>';
				}
			?>
			<tr>
				<td>Username</td>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td colspan="2" id="button"><input type="submit" value="Enter" name="" ></td>
			</tr>
			
			<tr>
				<td colspan="2" id="signup"><a href="" target="_blank">SIGN UP</a></td>
			</tr>
		</table>
	</form>
	</div>	
</body>
</html>