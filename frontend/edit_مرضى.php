**edit_مرضى.php**

<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

// Get ID from URL
$id = $_GET['id'];

// Fetch existing record details
$url = '../backend/مرضى.php?id=' . $id;
$response = file_get_contents($url);
$data = json_decode($response, true);

// Check if record exists
if (empty($data)) {
    echo 'Record not found!';
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit مرضى</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-md mx-auto p-4 bg-white rounded-md shadow-md">
        <h2 class="text-slate-900 text-lg font-bold mb-4">Edit مرضى</h2>
        <form id="edit-form">
            <div class="mb-4">
                <label for="name" class="block text-slate-900 text-sm font-bold mb-2">Name:</label>
                <input type="text" id="name" name="name" class="w-full p-2 text-slate-900 border border-slate-300 rounded-md" value="<?= $data['name'] ?>">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-slate-900 text-sm font-bold mb-2">Description:</label>
                <textarea id="description" name="description" class="w-full p-2 text-slate-900 border border-slate-300 rounded-md"><?= $data['description'] ?></textarea>
            </div>
            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md">Save Changes</button>
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
                    url: '../backend/مرضى.php',
                    data: formData,
                    success: function(response) {
                        window.location.href = 'list_مرضى.php';
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr, status, error);
                    }
                });
            });
        });
    </script>
</body>
</html>


**backend/مرضى.php**

<?php
// Check if ID is set
if (!isset($_GET['id'])) {
    http_response_code(400);
    exit;
}

// Get ID from URL
$id = $_GET['id'];

// Check if ID is valid
if (!is_numeric($id)) {
    http_response_code(400);
    exit;
}

// Fetch existing record details
$query = "SELECT * FROM مرضى WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Check if record exists
if (empty($data)) {
    http_response_code(404);
    exit;
}

// Update record
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents('php://input'), $updateData);
    $updateData['id'] = $id;
    $query = "UPDATE مرضى SET name = ?, description = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $updateData['name'], $updateData['description'], $updateData['id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    http_response_code(200);
    exit;
}

// Return existing record details
header('Content-Type: application/json');
echo json_encode($data);
exit;
?>