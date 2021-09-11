<?php
session_start();

include '../inc/dbConnection.php';
$conn = getDatabaseConnection("nfl_picks");


$game_key = $_GET['game_key'];
$username = $_SESSION['username'];
$league = $_GET['league'];	
$season = $_GET['season'];	
$week = $_GET['week'];
$date_time = $_GET['date_time'];	
$home_team = $_GET['home_team'];	
$away_team= $_GET['away_team'];
$pick = $_GET['pick'];
$user_game_id = $username . "_" . $game_key . "_" . $league;


$arr = array();

$arr[":user_game_id"] = $user_game_id;
$arr[":game_key"] = $game_key;
$arr[":username"] = $username;
$arr[":league"] = $league;
$arr[":season"] = $season;
$arr[":week"] = $week;
$arr[":date_time"] = $date_time;
$arr[":home_team"] = $home_team;
$arr[":away_team"] = $away_team;
$arr[":pick"] = $pick;

$sql = "INSERT INTO user_games (user_game_id, game_key, username, league, season, week, date_time, home_team, away_team, pick ) VALUES (:user_game_id, :game_key, :username, :league, :season, :week, :date_time, :home_team, :away_team, :pick) ON DUPLICATE KEY UPDATE pick = :pick";

$stmt = $conn->prepare($sql);
$stmt->execute($arr);

echo json_encode($pick);
?>