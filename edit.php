<?php
session_start();

include 'database.php';

if ($_SESSION['token']) {
    $user_id = $_SESSION['user_id'];
    //create query
    $id = $_GET['id'];
    if (isset($_GET['id'])) {


        $query = 'SELECT * FROM weather WHERE weather_id = ? AND user_id = ? ';

        //prepare statement
        $stmt = $db->prepare($query);

        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $user_id);
        // //excute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // var_dump($row);
        // die();
    }

    if (isset($_POST['update'])) {
        $date = $_POST['date'];
        $query = 'UPDATE weather
        SET date = :date
        WHERE weather_id = :id ';
        //prepare statement
        $stmt = $db->prepare($query);

        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':id', $id);
        // //excute query
        $stmt->execute();
        header('Location: viewdata.php');
    }
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
        <h1>Current temperature is : <?php echo $row['weather_temp'] ?></h1>
        <h1>Weather is <?php echo $row['weather'] ?></h1>
        
        <form action="" method="POST">


            <label for="date"><h1>Date : </h1></label>
            <input type="date" name="date" id="date" value="<?php echo $row['date'] ?>"> <br> <br>

            <input type="submit" value="Update" name="update" class="btn btn-success">
        </form>
        <div class="logout" >
            <form action="" method="POST">
                <input type="submit" value="Logout" name="logout" class="btn btn-dark">
            </form>
        </div>
        
    </div>
    




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>