<?php

require_once 'db.php';

// Get user data from session
$user = $_SESSION['user'];

// Check if user is logged in
if (!$user) {
    http_response_code(401);
    echo json_encode(array('error' => 'Unauthorized'));
    exit;
}

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle GET request
if ($method === 'GET') {
    // Check if user is admin
    if ($user['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode(array('error' => 'Forbidden'));
        exit;
    }

    // Get all medications
    $stmt = $pdo->prepare('SELECT * FROM مخزون_الأدوية');
    $stmt->execute();
    $medications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return medications
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($medications);
}

// Handle POST request
elseif ($method === 'POST') {
    // Get input data
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate input data
    if (!isset($input['اسم_المخزون']) || !isset($input['كمية']) || !isset($input['تاريخ_الاستيراد'])) {
        http_response_code(400);
        echo json_encode(array('error' => 'Invalid request'));
        exit;
    }

    // Sanitize input data
    $name = trim($input['اسم_المخزون']);
    $quantity = (int) $input['كمية'];
    $import_date = date('Y-m-d', strtotime($input['تاريخ_الاستيراد']));

    // Insert medication
    $stmt = $pdo->prepare('INSERT INTO مخزون_الأدوية (اسم_المخزون, كمية, تاريخ_الاستيراد) VALUES (:name, :quantity, :import_date)');
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':import_date', $import_date);
    $stmt->execute();

    // Return success message
    http_response_code(201);
    header('Content-Type: application/json');
    echo json_encode(array('message' => 'Medication added successfully'));
}

// Handle PUT request
elseif ($method === 'PUT') {
    // Check if user is admin
    if ($user['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode(array('error' => 'Forbidden'));
        exit;
    }

    // Get input data
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate input data
    if (!isset($input['id']) || !isset($input['اسم_المخزون']) || !isset($input['كمية']) || !isset($input['تاريخ_الاستيراد'])) {
        http_response_code(400);
        echo json_encode(array('error' => 'Invalid request'));
        exit;
    }

    // Sanitize input data
    $id = (int) $input['id'];
    $name = trim($input['اسم_المخزون']);
    $quantity = (int) $input['كمية'];
    $import_date = date('Y-m-d', strtotime($input['تاريخ_الاستيراد']));

    // Update medication
    $stmt = $pdo->prepare('UPDATE مخزون_الأدوية SET اسم_المخزون = :name, كمية = :quantity, تاريخ_الاستيراد = :import_date WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':import_date', $import_date);
    $stmt->execute();

    // Return success message
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode(array('message' => 'Medication updated successfully'));
}

// Handle DELETE request
elseif ($method === 'DELETE') {
    // Check if user is admin
    if ($user['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode(array('error' => 'Forbidden'));
        exit;
    }

    // Get input data
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate input data
    if (!isset($input['id'])) {
        http_response_code(400);
        echo json_encode(array('error' => 'Invalid request'));
        exit;
    }

    // Sanitize input data
    $id = (int) $input['id'];

    // Delete medication
    $stmt = $pdo->prepare('DELETE FROM مخزون_الأدوية WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Return success message
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode(array('message' => 'Medication deleted successfully'));
}

// Return error message if invalid request method
else {
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed'));
}