<?php
include 'includes/db.php';
include 'includes/header.php';
session_start();

if (!isset($_SESSION['user'])) {
    echo "<div class='alert alert-warning'>You need to <a href='login.php'>login</a> to view your bookings.</div>";
    include 'includes/footer.php';
    exit;
}

$user_id = $_SESSION['user'];
$sql = "SELECT b.id, e.title, e.date, e.time, e.location, b.seats, b.booking_date 
        FROM bookings b
        JOIN events e ON b.event_id = e.id
        WHERE b.user_id = $user_id
        ORDER BY b.booking_date DESC";

$result = $conn->query($sql);
?>

<h2 class="mb-4">My Bookings</h2>

<?php if ($result->num_rows > 0): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Event</th>
                <th>Date & Time</th>
                <th>Location</th>
                <th>Seats</th>
                <th>Booking Date</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['date']) . " at " . htmlspecialchars($row['time']); ?></td>
                <td><?php echo htmlspecialchars($row['location']); ?></td>
                <td><?php echo htmlspecialchars($row['seats']); ?></td>
                <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">You have no bookings yet.</div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
