<?php
session_start();

include 'database.php';

if ($_SESSION['token']) {
    if (isset($_POST['submit'])) {
        

        $temp = $_POST['tempCelsius'];
        $weather = $_POST['weather'];
        $date = $_POST['date'];
        $user_id = $_SESSION['user_id'];
        echo $temp . " " . $weather . " " . $date;
    
        $query = 'INSERT INTO weather (weather, weather_temp, date, user_id)
        VALUES
        (:weather, :weather_temp, :date,:user_id)';
        $stmt = $db->prepare($query);

        $stmt->bindParam(':weather', $weather);
        $stmt->bindParam(':weather_temp', $temp);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':user_id', $user_id);


        // execute the query
        if ($stmt->execute()) {
        
            $_SESSION['temp'] = $temp;
            $_SESSION['weather'] = $weather;
            header('Location: viewdata.php');

        }

        //print error if something goes wrong
            printf("Error %s. \n", $stmt->error);
            return false;

    }
}