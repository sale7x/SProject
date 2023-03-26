<?php

$userID = $_GET['userID'];

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

// Construct the SQL query
if(isset($userID)){
    $sql = "SELECT * FROM cars WHERE user_id = $userID";
    $result = $conn->query($sql);
    if (!$result) {
        die('Error querying the database');
    }

    // Fetch the results and return them as JSON
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
} else{
    echo "userID not found";
}

// Close database connection
mysqli_close($conn);
?>