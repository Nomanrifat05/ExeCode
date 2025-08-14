<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password</title>
    <link rel="stylesheet" href="Forget.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <form class="forgot-password-form">
            <h2><i class="fas fa-lock"></i> Forgot Password</h2>
            <p>Enter your email and we’ll send you a link to reset your password.</p>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Enter your email" required />
            </div>
            <button type="submit">Send Reset Link</button>
            <a href="login.html" class="back-link"><i class="fas fa-arrow-left"></i> Back to Login</a>
        </form>
    </div>
</body>

</html>