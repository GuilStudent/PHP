<?php
$servername = "mysql";
$username = "root";
$password = "password";
$dbname = "webshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
die("Connection failed");
}
?>