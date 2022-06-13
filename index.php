<?php
session_start();

include 'database.php';
include 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];

        //create query
        $query = 'SELECT * FROM user WHERE user_email = ?';

        //prepare statement
        $stmt = $db->prepare($query);

        // binding param
        $stmt->bindParam(1, $email);

        //excute query
        $stmt->execute();

        //get the row count
        $num = $stmt->rowCount();

        if ($num > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user_id = $row['user_id'];
                $name = $row['user_name'];
                $email = $row['user_email'];
                $password = $row['user_password'];

                $_SESSION['user_id'] = $user_id;
                if ($password !== $_POST['password']) {
                    $_SESSION['error_message'] = "Wrong Password";
                    header('Location: login.php');
                } else {

                    $payload = [
                        'iss' => "localhost",
                        'aud' => 'localhost',
                        'exp' => time() + 2000, //20 mint
                        'data' => [
                            'name' => $name,
                            'email' => $email,
                        ],
                    ];
                    $secret_key = "D9DC05EE4A5E57F008BBEB2D8BF1010F1DCD675E42427DCFC2D7AA823DA83DC3";
                    $jwt = JWT::encode($payload, $secret_key, 'HS256');

                    if (isset($jwt)) {

                        $_SESSION['JWT'] = $jwt;
                    }

                    if (isset($latitude) && isset($longitude)) {
                        $apiData = file_get_contents("https://api.openweathermap.org/data/2.5/weather?lat=" . $latitude . "&lon=" . $longitude . "&appid=dd5621837b762f2ffde832b01014a9c3");


                        $weatherArray = json_decode($apiData, true);
                        // echo "<pre>";
                        // print_r($weatherArray);
                        // die();
                        $weather = $weatherArray['weather']['0']['description'];
                        $temp = $weatherArray['main']['temp'];
                        $tempCelsius = $temp - 273;
                    }
                }
            }
        } else {
            header('Location: login.php');
        }
    } else {
        header('Location: login.php');
    }
}    
else {
    header('Location: login.php');
}

if (isset($_SESSION['JWT'])) {

    $jwt_token = $_SESSION['JWT'];


    $secret_key = "D9DC05EE4A5E57F008BBEB2D8BF1010F1DCD675E42427DCFC2D7AA823DA83DC3";
    $user_data = JWT::decode($jwt_token, new Key($secret_key, 'HS256'));

    if (isset($user_data)) {
        // working code 
        $_SESSION['token'] =  $user_data->exp;
    }
}
if (isset($latitude) && isset($longitude)) {
    $apiData = file_get_contents("https://api.openweathermap.org/data/2.5/weather?lat=" . $latitude . "&lon=" . $longitude . "&appid=dd5621837b762f2ffde832b01014a9c3");

    $weatherArray = json_decode($apiData, true);

    $weather = $weatherArray['weather']['0']['description'];
    $temp = $weatherArray['main']['temp'];
    $tempCelsius = $temp - 273;
} else {
    $weather =  $_SESSION['weather'];
    $tempCelsius = $_SESSION['temp'];
}

if(isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Tracker App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
   
    <div class="center">
        <h1>Current temperature is : <?php echo $tempCelsius; ?> <span>&#8451;</span> </h1>
        <h1>Weather is <?php echo $weather ?></h1>
        <form action="savedata.php" method="POST">
            <label for="birthday"><h1>Date :</h1></label>
            <input type="date" id="date" name="date">
            <input type="hidden" name="tempCelsius" id="tempCelsius" value="<?php echo $tempCelsius; ?>" />
            <input type="hidden" name="weather" id="weather" value="<?php echo $weather ?>" /> <br> <br>
            <div class="d-flex justify-content-between">
                <input type="submit" value="Save weather with date" name="submit" class="btn btn-outline-info">
                <a href="viewdata.php" class="btn btn-outline-warning">View Saved Weather data</a>
            </div>
            
        </form>
        <div class="logout" >
            <form action="" method="POST">
                <input type="submit" value="Logout" name="logout" class="btn btn-dark">
            </form>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function getLocation() {

            var latitude = document.getElementById("latitude");
            var longitude = document.getElementById("longitude");
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    latitude.value = position.coords.latitude;
                    longitude.value = position.coords.longitude;
                    console.log(position.coords.latitude);



                });
            }


        }
    </script>
</body>

</html>