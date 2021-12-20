<html lang="en">
<?php
require_once './helpers/connect_db.php';
session_start();

$error = null;
if (!isset($_SESSION['user'])) {
  header('location:./Authentication/registration.php');
}

$user = $_SESSION['user'];
$mysqli = connectDB();


if(isset($_POST['delete-ad'])){
    $mysqli->query("DELETE FROM product WHERE product_id={$_POST['delete-ad']}");
}

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Ads</title>
    <link rel="stylesheet" href="./css/pending_ads.css">
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
    <?php include_once 'shared/navbar.php' ?>

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
                    <th>Product Image</th>
                    <th>Status</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php

            $retrieve_data = $mysqli->query("SELECT * FROM product WHERE product.seller_id={$user['id']}");
            $count = 1;
               while($account = $retrieve_data->fetch_assoc()){
               ?>

                <tr>
                    <td><b><?php echo $count++; ?></b></td>
                    <td><b><?php echo $account['name']; ?></b></td>
                    <td>
                      <b>
                      <?php  
                          $productPrice = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $account['price']);
                          echo  $productPrice; 
                      ?>
                      </b>
                    </td>
                    <td class="subtable">
                      <?php 
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
                      ?>
                    </td>
                    <td class="subtable"><?php echo $account['description']?></td>
                    
                    <td>
                       
                       <img src="uploads/product-images/<?php echo explode(",", $account["image"])[0]; ?>" class="img-responsive img-thumbnail" width="150">
                      
                    </td>

                    <td>
                        <?php
                            if($account['approval'] == 0)
                            {
                                echo "Approval Pending";
                            }
                            else
                            {
                                echo "Approved";
                            }
                         ?>
                    </td>
                   <td>
                    <form action="myads.php" method="POST">
                        <button class="deny" type="submit" name="delete-ad" value="<?php echo $account['product_id'];?>">Delete</button>
                    </form>
                        
                   </td>
                </tr>
                <?php
               }
                ?>

            </tbody>
        </table>
    </div>
    <br><br><br><br><br><br>




    <!--FOOTER SECTION-->
    <?php include_once 'shared/footer.php' ?>

    <script src="./js/script.js"></script>
    <script src="./js/jquery.min.js"></script>
    <script src="owlcarousel/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

</body>

</html>