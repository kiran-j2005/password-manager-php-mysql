<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the password to edit
if (isset($_GET['id'])) {
    $password_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM passwords WHERE id = ? AND user_id = ?");
    $stmt->execute([$password_id, $_SESSION['user_id']]);
    $password = $stmt->fetch();

    if (!$password) {
        die("Password not found or access denied.");
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $username = $_POST['username'];
    $password_text = $_POST['password'];
    $notes = $_POST['notes'];

    $stmt = $pdo->prepare("UPDATE passwords SET title=?, username=?, password=?, notes=? WHERE id=?");
    $stmt->execute([$title, $username, $password_text, $notes, $password_id]);
    header("Location: dashboard.php");
    exit();
}

$page_title = "Edit Password - Password Manager";
include 'header.php';
?>

<div class="container py-4">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-white py-3 border-bottom">
            <h2 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Password</h2>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($password['title']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($password['username']); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" value="<?php echo htmlspecialchars($password['password']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea class="form-control" name="notes" rows="2"><?php echo htmlspecialchars($password['notes']); ?></textarea>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="dashboard.php" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
