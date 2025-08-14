<?php
include '../Include/Connection.php';

$sql = "SELECT * FROM problem_set";
$result = $conn->query($sql);

// if ($result->num_rows > 0) {
//   while ($row = $result->fetch_assoc()) {
//     echo $row['title'] . "<br>";
//   }
// } else {
//   echo "No records found.";
// }


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ExeCode - Practice Problem</title>
  <link rel="stylesheet" href="../Include/Navbar.css">
  <link rel="stylesheet" href="practiceproblem.css">
</head>

<body>

  <?php include("../Include/Navbar.php"); ?>

  <main class="practice-problem-page">
    <section class="problem-table-section">
      <h2>Practice Problem</h2>
      <div class="problem-table-container">
        <table class="practice-problem-table">
          <thead>
            <tr>
              <th>Title</th>
              <!-- <th>Solution</th> -->
              <th>Acceptance</th>
              <th>Difficulty</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                // You can style difficulty class based on the value
                $difficultyClass = strtolower($row['difficulty']); // "easy", "medium", "hard"
                echo "<tr>";
                echo "<td><a href='problem.php?problem_id=" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a></td>";
                // echo "<td><a href='#'>Solution</a></td>";
                echo "<td>--</td>"; // Placeholder for acceptance
                echo "<td class='difficulty " . $difficultyClass . "'>" . htmlspecialchars($row['difficulty']) . "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='4'>No problems found.</td></tr>";
            }
            ?>
          </tbody>

        </table>
      </div>
    </section>
  </main>

</body>

</html>