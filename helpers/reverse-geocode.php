<?php 
    $lat= $_POST['lat'];
    $lon =$_POST['lon'];
    $response = file_get_contents('https://apis.mapmyindia.com/advancedmaps/v1/80986ff3db7fc66addef332f8ccbb194/rev_geocode?lat='.$lat.'&lng='.$lon.'&region=IND&lang=en');
    $response1 = json_decode($response);
    echo $response;
    //54eccf92ee541c31182014c6a4cf94fb
 ?>