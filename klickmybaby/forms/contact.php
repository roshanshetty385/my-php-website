<?php
session_start();
require_once '../includes/db_connect.php';

// Initialize response array
$response = [
    'status' => 'error',
    'message' => 'An error occurred while processing your message.'
];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? sanitize_input($_POST['subject']) : '';
    $message = isset($_POST['message']) ? sanitize_input($_POST['message']) : '';
    
    // Validate input
    $errors = [];
    
    if (empty($name) || strlen($name) < 4) {
        $errors[] = "Name must be at least 4 characters";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    if (empty($subject) || strlen($subject) < 4) {
        $errors[] = "Subject must be at least 4 characters";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, proceed with database insertion
    if (empty($errors)) {
        $conn = connectDB();
        
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        
        if ($stmt->execute()) {
            // Generate a new token for the next submission
            $new_token = md5(uniqid(mt_rand(), true));
            $_SESSION['contact_form_token'] = $new_token;
            
            $response = [
                'status' => 'success',
                'message' => 'Your message has been sent. Thank you!',
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
$redirect = '../index.php';
if ($response['status'] === 'success') {
    $redirect .= '?contact_status=success&message=' . urlencode($response['message']);
} else {
    $redirect .= '?contact_status=error&message=' . urlencode($response['message']);
}

header("Location: $redirect#contact-us");
exit;
?>