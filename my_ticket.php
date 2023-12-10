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
$query = "SELECT tp.id, tp.id_event, tp.ticket_type, tp.quantity, tp.purchase_date, e.judul, e.tanggal_event, e.gambar
          FROM ticket_purchases tp
          JOIN event e ON tp.id_event = e.id_event
          WHERE tp.user_id = $user_id";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tickets</title>
    <link rel="stylesheet" href="stylemyticket.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Archivo:wght@100;200;300;400;500;600;700&family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Work+Sans:wght@100;200;300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- Add your Google Fonts links here -->
</head>

<body>
    <div class="header">
        <div class="leftside">
            <a href="main.php">
                <img src="img/fasfest.png" alt="">
            </a>

            <div class="menu">
                <a href="events.php" class="eventsmenu">Events</a>
                <a href="news.php" class="newsmenu">News</a>
                <a href="#" class="myticketmenu">My Ticket</a>
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

    <div class="content">
        <p>Your Tickets</p>

        <table>
            <!-- Add a new column header for the button/link -->
            <tr>
                <th>Ticket ID</th>
                <th>Event Title</th>
                <th>Event Date</th>
                <th>Ticket Type</th>
                <th>Quantity</th>
                <th>Purchase Date</th>
                <th>Event Details</th> <!-- New column for the button/link -->
            </tr>

            <?php
// Loop through the results and display ticket information
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['judul'] . "</td>";
    echo "<td>" . $row['tanggal_event'] . "</td>";
    echo "<td>" . $row['ticket_type'] . "</td>";
    echo "<td>" . $row['quantity'] . "</td>";
    echo "<td>" . $row['purchase_date'] . "</td>";

    // Add a button/link to view event details
    echo "<td><a href='event_detail.php?id=" . $row['id_event'] . "'>View Details</a></td>";

    echo "</tr>";
}
?>

        </table>
    </div>
</body>

<script>
function confirmLogout() {
    var confirmLogout = confirm("Are you sure you want to logout?");
    if (confirmLogout) {
        // Jika user mengklik OK, maka arahkan ke halaman logout.php
        window.location.href = "logout.php";
    }
}
</script>

</html>
<?php
// Close the database connection
mysqli_close($conn);
?>