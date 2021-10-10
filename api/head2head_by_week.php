<?php
session_start();

include '../inc/dbConnection.php';
$conn = getDatabaseConnection("nfl_picks");

$arr = array();

$sql1 = "SELECT game_key,
home_team,
    away_team,
    pick,
    date_time,
    count(pick) as count_num
FROM `user_games`
WHERE NOW() + INTERVAL 3 HOUR >= date_time AND NOW() + INTERVAL 3 HOUR <= date_time + INTERVAL 4 HOUR
GROUP BY game_key, pick;";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute();
$head2head = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$arr['head2head'] = $head2head;

echo json_encode($arr);
?>