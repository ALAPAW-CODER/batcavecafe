<?php
session_start();

$response = [
    'success' => false,
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['proofOfPayment'])) {
    $reservation_id = $_POST['reservation_id'] ?? '';
    
    if (empty($reservation_id)) {
        $response['message'] = 'Invalid reservation ID.';
        echo json_encode($response);
        exit();
    }

    // Validate file upload
    $file = $_FILES['proofOfPayment'];
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $response['message'] = 'Error uploading file.';
        echo json_encode($response);
        exit();
    }

    if (!in_array($file['type'], $allowed_types)) {
        $response['message'] = 'Only JPG, PNG, and GIF files are allowed.';
        echo json_encode($response);
        exit();
    }

    if ($file['size'] > $max_size) {
        $response['message'] = 'File size must be less than 5MB.';
        echo json_encode($response);
        exit();
    }

    // Create uploads directory if it doesn't exist
    $upload_dir = 'uploads/payments/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Generate unique filename
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_filename = $reservation_id . '_' . time() . '.' . $file_extension;
    $upload_path = $upload_dir . $new_filename;

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        // Update booking in database
        $bookings_file = 'bookings.json';
        $bookings = [];
        
        if (file_exists($bookings_file)) {
            $bookings = json_decode(file_get_contents($bookings_file), true) ?? [];
        }

        // Find and update the booking
        $booking_found = false;
        foreach ($bookings as &$booking) {
            if ($booking['reservation_id'] === $reservation_id) {
                $booking['proof_of_payment'] = $upload_path;
                $booking['payment_status'] = 'submitted';
                $booking['status'] = 'confirmed';
                $booking['payment_submitted_at'] = date('Y-m-d H:i:s');
                $booking_found = true;
                
                // Send email with receipt
                $email_sent = sendReceiptEmail($booking);
                
                break;
            }
        }

        if ($booking_found && file_put_contents($bookings_file, json_encode($bookings, JSON_PRETTY_PRINT))) {
            $response['success'] = true;
            $response['message'] = 'Payment proof uploaded successfully! Receipt sent to your email.';
        } else {
            $response['message'] = 'Failed to update reservation.';
        }
    } else {
        $response['message'] = 'Failed to upload file.';
    }
}

echo json_encode($response);

function sendReceiptEmail($booking) {
    $to = $booking['email'];
    $subject = 'Reservation Confirmation - The Malvar Bat Cave Cafe';
    
    $message = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
            .header { background: #2c1810; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; }
            .details { background: #f9f9f9; padding: 15px; margin: 20px 0; }
            .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>The Malvar Bat Cave Cafe</h1>
                <p>Reservation Confirmation</p>
            </div>
            <div class='content'>
                <h2>Thank you for your reservation!</h2>
                <p>Dear {$booking['full_name']},</p>
                <p>Your reservation has been confirmed. Here are your booking details:</p>
                
                <div class='details'>
                    <p><strong>Reservation ID:</strong> {$booking['reservation_id']}</p>
                    <p><strong>Type:</strong> {$booking['reservation_type']}</p>
                    <p><strong>Date:</strong> {$booking['date']}</p>
                    <p><strong>Start Time:</strong> " . date('g:i A', strtotime($booking['start_time'])) . "</p>
                    <p><strong>End Time:</strong> " . date('g:i A', strtotime($booking['end_time'])) . "</p>
                    <p><strong>Duration:</strong> {$booking['hours']} hour(s)</p>
                    <p><strong>Number of Persons:</strong> {$booking['persons']}</p>
                    <p><strong>Total Amount:</strong> ₱" . number_format($booking['total_amount'], 2) . "</p>
                    <p><strong>Status:</strong> Confirmed</p>
                </div>
                
                <p>We look forward to serving you!</p>
                <p>If you have any questions, please don't hesitate to contact us.</p>
            </div>
            <div class='footer'>
                <p>The Malvar Bat Cave Cafe - Your sanctuary for exceptional brews and warm connections</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: The Malvar Bat Cave Cafe <noreply@malvarbatcave.com>" . "\r\n";
    
    return mail($to, $subject, $message, $headers);
}
?>
