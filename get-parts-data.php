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

// Get the car id from the URL parameter
$carId = $_GET['id'];

// Retrieve the part data for the specified car
$sql = "SELECT * FROM parts WHERE ID = $carId";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Convert the result set to an array of parts
    $parts = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $parts[] = $row;
    }

    // Return the parts as JSON
    header('Content-Type: application/json');
    echo json_encode($parts);
} else {
    echo "No parts found for car $carId";
}

// Close the database connection
mysqli_close($conn);

?>
