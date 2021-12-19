<?php
require_once './helpers/connect_db.php';
session_start();

$error = null;
if (!isset($_SESSION['user'])) {
  header('location:./Authentication/registration.php');
}
$mysqli = connectDB();
$imgPrefix = "uploads/product-images/";
$account = $mysqli->query("SELECT id,city,state,lat,lon FROM account WHERE id={$_SESSION['user']['id']}");
$account = $account->fetch_assoc();
$resultSet = $mysqli->query("SELECT product_id,name,price,PRODUCT.image,approval,city,state FROM  PRODUCT INNER JOIN ACCOUNT ON PRODUCT.seller_id=ACCOUNT.id");
if ($resultSet->num_rows == 0) {
  $error = "no products found";
}

//Filter Product type according to product type
if (isset($_POST['type-request'])) {
  $request = $_POST['type-request'];
  $resultSet = $mysqli->query("SELECT product_id,name,price,PRODUCT.image,approval,city,state FROM  PRODUCT INNER JOIN ACCOUNT ON PRODUCT.seller_id=ACCOUNT.id where product_type='$request'");
  if ($resultSet->num_rows == 0) {
    $error = "no products found";
  }
  echo "";
}
//Filter Product type according to price
if (isset($_POST['price-request'])) {
  $request = $_POST['price-request'];
  if($request=='Highest'){
    $resultSet = $mysqli->query("SELECT product_id,name,price,PRODUCT.image,approval,city,state FROM  PRODUCT INNER JOIN ACCOUNT ON PRODUCT.seller_id=ACCOUNT.id ORDER BY price DESC");
  }
  elseif($request=='Lowest'){
    $resultSet = $mysqli->query("SELECT product_id,name,price,PRODUCT.image,approval,city,state FROM  PRODUCT INNER JOIN ACCOUNT ON PRODUCT.seller_id=ACCOUNT.id ORDER BY price ASC");
  }
  if ($resultSet->num_rows == 0) {
    $error = "no products found";
  }
  echo "";
}

if (isset($_POST['location-request'])) {
  $request = $_POST['location-request'];
  if($request=='city'){
    $resultSet = $mysqli->query("SELECT product_id,name,price,PRODUCT.image,approval,city,state FROM  PRODUCT INNER JOIN ACCOUNT ON PRODUCT.seller_id=ACCOUNT.id WHERE city='{$account['city']}'");
  } else{
    $resultSet = $mysqli->query("SELECT product_id,name,price,PRODUCT.image,approval,city,state FROM  PRODUCT INNER JOIN ACCOUNT ON PRODUCT.seller_id=ACCOUNT.id WHERE state='{$account['state']}'");
  }
}

