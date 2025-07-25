<?php
include("includes/config.php");
include("includes/header.php");

$user_id = $_SESSION["user_id"];
$sql = "SELECT events.name, events.date, events.location, bookings.booking_date 
        FROM bookings 
        JOIN events ON bookings.event_id = events.id 
        WHERE bookings.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>My Bookings</h2>
<table border="1">
    <tr>
        <th>Event Name</th>
        <th>Event Date</th>
        <th>Location</th>
        <th>Booked On</th>
    </tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['date']; ?></td>
    <td><?php echo $row['location']; ?></td>
    <td><?php echo $row['booking_date']; ?></td>
</tr>
<?php } ?>
</table>

<?php
$stmt->close();
include("includes/footer.php");
?>
