<?php
// Start session and database connection
$current_page = basename($_SERVER['PHP_SELF']);
include '../Include/Connection.php';
include '../Include/Navbar.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'] ?? "";
$username = "";

if (!empty($user_id)) {
    $stmt = $conn->prepare("SELECT username FROM users_info WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($fetched_username);
    if ($stmt->fetch()) {
        $username = htmlspecialchars($fetched_username);
    }
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $announcement = $_POST['announcement'];

    $photo = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $photo = file_get_contents($_FILES['photo']['tmp_name']);
    }

    $stmt = $conn->prepare("INSERT INTO post (username, title, announcement, photo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssb", $username, $title, $announcement, $photo);
    if ($photo !== null) {
        $stmt->send_long_data(3, $photo);
    }
    $stmt->execute();
    $stmt->close();

    echo "<p style='color: green; text-align: center;'>Announcement posted successfully.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
    <link rel="stylesheet" href="../Include/Navbar.css">
    <link rel="stylesheet" href="announcement.css">
</head>

<body>
    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="input">
                <label class="input-label" for="title">Enter Title</label><br>
                <input type="text" name="title" id="title" placeholder="Execode round 30 will be late" required>
            </div>

            <div class="input">
                <label class="input-label" for="announcement">Enter Your Announcement</label><br>
                <textarea name="announcement" id="announcement" placeholder="Your announcement..." required></textarea>
            </div>

            <div class="input">
                <label class="input-label" for="photo">Add a Photo</label><br>
                <input type="file" name="photo" id="photo" accept="image/*">
            </div>

            <button type="submit">Post</button>
        </form>
    </div>
</body>

</html>