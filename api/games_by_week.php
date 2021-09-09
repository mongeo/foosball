<?php
include '../inc/dbConnection.php';
$conn = getDatabaseConnection("nfl_picks");

$sql = "SELECT * FROM games WHERE week=1 ORDER BY date_time";

$stmt = $conn->prepare($sql);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($records);
?>