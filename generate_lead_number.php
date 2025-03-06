<?php
include 'DB/connect.php';

// Fetch the latest lead number
$result = $mysqli->query("SELECT lead_number FROM leads ORDER BY id DESC LIMIT 1");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastLeadNumber = $row['lead_number'];
    $leadNumber = 'LEAD' . str_pad(substr($lastLeadNumber, 4) + 1, 4, '0', STR_PAD_LEFT);
} else {
    $leadNumber = 'LEAD0001';
}

echo $leadNumber;
?>
