<?php
$host = "localhost";
$user = "root"; 
$password = "";
$database = "lead_management";

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
