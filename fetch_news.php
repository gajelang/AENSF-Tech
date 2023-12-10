<?php
include 'connect.php';

$sql = "SELECT * FROM news ORDER BY id_news DESC LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="newscont">';
        echo '<img src="' . $row['gambar'] . '" alt="' . $row['judul'] . '">';
        echo '<h3>' . $row['judul'] . '</h3>';

        // Memotong teks_isi menjadi maksimal 50 kata
        $textIsi = $row['text_isi'];
        $wordArray = str_word_count($textIsi, 1);
        $limitedTextIsi = implode(' ', array_slice($wordArray, 0, 50));

        echo '<p>' . $limitedTextIsi . '...</p>';

        // Mengubah format tanggal
        $formattedDate = date("j F Y", strtotime($row['date_news']));

        echo '<div class="bottomnews">';
echo '<p>Date: ' . $formattedDate . '</p>';
echo '<a href="news_detail.php?id=' . $row['id_news'] . '" class="news-button">Read More</a>';
echo '</div>';
echo '</div>';
    }
} else {
    echo "No news available.";
}

$conn->close();
?>