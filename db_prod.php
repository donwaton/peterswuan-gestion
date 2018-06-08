<?php
$servername = "localhost";
$username = "hcifuent_admin";
$password = "AdminPS2018";
$dbname = "hcifuent_peterswuan";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->query("SET NAMES 'utf8'");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>