<html lang="en">
<?php
include 'helpers/php_mail.php';
require_once './helpers/connect_db.php';
require './vendor/autoload.php';

session_start();
if (!isset($_SESSION['user'])) {
  header('location:./Authentication/registration.php');  
}
//$account=$_SESSION['user'];
$error = NULL;

//DATABSE CONNECTION
$mysqli = connectDB();

//RETRIEVING THE DATA FROM THE DATABASE
$retrieve_data = $mysqli->query("SELECT * FROM account WHERE id={$_SESSION['user']['id']}");
$account = $retrieve_data->fetch_assoc();

//UPDATING THE DATA IN THE DATABASE (EDIT BUTTON)
if (isset($_POST['update-button'])) {
  //get form data 
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $username = $_POST['username'];

  //Sanitize data for any sql injection chars
  $first_name = $mysqli->real_escape_string($first_name);
  $last_name = $mysqli->real_escape_string($last_name);
  $username = $mysqli->real_escape_string($username);

  //Update Query to add the updated values
  $update =  $mysqli->query("UPDATE account SET first_name='$first_name',last_name='$last_name', username='$username' WHERE id={$account['id']}");
  header("location:profile.php");
  exit;
}

//UPDATING A NEW PASSWORD
if (isset($_POST['password-update-button'])) {
  //get form data
  $password1 = $_POST['password1'];
  $password2 = $_POST['password2'];
 
  //Sanitize data for any sql injection chars
  $password1 = $mysqli->real_escape_string($password1);
  $password2 = $mysqli->real_escape_string($password2);

  //Generate hashed password      
  $password1 = md5($password1);
  $password2 = md5($password2);

  if((strlen($_POST['password2']) > 6)&&($password1 == $account['password'])){ 
    $mysqli->query("UPDATE account SET password='$password2' WHERE id={$account['id']}");
    echo '<script>alert("Password changed Successfully!!")</script>';
  }
  elseif (($password1 != $account['password'])) {
    echo '<script>alert("Enter Correct Old Password")</script>';
  }
  elseif(($password1 != $account['password'])||($password1 == $account['password'])&&(strlen($_POST['password2']) < 6)){
    echo '<script>alert("Password should be atleast 6 characters long")</script>';
  }
  else{
    echo '<script>alert("Enter correct old password and new password")</script>';
  }
  unset($_POST['password-update-button']);
}
//UPDATING EMAIL
if (isset($_POST['email-update-button'])) {
  $email = $mysqli->real_escape_string($_POST['new-email']);

  //Generate Vkey
  $vkey = md5(time().$account['username']);
  $insert = $mysqli->query("UPDATE account SET email='$email',vkey='$vkey',verified=0 WHERE id={$account['id']}");
  if ($insert){
      $subject="Verification Key for your EduThrift accout";
      $body="<a href='http://localhost/library/eduthrift/authentication/verify.php?vkey=$vkey&username={$account['username']}'>Verify Account</a>";
      php_mail($email,$subject,$body);
      echo '<script>alert("Verification mail has been sent to your E-mail")</script>';
  }else{
      $error="This email has already been registered! Log in with your credentials."; 
  }
}


//UPLOADING A PROFILE PICTURE
if (isset($_POST['upload-profile-button'])) {
   //$mysqli = connectDB();

  //get form data
  $fileName = basename($_FILES["myFile"]["name"]);

  $targetDir = "uploads/profile/";
  $targetFilePath = $targetDir . $fileName;

  if ($mysqli->connect_error) {
    echo "$mysqli->connect_error";
    die("Connection failed: " . $mysqli->connect_error);
  } else {
    echo "Connected";
    // echo "Product upload successful";
    if (!empty($_FILES["myFile"]["name"])) {
      // Upload file to server
      move_uploaded_file($_FILES["myFile"]["tmp_name"], $targetFilePath);
      // Insert image file name into database
      $insert = $mysqli->query("UPDATE account SET image='$fileName' WHERE id={$account['id']}");

      if ($insert) {
        $statusMsg = "The file " . $fileName . " has been uploaded successfully.";
      } else {
        $statusMsg = "File upload failed, please try again.";
      }
    } else {
      $statusMsg = 'Please select a file to upload.';
    }
  }
  header("location:profile.php");exit;
}

//For updating/setting address

