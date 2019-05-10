<?php
	class HomeView {

	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Stock Market</title>
	<link rel="stylesheet" type="text/css" href="<?php echo 'http://'.DOMAIN.'public/style/'.'Demo.css'?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo 'http://'.DOMAIN.'public/js/'.'Demo.js'?>"></script>
</head>
<body>	
	<div id="board">
		<div id="topbar">
			<div id="money" onclick="deposite()">10,000$</div>
			<div id="moneyalert"><input type="text" name="money" id="inputmoney"><button id="depositebut" onclick="depositeclick()">Deposite</button></div>
			<img src="<?php echo 'http://'.DOMAIN.'public/img/'.'dollar.png'?>" id="avatar">
			<img src="<?php echo 'http://'.DOMAIN.'public/img/'.'logo.png'?>" id="logo">
			<img src="<?php echo 'http://'.DOMAIN.'public/img/'.'fb.png'?>" id="company">			
		</div>							

		<div id="rightbar">
			<div class="choose" id="moneyIn">Amount<input type="text" id="amt"></div>
			<div class="choose">Lever
				<select id="lever">
					<option>x5</option>
					<option>x10</option>
					<option>x20</option>
				</select>
			</div>
			<div class="choose">Setting
				<table id="setTL" onclick="takestopprofit()">					
					<tr>
						<td>+5%</td>
						<td>-10%</td>
					</tr>
				</table>
				<div id="setTLalert">Take<input type="text" name="take" class="takestop">Stop<input type="text" name="stop" class="takestop stopin"></div>
			</div>
			<div class="button" id="myBuy">Buy</div>
			<div class="button" id="mySell">Sell</div>
		</div>

		<div id="leftbar">
			<div id="hist">HISTORY</div>
		</div>			

		<div id="centerbar">

			<canvas id="myCanvas"></canvas>			
						
		</div>
	
		<div id="bottombar">

		</div>

	</div>
	<script type="text/javascript" src="<?php echo 'http://'.DOMAIN.'public/js/'.'chart.js'?>"></script>
</body>
</html>