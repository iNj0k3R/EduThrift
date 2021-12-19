<!-- <html>
    <head>
        <style>
            #map_canvas {
    width: 980px;
    height: 500px;
}
#current {
    padding-top: 25px;
}
        </style>
    </head>
<body>
    <section>
        <div id='map_canvas'></div>
        <div id="current">Nothing yet...</div>
        <form class="addr-form" action="profile.php" method="POST">
                AddressLine: <input id='addr' value="AddressLine" name="address-line" style="width: 30%;"/>
                City: <input id='addr-city' value="City" name="city"/>
                State: <input id='addr-state' value="State" name="state"/>
                Pincode: <input id='addr-pincode' value="Pincode" name="pincode"/>
                <input id='addr-lat' value="lat" name="lat" hidden />
                <input id='addr-lon' value="lon" name="lon" hidden />
                <input type="submit" name="addr-submit" value="submit" />
        </form>
    </section>
    <button id='submit'>Submit</button>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
    var lat,lon;
    var loadMap = () =>
    {var map = new google.maps.Map(document.getElementById('map_canvas'), {
    zoom: 10,
    center: new google.maps.LatLng(15.477, 73.822),
    mapTypeId: google.maps.MapTypeId.ROADMAP
});

    var myMarker = new google.maps.Marker({
        position: new google.maps.LatLng(15.477, 73.822),
        draggable: true
    });

    google.maps.event.addListener(myMarker, 'dragend', function (evt) {
        lat = evt.latLng.lat();
        lon = evt.latLng.lng();
        document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
        $.ajax({
            type: 'POST',
            url: 'helpers/reverse-geocode.php',
            data: { lat: lat, lon: lon },
            success: function(response) {
            const myJSON = JSON.parse(response);
            $('#addr').val(myJSON.results[0].formatted_address);
            $('#addr-city').val(myJSON.results[0].subDistrict);
            $('#addr-state').val(myJSON.results[0].state);
            $('#addr-pincode').val(myJSON.results[0].pincode);
            $('#addr-lat').val(lat);
            $('#addr-lon').val(lon);
            console.log(response);
        }
    });
    });

    google.maps.event.addListener(myMarker, 'dragstart', function (evt) {
        document.getElementById('current').innerHTML = '<p>Currently dragging marker...</p>';
    });
   
map.setCenter(myMarker.position);
myMarker.setMap(map);
}

var submitBtn = document.getElementById('submit');
    // submitBtn.onclick = async ()=>{
    //     const response = await fetch(`https://apis.mapmyindia.com/advancedmaps/v1/54eccf92ee541c31182014c6a4cf94fb/rev_geocode?lat=${lat}&lng=${lon}&region=IND&lang=en`);
    //     const myJson = await response.json(); //extract JSON from the http response
    //     // do something with myJson
    //     console.log(myJson.results[0]);
    // }
    submitBtn.onclick = () =>{ //for sending text
        $.ajax({
            type: 'POST',
            url: 'helpers/reverse-geocode.php',
            data: { lat: lat, lon: lon },
            success: function(response) {
            $('#addr').html(response);
        }
    });
};
</script>
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBV90CFxs813k0fLPy2AJ5Lfi_vNEV7vPo&callback=loadMap"
      async
    ></script>
</html>
 -->
 <html>

<head>
    <style>
        #map_canvas {
            width: 700px;
            height: 500px;
        }

        #current {
            padding-top: 25px;
        }
    </style>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="./css/uploadproduct.css">
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
    <div class="uploaddiv ">
        <h2 Align="Center" class="title1">Choose your Location</h2>
        <br><br>
        <div id='map_canvas'></div>
        <!-- <div id="current">Nothing yet...</div> -->
        <form class="addr-form" action="profile.php" method="POST">
            <br>
            <span class="option1">Address Line:</span>
            <input id='addr' class="textbox" value="Address Line" name="address-line" style="width: 80%;"/> <br>
            <span class="option1">City:</span>
            <input id='addr-city' class="textbox" value="City" name="city"/><br>
            <span class="option1">State</span>
            <input id='addr-state' class="textbox" value="State" name="state"/><br>
            <span class="option1">Pincode:</span>
            <input id='addr-pincode' class="textbox" value="Pincode" name="pincode"/><br> <br>
            <input id='addr-lat' value="lat" name="lat" hidden />
            <input id='addr-lon' value="lon" name="lon" hidden />
            <input id='addr-submit' name="addr-submit" type="submit" class="Sell" value="Submit" style="color: #fff;"></input>
        </form>

    </div>

    <!--FOOTER SECTION-->
    <?php include './shared/footer.php'; ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
    var lat, lon;
    var loadMap = () => {
        var map = new google.maps.Map(document.getElementById('map_canvas'), {
            zoom: 10,
            center: new google.maps.LatLng(15.477, 73.822),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var myMarker = new google.maps.Marker({
            position: new google.maps.LatLng(15.477, 73.822),
            draggable: true
        });

        google.maps.event.addListener(myMarker, 'dragend', function(evt) {
            lat = evt.latLng.lat();
            lon = evt.latLng.lng();
            //document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
            $.ajax({
                type: 'POST',
                url: 'helpers/reverse-geocode.php',
                data: {
                    lat: lat,
                    lon: lon
                },
                success: function(response) {
                    const myJSON = JSON.parse(response);
                    $('#addr').val(myJSON.results[0].formatted_address);
                    $('#addr-city').val(myJSON.results[0].subDistrict);
                    $('#addr-state').val(myJSON.results[0].state);
                    $('#addr-pincode').val(myJSON.results[0].pincode);
                    $('#addr-lat').val(lat);
                    $('#addr-lon').val(lon);
                    console.log(response);
                }
            });
        });

        // google.maps.event.addListener(myMarker, 'dragstart', function(evt) {
        //     document.getElementById('current').innerHTML = '<p>Currently dragging marker...</p>';
        // });

        map.setCenter(myMarker.position);
        myMarker.setMap(map);
    }

    var submitBtn = document.getElementById('submit');
    // submitBtn.onclick = async ()=>{
    //     const response = await fetch(`https://apis.mapmyindia.com/advancedmaps/v1/54eccf92ee541c31182014c6a4cf94fb/rev_geocode?lat=${lat}&lng=${lon}&region=IND&lang=en`);
    //     const myJson = await response.json(); //extract JSON from the http response
    //     // do something with myJson
    //     console.log(myJson.results[0]);
    // }
    submitBtn.onclick = () => { //for sending text
        $.ajax({
            type: 'POST',
            url: 'helpers/reverse-geocode.php',
            data: {
                lat: lat,
                lon: lon
            },
            success: function(response) {
                $('#addr').html(response);
            }
        });
    };
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBV90CFxs813k0fLPy2AJ5Lfi_vNEV7vPo&callback=loadMap" async></script>

</html>