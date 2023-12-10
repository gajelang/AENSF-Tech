<!-- delete_event.php -->
<?php
include 'connect.php';

if (isset($_GET['id_event'])) {
    $event_id = $_GET['id_event'];

    // Perform delete query for the event
    $delete_event_query = "DELETE FROM event WHERE id_event='$event_id'";
    $delete_event_result = mysqli_query($conn, $delete_event_query);

    // Perform delete query for related ticket types
    $delete_ticket_query = "DELETE FROM harga_tiket WHERE id_event='$event_id'";
    $delete_ticket_result = mysqli_query($conn, $delete_ticket_query);

    if ($delete_event_result && $delete_ticket_result) {
        echo "Event deleted successfully.";
    } else {
        echo "Error deleting event: " . mysqli_error($conn);
    }
} else {
    echo "Event ID not specified.";
}

mysqli_close($conn);
?>