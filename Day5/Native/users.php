<?php
require "connection.php";

$query = "select * from users order by id desc";
$sqlQuery = $connection->prepare($query);
$sqlQuery->execute();
$users = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require "navbar.php"; ?>

<div class="container mt-5">
    <?php if (isset($_GET['message'])): ?>
        <p class="alert alert-success text-center"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">All Users</h2>
        </div>
    </div>

    <div class="row">
        <?php if (!empty($users)) : ?>
            <?php foreach ($users as $user) : ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($user['name']); ?></h5>
                            <p class="card-text">
                                <strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?>
                            </p>
                        </div>
                        <div class="card-footer bg-white border-top text-center">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateUser<?php echo (int)$user['id']; ?>">Update</button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUser<?php echo (int)$user['id']; ?>">Delete</button>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="updateUser<?php echo (int)$user['id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="server.php" method="post">
                                <div class="modal-body">
                                    <input type="hidden" name="user_id" value="<?php echo (int)$user['id']; ?>">
                                    <div class="mb-3">
                                        <label class="form-label" for="name-<?php echo (int)$user['id']; ?>">Name</label>
                                        <input class="form-control" type="text" name="name" id="name-<?php echo (int)$user['id']; ?>" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="email-<?php echo (int)$user['id']; ?>">Email</label>
                                        <input class="form-control" type="email" name="email" id="email-<?php echo (int)$user['id']; ?>" value="<?php echo htmlspecialchars($user['email']); ?>" required>
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

                <div class="modal fade" id="deleteUser<?php echo (int)$user['id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete <strong><?php echo htmlspecialchars($user['name']); ?></strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="server.php" method="post" class="d-inline">
                                    <input type="hidden" name="user_id" value="<?php echo (int)$user['id']; ?>">
                                    <button type="submit" name="btn-delete" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12">
                <p class="text-muted text-center">No users found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>