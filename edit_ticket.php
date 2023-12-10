<?php
include 'connect.php';

if (isset($_GET['id_harga']) && isset($_GET['id_event'])) {
    $id_harga = $_GET['id_harga'];
    $id_event = $_GET['id_event'];

    // Fetch ticket details based on id_harga
    $ticket_query = "SELECT * FROM harga_tiket WHERE id_harga='$id_harga' AND id_event='$id_event'";
    $ticket_result = mysqli_query($conn, $ticket_query);

    if ($ticket_result && mysqli_num_rows($ticket_result) > 0) {
        $ticket = mysqli_fetch_assoc($ticket_result);
        $jenis_tiket = $ticket['jenis_tiket'];
        $harga = $ticket['harga'];

        // Display the form for editing ticket details
        echo '
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Ticket</title>
            <style>
                body {
                    font-family: \'Arial\', sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }

                .edit-ticket-container {
                    max-width: 400px;
                    margin: 50px auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }

                h2 {
                    text-align: center;
                    color: #333;
                }

                form {
                    display: flex;
                    flex-direction: column;
                }

                label {
                    margin-bottom: 8px;
                    font-weight: bold;
                }

                input {
                    padding: 10px;
                    margin-bottom: 20px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                }

                button {
                    background-color: #3498db;
                    color: #fff;
                    padding: 10px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }

                button:hover {
                    background-color: #2184c3;
                }
            </style>
        </head>

        <body>
            <div class="edit-ticket-container">
                <h2>Edit Ticket</h2>
                <form action="update_ticket.php" method="post">
                    <input type="hidden" name="id_harga" value="' . $id_harga . '">
                    <input type="hidden" name="id_event" value="' . $id_event . '">
                    <label for="jenis_tiket">Ticket Type:</label>
                    <input type="text" id="jenis_tiket" name="jenis_tiket" value="' . $jenis_tiket . '" required>
                    <label for="harga">Ticket Price:</label>
                    <input type="number" id="harga" name="harga" value="' . $harga . '" step="0.01" required>
                    <button type="submit">Save Changes</button>
                </form>
            </div>
        </body>

        </html>';
    } else {
        echo "Ticket not found.";
    }
} else {
    echo "Ticket ID or Event ID not specified.";
}

mysqli_close($conn);
?>