<?php
session_start();
require_once 'db.php';

$username = $password = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($username) || empty($password)) {
        $errors['loginState'] = 'Please enter both username and password.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION["isLogged"] = true;
                $_SESSION['userId'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: dashboard.php');
                exit();
            } else {
                $errors['loginState'] = "Invalid credentials. Please try again.";
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $errors['loginState'] = "An error occurred. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/7751476fd8.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="wrapper">
        <nav class="nav">
            <div class="nav-container">
                <img src="POLOS.svg" alt="Logo" class="nav-logo">
            </div>
        </nav>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="login-form">
            <h2>Login</h2>

            <?php if (isset($errors['loginState'])): ?>
                <div class="alert alert-warning" role="alert">
                    <strong><?= $errors['loginState'] ?></strong>
                </div>
            <?php endif; ?>

            <div class="input-box">
                <input type="text" class="input-field" placeholder="Username" name="username" value="<?= $username ?>">
                <i class="bx bx-user"></i>
                <span class='errorMsj'><?= isset($errors['username']) ? $errors['username'] : '' ?></span>
            </div>

            <div class="input-box">
                <input type="password" class="input-field" placeholder="Password" name="password" value="<?= $password ?>">
                <i class="bx bx-lock-alt"></i>
                <span class='errorMsj'><?= isset($errors['password']) ? $errors['password'] : '' ?></span>
            </div>

            <div class="input-box">
                <input type="submit" class="submit" value="Sign In">
            </div>

            <div class="footer">
                <span>Don't have an account? <a href="register.php">Sign Up</a></span>
            </div>
        </form>
    </div>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
