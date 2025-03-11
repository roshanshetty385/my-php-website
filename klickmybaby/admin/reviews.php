<?php
// Ensure this file is included, not accessed directly
if (!defined('ADMIN_ACCESS')) {
    die('Direct access not permitted');
}

// Process review status updates
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['review_action'])) {
    $review_id = isset($_POST['review_id']) ? (int)$_POST['review_id'] : 0;
    $action = isset($_POST['action']) ? sanitize_input($_POST['action']) : '';
    
    if ($review_id > 0 && in_array($action, ['approve', 'reject', 'delete'])) {
        $conn = connectDB();
        
        if ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
            $stmt->bind_param("i", $review_id);
        } else {
            $status = ($action === 'approve') ? 'approved' : 'rejected';
            $stmt = $conn->prepare("UPDATE reviews SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $review_id);
        }
        
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
}

// Get all reviews
$conn = connectDB();
$sql = "SELECT id, name, rating, review, status, created_at FROM reviews ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<h3>Customer Reviews</h3>

<?php if ($result && $result->num_rows > 0): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Rating</th>
                <th>Review</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['rating']; ?> ★</td>
                    <td><?php echo htmlspecialchars($row['review']); ?></td>
                    <td>
                        <span class="badge bg-<?php 
                            echo ($row['status'] === 'approved') ? 'success' : 
                                (($row['status'] === 'rejected') ? 'danger' : 'warning'); 
                        ?>">
                            <?php echo ucfirst($row['status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                    <td>
                        <form method="post" action="" class="d-inline">
                            <input type="hidden" name="review_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="review_action" value="1">
                            
                            <?php if ($row['status'] !== 'approved'): ?>
                                <button type="submit" name="action" value="approve" class="btn btn-sm btn-success">Approve</button>
                            <?php endif; ?>
                            
                            <?php if ($row['status'] !== 'rejected'): ?>
                                <button type="submit" name="action" value="reject" class="btn btn-sm btn-warning">Reject</button>
                            <?php endif; ?>
                            
                            <button type="submit" name="action" value="delete" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">No reviews found.</div>
<?php endif; ?>

<?php
$conn->close();
?>