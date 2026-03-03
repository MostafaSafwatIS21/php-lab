<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>

<body>
    <?php
    require "navbar.php";
    if (isset($_GET["message"])) {
        echo "<p class='alert alert-danger w-57 text-center'>" . $_GET["message"] . "</p>";
    }

    ?>

    <h1 class="text-center text-success">Login Page</h1>
    <form action="server.php" method="post" class="p-3 border border-1 w-75 mx-auto">
        <label class="form-label" for="email">Uer Email</label>
        <input class="form-control" type="text" name="email" id="email">
        <label class="form-label" for="password">User Password</label>
        <input class="form-control" type="password" name="password" id="password">
        <button name="btn-login" type="submit" class="btn btn-primary p-2 border-0 rounded-1 my-5">Login</button>
    </form>

</body>

</html>