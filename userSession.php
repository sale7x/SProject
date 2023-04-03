<?php

session_start();
$userID = $_SESSION['user'];

if(empty($_SESSION["user"])){
    header('Location: login.php');

}

?>