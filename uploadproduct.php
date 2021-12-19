 <html lang="en">

<?php
    // phpinfo();

    session_start();
    $error = NULL;
    if (!isset($_SESSION['user'])) {
        header('location:./Authentication/registration.php');  
    }
    $user=$_SESSION['user'];
   
    if(isset($_POST['upload-product'])) {

        include_once 'helpers/connect_db.php';
        $mysqli = connectDB();

        //SETTING VARIABLES FROM FORM DATA
        $productType = $_POST['producttype'];
        $saleType = $_POST['saletype'];
        $productName = $_POST['productname'];
        $productPrice = $_POST['productprice'];
        $productDesc = $_POST['productdescription'];
        //$fileName = basename($_FILES["myFile"]["name"]);

        $targetDir = "uploads/product-images";      
        $targetFilePath = $targetDir;

    
        if($mysqli->connect_error) {
            echo "$mysqli->connect_error";
            die ("Connection failed: ".$mysqli->connect_error);
        }
        else {
            echo "Connected";
            // echo "Product upload successful";
            // if(!empty($_FILES["myFile"]["name"])){
            //     // Upload file to server
            //     move_uploaded_file($_FILES["myFile"]["tmp_name"], $targetFilePath);
            //     // Insert image file name into database
            //     $insert = $mysqli->query("INSERT INTO PRODUCT(name, price,image, description, sell_or_rent, product_type, seller_id) 
            //                                 VALUES('$productName', '$productPrice','{$_FILES['myFile']['name']}', '$productDesc', '$saleType', '$productType',{$user['id']})");
            //     if($insert){
            //         $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            //     }else{
            //         $statusMsg = "File upload failed, please try again.";
            //     } 

            // } else{
            //         $statusMsg = 'Please select a file to upload.';
            //      }
           // echo "Product upload successful";
          //$error=array();
            $document_names = '';
            $extension=array("jpeg","jpg","png");
            foreach($_FILES["myFile"]["tmp_name"] as $key=>$tmp_name) {
                $file_name=$_FILES["myFile"]["name"][$key];
                
                $file_tmp=$_FILES["myFile"]["tmp_name"][$key];
                $ext=pathinfo($file_name,PATHINFO_EXTENSION);
                
                if(in_array($ext,$extension)) {
                    if(!file_exists($targetDir."/".$file_name)) {
                        move_uploaded_file($file_tmp=$_FILES["myFile"]["tmp_name"][$key],$targetDir."/".$file_name);
                        $document_names = $document_names . $file_name . ',';
                    }
                    else {
                        $filename=basename($file_name,$ext);
                        $newFileName=$filename.time().".".$ext;
                        move_uploaded_file($file_tmp=$_FILES["myFile"]["tmp_name"][$key],$targetDir."/".$newFileName);
                        $document_names = $document_names . $newFileName . ',';
                    }
                }else {
                    //array_push($error,"$file_name, ");
                    echo 'error';
                }
            }
            $document_names = substr_replace($document_names ,"",-1); //removing extra , at the end
            $insert = $mysqli->query("INSERT INTO PRODUCT(name, price,image, description, sell_or_rent, product_type, seller_id) 
                                                   VALUES('$productName','$productPrice','$document_names', '$productDesc', '$saleType', '$productType',{$user['id']})");
            $mysqli->close();
        }
    }


    
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product</title>
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

    <!--UPLOAD PRODUCT--->
    <div class="uploaddiv uploadProduct">
        <form action="uploadproduct.php" method="POST" enctype="multipart/form-data">
            <h2 Align="Center" class="title1">Upload your Product</h2>
            <br><br><br>
            <h3 class="title2">Product Details</h3>
            <br><br>

            <div class="formContent">
                <p class="subtitle">Select the categories your product falls under:</p>
                <input type="radio" name="producttype" class="option" value="stationery">
                <span class="option">Stationery</span><br>
                <input type="radio" name="producttype" value="uniformclothes">
                <span class="option">Uniform/Clothes</span><br>
                <input type="radio" name="producttype" value="electronics">
                <span class="option">Electronics</span> <br>
                <input type="radio" name="producttype" value="furniture">
                <span class="option">Furniture</span> <br>
                <input type="radio" name="producttype" value="shoes">
                <span class="option">Shoes</span> <br>
                <input type="radio" name="producttype" value="schoolbags">
                <span class="option">School Bags & Pouches</span> <br>
                <input type="radio" name="producttype">
                <span class="option">Textbooks</span> <br>
                <input type="radio" name="producttype" value="others">
                <span class="option">Others</span>

                <br><br><br>

                <p class="subtitle">Select the category of sale of your product:</p>
                <input type="checkbox" name="saletype">
                <span class="option" value="sell">Sell</span><br>
                <input type="checkbox" name="saletype">
                <span class="option" value="rent">Rent</span>

                <br><br>
                <span class="option1">Add Product Name:</span>
                <input type="text" class="textbox" name="productname"><br>
                <span class="option1">Set Product Price:</span>
                <input type="text" class="textbox" name="productprice"><br>
                <span class="option1">Product Description:</span>
                <textarea class=".textbox" rows="4" cols="45" name="productdescription"></textarea>
                <br><br>

                <div class="file-upload">
                    <input class="file-upload__input file-upload__button" type="file" name="myFile[]" id="myFile" accept="image/png, image/jpeg, image/jpg" multiple>
                    <!-- <button class="file-upload__button" type="button">Choose Image(s)</button> -->
                    <span class="file-upload__label"></span>
                </div>
                <br> <br>
            <input type="submit" class="Sell uploadProductButton" style="color: #fff;" name="upload-product" value="Upload Product"/>

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