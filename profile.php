<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name']; // Get name from session

// Fetch user data from database
$stmt = $pdo->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user_data) {
    // User not found in DB (shouldn't happen if session is valid)
    session_destroy();
    header("Location: login.php");
    exit();
}

$current_name = $user_data['name'];
$current_email = $user_data['email'];
$message = '';
$message_type = '';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $new_name = trim($_POST['name']);
//     $new_email = trim($_POST['email']);
//     $password_confirm = $_POST['password_confirm']; // For security, require current password to change sensitive info

//     // Validate inputs
//     if (empty($new_name) || empty($new_email) || empty($password_confirm)) {
//         $message = "All fields are required.";
//         $message_type = "danger";
//     } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
//         $message = "Invalid email format.";
//         $message_type = "danger";
//     } else {
//         // Verify current password before updating
//         $stmt_check_pass = $pdo->prepare("SELECT password FROM users WHERE id = ?");
//         $stmt_check_pass->execute([$user_id]);
//         $stored_hashed_password = $stmt_check_pass->fetchColumn();

//         if (!password_verify($password_confirm, $stored_hashed_password)) {
//             $message = "Incorrect password. Please enter your current password to save changes.";
//             $message_type = "danger";
//         } else {
//             // Check if new name or email already exists (for other users)
//             $stmt_check_duplicate = $pdo->prepare("SELECT id FROM users WHERE (name = ? OR email = ?) AND id != ?");
//             $stmt_check_duplicate->execute([$new_name, $new_email, $user_id]);
//             if ($stmt_check_duplicate->fetch()) {
//                 $message = "Name or email already taken by another user.";
//                 $message_type = "danger";
//             } else {
//                 // Update user data
//                 $stmt_update = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
//                 if ($stmt_update->execute([$new_name, $new_email, $user_id])) {
//                     // Update session variable if name changed
//                     $_SESSION['user_name'] = $new_name;
//                     $current_name = $new_name;
//                     $current_email = $new_email;
//                     $message = "Profile updated successfully!";
//                     $message_type = "success";
//                 } else {
//                     $message = "Failed to update profile. Please try again.";
//                     $message_type = "danger";
//                 }
//             }
//         }
//     }
// }

$page_title = "My Profile - Password Manager";
include 'header.php';
?>

<div class="container py-4">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-white py-3 border-bottom">
            <h2 class="mb-0"><i class="bi bi-person-circle me-2"></i>My Profile</h2>
        </div>
        <div class="card-body">
            <?php if ($message): ?>
                <div class="alert alert-<?= $message_type ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($current_name) ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($current_email) ?>" required>
                    </div>
                </div>
                <hr>
                <!-- <p class="text-muted"><small>Enter your current password to save changes.</small></p>
                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Current Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                    </div>
                </div> -->

                <div class="d-flex justify-content-end gap-2">
                    <!-- <a href="logout.php" class="btn btn-danger">Logout</a> -->

                 
                        <a href="logout.php" class="btn btn-danger" id="globalLogoutConfirmLink"> <!-- Changed ID to 'globalLogoutConfirmLink' -->
                            Logout
                        </a>
                  

                    <a href="dashboard.php" class="btn btn-outline-secondary">Cancel</a>
                    <!-- <button type="submit" class="btn btn-primary">Save Changes</button> -->
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // script.js

    document.addEventListener('DOMContentLoaded', function() {

        // ... (Your existing password toggle and copy logic here) ...

        // --- Logout Confirmation Handlers ---
        // Handle the global logout link from the header
        const globalLogoutLink = document.getElementById('globalLogoutConfirmLink');
        if (globalLogoutLink) {
            globalLogoutLink.addEventListener('click', function(event) {
                if (!confirm('Are you sure you want to log out?')) {
                    event.preventDefault(); // Prevent navigation
                }
            });
        }

        // Handle the logout link specific to the profile page
        const profileLogoutLink = document.getElementById('profileLogoutConfirmLink');
        if (profileLogoutLink) {
            profileLogoutLink.addEventListener('click', function(event) {
                if (!confirm('Are you sure you want to log out?')) {
                    event.preventDefault(); // Prevent navigation
                }
            });
        }

        // ... (Your existing card animation and other JS here) ...
    });
</script>
<?php include 'footer.php'; ?>