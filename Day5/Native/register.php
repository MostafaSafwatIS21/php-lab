<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
</head>

<body>
    <?php require "navbar.php"; ?>
    <h1 class="text-center text-success">Register Page</h1>
    <?php

    if (isset($_GET["message"])) {
        echo "<p class='alert alert-danger w-57 text-center'>" . $_GET["message"] . "</p>";
    }


    ?>
    <form action="server.php" method="post" class="p-3 border border-1 w-75 mx-auto">

        <label for="name" class="form-label">User Name</label>
        <input class="form-control" type="text" name="name" id="name" required>
        <label class="form-label" for="email">Uer Email</label>
        <input class="form-control" type="email" name="email" id="email" required>
        <label class="form-label" for="password">User Password</label>
        <input class="form-control" type="password" name="password" id="password" required>
        <button type="submit" name='btn-register' class="btn btn-primary p-2 border-0 rounded-1 my-5">Register</button>
    </form>

</body>

</html>