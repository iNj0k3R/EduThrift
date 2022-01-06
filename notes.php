<?php

require_once './helpers/connect_db.php';
session_start();

$error = null;
if (!isset($_SESSION['user'])) {
    header('location:./Authentication/registration.php');
}
$mysqli = connectDB();
$documentPrefix = "uploads/documents/";

$resultSet = $mysqli->query("SELECT notes_id,title,uploader_id,date_of_uploading,category,document,first_name,last_name FROM document INNER JOIN account ON document.uploader_id=account.id");

if (isset($_GET['search_for_request'])) {
    $request = $_GET['search_for_request'];
    //header('location:myads.php');
    //echo $request;
    $resultSet = $mysqli->query("SELECT notes_id,title,uploader_id,date_of_uploading,category,document,first_name,last_name FROM document INNER JOIN account ON document.uploader_id=account.id WHERE category='{$request}'");
    if ($resultSet->num_rows == 0) {
      $error = "no products found";
    }
  }
  if (isset($_GET['search_for_class'])) {
    $request = $_GET['search_for_class'];
    //header('location:myads.php');
    //echo $request;
    $resultSet = $mysqli->query("SELECT notes_id,title,uploader_id,date_of_uploading,category,document,first_name,last_name FROM document INNER JOIN account ON document.uploader_id=account.id WHERE class='{$request}'");
    if ($resultSet->num_rows == 0) {
      $error = "no products found";
    }
  }

