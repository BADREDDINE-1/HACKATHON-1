<?php
require_once 'db.php';

$username = $password = $confirm_password = $email = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (strlen($username) < 4) {
        $errors['username'] = 'Username must be at least 4 characters.';
    } else {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            $errors['username'] = 'Username is already taken. Please choose another one.';
        }
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        $errors['email'] = 'Invalid email format. Please enter a valid email address.';
    } else {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $errors['email'] = 'Email is already taken. Please choose another one.';
        }
    }

    if (
        strlen($password) < 8 ||
        !preg_match('/[A-Z]/', $password) ||
        !preg_match('/[a-z]/', $password) ||
        !preg_match('/[\W]/', $password) ||
        !preg_match('/[0-9]/', $password)
    ) {
        $errors['password'] = 'Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one special character, and one number.';
    }

    if (empty($confirm_password) || $password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords did not match.";
    }

    if (empty($errors)) {
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $passwordhash]);
            header('Location: login.php');
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $errors['registrationState'] = "Sorry, this email or username is already taken. Choose another one.";
            } else {
                echo 'Error: ' . $e->getMessage();
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/7751476fd8.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    <nav class="nav">
        <div class="nav-container">
            <img src="POLOS.svg" alt="Logo" class="nav-logo">
        </div>
    </nav>

    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="login-form">
        <h2>Register</h2>

        <?php if (isset($errors['registrationState'])): ?>
            <div class="alert alert-warning" style="color: red;"><?= $errors['registrationState'] ?></div>
        <?php endif; ?>

        <div class="input-box">
            <input type="text" name="username" class="input-field" placeholder="Username" value="<?= $username ?>">
            <i class="bx bx-user"></i>
            <span class="errorMsj" style="color: red;"><?= $errors['username'] ?? '' ?></span>
        </div>

        <div class="input-box">
            <input type="email" name="email" class="input-field" placeholder="Email" value="<?= $email ?>">
            <i class="bx bx-envelope"></i>
            <span class="errorMsj" style="color: red;"><?= $errors['email'] ?? '' ?></span>
        </div>

        <div class="input-box">
            <input type="password" name="password" class="input-field" placeholder="Password" value="<?= $password ?>">
            <i class="bx bx-lock-alt"></i>
            <span class="errorMsj" style="color: red;"><?= $errors['password'] ?? '' ?></span>
        </div>

        <div class="input-box">
            <input type="password" name="confirm_password" class="input-field" placeholder="Confirm Password" value="<?= $confirm_password ?>">
            <i class="bx bx-lock-alt"></i>
            <span class="errorMsj" style="color: red;"><?= $errors['confirm_password'] ?? '' ?></span>
        </div>

        <div class="input-box">
            <input type="submit" class="submit" value="Register">
        </div>

        <div class="footer">
            <span>Already have an account? <a href="login.php">Login</a></span>
        </div>
    </form>
</div>

<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
