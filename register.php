<?php

// Start a session to persist data across pages
session_start();

// If user is already logged in, redirect to home page
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit();
}

// Include database configuration
require_once('config.php');

// If form is submitted, process the data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate form data
    $errors = [];

    if (empty($username)) {
        $errors[] = 'Username is required';
    }

    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
    }

    if (empty($password)) {
        $errors[] = 'Password is required';
    }

    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters long';
    }

    // If there are no errors, register the user
    if (empty($errors)) {
        // Check if the email is already taken
        $sql = "SELECT id FROM users WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            $errors[] = 'Email is already taken';
        } else {
            // Insert the new user into the database
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ? )";
            $stmt = $conn->prepare($sql);
            $secured_pass = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("sss", $username, $email, $secured_pass);
            $stmt->execute();

            // If registration is successful, redirect to login page
            if ($stmt->affected_rows === 1) {
                $_SESSION['success'] = 'Registration successful! You can now log in.';
                header('Location: login.php');
                exit();
            } else {
                $errors[] = 'Registration failed. Please try again later.';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
    <h1>Register</h1>
    <?php if (!empty($errors)): ?>
        <ul class="errors">
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($username ?? '') ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Register</button>
    </form>
</div>
</body>
</html>