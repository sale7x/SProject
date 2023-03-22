<?php
// Database connection settings
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "carreminder";

// Create database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check for errors in connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select car data from database
$sql = "SELECT * FROM cars";
$result = mysqli_query($conn, $sql);

// Check for errors in SQL query
if (!$result) {
    die("Error retrieving car data: " . mysqli_error($conn));
}

// Convert car data to JSON
$cars = array();
while ($row = mysqli_fetch_assoc($result)) {
    $cars[] = $row;
}
$json = json_encode($cars);

// Send JSON response
header("Content-type: application/json");
echo $json;

// Close database connection
mysqli_close($conn);
?>