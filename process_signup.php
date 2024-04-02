<?php
$hostname = "84.55.182.143";
$servername = "localhost"; 
$username = "yeshna"; 
$password = "root"; 
$dbname = "isgsdb"; 
$conn = new mysqli($hostname,$servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$FirstName = $_POST["FirstName"];
$LastName = $_POST["LastName"];
$EmailAddress = $_POST["EmailAddress"];
$Password = $_POST["Password"];

$sql = "INSERT INTO user (FirstName, LastName, EmailAddress, Password)
        VALUES (\"$FirstName\", \"$LastName\", \"$EmailAddress\", \"$Password\")";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
