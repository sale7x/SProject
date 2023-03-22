<?php
// Get the ID of the car to be deleted from the request parameters
$id = $_POST['id'];

// Connect to the database
$host = '127.0.0.1';
$dbname = 'carreminder';
$username = 'root';
$password = '';
$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Prepare the SQL statement to delete the car record with the given ID
$stmt = $db->prepare('DELETE FROM cars WHERE id = :id');
$stmt->bindParam(':id', $id);
$stmt->execute();

// Return a success response
http_response_code(200);
?>