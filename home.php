<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
}
?>

<html>

<head>
    <title>Home Page</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">

</head>

<body>
    <div class="container">
        <a class="float-right" href="logout.php">Logout</a>
        <h1>Welcome <?php echo $_SESSION['username']; ?></h1>
    </div>
</body>

</html>