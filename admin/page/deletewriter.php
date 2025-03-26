<?php
include "../../Database/database.php";

$id = $_GET['id'];
$stmt = $conn->prepare("delete from writer where id=?");
$stmt->bindParam(1, $id);
$stmt->execute();
header('location:writers.php');

