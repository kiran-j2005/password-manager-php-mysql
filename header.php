<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Password Manager' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --dark: #1e293b;
        }

        body {
            background-color: #f8fafc;
        }

        .navbar {
            background: var(--dark) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .nav-link {
            position: relative;
            margin: 0 10px;
        }

        .nav-link:hover::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary);
            animation: underline 0.3s ease;
        }

        @keyframes underline {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
                <i class="bi bi-shield-lock fs-4 me-2" style="color: var(--primary);"></i>
                <span>PasswordVault</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add_password.php">
                                <i class="bi bi-plus me-1"></i> Add
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="inactive_passwords.php">
                                <i class="bi bi-trash3 me-1"></i> Trash
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php" id="logoutConfirmLink">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">
                                <i class="bi bi-person-circle me-1"></i> Profile
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">
                                <i class="bi bi-person-plus me-1"></i> Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container py-4">

    <!-- In your footer.php, or common script file -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const logoutLink = document.getElementById('logoutConfirmLink');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(event) {
            // Check if the user clicked 'Cancel'
            if (!confirm('Are you sure you want to log out?')) {
                event.preventDefault(); // Prevent the default link navigation
            }
        });
    }
});
</script>