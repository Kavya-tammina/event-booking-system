<?php
include 'includes/db.php';
include 'includes/header.php';
?>

<h1 class="text-center mb-4">Upcoming Events</h1>
<div class="row">
<?php
$sql = "SELECT * FROM events ORDER BY date ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0):
    while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <?php if (!empty($row['image'])): ?>
                    <img src="images/<?php echo $row['image']; ?>" class="card-img-top" alt="Event Image">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                    <p class="card-text">
                        <small class="text-muted">
                            Date: <?php echo htmlspecialchars($row['date']); ?> |
                            Time: <?php echo htmlspecialchars($row['time']); ?>
                        </small>
                    </p>
                    <p class="card-text">
                        <small class="text-muted">Location: <?php echo htmlspecialchars($row['location']); ?></small>
                    </p>
                    <a href="event.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
<?php endwhile;
else:
    echo "<div class='alert alert-info text-center'>No events found.</div>";
endif;
?>
</div>

<?php include 'includes/footer.php'; ?>
