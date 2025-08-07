<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("
    SELECT id, title, username, created_at 
    FROM passwords 
    WHERE user_id = ? AND status = 'inactive'
    ORDER BY created_at DESC
");
$stmt->execute([$user_id]);
$passwords = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inactive Passwords - Password Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-trash"></i> Inactive Passwords</h2>
            <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <?php if (empty($passwords)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No inactive passwords found
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Username</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($passwords as $password): ?>
                            <tr>
                                <td><?= htmlspecialchars($password['title']) ?></td>
                                <td><?= htmlspecialchars($password['username']) ?></td>
                                <td><?= date('M j, Y', strtotime($password['created_at'])) ?></td>
                                <td>
                                    <a href="toggle_status.php?id=<?= $password['id'] ?>&status=active" 
                                       class="btn btn-sm btn-success me-2"
                                       onclick="return confirm('Restore this password?')">
                                        <i class="bi bi-arrow-counterclockwise"></i> Restore
                                    </a>
                                    <a href="delete_password.php?id=<?= $password['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Permanently delete this password?')">
                                        <i class="bi bi-trash-fill"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
