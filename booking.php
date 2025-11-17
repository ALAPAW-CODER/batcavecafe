<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['isLoggedIn']) && !isset($_SESSION['isAdmin'])) {
    header('Location: login.php');
    exit();
}

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - The Malvar Bat Cave Cafe</title>
    <link rel="icon" type="image/png" href="./images/logoo.png">
    <link rel="stylesheet" href="coffee-landing.css?v=<?php echo time(); ?>">
    <script src="https://kit.fontawesome.com/8196c78746.js" crossorigin="anonymous"></script>
    <script src="common.js" defer></script>
    <style>
        /* Booking Page Styles */
        .booking-page {
            min-height: 100vh;
            background: linear-gradient(180deg, rgba(10, 8, 6, 0.98) 0%, rgba(15, 12, 9, 0.98) 50%, rgba(12, 9, 7, 0.98) 100%);
            padding: 100px 20px 50px;
        }

        .booking-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .booking-header {
            text-align: center;
            margin-bottom: 40px;
            color: #e8d5c4;
        }

        .booking-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }

        .booking-header p {
            font-size: 1.1rem;
            color: #d4c4b0;
        }

        /* Form Container */
        .booking-form-wrapper {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.5);
            margin-bottom: 30px;
        }

        .booking-form-wrapper h2 {
            color: #2c1810;
            margin-bottom: 30px;
            font-size: 1.8rem;
            border-bottom: 3px solid #d4b896;
            padding-bottom: 15px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            color: #2c1810;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #d4b896;
            box-shadow: 0 0 0 3px rgba(212, 184, 150, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Price Display */
        .price-display {
            background: #f9fafb;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #d4b896;
        }

        .price-display p {
            margin: 5px 0;
            color: #2c1810;
        }

        .price-display .total-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #d4b896;
            margin-top: 10px;
        }

        /* Payment Section */
        .payment-section {
            background: #f9fafb;
            padding: 30px;
            border-radius: 15px;
            margin-top: 30px;
            display: none;
        }

        .payment-section.active {
            display: block;
        }

        .payment-section h3 {
            color: #2c1810;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .qr-payment-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: start;
        }

        .qr-code-box {
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .qr-code-box h4 {
            margin-bottom: 15px;
            color: #2c1810;
        }

        .qr-code-box img {
            max-width: 250px;
            width: 100%;
            height: auto;
            border: 3px solid #d4b896;
            border-radius: 10px;
        }

        .upload-proof-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .upload-proof-box h4 {
            margin-bottom: 15px;
            color: #2c1810;
        }

        .file-upload-wrapper {
            position: relative;
            margin: 20px 0;
        }

        .file-upload-wrapper input[type="file"] {
            display: none;
        }

        .file-upload-label {
            display: block;
            padding: 15px 20px;
            background: #d4b896;
            color: white;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .file-upload-label:hover {
            background: #c9964c;
            transform: translateY(-2px);
        }

        .file-name-display {
            margin-top: 10px;
            color: #2c1810;
            font-size: 0.9rem;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #d4b896 0%, #c9964c 100%);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(212, 184, 150, 0.3);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Map Section */
        .map-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.5);
            margin-top: 30px;
        }

        .map-section h3 {
            color: #2c1810;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .map-section iframe {
            width: 100%;
            height: 450px;
            border: none;
            border-radius: 15px;
        }

        /* Success Modal */
        .success-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 10000;
            justify-content: center;
            align-items: center;
        }

        .success-modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .modal-content .success-icon {
            font-size: 4rem;
            color: #4caf50;
            margin-bottom: 20px;
        }

        .modal-content h2 {
            color: #2c1810;
            margin-bottom: 15px;
        }

        .modal-content p {
            color: #666;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .modal-content .reservation-id {
            background: #f9fafb;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            font-size: 1.2rem;
            font-weight: 700;
            color: #d4b896;
        }

        .modal-content .btn-close {
            background: #d4b896;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .booking-header h1 {
                font-size: 2rem;
            }

            .booking-form-wrapper {
                padding: 25px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .qr-payment-container {
                grid-template-columns: 1fr;
            }

            .map-section iframe {
                height: 350px;
            }
        }

        @media (max-width: 480px) {
            .booking-page {
                padding: 80px 15px 30px;
            }

            .booking-header h1 {
                font-size: 1.5rem;
            }

            .booking-form-wrapper {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header (copy from existing page) -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="images/logoo.png" alt="The Malvar Bat Cave Cafe Logo">
                <span>The Malvar Bat <span class="tique">Cave Cafe</span></span>
            </div>
            <ul class="nav-links">
                <li><a href="coffee-landing.php">Home</a></li>
                <li><a href="special-menu.php">Menu</a></li>
                <li><a href="booking.php" class="active">Booking</a></li>
            </ul>
            <div class="nav-actions">
                <div class="cart-dropdown">
                    <button class="cart-btn" id="cartBtn">
                        <i class="fa-solid fa-cart-shopping fa-xl"></i>
                        <span class="cart-count" id="cartCount">0</span>
                    </button>
                </div>
                <div class="profile-dropdown">
                    <button class="profile-btn" id="profileBtn">
                        <i class="fa-solid fa-user fa-xl"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Booking Page Content -->
    <div class="booking-page">
        <div class="booking-container">
            <div class="booking-header">
                <h1>Reserve Your Spot</h1>
                <p>Book your table and enjoy the perfect study or event space</p>
            </div>

            <!-- Booking Form -->
            <div class="booking-form-wrapper">
                <h2>Reservation Details</h2>
                <form id="bookingForm">
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="reservationType">Select Reservation Type *</label>
                            <select id="reservationType" name="reservationType" required>
                                <option value="">Choose type...</option>
                                <option value="Studying">Studying</option>
                                <option value="Event">Event</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="fullName">Full Name *</label>
                            <input type="text" id="fullName" name="fullName" required placeholder="Juan Dela Cruz">
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required placeholder="juan@example.com">
                        </div>

                        <div class="form-group">
                            <label for="persons">Number of Persons *</label>
                            <select id="persons" name="persons" required>
                                <option value="">Select...</option>
                                <?php for($i = 1; $i <= 20; $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?> Person<?php echo $i > 1 ? 's' : ''; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date">Date of Reservation *</label>
                            <input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div class="form-group">
                            <label for="startTime">Start Time *</label>
                            <select id="startTime" name="startTime" required>
                                <option value="">Choose start time...</option>
                                <option value="13:00">1:00 PM</option>
                                <option value="14:00">2:00 PM</option>
                                <option value="15:00">3:00 PM</option>
                                <option value="16:00">4:00 PM</option>
                                <option value="17:00">5:00 PM</option>
                                <option value="18:00">6:00 PM</option>
                                <option value="19:00">7:00 PM</option>
                                <option value="20:00">8:00 PM</option>
                                <option value="21:00">9:00 PM</option>
                                <option value="22:00">10:00 PM</option>
                                <option value="23:00">11:00 PM</option>
                                <option value="00:00">12:00 AM</option>
                                <option value="01:00">1:00 AM</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="endTime">End Time *</label>
                            <select id="endTime" name="endTime" required>
                                <option value="">Choose end time...</option>
                                <option value="14:00">2:00 PM</option>
                                <option value="15:00">3:00 PM</option>
                                <option value="16:00">4:00 PM</option>
                                <option value="17:00">5:00 PM</option>
                                <option value="18:00">6:00 PM</option>
                                <option value="19:00">7:00 PM</option>
                                <option value="20:00">8:00 PM</option>
                                <option value="21:00">9:00 PM</option>
                                <option value="22:00">10:00 PM</option>
                                <option value="23:00">11:00 PM</option>
                                <option value="00:00">12:00 AM</option>
                                <option value="01:00">1:00 AM</option>
                                <option value="02:00">2:00 AM</option>
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label for="specialRequests">Special Requests (Optional)</label>
                            <textarea id="specialRequests" name="specialRequests" placeholder="Any special requirements or preferences..."></textarea>
                        </div>
                    </div>

                    <!-- Price Display -->
                    <div class="price-display">
                        <p><strong>Rate:</strong> ₱100 per hour</p>
                        <p><strong>Duration:</strong> <span id="duration">-</span> hour(s)</p>
                        <p class="total-price">Total: ₱<span id="totalAmount">0</span></p>
                    </div>

                    <button type="submit" class="btn-primary" id="submitBooking">Continue to Payment</button>
                </form>

                <!-- Payment Section (Initially Hidden) -->
                <div class="payment-section" id="paymentSection">
                    <h3>Complete Your Reservation</h3>
                    <div class="qr-payment-container">
                        <div class="qr-code-box">
                            <h4>Scan QR Code to Pay</h4>
                            <img src="images/qrcode.png" alt="GCash QR Code" id="qrCodeImage">
                            <p style="margin-top: 15px; color: #666; font-size: 0.9rem;">
                                Scan this QR code using GCash to complete payment
                            </p>
                        </div>

                        <div class="upload-proof-box">
                            <h4>Upload Proof of Payment</h4>
                            <p style="color: #666; margin-bottom: 15px;">
                                Please upload a screenshot of your payment confirmation
                            </p>
                            
                            <div class="file-upload-wrapper">
                                <input type="file" id="proofOfPayment" name="proofOfPayment" accept="image/*">
                                <label for="proofOfPayment" class="file-upload-label">
                                    <i class="fa-solid fa-cloud-arrow-up"></i> Choose File
                                </label>
                                <div class="file-name-display" id="fileName">No file chosen</div>
                            </div>

                            <div id="reservationIdDisplay" style="background: #f9fafb; padding: 15px; border-radius: 10px; margin: 15px 0;">
                                <p style="margin: 0; color: #666; font-size: 0.9rem;">Reservation ID:</p>
                                <p style="margin: 5px 0 0; font-weight: 700; color: #d4b896; font-size: 1.1rem;" id="resId">-</p>
                            </div>

                            <button type="button" class="btn-primary" id="submitPayment" disabled>
                                Submit Payment Proof
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Google Maps Section -->
            <div class="map-section">
                <h3><i class="fa-solid fa-location-dot"></i> Find Us Here</h3>
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!4v1731740000000!6m8!1m7!1sCAoSLEFGMVFpcE1PWjNkdm5HMUJZb2Z1MHRmTUhsRGdYNzBnb1FjOEJqVkVZSWpI!2m2!1d14.0449448!2d121.1559532!3f0!4f0!5f0.7820865974627469"
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="success-modal" id="successModal">
        <div class="modal-content">
            <div class="success-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h2>Reservation Confirmed!</h2>
            <p>Thank you for your reservation. A confirmation receipt has been sent to your email.</p>
            <div class="reservation-id" id="modalReservationId">TMBC-XXXXXX</div>
            <p style="font-size: 0.9rem; color: #888;">
                Please check your email for complete details.
            </p>
            <button class="btn-close" onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        let currentReservationId = '';

        // Handle form submission
        document.getElementById('bookingForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('process_booking.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    currentReservationId = result.reservation_id;
                    document.getElementById('resId').textContent = currentReservationId;
                    
                    // Show payment section
                    document.getElementById('paymentSection').classList.add('active');
                    document.getElementById('submitBooking').disabled = true;
                    document.getElementById('submitBooking').textContent = 'Awaiting Payment';
                    
                    // Scroll to payment section
                    document.getElementById('paymentSection').scrollIntoView({ behavior: 'smooth' });
                } else {
                    alert(result.message);
                }
            } catch (error) {
                alert('An error occurred. Please try again.');
                console.error('Error:', error);
            }
        });

        // Handle file selection
        document.getElementById('proofOfPayment').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
            document.getElementById('fileName').textContent = fileName;
            document.getElementById('submitPayment').disabled = !this.files[0];
        });

        // Handle payment submission
        document.getElementById('submitPayment').addEventListener('click', async function() {
            const fileInput = document.getElementById('proofOfPayment');
            
            if (!fileInput.files[0]) {
                alert('Please select a proof of payment file');
                return;
            }
            
            const formData = new FormData();
            formData.append('proofOfPayment', fileInput.files[0]);
            formData.append('reservation_id', currentReservationId);
            
            this.disabled = true;
            this.textContent = 'Uploading...';
            
            try {
                const response = await fetch('upload_payment.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    document.getElementById('modalReservationId').textContent = currentReservationId;
                    document.getElementById('successModal').classList.add('active');
                } else {
                    alert(result.message);
                    this.disabled = false;
                    this.textContent = 'Submit Payment Proof';
                }
            } catch (error) {
                alert('An error occurred. Please try again.');
                console.error('Error:', error);
                this.disabled = false;
                this.textContent = 'Submit Payment Proof';
            }
        });

        function closeModal() {
            document.getElementById('successModal').classList.remove('active');
            window.location.href = 'coffee-landing.php';
        }

        // Calculate duration and total price
        function calculatePrice() {
            const startTime = document.getElementById('startTime').value;
            const endTime = document.getElementById('endTime').value;
            
            if (startTime && endTime) {
                const start = parseInt(startTime.split(':')[0]);
                const end = parseInt(endTime.split(':')[0]);
                
                let hours;
                if (end <= start) {
                    // Crossing midnight (e.g., 11 PM to 1 AM)
                    hours = (24 - start) + end;
                } else {
                    hours = end - start;
                }
                
                if (hours <= 0) {
                    document.getElementById('duration').textContent = '-';
                    document.getElementById('totalAmount').textContent = '0';
                    alert('End time must be after start time');
                    return;
                }
                
                const total = hours * 100;
                document.getElementById('duration').textContent = hours;
                document.getElementById('totalAmount').textContent = total;
            } else {
                document.getElementById('duration').textContent = '-';
                document.getElementById('totalAmount').textContent = '0';
            }
        }

        // Add event listeners for time calculation
        document.getElementById('startTime').addEventListener('change', calculatePrice);
        document.getElementById('endTime').addEventListener('change', calculatePrice);
    </script>
</body>
</html>
