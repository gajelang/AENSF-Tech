<?php
// File: create_event.php

// Include the database connection file
include "connect.php";

// Define a variable to store any potential error messages
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Perform your form processing here

    // Example: Fetching values from the form
    $id_event = mysqli_real_escape_string($conn, $_POST["id_event"]);
    $gambar = mysqli_real_escape_string($conn, $_FILES["gambar"]["name"]);
    $judul = mysqli_real_escape_string($conn, $_POST["judul"]);
    $tanggal_event = mysqli_real_escape_string($conn, $_POST["tanggal_event"]);
    $deskripsi = mysqli_real_escape_string($conn, $_POST["deskripsi"]);
    $lokasi = mysqli_real_escape_string($conn, $_POST["lokasi"]);
    $kategori = mysqli_real_escape_string($conn, $_POST["kategori"]);

    // Example: Uploading the event image
    $target_dir = "img/";  // Updated target directory
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);

    // Example: Inserting data into the 'event' table
    $sql_event = "INSERT INTO event (id_event, gambar, judul, tanggal_event, deskripsi, lokasi, kategori)
                  VALUES ('$id_event', '$gambar', '$judul', '$tanggal_event', '$deskripsi', '$lokasi', '$kategori')";

    if ($conn->query($sql_event) === TRUE) {
        // Data berhasil disimpan ke dalam tabel 'event'
        echo "Event data inserted successfully";
    } else {
        // Jika ada kesalahan
        echo "Error: " . $sql_event . "<br>" . $conn->error;
    }

    // Example: Processing ticket information
    if (isset($_POST["jenis_tiket"])) {
        foreach ($_POST["jenis_tiket"] as $key => $value) {
            // Process each ticket type, price, and available tickets
            $jenis_tiket = mysqli_real_escape_string($conn, $_POST["jenis_tiket"][$key]);
            $harga = mysqli_real_escape_string($conn, $_POST["harga"][$key]);
            $jumlah_tersedia = mysqli_real_escape_string($conn, $_POST["jumlah_tersedia"][$key]);

            // Example: Inserting data into the 'harga_tiket' table
            $sql_ticket = "INSERT INTO harga_tiket (id_event, jenis_tiket, harga, jumlah_tersedia)
                           VALUES ('$id_event', '$jenis_tiket', '$harga', '$jumlah_tersedia')";

            if ($conn->query($sql_ticket) !== TRUE) {
                // Jika ada kesalahan
                echo "Error: " . $sql_ticket . "<br>" . $conn->error;
            }
        }
    }

    // You can redirect to another page or display a success message if needed
    // header("Location: success_page.php");
    // exit();
} else {
    // Display an error message if someone tries to access this file directly
    $error_message = "Access denied.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Event</title>
    <link rel="stylesheet" href="stylecreateevent.css">
</head>

<body>
    <div class="container">
        <h2>Upload Event</h2>

        <!-- Event Details -->
        <div class="event-details">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                enctype="multipart/form-data">
                <label for="id_event">Event ID:</label>
                <input type="text" name="id_event" required>

                <label for="gambar">Event Image:</label>
                <input type="file" name="gambar" accept="image/*" required>

                <label for="judul">Event Title:</label>
                <input type="text" name="judul" required>

                <label for="tanggal_event">Event Date:</label>
                <input type="date" name="tanggal_event" required>

                <label for="deskripsi">Event Description:</label>
                <textarea name="deskripsi" rows="4" required></textarea>

                <label for="lokasi">Event Location:</label>
                <input type="text" name="lokasi" required>

                <label for="kategori">Event Category:</label>
                <input type="text" name="kategori" required>

                <!-- Ticket Details -->
                <div class="ticket-details">
                    <h3>Ticket Information</h3>
                    <div id="ticket-container">
                        <div class="ticket-form">
                            <label for="jenis_tiket[]">Ticket Type:</label>
                            <input type="text" name="jenis_tiket[]" required>

                            <label for="harga[]">Ticket Price:</label>
                            <input type="text" name="harga[]" required>

                            <label for="jumlah_tersedia[]">Available Tickets:</label>
                            <input type="text" name="jumlah_tersedia[]" required>
                        </div>
                    </div>
                    <button type="button" class="buttonticket" onclick="addTicketForm()">Add More Ticket</button>
                </div>
                <!-- End of Ticket Details -->

                <button type="submit" name="uploadData">Upload Data</button>

            </form>

        </div>
    </div>

    <script>
    function addTicketForm() {
        var container = document.getElementById('ticket-container');
        var newTicketForm = document.createElement('div');
        newTicketForm.classList.add('ticket-form');

        newTicketForm.innerHTML = `
                <label for="jenis_tiket[]">Ticket Type:</label>
                <input type="text" name="jenis_tiket[]" required>

                <label for="harga[]">Ticket Price:</label>
                <input type="text" name="harga[]" required>

                <label for="jumlah_tersedia[]">Available Tickets:</label>
                <input type="text" name="jumlah_tersedia[]" required>
            `;

        container.appendChild(newTicketForm);
    }
    </script>
</body>

</html>