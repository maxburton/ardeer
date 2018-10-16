var $cash;
var $poles;
var $waterBasePrice;
var $digSuccessChance;
var $debt;

var $salt;
var $helmet;
var $worker;


function start(){
	$cash = 1000.00;
	$poles = 0;
	$waterBasePrice = 10.00;
	$digSuccessChance = 10.0;
	$debt = 0.00;

	$salt = {
		multiplier:1.1,
		quantity:0,
		basePrice:100.00,
		inflation:1.2,
		currentPrice:100.00
	};

	$helmet = {
		multiplier:1.05,
		quantity:0,
		basePrice:50.00,
		inflation:1.5,
		currentPrice:50.00
	};

	$worker = {
		RPS:1,
		quantity:0,
		basePrice:200.00,
		wages:20.00,
		inflation:1.15,
		currentPrice:200.00
	};

}

var $cookie = {};
function updateCookie(){
	$cookie.cash = $cash;
	$cookie.poles = $poles;
	$cookie.digSuccessChance = $digSuccessChance;
	$cookie.debt = $debt;
	$cookie.salt = JSON.stringify($salt);
	$cookie.helmet = JSON.stringify($helmet);
	$cookie.worker = JSON.stringify($worker);
	document.cookie = "saveData=" + JSON.stringify($cookie);
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function loadData(){
	$saveData = JSON.parse(getCookie("saveData"));
	$cash = $saveData.cash;
	$poles = $saveData.poles;
	$digSuccessChance = $saveData.digSuccessChance;
	$debt = $saveData.debt;
	$salt.quantity = JSON.parse($saveData.salt).quantity;
	$salt.currentPrice = JSON.parse($saveData.salt).currentPrice;
	$helmet.quantity = JSON.parse($saveData.helmet).quantity;
	$helmet.currentPrice = JSON.parse($saveData.helmet).currentPrice;
	$worker.quantity = JSON.parse($saveData.worker).quantity;
	$worker.currentPrice = JSON.parse($saveData.worker).currentPrice;
}

$(document).ready(function(){
	start();
	loadData();
	updateCash();
	updatePoles();
	updatePrices();
	$("#dig").click(function(){
		attemptDig(true);
	});
	$("#delete").click(function(){
		start();
	});
	$("#salt").click(function(){
		buy($salt);
	});
	$("#helmet").click(function(){
		buy($helmet);
		updateDigSuccess();
	});
	$("#worker").click(function(){
		buy($worker);
	});
});



function attemptDig($user) {
	var $random = Math.random() * 100;
	if($random < $digSuccessChance){
		var $amount = addWaterCash(true);
		if($user){
			$("p#digOutcome").css('color', 'green');
			$("p#digOutcome").text("You dig girl! You earned " + $amount + " Lt!");
		}
	}else{
		if($user){
			$("p#digOutcome").css('color', 'red');
			$("p#digOutcome").text("Dig unsuccessful. Could this be the dreaded Latushkan drought?");
		}
	}
}

function addWaterCash($output){
	var $newCash = $waterBasePrice;
	$newCash = $newCash * Math.pow($salt.multiplier, $salt.quantity);
	$cash = parseFloat($cash) + parseFloat($newCash);
	$cash = $cash.toFixed(2);
	updateCash();
	if($output){
		return $newCash.toFixed(2);
	}
}

function buy(obj){
	if($cash >= obj.currentPrice){
		$cash = $cash - obj.currentPrice;
		$cash = $cash.toFixed(2);
		updateCash();
		obj.quantity++;
		obj.currentPrice = obj.currentPrice * obj.inflation;
		obj.currentPrice = obj.currentPrice.toFixed(2);
		updatePrices();
	}
}

window.setInterval(function(){ //Every second checks to see how many autodigs occur & executes them
	var i;
	for (i = 0; i < $worker.quantity; i++) { 
    attemptDig(false);
	}
	updateCookie(); //May as well put the cookie updater here as well.
}, 1000);

window.setInterval(function(){ //Every minute wages are paid
	var $totalWages = $worker.quantity * $worker.wages;
	$cash = $cash - $totalWages;
}, 60000);

function updateCash(){
	$("p#cash").text($cash + " Lt");
}

function updatePoles(){
	$("p#poles").text($poles + "/543060 Poles Lured");
}

function updatePrices(){
	$("h4#saltPrice").text($salt.currentPrice + " Lt");
	if($salt.quantity > 0){
		$("h4#saltQuantity").text($salt.quantity + " Shakers Shaking");
	}$("h4#helmetPrice").text($helmet.currentPrice + " Lt");
	if($helmet.quantity > 0){
		$("h4#helmetQuantity").text($helmet.quantity + " Latushkan Soldiers");
	}$("h4#workerPrice").text($worker.currentPrice + " Lt + " + $worker.wages + " Lt p/m");
	if($worker.quantity > 0){
		$("h4#workerQuantity").text($worker.quantity + " Very Sad Chaps");
	}
}

function updateDigSuccess(){
	$digSuccessChance = $digSuccessChance * Math.pow($helmet.multiplier, $helmet.quantity);
}
