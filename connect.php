<?php
$servernameku = "localhost";
$username = "root";
$dbname = "aensf";
$password = "root";

// Create connection
$conn = new mysqli($servernameku, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get user data by user ID
function getUserById($conn, $userId) {
    $sql = "SELECT * FROM users WHERE user_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Function to update user data
function updateUser($conn, $userId, $newData) {
    $username = $newData['username'];
    $email = $newData['email'];
    $tanggal_lahir = $newData['tanggal_lahir'];
    $phone_number = $newData['phone_number'];
    $instagram = $newData['instagram'];

    $sql = "UPDATE users SET 
            username = '$username',
            email = '$email',
            tanggal_lahir = '$tanggal_lahir',
            phone_number = '$phone_number',
            instagram = '$instagram'
            WHERE user_id = $userId";

    if ($conn->query($sql) === TRUE) {
        // Update successful
        echo "Record updated successfully";
    } else {
        // Error updating record
        echo "Error updating record: " . $conn->error;
    }
}
?>