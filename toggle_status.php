<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id']) || !isset($_GET['status'])) {
    header("Location: login.php");
    exit();
}

$allowed_statuses = ['active', 'inactive'];
$new_status = in_array($_GET['status'], $allowed_statuses) ? $_GET['status'] : 'active';

$stmt = $pdo->prepare("UPDATE passwords SET status = ? WHERE id = ? AND user_id = ?");
$stmt->execute([$new_status, $_GET['id'], $_SESSION['user_id']]);

header("Location: " . ($new_status === 'active' ? 'inactive_passwords.php' : 'dashboard.php'));
exit();
?>
