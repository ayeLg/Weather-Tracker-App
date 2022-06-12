<?php

include 'database.php';

if (isset($_POST['submit'])) {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //create query
    $query = 'INSERT INTO user (user_name, user_email, user_password) 
         VALUES 
         (:user_name, :user_email, :user_password)';

    //prepare statement
    $stmt = $db->prepare($query);

    $stmt->bindParam(':user_name', $name);
    $stmt->bindParam(':user_email', $email);
    $stmt->bindParam(':user_password', $password);

    //excute query
    $stmt->execute();

    // execute the query 
    if ($stmt->execute()) {
        header('Location: login.php');
    }

    //print error if something goes wrong
    printf("Error %s. \n", $stmt->error);
    return false;
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
        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">User Name</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email">

            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <!-- <button type="submit" class="btn btn-primary" name="submit">Submit</button> -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
                ​ <a href="login.php" class="btn btn-secondary"> Login </a>
            </div>
        </form>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>