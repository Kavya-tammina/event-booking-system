<?php
include 'includes/db.php';
include 'includes/header.php';
session_start();

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-warning'>No event selected.</div>";
    include 'includes/footer.php';
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM events WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    echo "<div class='alert alert-danger'>Event not found.</div>";
    include 'includes/footer.php';
    exit;
}

$event = $result->fetch_assoc();
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-4">
            <?php if (!empty($event['image'])): ?>
                <img src="images/<?php echo $event['image']; ?>" class="card-img-top" alt="Event Image">
            <?php endif; ?>
            <div class="card-body">
                <h3 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h3>
                <p class="card-text"><?php echo htmlspecialchars($event['description']); ?></p>
                <p class="card-text"><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
                <p class="card-text"><strong>Time:</strong> <?php echo htmlspecialchars($event['time']); ?></p>
                <p class="card-text"><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>

                <?php if (isset($_SESSION['user'])): ?>
                    <form method="POST" action="book.php">
                        <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                        <div class="mb-3">
                            <label for="seats" class="form-label">Number of Seats</label>
                            <input type="number" name="seats" id="seats" class="form-control" min="1" max="10" required>
                        </div>
                        <button type="submit" class="btn btn-success">Book Now</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-info mt-3">
                        <a href="login.php" class="btn btn-primary">Login</a> or <a href="register.php" class="btn btn-secondary">Register</a> to book this event.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
