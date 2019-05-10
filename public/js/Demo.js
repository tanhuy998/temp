function deposite(){
	var x = document.getElementById('moneyalert');
	if(x.style.visibility == "hidden"){
		x.style.visibility = "visible";
	}	
	else{
		x.style.visibility = "hidden";
	}   	
}
function depositeclick(){
	if(parseInt(inputmoney.value) != 0)
	document.getElementById("money").innerHTML = inputmoney.value+"$";	
	
}
function takestopprofit(){
	var x = document.getElementById('setTLalert');
	if(x.style.visibility == "hidden"){
		x.style.visibility = "visible";
	}	
	else{
		x.style.visibility = "hidden";
	}   	
}


