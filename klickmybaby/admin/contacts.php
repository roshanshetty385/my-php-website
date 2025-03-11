<?php
// Ensure this file is included, not accessed directly
if (!defined('ADMIN_ACCESS')) {
    die('Direct access not permitted');
}

// Process contact message actions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_action'])) {
    $contact_id = isset($_POST['contact_id']) ? (int)$_POST['contact_id'] : 0;
    $action = isset($_POST['action']) ? sanitize_input($_POST['action']) : '';
    
    if ($contact_id > 0 && in_array($action, ['mark_read', 'mark_unread', 'delete'])) {
        $conn = connectDB();
        
        if ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
            $stmt->bind_param("i", $contact_id);
        } else {
            $is_read = ($action === 'mark_read') ? 1 : 0;
            $stmt = $conn->prepare("UPDATE contacts SET is_read = ? WHERE id = ?");
            $stmt->bind_param("ii", $is_read, $contact_id);
        }
        
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
}

// Get all contact messages
$conn = connectDB();
$sql = "SELECT id, name, email, subject, message, is_read, created_at FROM contacts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<h3>Contact Messages</h3>

<?php if ($result && $result->num_rows > 0): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr class="<?php echo ($row['is_read'] ? '' : 'table-primary'); ?>">
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a></td>
                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                    <td><?php echo htmlspecialchars(substr($row['message'], 0, 100)) . (strlen($row['message']) > 100 ? '...' : ''); ?></td>
                    <td>
                        <span class="badge bg-<?php echo ($row['is_read'] ? 'secondary' : 'primary'); ?>">
                            <?php echo ($row['is_read'] ? 'Read' : 'Unread'); ?>
                        </span>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                    <td>
                        <form method="post" action="" class="d-inline">
                            <input type="hidden" name="contact_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="contact_action" value="1">
                            
                            <?php if (!$row['is_read']): ?>
                                <button type="submit" name="action" value="mark_read" class="btn btn-sm btn-info">Mark Read</button>
                            <?php else: ?>
                                <button type="submit" name="action" value="mark_unread" class="btn btn-sm btn-secondary">Mark Unread</button>
                            <?php endif; ?>
                            
                            <button type="submit" name="action" value="delete" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this message?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">No contact messages found.</div>
<?php endif; ?>

<?php
$conn->close();
?>