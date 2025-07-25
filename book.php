<?php
include 'includes/db.php';
include 'includes/header.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "Event not found.";
    exit;
}

$event_id = (int)$_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seats = (int)$_POST['seats'];
    $user_id = $_SESSION['user'];

    $sql = "INSERT INTO bookings (user_id, event_id, seats) VALUES ($user_id, $event_id, $seats)";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Booking successful! <a href='index.php'>Go back to events</a></p>";
        include 'includes/footer.php';
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM events WHERE id=$event_id";
$result = $conn->query($sql);
if ($result->num_rows != 1) {
    echo "Event not found.";
    exit;
}
$event = $result->fetch_assoc();
?>

<h2>Book Tickets for <?php echo $event['title']; ?></h2>
<form method="POST">
    <label for="seats">Number of Seats:</label><br>
    <input type="number" name="seats" min="1" required><br><br>
    <button type="submit">Confirm Booking</button>
</form>

<?php include 'includes/footer.php'; ?>
