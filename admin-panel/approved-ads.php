<?php
    session_start();
    if(!isset($_SESSION['username'])){
        echo "<p>session not set</p>";
        header("Location:admin-login.php");exit;    
    }
    $mysqli = NEW MySQLi('localhost','root','','EduThrift');
 ?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Ads</title>
    <link rel="stylesheet" href="../css/pending_ads.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200&display=swap" rel="stylesheet">
</head>

<body>
    <!--Navbar-->
    <div class="container justify-content-center">
        <nav class="
            navbar navbar-custom navbar-expand-lg navbar-dark
            shadow-5-strong
            fixed-top
          " style="background: #fff; border: 1px solid #C4C4C4;">
            <div class="container-fluid">
                <a class="navbar-brand" href="#" style="margin-left: 3%;margin-bottom: 30px;"><img
                        src="./images/eduthrift.png" alt="" /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0" style="font-size: 1.2rem; font-weight: 400;font-family: Raleway;
                font-style: normal;
                ">
                        <li class="nav-item px-4">
                            <a class="nav-link active hover-underline-animation" aria-current="page" href="admin-home.php">Pending
                                Ads</a>
                        </li>
                        <li class="nav-item px-4">
                            <a class="nav-link hover-underline-animation" href="approved-ads.php">Approved Ads</a>
                        </li>

                        <!-- <li class="nav-item px-4">
                            <button class="Sell">
                                <p class="nav-link" href="#">Sign Out</p>
                            </button>
                        </li> -->
                    </ul>
                </div>
                <li class="nav-item px-4">
                    <button class="Sell">
                        <p class="nav-link" href="#">Sign Out</p>
                    </button>
                </li>
            </div>
        </nav>
    </div>

    <!--TABLE-->
    <div class="container">
        <br><br>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Sr no</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Sale/Rent</th>
                    <th>Description</th>
                    <th>Seller Details</th>
                    <th>Product Image</th>
                    
                </tr>
            </thead>
            <tbody>
                 <?php
                    $retrieve_data = $mysqli->query("SELECT product_id,name,price,sell_or_rent,description,first_name,last_name,city,state,id,PRODUCT.image FROM product inner join account on product.seller_id=account.id WHERE approval=1");
                    while($account = $retrieve_data->fetch_assoc()){
                ?>
                <tr>
                    <td><b><?php echo $account['product_id']; ?></b></td>
                    <td><b><?php echo $account['name']; ?></b></td>
                    <td><b><?php  
                          $productPrice = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $account['price']);
                          echo  $productPrice; 
                      ?></b></td>
                    <td class="subtable"><?php 
                      $sell = explode(",", $account['sell_or_rent'], 2);
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
                      ?></td>
                    <td class="subtable"><?php echo $account['description']?></td>
                    <td class="subtable">
                        <p><?php echo $account['first_name'].$account['last_name'];?></p>
                        <p><?php echo $account['city'].",".$account['state']; ?></p>
                        <p>UID: <?php echo $account['id'];?></p>
                    </td>
                    <td><img src="../uploads/product-images/s<?php echo explode(",", $account["image"])[0]; ?>" class="img-responsive img-thumbnail" width="150"></td>
                </tr>
                <?php
               }
                ?>
            </tbody>
        </table>
    </div>
    <br><br><br><br><br><br>




    <!--FOOTER SECTION-->
    <footer>
        <div id="footer">
            <div class="footer-grid">
                <div id="footer-logo">
                    <a class="brand" href="index.html">
                        <img class="brand-logo-light" src="./images/footer.png" alt="" />
                    </a>
                    <p id="footer-address">
                        Thrift store for educational purpose
                    </p>
                </div>

                <div class="important-links">
                    <div class="detail">
                        <p>Privacy Policy</p>
                        <p>Terms and Conditions</p>
                        <p>All Rights Reserved 2021</p>
                    </div>

                    <div class="detail connect-us">
                        <ul class="social_footer_ul">
                            <a href="#"><img src="./images/instagram.png" alt="" /></a>
                            <a href="#"><img src="./images/twitter.png" alt="" /></a>
                            <a href="#"><img src="./images/facebook.png" alt="" /></a>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </footer>

    <script src="./js/script.js"></script>
    <script src="./js/jquery.min.js"></script>
    <script src="owlcarousel/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

</body>

</html>