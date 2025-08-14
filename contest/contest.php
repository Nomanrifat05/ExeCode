<?php
include '../Include/Connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json'); // Set default header for JSON responses

// Handle registration/unregistration requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $contest_id = isset($_POST['contest_id']) ? intval($_POST['contest_id']) : 0;
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($contest_id <= 0 || !in_array($action, ['register', 'unregister'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        exit;
    }

    try {
        if ($action === 'register') {
            // Check if already registered
            $sql = "SELECT id FROM user_contests WHERE user_id = ? AND contest_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $user_id, $contest_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo json_encode(['success' => false, 'message' => 'Already registered']);
                $stmt->close();
                exit;
            }
            $stmt->close();

            // Register user
            $sql = "INSERT INTO user_contests (user_id, contest_id, registered_at) VALUES (?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $user_id, $contest_id);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Registered successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Registration failed']);
            }
            $stmt->close();
        } elseif ($action === 'unregister') {
            // Unregister user
            $sql = "DELETE FROM user_contests WHERE user_id = ? AND contest_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $user_id, $contest_id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    echo json_encode(['success' => true, 'message' => 'Unregistered successfully']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Not registered for this contest']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Unregistration failed']);
            }
            $stmt->close();
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }

    $conn->close();
    exit; // Exit after handling the POST request
}

// Reset content type for HTML rendering
header('Content-Type: text/html; charset=UTF-8');

// Function to update contest statuses based on current time
function updateContestStatuses($conn, $currentTime) {
    // Update upcoming to ongoing
    $sql = "UPDATE contests SET status = 'ongoing' WHERE status = 'upcoming' AND start_time <= ? AND end_time >= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $currentTime, $currentTime);
    $stmt->execute();
    $stmt->close();

    // Update ongoing to past
    $sql = "UPDATE contests SET status = 'past' WHERE status = 'ongoing' AND end_time < ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $currentTime);
    $stmt->execute();
    $stmt->close();
}

// Get current time in Asia/Dhaka timezone
date_default_timezone_set('Asia/Dhaka');
$currentTime = (new DateTime())->format('Y-m-d H:i:s');

// Update statuses in the database
updateContestStatuses($conn, $currentTime);

// Initialize arrays for contest categories
$upcomingContests = [];
$ongoingContests = [];
$pastContests = [];

// Fetch registered contests for the logged-in user
$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
$registered_contests = [];
if ($user_id > 0) {
    $sql = "SELECT contest_id FROM user_contests WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $registered_contests[] = $row['contest_id'];
    }
    $stmt->close();
}

// Fetch all contests from the database
$sql = "SELECT * FROM contests ORDER BY start_time ASC";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $startTime = new DateTime($row['start_time']);
        $endTime = new DateTime($row['end_time']);

        if ($currentTime >= $startTime->format('Y-m-d H:i:s') && $currentTime <= $endTime->format('Y-m-d H:i:s')) {
            $ongoingContests[] = $row;
        } elseif ($currentTime > $endTime->format('Y-m-d H:i:s')) {
            $pastContests[] = $row;
        } else {
            $upcomingContests[] = $row;
        }
    }
    $result->free();
} else {
    die("Error fetching contests: " . $conn->error);
}

