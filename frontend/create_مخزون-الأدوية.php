**create_مخزون-الأدوية.php**

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
    $quantity = trim($_POST['quantity']);
    $expiration_date = trim($_POST['expiration_date']);

    // Check for empty fields
    if (empty($name) || empty($quantity) || empty($expiration_date)) {
        $error = 'Please fill in all fields';
    } else {
        // Insert data into database
        $sql = "INSERT INTO مخزون_الأدوية (name, quantity, expiration_date) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $quantity, $expiration_date);
        if ($stmt->execute()) {
            // Redirect back to list page
            header('Location: list_مخزون-الأدوية.php');
            exit;
        } else {
            $error = 'Error inserting data';
        }
    }
}

// Include header
require_once '../includes/header.php';

?>

<!-- Page content -->
<div class="container mx-auto p-4 pt-6 md:p-6 lg:p-12 xl:p-12">
    <h1 class="text-3xl font-bold text-slate-900 mb-4">Create New مخزون الأدوية</h1>

    <!-- Form -->
    <form id="create-form" class="bg-white rounded-lg shadow-md p-4" method="POST">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-slate-900">Name:</label>
            <input type="text" id="name" name="name" class="block w-full p-2 pl-10 text-sm text-slate-900 placeholder-slate-400 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter name">
        </div>
        <div class="mb-4">
            <label for="quantity" class="block text-sm font-medium text-slate-900">Quantity:</label>
            <input type="number" id="quantity" name="quantity" class="block w-full p-2 pl-10 text-sm text-slate-900 placeholder-slate-400 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter quantity">
        </div>
        <div class="mb-4">
            <label for="expiration_date" class="block text-sm font-medium text-slate-900">Expiration Date:</label>
            <input type="date" id="expiration_date" name="expiration_date" class="block w-full p-2 pl-10 text-sm text-slate-900 placeholder-slate-400 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter expiration date">
        </div>
        <button type="submit" name="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Create</button>
    </form>
</div>

<!-- Include footer -->
<?php require_once '../includes/footer.php'; ?>

<script>
    // AJAX form submission
    document.getElementById('create-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '../backend/مخزون-الأدوية.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data === 'success') {
                    window.location.href = 'list_مخزون-الأدوية.php';
                } else {
                    alert('Error creating new مخزون الأدوية');
                }
            }
        });
    });
</script>


**مخزون-الأدوية.php (backend)**

<?php
// Include database connection
require_once '../config/db.php';

// Check if form data has been submitted
if (isset($_POST['submit'])) {
    // Validate form data
    $name = trim($_POST['name']);
    $quantity = trim($_POST['quantity']);
    $expiration_date = trim($_POST['expiration_date']);

    // Insert data into database
    $sql = "INSERT INTO مخزون_الأدوية (name, quantity, expiration_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $quantity, $expiration_date);
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'Error inserting data';
    }
}
?>