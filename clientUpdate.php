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
    $cId = $_POST["Id"];
    $stmt = $pdo->prepare("UPDATE `clients` SET `updated?` = '0' WHERE `clients`.`id` = ?");
    $stmt->execute([$cId]);
    echo "Client " . $cId . " will update soon.";
}
