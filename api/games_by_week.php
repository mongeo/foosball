<?php
session_start();

include '../inc/dbConnection.php';
$conn = getDatabaseConnection("nfl_picks");

$username = $_SESSION['username'];
$week = $_GET['week'];

$arr = array();

$sql1 = "SELECT * FROM games WHERE week = :week ORDER BY date_time";
$stmt1 = $conn->prepare($sql1);
$stmt1->bindParam(':week', $week, PDO::PARAM_INT);
$stmt1->execute();
$games = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$arr['games'] = $games;


$sql2 = "SELECT * FROM teams";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute();
$teams = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$arr['teams'] = $teams;

$sql3 = 'SELECT * FROM user_games WHERE week = :week AND username = :username';
$stmt3 = $conn->prepare($sql3);
$stmt3->bindParam(':week', $week, PDO::PARAM_INT);
$stmt3->bindParam(':username', $username, PDO::PARAM_STR);
$stmt3->execute();
$user_games = $stmt3->fetchAll(PDO::FETCH_ASSOC);
$arr['user_games'] = $user_games;

echo json_encode($arr);
?>