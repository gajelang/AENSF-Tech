<?php
include 'connect.php'; // Include the connection file

// Function to get total, active, and completed events
function getEventStats($conn)
{
    $result = array();

    // Total events
    $totalEventsQuery = "SELECT COUNT(*) as total FROM event";
    $totalEventsResult = $conn->query($totalEventsQuery);
    $totalEvents = $totalEventsResult->fetch_assoc()['total'];

    // Active events
    $activeEventsQuery = "SELECT COUNT(*) as active FROM event WHERE tanggal_event >= CURDATE()";
    $activeEventsResult = $conn->query($activeEventsQuery);
    $activeEvents = $activeEventsResult->fetch_assoc()['active'];

    // Completed events
    $completedEventsQuery = "SELECT COUNT(*) as completed FROM event WHERE tanggal_event < CURDATE()";
    $completedEventsResult = $conn->query($completedEventsQuery);
    $completedEvents = $completedEventsResult->fetch_assoc()['completed'];

    $result['totalEvents'] = $totalEvents;
    $result['activeEvents'] = $activeEvents;
    $result['completedEvents'] = $completedEvents;

    return $result;
}

// Function to get total ticket sales for a specific event
function getTotalTicketSales($conn, $eventId)
{
    $totalSalesQuery = "SELECT IFNULL(SUM(tp.quantity), 0) as totalSales 
                        FROM ticket_purchases tp 
                        WHERE tp.event_id = '$eventId'";
    $totalSalesResult = $conn->query($totalSalesQuery);
    $totalSales = $totalSalesResult->fetch_assoc()['totalSales'];

    return $totalSales;
}

// Function to get ticket information for each event
function getTicketInfo($conn, $eventId)
{
    $ticketInfo = array();

    $ticketQuery = "SELECT ht.id_harga, ht.jenis_tiket, ht.harga, ht.jumlah_tersedia,
                    IFNULL(SUM(CASE WHEN tp.event_id = '$eventId' THEN tp.quantity ELSE 0 END), 0) as terjual
                    FROM harga_tiket ht
                    LEFT JOIN ticket_purchases tp ON ht.id_harga = tp.ticket_type
                    WHERE ht.id_event = '$eventId'
                    GROUP BY ht.id_harga";

    $ticketResult = $conn->query($ticketQuery);

    while ($ticket = $ticketResult->fetch_assoc()) {
        $ticketInfo[] = $ticket;
    }

    return $ticketInfo;
}

// Get the sorting parameter from the form submission or use a default value
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_asc';

// Fetch events from the database with sorting
$eventsQuery = "SELECT * FROM event ORDER BY ";

if ($sort == 'date_asc') {
    $eventsQuery .= "tanggal_event ASC";
} elseif ($sort == 'date_desc') {
    $eventsQuery .= "tanggal_event DESC";
} elseif ($sort == 'event_id') {
    $eventsQuery .= "id_event";
}

$eventsResult = $conn->query($eventsQuery);


// Get event stats
$eventStats = getEventStats($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Events Manager</title>
    <link rel="stylesheet" href="styleeventsmanager.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Archivo:wght@100;200;300;400;500;600;700&family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Work+Sans:wght@100;200;300;400;500;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body>
    <!-- NAVBAR -->
    <div class="header">
        <div class="leftside">
            <a href="main.php">
                <img src="img/fasfest.png" alt="" />
            </a>

            <div class="menu">
                <a href="events.php">Events</a>
                <a href="news.php">News</a>
            </div>
        </div>
        <div class="rightside">
            <a href="login.php" class="login">Login</a>
            <a href="register.php" class="signup">Sign Up</a>
        </div>
    </div>

    <!-- New Event -->
    <div class="new-event">
        <div class="add-new-event" onclick="toggleNewEventForm()">
            <a href="create_events.php">Add New Events</a>
        </div>

        <!-- Display total, active, and completed events -->
        <div class="status-container">
            <div class="total-events">
                <p>Total Events: <?php echo $eventStats['totalEvents']; ?></p>
            </div>
            <div class="active">
                <p>Active: <?php echo $eventStats['activeEvents']; ?></p>
            </div>
            <div class="completed">
                <p>Completed: <?php echo $eventStats['completedEvents']; ?></p>
            </div>
        </div>
    </div>

    <!-- Sorting Form -->
    <form action="" method="GET">
        <label for="sort">Sort By:</label>
        <select name="sort" id="sort">
            <option value="date_asc">Date (Ascending)</option>
            <option value="date_desc">Date (Descending)</option>
            <option value="event_id">Event ID</option>
        </select>
        <input type="submit" value="Sort">
    </form>


    <!-- New Event -->
    <div class="new-event">
        <!-- ... (existing code remains the same) ... -->
    </div>

    <!-- Display events cards -->
    <div class="event-list">
        <?php
        while ($event = $eventsResult->fetch_assoc()) {
            $eventStatus = ($event['tanggal_event'] >= date('Y-m-d')) ? 'Active' : 'Completed';
            $bgColor = ($eventStatus == 'Completed') ? 'background-color: #ededed;' : '';

            echo "<div class='event-card' style='{$bgColor}'>";
            echo "<h2 class='event-id'>ID Event: <span>" . $event['id_event'] . "</span></h2>";
            echo "<h2 class='event-title'>" . $event['judul'] . "</h2>";
            echo "<p class='event-date'>Date: " . $event['tanggal_event'] . "</p>";
            echo "<p class='event-location'>Location: " . $event['lokasi'] . "</p>";
            echo "<p class='event-status'>Status: " . $eventStatus . "</p>";

            $ticketInfo = getTicketInfo($conn, $event['id_event']);
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Ticket Type</th>";
            echo "<th>Price</th>";
            echo "<th>Available</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($ticketInfo as $ticket) {
                echo "<tr>";
                echo "<td>" . $ticket['jenis_tiket'] . "</td>";
                echo "<td>" . $ticket['harga'] . "</td>";
                echo "<td>" . $ticket['jumlah_tersedia'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";

            echo "<a href='edit_event.php?id_event=" . $event['id_event'] . "' class='edit-button'>Edit Event</a>";
            echo "</div>";
        }
        ?>
    </div>

    <!-- ... (remaining HTML remains the same) ... -->

</body>

</html>