<?php

// Get the ID of the car to be deleted from the request parameters
$id = $_POST['id'];

// Connect to the database
$servername = '127.0.0.1';
$dbname = 'carreminder';
$username = 'root';
$password = '';
// Create database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check for errors in connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



// Prepare the SQL statement to delete the car record with the given ID
$stmt = $conn->prepare('DELETE FROM cars WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();

// Return a success response
http_response_code(200);
?>