<?php
include 'config.php';
session_start();
if (!isset($_SESSION["user"])) {
    echo "<script>window.location.href='login.php';</script>";
} else {
    $FilterFrom = $_POST["From"];
    $FilterTo = $_POST["To"];
    $conn = new mysqli($ServerIP, $Username, $Password, $DbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT DISTINCT 
    `clients`.`id` AS 'id', 
    `client_specs`.`name` AS 'name',
    `client_specs`.`ip` AS 'ip'
    FROM clients 
    INNER JOIN client_specs ON `clients`.`id` = `client_specs`.`id` 
    INNER JOIN client_status ON `clients`.`id` = `client_status`.`id` 
    WHERE client_status.date_time BETWEEN '" . $FilterFrom . "' AND '" . $FilterTo . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subs_ip = "";
            $str = $row["ip"];
            $b = 0;
            for ($i = 0; $i < strlen($str) && $i < 25; $i++) {
                if ($str[$i] == '/') {
                    $subs_ip = $subs_ip . substr($str, $b, ($i - $b));
                    if ($i < strlen($str) - 1) {
                        $subs_ip = $subs_ip . ", ";
                    }
                    $b = $i + 1;
                }
                if ($i >= 24) {
                    $subs_ip = $subs_ip . "...";
                }
            }
            $param = "'" . $row['id'] . "','" . $FilterFrom . "','" . $FilterTo . "'";
            echo '<input type="button" onclick="showClientDetails2(' . $param . ');"';
            echo ' style="width:100%; text-align: left;" 
            value="[' . $row['id'] . '] ' . $row['name'] . ' (' . $subs_ip . ')"></input>';
            echo '<br><br>';
        }
    }
    $conn->close();
}
