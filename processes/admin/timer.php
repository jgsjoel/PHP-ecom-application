<?php

// require "processes/connection.php";

$startdate = new DateTime("2023-01-01 00:00:00");

$tdate = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$tdate->setTimezone($tz);
$endDate = new DateTime($tdate->format("Y-m-d H:i:s"));

$difference = $endDate->diff($startdate);

echo $difference->format("%Y") . "Years" ."|". $difference->format("%m") . "Months" ."|".
    $difference->format("%d") . "Days" ."|". $difference->format("%H") . "Hours" ."|".
    $difference->format("%i") . "Minutes" ."|". $difference->format("%s") . "Seconds";
