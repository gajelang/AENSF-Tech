<?php
// Mulai sesi atau lanjutkan sesi yang sudah ada
session_start();

// Hapus semua variabel sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit();
?>