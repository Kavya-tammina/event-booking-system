<?php
include '../includes/db.php';
include '../includes/header.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM events ORDER BY date ASC";
$result = $conn->query($sql);
?>

<h2 class="mb-4">Admin Dashboard</h2>
<a href="add_event.php" class="btn btn-success mb-3">Add New Event</a>
<a href="logout.php" class="btn btn-danger mb-3">Logout</a>

<?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['time']); ?></td>
                <td><?php echo htmlspecialchars($row['location']); ?></td>
                <td>
                    <a href="edit_event.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="delete_event.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">No events found.</div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
