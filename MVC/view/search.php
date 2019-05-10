<?php
	class SearchView {
		
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
	<div id="form">
		<form method="POST" action="<?php ECHO 'http://'.DOMAIN.'s'?>" >
		<table>
			<tr>
				<td>search name</td>
				<td><input type="text" name="name"></td>
			</tr>
			
			<tr>
				<td colspan="2" id="button"><input type="submit" value="Enter" name="" ></td>
			</tr>
			
			
		</table>
	</form>
	</div>	
</body>
</html>