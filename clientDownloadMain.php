<?php
include 'config.php';
$dsn = "mysql:host=$ServerIP;dbname=$DbName;charset=$DBCharset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $Username, $Password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
session_start();
if (!isset($_SESSION["user"])) {
} else {
    $stmt = $pdo->prepare("SELECT `clients`.`id` AS 'id', 
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
    INNER JOIN client_apps ON `clients`.`id` = `client_apps`.`id`");
    $stmt->execute();

    $delimiter = ",";
    $filename = "clients_" . date('Y-m-d H:i:s') . ".csv";
    // Create a file pointer 
    $f = fopen('php://memory', 'w');

    // Set column headers 
    $fields = array('Client ID', 'Updated?', 'Client Name', 'CPU', 'iGPU', 'eGPU', 'RAM', 'Memory', 'IP address', 'MAC address', 'Installed Apps');
    fputcsv($f, $fields, $delimiter);

    foreach ($stmt as $row) {
        $lineData = array($row['id'], $row['update'], $row['name'], $row['cpu'], $row['igpu'], $row['egpu'], $row['ram'], $row['mem'], $row['ip'], $row['mac'], $row['apps']);
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
