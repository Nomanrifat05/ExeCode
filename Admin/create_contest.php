<?php
include("../Include/Connection.php");

// Step 1: Receive form data
$title = $_POST['title'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$selected_problems = $_POST['selected_problems'] ?? [];

// Step 2: Insert into contests table
$stmt = $conn->prepare("INSERT INTO contests (title, start_time, end_time, status, created_at) VALUES (?, ?, ?, 1, NOW())");
$stmt->bind_param("sss", $title, $start_time, $end_time);
$stmt->execute();

// Step 3: Get the inserted contest ID
$contest_id = $conn->insert_id;

// Step 4: Insert selected problems into contest_problems
if (!empty($selected_problems)) {
    $stmt = $conn->prepare("INSERT INTO contest_problems (contest_id, problem_set_id) VALUES (?, ?)");
    foreach ($selected_problems as $problem_id) {
        $stmt->bind_param("ii", $contest_id, $problem_id);
        $stmt->execute();
    }
}

$stmt->close();
$conn->close();

// Step 5: Redirect or confirmation
echo "<script>alert('Contest created successfully!'); window.location.href='arrange_contest.php';</script>";
?>
