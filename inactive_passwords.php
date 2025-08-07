<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$page_title = "Trash - Password Manager";
include 'header.php';

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("
    SELECT * FROM passwords 
    WHERE user_id = ? AND status = 'inactive'
    ORDER BY created_at DESC
");
$stmt->execute([$user_id]);
$passwords = $stmt->fetchAll();
?>

<div class="container py-4">
    <!-- Dashboard Header with Stats -->
    <div class="dashboard-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1"><i class="bi bi-trash3 me-2"></i>Password Trash</h2>
                <p class="text-muted mb-0"><?= count($passwords) ?> deleted passwords</p>
            </div>
            <div class="d-flex">
                <a href="dashboard.php" class="btn btn-outline-secondary btn-md">
                    <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Password Table Card -->
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0"><i class="bi bi-trash me-2"></i>Deleted Passwords</h5>
        </div>
        <div class="card-body p-0">
            <?php if (isset($_GET['restored'])): ?>
                <div class="alert alert-success alert-dismissible fade show m-3">
                    Password restored successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3" style="width: 50px;">Sr.No</th>
                            <th class="py-3">Title</th>
                            <th class="py-3">Username</th>
                            <th class="py-3">Password</th>
                            <th class="text-end pe-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($passwords)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-trash fs-1 text-muted"></i>
                                        <h5 class="mt-3">Trash is empty</h5>
                                        <p class="text-muted">No passwords have been moved to trash</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($passwords as $index => $password): ?>
                                <tr>
                                    <td class="ps-4 text-muted fw-medium"><?= $index + 1 ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="password-icon me-3">
                                                <i class="bi bi-lock-fill"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?= htmlspecialchars($password['title']) ?></h6>
                                                <small class="text-muted">Created: <?= date('M d, Y', strtotime($password['created_at'])) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark"><?= htmlspecialchars($password['username']) ?></span>
                                    </td>
                                    <td>
                                        <div class="password-display d-flex align-items-center gap-2">
                                            <span class="password-placeholder">••••••••</span>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-link view-password" data-password="<?= htmlspecialchars($password['password']) ?>">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-link copy-password" data-password="<?= htmlspecialchars($password['password']) ?>">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="justify-content-end gap-2">
                                            <a href="toggle_status.php?id=<?= $password['id'] ?>&status=active" 
                                               class="btn btn-sm btn-outline-success" 
                                               title="Restore"
                                               onclick="return confirm('Restore this password?')">
                                               <i class="bi bi-arrow-counterclockwise"></i>
                                            </a>
                                            <a href="delete_password.php?id=<?= $password['id'] ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               title="Delete Permanently"
                                               onclick="return confirm('Permanently delete this password?')">
                                               <i class="bi bi-trash-fill"></i>
                                            </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add this toast container (same as dashboard.php) -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="copyToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body bg-success text-white">
            <i class="bi bi-check-circle me-2"></i> Password copied to clipboard!
        </div>
    </div>
</div>

<style>
    .dashboard-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
        border: none;
    }
    
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    
    .password-icon {
        width: 40px;
        height: 40px;
        background-color: rgba(13, 110, 253, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d6efd;
    }
    
    .password-display {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .password-placeholder {
        letter-spacing: 2px;
        font-family: monospace;
    }
    
    .empty-state {
        padding: 2rem;
        text-align: center;
    }
    
    .empty-state i {
        font-size: 3rem;
        opacity: 0.5;
    }
    
    .btn-group .btn {
        border-radius: 0.375rem !important;
        padding: 0.375rem 0.75rem;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.03);
    }
</style>

<script>
    // Toggle password visibility
    document.querySelectorAll('.view-password').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const placeholder = this.closest('.password-display').querySelector('.password-placeholder');
            if (this.innerHTML.includes('bi-eye')) {
                placeholder.textContent = this.dataset.password;
                this.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                placeholder.textContent = '••••••••';
                this.innerHTML = '<i class="bi bi-eye"></i>';
            }
        });
    });

    // Copy password to clipboard with toast notification
    document.querySelectorAll('.copy-password').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            navigator.clipboard.writeText(this.dataset.password).then(() => {
                // Show toast notification
                const toast = new bootstrap.Toast(document.getElementById('copyToast'));
                toast.show();
                
                // Button feedback
                const originalIcon = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check"></i>';
                setTimeout(() => {
                    this.innerHTML = originalIcon;
                }, 2000);
            });
        });
    });
</script>

<?php include 'footer.php'; ?>
