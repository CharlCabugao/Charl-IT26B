<?php
session_start();
include 'connection.php';
include 'includes/messages.php';

try {
    $query = "SELECT u.id, u.name, u.email, r.role_name 
              FROM users u 
              INNER JOIN roles r ON u.role_id = r.id";
    $users = $conn->query($query)->fetchAll();
} catch (PDOException $e) {
    header("Location: dashboard.php?error=Could not load data");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Dashboard</h2>
    <?php showMessage(); ?>

    <div class="mb-3 d-flex justify-content-between">
        <a href="create_user.php" class="btn btn-success">+ Add User</a>
        <a href="logout.php" class="btn btn-outline-danger">Logout</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['role_name'] ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
