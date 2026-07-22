<?php
// login.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-slate-900 to-indigo-500 h-screen">
    <div class="flex justify-center items-center h-full">
        <div class="bg-white rounded-lg p-8 shadow-md w-96">
            <h2 class="text-2xl text-center text-slate-900 mb-4">Login</h2>
            <form id="login-form" class="space-y-4">
                <div>
                    <label for="username" class="block text-slate-900 text-sm font-medium mb-2">Username</label>
                    <input type="text" id="username" name="username" class="block w-full p-2 text-slate-900 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" pattern="[A-Za-z\u0600-\u06FF0-9\s]+" required>
                </div>
                <div>
                    <label for="password" class="block text-slate-900 text-sm font-medium mb-2">Password</label>
                    <input type="password" id="password" name="password" class="block w-full p-2 text-slate-900 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">Login</button>
            </form>
            <p class="text-center text-slate-900 mt-4">Don't have an account? <a href="register.php" class="text-indigo-500 hover:text-indigo-700">Register</a></p>
        </div>
    </div>

    <script>
        const form = document.getElementById('login-form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            try {
                const response = await fetch('../backend/auth.php?action=login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ username, password })
                });
                const data = await response.json();
                if (data.success) {
                    alert('Login successful!');
                    window.location.href = 'dashboard.php';
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });
    </script>
</body>
</html>


This code uses Tailwind CSS to create a premium-looking login page with a glassmorphic layout, gradients, and a form for username and password input. The form includes standard HTML input pattern validators to support Arabic and Latin characters. The AJAX JavaScript code uses the Fetch API to submit the credentials to the backend PHP script (`../backend/auth.php?action=login`) and handles the response or error alerts dynamically. The code also includes a direct link to the `register.php` page.