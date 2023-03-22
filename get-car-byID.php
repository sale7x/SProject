<?php

// Connect to the database
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "carreminder";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get the car id from the URL parameter
$carId = $_GET['id'];

// Query the database to get the car details by id
$sql = 'SELECT * FROM cars WHERE id=' . $carId;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Return the car details as JSON
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    // Return an error message if the car is not found
    http_response_code(404);
    echo json_encode(array('message' => 'Car not found'));
}

// Close the database connection
$conn->close();

?>