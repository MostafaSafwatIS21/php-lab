<?php
require "connection.php";

if (isset($_SESSION['login_ID'])) {
    require "navbar.php";
    $userId = $_SESSION['login_ID'];
    $query = "select * from users where id=:id";
    $sqlQuery = $connection->prepare($query);
    $sqlQuery->execute([
        ':id' => $userId
    ]);
    $user = $sqlQuery->fetch(PDO::FETCH_ASSOC);
} else {
    header("location:login.php?message=you must login first");
    exit;
}
?>
<section class="vh-100" style="background-color: #9de2ff;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-md-9 col-lg-7 col-xl-5">
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex text-black">
                            <div class="flex-shrink-0">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-profiles/avatar-1.webp" alt="Generic placeholder image" class="img-fluid" style="width: 180px; border-radius: 10px;">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1"><?php echo htmlspecialchars($user["name"] ?? ""); ?></h5>
                                <p class="mb-2 pb-1" style="color: #2b2a2a;"><?php echo htmlspecialchars($user["email"] ?? ""); ?></p>

                                <div class="d-flex pt-1">
                                    <button type="button" class="btn btn-outline-primary me-1 flex-grow-1" data-bs-toggle="modal" data-bs-target="#updateProfile">Update</button>
                                    <button type="button" class="btn btn-danger flex-grow-1" data-bs-toggle="modal" data-bs-target="#deleteProfile">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="updateProfile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="server.php" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="profile-name">Name</label>
                        <input class="form-control" type="text" name="name" id="profile-name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="profile-email">Email</label>
                        <input class="form-control" type="email" name="email" id="profile-email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
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

<div class="modal fade" id="deleteProfile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete your account?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="server.php" method="post" class="d-inline">
                    <button type="submit" name="btn-delete" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>