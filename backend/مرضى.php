<?php

require_once 'db.php';

// Get user data from session
$userData = $_SESSION['userData'];

// Check if user is logged in
if (!isset($userData['id'])) {
    http_response_code(401);
    echo json_encode(array('error' => 'Unauthorized'));
    exit;
}

// Get input data
$inputData = json_decode(file_get_contents('php://input'), true);

// Validate input data
if (!isset($inputData['id']) && !isset($inputData['name']) && !isset($inputData['age']) && !isset($inputData['email'])) {
    http_response_code(400);
    echo json_encode(array('error' => 'Invalid request'));
    exit;
}

// Sanitize input data
$inputData['name'] = htmlspecialchars($inputData['name']);
$inputData['age'] = (int)$inputData['age'];
$inputData['email'] = filter_var($inputData['email'], FILTER_VALIDATE_EMAIL);

// Check if user is admin
if ($userData['role'] !== 'admin' && (isset($inputData['id']) || isset($inputData['action']) && in_array($inputData['action'], array('update', 'delete')))) {
    http_response_code(403);
    echo json_encode(array('error' => 'Forbidden'));
    exit;
}

// Handle GET request
if (isset($_GET['action']) && $_GET['action'] === 'get') {
    $stmt = $pdo->prepare('SELECT * FROM مرضى');
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Handle POST request
if (isset($_GET['action']) && $_GET['action'] === 'create') {
    $stmt = $pdo->prepare('INSERT INTO مرضى (name, age, email) VALUES (:name, :age, :email)');
    $stmt->bindParam(':name', $inputData['name']);
    $stmt->bindParam(':age', $inputData['age']);
    $stmt->bindParam(':email', $inputData['email']);
    $stmt->execute();
    http_response_code(201);
    echo json_encode(array('message' => 'Created successfully'));
    exit;
}

// Handle PUT request
if (isset($_GET['action']) && $_GET['action'] === 'update') {
    $stmt = $pdo->prepare('UPDATE مرضى SET name = :name, age = :age, email = :email WHERE id = :id');
    $stmt->bindParam(':id', $inputData['id']);
    $stmt->bindParam(':name', $inputData['name']);
    $stmt->bindParam(':age', $inputData['age']);
    $stmt->bindParam(':email', $inputData['email']);
    $stmt->execute();
    http_response_code(200);
    echo json_encode(array('message' => 'Updated successfully'));
    exit;
}

// Handle DELETE request
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $stmt = $pdo->prepare('DELETE FROM مرضى WHERE id = :id');
    $stmt->bindParam(':id', $inputData['id']);
    $stmt->execute();
    http_response_code(200);
    echo json_encode(array('message' => 'Deleted successfully'));
    exit;
}

http_response_code(404);
echo json_encode(array('error' => 'Not found'));
exit;