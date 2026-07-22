**create_فريق-طبي.php**

<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

// Include database connection
require_once '../config/db.php';

// Check if form has been submitted
if (isset($_POST['submit'])) {
    // Validate form data
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $specialty = trim($_POST['specialty']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    // Check for empty fields
    if (empty($name) || empty($description) || empty($specialty) || empty($phone) || empty($email)) {
        $error = 'Please fill in all fields';
    } else {
        // Insert data into database
        $query = "INSERT INTO فريق_طبي (name, description, specialty, phone, email) VALUES ('$name', '$description', '$specialty', '$phone', '$email')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Redirect back to list page
            header('Location: list_فريق-طبي.php');
            exit;
        } else {
            $error = 'Error inserting data';
        }
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة فريق طبي</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
        }
        .bg-slate-900 {
            background-color: #1a1a1a !important;
        }
        .text-indigo-500 {
            color: #6b5f7e !important;
        }
    </style>
</head>
<body class="bg-slate-900">
    <div class="container mx-auto p-4 md:p-6 lg:p-8">
        <h1 class="text-3xl text-indigo-500 font-bold mb-4">إضافة فريق طبي</h1>
        <form id="create-form" class="bg-white rounded shadow-md p-4 md:p-6 lg:p-8">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">اسم الفريق</label>
                <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="اسم الفريق">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">وصف الفريق</label>
                <textarea id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="وصف الفريق"></textarea>
            </div>
            <div class="mb-4">
                <label for="specialty" class="block text-gray-700 text-sm font-bold mb-2">الاختصاص</label>
                <input type="text" id="specialty" name="specialty" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="الاختصاص">
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">رقم الهاتف</label>
                <input type="tel" id="phone" name="phone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="رقم الهاتف">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="البريد الإلكتروني">
            </div>
            <button type="submit" id="submit-btn" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">إضافة</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#create-form').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: '../backend/فريق-طبي.php',
                    data: formData,
                    success: function(response) {
                        if (response == 'success') {
                            window.location.href = 'list_فريق-طبي.php';
                        } else {
                            alert('Error adding data');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>

**backend/فريق-طبي.php**

<?php
// Include database connection
require_once '../config/db.php';

// Check if form data has been posted
if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['specialty']) && isset($_POST['phone']) && isset($_POST['email'])) {
    // Insert data into database
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $specialty = trim($_POST['specialty']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    $query = "INSERT INTO فريق_طبي (name, description, specialty, phone, email) VALUES ('$name', '$description', '$specialty', '$phone', '$email')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'success';
    } else {
        echo 'Error adding data';
    }
}

// Close database connection
mysqli_close($conn);
?>