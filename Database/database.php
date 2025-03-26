<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
try {
    $conn = new PDO("mysql:host=$servername;dbname=weblog", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
if (isset($_COOKIE['email'])) {

    $stmt = $conn->prepare("select * from users where email=? and password=?");
    $stmt->bindParam(1, $_COOKIE['email']);
    $stmt->bindParam(2, $_COOKIE['password']);
    $stmt->execute();
    if ($stmt->rowCount() >= 1) {
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['login'] = true;
        $_SESSION['email'] = $_COOKIE['email'];
        $_SESSION['password'] = $_COOKIE['password'];
        $_SESSION['role'] = $rows['role'];
    }

}
?>
