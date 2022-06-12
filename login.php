<?php 
session_start();

include 'database.php';
include 'vendor/autoload.php';

use \Firebase\JWT\JWT;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Tracker App</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
</head>

<body onload="getLocation()">
    <div class="center">
        <form action="index.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email">

            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <input type="hidden" name="latitude" id="latitude" />
            <input type="hidden" name="longitude" id="longitude" />
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
                ​ <a href="register.php" class="btn btn-secondary"> Register </a>
            </div>
           
        </form>

    </div>
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function getLocation() {
            alert("Please Click the allow button to get your location");
            var latitude = document.getElementById("latitude");
            var longitude = document.getElementById("longitude");
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    latitude.value = position.coords.latitude;
                    longitude.value = position.coords.longitude;
                    console.log(position.coords.latitude);



                });
            } else {
                // x.innerHTML="Geolocation is not supported by this browser.";
            }


        }
    </script>
</body>

</html>