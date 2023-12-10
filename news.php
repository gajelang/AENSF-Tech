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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Event Website - Additional Events</title>

    <link rel="stylesheet" href="stylenews.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Archivo:wght@100;200;300;400;500;600;700&family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Work+Sans:wght@100;200;300;400;500;600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
</head>

<body>
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

    <!-- LATEST NEWS CARD -->
    <div class="bigscreen">
        <div class="leftscreen">
            <p>Read the <strong>Latest News</strong> About the <strong></strong>Hottest Festivals, Musical Bliss, and
                Trendsetting Events!</p>
            <a href="#news-container" class="newsbutton" onclick="scrollToNews()">Read All News</a>
        </div>

        <div class="latest-news-card">
            <?php
    include 'connect.php';
    $latestNewsSql = "SELECT * FROM news ORDER BY date_news DESC LIMIT 1";
    $latestNewsResult = mysqli_query($conn, $latestNewsSql);
    if (mysqli_num_rows($latestNewsResult) > 0) {
        $latestNews = mysqli_fetch_assoc($latestNewsResult);
        echo '<div class="news-article latest-news">';
        echo '<img src="' . $latestNews['gambar'] . '" alt="Latest News Image">';
        echo '<h2>' . $latestNews['judul'] . '</h2>';
        echo '<p class="news-text">' . substr($latestNews['text_isi'], 0, 500) . '...</p>';
        echo '<div class="article-details">';
        echo '<p class="date">Date: ' . $latestNews['date_news'] . '</p>';
        echo '<a href="news_detail.php?id=' . $latestNews['id_news'] . '" class="read-more">Read More</a>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p>No latest news available.</p>';
    }
    mysqli_close($conn);
    ?>
        </div>


    </div>

    <!-- NEWS SECTION -->
    <div class="news-container" id="news-container">
        <div class="headlinenews">
            <p>Latest <br> News</p>
        </div>
        <?php
        // Include database connection file
        include 'connect.php';

        // Function to truncate text to a certain number of words
        function truncateText($text, $limit) {
            $words = explode(" ", $text);
            $truncatedText = implode(" ", array_slice($words, 0, $limit));
            // Add an ellipsis (...) if the text is truncated
            if (count($words) > $limit) {
                $truncatedText .= '...';
            }
            return $truncatedText;
        }

        // Fetch news from the database
        $sql = "SELECT * FROM news";
        $result = mysqli_query($conn, $sql);

        // Display news cards
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="news-article">';
                echo '<img src="' . $row['gambar'] . '" alt="News Image">';
                echo '<h2>' . $row['judul'] . '</h2>';
                // Truncate text to 30 words
                $truncatedText = truncateText($row['text_isi'], 30);
                echo '<p class="news-text">' . $truncatedText . '</p>';
                echo '<div class="article-details">';
                echo '<p class="date">Date: ' . $row['date_news'] . '</p>';
                echo '<a href="news_detail.php?id=' . $row['id_news'] . '" class="read-more">Read More</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No news articles available.</p>';
        }

        // Close connection
        mysqli_close($conn);
        ?>
    </div>

    <footer>
        <!-- Your footer content here -->
    </footer>

    <script>
    function scrollToNews() {
        document.getElementById('news-container').scrollIntoView({
            behavior: 'smooth'
        });
    }
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
</body>

</html>