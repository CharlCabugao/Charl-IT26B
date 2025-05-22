<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id  = $_POST['role_id'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?)");
    try {
        $stmt->execute([$name, $email, $password, $role_id]);
        $success = "Signup successful! <a href='login.php'>Login here</a>";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
$roles = $conn->query("SELECT * FROM roles")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <h2>Signup</h2>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="post" class="card p-4 shadow-sm" style="max-width: 400px;">
        <div class="mb-3">
            <input name="name" type="text" class="form-control" placeholder="Full Name" required>
        </div>
        <div class="mb-3">
            <input name="email" type="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input name="password" type="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-3">
            <select name="role_id" class="form-select" required>
                <option value="">Select Role</option>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success w-100">Sign Up</button>
        <a href="login.php" class="btn btn-secondary w-100 mt-2">Back to Login</a>
    </form>
</div>
</body>
</html>
