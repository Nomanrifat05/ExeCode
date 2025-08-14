<?php
include '../Include/Connection.php';

if (isset($_POST['login'])) {
    $username = trim($_POST['user_name']);
    $password = trim($_POST['password']);

    // Prevent SQL injection
    $stmt = $conn->prepare("SELECT id, password FROM users_info WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;

            header("Location: ../Home/Home.php");
            exit();
        } else {
            echo "<script>alert('Invalid username or password.');</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password.');</script>";
    }
    $stmt->close();
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../Include/Navbar.css">
    <link rel="stylesheet" href="Login.css">
</head>

<body>

    <?php
    include("..\Include\Navbar.php");
    ?>

    <div class="login-portal">
        <div class="login-img">
            <img src="../Image/Login.png" alt="login-img">
        </div>
        <div class="login">
            <h1 class="brand-name"><span class="first">Exe</span><span class="second">Code</span></h1>
            <form action="login.php" method="POST">
                <input class="user-box" type="text" name="user_name" placeholder="Username" required>
                <input class="user-box" type="password" name="password" placeholder="Password" required>

                <div class="login-button">
                    <button type="submit" name="login">Login</button>
                </div>
            </form>

            <div class="forget">
                <p>Forget Password?</p>
                <p><a href="Signup.php">Sign Up</a></p>
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