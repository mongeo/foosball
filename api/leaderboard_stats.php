<?php
session_start();

include '../inc/dbConnection.php';
$conn = getDatabaseConnection("nfl_picks");

$username = $_SESSION['username'];

$arr = array();

$sql1 = "SELECT COUNT(*) as wins, username FROM `user_games` WHERE user_games.result = 'W' GROUP BY username ORDER BY wins DESC";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute();
$total_wins = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$arr['total_wins'] = $total_wins;


$sql2 = "SELECT username, week, COUNT(*) as wins FROM `user_games` WHERE user_games.result = 'W' GROUP BY username, week ORDER BY wins DESC, week ASC";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute();
$wins_by_week = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$arr['wins_by_week'] = $wins_by_week;


echo json_encode($arr);
?>