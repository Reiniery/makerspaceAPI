<?php
require "connection.php";
$input = json_decode(file_get_contents('php://input'), true);

        $table = 'graduates' ?? '';
        // Fetch all users

        $allowed_tables= ['graduates'];
        if (!in_array($table, $allowed_tables)) {
            echo json_encode(['error' => 'Invalid table name']);
             // Bad Request
            exit;}
        
        $sql = "SELECT * FROM $table";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        // Fetch the results
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Return the result as JSON
        echo "const data =".json_encode($users);
        