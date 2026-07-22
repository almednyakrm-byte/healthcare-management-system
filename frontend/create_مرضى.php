<?php
// Start session
session_start();

// Session validation
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Include database connection
include '../backend/db.php';

// Module slug
$mod_slug = 'مرضى';

// Page title
$page_title = 'Add New مرضى';
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="max-w-5xl mx-auto p-4 sm:p-6 md:p-8">
        <h1 class="text-3xl text-slate-900 font-bold mb-4"><?php echo $page_title; ?></h1>
        <form id="create-form">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-slate-900">اسم المريض</label>
                <input type="text" id="name" name="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-slate-900">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-slate-900">رقم الهاتف</label>
                <input type="text" id="phone" name="phone" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-slate-900">العنوان</label>
                <input type="text" id="address" name="address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="medical_history" class="block text-sm font-medium text-slate-900">التاريخ الطبي</label>
                <textarea id="medical_history" name="medical_history" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>
            <button type="submit" class="py-2 px-4 bg-indigo-500 text-white rounded-md hover:bg-indigo-700">إضافة</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#create-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '../backend/مرضى.php',
                    data: $(this).serialize(),
                    success: function() {
                        window.location.href = 'list_<?php echo $mod_slug; ?>.php';
                    }
                });
            });
        });
    </script>
</body>
</html>