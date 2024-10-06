<?php
require 'connection.php';


$sql = 'SHOW TABLES';
$stmt = $pdo->prepare($sql);

$stmt->execute();
$tables = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($tables);