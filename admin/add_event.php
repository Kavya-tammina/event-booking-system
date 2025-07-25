<?php
include '../includes/db.php';
include '../includes/header.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $desc = $conn->real_escape_string($_POST['description']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $conn->real_escape_string($_POST['location']);
    $image = $_FILES['image']['name'];
    $target = "../images/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO events (title, description, date, time, location, image)
                VALUES ('$title', '$desc', '$date', '$time', '$location', '$image')";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Event added successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Image upload failed.</div>";
    }
}
?>

<h2 class="mb-4">Add New Event</h2>
<form method="POST" enctype="multipart/form-data" class="mb-4">
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3" required></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Date</label>
        <input type="date" name="date" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Time</label>
        <input type="time" name="time" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Event Image</label>
        <input type="file" name="image" class="form-control" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-success">Add Event</button>
    <a href="dashboard.php" class="btn btn-secondary">Back</a>
</form>

<?php include '../includes/footer.php'; ?>
