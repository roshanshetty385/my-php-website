<?php
require_once 'includes/db_connect.php';

function getApprovedReviews($limit = 10) {
    $conn = connectDB();
    $reviews = [];
    
    $sql = "SELECT DISTINCT name, rating, review, created_at FROM reviews 
            WHERE status = 'approved' 
            ORDER BY created_at DESC 
            LIMIT ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
    }
    
    $stmt->close();
    $conn->close();
    
    return $reviews;
}

// Function to generate star rating HTML
function generateStarRating($rating) {
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $stars .= '<i class="bx bxs-star"></i> ';
        } else {
            $stars .= '<i class="bx bx-star"></i> ';
        }
    }
    return $stars;
}

// Get reviews for display
$reviews = getApprovedReviews();
?>

<!-- HTML output for reviews -->
<div id="reviewCarousel" class="carousel slide mt-5" data-bs-ride="carousel">
  <div class="carousel-inner">
    <?php 
    $active = true;
    foreach ($reviews as $review): 
    ?>
      <div class="carousel-item <?php echo $active ? 'active' : ''; ?>">
        <div class="review-item">
          <h4><?php echo htmlspecialchars($review['name']); ?></h4>
          <p><?php echo generateStarRating($review['rating']); ?></p>
          <p><?php echo htmlspecialchars($review['review']); ?></p>
        </div>
      </div>
    <?php 
    $active = false;
    endforeach; 
    
    // If no reviews, show a message
    if (empty($reviews)): 
    ?>
      <div class="carousel-item active">
        <div class="review-item">
          <h4>No Reviews Yet</h4>
          <p>Be the first to leave a review!</p>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <!-- Carousel Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>