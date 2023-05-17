<?php
include 'config.php';
session_start();
if (!isset($_SESSION["user"])) {
    echo "<script>window.location.href='login.php';</script>";
} else {
    $conn = new mysqli($ServerIP, $Username, $Password, $DbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `clients`.`id` AS 'id', 
`clients`.`updated?` AS 'update', 
`client_specs`.`name` AS 'name', 
`client_specs`.`cpu` AS 'cpu', 
`client_specs`.`i-gpu` AS 'igpu', 
`client_specs`.`e-gpu` AS 'egpu', 
`client_specs`.`ram` AS 'ram', 
`client_specs`.`memory` AS 'mem', 
`client_specs`.`ip` AS 'ip', 
`client_specs`.`mac` AS 'mac', 
`client_apps`.`apps` AS 'apps' 
FROM clients 
INNER JOIN client_specs ON `clients`.`id` = `client_specs`.`id` 
INNER JOIN client_apps ON `clients`.`id` = `client_apps`.`id`";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $delimiter = ",";
        $filename = "clients_" . date('Y-m-d H:i:s') . ".csv";
        // Create a file pointer 
        $f = fopen('php://memory', 'w');
        // Set column headers 
        $fields = array('Client ID', 'Updated?', 'Client Name', 'CPU', 'iGPU', 'eGPU', 'RAM', 'Memory', 'IP address', 'MAC address', 'Installed Apps');
        fputcsv($f, $fields, $delimiter);

        // Output each row of the data, format line as csv and write to file pointer 
        while ($row = $result->fetch_assoc()) {
            // $str_ip = "";
            // $str_mac = "";
            // $str_apps = "";

            // $str = $row["ip"];
            // $b = 0;
            // for ($i = 0; $i < strlen($str); $i++) {
            //     if ($str[$i] == '/') {
            //         $str_ip = $str_ip.substr($str, $b, ($i - $b));
            //         if ($i < strlen($str) - 1) {
            //             $str_ip = $str_ip.", ";
            //         }
            //         $b = $i + 1;
            //     }
            // }

            // $str = $row["mac"];
            // $b = 0;
            // for ($i = 0; $i < strlen($str); $i++) {
            //     if ($str[$i] == '/') {
            //         $str_mac = $str_mac.substr($str, $b, ($i - $b));
            //         if ($i < strlen($str) - 1) {
            //             $str_mac = $str_mac.", ";
            //         }
            //         $b = $i + 1;
            //     }
            // }

            // $str = $row["apps"];
            // $b = 0;
            // for ($i = 0; $i < strlen($str); $i++) {
            //     if ($str[$i] == '/') {
            //         $str_apps = $str_apps.substr($str, $b, ($i - $b));
            //         if ($i < strlen($str) - 1) {
            //             $str_apps = $str_apps.", ";
            //         }
            //         $b = $i + 1;
            //     }
            // }

            $lineData = array($row['id'], $row['update'], $row['name'], $row['cpu'], $row['igpu'], $row['egpu'], $row['ram'], $row['mem'], $row['ip'], $row['mac'], $row['apps']);
            //$lineData = array($row['id'], $row['update'], $row['name'], $row['cpu'], $row['igpu'], $row['egpu'], $row['ram'], $row['mem'], $str_ip, $str_mac, $str_apps);
            fputcsv($f, $lineData, $delimiter);
        }

        // Move back to beginning of file 
        fseek($f, 0);

        // Set headers to download file rather than displayed 
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        //output all remaining data on a file pointer 
        fpassthru($f);
    }

    $conn->close();
}
