<?php
// Mulai sesi atau lanjutkan sesi yang sudah ada
session_start();

// Pemeriksaan apakah user_id sudah ada di dalam sesi
if (!isset($_SESSION['user_id'])) {
    // Jika user_id tidak ditemukan, mungkin perlu melakukan tindakan tertentu
    // seperti mengarahkan pengguna ke halaman login
    echo '<script>alert("Silakan login terlebih dahulu."); window.location.href = "login.php";</script>';
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!-- NEW PAGE FOR ADDITIONAL EVENTS -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Event Website - Additional Events</title>

    <link rel="stylesheet" href="styleevent.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Archivo:wght@100;200;300;400;500;600;700&family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Work+Sans:wght@100;200;300;400;500;600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

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

    <!-- TEXT HEADLINE -->

    <div class="headline">
        <h2>Where Music Concerts Act as Engines <br> for Indonesia's Economic and Tourism Enhancement!</h2>
        <p>Support Indonesia's economy and tourism by backing successful concerts and festivals, <br>creating memorable
            cultural experiences, and contributing to local communities!</p>
        <div class="slider-container">
            <img id="slider-image" src="img/concertbanner.png" alt="">
            <div class="slider-buttons">
                <button onclick="prevSlide()"><span class="material-symbols-outlined">
                        arrow_back_ios
                    </span></button>
                <button onclick="nextSlide()"><span class="material-symbols-outlined">
                        arrow_forward_ios
                    </span></button>
            </div>
        </div>
    </div>


    <!-- ADDITIONAL EVENTS -->
    <div class="upcomingevents">
        <p>All Upcoming Events!</p>
    </div>

    <div class="additional-event-container">

        <div class="eventmain" id="additional-event-container">
            <!-- Additional Event cards will be dynamically added here -->
            <?php include 'fetch_additional_events.php'; ?>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil semua elemen tombol dengan class 'additional-event-button'
        var buyButtons = document.querySelectorAll('.additional-event-button');

        // Loop melalui setiap tombol
        buyButtons.forEach(function(button) {
            // Tambahkan event listener untuk setiap tombol
            button.addEventListener('click', function() {
                // Dapatkan nilai data-id dari atribut data-id pada tombol
                var eventId = this.getAttribute('data-id');

                // Redirect ke halaman detail acara dengan menyertakan id acara
                window.location.href = 'event_detail.php?id=' + eventId;
            });
        });
    });
    </script>

    <script>
    // JavaScript code di sini
    var slides = ['img/wtfbanner.jpeg', 'img/coldplaybanner.png', 'img/arcticbanner.png', 'img/nctbanner.png'];

    // Set initial currentSlide based on the current time
    var currentSlide = new Date().getMilliseconds() % slides.length;

    function showSlide(index) {
        document.getElementById('slider-image').src = slides[index];
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    // Call showSlide to set the initial image
    showSlide(currentSlide);

    // Auto slide every 5 seconds
    setInterval(function() {
        nextSlide();
    }, 150000);
    </script>


    <script>
    function confirmLogout() {
        var confirmLogout = confirm("Are you sure you want to logout?");
        if (confirmLogout) {
            // Jika user mengklik OK, maka arahkan ke halaman logout.php
            window.location.href = "logout.php";
        }
    }
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.querySelector('input[type="text"]');
        var searchIcon = document.querySelector('.contsearch img');

        searchInput.addEventListener('focus', function() {
            searchIcon.style.transform = 'scale(1.2)';
        });

        searchInput.addEventListener('blur', function() {
            searchIcon.style.transform = 'scale(1)';
        });
    });
    </script>

    <script>
    function submitSearchForm() {
        // Get values from the form
        var searchQuery = document.getElementById('search_query').value;
        var searchCategory = document.getElementById('search_category').value;

        // Perform any additional validation if needed

        // Redirect to search_events.php with query parameters
        window.location.href = 'search_events.php?search_query=' + encodeURIComponent(searchQuery) +
            '&search_category=' + encodeURIComponent(searchCategory);
    }
    </script>

</body>

</html>