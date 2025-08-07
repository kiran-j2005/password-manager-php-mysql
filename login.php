<?php
// login.php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']; // Changed from $username to $email
    $password = $_POST['password'];

    // Authenticate using email
    $stmt = $pdo->prepare("SELECT id, name, password FROM users WHERE email = ?"); // Query by email
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name']; // Store the user's name (from the 'name' column)
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password."; // Updated error message
    }
}

$page_title = "Login - Password Manager";
include 'header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <!-- Logo and Header -->
                    <div class="text-center mb-4">
                        <div class="logo-circle bg-primary mb-3 mx-auto">
                            <i class="bi bi-shield-lock text-white fs-3"></i>
                        </div>
                        <h2 class="fw-bold mb-1">PasswordVault</h2>
                        <p class="text-muted">Secure your digital life</p>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success'])): /* Show registration success message */?>
                        <div class="alert alert-success"><?php echo $_SESSION['success']; ?></div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label> <!-- Changed label to Email -->
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span> <!-- Changed icon to envelope -->
                                <input type="email" class="form-control" id="email" name="email" required> <!-- Changed id and name to email, type to email -->
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Login
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">Don't have an account? <a href="register.php">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /*
    This style block is for the login/register pages.
    It's recommended to move these styles to your central style.css file
    if you haven't already, to avoid duplication and improve maintainability.
    */
    .logo-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
    }
    
    .card {
        border-radius: 1rem;
        overflow: hidden;
        border: none;
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    
    .input-group-text {
        background-color: #f8f9fa;
    }
    
    body {
        background-color: #f5f7fa;
    }
</style>

<?php include 'footer.php'; ?>