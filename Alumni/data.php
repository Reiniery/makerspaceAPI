<?php
require "connection.php";
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);
//check if it is trying to get content


error_reporting(E_ERROR | E_PARSE);

switch ($method) {
    //retrieve data from db
    case 'GET':
        $input = json_decode(file_get_contents('php://input'), true);
        $table = $_GET['table'] ?? '';  
        $allowed_tables= ['graduates'];
        if (!in_array($table, $allowed_tables)) {
            echo json_encode(['error' => 'Invalid table name']);
            exit;}
        // Fetch all users
        $sql = "SELECT * FROM $table";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        // Fetch the results
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users); // Return the result as JSON
        break;
    //insert into db
    case 'POST':
        //assign content from page to variable
        $name = $input['name'];
        $jobTitle = $input['jobTitle'];
        $employer = $input['employer'];
        $imageURL = $input['imageURL'];
        $linkedinURL = $input['linkedinURL'];
        $major = $input['major'];
        $gradYear = $input['gradYear'];

        //inserting the information into the table
        $sql = "INSERT INTO graduates (name, jobTitle, employer, imageURL, linkedinURL, major, gradYear) VALUES (:name, :jobTitle, :employer, :imageURL, :linkedinURL, :major, :gradYear);";
        //$sql = "INSERT INTO graduates (name) VALUES (:name)";
        $stmt = $pdo->prepare($sql);

        //will change values inside sql 
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':jobTitle', $jobTitle);
        $stmt->bindParam(':employer', $employer);
        $stmt->bindParam(':imageURL', $imageURL);
        $stmt->bindParam(':linkedinURL', $linkedinURL);
        $stmt->bindParam(':major', $major);
        $stmt->bindParam(':gradYear', $gradYear);
        $stmt->execute();
        http_response_code(201);
        break;
    //delete from db
    case 'DELETE':
        $table = $_GET['table'] ?? '';
        $id = $_GET['id'] ?? '';
        $sql = "DELETE FROM $table WHERE id =$id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        break;
    //update db 
    case 'PUT':
        // Get parameters from the query string
        $input = json_decode(file_get_contents('php://input'), true);
        $table = $input['table'] ?? '';
        $name = $input['name']??'';
        $jobTitle = $input['jobTitle'] ?? '';
        $employer = $input['employer'] ?? '';
        $imageURL = $input['imageURL'] ?? '';
        $linkedinURL = $input['linkedinURL'] ?? '';
        $major = $input['major'] ?? '';
        $gradYear =$input['gradYear'] ?? '';
        $id = $input['id'] ?? ''; // Ensure you have an ID for the WHERE clause

        // Prepare the SQL statement with placeholders
        $sql = "UPDATE $table
        SET name = :name, jobTitle = :jobTitle, employer = :employer, 
            imageURL = :imageURL, linkedinURL = :linkedinURL, 
            major = :major, gradYear = :gradYear
        WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        // Bind parameters to prevent SQL injection
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':jobTitle', $jobTitle);
        $stmt->bindParam(':employer', $employer);
        $stmt->bindParam(':imageURL', $imageURL);
        $stmt->bindParam(':linkedinURL', $linkedinURL);
        $stmt->bindParam(':major', $major);
        $stmt->bindParam(':gradYear', $gradYear);
        $stmt->bindParam(':id', $id); // Bind the ID for the WHERE clause
        // Execute the statement
        $stmt->execute();
        http_response_code(201);


}

