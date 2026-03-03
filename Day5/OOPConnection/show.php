<?php
require "connection.php";

$userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user = null;

if ($userId > 0) {
    $result = $database->show("users", $userId);
    if (!empty($result)) {
        $user = $result[0];
    }
}
?>

<?php require "navbar.php"; ?>

<div class="container mt-5">
    <?php if ($user) : ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title mb-3">User Details</h3>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <a href="index.php" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <p class="text-muted text-center">User not found.</p>
        <div class="text-center">
            <a href="index.php" class="btn btn-secondary">Back</a>
        </div>
    <?php endif; ?>
</div>

<?php require "bootstrapJs.php"; ?>