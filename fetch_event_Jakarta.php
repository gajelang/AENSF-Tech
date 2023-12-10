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
        background-image: url('img/bgjakarta.png');
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
                <p>Jakarta</p>
            </div>
            <div class="explore">
                <a href="#event">Explore Now</a>
            </div>

        </div>
    </div>



    <!-- EVENT CARD -->

    <div class=" event-container" id="event">
        <?php
        include 'connect.php';

        // Function to fetch and display events from Jakarta
        function fetchEventsFromJakarta()
        {
            global $conn;

            $location = 'Jakarta';
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

        // Display events from Jakarta
        fetchEventsFromJakarta();
        ?>
    </div>

    <!-- GUIDE -->
    <div class="guide">
        <div class="hotel">
            <p>Book A Hotel?</p>

            <div class="hotelcontainer">
                <a href="https://www.traveloka.com/en-id/hotel">Traveloka</a>
                <a href="https://www.oyorooms.com/id/hotels-in-jakarta/">OYO</a>
                <a href="https://www.reddoorz.com/id-id/search/hotel/indonesia/jakarta">RedDoorz</a>
                <a href="https://www.booking.com/city/id/jakarta.id.html">Booking.com</a>
            </div>
        </div>
    </div>

    <!-- MAP -->

    <div class="map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253840.65638470952!2d106.66470585519298!3d-6.229379598355993!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1701167856036!5m2!1sid!2sid"
            width="800" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

</body>

</html>