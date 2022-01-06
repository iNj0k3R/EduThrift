<?php 
    $lat= $_POST['lat'];
    $lon =$_POST['lon'];
    $apiKey = '';
    $response = file_get_contents('https://apis.mapmyindia.com/advancedmaps/v1/'.$apiKey.'/rev_geocode?lat='.$lat.'&lng='.$lon.'&region=IND&lang=en');
    echo $response;
 ?>