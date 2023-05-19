<?php
include 'config.php';
session_start();
if (isset($_SESSION["user"])) {
  echo "<script>window.location.href='main2.php';</script>";
  exit;
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user = $_POST['user'];
  $pass = $_POST['pass'];
  $passmd5 = md5($pass);

  $stmt = $pdo->prepare("SELECT `username` as name FROM `admins` WHERE `username` = ? AND `password` = ?");
  $stmt->execute([$user, $passmd5]);
  $n=0;
  foreach ($stmt as $row) {
    $_SESSION["user"] = $row['name'];
    echo "<script>window.location.href='main2.php';</script>";
    $n++;
  }
  if($n<=0){
    echo "<script>alert('Wrong username or password!');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Dashboard</title>
</head>
<style>
  html,
  body {
    height: 100%;
    align-items: center;
    display: flex;
    justify-content: center;
  }
</style>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<body>
  <table style="width: 100%; padding: 50px; text-align:center; border: 1px solid black;">
    <tr style="height: 10%;">
      <th style="font-size:24px;">
        Client Dashboard Login
        <br><br>
        <form method="post">
          <input type="text" required name="user" placeholder="Username">
          <input type="password" required name="pass" placeholder="Password">
          <input type="submit" value="Login" />
        </form>
      </th>
    </tr>
  </table>
</body>

</html>