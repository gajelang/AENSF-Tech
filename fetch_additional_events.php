<?php
include 'connect.php';

$sql = "SELECT * FROM event ORDER BY id_event DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="eventscontainer">';

    while ($row = $result->fetch_assoc()) {
        echo '<div class="eventcard">';
        echo '<img src="' . $row['gambar'] . '" alt="' . $row['judul'] . '">';
        echo '<h3 class="event-title">' . $row['judul'] . '</h3>';

        // Mengubah format tanggal
        $formattedDate = date("j F Y", strtotime($row['tanggal_event']));

        echo '<p class="event-date">' . $formattedDate . '</p>';
        echo '<a href="event_detail.php?id=' . $row['id_event'] . '" class="event-button">Buy Ticket</a>';
        echo '</div>';
    }

    echo '</div>';
} else {
    echo "No events available.";
}

$conn->close();
?>