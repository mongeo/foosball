<?php
session_start(); //starts or resumes an existing session

//print_r($_POST); //for debugging purposes, display the content of the $_POST array

include '../inc/dbConnection.php';

$conn = getDatabaseConnection("nfl_picks");
if (!( isset($_POST['username']) && isset($_POST['password']) && isset($_POST['cpassword']) && isset($_POST['email']))) {
 echo "Missing input";
 exit;
}

 if ($_POST['password'] != $_POST['cpassword']){
  echo "Error! Passwords do not match.";
  exit;
 }


$sql = "SELECT * FROM users WHERE username = :username";

$namedParameters = array();
$namedParameters[':username'] = $_POST['username'];


$stmt = $conn->prepare($sql);
$stmt->execute($namedParameters);
$record = $stmt->fetchAll(PDO::FETCH_ASSOC); //we are expecting ONLY one record, so we use fetch instead of fetchAll

// print_r($record);
 if (!empty($record)) {
     echo "Username alraedy exists!";
     exit;
 }  else {
    $arr2= array();
    $arr2[":username"] = $_POST['username'];
    $arr2[":password"] = sha1($_POST['password']);
    $arr2[":email"] = $_POST['email'];
    
    $sqlInsert = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
    
    $stmt2 = $conn->prepare($sqlInsert);
    $stmt2->execute($arr2);
    $_SESSION['username'] = $_POST['username'];
    header('Location: ../dash/dash.php'); //redirecting to a new file
}

?>