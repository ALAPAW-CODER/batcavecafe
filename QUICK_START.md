# 🚀 QUICK START GUIDE - Booking System

## IMMEDIATE SETUP (5 Minutes)

### Step 1: Add Your QR Code
1. Get your GCash QR code image
2. Save it as: `images/qrcode.png`
3. Recommended size: 500x500px or larger

### Step 2: Test the System
1. Open browser: `http://localhost/themalvarcafe-1/booking.php`
2. Fill out the reservation form
3. Click "Continue to Payment"
4. Upload a test image as payment proof
5. Check if confirmation appears

### Step 3: Check Bookings (Admin)
1. Login as admin
2. Visit: `http://localhost/themalvarcafe-1/view_bookings.php`
3. View all reservations and payment proofs

## WHAT'S WORKING NOW

✅ Complete reservation form with all fields
✅ Automatic reservation ID generation
✅ Payment section with QR code display
✅ File upload for payment proof
✅ Success confirmation modal
✅ Booking data storage (bookings.json)
✅ Admin dashboard to view bookings
✅ 3D Google Maps integration
✅ Fully responsive design
✅ Email receipt system (configure for production)

## EMAIL SETUP (For Production)

### Option 1: PHP mail() (Simple)
Already configured in `upload_payment.php`. Just ensure your server has mail configured.

### Option 2: PHPMailer (Recommended)
```bash
composer require phpmailer/phpmailer
```

Then update `upload_payment.php`:
```php
use PHPMailer\PHPMailer\PHPMailer;

function sendReceiptEmail($booking) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@gmail.com';
    $mail->Password = 'your-app-password';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    
    $mail->setFrom('noreply@malvarbatcave.com', 'Malvar Bat Cave Cafe');
    $mail->addAddress($booking['email']);
    $mail->isHTML(true);
    $mail->Subject = 'Reservation Confirmation';
    $mail->Body = /* your HTML template */;
    
    $mail->send();
}
```

## FILE LOCATIONS

📁 **Main Files**
- `booking.php` - Customer booking page
- `view_bookings.php` - Admin view (login required)

📁 **Backend**
- `process_booking.php` - Creates reservation
- `upload_payment.php` - Handles payment proof

📁 **Data Storage**
- `bookings.json` - All reservation data
- `uploads/payments/` - Payment proof images

## TROUBLESHOOTING

### Issue: Form doesn't submit
- Check browser console for JavaScript errors
- Verify all required fields are filled
- Ensure you're logged in

### Issue: File upload fails
- Check `uploads/payments/` folder exists
- Verify folder permissions (777 on Linux)
- Ensure file is under 5MB and is an image

### Issue: Email not sending
- Check PHP mail configuration
- Review server mail logs
- Consider using PHPMailer

### Issue: Bookings not saving
- Verify `bookings.json` file exists
- Check file permissions (writable)
- Review PHP error logs

## CUSTOMIZATION

### Change Pricing
Edit `booking.php` line with `totalAmount`:
```javascript
document.getElementById('totalAmount').textContent = '200'; // New rate
```

### Add Time Slots
Edit `booking.php`, add options:
```html
<option value="02:00">2:00 AM</option>
```

### Modify Email Template
Edit `upload_payment.php`, function `sendReceiptEmail()`

## TESTING CHECKLIST

- [ ] QR code displays correctly
- [ ] All form fields validate properly
- [ ] Reservation ID generates
- [ ] Payment section appears after form submit
- [ ] File upload works
- [ ] Success modal shows
- [ ] Booking saves to bookings.json
- [ ] Admin can view bookings
- [ ] Google Maps loads in 3D
- [ ] Mobile responsive works

## SUPPORT FILES

📄 `BOOKING_SYSTEM_README.md` - Complete documentation
📄 `IMPLEMENTATION_SUMMARY.md` - Feature checklist
📄 `booking_backup.php` - Original file backup

## LIVE DEPLOYMENT

When moving to production:
1. Update email configuration
2. Change file paths if needed
3. Set proper file permissions
4. Configure SSL for secure uploads
5. Consider MySQL instead of JSON
6. Enable error logging
7. Test all features thoroughly

---

**You're all set!** 🎉

The booking system is ready to use. Just add your QR code image and start taking reservations!
