<?php
session_start();

include '../../inc/dbConnection.php';
$conn = getDatabaseConnection("nfl_picks");

$arr = array();

$sql1 = "SELECT * FROM user_games ORDER BY username";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute();
$user_games = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$arr['user_games'] = $user_games;

$sql2 = "SELECT * FROM users ORDER BY username";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute();
$users = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$arr['users'] = $users;

echo json_encode($arr);
?>