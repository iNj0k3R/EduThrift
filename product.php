<html lang="en">

</html>
<?php
require_once './helpers/connect_db.php';
session_start();

$error = null;
if (!isset($_SESSION['user'])) {
    header('location:./Authentication/registration.php');
}

$user = $_SESSION['user'];
$productID = $_GET['product_id'];
$mysqli = connectDB();

//$mysqli = new MySQLi('localhost','root','','EduThrift');
$imgPrefix = "uploads/product-images/";

//Retrieving data from database
$retrieve_data = $mysqli->query("SELECT description,name,price,city,state,sell_or_rent,username,first_name,last_name,PRODUCT.image FROM product inner join account ON product.seller_id=account.id AND product.product_id={$productID}");
$productSellerData = $retrieve_data->fetch_assoc();

// $retrieve_name = $mysqli->query("SELECT first_name, last_name FROM account inner join product where account.id = product.seller_id");
// $productSellerData_name = $retrieve_name->fetch_assoc();

if ($retrieve_data) {
    if ($retrieve_data->num_rows == 0) {
        $error = "No products found";
    } else {
        $productDesc = $productSellerData['description'];
        $productName = $productSellerData['name'];
        $productPrice = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $productSellerData['price']);
        $productCity = $productSellerData['city'];
        $productState = $productSellerData['state'];

        $sell = explode(",", $productSellerData['sell_or_rent'], 2);

        $seller_uname = $productSellerData['username'];
        $firstName = $productSellerData['first_name'];
        $lastName = $productSellerData['last_name'];
    }
}

// if ($retrieve_data) {
//     if ($retrieve_name->num_rows == 0) {
//         $error = "No seller found";
//     } else {
        
//     }
// }

$mysqli->close();


?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Description</title>
    <link rel="stylesheet" href="./css/product.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200&display=swap" rel="stylesheet">
</head>

<body>
    <!----NAVBAR SECTION-->
    <?php include './shared/navbar.php'; ?>

    <!--PRODUCT IMAGE-->
    <div class="product">
        <div class="product-desc">
            <div class="col-10 col-lg-4 event-image">
                <div style="display: flex; justify-content: center; align-items: center">
                    <div>
                        <img src="./images/left-arrow.svg" id="news-arrow-left" onclick="newsCarousel(-1)" />
                    </div>
                  
                    <div class="items-carousel">
                        <?php 
                             $productImg = explode("," ,$productSellerData["image"]);
                             foreach($productImg as $img)
                             {
                                 $imgUrl = $imgPrefix.$img;
                                //  echo "./".$imgUrl;
                             ?>
                            <div class="items-card">
                                <img src="<?php echo $imgUrl ?>" alt="news" />
                                <h4 class="news-headline">
                                    
                                </h4>
                            </div>
                        <?php } ?>
                    </div>  
                    <div>
                        <img src="./images/right-arrow.svg" id="news-arrow-right" onclick="newsCarousel(1)" />
                    </div>
                </div>
            </div>
            <div class="col-10 col-lg-6 item-desc">
                <h2><?php echo $productName ?></h2>
                <h6>Available for
                    <span><?php
                            if ($sell[0] != null) {
                                if (!isset($sell[1])) {
                                    if ($sell[0] == 'sell') {
                                        echo "sale";
                                    } elseif ($sell[0] == 'rent') {
                                        echo "rent";
                                    }
                                } else {
                                    echo "sale and rent";
                                }
                            }
                            ?>
                    </span>
                </h6>
                <h2>&#8377; <?php echo $productPrice ?></h2>
                <br> <br>
                <h3 href="#">Seller Details</h3>
                <h5><?php echo $firstName . " " . $lastName ?></h5>
                <h6><?php echo $productCity.", ". $productState ?></h6>
                <!-- <h6>Panaji, Goa</h6> -->
                <button class="view-event" style="color: #fff;"><a href="chat.php?contact_uname=<?php echo $seller_uname;?>" >Chat with Seller</a></button>
            </div>
        </div>
    </div>

    <!------DETAIL PRODUCT DESCRIPTION---------->
    <section class="detail_product_describe">
        <h4 class="product_detail" style="font-family: Raleway, sans-serif;
      font-size: 24px;
      font-style: normal;
      font-weight: 700;
      line-height: 28px;
      letter-spacing: 0em;
      text-align: left;
      margin-left: 0px;
      color: #000000;">Product Description</h4>
        <div>
            <ul class="product_list">
                <li style="list-style: none;" class="list">
                    <?php echo $productDesc ?>
                </li>
            </ul>
        </div>
    </section>

    <!--FOOTER SECTION-->
    <?php include './shared/footer.php'; ?>

    <script src="./product.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>