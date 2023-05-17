<?php
include 'config.php';
session_start();
if (isset($_SESSION["user"])) {
  echo "<script>window.location.href='main2.php';</script>";
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user = $_POST['user'];
  $pass = $_POST['pass'];

  $conn = new mysqli($ServerIP, $Username, $Password, $DbName);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $passmd5 = md5($pass);
  $sql = "SELECT username as name FROM admins WHERE username = '$user' AND password = '$passmd5'";
  $result = $conn->query($sql);
  $hasil = $result->fetch_assoc();

  if ($result->num_rows < 1) {
    echo "<script>alert('Wrong username or password!');</script>";
  } else {
    $_SESSION["user"] = $hasil['name'];
    $conn->close();
    echo "<script>window.location.href='main2.php';</script>";
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