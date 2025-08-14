<?php
include("../Include/Connection.php");

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid data"]);
    exit;
}

$user_id = intval($data['user_id']);
$problem_id = intval($data['problem_id']);
$contest_id = intval($data['contest_id']);
$code = $conn->real_escape_string($data['code']);
$language = $conn->real_escape_string($data['language']);
$status = $conn->real_escape_string($data['status']);
$runtime = floatval($data['runtime']);
$output = $conn->real_escape_string($data['output']);
$error = $conn->real_escape_string($data['error']);
$input = $conn->real_escape_string($data['input']);

// 🔥 Count previous attempts by this user on this problem in this contest
$triesQuery = $conn->prepare("SELECT COUNT(*) as total FROM submissions WHERE user_id = ? AND problem_id = ? AND contest_id = ?");
$triesQuery->bind_param("iii", $user_id, $problem_id, $contest_id);
$triesQuery->execute();
$triesResult = $triesQuery->get_result();
$tries = ($triesResult->fetch_assoc()['total'] ?? 0) + 1; // include current try

// ✅ Mark Calculation Logic
$marks = 0;
if (strtolower($status) === 'accepted') {
    if ($tries == 1) $marks = 10;
    elseif ($tries == 2) $marks = 8;
    elseif ($tries == 3) $marks = 6;
    else $marks = 5;
}

// ✅ Insert submission with marks
$sql = "INSERT INTO submissions (user_id, problem_id, contest_id, code, language, status, runtime, output, error, input, marks)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiisssssssi", $user_id, $problem_id, $contest_id, $code, $language, $status, $runtime, $output, $error, $input, $marks);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "marks" => $marks]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "DB insert failed"]);
}
