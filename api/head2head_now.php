<?php
session_start();

include '../inc/dbConnection.php';
$conn = getDatabaseConnection("nfl_picks");

$arr = array();

$sql1 = "SELECT * FROM `user_games` WHERE NOW() + INTERVAL 3 HOUR >= date_time AND NOW() + INTERVAL 3 HOUR <= date_time + INTERVAL 3 HOUR;";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute();
$head2head = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$arr['head2head'] = $head2head;

$sql2 = "SELECT * FROM teams";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute();
$teams = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$arr['teams'] = $teams;

echo json_encode($arr);
?>