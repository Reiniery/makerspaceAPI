<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

header('Content-Type: application/json');

header("Access-Control-Allow-Methods: *");

header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$host ="localhost";
$dbusername = "alumni";
$dbpassword = "alumni12";
$database ="alumni";
try{
   $pdo = new pdo('mysql:dbname='.$database.";host=".$host.";",$dbusername,$dbpassword); 
}catch(PDOException $e){
die('Connection Failed'. $e->getMessage());
}
