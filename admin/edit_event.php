<?php
include '../includes/db.php';
include '../includes/header.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-warning'>No event selected.</div>";
    include '../includes/footer.php';
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM events WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    echo "<div class='alert alert-danger'>Event not found.</div>";
    include '../includes/footer.php';
    exit;
}

$event = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $desc = $conn->real_escape_string($_POST['description']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $conn->real_escape_string($_POST['location']);

    $image = $event['image'];
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "../images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    $sql = "UPDATE events SET title='$title', description='$desc', date='$date', time='$time', location='$location', image='$image' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Event updated successfully.</div>";
        $event = array_merge($event, $_POST, ['image' => $image]);
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<h2 class="mb-4">Edit Event</h2>
<form method="POST" enctype="multipart/form-data" class="mb-4">
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($event['title']); ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($event['description']); ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Date</label>
        <input type="date" name="date" class="form-control" value="<?php echo htmlspecialchars($event['date']); ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Time</label>
        <input type="time" name="time" class="form-control" value="<?php echo htmlspecialchars($event['time']); ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($event['location']); ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Event Image</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        <?php if (!empty($event['image'])): ?>
            <p class="mt-2">Current Image: <img src="../images/<?php echo $event['image']; ?>" width="100"></p>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Update Event</button>
    <a href="dashboard.php" class="btn btn-secondary">Back</a>
</form>

<?php include '../includes/footer.php'; ?>
