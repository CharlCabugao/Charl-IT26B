<?php
session_start();
include 'connection.php';
include 'includes/messages.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name     = $_POST['name'];
        $email    = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role_id  = $_POST['role_id'];

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $role_id]);

        header("Location: dashboard.php?success=User added successfully");
        exit();
    } catch (PDOException $e) {
        header("Location: create_user.php?error=Could not add user: " . urlencode($e->getMessage()));
        exit();
    }
}

$roles = $conn->query("SELECT * FROM roles")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4 text-center">Create User</h2>

    <?php showMessage(); ?>

    <form method="post" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" class="form-control" required placeholder="Full Name">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" class="form-control" required placeholder="Email Address">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input name="password" type="password" class="form-control" required placeholder="Password">
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role_id" class="form-select" required>
                <option value="">Select Role</option>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= htmlspecialchars($role['id']) ?>"><?= htmlspecialchars($role['role_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Save User</button>
        <a href="dashboard.php" class="btn btn-secondary mt-2 w-100">Back to Dashboard</a>
    </form>
</div>
</body>
</html>
