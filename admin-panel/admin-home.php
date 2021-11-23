<?php
    session_start();
    if(!isset($_SESSION['username'])){
        echo "<p>session not set</p>";
        header("Location:admin-login.php");exit;    
    }
    $mysqli = NEW MySQLi('localhost','root','','EduThrift');
    $resultSet = $mysqli->query("SELECT * FROM account");
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Home</title>
</head>
<body>
    <h2>Admin home page</h2>
    <h5>Registered users:</h5>
    <?php
            if($resultSet->num_rows>0){
                echo '<table>';
                    echo '<tr><th>Username</th><th>First Name</th><th>Last Name</th></tr>';
                    while ($row = $resultSet->fetch_assoc()) {
                        echo "<tr><td>{$row['username']}</td><td>{$row['first_name']}</td><td>{$row['last_name']}</td></tr>";
                    }
                echo '</table>';
            } else {
                echo '<p>no records found </>';
            }
    ?>
</body>
</html>