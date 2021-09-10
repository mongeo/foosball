<?php
include '../inc/dbConnection.php';
$conn = getDatabaseConnection("nfl_picks");

$w = $_GET['week'];

$arr = array();

$sql1 = "SELECT * FROM games WHERE week = $w ORDER BY date_time";

$stmt1 = $conn->prepare($sql1);
$stmt1->execute();
$games = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$arr['games'] = $games;


$sql2 = "SELECT * FROM teams";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute();
$teams = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$arr['teams'] = $teams;

echo json_encode($arr);
?>