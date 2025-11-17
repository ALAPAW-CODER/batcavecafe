<?php
session_start();

// Database configuration - You can change this to use MySQL later
$bookings_file = 'bookings.json';

// Initialize response
$response = [
    'success' => false,
    'message' => '',
    'reservation_id' => ''
];

// Check if user is logged in
if (!isset($_SESSION['isLoggedIn']) && !isset($_SESSION['isAdmin'])) {
    $response['message'] = 'Please log in to make a reservation.';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    $required_fields = ['reservationType', 'fullName', 'email', 'persons', 'startTime', 'endTime', 'date'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $response['message'] = 'Please fill in all required fields.';
            echo json_encode($response);
            exit();
        }
    }

    // Validate number of persons
    $persons = intval($_POST['persons']);
    if ($persons < 1 || $persons > 20) {
        $response['message'] = 'Number of persons must be between 1 and 20.';
        echo json_encode($response);
        exit();
    }

    // Calculate hours and total amount
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $start = intval(explode(':', $startTime)[0]);
    $end = intval(explode(':', $endTime)[0]);
    
    if ($end <= $start) {
        // Crossing midnight
        $hours = (24 - $start) + $end;
    } else {
        $hours = $end - $start;
    }
    
    if ($hours <= 0) {
        $response['message'] = 'Invalid time range. End time must be after start time.';
        echo json_encode($response);
        exit();
    }
    
    $hourly_rate = 100;
    $total_amount = $hours * $hourly_rate;

    // Generate unique reservation ID
    $reservation_id = 'TMBC-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

    // Prepare booking data
    $booking = [
        'reservation_id' => $reservation_id,
        'reservation_type' => $_POST['reservationType'],
        'full_name' => htmlspecialchars($_POST['fullName']),
        'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
        'persons' => $persons,
        'start_time' => $startTime,
        'end_time' => $endTime,
        'hours' => $hours,
        'date' => $_POST['date'],
        'special_requests' => htmlspecialchars($_POST['specialRequests'] ?? ''),
        'total_amount' => $total_amount,
        'payment_status' => 'pending',
        'proof_of_payment' => '',
        'status' => 'pending_payment',
        'created_at' => date('Y-m-d H:i:s'),
        'user_email' => $_SESSION['email'] ?? $_POST['email']
    ];

    // Load existing bookings
    $bookings = [];
    if (file_exists($bookings_file)) {
        $bookings = json_decode(file_get_contents($bookings_file), true) ?? [];
    }

    // Add new booking
    $bookings[] = $booking;

    // Save to file
    if (file_put_contents($bookings_file, json_encode($bookings, JSON_PRETTY_PRINT))) {
        // Store reservation ID in session for payment upload
        $_SESSION['pending_reservation'] = $reservation_id;
        
        $response['success'] = true;
        $response['reservation_id'] = $reservation_id;
        $response['message'] = 'Reservation created successfully. Please proceed with payment.';
    } else {
        $response['message'] = 'Failed to save reservation. Please try again.';
    }
}

echo json_encode($response);
?>
