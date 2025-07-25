<?php
include 'includes/db.php';
include 'includes/header.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['user'] = $conn->insert_id;
        header("Location: index.php");
    } else {
        $error = "Registration failed: " . $conn->error;
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4">User Registration</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <button type="submit" class="btn btn-success">Register</button>
            <a href="login.php" class="btn btn-link">Login</a>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
