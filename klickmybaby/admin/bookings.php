<?php
// Ensure this file is included, not accessed directly
if (!defined('ADMIN_ACCESS')) {
    die('Direct access not permitted');
}

// Process booking status updates
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_action'])) {
    $booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
    $action = isset($_POST['action']) ? sanitize_input($_POST['action']) : '';
    
    if ($booking_id > 0 && in_array($action, ['confirm', 'complete', 'cancel', 'delete'])) {
        $conn = connectDB();
        
        if ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
            $stmt->bind_param("i", $booking_id);
        } else {
            $status = '';
            switch ($action) {
                case 'confirm':
                    $status = 'confirmed';
                    break;
                case 'complete':
                    $status = 'completed';
                    break;
                case 'cancel':
                    $status = 'cancelled';
                    break;
            }
            
            $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $booking_id);
        }
        
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
}

// Get all bookings
$conn = connectDB();
$sql = "SELECT id, name, email, phone, preferred_date, preferred_time, package_type, special_requests, status, created_at 
        FROM bookings 
        ORDER BY preferred_date DESC";
$result = $conn->query($sql);
?>

<h3>Booking Requests</h3>

<?php if ($result && $result->num_rows > 0): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Date & Time</th>
                <th>Package</th>
                <th>Special Requests</th>
                <th>Status</th>
                <th>Booked On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr class="<?php 
                    echo ($row['status'] === 'pending') ? 'table-warning' : 
                        (($row['status'] === 'confirmed') ? 'table-info' : 
                        (($row['status'] === 'completed') ? 'table-success' : 
                        (($row['status'] === 'cancelled') ? 'table-danger' : ''))); 
                ?>">
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td>
                        <strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a><br>
                        <strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?>
                    </td>
                    <td>
                        <strong>Date:</strong> <?php echo date('d M Y', strtotime($row['preferred_date'])); ?><br>
                        <strong>Time:</strong> <?php echo htmlspecialchars($row['preferred_time']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['package_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['special_requests']); ?></td>
                    <td>
                        <span class="badge bg-<?php 
                            echo ($row['status'] === 'pending') ? 'warning' : 
                                (($row['status'] === 'confirmed') ? 'info' : 
                                (($row['status'] === 'completed') ? 'success' : 
                                (($row['status'] === 'cancelled') ? 'danger' : ''))); 
                        ?>">
                            <?php echo ucfirst($row['status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                    <td>
                        <form method="post" action="" class="d-inline">
                            <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="booking_action" value="1">
                            
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <?php if ($row['status'] !== 'confirmed' && $row['status'] !== 'completed'): ?>
                                        <li><button type="submit" name="action" value="confirm" class="dropdown-item">Confirm</button></li>
                                    <?php endif; ?>
                                    
                                    <?php if ($row['status'] === 'confirmed'): ?>
                                        <li><button type="submit" name="action" value="complete" class="dropdown-item">Mark as Completed</button></li>
                                    <?php endif; ?>
                                    
                                    <?php if ($row['status'] !== 'cancelled' && $row['status'] !== 'completed'): ?>
                                        <li><button type="submit" name="action" value="cancel" class="dropdown-item">Cancel</button></li>
                                    <?php endif; ?>
                                    
                                    <li><hr class="dropdown-divider"></li>
                                    <li><button type="submit" name="action" value="delete" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</button></li>
                                </ul>
                            </div>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">No booking requests found.</div>
<?php endif; ?>

<?php
$conn->close();
?>