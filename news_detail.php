<?php
include 'connect.php';

// Get news ID from the URL parameter
$news_id = $_GET['id'];

// Fetch news details from the database based on the ID
$sql = "SELECT * FROM news WHERE id_news = '$news_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['judul']; ?></title>
    <link rel="stylesheet" href="stylenewsdetail.css">
</head>

<body>
    <div class="newsdetail-container">
        <div class="headernews">
            <a href="news.php"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M20 11H7.83l5.59-5.59L12 4l-8 8l8 8l1.41-1.41L7.83 13H20v-2z" />
                </svg></a>

            <p>FastFEST</p>
        </div>

        <hr>

        <h2><?php echo $row['judul']; ?></h2>
        <img src="<?php echo $row['gambar']; ?>" alt="<?php echo $row['judul']; ?>">
        <p><?php echo $row['text_isi']; ?></p>
        <p>Date: <?php echo date("j F Y", strtotime($row['date_news'])); ?></p>
    </div>
</body>

</html>
<?php
} else {
    echo "News not found.";
}

$conn->close();
?>