if (isset($_POST['radius-request'])) {
  $request = $_POST['radius-request'];
  $lat = $account['lat'];
  $lon = $account['lon'];
  $resultSet = $mysqli->query("SELECT * FROM( SELECT product_id,name,price,PRODUCT.image,approval,city,state,
                              (((acos(sin(($lat*pi()/180)) * sin((lat*pi()/180))+cos(($lat*pi()/180)) * cos((lat*pi()/180)) * cos((($lon - lon)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance 
                                FROM account INNER JOIN product ON account.id=product.seller_id) t WHERE distance*1.609 <= $request");
                        //$lat and $lon are the latitude and longitude of the user's location. lat and lon are the columns of distances table consisting of locations of all products.
} 

?>

<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="css/home.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
  <?php include './shared/navbar.php'; ?>

  <!-- FILTERS -->
  <div class="filter">
    <ul class="filter-1">
      <li class="filter-2">
        <div class="select-style">
          <select name="fetchval" id="fetchval">
            <option class="filter-3" value="" disabled="" selected="">Product Type</option>
            <option class="filter-3" value="stationery">Stationery</option>
            <option class="filter-3" value="furniture">Furniture</option>
            <option class="filter-3" value="Electronics">Electronics</option>
            <option class="filter-3" value="uniform">Uniform</option>
            <option class="filter-3" value="shoes">Shoes</option>

          </select>
        </div>

      </li>
      <li class="filter-2">
        <div class="select-style">
          <select name="fetchval1" id="fetchval1">
            <option class="filter-3" value="" disabled="" selected="">Price</option>
            <option class="filter-3" value="Highest">Highest to Lowest</option>
            <option class="filter-3" value="Lowest">Lowest to Highest</option>
          </select>
        </div>
      </li>
      <li class="filter-2">
        <div class="select-style">
          <select name="fetchval2" id="fetchval2">
            <option class="filter-3" value="" disabled="" selected="">Location</option>
            <option class="filter-3" value="city">City</option>
            <option class="filter-3" value="state">State</option>
          </select>
        </div>
      </li>
      <li class="filter-2">
        <div class="select-style">
          <select name="fetchval3" id="fetchval3">
            <option class="filter-3" value="" disabled="" selected="">Radius</option>
            <option class="filter-3" value="5">5km</option>
            <option class="filter-3" value="15">15km</option>
            <option class="filter-3" value="50">50km</option>
            <option class="filter-3" value="100">100km</option>
          </select>
        </div>
      </li>
    </ul>
  </div>

  <br> <br> <br><br>
  <!---PRODUCT DISPLAY-->
  <div class="container product-container">
    <div class="row align-items-start">
      <?php 
      while ($product = $resultSet->fetch_assoc()) {
        if($product["approval"]==0)
        {
          continue;
        }
        $product_image = explode(",", $product["image"])[0]; //taking first url from comma seperated urls
        $imgUrl = $imgPrefix . $product_image;
        $amount = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $product['price']); // to convert price to indian format
      ?>
        
          <div class="col displaycard">
          <a href="product.php?product_id=<?php echo $product['product_id'];?>">
            <img src="<?php echo $imgUrl ?>" alt="" width="250px" height="220px">
            <h4><?php echo "\u{20B9} $amount" ?></h4>
            <p><?php echo $product['name'] ?></p>
            <p class="loc"><?php echo $product['city'].", ".$product['state']; ?></p>
            </a>
          </div>
        
      <?php
      }
      ?>
    </div>

  </div>
  <br><br>

  <script type="text/javascript">

    $(document).ready(function() {              //on changing the value of select tag it will display an 
      $("#fetchval").on('change', function() {
        var value = $(this).val();

        $.ajax({
            url:"home.php",
            type:"POST",
            data:'type-request='+ value,       
            beforeSend:function(){
                $(".product-container").html("<span>Working.....</span>");
            },
            success:function(result){
                console.log(result);
                $("body").html(result);
            }
        });

      })
    });

    $(document).ready(function() {              //on changing the value of select tag it will display an 
      $("#fetchval1").on('change', function() {
        var value = $(this).val();

        $.ajax({
            url:"home.php",
            type:"POST",
            data:'price-request='+ value,       
            beforeSend:function(){
                $(".product-container").html("<span>Working.....</span>");
            },
            success:function(result){
                console.log(result);
                $("body").html(result);
            }
        });

      })
    });

    $(document).ready(function() {              //on changing the value of select tag it will display an 
      $("#fetchval2").on('change', function() {
        var value = $(this).val();

        $.ajax({
            url:"home.php",
            type:"POST",
            data:'location-request='+ value,       
            beforeSend:function(){
                $(".product-container").html("<span>Working.....</span>");
            },
            success:function(result){
                console.log(result);
                $("body").html(result);
            }
        });

      })
    });

    $(document).ready(function() {              //on changing the value of select tag it will display an 
      $("#fetchval3").on('change', function() {
        var value = $(this).val();

        $.ajax ({
            url:"home.php",
            type:"POST",
            data:'radius-request='+ value,       
            beforeSend:function(){
                $(".product-container").html("<span>Working.....</span>");
            },
            success:function(result){
                console.log(result);
                $("body").html(result);
            }
        });

      })
    });
  </script>
  <!--FOOTER SECTION-->
  <?php include './shared/footer.php'; ?>
</body>

</html>