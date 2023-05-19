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
    $FilterFrom = $_POST["From"];
    $FilterTo = $_POST["To"];

    $stmt = $pdo->prepare("SELECT DISTINCT 
    `clients`.`id` AS 'id', 
    `client_specs`.`name` AS 'name',
    `client_specs`.`ip` AS 'ip'
    FROM clients 
    INNER JOIN client_specs ON `clients`.`id` = `client_specs`.`id` 
    INNER JOIN client_status ON `clients`.`id` = `client_status`.`id` 
    WHERE client_status.date_time BETWEEN ? AND ?");
    $stmt->execute([$FilterFrom, $FilterTo]);
    foreach ($stmt as $row) {
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