if(isset($_POST['addr-submit'])){
    $insert = $mysqli->query("UPDATE account SET address_line='{$_POST['address-line']}', city='{$_POST['city']}', state='{$_POST['state']}',
                               pincode='{$_POST['pincode']}', lat='{$_POST['lat']}', lon='{$_POST['lon']}' WHERE id={$account['id']}");
    if ($insert) {
      $statusMsg = "The address has been updated successfully.";
    } else {
      $statusMsg = "address update failed, please try again.";
    }
    header("location:profile.php");exit;
}


if(isset($_POST['logout-button'])){
  header('location:logout.php');exit;
}
$mysqli->close();
?>



<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <link rel="stylesheet" href="css/profile.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>

  <?php include_once './shared/navbar.php' ?>

  <!---DESCRIPTION-->

  <div class="profile l-section">
    <div class="details1">
      <div class="pfp">
        <div class="profile-image">
          <img src="<?php echo 'uploads/profile/' . $account['image']; ?>" alt="" width="100px" height="100px">
        </div>
        <div class="pop-up image-popup">
          <div class="content">
            <div class="container">
              <div class="dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
              </div>

              <span class="close">close</span>

              <div class="title">
                <h1>Upload Profile ?</h1>
              </div>

              <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/256492/cXsiNryL.png" alt="Car">

              <div class="subscribe">
                <h1>Upload pic</h1>

                <form action="profile.php" method="POST" enctype="multipart/form-data">
                  <div class="file-upload">
                    <input type="file" name="myFile" id="myFile" accept="image/png, image/jpeg">
                    <!-- <button class="file-upload__button" type="button">Choose Image(s)</button> -->
                    <!-- <span class="file-upload__label"></span> -->
                  </div>
                  <input type="submit" style="color: #fff;" name="upload-profile-button" value="Upload" />
                </form>
              </div>
            </div>
          </div>
        </div>


        <div class="profile-text">
          <p class="profilename"><?php echo $account['first_name'] ?>&nbsp;<?php echo $account['last_name'] ?></p>
          <p class="profilelocation"><?php echo $account['city'] ?>, <?php echo $account['state'] ?></p>
        </div>
        <div class="personalDetails_button">
          <button class="editbutton js-toggleForm" type="reset">Edit</button>
        </div>

      </div>

      <form action="profile.php" class="form" method="POST">
        <div class="personalDetails">
          <div class="pd">
            <div class="personalDetails_text">
              <p class="heading">First Name: </p>
              <input type="text" name="first_name" value=<?php echo $account['first_name'] ?> >
            </div>
          </div>
          <div class="pd">
            <div class="personalDetails_text">
              <p class="heading">Last Name: </p>
              <input type="text" name="last_name" value=<?php echo $account['last_name'] ?>>
            </div>
          </div>
          <div class="pd">
            <div class="personalDetails_text">
              <p class="heading">Email: </p>

              <div class="pop-input">
                <input type="text" name="email" value=<?php echo $account['email'] ?>>
              </div>
              <div class="pop-up email-popup">
                <form action="profile.php" method="POST">
                  <div class="content">
                    <div class="container">
                      <div class="dots">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                      </div>

                      <span class="close">close</span>

                      <div class="title">
                        <h1>Change E-mail?</h1>
                      </div>

                      <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/256492/cXsiNryL.png" alt="Car">

                      <div class="subscribe">
                        <h1>Enter New E-mail</h1>
                        <form >
                          <input type="text" name="new-email" placeholder="New E-mail">
                          <input type="submit" name="email-update-button" value="Submit">
                        </form>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- <div class="personalDetails_button">
              <button class="editbutton">edit</button>
            </div> -->

          </div>
          <div class="pd">
            <div class="personalDetails_text">
              <p class="heading">Username: </p>
              <input type="text" name="username" value=<?php echo $account['username'] ?>>
            </div>
          </div>
          <div class="pd">
            <div class="personalDetails_text">
              <p class="heading">Password: </p>
              <div class="pop-input1">
                <input type="password" name="password" value=<?php echo $account['password'] ?>>
              </div>

              <form action="profile.php" method="POST">
                <div class="pop-up1">
                  <div class="content">
                    <div class="container">
                      <div class="dots">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                      </div>

                      <span class="close">close</span>

                      <div class="title">
                        <h1>Change Password?</h1>
                      </div>

                      <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/256492/cXsiNryL.png" alt="Car">

                      <div class="subscribe">
                        <h1>Enter Password Details</h1>
                        <form >
                          <input type="password" name="password1" placeholder="Your old password">
                          <input type="password" name="password2" placeholder="Your new password">
                          <input type="submit" name="password-update-button" value="Submit">
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

              </form>



            </div>
            <!-- <div class="personalDetails_button">
              <button class="editbutton">Edit</button>
            </div> -->
          </div>

          <div class="location pd">
            <div class="personalDetails_text">
              <p class="heading">Address Line: </p>
              <a href="maps.php"><input type="text" name="address-line"  value="<?php echo $account['address_line'] ?>"></a>
            </div>
          </div>
          <div class="location pd">
            <div class="personalDetails_text">
              <p class="heading">City: </p>
              <a href="maps.php"><input type="text" name="city" value=<?php echo $account['city'] ?>></a>
            </div>
          </div>
          <div class="location pd">
            <div class="personalDetails_text">
              <p class="heading">State: </p>
              <a href="maps.php"><input type="text" name="state" value=<?php echo $account['state'] ?>></a>
            </div>
          </div>
          <div class="location pd">
            <div class="personalDetails_text">
              <p class="heading">Pincode</p>
              <a href="maps.php"><input type="text" name="pincode" value=<?php echo $account['pincode'] ?>></a>
            </div>
          </div>
      </form>
      <button style="
          width: 100px;
          font-family: Raleway;
          font-style: normal;
          background: #000000;
          color: #fff;" type="submit" name="update-button" class="btn">Submit</button>

    </div>

    <br>
      <form action="profile.php" method="POST">
          <button style="
            width: 100px;
            font-family: Raleway;
            font-style: normal;
            text-align:center;
            background: #000000;
            color: #fff;" type="submit" name="logout-button" class="btn">Sign out</button></a>
      </form>
  </div>


  <!--FOOTER SECTION-->
  <?php include_once './shared/footer.php' ?>
  <script src="./profile.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>

</body>

</html>