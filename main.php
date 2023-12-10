<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    echo '<script>alert("Silakan login terlebih dahulu."); window.location.href = "login.php";</script>';
    exit();
}

// Include your database connection file
include 'connect.php';

$user_id = $_SESSION['user_id'];

// Fetch the username from the database based on the user_id
$query = "SELECT username FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
} else {
    // Handle the error accordingly
    $username = "Guest"; // Default to 'Guest' if an error occurs
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Event Website</title>

    <link rel="stylesheet" href="style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Archivo:wght@100;200;300;400;500;600;700&family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Work+Sans:wght@100;200;300;400;500;600&display=swap"
        rel="stylesheet">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
</head>

<body>

    <!-- NAVBAR -->
    <div class="header">
        <div class="leftside">
            <img src="img/fasfest.png" alt="">
            <!-- menu wide -->
            <div class="menu">
                <a href="events.php">Events</a>
                <a href="news.php">News</a>
                <a href="my_ticket.php">My Ticket</a>
            </div>
        </div>

        <div class="rightside">
            <p class="headerheadline">Helloooo, <strong><?php echo $username; ?></strong></p>

            <a href="settings.php">
                <div class="settings">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 28 28">
                        <rect x="0" y="0" width="32" height="32" fill="none" stroke="none" />
                        <path fill="currentColor"
                            d="M14 9.5a4.5 4.5 0 1 0 0 9a4.5 4.5 0 0 0 0-9ZM11 14a3 3 0 1 1 6 0a3 3 0 0 1-6 0Zm10.71 8.395l-1.728-.759a1.72 1.72 0 0 0-1.542.086c-.467.27-.765.747-.824 1.284l-.208 1.88a.923.923 0 0 1-.703.796a11.67 11.67 0 0 1-5.412 0a.923.923 0 0 1-.702-.796l-.208-1.877a1.701 1.701 0 0 0-.838-1.281a1.694 1.694 0 0 0-1.526-.086l-1.728.759a.92.92 0 0 1-1.043-.215a12.064 12.064 0 0 1-2.707-4.672a.924.924 0 0 1 .334-1.016l1.527-1.128a1.7 1.7 0 0 0 0-2.74l-1.527-1.125a.924.924 0 0 1-.334-1.017A12.059 12.059 0 0 1 5.25 5.821a.92.92 0 0 1 1.043-.214l1.72.757a1.707 1.707 0 0 0 2.371-1.376l.21-1.878a.923.923 0 0 1 .715-.799c.881-.196 1.78-.3 2.704-.311c.902.01 1.8.115 2.68.311a.922.922 0 0 1 .715.8l.209 1.878a1.701 1.701 0 0 0 1.688 1.518c.233 0 .464-.049.68-.144l1.72-.757a.92.92 0 0 1 1.043.214a12.057 12.057 0 0 1 2.708 4.667a.924.924 0 0 1-.333 1.016l-1.525 1.127c-.435.32-.698.829-.698 1.37c0 .54.263 1.049.699 1.37l1.526 1.126c.316.234.45.642.334 1.017a12.065 12.065 0 0 1-2.707 4.667a.92.92 0 0 1-1.043.215Zm-5.447-.198a3.162 3.162 0 0 1 1.425-1.773a3.22 3.22 0 0 1 2.896-.161l1.344.59a10.565 10.565 0 0 0 1.97-3.398l-1.189-.877v-.001a3.207 3.207 0 0 1-1.309-2.578c0-1.027.497-1.98 1.307-2.576l.002-.001l1.187-.877a10.56 10.56 0 0 0-1.971-3.397l-1.333.586l-.002.001c-.406.18-.843.272-1.286.272a3.202 3.202 0 0 1-3.178-2.852v-.002l-.163-1.46a11.476 11.476 0 0 0-1.95-.193a11.71 11.71 0 0 0-1.975.193l-.163 1.461A3.207 3.207 0 0 1 7.41 7.737l-1.336-.588a10.558 10.558 0 0 0-1.971 3.397l1.19.877a3.201 3.201 0 0 1 0 5.155l-1.19.878a10.565 10.565 0 0 0 1.97 3.403l1.345-.59a3.194 3.194 0 0 1 2.878.16a3.2 3.2 0 0 1 1.579 2.411v.005l.162 1.464c1.297.255 2.63.255 3.927 0l.162-1.467c.024-.22.07-.437.138-.645Z" />
                    </svg>
                </div>
            </a>

            <div class="greetinglogout">

                <a href="logout.php" class="logout" onclick="confirmLogout()">
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
    </div>

    <div class="menumobile">
        <a href="events.php">Events</a>
        <a href="news.php">News</a>
        <a href="my_ticket.php">My Ticket</a>
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


    <!-- HOME BANNER -->

    <div class="bannercontainer">

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

        <script>
        // JavaScript code di sini
        var slides = ['img/movethebeatbanner.png', 'img/drakebanner.png'];

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
    </div>


    <!--- KATEGORI KONSER ---->

    <div class="headerkategori">
        <p>Choose by City!</p>
    </div>

    <div class="containerkategori">
        <a href="fetch_event_Yogyakarta.php" class="jogja">
            <img src="img/Yogya.png" alt="">
        </a>
        <a href="fetch_event_Jakarta.php" class="jakarta">
            <img src="img/Jakarta.png" alt="">
        </a>
        <a href="fetch_event_Surabaya.php" class="surabaya">
            <img src="img/Surabaya.png" alt="">
        </a>
        <a href="fetch_event_Bandung.php" class="bandung">
            <img src="img/Bandung.png" alt="">
        </a>
        <a href="fetch_event_Bali.php" class="bali">
            <img src="img/Bali.png" alt="">
        </a>
    </div>

    <!-- KATEGORI LOKASI - MOBILE -->
    <div class="containerkategorimobile">
        <a href="fetch_event_Yogyakarta.php" class="jogja">
            <img src="img/Yogya.png" alt="">
        </a>
        <a href="fetch_event_Jakarta.php" class="jakarta">
            <img src="img/Jakarta.png" alt="">
        </a>
        <a href="fetch_event_Surabaya.php" class="surabaya">
            <img src="img/Surabaya.png" alt="">
        </a>
        <a href="fetch_event_Bandung.php" class="bandung">
            <img src="img/Bandung.png" alt="">
        </a>
        <a href="fetch_event_Bali.php" class="bali">
            <img src="img/Bali.png" alt="">
        </a>
    </div>

    <!-- POPULAR EVENTS -->
    <div class="eventcontainer">
        <div class="headerevent">
            <p>Upcoming Events</p>
        </div>

        <div class="eventmain" id="event-container">
            <!-- Event cards will be dynamically added here -->
            <?php include 'fetch_events.php'; ?>
        </div>
    </div>


    <!-- NEWS PAGE -->
    <div class="NewsContainer">
        <div class="headerevent">
            <p>Latest News</p>
        </div>

        <div class="WrapperNews">
            <!-- News content, if needed -->
            <?php include 'fetch_news.php'; ?>
        </div>
    </div>


    <!-- ABOUT US -->
    <div class="about-container">
        <div class="about-content">

            <h2>About Us</h2>

            <p>Welcome to FastFEST, your ultimate destination for hassle-free concert ticket purchases in major
                cities
                across Indonesia. At FastFEST, we provide quick and secure access to a diverse range of concert
                tickets,
                covering genres from pop to rock and beyond. Our user-friendly platform ensures a seamless
                ticket-buying
                experience with comprehensive information on schedules, venues, and artists. Join the FastFEST
                community
                to effortlessly secure your dream concert tickets and make every moment at a concert extraordinary.
                Thanks for choosing FastFEST, where we simplify your music journey, one ticket at a time!</p>

            <br><br>

            <hr>

            <br><br>

            <div class="containeraboutus">
                <div class="leftaboutus">
                    <p>22523008 <br>
                        22523044 <br>
                        22523068 <br>
                        22523147 <br>
                        22523288
                    </p>
                </div>

                <div class="rightaboutus">
                    <p>Elang Samudra Bintang <br>
                        Fathya Az Zahra <br>
                        Aldrin Radhitya Remasaski <br>
                        Naufal Annabih Mudaffa <br>
                        Syifa Amalia Rahma Devi
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk konfirmasi logout -->
    <script>
    function confirmLogout() {
        var confirmLogout = confirm("Are you sure you want to logout?");
        if (confirmLogout) {
            // Jika user mengklik OK, maka arahkan ke halaman logout.php
            window.location.href = "logout.php";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const hamburgerMenu = document.querySelector('.hamburger-menu');
        const menu = document.querySelector('.menu');

        hamburgerMenu.addEventListener('click', function() {
            menu.classList.toggle('active');
        });
    });
    </script>



</body>

</html>