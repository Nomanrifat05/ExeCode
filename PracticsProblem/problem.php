<?php
include("../Include/Connection.php");
session_start();

$problem_id = isset($_GET['problem_id']) ? intval($_GET['problem_id']) : 1;
$user_id = $_SESSION['user_id'] ?? 0;
$contest_id = isset($_GET['contest_id']) ? intval($_GET['contest_id']) : 0;

// Save open time if not already saved
$insertTimeStmt = $conn->prepare("INSERT IGNORE INTO problem_start_times (user_id, problem_id, opened_at) VALUES (?, ?, NOW())");
$insertTimeStmt->bind_param("ii", $user_id, $problem_id);
$insertTimeStmt->execute();

// Fetch the problem
$stmt = $conn->prepare("SELECT * FROM problem_set WHERE id = ?");
$stmt->bind_param("i", $problem_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die("Problem not found.");
}

$problem = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>ExeCode - <?php echo htmlspecialchars($problem['title']); ?></title>
  <link rel="stylesheet" href="../Include/Navbar.css">
  <link rel="stylesheet" href="../PracticsProblem/problem.css">
</head>

<body>
  <?php include("../Include/Navbar.php"); ?>

  <div class="container">
    <!-- Problem Title -->
    <h3 class="title"><?= htmlspecialchars($problem['title']) ?></h3>

    <!-- Limits -->
    <div class="limit">
      <p>Time-limit: <?= htmlspecialchars($problem['time_limit']) ?></p>
      <p>Memory-Limit: <?= htmlspecialchars($problem['memory_limit']) ?></p>
    </div>

    <!-- Description -->
    <div class="statement">
      <p><?= nl2br(htmlspecialchars($problem['statement'])) ?></p>
    </div>

    <!-- Input/Output Format -->
    <div class="formate-con">
      <div class="formate">Input format</div>
      <p><?= nl2br(htmlspecialchars($problem['input_format'])) ?></p>

      <div class="formate">Output format</div>
      <p><?= nl2br(htmlspecialchars($problem['output_format'])) ?></p>
    </div>

    <!-- Sample Input/Output -->
    <div class="inp-out">
      <div class="in-ou">Input:</div>
      <p id="sampleInput"><?= htmlspecialchars($problem['input']) ?></p>
      <div class="in-ou">Output:</div>
      <p id="expectedOutput"><?= htmlspecialchars($problem['output']) ?></p>
    </div>

    <!-- Code Editor -->
    <div id="ide" class="code-editor"></div>

    <!-- Console Input -->
    <section class="console">
      <h2>Console</h2>
      <textarea id="console"><?php echo htmlspecialchars($problem['input']); ?></textarea>
    </section>

    <!-- Buttons -->
    <div class="button-con">
      <button id="run" class="run button">Run</button>
      <button id="submit" class="submit button">Submit</button>
    </div>

    <!-- Output -->
    <div id="output" style="white-space: pre-wrap; margin-top: 15px;"></div>
  </div>

  <script src="https://unpkg.com/monaco-editor@latest/min/vs/loader.js"></script>
  <script>
    require.config({ paths: { vs: "https://unpkg.com/monaco-editor@latest/min/vs" } });
    window.MonacoEnvironment = {
      getWorkerUrl: () => URL.createObjectURL(new Blob([`
        self.MonacoEnvironment = { baseUrl: 'https://unpkg.com/monaco-editor@latest/min/' };
        importScripts('https://unpkg.com/monaco-editor@latest/min/vs/base/worker/workerMain.js');
      `], { type: 'text/javascript' }))
    };

    let editor;
    require(["vs/editor/editor.main"], function () {
      editor = monaco.editor.create(document.getElementById("ide"), {
        value: `#include <iostream>\nusing namespace std;\n\nint main() {\n  // Your code here\n  return 0;\n}`,
        language: "cpp",
        theme: "vs-dark",
        automaticLayout: true,
        scrollBeyondLastLine: false,
        minimap: { enabled: false },
        fontSize: 14
      });
      document.getElementById("ide").style.height = "400px";
      editor.layout();
    });

    const runBtn = document.getElementById("run");
    const submitBtn = document.getElementById("submit");
    const outputDiv = document.getElementById("output");

    async function runCode(submit = false) {
      const sourceCode = editor.getValue();
      const inputText = document.getElementById("console").value;
      const expectedOutput = `<?php echo trim($problem['output']); ?>`;
      outputDiv.innerText = "Running...";

      const payload = {
        source_code: sourceCode,
        language_id: 54,
        stdin: inputText,
        cpu_time_limit: 2,
        memory_limit: 262144
      };

      try {
        let res = await fetch("https://judge0-ce.p.rapidapi.com/submissions?base64_encoded=false&wait=true", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-RapidAPI-Host": "judge0-ce.p.rapidapi.com",
            "X-RapidAPI-Key": "d2b6e24504msh1e16f9c83fec697p181867jsn200c6e79083c"
          },
          body: JSON.stringify(payload)
        });

        let data = await res.json();
        let verdict = data.status?.description || "";

        if (data.stdout) {
          let output = data.stdout.trim();
          if (verdict === "Accepted" && output !== expectedOutput.trim()) {
            verdict = "Wrong Answer";
          }
          outputDiv.innerText = `Output:\n${output}\nVerdict: ${verdict}`;
        } else if (data.stderr || data.compile_output) {
          verdict = "Compilation/Error";
          outputDiv.innerText = data.stderr || data.compile_output;
        } else {
          verdict = "Error";
          outputDiv.innerText = "No output returned.";
        }

        if (submit) {
          await fetch("save_submission.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              user_id: <?php echo $user_id; ?>,
              problem_id: <?php echo $problem_id; ?>,
              contest_id: <?php echo $contest_id; ?>,
              code: sourceCode,
              language: "cpp",
              status: verdict,
              runtime: data.time || 0,
              output: data.stdout || "",
              error: data.stderr || data.compile_output || "",
              input: inputText
            })
          });
        }
      } catch (err) {
        outputDiv.innerText = "Error: " + err.message;
      }
    }

    runBtn.addEventListener("click", () => runCode(false));
    submitBtn.addEventListener("click", () => runCode(true));
  </script>
</body>

</html>
