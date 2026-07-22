**edit_فريق-طبي.php**

<?php
// Session validation
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get ID from URL
$id = $_GET['id'];

// Fetch existing record details via GET
$url = '../backend/فريق-طبي.php?id=' . $id;
$response = file_get_contents($url);
$data = json_decode($response, true);

// Check if data exists
if (empty($data)) {
    echo 'Error: Record not found.';
    exit;
}

// Set page title and content
$page_title = 'Edit فريق طبي';
$page_content = '';

// Include header and navigation
include 'header.php';
?>

<!-- Page content -->
<div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-4"><?= $page_title ?></h1>
    <form id="edit-form" class="bg-white rounded-lg shadow-md p-4">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-900">Name:</label>
                <input type="text" id="name" name="name" class="block w-full p-2 mt-1 text-sm text-slate-900 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-500 focus:border-indigo-500" value="<?= $data['name'] ?>">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-slate-900">Description:</label>
                <textarea id="description" name="description" class="block w-full p-2 mt-1 text-sm text-slate-900 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-500 focus:border-indigo-500"><?= $data['description'] ?></textarea>
            </div>
        </div>
        <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Save Changes</button>
    </form>
</div>

<!-- Include footer -->
<?php include 'footer.php'; ?>

<script>
    // Fetch existing record details via GET
    fetch('../backend/فريق-طبي.php?id=<?= $id ?>')
        .then(response => response.json())
        .then(data => {
            // Populate form fields
            document.getElementById('name').value = data.name;
            document.getElementById('description').value = data.description;
        })
        .catch(error => console.error(error));

    // Submit form via AJAX PUT request
    document.getElementById('edit-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch('../backend/فريق-طبي.php', {
            method: 'PUT',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'list_فريق-طبي.php';
                } else {
                    console.error(data.error);
                }
            })
            .catch(error => console.error(error));
    });
</script>


**backend/فريق-طبي.php**

<?php
// Check if ID exists in URL
if (!isset($_GET['id'])) {
    http_response_code(404);
    exit;
}

// Get ID from URL
$id = $_GET['id'];

// Check if ID exists in database
// Replace with your database query
$data = array(
    'id' => $id,
    'name' => 'فريق طبي',
    'description' => 'This is a team of doctors.'
);

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);