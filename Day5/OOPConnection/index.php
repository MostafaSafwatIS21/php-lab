<?php
require "connection.php";

if (isset($_POST['btn-update'])) {
    $userId = (int)($_POST['user_id'] ?? 0);
    $userName = trim($_POST['name'] ?? '');
    $userEmail = trim($_POST['email'] ?? '');

    if ($userId > 0) {
        $database->update("users", [
            'id' => $userId,
            'name' => $userName,
            'email' => $userEmail
        ]);
        header("location:index.php?message=account updated successfully");
        exit;
    }
}

if (isset($_POST['btn-delete'])) {
    $userId = (int)($_POST['user_id'] ?? 0);
    if ($userId > 0) {
        $database->delete("users", $userId);
        header("location:index.php?message=account deleted successfully");
        exit;
    }
}

$allUsers = $database->index("users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php require "boostrapCss.php"; ?>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <?php if (isset($_GET['message'])) : ?>
            <p class="alert alert-success text-center"><?php echo htmlspecialchars($_GET['message']); ?></p>
        <?php endif; ?>
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">All Users</h2>
            </div>
        </div>
        <div class="row">
            <?php
            if (!empty($allUsers)) {
                foreach ($allUsers as $user) {
                    echo '
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($user['name']) . '</h5>
                                <p class="card-text">
                                    <strong>Email:</strong> ' . htmlspecialchars($user['email']) . '<br>
                                </p>
                            </div>
                            <div class="card-footer bg-white border-top text-center">
                                <a href="show.php?id=' . $user['id'] . '" class="btn btn-sm btn-warning">Show</a>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateUser' . $user['id'] . '">Update</button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUser' . $user['id'] . '">Delete</button>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="updateUser' . $user['id'] . '" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="index.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name="user_id" value="' . (int)$user['id'] . '">
                                        <div class="mb-3">
                                            <label class="form-label" for="name-' . $user['id'] . '">Name</label>
                                            <input class="form-control" type="text" name="name" id="name-' . $user['id'] . '" value="' . htmlspecialchars($user['name']) . '" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="email-' . $user['id'] . '">Email</label>
                                            <input class="form-control" type="email" name="email" id="email-' . $user['id'] . '" value="' . htmlspecialchars($user['email']) . '" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="btn-update" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteUser' . $user['id'] . '" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete <strong>' . htmlspecialchars($user['name']) . '</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="index.php" method="post" class="d-inline">
                                        <input type="hidden" name="user_id" value="' . (int)$user['id'] . '">
                                        <button type="submit" name="btn-delete" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                }
            } else {
                echo '<div class="col-12"><p class="text-muted text-center">No users found.</p></div>';
            }
            ?>
        </div>
    </div>

    <?php require "bootstrapJs.php"; ?>

</body>

</html>