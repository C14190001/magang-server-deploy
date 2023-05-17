<?php
include 'config.php';
session_start();
if (!isset($_SESSION["user"])) {
    echo "<script>window.location.href='login.php';</script>";
} else {
    $cId = $_POST["Id"];
    $conn = new mysqli($ServerIP, $Username, $Password, $DbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "UPDATE `clients` SET `updated?` = '0' WHERE `clients`.`id` = " . $cId;
    if(!$conn->query($sql)){
        echo "Failed to set Updated? value for Client " . $cId . ".";
    }
    else{
        echo "Client " . $cId . " will update soon.";
    }
    $conn->close();
}
?>