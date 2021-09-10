<?php
session_start();
session_destroy();
header("Location: ../8g6TDGxmQP/sign_in.php"); //sends users to login screen if they haven't logged in
?>