<!-- update_event.php -->
<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $event_title = $_POST['eventTitle'];
    $event_date = $_POST['eventDate'];
    $event_location = $_POST['eventLocation'];
    $event_description = $_POST['eventDescription'];

    // Perform update query
    $update_query = "UPDATE event SET judul='$event_title', tanggal_event='$event_date', 
                     lokasi='$event_location', deskripsi='$event_description' WHERE id_event='$event_id'";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        echo "Event details updated successfully.";
    } else {
        echo "Error updating event details: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>