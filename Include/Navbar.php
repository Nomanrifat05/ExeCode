<?php
// Get the current page filename for Navbar
$current_page = basename($_SERVER['PHP_SELF']);
include '../Include/Connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user_id = $_SESSION['user_id'] ?? "";

$username = "";
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT username FROM users_info WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($fetched_username);
    if ($stmt->fetch()) {
        $username = htmlspecialchars($fetched_username);
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Libertinus+Math&display=swap" rel="stylesheet"> -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="Navbar.css">
</head>

<body>
    <header class="nav-header">
        <nav class="upper-nav">
            <div class="logo"><a href="../Home/Home.php"><span class="first"><span class="rote">E</span>xe</span><span class="second"><span class="rote">C</span>o<span class="rote">d</span>e</span></a></div>
            <div class="search-box">
                <input type="text" name="" id="" placeholder="Search your opponent">
            </div>
            <div class="profile">
                <ul>
                    <li class="nav-item"><a href="../editprofile/editprofile.php"><?php echo htmlspecialchars($username); ?></a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">|</li>
                        <li class="nav-item"><a href="../User/Logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a href="../User/Login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
        <nav class="lower-nav">
            <ul>
                <li class="nav-item">
                    <a href="../Home/Home.php" class="<?php echo $current_page == 'Home.php' ? 'active' : ''; ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a href="../contest/contest.php" class="<?php echo $current_page == 'contest.php' ? 'active' : ''; ?>">Contest</a>
                </li>
                <li class="nav-item">
                    <a href="../PracticsProblem/practiceproblem.php" class="<?php echo $current_page == 'practiceproblem.php' ? 'active' : ''; ?>">ProblemSet</a>
                </li>
                <li class="nav-item">
                    <a href="../Ranking/Ranking.php" class="<?php echo $current_page == 'Ranking.php' ? 'active' : ''; ?>">Ranking</a>
                </li>
                <?php if ($username === "Mahbub" || $username === "Noman" || $username === "Musfiq"): ?>
                    <li class="nav-item">
                        <a href="../Admin/admin.php" class="<?php echo $current_page == 'admin.php' ? 'active' : ''; ?>">Manage</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>

</html>