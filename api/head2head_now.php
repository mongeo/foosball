<?php
session_start();

include '../inc/dbConnection.php';
$conn = getDatabaseConnection("nfl_picks");

$arr = array();
$week = $_GET['week'];


$sql1 = "SELECT * FROM `user_games` WHERE NOW() + INTERVAL 2 HOUR >= date_time AND week = :week ORDER BY date_time ASC";
$stmt1 = $conn->prepare($sql1);
$stmt1->bindParam(':week', $week, PDO::PARAM_INT);
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