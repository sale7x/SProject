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

if (empty($carId)) {
    echo "Car ID not found.";
    exit;
}



// Get the partname and daysno values from the form
$partname = $_POST['partname'];
$daysno = $_POST['daysno'];

// Insert the new data into the parts table
$sql = "INSERT INTO parts (partname, daysno, ID) VALUES ('$partname', '$daysno', $carId)";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "Part/Service added successfully";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>