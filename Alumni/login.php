<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: *");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
require 'connection.php';
session_start();



$input = json_decode(file_get_contents('php://input'),true);
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
//assign email/pw
$email = $input['email'];
$password = $input['password'];

//create sql to check if email and password match
$sql = "SELECT * FROM access WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch();


if ($user && $password === $user['password']) {
    $_SESSION['email']= $email;
    $_SESSION['logged_in']= true;
    http_response_code(201);

} else {
    http_response_code(203);

}













