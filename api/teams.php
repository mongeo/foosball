<?php
include '../inc/dbConnection.php';
$conn = getDatabaseConnection("nfl_picks");

$sql = "SELECT * FROM teams";

$stmt = $conn->prepare($sql);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($records);
?>