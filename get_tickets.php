<?php
// Mulai sesi atau lanjutkan sesi yang sudah ada
session_start();

// Pemeriksaan apakah user_id sudah ada di dalam sesi
if (!isset($_SESSION['user_id'])) {
    // Jika user_id tidak ditemukan, mungkin perlu melakukan tindakan tertentu
    // seperti mengarahkan pengguna ke halaman login
    echo '<script>alert("Silakan login terlebih dahulu."); window.location.href = "login.php";</script>';
    exit();
}

$user_id = $_SESSION['user_id'];

// Include your database connection file here
include('connect.php');

// Fetch ticket information including event details from the database based on the user_id
$query = "SELECT tp.id, tp.event_id, tp.ticket_type, tp.quantity, tp.purchase_date, e.judul, e.tanggal_event, e.gambar
          FROM ticket_purchases tp
          JOIN event e ON tp.event_id = e.id_event
          WHERE tp.user_id = $user_id";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

// Close the database connection
mysqli_close($conn);

// Include the HTML file
include('mytickets.php');
?>