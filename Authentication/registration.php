<html>
<?php
require '../helpers/php_mail.php';
require_once '../helpers/connect_db.php';
require '../vendor/autoload.php';
session_start();
$error = NULL;
if(isset($_POST['submit-login'])){
      //getting form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    //sql connection string
    $mysqli = connectDB();
    $username = $mysqli->real_escape_string($username); 
    $password = $mysqli->real_escape_string($password);
    $password = md5($password);
    //Query the database
    $resultSet = $mysqli->query("SELECT * FROM account WHERE username='$username' AND password='$password' LIMIT 1");
    if($resultSet->num_rows == 1){
        //Process login
        $result = $resultSet->fetch_assoc();
        if(!$result["verified"]){
            $error = "This account has not been verified. An email was sent to ". $result["email"] . " on " . date('M d Y',strtotime($result["createdate"]));
        } else {
            $_SESSION["user"] = $result;
            header("Location:../home.php");exit;
        }
        
    } else {
        //credentials invalid
        $error = "The username or password you entered is invalid!";
        echo $error;
    }
}
if(isset($_POST['submit-signup'])){
    //get form data 
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    if(strlen($password) < 6){
        $error = "<p>Your password must be atleast 6 characters long</p>";
    }else{
        //connect to the database
        $mysqli = connectDB();

        //Sanitize data for any sql injection chars
        $username = $mysqli->real_escape_string($username);
        $password = $mysqli->real_escape_string($password);
        $email = $mysqli->real_escape_string($email);
        $fname = $mysqli->real_escape_string($fname);
        $lname = $mysqli->real_escape_string($lname);

        //Generate Vkey
        $vkey = md5(time().$username);
        $password = md5($password);
        $insert = $mysqli->query("INSERT INTO ACCOUNT(username,password,email,first_name,last_name,vkey) 
            VALUES('$username','$password','$email','$fname','$lname','$vkey')");
        if ($insert){
            $subject="Verification Key for your EduThrift accout";
            $body="<a href='http://localhost/library/eduthrift/authentication/verify.php?vkey=$vkey&username=$username'>Verify Account</a>";
            php_mail($email,$subject,$body);
            $error="Verification mail has been sent to your E-mail";
        }else{
            $error="This email has already been registered! Log in with your credentials."; 
        }
    }
}
?>
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login and Registration</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="user signinBx">
            <div class="formBx">
                <form action="registration.php" method="POST">
                    <h3>Log in</h3>
                    <input type="text" name="username" placeholder="Username" />
                    <input type="password" name="password" id="password" placeholder="Password" />
                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                    <input class="btn" type="submit" name="submit-login" value="Login" />
                     <?php
                    if (isset($error)) {
                        echo "<span>$error</span>";
                    }
                    ?> 

                    <p class="signup">
                        Don't have an account ?<a href="#" onclick="toggleForm();">
                            Sign Up
                        </a>
                    </p>
                </form>
            </div>
            <div class="imgBx">
                <h3>Share and use educational resources at a minimal cost</h3>
                <img src="./images/signup.png" />
            </div>
        </div>
        <div class="user signupBx">
            <div class="imgBx">
                <h3>Share and use educational resources at a minimal cost</h3>
                <img src="./images/signup.png" />
            </div>
            <div class="formBx">
                <form action="registration.php" method="POST">
                    <h3>Sign Up</h3>
                    <input type="text" name="fname" placeholder="First Name" required/>
                    <input type="text" name="lname" placeholder="Last Name" required/>
                    <input type="email" name="email" placeholder="Email Id" required/>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" id="password" placeholder="Password" required/>
                    <i class="bi bi-eye-slash" id="togglePassword"></i> 
                   
                    <input class="btn" type="submit" name="submit-signup" value="Sign Up" />

                    <?php
                    if (isset($error)) {
                        echo "<span>$error</span>";
                    }
                    ?>
                    <p class="signup">
                        Already have an account ?
                        <a href="#" onclick="toggleForm();">Log in </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="password.js"></script>
<script src="signup.js"></script>

</html>