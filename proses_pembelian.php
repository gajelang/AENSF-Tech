<?php
include 'connect.php';

// Start the session or resume an existing one
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Silakan login terlebih dahulu."); window.location.href = "login.php";</script>';
    exit();
}

if (isset($_POST['beli_tiket'])) {
    // Get user information from the session
    $user_id = $_SESSION['user_id'];

    // Get other ticket purchase details
    $event_id = $_POST['event_id'];
    $jenis_tiket = $_POST['jenis_tiket'];
    $jumlah_beli = $_POST['jumlah_beli'];

    // Check the availability of the ticket
    $sql_tiket = "SELECT * FROM harga_tiket WHERE id_event = '$event_id' AND jenis_tiket = '$jenis_tiket' AND jumlah_tersedia >= $jumlah_beli";
    $result_tiket = $conn->query($sql_tiket);

    if ($result_tiket->num_rows > 0) {
        // Fetch ticket information
        $row_tiket = $result_tiket->fetch_assoc();
        $harga_tiket = $row_tiket['harga'];

        // Start a transaction
        $conn->begin_transaction();

        try {
            // Update the available ticket quantity
            $sql_update = "UPDATE harga_tiket SET jumlah_tersedia = jumlah_tersedia - $jumlah_beli WHERE id_event = '$event_id' AND jenis_tiket = '$jenis_tiket'";
            $conn->query($sql_update);

            // Insert the ticket purchase information
            $sql_insert_purchase = "INSERT INTO ticket_purchases (user_id, event_id, id_event, ticket_type, quantity) VALUES ('$user_id', '$event_id', '{$row_tiket['id_event']}', '$jenis_tiket', '$jumlah_beli')";
            $conn->query($sql_insert_purchase);

            // Commit the transaction
            $conn->commit();

            // Notify the user about the successful purchase
            echo '<script>alert("Pembelian berhasil!"); window.location.href = "main.php";</script>';
            exit();
        } catch (Exception $e) {
            // Rollback the transaction on error
            $conn->rollback();

            // Log the error
            error_log("Transaction error: " . $e->getMessage());

            // Notify the user about the failure
            echo '<script>alert("Maaf, terjadi kesalahan dalam pembelian. Silakan coba lagi nanti."); window.history.back();</script>';
            exit();
        }
    } else {
        // Notify the user that the requested ticket is not available
        echo '<script>alert("Maaf, jumlah tiket yang tersedia tidak mencukupi."); window.history.back();</script>';
        exit();
    }
} else {
    // Notify the user about an invalid request
    echo '<script>alert("Invalid request."); window.history.back();</script>';
    exit();
}

// Close the database connection
$conn->close();
?>