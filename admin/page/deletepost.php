<?php
include "../../Database/database.php";

$id = $_GET['id'];
$stmt = $conn->prepare("delete from posts where id=?");
$stmt->bindParam(1, $id);
$stmt->execute();
header('location:blog.php');

