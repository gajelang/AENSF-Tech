<!-- edit_event_form.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="styleeditevent.css" />
</head>

<body>
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
            $event_title = $row['judul'];
            $event_date = $row['tanggal_event'];
            $event_location = $row['lokasi'];
            $event_description = $row['deskripsi'];

            // Get existing ticket types for the event
            $ticketQuery = "SELECT id_harga, jenis_tiket, harga FROM harga_tiket WHERE id_event = '$event_id'";
            $ticketResult = mysqli_query($conn, $ticketQuery);
            $existingTicketTypes = array();
            while ($ticket = mysqli_fetch_assoc($ticketResult)) {
                $existingTicketTypes[] = $ticket;
            }

            // Display the form with pre-filled values for editing
            echo '<div class="edit-event-container">';
            echo '<h2>Edit Event</h2>';
            echo '<form action="update_event.php" method="post" enctype="multipart/form-data">';
            echo '<input type="hidden" name="event_id" value="' . $event_id . '">';

            echo '<label for="eventTitle">Event Title:</label>';
            echo '<input type="text" id="eventTitle" name="eventTitle" value="' . $event_title . '" required>';

            echo '<label for="eventDate">Event Date:</label>';
            echo '<input type="date" id="eventDate" name="eventDate" value="' . $event_date . '" required>';

            echo '<label for="eventLocation">Event Location:</label>';
            echo '<input type="text" id="eventLocation" name="eventLocation" value="' . $event_location . '" required>';

            echo '<label for="eventDescription">Event Description:</label>';
            echo '<textarea id="eventDescription" name="eventDescription" rows="4" required>' . $event_description . '</textarea>';

            // Display existing ticket types for editing
            echo '<label for="ticketTypes">Existing Ticket Types:</label>';
            echo '<ul>';
            foreach ($existingTicketTypes as $ticketType) {
                echo '<li>';
                echo $ticketType['jenis_tiket'] . ' - ' . $ticketType['harga'];
                echo '<a href="edit_ticket.php?id_harga=' . $ticketType['id_harga'] . '&id_event=' . $event_id . '">Edit</a>';
                echo '</li>';
            }
            echo '</ul>';

            echo '<button type="submit">Save Changes</button>';

            // Add the delete button here
            echo '<a href="delete_event.php?id_event=' . $event_id . '" class="delete-button">Delete Event</a>';

            echo '</form>';
            echo '</div>';
        } else {
            echo "Event not found.";
        }
    } else {
        echo "Event ID not specified.";
    }

    mysqli_close($conn);
    ?>
</body>

</html>