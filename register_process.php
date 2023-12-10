<?php
include 'connect.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate if passwords match
    if ($password !== $confirm_password) {
        echo '<script>alert("Passwords do not match."); window.history.back();</script>';
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email format."); window.history.back();</script>';
        exit();
    }

    // You can add more validation for username and email as needed

    // Check if the username is already taken
    $check_username = "SELECT * FROM users WHERE username = '$username'";
    $result_username = $conn->query($check_username);

    if ($result_username->num_rows > 0) {
        echo '<script>alert("Username is already taken. Please choose another username."); window.history.back();</script>';
        exit();
    }

    // Check if the email is already registered
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result_email = $conn->query($check_email);

    if ($result_email->num_rows > 0) {
        echo '<script>alert("Email is already registered. Please use a different email address."); window.history.back();</script>';
        exit();
    }

    // Insert user data into the database without hashing
    $insert_user = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($insert_user) === TRUE) {
        echo '<script>alert("Registration successful. You can now log in."); window.location.href = "login.php";</script>';
        exit();
    } else {
        echo "Error: " . $insert_user . "<br>" . $conn->error;
    }
}

$conn->close();
?>