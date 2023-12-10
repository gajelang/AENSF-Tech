<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Event Website - Search Results</title>

    <!-- Link to your existing CSS file -->
    <link rel="stylesheet" href="stylesearchevent.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Archivo:wght@100;200;300;400;500;600;700&family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Work+Sans:wght@100;200;300;400;500;600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Add any other meta tags or links you need in the head section -->

</head>

<body>
    <!-- NAVBAR -->
    <div class="header">
        <div class="leftside">
            <a href="main.php">
                <img src="img/fasfest.png" alt="">
            </a>

            <div class="menu">
                <a href="events.php" class="eventsmenu">Events</a>
                <a href="news.php" class="newsmenu">News</a>
                <a href="my_ticket.php" class="myticketmenu">My Ticket</a>
            </div>
        </div>

        <div class="rightside">
            <a href="#" class="logout" onclick="confirmLogout()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12 3.25a.75.75 0 0 1 0 1.5a7.25 7.25 0 0 0 0 14.5a.75.75 0 0 1 0 1.5a8.75 8.75 0 1 1 0-17.5Z" />
                    <path fill="currentColor"
                        d="M16.47 9.53a.75.75 0 0 1 1.06-1.06l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H10a.75.75 0 0 1 0-1.5h8.19l-1.72-1.72Z" />
                </svg>
                <span class="logout-text">Logout</span>
            </a>
        </div>
    </div>

    <!-- SEARCH BAR -->
    <div class="serachcontainer">
        <!-- Inside the <div class="serachcontainer"> section, add the following form: -->
        <form action="search_events.php" method="post">
            <div class="searchbar">
                <div class="contsearch">
                    <select name="search_category" id="search_category">
                        <option value="judul">Title</option>
                        <option value="kategori">Category</option>
                        <option value="lokasi">Location</option>
                        <option value="id_event">Event ID</option>
                    </select>
                    <input type="text" name="search_query" id="search_query" placeholder="Search your event!">
                </div>
                <!-- Apply the CSS class to the SVG element -->
                <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <rect x="0" y="0" width="24" height="24" fill="none" stroke="none" />
                        <path fill="currentColor"
                            d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Your HTML content here -->


    <div class="events-container">
        <?php
    include 'connect.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $search_query = mysqli_real_escape_string($conn, $_POST['search_query']);
        $search_category = $_POST['search_category'];

        $sql = "SELECT * FROM `event` WHERE `$search_category` LIKE '%$search_query%'";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="event-card">';
            echo '<img src="' . $row['gambar'] . '" alt="Event Image">';
            echo '<div class="event-details">';
            echo '<h3 class="event-title">' . $row['judul'] . '</h3>';
            echo '<p class="event-date">Date: ' . $row['tanggal_event'] . '</p>';
            echo '<p class="event-location">Location: ' . $row['lokasi'] . '</p>';
            echo '<p class="event-description">' . $row['deskripsi'] . '</p>';
            echo '<a href="event_detail.php?id=' . $row['id_event'] . '" class="event-button">View Details</a>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>
    </div>

    <!-- Include your existing JavaScript code if needed -->

</body>

</html>