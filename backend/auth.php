<?php
// Start the session to handle user authentication
session_start();

// Include the database connection file
require_once 'db.php';

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    // If the user is logged in, return a JSON response with their user data
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    echo json_encode($user_data);
    exit;
}

// Check if the user is trying to register
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    // Check if all required fields are present
    if (!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])) {
        echo json_encode(array('error' => 'Missing required fields'));
        exit;
    }

    // Sanitize and validate user input
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    // Check if the username and email are already taken
    $query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(array('error' => 'Username or email already taken'));
        exit;
    }

    // Hash the password using password_hash()
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    $stmt->execute();

    // Return a JSON response with the new user's data
    $user_id = $mysqli->insert_id;
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    echo json_encode($user_data);
    exit;
}

// Check if the user is trying to login
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    // Check if all required fields are present
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        echo json_encode(array('error' => 'Missing required fields'));
        exit;
    }

    // Sanitize and validate user input
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    // Check if the username and password are valid
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    if (!$user_data || !password_verify($password, $user_data['password'])) {
        echo json_encode(array('error' => 'Invalid username or password'));
        exit;
    }

    // Log the user in by setting their user ID in the session
    $_SESSION['user_id'] = $user_data['id'];

    // Return a JSON response with the user's data
    echo json_encode($user_data);
    exit;
}

// Check if the user is trying to logout
if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    // Log the user out by destroying their session
    session_destroy();
    echo json_encode(array('success' => 'Logged out successfully'));
    exit;
}

// If none of the above conditions are met, return a JSON response with an error message
echo json_encode(array('error' => 'Invalid request'));
exit;