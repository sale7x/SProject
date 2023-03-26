<?php

// Get the ID of the car to be deleted from the request parameters
if (!isset($_POST['id'])) {
    http_response_code(400);
    echo 'Error: No car ID specified';
    exit;
}
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



try {


    $id = $_POST['id'];

// Prepare the SQL statement to delete the car record with the given ID
$stmt = $conn->prepare('DELETE FROM cars WHERE id = ?');
$stmt->bind_param('s', $id);
$stmt->execute();


if($stmt->affected_rows > 0 ){
    // Return a success response
    echo $stmt->affected_rows;
//    http_response_code(200);
} else {
    echo $_POST['id'];

}

}
catch (Exception $exception) {
    // Rollback transaction on error

    echo 'Error deleting car: ' . $exception->getMessage();
}
