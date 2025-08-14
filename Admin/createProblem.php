<?php
include '../Include/Connection.php';  // Adjust path to your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data and sanitize
    $title = $conn->real_escape_string(trim($_POST['title']));
    $statement = $conn->real_escape_string(trim($_POST['statement']));
    $input = $conn->real_escape_string(trim($_POST['input']));
    $output = $conn->real_escape_string(trim($_POST['output']));
    $input_format = $conn->real_escape_string(trim($_POST['input_format']));
    $output_format = $conn->real_escape_string(trim($_POST['output_format']));
    $difficulty = $conn->real_escape_string(trim($_POST['difficulty']));
    // $time_limit = $_POST['time_limit'];
    $time_limit = $conn->real_escape_string(trim($_POST['time_limit']));
    $memory_limit = $_POST['memory_limit'];

    // Prepare SQL insert
    $sql = "INSERT INTO problem_set 
            (title, statement, input, output, input_format, output_format, difficulty, time_limit, memory_limit)
            VALUES 
            ('$title', '$statement', '$input', '$output', '$input_format', '$output_format', '$difficulty', $time_limit, $memory_limit)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Problem added successfully.'); window.location.href='createProblem.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crate Problem</title>
    <link rel="stylesheet" href="../Include/Navbar.css">
    <link rel="stylesheet" href="createProblem.css">
</head>

<body>

    <?php
    include("..\Include\Navbar.php");
    ?>

    <div class="container">
        <h2>Add New Problem</h2>
        <form action="createProblem.php" method="POST">
            <label>Title</label>
            <input type="text" name="title" placeholder="Enter problem title" required>

            <label>Statement</label>
            <textarea name="statement" rows="4" placeholder="Describe the problem statement" required></textarea>

            <label>Input</label>
            <textarea name="input" rows="3" placeholder="Example input" required></textarea>

            <label>Output</label>
            <textarea name="output" rows="3" placeholder="Expected output" required></textarea>

            <label>Input Format</label>
            <textarea name="input_format" rows="2" placeholder="Format of the input" required></textarea>

            <label>Output Format</label>
            <textarea name="output_format" rows="2" placeholder="Format of the output" required></textarea>

            <label>Difficulty</label>
            <select name="difficulty" required>
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Hard">Hard</option>
            </select>

            <label>Time Limit (s)</label>
            <input type="number" name="time_limit" placeholder="e.g., 1s" required>

            <label>Memory Limit (MB)</label>
            <input type="number" name="memory_limit" placeholder="e.g., 256" required>

            <button type="submit">Submit</button>
        </form>

    </div>
</body>

</html>