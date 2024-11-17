<?php
$startDate = '2023-09-01'; // Replace with your start date
$endDate = '2023-09-10';   // Replace with your end date

$currentDate = strtotime($startDate); // Convert start date to timestamp

while ($currentDate <= strtotime($endDate)) {
    echo date('Y-m-d', $currentDate) . "-"; // Print the current date
    $currentDate = strtotime('+1 day', $currentDate); // Move to the next day
}