echo "<!-- Debug: Number of past contests: " . count($pastContests) . " -->"; // Debug comment
include('..\Include\Navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contest</title>
    <link rel="stylesheet" href="contest.css">
    <link rel="stylesheet" href="..\Include\Navbar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</head>
<body>
  <div class="contest-title">
    <!-- <img id="rotating-text" src="trophy.png" alt="Trophy"> -->
     <img src="trophy.png" alt="Trophy">
    <!-- <h1 id="dancing-text"><span class="exe-color">Exe</span>Code Contest</h1> -->
    <h1><span class="exe-color">Exe</span>Code Contest</h1>
    <p>Contest every week. Compete and see your ranking!</p>
  </div>

  <div class="container-upcoming-contest">
    <div class="upcoming-contest-title">
      <p id="blinking-text">Upcoming Contests</p>
    </div>
    <div class="container swiper">
      <div class="card-wrapper" id="upcoming-card-wrapper">
        <ul class="card-list swiper-wrapper" id="upcoming-card-list">
          <?php
          date_default_timezone_set("Asia/Dhaka");
          foreach ($upcomingContests as $contest):
              $futureDate = $contest['start_time'];
              $endDate = $contest['end_time'];
              $is_registered = in_array($contest['id'], $registered_contests) ? 'true' : 'false';
          ?>
            <li class="card-item swiper-slide" data-start="<?= htmlspecialchars($futureDate) ?>" data-end="<?= htmlspecialchars($endDate) ?>" data-contest-id="<?= $contest['id'] ?>">
              <a href="#" class="card-link">
                <div class="card-container">
                  <div class="img-box">
                    <img src="contest.jpg" alt="Card Image" class="card-image" />
                    <div class="contest-info">
                      Starts in <span class="countdown-timer" data-target="<?= (new DateTime($contest['start_time']))->format('c') ?>"></span>
                    </div>
                  </div>
                  <div class="content-box">
                    <p class="badge"><?= htmlspecialchars($contest['title']) ?></p>
                    <h2 class="card-time"><?= (new DateTime($contest['start_time']))->format('l h:i A') ?> GMT+6</h2>
                    <button class="card-button" data-registered="<?= $is_registered ?>" <?= $is_registered === 'true' ?  : '' ?>>
                      <?= $is_registered === 'true' ? 'Registered' : 'Register' ?>
                    </button>
                  </div>
                </div>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="swiper-pagination"></div>
        <div class="swiper-slide-button swiper-button-prev"></div>
        <div class="swiper-slide-button swiper-button-next"></div>
      </div>
    </div>
  </div>

  <div class="container-ongoing-contest">
    <div class="ongoing-contest-title">
      <p id="blinking-text">Ongoing Contests</p>
    </div>
    <div class="container">
      <ul class="card-list ongoing-card-list" id="ongoing-card-list">
        <?php foreach ($ongoingContests as $contest): 
            $is_registered = in_array($contest['id'], $registered_contests);
        ?>
          <li class="card-item" data-start="<?= htmlspecialchars($contest['start_time']) ?>" data-end="<?= htmlspecialchars($contest['end_time']) ?>" data-contest-id="<?= $contest['id'] ?>">
            <a href="#" class="card-link">
              <div class="card-container">
                <div class="img-box">
                  <img src="contest.jpg" alt="Card Image" class="card-image" />
                  <div class="contest-info">
                    Ends in <span class="countdown-timer" data-target="<?= (new DateTime($contest['end_time']))->format('c') ?>"></span>
                  </div>
                </div>
                <div class="content-box2">
                  <p class="badge"><?= htmlspecialchars($contest['title']) ?></p>
                  <?php if ($is_registered): ?>
                   <!-- <a href="../ProblemSet/problemset.php" class="card-link"> -->
                     <button class="open-contest-btn" data-contest-id="<?= $contest['id'] ?>">&#8658;</button>
                   <!-- </a> -->
                    <!-- <button class="open-contest-btn" data-contest-id="<?= $contest['id'] ?>">Open <?= htmlspecialchars($contest['title']) ?></button> -->
                  <?php endif; ?>
                </div>
              </div>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <div class="main-container">
    <div class="sub-tabs">
      <button onclick="showSubTab('past-contests')" class="active">Past Contests</button>
      <button onclick="showSubTab('my-contests')">My Contests</button>
    </div>

   <div id="past-contests" class="sub-tab-content active">
  <div class="past-contests-header">
    <div></div>
  </div>
  <div class="past-contests-list" id="past-contests-list">
    <?php 
    echo "<!-- Debug: Number of past contests: " . count($pastContests) . " -->"; // Existing debug
    foreach ($pastContests as $contest): 
        echo "<!-- Debug: Processing contest ID: " . (isset($contest['id']) ? $contest['id'] : 'null') . " -->";
    ?>
      <div class="contest-card" data-id="<?= isset($contest['id']) ? $contest['id'] : '<!-- Debug: No ID -->' ?>" data-contest-id="<?= isset($contest['id']) ? $contest['id'] : '<!-- Debug: No ID -->' ?>" <?= !isset($contest['id']) ? 'style="background: red;"' : '' ?>>
        <img src="contest.jpg" alt="Contest Icon">
        <div>
          <h3><?= htmlspecialchars($contest['title']) ?></h3>
          <p>Ended: <?= (new DateTime($contest['end_time']))->format('M d, Y h:i A') ?> GMT+6</p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="pagination" id="pagination">
    <button onclick="changePage('prev')" id="prev-page"><</button>
    <div id="page-numbers"></div>
    <button onclick="changePage('next')" id="next-page">></button>
  </div>
</div>

   <div id="my-contests" class="sub-tab-content">
      <table class="my-contests-table">
        <thead>
          <tr>
            <th>Contest</th>
            <th>Solved</th>
            <th>Ranking</th>
          </tr>
        </thead>
        <tbody id="my-contests-body">
            <?php
          if ($user_id > 0) {
              $sql = "SELECT uc.contest_id, c.title FROM user_contests uc JOIN contests c ON uc.contest_id = c.id WHERE uc.user_id = ?";
              $stmt = $conn->prepare($sql);
              $stmt->bind_param("i", $user_id);
              $stmt->execute();
              $result = $stmt->get_result();
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td><a href=\"../ProblemSet/problemset.php?contest_id=" . $row['contest_id'] . "\">" . htmlspecialchars($row['title']) . "</a></td>";
                  echo "<td>0/0</td>"; // Placeholder for Solved
                  echo "<td>N/A</td>"; // Placeholder for Ranking
                  echo "</tr>";
              }
              $stmt->close();
          } else {
              echo "<tr><td colspan='3'>Please log in to see your contests.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="contest_register.js"></script>
  <script src="contest.js"></script>
  <script src="contesttabs.js"></script>
 <script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.open-contest-btn').forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        const contestId = button.getAttribute('data-contest-id');
        console.log('Ongoing Contest Button Data:', button.dataset);
        console.log('Ongoing Contest ID:', contestId);
        if (!contestId) console.error('No contest ID found for button:', button);
        window.location.href = `../ProblemSet/problemset.php?contest_id=${contestId || 'undefined'}`;//eta te nia jay
      });
    });

    document.querySelectorAll('.contest-card').forEach(card => {
      card.addEventListener('click', (e) => {
        e.preventDefault();
        const contestId = card.getAttribute('data-contest-id');
        console.log('Past Contest Card Data:', card.dataset);
        console.log('Past Contest ID:', card.getAttribute('data-contest-id')); // Double-check
        if (!contestId) console.error('No contest ID found for card:', card);
        window.location.href = `../ProblemSet/problemset.php?contest_id=${contestId || 'undefined'}`;
      });
    });

    document.querySelectorAll('.my-contests-table a').forEach(link => {
      console.log('My Contests Link HREF:', link.href);
    });
  });
</script>
</body>
</html>