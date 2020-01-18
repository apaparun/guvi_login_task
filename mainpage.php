<?php
session_start();
echo htmlspecialchars($_SESSION["email"]);
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>