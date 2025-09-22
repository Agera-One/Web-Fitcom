<?php
$hostname = "127.0.0.1:3307";
$username = "root";
$password = "";
$database = "smart_farm";

$connection = mysqli_connect($hostname, $username, $password, $database);
mysqli_select_db($connection, $database);
