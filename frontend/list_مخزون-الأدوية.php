**list_مخزون-الأدوية.php**

<?php
// Session validation
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مخزون الأدوية</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }
        .header {
            background-color: #1f2937;
            padding: 1rem;
            text-align: center;
        }
        .header a {
            color: #ffffff;
            text-decoration: none;
        }
        .header a:hover {
            color: #e5e7eb;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 1rem;
            text-align: left;
        }
        .table th {
            background-color: #1f2937;
            color: #ffffff;
        }
        .search-bar {
            width: 50%;
            padding: 1rem;
            font-size: 1.5rem;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
        }
        .search-bar:focus {
            outline: none;
            border-color: #aaa;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php">الرئيسية</a>
        <span class="text-white ml-4">مرحباً <?= $_SESSION['username'] ?></span>
        <a href="logout.php" class="text-white ml-4">تسجيل الخروج</a>
    </div>
    <div class="container mx-auto p-4 mt-4">
        <h1 class="text-3xl font-bold mb-4">مخزون الأدوية</h1>
        <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded" onclick="location.href='create_مخزون-الأدوية.php'">إضافة عنصر جديد</button>
        <div class="flex justify-between items-center mb-4">
            <input type="search" class="search-bar" id="search-input" placeholder="بحث...">
            <button class="bg-slate-900 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded" onclick="searchRecords()">بحث</button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>رقم العنصر</th>
                    <th>اسم العنصر</th>
                    <th>مخزون</th>
                    <th>حذف</th>
                    <th>تعديل</th>
                </tr>
            </thead>
            <tbody id="records-table">
                <!-- Records will be loaded here -->
            </tbody>
        </table>
    </div>

    <script>
        const searchInput = document.getElementById('search-input');
        const recordsTable = document.getElementById('records-table');

        function searchRecords() {
            const searchQuery = searchInput.value.trim();
            fetch('../backend/مخزون-الأدوية.php?search=' + searchQuery)
                .then(response => response.json())
                .then(data => {
                    const recordsHtml = data.map(record => `
                        <tr>
                            <td>${record.id}</td>
                            <td>${record.name}</td>
                            <td>${record.quantity}</td>
                            <td><button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="deleteRecord(${record.id})">حذف</button></td>
                            <td><a href="edit_مخزون-الأدوية.php?id=${record.id}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">تعديل</a></td>
                        </tr>
                    `).join('');
                    recordsTable.innerHTML = recordsHtml;
                });
        }

        function deleteRecord(id) {
            if (confirm('هل أنت متأكد من حذف العنصر؟')) {
                fetch('../backend/مخزون-الأدوية.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        searchRecords();
                    } else {
                        alert('حدث خطأ أثناء الحذف');
                    }
                });
            }
        }

        searchRecords();
    </script>
</body>
</html>

**backend/مخزون-الأدوية.php**

<?php
// Get search query from URL
$searchQuery = $_GET['search'] ?? '';

// Connect to database
$conn = new mysqli('localhost', 'username', 'password', 'database');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get records from database
$stmt = $conn->prepare("SELECT * FROM مخزون_الأدوية");
$stmt->execute();
$result = $stmt->get_result();

// Filter records by search query
if ($searchQuery) {
    $stmt = $conn->prepare("SELECT * FROM مخزون_الأدوية WHERE name LIKE ? OR quantity LIKE ?");
    $stmt->bind_param("ss", "%$searchQuery%", "%$searchQuery%");
    $stmt->execute();
    $result = $stmt->get_result();
}

// Fetch records
$records = array();
while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}

// Close connection
$conn->close();

// Output records in JSON format
echo json_encode($records);
?>

Note: You need to replace the placeholders in the backend code with your actual database credentials and table name.