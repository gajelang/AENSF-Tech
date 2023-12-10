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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Detail</title>
    <link rel="stylesheet" href="styleeventdetail.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Archivo:wght@100;200;300;400;500;600;700&family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Work+Sans:wght@100;200;300;400;500;600&display=swap"
        rel="stylesheet">
</head>

<body>
    <!-- NAVBAR -->
    <div class="header">
        <div class="leftside">
            <a href="main.php"><img src="img/fasfest.png" alt=""></a>

            <div class="menu">
                <a href="events.php">Events</a>
                <a href="news.php">News</a>
                <a href="my_ticket.php">My Ticket</a>
            </div>
        </div>

        <div class="rightside">
            <a href="#" class="logout" onclick="confirmLogout()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12 3.25a.75.75 0 0 1 0 1.5a7.25 7.25 0 0 0 0 14.5a.75.75 0 0 1 0 1.5a8.75 8.75 0 1 1 0-17.5Z" />
                    <path fill="currentColor"
                        d="M16.47 9.53a.75.75 0 0 1 1.06-1.06l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H10a.75.75 0 0 1 0-1.5h8.19l-1.72-1.72Z" />
                </svg>
                <span class="logout-text">Logout</span>
            </a>
        </div>
    </div>

    <!-- EVENT DETAIL -->
    <div class="event-detail-container">
        <?php
        include 'connect.php';

        if (isset($_GET['id'])) {
            $event_id = $_GET['id'];

            $sql = "SELECT * FROM event WHERE id_event = $event_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="event-detail-card">';

                    // Bagian gambar (paling atas)
                    echo '<img src="' . $row['gambar'] . '" alt="' . $row['judul'] . '">';

                    // Bagian informasi acara (60%)
                    echo '<div class="eventdescription">'; // <-- Penambahan div baru
                    echo '<div class="event-info">';
                    echo '<h2 class="event-detail-title">' . $row['judul'] . '</h2>';

                    // Mengubah format tanggal
                    $formattedDate = date("j F Y", strtotime($row['tanggal_event']));
                    echo '<p class="event-detail-date">' . $formattedDate . '</p>';
                    echo '<p class="event-detail-description">' . $row['deskripsi'] . '</p>';
                    echo '<p class="event-detail-location">Location: ' . $row['lokasi'] . '</p>';
                    echo '</div>';

                    // Bagian pembelian tiket (40%)
                    echo '<div class="pembeliantiket">'; // <-- Pembungkus div baru
                    echo '<form method="POST" action="proses_pembelian.php">'; // <-- Form untuk sistem pembelian tiket
                    echo '<div class="ticket-options">';
                    $sql_tiket = "SELECT * FROM harga_tiket WHERE id_event = $event_id";
                    $result_tiket = $conn->query($sql_tiket);

                    if ($result_tiket->num_rows > 0) {
                        // Menampilkan jenis tiket dalam bentuk teks
echo '<div class="ticket-info-text">';
echo '<p>Ticket Types and Prices:</p>';
echo '<ul style="list-style-type:none; padding:0;">'; // Tambahkan style untuk menghilangkan dot
while ($row_tiket = $result_tiket->fetch_assoc()) {
    echo '<li>' . $row_tiket['jenis_tiket'] . ' - ' . $row_tiket['harga'] . '</li>';
}
echo '</ul>';
echo '</div>';

                        echo '<div class="SelectType">';
                        echo '<label for="jenis_tiket">Select Ticket Type:</label>';
                        echo '<select name="jenis_tiket">';
                        $result_tiket = $conn->query($sql_tiket); // Reset hasil set
                        while ($row_tiket = $result_tiket->fetch_assoc()) {
                            echo '<option value="' . $row_tiket['jenis_tiket'] . '">' . $row_tiket['jenis_tiket'] . ' - ' . $row_tiket['harga'] . '</option>';
                        }
                        echo '</select>';
                        echo '</div>';

                        echo '<div class="ticketquantity">';
                        echo '<label for="jumlah_beli">Quantity:</label>';
                        echo '<input type="number" name="jumlah_beli" value="1" min="1">';
                        echo '</div>';

                        echo '<input type="hidden" name="event_id" value="' . $event_id . '">';
                        echo '<input type="submit" name="beli_tiket" value="Beli Tiket">';
                    } else {
                        echo '<p>No ticket options available.</p>';
                    }
                    echo '</div>';
                    echo '</form>'; // <-- Penutup form
                    echo '</div>'; // <-- Penutup div baru (pembungkus)
                    echo '</div>';
                    echo '</div>'; // <-- Penutup div baru
                    echo '</div>';
                }
            } else {
                echo "Event not found.";
            }
        } else {
            echo "Invalid event ID.";
        }

        $conn->close();
        ?>
    </div>

    <script>
    function confirmLogout() {
        var confirmLogout = confirm("Are you sure you want to logout?");
        if (confirmLogout) {
            // Jika user mengklik OK, maka arahkan ke halaman logout.php
            window.location.href = "logout.php";
        }
    }
    </script>

</body>

</html>