<!-- update_ticket.php -->
<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_harga = $_POST['id_harga'];
    $id_event = $_POST['id_event'];
    $jenis_tiket = $_POST['jenis_tiket'];
    $harga = $_POST['harga'];

    // Perform update query for the ticket type
    $update_ticket_query = "UPDATE harga_tiket SET jenis_tiket='$jenis_tiket', harga='$harga' 
                            WHERE id_harga='$id_harga' AND id_event='$id_event'";
    $update_ticket_result = mysqli_query($conn, $update_ticket_query);

    if ($update_ticket_result) {
        echo "Ticket details updated successfully.";
    } else {
        echo "Error updating ticket details: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>