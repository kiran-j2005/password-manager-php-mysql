<?php
// delete_password.php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $password_id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM passwords WHERE id = ? AND user_id = ?");
        $stmt->execute([$password_id, $_SESSION['user_id']]);
        header("Location: dashboard.php");
        exit();
    } catch (PDOException $e) {
        die("Error deleting password: " . $e->getMessage());
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>
