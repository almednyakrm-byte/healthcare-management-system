<!-- register.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 10px;
        }
        .form-group input {
            width: 100%;
            height: 40px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input:focus {
            border-color: #aaa;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .btn {
            width: 100%;
            height: 40px;
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .error {
            color: #f00;
            font-size: 12px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="title">Register</h2>
        <form id="register-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required pattern="[A-Za-z\u0600-\u06FF0-9\s]+">
                <div class="error" id="username-error"></div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <div class="error" id="email-error"></div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required pattern="[A-Za-z0-9!@#$%^&*()_+=-{};:'<>,./?]+">
                <div class="error" id="password-error"></div>
            </div>
            <button class="btn" type="submit">Register</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#register-form').submit(function(e) {
                e.preventDefault();
                var username = $('#username').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var error = false;

                if (!username.match(pattern)) {
                    $('#username-error').text('Invalid username. Only letters, numbers, and spaces are allowed.');
                    error = true;
                } else {
                    $('#username-error').text('');
                }

                if (!email.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)) {
                    $('#email-error').text('Invalid email address.');
                    error = true;
                } else {
                    $('#email-error').text('');
                }

                if (!password.match(pattern)) {
                    $('#password-error').text('Invalid password. Only letters, numbers, and special characters are allowed.');
                    error = true;
                } else {
                    $('#password-error').text('');
                }

                if (!error) {
                    $.ajax({
                        type: 'POST',
                        url: '../backend/auth.php?action=register',
                        data: {
                            username: username,
                            email: email,
                            password: password
                        },
                        success: function(response) {
                            if (response == 'success') {
                                alert('Registration successful. Please login to continue.');
                                window.location.href = 'login.php';
                            } else {
                                alert('Registration failed. Please try again.');
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>


Note: The `pattern` variable is not defined in the code. You need to define it before using it. Also, the `backend/auth.php` file should be created and the `register` action should be implemented to handle the registration process.