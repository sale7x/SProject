<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "carreminder";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind statement
$stmt = $conn->prepare("INSERT INTO cars (carname, carmodel ) VALUES (?, ?)");
$stmt->bind_param("ss", $carname, $carmodel);

// Set parameters and execute
$carname = $_POST["carname"];
$carmodel = $_POST["carmodel"];

$stmt->execute();

echo "New record created successfully";

$stmt->close();
$conn->close();

?>