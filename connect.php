<?php
$hostname ="84.55.182.143";
$servername = "localhost"; 
$username = "yeshna";
$password = "root";
$dbname = "isgsb";

// Create connection
$conn = mysqli_connect($hostname,$servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>
