<?php
session_start();
if (empty($_SESSION["isLogged"])) {
    header("location: login.php");
    exit;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Dashboard</title>
    <style>
        body {
            background-color: #222;
            color: #fff;
            font-family: Arial, sans-serif;
        }
        
        h1, h5 {
            color: #fff;
            margin-bottom: 20px;
        }
        
        h1 span {
            color: #FF5733;
        }
        
        .nav {
            width: 100%;
            background-color: #111;
            padding: 0 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;

        }
        
        .nav-logo img {
            height: 100px;
            width: auto;
        }
        
        .nav-button .actionBtn {
            color: #fff;
            background-color: #FF5733;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1em;
        }
        
        .nav-button .actionBtn:hover {
            background-color: #FF3D00;
        }
        
        .container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 30px;
        }
        
        .table {
            background-color: #444;
            border-radius: 10px;
            margin-top: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .table th, .table td {
            color: black;
            text-align: center;
        }
        
        .table th {
            background-color: #333;
        }
        
        .table tr:hover {
            background-color: #555;
            cursor: pointer;
        }
        
        .table .btn {
            background-color: #FF5733;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            transition: background-color 0.3s;
        }
        
        .table .btn:hover {
            background-color: #FF3D00;
        }
        
        .footer {
            color: #fff;
            text-align: center;
            margin-top: 30px;
        }
        
        .footer a {
            color: #FF5733;
            text-decoration: none;
        }
        
        .footer a:hover {
            color: #FF3D00;
        }

    </style>
</head>
<body>
    <div class="wrapper">
        <nav class="nav">
            <div class="nav-logo">
                <img src="POLOS.svg" alt="logo">
            </div>
            <div class="nav-button">
                <a href="logout.php" class="actionBtn">Log out</a>
            </div>
        </nav>

        <div class="container">
            <h1 class='text-center'>Welcome <span><?= $_SESSION['username'] ?></span> to your dashboard</h1>
            <h5 class='text-center'>Here are your list of anime</h5>
            <table class="table table-striped table-hover border rounded-circle">
                <thead>
                    <tr>
                        <th>Anime Name</th>
                        <th>Genre</th>
                        <th>Rating</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class='table-group-divider'>
                    <tr>
                        <td>One Piece</td>
                        <td>Action, Adventure, Fantasy</td>
                        <td>8.72</td>
                        <td>
                            <button class="btn btn-outline-warning">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Attack on Titan</td>
                        <td>Action, Award Winning, Drama, Suspense</td>
                        <td>8.55</td>
                        <td>
                            <button class="btn btn-outline-warning">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>HUNTER×HUNTER</td>
                        <td>Action, Adventure, Fantasy</td>
                        <td>9.04</td>
                        <td>
                            <button class="btn btn-outline-warning">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class='text-center'>
                <a href="#" class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Explore more anime</a>
            </p>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
