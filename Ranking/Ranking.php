<?php
include '../Include/Connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch ranking data based on total marks and penalties
function fetchRankings($conn)
{
    $query = "
        SELECT 
            u.id,
            u.username,
            COALESCE(p.location, 'Unknown') as country,
            COALESCE(SUM(CASE WHEN s.status = 'Accepted' THEN s.marks ELSE 0 END), 0) as total_marks,
            COUNT(CASE WHEN s.status != 'Accepted' THEN 1 END) as penalties,
            COUNT(CASE WHEN s.status = 'Accepted' THEN 1 END) as solved_count,
            RANK() OVER (ORDER BY COALESCE(SUM(CASE WHEN s.status = 'Accepted' THEN s.marks ELSE 0 END), 0) DESC) as user_rank
        FROM users_info u
        LEFT JOIN submissions s ON u.id = s.user_id
        LEFT JOIN users_profile p ON u.id = p.id
        GROUP BY u.id, u.username, p.location
        ORDER BY user_rank, u.username
    ";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $rankings = [];
    while ($row = $result->fetch_assoc()) {
        // Extract country from location (assuming format like "USA, California, Los Angeles")
        $location_parts = explode(',', $row['country']);
        $row['country'] = trim($location_parts[0]) ?: 'Unknown';
        $rankings[] = $row;
    }
    $stmt->close();
    return $rankings;
}

// Fetch the logged-in user's rank and stats
function fetchUserRank($conn, $user_id)
{
    $query = "
        SELECT 
            user_rank,
            solved_count,
            total_marks,
            penalties,
            country
        FROM (
            SELECT 
                u.id,
                COALESCE(p.location, 'Unknown') as country,
                COUNT(CASE WHEN s.status = 'Accepted' THEN 1 END) as solved_count,
                COALESCE(SUM(CASE WHEN s.status = 'Accepted' THEN s.marks ELSE 0 END), 0) as total_marks,
                COUNT(CASE WHEN s.status != 'Accepted' THEN 1 END) as penalties,
                RANK() OVER (ORDER BY COALESCE(SUM(CASE WHEN s.status = 'Accepted' THEN s.marks ELSE 0 END), 0) DESC) as user_rank
            FROM users_info u
            LEFT JOIN submissions s ON u.id = s.user_id
            LEFT JOIN users_profile p ON u.id = p.id
            GROUP BY u.id, p.location
        ) ranked
        WHERE id = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_rank = $result->fetch_assoc();
    $stmt->close();
    if ($user_rank) {
        // Extract country from location
        $location_parts = explode(',', $user_rank['country']);
        $user_rank['country'] = trim($location_parts[0]) ?: 'Unknown';
    }
    return $user_rank ?: ['user_rank' => 'N/A', 'solved_count' => 0, 'total_marks' => 0, 'penalties' => 0, 'country' => 'Unknown'];
}

$rankings = fetchRankings($conn);
$user_rank = fetchUserRank($conn, $user_id);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking</title>
    <link rel="stylesheet" href="../Include/Navbar.css">
    <link rel="stylesheet" href="Ranking.css">
</head>

<body>
    <?php include '../Include/Navbar.php'; ?>
    <div class="main">
        <!-- <div class="user-rank">
            <p>Your Rank: <?php echo htmlspecialchars($user_rank['user_rank']); ?> | Country: <?php echo htmlspecialchars($user_rank['country']); ?> | Penalties: <?php echo htmlspecialchars($user_rank['penalties']); ?> | Score: <?php echo htmlspecialchars($user_rank['total_marks']); ?></p>
        </div> -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Who</th>
                    <th>Country</th>
                    <!-- <th>Penalties</th> -->
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rankings as $row): ?>
                    <tr <?php echo ($row['id'] == $user_id) ? 'class="current-user"' : ''; ?>>
                        <td><?php echo htmlspecialchars($row['user_rank']); ?></td>
                        <?php
                            $scoreColor = ($row['total_marks'] >= 10) ? 'red' : (($row['total_marks'] < 10) ? 'blue' : '');
                        ?>
                        <td>
                            <a class="u-name" href="profile.php?id=<?php echo htmlspecialchars($row['id']); ?>" style="<?php echo $scoreColor ? "color: $scoreColor;" : ""; ?>">
                                <?php echo htmlspecialchars($row['username']); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($row['country']); ?></td>
                        <!-- <td><?php echo htmlspecialchars($row['penalties']); ?></td> -->
                        <td><?php echo htmlspecialchars($row['total_marks']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>