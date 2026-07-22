**edit_مخزون-الأدوية.php**

<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Get ID from URL
$id = $_GET['id'];

// Fetch existing record details
$record = json_decode(file_get_contents('../backend/مخزون-الأدوية.php?id=' . $id), true);

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل مخزون الأدوية</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-md mx-auto p-4 bg-white rounded-md shadow-md">
        <h2 class="text-slate-900 text-lg font-bold mb-4">تعديل مخزون الأدوية</h2>
        <form id="edit-form" class="space-y-4">
            <div>
                <label for="name" class="text-slate-900 block text-sm font-bold mb-2">اسم المخزون:</label>
                <input type="text" id="name" name="name" class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="<?= $record['name'] ?>">
            </div>
            <div>
                <label for="quantity" class="text-slate-900 block text-sm font-bold mb-2">الكمية:</label>
                <input type="number" id="quantity" name="quantity" class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="<?= $record['quantity'] ?>">
            </div>
            <div>
                <label for="expiration_date" class="text-slate-900 block text-sm font-bold mb-2">تاريخ الانتهاء:</label>
                <input type="date" id="expiration_date" name="expiration_date" class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="<?= $record['expiration_date'] ?>">
            </div>
            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md">تعديل</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#edit-form').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'PUT',
                    url: '../backend/مخزون-الأدوية.php',
                    data: formData,
                    success: function(response) {
                        if (response === 'success') {
                            window.location.href = 'list_<?= $_SESSION['mod_slug'] ?>.php';
                        } else {
                            alert('Error updating record');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>


**backend/مخزون-الأدوية.php**

<?php
// Check if ID is set
if (!isset($_GET['id'])) {
    exit;
}

// Get ID
$id = $_GET['id'];

// Fetch existing record details
$record = array();
// Assuming you have a database connection and a function to fetch records
// $record = fetch_record($id);

// Return JSON response
echo json_encode($record);