if(isset($_POST['download-submit'])){
    $url = $documentPrefix.$_POST['download-file'];
    //file_put_contents($_POST['documentName'], file_get_contents($url));
    
    $file_name = "C:/Users/varad/Desktop/".basename($url);    
    // Use file_get_contents() function to get the file
    // from url and use file_put_contents() function to
    // save the file by using base name
     file_put_contents($file_name, file_get_contents($url));
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes & PDFs</title>
    <link rel="stylesheet" href="./css/notes.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200&display=swap" rel="stylesheet">
</head>

<body>
    <!-- NAVBAR -->
    <?php include_once 'shared/navbar.php' ?>
    <!---MAIN SECTION---->
    <br><br><br>

    <!-- FILTER SECTION -->
    <div class="notes-display">
        <div class="container">
            <div class="row ipda-row">
                <div class="col-lg-4 file_upload">
                    <form action="" id="search-form">
                        <div class="user_profile_section">
                            <div class="search_user_div">
                                <h4 class="search_profile_handling">
                                    Search for
                                </h4>
                            </div>
                            <ul class="searching_student_list1">
                                <label for="" class="container_check">
                                    <input type="radio" class="search_data" name="search_for" value="textbooks">
                                    Textbooks
                                </label><br>
                                <label for="" class="container_check">
                                    <input type="radio" class="search_data" name="search_for" value="classnotes">
                                    Class notes
                                </label><br>
                                <label for="" class="container_check">
                                    <input type="radio" class="search_data" name="search_for" value="exampapers">
                                    Exam papers
                                </label><br>
                                <label for="" class="container_check">
                                    <input type="radio" class="search_data" name="search_for" value="answers">
                                    Answers
                                </label><br>
                                <label for="" class="container_check">
                                    <input type="radio" class="search_data" name="search_for" value="presentations">
                                    Presentations
                                </label><br>
                                <label for="" class="container_check">
                                    <input type="radio" class="search_data" name="search_for" value="researchpapers">
                                    Research papers
                                </label><br>
                                <label for="" class="container_check">
                                    <input type="radio" class="search_data" name="search_for" value="summary">
                                    Summary
                                </label><br>
                                <label for="" class="container_check">
                                    <input type="radio" class="search_data" name="search_for" value="others">
                                    Others
                                </label><br>
                            </ul>
                        </div>
                        <!-- <div class="user_profile_section">
                            <div class="search_user_div">
                                <h4 class="search_profile_handling">
                                    Filter by Institute
                                </h4>
                            </div>
                            <div class="row profile_cont">
                                <div class="col-md-12 card-row">
                                    <div class="form-group">
                                        <select name="institute_id" id="institute_id" class="form-control">
                                            <option selected="selected" value>Institute</option>
                                            <option value="1">Sharada Mandir School</option>
                                            <option value="2">Green Rosary School</option>
                                            <option value="3">Red Rosary School</option>
                                            <option value="4">People's Secondary School</option>
                                            <option value="5">IIT Bombay</option>
                                            <option value="6">IIT Delhi</option>
                                            <option value="7">IIT Madras</option>
                                            <option value="8">IIT Guwahati</option>
                                            <option value="9">IIT Goa</option>
                                            <option value="10">Mumbai University</option>

                                            <!-- show all nodes 
                                        </select><br>
                                    </div>
                                    <div class="form-group">
                                        <select name="board_of_education" id="board_of_education_id" class="form-control search_data">
                                            <option selected="selected" value>Board of Education</option>
                                            <option value="1">ICSE</option>
                                            <option value="2">CBSE</option>
                                            <option value="3">IGCSE</option>
                                            <option value="4">State Board</option>
                                            <option value="5">AICTE</option>
                                            <option value="6">UGC</option>
                                        </select><br>

                                        <!-- show all nodes 
                                    </div>
                                    <div class="form-group">
                                        <select name="course_id" id="course_id" class="form-control">
                                            <option selected="selected" value>Course name</option>
                                            <option value="1">Mathematics</option>
                                            <option value="2">Physics</option>
                                            <option value="3">Chemistry</option>
                                            <option value="4">Biology</option>
                                            <option value="5">English Literature</option>
                                            <option value="6">English Language</option>
                                            <option value="7">Hindi</option>
                                            <option value="8">Geography</option>
                                            <option value="9">Computer Science</option>
                                            <option value="10">History & Civics</option>

                                            <!-- show all nodes 
                                        </select><br>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="user_profile_section">
                            <div class="search_user_div">
                                <h4 class="search_profile_handling">
                                    Search by Class
                                </h4>
                            </div>
                            <ul class="searching_student_list1">
                                <label for="" class="container_radio">
                                    <input type="radio" class="search_data" name="search_for_class" value="class1">
                                    Class 1
                                </label><br>
                                <label for="" class="container_radio">
                                    <input type="radio" class="search_data" name="search_for_class" value="class2">
                                    Class 2
                                </label><br>
                                <label for="" class="container_radio">
                                    <input type="radio" class="search_data" name="search_for_class" value="class3">
                                    Class 3
                                </label><br>
                                <label for="" class="container_radio">
                                    <input type="radio" class="search_data" name="search_for_class" value="class4">
                                    Class 4
                                </label><br>
                                <label for="" class="container_radio">
                                    <input type="radio" class="search_data" name="search_for_class" value="class5">
                                    Class 5
                                </label><br>
                                <label for="" class="container_radio">
                                    <input type="radio" class="search_data" name="search_for_class" value="class6">
                                    Class 6
                                </label><br>
                                <label for="" class="container_radio">
                                    <input type="radio" class="search_data" name="search_for_class" value="class7">
                                    Class 7
                                </label><br>
                                <label for="" class="container_radio">
                                    <input type="radio" class="search_data" name="search_for_class" value="class8">
                                    Class 8
                                </label><br>
                                <label for="" class="container_radio">
                                    <input type="radio" class="search_data" name="search_for_class" value="class9">
                                    Class 9
                                </label><br>
                                <label for="" class="container_radio">
                                    <input type="radio" class="search_data" name="search_for_class" value="class10">
                                    Class 10
                                </label><br>
                                <label for="" class="container_radio">
                                    <input type="radio" class="search_data" name="search_for_class" value="class11">
                                    Class 11 (Highschool)
                                </label><br>
                                <label for="" class="container_radio">
                                    <input type="radio" class="search_data" name="search_for_class" value="class12">
                                    Class 12 (Highschool)
                                </label><br>
                                <label for="" class="container_radio">
                                    <input type="radio" class="search_data" name="search_for_class" value="college">
                                    College
                                </label><br>

                            </ul>
                        </div>

                    </form>
                </div>
        
                <!-- DISPLAY NOTES SECTION -->
                <div class="col-lg-8 forums search-page">
                    <div id="document-container" class="listing_pagination">
                        <div id="document-body">
                            <?php while ($document = $resultSet->fetch_assoc()) { ?>
                                <div class="user_profile_section list_search">
                                    <div class="search_used search-ipad">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="bundle_left_col">
                                                    <div class="quick-view-main">
                                                        <img src="https://image.flaticon.com/icons/png/512/1215/1215867.png" alt="" class="onload-img" width="86px" height="138px">
                                                        <!-- <a href="#" class="quickview" data-toggle="modal" data-url="">Download</a> -->
                                                    </div>
                                                </div>
                                                <a href="#"></a>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="bundle_right_col">
                                                    <a href="#"></a>
                                                    <p class="search_heading">
                                                        <a href="#"><?php echo $document['title']; ?></a>
                                                    </p>
                                   
                                                    <p class="remark">
                                                        Uploaded by <strong><?php echo $document['first_name'] . " " . $document['last_name']; ?></strong> on
                                                        <strong><?php echo date('d-m-Y', strtotime($document['date_of_uploading'])); ?></strong>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="single-line">
                                                    <div class="span-dd">
                                                        <span class="card_doctype">
                                                            <?php echo strtoupper($document['category']); ?>
                                                        </span>

                                                    </div>
                                                    <form action="notes.php" method="POST">
                                                        <input type="text" name="download-file" value="<?php echo $document['document']; ?>" hidden>
                                                        <input type="submit" name="download-submit" value="Download">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>




    <!-- FOOTER -->
    <?php include_once 'shared/footer.php' ?>
    <script>
        $(document).ready(function() {       
           // $("#document-container").load(location.href + " #document-container")       //on changing the value of select tag it will display an 
            $('input[name=search_for]').change(function() {
                var search=$(this).val();
                $.ajax({
                url:"notes.php",
                type:"GET",
                data:
                    "search_for_request="+search
                ,       
                beforeSend:function(){
                   // $(".product-container").html("<span>Working.....</span>");
                },
                success:function(data){
                   // console.log(result);     
                    var result = $('<div />').append(data).find('#document-container').html();     
                    //$("#document-container").load(window.location.href + " #document-container");
                    $("#document-container").html(result);
                     }
                });
            });
            $('input[name=search_for_class]').change(function() {
                var search=$(this).val();
                $.ajax({
                url:"notes.php",
                type:"GET",
                data:
                    "search_for_class="+search
                ,       
                beforeSend:function(){
                   // $(".product-container").html("<span>Working.....</span>");
                },
                success:function(data){
                   // console.log(result);     
                    var result = $('<div />').append(data).find('#document-container').html();     
                    //$("#document-container").load(window.location.href + " #document-container");
                    $("#document-container").html(result);
                     }
                });
            });

        });

    </script>

    <!-- <script src="./js/script.js"></script>
    <script src="./js/jquery.min.js"></script>
    <script src="owlcarousel/owl.carousel.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>