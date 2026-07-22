**list_فريق-طبي.php**

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
    <title>فريق طبي</title>
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
            color: #ffffff;
        }
        .table-container {
            max-width: 800px;
            margin: 2rem auto;
        }
        .table-container table {
            border-collapse: collapse;
            width: 100%;
        }
        .table-container table th, .table-container table td {
            border: 1px solid #ddd;
            padding: 1rem;
        }
        .table-container table th {
            background-color: #f0f0f0;
        }
        .search-bar {
            padding: 1rem;
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
        }
        .search-bar input[type="search"] {
            width: 100%;
            padding: 0.5rem;
            border: none;
            border-radius: 0.5rem;
        }
        .search-bar button[type="submit"] {
            background-color: #1f2937;
            color: #ffffff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
        }
        .search-bar button[type="submit"]:hover {
            background-color: #1f2937;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php">الصفحة الرئيسية</a>
        <span class="text-white">مرحباً, <?php echo $_SESSION['username']; ?></span>
        <a href="logout.php" class="text-white">تسجيل الخروج</a>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>اسم الفريق</th>
                    <th>وصف الفريق</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <!-- Table records will be populated here -->
            </tbody>
        </table>
    </div>
    <div class="search-bar">
        <input type="search" id="search-input" placeholder="بحث...">
        <button type="submit" id="search-button">بحث</button>
    </div>
    <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded" onclick="location.href='create_فريق-طبي.php'">إضافة فريق طبي جديد</button>

    <script>
        // Fetch API to get list of records
        fetch('../backend/فريق-طبي.php')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('table-body');
                data.forEach(record => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${record.اسم_الفريق}</td>
                        <td>${record.وصف_الفريق}</td>
                        <td>
                            <a href="edit_فريق-طبي.php?id=${record.id}" class="text-blue-500 hover:text-blue-700">تعديل</a>
                            <button class="text-red-500 hover:text-red-700" onclick="deleteRecord(${record.id})">حذف</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => console.error(error));

        // Search bar functionality
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');
        searchButton.addEventListener('click', () => {
            const searchQuery = searchInput.value.trim();
            if (searchQuery) {
                fetch('../backend/فريق-طبي.php?search=' + searchQuery)
                    .then(response => response.json())
                    .then(data => {
                        const tableBody = document.getElementById('table-body');
                        tableBody.innerHTML = '';
                        data.forEach(record => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${record.اسم_الفريق}</td>
                                <td>${record.وصف_الفريق}</td>
                                <td>
                                    <a href="edit_فريق-طبي.php?id=${record.id}" class="text-blue-500 hover:text-blue-700">تعديل</a>
                                    <button class="text-red-500 hover:text-red-700" onclick="deleteRecord(${record.id})">حذف</button>
                                </td>
                            `;
                            tableBody.appendChild(row);
                        });
                    })
                    .catch(error => console.error(error));
            } else {
                fetch('../backend/فريق-طبي.php')
                    .then(response => response.json())
                    .then(data => {
                        const tableBody = document.getElementById('table-body');
                        tableBody.innerHTML = '';
                        data.forEach(record => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${record.اسم_الفريق}</td>
                                <td>${record.وصف_الفريق}</td>
                                <td>
                                    <a href="edit_فريق-طبي.php?id=${record.id}" class="text-blue-500 hover:text-blue-700">تعديل</a>
                                    <button class="text-red-500 hover:text-red-700" onclick="deleteRecord(${record.id})">حذف</button>
                                </td>
                            `;
                            tableBody.appendChild(row);
                        });
                    })
                    .catch(error => console.error(error));
            }
        });

        // Delete record functionality
        function deleteRecord(id) {
            if (confirm('هل تريد حذف هذا الفريق الطبي؟')) {
                fetch('../backend/فريق-طبي.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('تم حذف الفريق الطبي بنجاح');
                        location.reload();
                    } else {
                        alert('حدث خطأ أثناء حذف الفريق الطبي');
                    }
                })
                .catch(error => console.error(error));
            }
        }
    </script>
</body>
</html>

This code includes the following features:

1.  Session validation: The code checks if the user is authenticated before allowing them to access the page.
2.  Header navigation: The code includes a header with navigation links to the index page, the current user's information, and a logout link.
3.  Table: The code displays a table with a list of records, including the team name, description, and actions (edit and delete).
4.  Search bar: The code includes a search bar that filters the table records in real-time.
5.  AJAX: The code uses the Fetch API to fetch the list of records from the backend and to delete records.
6.  Delete record functionality: The code includes a delete button for each record, which sends a DELETE request to the backend to delete the record.

Note that this code assumes that the backend API is implemented and returns the list of records in JSON format. The code also assumes that the backend API has a DELETE endpoint to delete records.