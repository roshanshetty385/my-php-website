<?php
session_start();
require_once 'includes/db_connect.php';

// Initialize response array
$response = [
    'status' => 'error',
    'message' => 'An error occurred while processing your review.'
];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $review = isset($_POST['review']) ? sanitize_input($_POST['review']) : '';
    
    // Validate input
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if ($rating < 1 || $rating > 5) {
        $errors[] = "Rating must be between 1 and 5";
    }
    
    if (empty($review)) {
        $errors[] = "Review text is required";
    }
    
    // If no errors, proceed with database insertion
    if (empty($errors)) {
        $conn = connectDB();
        
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO reviews (name, rating, review) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $name, $rating, $review);
        
        if ($stmt->execute()) {
            // Generate a new token for the next submission
            $new_token = md5(uniqid(mt_rand(), true));
            $_SESSION['review_form_token'] = $new_token;
            
            $response = [
                'status' => 'success',
                'message' => 'Thank you for your review! It will be displayed after moderation.',
                'token' => $new_token
            ];
        } else {
            $response['message'] = "Error: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
    } else {
        $response['message'] = implode(", ", $errors);
    }
}

// Return JSON response for AJAX requests
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// For non-AJAX requests, redirect back to the page with a message
$redirect = 'index.php';
if ($response['status'] === 'success') {
    $redirect .= '?review_status=success&message=' . urlencode($response['message']);
} else {
    $redirect .= '?review_status=error&message=' . urlencode($response['message']);
}

header("Location: $redirect#reviews");
exit;
?>