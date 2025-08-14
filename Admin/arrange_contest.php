<?php
include("../Include/Connection.php");

// Fetch all problems from problem_set table
$sql = "SELECT * FROM problem_set ORDER BY title ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Arrange Contest</title>
    <link rel="stylesheet" href="../Include/Navbar.css" />
    <link rel="stylesheet" href="arrange_contest.css" />
</head>
<body>
    <!-- Navbar Include if needed -->
    <?php include("../Include/Navbar.php"); ?>

    <div class="container">
        <h2>Arrange a Contest</h2>

        <form action="create_contest.php" method="POST">
            <label for="title">Contest Title:</label>
            <input type="text" name="title" id="title" required placeholder="Weekly Contest"/>

            <label for="start_time">Start Time:</label>
            <input type="datetime-local" name="start_time" id="start_time" required />

            <label for="end_time">End Time:</label>
            <input type="datetime-local" name="end_time" id="end_time" required />

            <h3>Select Problems:</h3>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="problem-checkbox">
                    <input type="checkbox" id="problem-<?= $row['id'] ?>" name="selected_problems[]" value="<?= $row['id'] ?>" />
                    <label for="problem-<?= $row['id'] ?>" style="display: inline;">
                        <?= htmlspecialchars($row['title']) ?> (Difficulty: <?= htmlspecialchars($row['difficulty']) ?>)
                    </label>
                </div>
            <?php endwhile; ?>

            <button type="submit">Create Contest</button>
        </form>
    </div>
</body>
</html>
