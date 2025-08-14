<?php
include("../Include/Connection.php");

$contest_id = isset($_GET['contest_id']) ? intval($_GET['contest_id']) : 0;
if ($contest_id === 0) die("Contest ID missing.");

$problems = [];
$problemQuery = $conn->prepare("
  SELECT ps.id, ps.title
  FROM contest_problems cp
  JOIN problem_set ps ON cp.problem_set_id = ps.id
  WHERE cp.contest_id = ?
  ORDER BY cp.id ASC
");
$problemQuery->bind_param("i", $contest_id);
$problemQuery->execute();
$problemResult = $problemQuery->get_result();
while ($row = $problemResult->fetch_assoc()) {
  $problems[$row['id']] = $row['title'];
}

// Note: changed query to get users who submitted to problems of THIS contest only (with contest_id filter)
$userQuery = $conn->prepare("SELECT DISTINCT user_id FROM submissions WHERE contest_id = ?"); // EDITED
$userQuery->bind_param("i", $contest_id); // EDITED
$userQuery->execute();
$userResults = $userQuery->get_result();
$userIds = [];
while ($row = $userResults->fetch_assoc()) {
  $userIds[] = $row['user_id'];
}

$usernames = [];
if (count($userIds) > 0) {
  $ids = implode(',', $userIds);
  $userInfo = $conn->query("SELECT id, username FROM users_info WHERE id IN ($ids)");
  while ($row = $userInfo->fetch_assoc()) {
    $usernames[$row['id']] = $row['username'];
  }
}

$standings = [];
foreach ($userIds as $uid) {
  $entry = ['uid' => $uid, 'solved' => 0, 'penalty' => 0, 'problems' => []];

  foreach ($problems as $pid => $title) {
    // IMPORTANT: added contest_id filter here to consider only submissions in this contest
    $subs = $conn->query("SELECT status, submitted_at FROM submissions WHERE user_id=$uid AND problem_id=$pid AND contest_id=$contest_id ORDER BY submitted_at"); // EDITED
    $tries = 0;
    $solved = false;
    $time = 0;
    while ($sub = $subs->fetch_assoc()) {
      $tries++;
      $status = strtolower(trim($sub['status']));
      if ($status === 'accepted') {
        $solved = true;
        $openedRes = $conn->query("SELECT opened_at FROM problem_start_times WHERE user_id=$uid AND problem_id=$pid"); // optionally add contest_id filter here if you store it in that table
        if ($openedRes && $openedRes->num_rows > 0) {
          $opened = $openedRes->fetch_assoc();
          $time = strtotime($sub['submitted_at']) - strtotime($opened['opened_at']);
          if ($time < 0) $time = 0;
        } else {
          $time = 0;
        }
        break;
      }
    }
    $entry['problems'][$pid] = ['solved' => $solved, 'tries' => $tries, 'time' => $time];
    if ($solved) {
      $entry['solved']++;
      $entry['penalty'] += $time + ($tries - 1) * 20 * 60;
    }
  }
  $standings[] = $entry;
}

usort($standings, function ($a, $b) {
  return ($b['solved'] <=> $a['solved']) ?: ($a['penalty'] <=> $b['penalty']);
});
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>ExeCode - Standings</title>
  <link rel="stylesheet" href="../Include/Navbar.css" />
  <link rel="stylesheet" href="standings.css" />
</head>

<body>
  <?php include("../Include/Navbar.php"); ?>

  <main class="standings">
    <h2>Standings - Contest #<?= $contest_id ?></h2>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Who</th>
            <th>Solved</th>
            <th>Penalty</th>
            <?php foreach (array_keys($problems) as $index => $pid): ?>
              <th><?= chr(65 + $index) ?></th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php $rank = 1;
          foreach ($standings as $stat): ?>
            <tr>
              <td><?= $rank++ ?></td>
              <td><?= htmlspecialchars($usernames[$stat['uid']] ?? 'Unknown') ?></td>
              <td><?= $stat['solved'] ?></td>
              <td><?= gmdate("H:i", $stat['penalty']) ?></td>
              <?php foreach ($problems as $pid => $_):
                $p = $stat['problems'][$pid];
                if ($p['solved']) {
                  echo "<td class='solved'>+<span class='attempts'>{$p['tries']}<br>" . gmdate("H:i", $p['time']) . "</span></td>";
                } elseif ($p['tries'] > 0) {
                  echo "<td class='unsolved'>-{$p['tries']}</td>";
                } else {
                  echo "<td class='no-attempt'>.</td>";
                }
              endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>
</body>

</html>
