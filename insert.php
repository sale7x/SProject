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
$stmt = $conn->prepare("INSERT INTO cars (carname, carmodel, user_id) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $carname, $carmodel,$userID );

// Set parameters and execute
$userID= $_POST["userID"];
if (empty($userID)) {
    die("User ID is required");
}
$carname = $_POST["carname"];
$carmodel = $_POST["carmodel"];

$stmt->execute();

echo "New record created successfully";

$stmt->close();
$conn->close();

?>