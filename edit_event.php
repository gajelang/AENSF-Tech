<!-- edit_event.php -->
<?php
include 'connect.php';

// Check if event_id is set in the URL
if (isset($_GET['id_event'])) {
    $event_id = $_GET['id_event'];

    // Fetch event details from the database based on event_id
    $sql = "SELECT * FROM event WHERE id_event = '$event_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $event_id = $row['id_event'];
        $event_title = $row['judul'];
        $event_date = $row['tanggal_event'];
        $event_location = $row['lokasi'];
        $event_description = $row['deskripsi'];
    
        // Display the form with pre-filled values for editing
        include 'edit_event_form.php';
    } else {
        echo "Event not found.";
    }
} else {
    echo "Event ID not specified.";
}