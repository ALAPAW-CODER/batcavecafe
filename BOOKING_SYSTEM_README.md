# Booking System - The Malvar Bat Cave Cafe

## Overview
Complete booking reservation system with payment integration and automated email receipts.

## Features Implemented

### 1. Reservation Form
- **Reservation Type**: Dropdown (Studying / Event)
- **Personal Information**: Full Name, Email
- **Booking Details**: Number of Persons (1-20), Time (1:00 PM - 1:00 AM), Date
- **Special Requests**: Optional textarea for additional requirements
- **Rate**: ₱100 per hour (displayed clearly)

### 2. Payment System
- **QR Code Display**: Shows QR code for GCash payment (image: `images/qrcode.png`)
- **Proof of Payment Upload**: File upload for payment confirmation
- **Automatic Receipt**: Sends email receipt upon payment submission
- **Reservation Confirmation**: Generates unique reservation ID

### 3. Google Maps Integration
- **3D Street View**: Embedded Google Maps showing Batangas State University location
- **Default View**: 3D perspective as requested

### 4. Design Features
- **Responsive Layout**: Mobile-friendly design
- **Modern UI**: Clean, centered form with proper spacing
- **Bat Cave Theme**: Consistent with website aesthetic
- **Neutral Colors**: Professional color scheme
- **Two-Column Payment**: QR code and upload side-by-side

### 5. Functionality
- **Form Validation**: All required fields validated
- **File Upload**: Image upload with size/type validation
- **Email System**: Automatic receipt generation and sending
- **JSON Storage**: Bookings stored in `bookings.json`
- **Success Modal**: Confirmation popup with reservation details

## Files Created

### 1. `booking.php`
Main booking page with complete UI

### 2. `process_booking.php`
Backend logic for:
- Form validation
- Reservation ID generation
- Data storage in JSON format
- Initial booking creation

### 3. `upload_payment.php`
Payment processing:
- File upload handling
- Payment proof validation
- Booking status update
- Email receipt sending

### 4. `bookings.json`
Stores all reservation data (auto-created)

### 5. `uploads/payments/`
Directory for payment proof images (auto-created)

## Setup Instructions

### 1. Email Configuration
To enable email sending, configure your PHP mail settings or use a library like PHPMailer:

```php
// In upload_payment.php, update the email headers
// For production, consider using PHPMailer or SendGrid
```

### 2. Add QR Code Image
Place your GCash QR code image at:
```
images/qrcode.png
```

### 3. Database (Optional Enhancement)
Current version uses JSON storage. To upgrade to MySQL:
- Create database table for bookings
- Update `process_booking.php` and `upload_payment.php`
- Recommended table structure provided below

## Database Schema (Optional Upgrade)

```sql
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id VARCHAR(50) UNIQUE NOT NULL,
    reservation_type ENUM('Studying', 'Event') NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    persons INT NOT NULL,
    time VARCHAR(10) NOT NULL,
    date DATE NOT NULL,
    special_requests TEXT,
    total_amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('pending', 'submitted', 'confirmed') DEFAULT 'pending',
    proof_of_payment VARCHAR(255),
    status VARCHAR(50) DEFAULT 'pending_payment',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_submitted_at TIMESTAMP NULL
);
```

## User Flow

1. **Fill Reservation Form**
   - Select type, enter details
   - Submit form

2. **Receive Reservation ID**
   - System generates unique ID
   - Payment section appears

3. **Make Payment**
   - Scan QR code
   - Pay via GCash

4. **Upload Proof**
   - Take screenshot of payment
   - Upload image file

5. **Receive Confirmation**
   - Instant confirmation modal
   - Email receipt sent automatically

## Customization

### Pricing
Update hourly rate in `booking.php`:
```javascript
// Line with totalAmount calculation
document.getElementById('totalAmount').textContent = 'NEW_RATE';
```

### Time Slots
Modify time options in `booking.php`:
```php
<option value="TIME">DISPLAY_TEXT</option>
```

### Email Template
Customize email design in `upload_payment.php`:
```php
function sendReceiptEmail($booking) {
    // Modify HTML content here
}
```

## Security Notes

1. **File Upload**: Currently validates file type and size
2. **SQL Injection**: Using JSON storage (no SQL)
3. **XSS Protection**: Using `htmlspecialchars()` on user inputs
4. **Session Management**: Requires user login

## Support

For issues or enhancements, update the respective PHP files or create a support ticket.

## License

Proprietary - The Malvar Bat Cave Cafe
