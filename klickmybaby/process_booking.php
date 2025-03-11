<?php
session_start();
require_once 'includes/db_connect.php';

// Initialize response array
$response = [
    'status' => 'error',
    'message' => 'An error occurred while processing your booking request.'
];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize_input($_POST['phone']) : '';
    $preferred_date = isset($_POST['preferred_date']) ? sanitize_input($_POST['preferred_date']) : '';
    $preferred_time = isset($_POST['preferred_time']) ? sanitize_input($_POST['preferred_time']) : '';
    $package_type = isset($_POST['package_type']) ? sanitize_input($_POST['package_type']) : '';
    $special_requests = isset($_POST['special_requests']) ? sanitize_input($_POST['special_requests']) : '';
    
    // Validate input
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    }
    
    if (empty($preferred_date)) {
        $errors[] = "Preferred date is required";
    } else {
        // Validate date format (YYYY-MM-DD)
        $date_parts = explode('-', $preferred_date);
        if (count($date_parts) !== 3 || !checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
            $errors[] = "Invalid date format. Please use YYYY-MM-DD format.";
        }
        
        // Check if date is in the future
        $selected_date = new DateTime($preferred_date);
        $today = new DateTime();
        if ($selected_date < $today) {
            $errors[] = "Please select a future date for your booking.";
        }
    }
    
    if (empty($preferred_time)) {
        $errors[] = "Preferred time is required";
    }
    
    if (empty($package_type)) {
        $errors[] = "Package type is required";
    }
    
    // If no errors, proceed with database insertion
    if (empty($errors)) {
        $conn = connectDB();
        
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO bookings (name, email, phone, preferred_date, preferred_time, package_type, special_requests) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $email, $phone, $preferred_date, $preferred_time, $package_type, $special_requests);
        
        if ($stmt->execute()) {
            // Generate a new token for the next submission
            $new_token = md5(uniqid(mt_rand(), true));
            $_SESSION['booking_form_token'] = $new_token;
            
            $response = [
                'status' => 'success',
                'message' => 'Thank you for your booking request! We will contact you shortly to confirm your appointment.',
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
    $redirect .= '?booking_status=success&message=' . urlencode($response['message']);
} else {
    $redirect .= '?booking_status=error&message=' . urlencode($response['message']);
}

header("Location: $redirect#booking");
exit;
?>