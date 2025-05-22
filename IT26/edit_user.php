<?php
session_start();
include 'connection.php';

try {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name    = $_POST['name'];
        $email   = $_POST['email'];
        $role_id = $_POST['role_id'];

        $update = $conn->prepare("UPDATE users SET name = ?, email = ?, role_id = ? WHERE id = ?");
        $update->execute([$name, $email, $role_id, $id]);
        header("Location: dashboard.php?success=User updated successfully");
        exit();
    }

    $roles = $conn->query("SELECT * FROM roles")->fetchAll();
} catch (PDOException $e) {
    $error = "Error updating user: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4">Edit User</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role_id" class="form-select" required>
                <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id'] ?>" <?= $user['role_id'] == $role['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($role['role_name']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
