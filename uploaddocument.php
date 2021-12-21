<html lang="en">
    <?php
        // phpinfo();

        session_start();
        $error = NULL;
        if (!isset($_SESSION['user'])) {
            header('location:./Authentication/registration.php');  
      }
        $user=$_SESSION['user'];
    
        if(isset($_POST['upload-document'])) {
            include_once 'helpers/connect_db.php';
            $mysqli = connectDB();

            //SETTING VARIABLES FROM FORM DATA
            $docType = $_POST['doctype'];
            $grade = $_POST['grade'];
            $instituteName = $_POST['institutename'];
            $courseName = $_POST['coursename'];
            $boardOfEducation = $_POST['boardofeducation'];
            $docTitle = $_POST['doctitle'];
            $fileName = basename($_FILES["myFile"]["name"]);

            $targetDir = "uploads/documents/";      
            $targetFilePath = $targetDir . $fileName;
            //$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        
            if($mysqli->connect_error) {
                echo "$mysqli->connect_error";
                die ("Connection failed: ".$mysqli->connect_error);
            }
            else {
                echo "Connected";

                if(!empty($_FILES["myFile"]["name"])){
                            // Upload file to server
                            move_uploaded_file($_FILES["myFile"]["tmp_name"], $targetFilePath);
                            // Insert image file name into database
                            $insert = $mysqli->query("INSERT INTO DOCUMENT(title, class, board_of_education, course, institute, document, category, uploader_id) 
                                                VALUES('$docTitle', '$grade', '$boardOfEducation', '$courseName', '$instituteName', '$fileName' ,'$docType',{$user['id']})");
                            if($insert){
                                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                            }else{
                                $statusMsg = "File upload failed, please try again.";
                            } 
  
                        } else{
                                $statusMsg = 'Please select a file to upload.';
                             }

                // $insertdata = $mysqli->query("INSERT INTO DOCUMENTS(title, class, board_of_education, course, institute, category, user_id) 
                // VALUES('$docTitle', '$grade', '$boardOfEducation', '$courseName', '$instituteName', '$docType',212)");
                echo $statusMsg;

                $mysqli->close();
            }
        }
    ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Document</title>
    <link rel="stylesheet" href="./css/uploadproduct.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'shared/navbar.php'; ?>

    <!----UPLOAD-->
    <div class="uploaddiv uploadDocument">
        <form action="uploaddocument.php" method="POST" enctype="multipart/form-data">
            <h2 Align="Center" class="title1">Upload your Notes</h2>
            <br><br><br>

            <h3 class="title2">Document Details</h3>
            <br><br>

            <div class="formContent">
                <p class="subtitle">Select the categories your document falls under:</p>
                <input type="radio" name="doctype" value="textbooks">
                <span class="option">Textbooks</span><br>
                <input type="radio" name="doctype" value="classnotes">
                <span class="option">Class notes</span><br>
                <input type="radio" name="doctype" value="exampapers">
                <span class="option">Exam papers</span><br>
                <input type="radio" name="doctype" value="answers">
                <span class="option">Answers</span><br>
                <input type="radio" name="doctype" value="presentations">
                <span class="option">Presentation</span><br>
                <input type="radio" name="doctype" value="researchpapers">
                <span class="option">Research paper</span><br>
                <input type="radio" name="doctype" value="summary">
                <span class="option">Summary</span><br>
                <input type="radio" name="doctype" value="others">
                <span class="option">Others</span><br>


                <br><br><br>

                <p class="subtitle">Select the Class/Grade for which the documents are:</p>
                <input type="radio" name="grade" value="class1">
                <span class="option">Class 1</span><br>
                <input type="radio" name="grade" value="class2">
                <span class="option">Class 2</span><br>
                <input type="radio" name="grade" value="class3">
                <span class="option">Class 3</span><br>
                <input type="radio" name="grade" value="class4">
                <span class="option">Class 4</span><br>
                <input type="radio" name="grade" value="class5">
                <span class="option">Class 5</span><br>
                <input type="radio" name="grade" value="class6">
                <span class="option">Class 6</span><br>
                <input type="radio" name="grade" value="class7">
                <span class="option">Class 7</span><br>
                <input type="radio" name="grade" value="class8">
                <span class="option">Class 8</span><br>
                <input type="radio" name="grade" value="class9">
                <span class="option">Class 9</span><br>
                <input type="radio" name="grade" value="class10">
                <span class="option">Class 10</span><br>
                <input type="radio" name="grade" value="class11">
                <span class="option">Class 11 (Highschool)</span><br>
                <input type="radio" name="grade" value="class12">
                <span class="option">Class 12 (Highschool)</span><br>
                <input type="radio" name="grade" value="collegelevel">
                <span class="option">College Level</span>

                <br><br>
                <span class="option1">Add Institute Name:</span>
                <input type="text" class="textbox" name="institutename" value=""> <br>
                <span class="option1">Add Course Name:</span>
                <input type="text" class="textbox" name="coursename" value=""> <br>
                <span class="option1">Add Board of Education:</span>
                <input type="text" class="textbox" name="boardofeducation" value=""> <br>
                <span class="option1">Add Document Title:</span>
                <input type="text" class="textbox" name="doctitle" value="">
                <br><br>

                <div class="file-upload">
                    <input class="file-upload__input file-upload__button" type="file" name="myFile" id="myFile" accept="application/pdf,application/msword,
                    application/vnd.openxmlformats-officedocument.wordprocessingml.document" multiple>
                    <!-- <button class="file-upload__button" type="button">Choose Document(s)</button> -->
                    <span class="file-upload__label"></span>
                </div>
                 <br> <br>
                <!-- <button type="submit" class="Sell uploadDocButton">
                    <p class="nav-link" href="#">Upload Document</p>
                </button> -->

                <input type="submit" class="Sell uploadDocButton" style="color: #fff;" name="upload-document" value="Upload Document"/>

                <?php
                if (isset($error)) {
                        echo "<span>$error</span>";
                }
            ?>

            </div>
            
        </form>
    </div>
    <!--FOOTER SECTION-->
    <?php include 'shared/footer.php'; ?>

    <script src="./js/script.js"></script>
    <script src="./js/jquery.min.js"></script>
    <script src="owlcarousel/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>