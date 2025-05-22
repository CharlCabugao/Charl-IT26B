<?php
session_start();
include 'connection.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php?error=Invalid user ID");
    exit();
}

$id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: dashboard.php?success=User deleted successfully");
        exit();
    } catch (PDOException $e) {
        $error = "Error deleting user: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <h2>Confirm Delete User</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php else: ?>
        <div class="alert alert-warning">
            Are you sure you want to delete user with ID <?= htmlspecialchars($id) ?>?
        </div>

        <form method="post">
            <button type="submit" name="confirm" class="btn btn-danger">Yes, Delete</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
