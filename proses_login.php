<?php
session_start();
include 'connect.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password_form = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $db_password = $row['password'];

        if ($password_form == $db_password) { // Saat menggunakan password yang belum dienkripsi
            // Password cocok, lakukan proses login.
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $username;

            // Check if the user is admin
            if ($username == "admin" && $password_form == "admin") {
                // Redirect to events_manager.php for admin
                header("Location: events_manager.php");
                exit();
            } else {
                // Redirect to main.php for regular users
                header("Location: main.php");
                exit();
            }
        } else {
            // Password tidak cocok, tampilkan pesan kesalahan.
            echo '<script>alert("Password salah."); window.history.back();</script>';
            exit();
        }
    } else {
        // User tidak ditemukan, tampilkan pesan kesalahan.
        echo '<script>alert("Username tidak ditemukan."); window.history.back();</script>';
        exit();
    }
}

$conn->close();
?>