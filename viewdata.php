<?php
session_start();

include 'database.php';
include 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

if ($_SESSION['token']) {
    $user_id = $_SESSION['user_id'];
    //create query
    $query = 'SELECT * FROM weather WHERE user_id = ? ORDER BY weather_id DESC';

    //prepare statement
    $stmt = $db->prepare($query);

    // binding param
    $stmt->bindParam(1, $user_id);
    // //excute query
    $stmt->execute();

    if (isset($_GET['submit'])) {
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $query = 'SELECT * FROM weather  WHERE   date >= ? AND
        date  <= ? AND  user_id = ? ';

        //prepare statement
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $fromdate);
        $stmt->bindParam(2, $todate);
        $stmt->bindParam(3, $user_id);

        // //excute query
        $stmt->execute();
        // $row = $stmt->fetch(PDO::FETCH_ASSOC);

    }

    if (isset($_POST['clear'])) {

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
    <style>
        .center {
            width: 70%;
        }
    </style>
</head>

<body>
    <div class="center">
        <form action="" method="GET">
            <div class="d-flex justify-content-evenly">
                <div class="">
                    <label for="fromdate">From Date : </label>
                    <input type="date" name="fromdate" id="fromdate">
                </div>
                <div class="">
                    <label for="todate">To date : </label>
                    <input type="date" name="todate" id="todate">
                </div>
                <input type="submit" value="Search" name="submit" class="btn btn-outline-info">
               
            </div>
            

            
        </form>
        
        <table class="table table-success table-striped mt-5">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Weather </th>
                    <th scope="col">Tempature</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php



                $no = 1;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                ?>
                    <tr>
                        <td><?php echo $no++  ?></td>
                        <td><?php echo $weather ?> </td>
                        <td><?php echo $weather_temp ?> </td>
                        <td><?php echo $date ?> </td>
                        <td><a href="edit.php?id=<?php echo $weather_id ?>" class="btn btn-success">Update</a></td>
                    </tr>

                <?php
                }


                ?>




            </tbody>
        </table>
        <form action="" method="POST">
            <input type="submit" value="Clear Search" name="clear" class="btn btn-outline-warning">
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