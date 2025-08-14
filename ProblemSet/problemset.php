<?php
// ===== Updated problemset.php =====
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ExeCode - Problem Set</title>
  <link rel="stylesheet" href="../Include/Navbar.css">
  <link rel="stylesheet" href="problemset.css">
</head>

<body>
  <?php
  include("../Include/Navbar.php");
  include("../Include/Connection.php");

  $contest_id = isset($_GET['contest_id']) ? intval($_GET['contest_id']) : 0;
  if ($contest_id === 0) die("No contest selected.");

  $sql = "
    SELECT ps.id, ps.title, ps.time_limit, ps.memory_limit
    FROM contest_problems cp
    JOIN problem_set ps ON cp.problem_set_id = ps.id
    WHERE cp.contest_id = ?
    ORDER BY cp.id ASC
  ";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $contest_id);
  $stmt->execute();
  $result = $stmt->get_result();
  ?>

  <main class="problem-set">
    <h2>Problems for Contest #<?= htmlspecialchars($contest_id) ?></h2>
    <a class="aprob" href="../Standing/standing.php?contest_id=<?= $contest_id ?>">View Standings</a>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Details</th>
          <th>Solutions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $problemCode = 'A';
        while ($row = $result->fetch_assoc()) {
          $id = $row['id'];
          $title = htmlspecialchars($row['title']);
          $time_limit = $row['time_limit'] ?? 2;
          $memory_limit = $row['memory_limit'] ?? 1024;

          // 🆕 Count how many users solved this problem
          $solutionCountStmt = $conn->prepare("
            SELECT COUNT(DISTINCT user_id) as solved_count
            FROM submissions
            WHERE problem_id = ? AND contest_id = ? AND status = 'Accepted'
          ");
          $solutionCountStmt->bind_param("ii", $id, $contest_id);
          $solutionCountStmt->execute();
          $solutionResult = $solutionCountStmt->get_result();
          $solvedCount = $solutionResult->fetch_assoc()['solved_count'] ?? 0;

          echo "<tr>
                  <td>{$problemCode}</td>
                  <td><a href='../IDE/index.php?problem_id={$id}&contest_id={$contest_id}'>{$title}</a></td>
                  <td>Standard input/output<br>{$time_limit} s, {$memory_limit} MB</td>
                  <td>👨 x{$solvedCount}</td>
                </tr>";
          $problemCode++;
        }
        ?>
      </tbody>
    </table>
  </main>
</body>

</html>
