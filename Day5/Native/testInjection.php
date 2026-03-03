<?php
require("connection.php");

echo "<h2>Vulnerable Login</h2>";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "select * from user 
              WHERE email = '$email' 
              AND password = '$password'";
              

    echo "<p><strong>Executed Query:</strong> $query</p>";

    $result = $connection->query($query);
    $user = $result->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "<h3 style='color:green'>Login Success  (Site Hacked)</h3>";
    } else {
        echo "<h3 style='color:red'>Login Failed</h3>";
    }
}
?>

<form method="POST">
    <input type="text" name="email" placeholder="Email"><br><br>
    <input type="text" name="password" placeholder="Password"><br><br>
    <button name="login">Login</button>
</form>