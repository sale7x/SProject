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


//  Prepare  the  SQL  statement  and  bind  the  parameter
$stmt  =  $conn->prepare('SELECT  *  FROM  cars  WHERE  id=?');
$stmt->bind_param('i',  $carId);

//  Execute  the  statement  and  get  the  result
$stmt->execute();
$result  =  $stmt->get_result();

if  ($result->num_rows  >  0)  {
    //  Return  the  car  details  as  JSON
    $row  =  $result->fetch_assoc();
    echo  json_encode($row);
}  else  {
    //  Return  an  error  message  if  the  car  is  not  found
    http_response_code(404);
    echo  json_encode(array('message'  =>  'Car  not  found'));
}

//  Close  the  statement  and  the  database  connection
$stmt->close();
// Close the database connection


?>