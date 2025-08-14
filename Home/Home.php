<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../Include/Navbar.css">
    <link rel="stylesheet" href="Home.css">
</head>

<body>
    <?php
    include("..\Include\Navbar.php");
    include("..\Include\Connection.php");

    // Fetch Posts
    $stmt = $conn->prepare("SELECT username, title, announcement, photo FROM post ORDER BY id DESC");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($username, $title, $announcement, $photo_data);

    // Fetch Upcoming Contests
    $contest_stmt = $conn->prepare("SELECT title, start_time FROM contests WHERE status = 'upcoming' ORDER BY start_time ASC");
    $contest_stmt->execute();
    $contest_stmt->store_result();
    $contest_stmt->bind_result($contest_title, $start_date);

    // Fetch Top 10 Rankings
    function fetchTopRankings($conn, $limit = 10)
    {
        $query = "
            SELECT 
                u.id,
                u.username,
                COALESCE(p.location, 'Unknown') as country,
                COALESCE(SUM(CASE WHEN s.status = 'Accepted' THEN s.marks ELSE 0 END), 0) as total_marks,
                COUNT(CASE WHEN s.status != 'Accepted' THEN 1 END) as penalties,
                RANK() OVER (ORDER BY COALESCE(SUM(CASE WHEN s.status = 'Accepted' THEN s.marks ELSE 0 END), 0) DESC) as user_rank
            FROM users_info u
            LEFT JOIN submissions s ON u.id = s.user_id
            LEFT JOIN users_profile p ON u.id = p.id
            GROUP BY u.id, u.username, p.location
            ORDER BY user_rank
            LIMIT ?
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $rankings = [];
        while ($row = $result->fetch_assoc()) {
            // Extract country from location
            $location_parts = explode(',', $row['country']);
            $row['country'] = trim($location_parts[0]) ?: 'Unknown';
            $rankings[] = $row;
        }
        $stmt->close();
        return $rankings;
    }

    $topRankings = fetchTopRankings($conn);
    ?>

    <div class="container home-flex">

        <!-- Left Side: Posts -->
        <div class="post-container">
            <?php while ($stmt->fetch()): ?>
                <div class="post-details">
                    <h2 class="post-heading"><?php echo htmlspecialchars($title); ?></h2>
                    <h4 class="posted-by"> - <?php echo htmlspecialchars($username); ?></h4>
                    <p class="post">
                        <?php echo nl2br(htmlspecialchars($announcement)); ?>
                    </p>
                    <?php if (!empty($photo_data)): ?>
                        <img class="home-img" src="data:image/jpeg;base64,<?php echo base64_encode($photo_data); ?>" alt="Post-image">
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Right Side: Contests + Rankings -->
        <div class="right-panel">

            <!-- Upcoming Contests -->
            <div class="upcoming-contest-home">
                <h3>Upcoming Contests</h3>
                <ul>
                    <?php while ($contest_stmt->fetch()): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($contest_title); ?></strong><br>
                            <?php echo htmlspecialchars(date("F j, Y", strtotime($start_date))); ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>

            <!-- Ranking Table -->
            <div class="ranking-home">
                <h3>Top Rankings</h3>
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
                        <?php foreach ($topRankings as $row): ?>
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

        </div>
    </div>
</body>

</html>