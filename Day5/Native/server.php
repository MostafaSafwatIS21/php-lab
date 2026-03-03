<?php


require "connection.php";


if (isset($_POST["btn-register"])) {
    $userName = trim($_POST['name']);
    $userEmail = $_POST['email'];
    $userPassword = $_POST['password'];



    $namePattern = "/^[a-zA-Z ]+$/";
    $nameLettersCount = strlen(str_replace(' ', '', $userName));
    if (!preg_match($namePattern, $userName) || $nameLettersCount < 3) {
        header("location:register.php?message=enter vaild name must be more than 3 characters");
        exit;
    }
    $passwordPattern = "/^[0-9]{6,15}$/";
    if (!preg_match($passwordPattern, $userPassword)) {
        header("location:register.php?passwordmessage=enter vaild password must be more than 6 numbers and less than 15 ");
        exit;
    }
    $encreptedPassword = password_hash($userPassword, PASSWORD_DEFAULT);


    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        header("location:register.php?passwordmessage=enter vaild Email");
        exit;
    }


    $query = "select email from users where email='$userEmail'";
    $data = $connection->query($query);
    $result = $data->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {

        header("location:register.php?passwordmessage=this email already exist");
        exit;
    }


    // insert into database
    try {
        $query = "insert into users (name,email,password) values(:name,:email,:password)";
        // $connection->query($query);
        $sqlQuery = $connection->prepare($query);
        $sqlQuery->execute(
            [
                ':name' => $userName,
                ':email' => $userEmail,
                ':password' => $encreptedPassword,
            ]
        );
        header("location:login.php?message=Register success");

        // go to login page
        exit;
    } catch (PDOException $e) {

        echo $e->getMessage();
    }
}



if (isset($_POST["btn-login"])) {

    $userEmail = $_POST['email'];
    $userPassword = $_POST['password'];


    $query = "select * from users where email=:email";
    $sqlQuery = $connection->prepare($query);
    $sqlQuery->execute([
        ':email' => $userEmail
    ]);
    $user = $sqlQuery->fetch(PDO::FETCH_ASSOC);

    if ($user &&  password_verify($userPassword, $user["password"])) {

        $_SESSION['login_ID'] = $user['id'];
        header("location:profile.php?message=login success");
        exit;
    } else {
        header("location:login.php?message=check your email or password");
        exit;
    }
}
# Delete User
if (isset($_POST["btn-delete"])) {
    $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : (int)$_SESSION['login_ID'];
    $query = "delete from users where id=:id";
    $sqlQuery = $connection->prepare($query);
    $sqlQuery->execute([
        ':id' => $userId
    ]);
    if (isset($_POST['user_id'])) {
        header("location:users.php?message=account deleted successfully");
    } else {
        header("location:logout.php?message=account deleted successfully");
    }
    exit;
}
if (isset($_POST["btn-update"])) {
    $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : (int)$_SESSION['login_ID'];
    $userName = trim($_POST['name']);
    $userEmail = trim($_POST['email']);
    $query = "update users set name=:name,email=:email where id=:id";
    $sqlQuery = $connection->prepare($query);
    $sqlQuery->execute([
        ':id' => $userId,
        ':name' => $userName,
        ':email' => $userEmail
    ]);
    if (isset($_POST['user_id'])) {
        header("location:users.php?message=account updated successfully");
    } else {
        header("location:profile.php?message=account updated successfully");
    }
    exit;
}
