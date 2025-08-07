<?php
// add_password.php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $notes = $_POST['notes'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO passwords (user_id, title, username, password, notes) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $title, $username, $password, $notes]);
    header("Location: dashboard.php");
    exit();
}

$page_title = "Add Password - Password Manager";
include 'header.php';
?>

<div class="container py-4">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-white py-3 border-bottom">
            <h2 class="mb-0"><i class="bi bi-plus-lg me-2"></i>Add New Password</h2>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="dashboard.php" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
