<?php
session_start();
require 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Check if the username exists in the database
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Fetch user data
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Store user session
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $user['id'];

                // Redirect with success message
                $_SESSION['login_success'] = "You have successfully logged in!";
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<script>alert('Invalid password. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Username not found. Please sign up.');</script>";
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}
?>
