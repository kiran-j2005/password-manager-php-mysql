<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the password to view
if (isset($_GET['id'])) {
    $password_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM passwords WHERE id = ? AND user_id = ?");
    $stmt->execute([$password_id, $_SESSION['user_id']]);
    $password = $stmt->fetch();

    if (!$password) {
        die("Password not found or access denied.");
    }
}

$page_title = "View Password - Password Manager";
include 'header.php';
?>

<div class="container py-4">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-white py-3 border-bottom">
            <h2 class="mb-0"><i class="bi bi-eye me-2"></i>View Password</h2>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Title</label>
                <p class="form-control-static"><?php echo htmlspecialchars($password['title']); ?></p>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Username</label>
                <p class="form-control-static"><?php echo htmlspecialchars($password['username']); ?></p>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="passwordField" 
                           value="<?php echo htmlspecialchars($password['password']); ?>" readonly>
                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>  
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Notes</label>
                <p class="form-control-static"><?php echo nl2br(htmlspecialchars($password['notes'])); ?></p>
            </div>
            <div class="mt-4 d-flex justify-content-end gap-2">
                <a href="edit_password.php?id=<?php echo $password['id']; ?>" class="btn btn-outline-primary">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a>
                <a href="dashboard.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('passwordField');
        const icon = this.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>

<?php include 'footer.php'; ?>
