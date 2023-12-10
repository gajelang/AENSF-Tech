<?php
include 'connect.php';

$sqlEventSlider = "SELECT * FROM event ORDER BY id_event DESC LIMIT 7"; // Sesuaikan kueri sesuai kebutuhan
$resultEventSlider = $conn->query($sqlEventSlider);

if ($resultEventSlider->num_rows > 0) {
    while ($row = $resultEventSlider->fetch_assoc()) {
        echo '<div class="eventslide">';
        echo '<img src="' . $row['gambar'] . '" alt="' . $row['judul'] . '">';
        echo '</div>';
    }
} else {
    echo "No events available.";
}

$conn->close();
?>