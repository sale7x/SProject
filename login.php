<?php

include 'config.php';
session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h1>Login</h1>
<form method="post" action="login.php">
    <label>Username or Email:</label>
    <input type="text" name="username_email" required><br>

    <label>Password:</label>
    <input type="password" name="password" required><br>

    <input type="submit" name="submit" value="Login">
</form>

<a href="register.php">Register</a>

<?php
if (isset($_POST['submit'])) {
    $username_email = $_POST['username_email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['id'];
            header('Location: index.php');
            echo "<p>Login successful. Welcome, " . $user['username'] . "!</p>";
        } else {
            echo "<p>Incorrect password.</p>";
        }
    } else {
        echo "<p>User not found.</p>";
    }
}
?>
</body>
</html>