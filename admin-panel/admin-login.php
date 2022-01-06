<?php
    session_start();
    if(isset($_POST['submit-login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        //sql connection string
        $mysqli = NEW MySQLi('localhost','root','','EduThrift');
        $username = $mysqli->real_escape_string($username); 
        $password = $mysqli->real_escape_string($password);
        //query the database
        $resultSet = $mysqli->query("SELECT * FROM admin_account WHERE username='$username' AND pass='$password' LIMIT 1");
        if($resultSet->num_rows == 1){
            //Process login
            $result = $resultSet->fetch_assoc();
            $_SESSION["username"] = $result["username"];
            header("Location:admin-home.php");exit;
        } else {
            //credentials invalid
            $error = "The username or password you entered is invalid!";
            echo $error;
        }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Login</title>
    <link rel="stylesheet" href="../Authentication/styles.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200&display=swap" rel="stylesheet">
</head>
<body>
    <!-- <form action="" method="POST">
        Username: <input type="text" name="username">
        Password: <input type="password" name="password">
        <input type="submit" name="login">
    </form> -->
    <div class="container">
        <div class="user signinBx">
            <div class="formBx">
                <form action="admin-login.php" method="POST">
                    <h3>Admin - Log in</h3>
                    <input type="text" name="username" placeholder="Username" />
                    <input type="password" name="password" id="password" placeholder="Password" />
                    <input class="btn" type="submit" name="submit-login" value="Login" />
                    <?php
                        if (isset($error)) {
                            echo "<span>$error</span>";
                        }
                      ?>  
                </form>
            </div>
            <div class="imgBx">
                <h3>Share and use educational resources at a minimal cost</h3>
                <img src="../Authentication/images/EduThrift-logos_white.png" />
            </div>
        </div>
    </div>
</body>
</html>