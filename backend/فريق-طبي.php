<?php

require_once 'db.php';

// Get user role and authentication status
$userRole = $_SESSION['userRole'];
$authStatus = $_SESSION['authStatus'];

// Check if user is logged in and authorized
if (!$authStatus || ($userRole != 'admin' && $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'DELETE')) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

// Get input data
$inputData = json_decode(file_get_contents('php://input'), true);

// Validate input data
if (!$inputData) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input data']);
    exit;
}

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        // Prepare SQL query
        $stmt = $pdo->prepare('SELECT * FROM فريق_طبي');
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Output data
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($data);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}

// Handle POST request
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Validate input data
        $requiredFields = ['name', 'description'];
        foreach ($requiredFields as $field) {
            if (!isset($inputData[$field]) || empty($inputData[$field])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                exit;
            }
        }
        
        // Sanitize input data
        $inputData['name'] = trim($inputData['name']);
        $inputData['description'] = trim($inputData['description']);
        
        // Prepare SQL query
        $stmt = $pdo->prepare('INSERT INTO فريق_طبي (name, description) VALUES (:name, :description)');
        $stmt->bindParam(':name', $inputData['name']);
        $stmt->bindParam(':description', $inputData['description']);
        $stmt->execute();
        
        // Output data
        http_response_code(201);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Team created successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}

// Handle PUT request
elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    try {
        // Validate input data
        $requiredFields = ['id', 'name', 'description'];
        foreach ($requiredFields as $field) {
            if (!isset($inputData[$field]) || empty($inputData[$field])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                exit;
            }
        }
        
        // Sanitize input data
        $inputData['name'] = trim($inputData['name']);
        $inputData['description'] = trim($inputData['description']);
        
        // Prepare SQL query
        $stmt = $pdo->prepare('UPDATE فريق_طبي SET name = :name, description = :description WHERE id = :id');
        $stmt->bindParam(':id', $inputData['id']);
        $stmt->bindParam(':name', $inputData['name']);
        $stmt->bindParam(':description', $inputData['description']);
        $stmt->execute();
        
        // Output data
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Team updated successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}

// Handle DELETE request
elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    try {
        // Validate input data
        if (!isset($inputData['id']) || empty($inputData['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required field: id']);
            exit;
        }
        
        // Prepare SQL query
        $stmt = $pdo->prepare('DELETE FROM فريق_طبي WHERE id = :id');
        $stmt->bindParam(':id', $inputData['id']);
        $stmt->execute();
        
        // Output data
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Team deleted successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}

// Output error message for invalid request method
else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
}