<?php
session_start();

include '../inc/dbConnection.php';
$conn = getDatabaseConnection("nfl_picks");

$week = $_GET['week'];

$arr = array();

$sql1 = "SELECT game_key, home_team, away_team, pick, count(pick) as count_num FROM `user_games` WHERE week = :week GROUP BY game_key, pick ORDER BY count_num DESC";
$stmt1 = $conn->prepare($sql1);
$stmt1->bindParam(':week', $week, PDO::PARAM_INT);
$stmt1->execute();
$head2head = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$arr['head2head'] = $head2head;

echo json_encode($arr);
?>