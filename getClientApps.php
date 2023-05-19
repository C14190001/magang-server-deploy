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

    $stmt = $pdo->prepare("SELECT `client_apps`.`apps` AS 'apps' FROM `client_apps` WHERE `client_apps`.`id` = ?");
    $stmt->execute([$cId]);
    foreach ($stmt as $row) {
        $str = $row["apps"];
        $b = 0;
        echo "<p>Installed apps:<br>";
        for ($i = 0; $i < strlen($str); $i++) {
            if ($str[$i] == '/') {
                echo "• ";
                echo substr($str, $b, ($i - $b));
                if ($i < strlen($str) - 1) {
                    echo "<br>";
                }
                $b = $i + 1;
            }
        }
        echo "</p>";
    }
}
