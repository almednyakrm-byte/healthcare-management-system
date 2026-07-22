<?php
session_start();

// Check if user is authenticated
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
    <title>نظام إدارة صحي</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .glassmorphism-card {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="flex justify-between items-center p-4 bg-slate-900 text-white">
        <h1 class="text-3xl font-bold">نظام إدارة صحي</h1>
        <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded" onclick="location.href='logout.php'">تسجيل خروج</button>
    </div>
    <div class="flex justify-center items-center p-4 bg-slate-900 text-white">
        <h1 class="text-2xl font-bold">مرحباً بكم في نظام إدارة صحي</h1>
    </div>
    <div class="flex justify-center items-center p-4 bg-slate-900 text-white">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php
            // Fetch stats dynamically via Javascript API calls from the backend files
            $stats = json_decode(file_get_contents('stats.json'), true);
            ?>
            <div class="glassmorphism-card bg-white text-slate-900 p-4">
                <h2 class="text-lg font-bold">إحصائيات</h2>
                <p>عدد المرضى: <?= $stats['patients'] ?></p>
                <p>عدد الأطباء: <?= $stats['doctors'] ?></p>
                <p>عدد الأدوية: <?= $stats['medicines'] ?></p>
            </div>
            <div class="glassmorphism-card bg-white text-slate-900 p-4">
                <h2 class="text-lg font-bold">إحصائيات</h2>
                <p>عدد المرضى: <?= $stats['patients'] ?></p>
                <p>عدد الأطباء: <?= $stats['doctors'] ?></p>
                <p>عدد الأدوية: <?= $stats['medicines'] ?></p>
            </div>
            <div class="glassmorphism-card bg-white text-slate-900 p-4">
                <h2 class="text-lg font-bold">إحصائيات</h2>
                <p>عدد المرضى: <?= $stats['patients'] ?></p>
                <p>عدد الأطباء: <?= $stats['doctors'] ?></p>
                <p>عدد الأدوية: <?= $stats['medicines'] ?></p>
            </div>
        </div>
    </div>
    <div class="flex justify-center items-center p-4 bg-slate-900 text-white">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="patients.php" class="glassmorphism-card bg-white text-slate-900 p-4 hover:bg-indigo-500 hover:text-white">
                <h2 class="text-lg font-bold">مرضى</h2>
            </a>
            <a href="doctors.php" class="glassmorphism-card bg-white text-slate-900 p-4 hover:bg-indigo-500 hover:text-white">
                <h2 class="text-lg font-bold">فريق طبي</h2>
            </a>
            <a href="medicines.php" class="glassmorphism-card bg-white text-slate-900 p-4 hover:bg-indigo-500 hover:text-white">
                <h2 class="text-lg font-bold">مخزون الأدوية</h2>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May'],
                datasets: [{
                    label: 'Number of Patients',
                    data: [<?= $stats['patients'] ?>, <?= $stats['patients'] ?>, <?= $stats['patients'] ?>, <?= $stats['patients'] ?>, <?= $stats['patients'] ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>


Note: You need to replace `stats.json` with your actual API endpoint that returns the stats data.

Also, you need to create a `logout.php` file that handles the logout functionality.

This code uses Tailwind CSS for styling and Chart.js for creating a bar chart. You need to include the Chart.js library in your HTML file.

Make sure to adjust the code according to your project's requirements and structure.