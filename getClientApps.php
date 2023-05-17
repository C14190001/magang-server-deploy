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

    $sql = "SELECT `client_apps`.`apps` AS 'apps' FROM `client_apps` WHERE `client_apps`.`id` = ". $cId;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $str = $row["apps"];
            $b = 0;
            echo "<p>Installed apps:<br>";
            for( $i = 0; $i<strlen($str); $i++ ) {
                if($str[$i]=='/'){
                    echo "• ";
                    echo substr($str, $b, ($i - $b));
                    if($i<strlen($str)-1){
                        echo "<br>";
                    }
                    $b = $i + 1;
                }
            }
            echo"</p>";
        }
    }
    $conn->close();
}
