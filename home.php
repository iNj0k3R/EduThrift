<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:./Authentication/registration.php');
}


?>

<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="./home.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200&display=swap" rel="stylesheet">
</head>

<body>
    <?php include './shared/navbar.php'; ?>

     <!-- FILTERS -->
  <div class="filter">
    <ul class="filter-1 ">
      <li class="filter-2 "><a href="#">Choose Filters</a></li>
      <li class="filter-2"><a href="#">Product type</a>

      </li>
      <li class="filter-2  "> <a href="#"> Price Range</a>
         
      </li>
      <li class="filter-2 "> <a href="#">Location</a>
        <!-- <select name="" id=""></select> -->
        
      </li>
    </ul>
  </div>
<br> <br> <br><br> 
<!---PRODUCT DISPLAY-->
  <div class="container">
    <div class="row align-items-start">
      <div class="col displaycard">
        <img src="./images/product.png" alt="" width="250px" height="220px">
        <h4>₹ 499.00</h4>
        <p>Lorem ipsum dolor sit amet</p>
        <p class="loc">Panaji, Goa</p>
      </div>
    
      <div class="col displaycard">
        <img src="./images/product.png" alt="" width="250px" height="220px">
        <h4>₹ 499.00</h4>
        <p>Lorem ipsum dolor sit amet</p>
        <p class="loc">Panaji, Goa</p>
      </div>
    
      <div class="col displaycard">
        <img src="./images/product.png" alt="" width="250px" height="220px">
        <h4>₹ 499.00</h4>
        <p>Lorem ipsum dolor sit amet</p>
        <p class="loc">Panaji, Goa</p>
      </div>
    
      <div class="col displaycard">
        <img src="./images/product.png" alt="" width="250px" height="220px">
        <h4>₹ 499.00</h4>
        <p>Lorem ipsum dolor sit amet</p>
        <p class="loc">Panaji, Goa</p>
      </div>
    
    </div>

    <div class="row align-items-center">
      <div class="col displaycard">
        <img src="./images/product.png" alt="" width="250px" height="220px">
        <h4>₹ 499.00</h4>
        <p>Lorem ipsum dolor sit amet</p>
        <p class="loc">Panaji, Goa</p>
      </div>
    
      <div class="col displaycard">
        <img src="./images/product.png" alt="" width="250px" height="220px">
        <h4>₹ 499.00</h4>
        <p>Lorem ipsum dolor sit amet</p>
        <p class="loc">Panaji, Goa</p>
      </div>
    
      <div class="col displaycard">
        <img src="./images/product.png" alt="" width="250px" height="220px">
        <h4>₹ 499.00</h4>
        <p>Lorem ipsum dolor sit amet</p>
        <p class="loc">Panaji, Goa</p>
      </div>
    
      <div class="col displaycard">
        <img src="./images/product.png" alt="" width="250px" height="220px">
        <h4>₹ 499.00</h4>
        <p>Lorem ipsum dolor sit amet</p>
        <p class="loc">Panaji, Goa</p>
      </div>
    
    </div>

  </div>
  <br><br>


    <!--FOOTER SECTION-->
    <?php include './shared/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>
</html>