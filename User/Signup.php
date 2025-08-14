<?php
include("../Include/Connection.php");

$errors = [];
$email = '';
$username = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Basic validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }
    if($username === "Mahbub" || $username === "Noman" || $username === "Musfiq"){
        $errors[] = "User name is reserved";
    }

    // Check if email or username already exists
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users_info WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Email or username already exists.";
        }
        $stmt->close();
    }

    // Insert new user
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users_info (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        if ($stmt->execute()) {
            header("Location: Login.php");
            exit();
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../Include/Navbar.css">
    <link rel="stylesheet" href="Signup.css">
</head>

<body>

    <?php include("..\Include\Navbar.php"); ?>

    <div class="login-portal">
        <div class="login-img">
            <img src="../Image/Login.png" alt="login-img">
        </div>
        <div class="login">
            <h1 class="brand-name"><span class="first">Exe</span><span class="second">Code</span></h1>
            <form method="POST" autocomplete="off">
                <?php
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        echo "<div style='color:red;'>$error</div>";
                    }
                }
                ?>
                <input class="user-box" type="email" name="email" id="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
                <input class="user-box" type="text" name="username" id="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" required>
                <input class="user-box" type="password" name="password" id="password" placeholder="Password" required>
                <input class="user-box" type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>

                <div class="login-button">
                    <button type="submit">Register</button>
                </div>
            </form>

            <div class="forget">
                <p>Already have account?</p>
                <p><a href="Login.php">Login</a></p>
            </div>

            <div class="anther-sign">
                <p>Or you can sign with</p>
                <div class="icons">
                    <i class="fa-brands fa-google"></i>
                    <i class="fa-brands fa-github"></i>
                    <i class="fa-brands fa-facebook"></i>
                </div>
            </div>
        </div>
    </div>
</body>

</html>