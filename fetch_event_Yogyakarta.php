<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include your main CSS file -->
    <link rel="stylesheet" href="stylelocationevent.css">
    <!-- ... Other meta tags and links ... -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Archivo:wght@100;200;300;400;500;600;700&family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Work+Sans:wght@100;200;300;400;500;600&display=swap"
        rel="stylesheet">

    <style>
    .headercontainer {
        background-image: url('img/bgjogja.png');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        background-color: #f0f0f0;
        padding: 40px;
        height: 70vh;
    }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
    function confirmLogout() {
        // Add your confirmation logic here
        var confirmLogout = confirm("Are you sure you want to logout?");
        if (confirmLogout) {
            // Redirect to logout page or perform logout action
            window.location.href = 'logout.php';
        }
    }
    </script>
</head>

<body>
    <div class="headercontainer">
        <div class="header">
            <div class="logo">
                <a href="main.php"><img src="img/LOGO WEB.png" alt=""></a>
            </div>

            <div class="tagline">
                <p>Yogyakarta</p>
            </div>
            <div class="explore">
                <a href="#event">Explore Now</a>
            </div>

        </div>
    </div>

    <div class="event-container" id="event">
        <?php
        include 'connect.php';

        // Function to fetch and display events from Yogyakarta
        function fetchEventsFromYogyakarta()
        {
            global $conn;

            $location = 'Yogyakarta';
            $query = "SELECT * FROM event WHERE lokasi = '$location'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $counter = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="event-card">';
                    echo '<img src="' . $row['gambar'] . '" alt="' . $row['judul'] . '">';
                    echo '<h3>' . $row['judul'] . '</h3>';
                    echo '<p>Date: ' . $row['tanggal_event'] . '</p>';
                    echo '<p>Location: ' . $row['lokasi'] . '</p>';

                    // Button linking to event_detail.php with event ID as a parameter
                    echo '<a href="event_detail.php?id=' . $row['id_event'] . '" class="event-button">View Details</a>';

                    echo '</div>';

                    $counter++; // Increment the counter for the next iteration
                }
            } else {
                // Handle the error accordingly
                echo 'Error fetching events: ' . mysqli_error($conn);
            }

            mysqli_close($conn);
        }

        // Display events from Yogyakarta
        fetchEventsFromYogyakarta();
        ?>
    </div>
</body>

</html>