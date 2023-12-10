<?php
session_start();
include('connect.php');

$user_id = $_SESSION['user_id'];

// Check if the form is submitted for updating user data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have form field names like 'username_input', 'email_input', etc.
    $newUsername = $_POST['username_input'];
    $newEmail = $_POST['email_input'];
    $newTanggalLahir = $_POST['tanggal_lahir_input'];
    $newPhoneNumber = $_POST['phone_number_input'];
    $newInstagram = $_POST['instagram_input'];

    // Update the user data in the database
    $updateSql = "UPDATE users SET username='$newUsername', email='$newEmail', tanggal_lahir='$newTanggalLahir', phone_number='$newPhoneNumber', instagram='$newInstagram' WHERE user_id=$user_id";

    if ($conn->query($updateSql) === TRUE) {
        // Refresh the page after successful update
        header("Location: settings.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Fetch user data
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $email = $row['email'];
    $tanggal_lahir = $row['tanggal_lahir'];
    $phone_number = $row['phone_number'];
    $instagram = $row['instagram'];
} else {
    echo "User not found";
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="stylesettings.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Archivo:wght@100;200;300;400;500;600;700&family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Work+Sans:wght@100;200;300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="header">
        <div class="leftside">
            <a href="main.php">
                <img src="img/fasfest.png" alt="">
            </a>

            <div class="judul">
                <p>Settings</p>
            </div>
        </div>

        <div class="rightside">

            <div class="greetinglogout">
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
    </div>

    <div class="content">
        <form method="post" action="">
            <div class="username">
                <label for="username_input">Username</label>
                <input type="text" name="username_input" id="username_input" value="<?php echo $username; ?>">
            </div>

            <div class="email">
                <label for="email_input">Email</label>
                <input type="text" name="email_input" id="email_input" value="<?php echo $email; ?>">
            </div>

            <div class="date">
                <label for="tanggal_lahir_input">Date Of Birth</label>
                <input type="date" name="tanggal_lahir_input" id="tanggal_lahir_input"
                    value="<?php echo $tanggal_lahir; ?>">
            </div>

            <div class="phone">
                <label for="phone_number_input">Phone Number</label>
                <input type="text" name="phone_number_input" id="phone_number_input"
                    value="<?php echo $phone_number; ?>">
            </div>

            <div class="instagram">
                <label for="instagram_input">Instagram</label>
                <input type="text" name="instagram_input" id="instagram_input" value="<?php echo $instagram; ?>">
            </div>

            <input class="update" type="submit" value="Update">
        </form>
    </div>
</body>


</html>