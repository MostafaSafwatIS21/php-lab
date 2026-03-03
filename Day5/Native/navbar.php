<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <?php require "boostrapCss.php"  ?>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="connection.php">Connection</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">

          <?php if (isset($_SESSION['login_ID'])) { ?>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="profile.php">Profile</a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php">Register</a>
            </li>
          <?php } ?>
          <li class="nav-item">
            <a class="nav-link" href="users.php">users</a>
          </li>
          <?php if (isset($_SESSION['login_ID'])) { ?>
            <li class="nav-item">
              <a class="nav-link" href="server.php?logout=true">Logout</a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>

  <?php require "bootstrapJs.php"  ?>

</body>

</html>