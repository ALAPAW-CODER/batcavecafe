# 📊 BOOKING SYSTEM - USER FLOW DIAGRAM

## CUSTOMER JOURNEY

```
┌─────────────────────────────────────────────────────────────┐
│                    START: Landing Page                       │
│               (coffee-landing.php)                           │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       │ Click "Booking" in menu
                       ↓
┌─────────────────────────────────────────────────────────────┐
│                  STEP 1: Login Check                         │
│                  (Session validation)                        │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       │ If not logged in → redirect to login.php
                       │ If logged in ↓
                       ↓
┌─────────────────────────────────────────────────────────────┐
│              STEP 2: Booking Form Page                       │
│                   (booking.php)                              │
│                                                              │
│  ┌─────────────────────────────────────────────────┐        │
│  │  Reservation Form                               │        │
│  │  • Select Type (Studying/Event)                 │        │
│  │  • Full Name                                    │        │
│  │  • Email                                        │        │
│  │  • Number of Persons (1-20)                     │        │
│  │  • Time (1PM - 1AM)                             │        │
│  │  • Date                                         │        │
│  │  • Special Requests (optional)                  │        │
│  │  • Price Display: ₱100/hour                     │        │
│  └─────────────────────────────────────────────────┘        │
│                                                              │
│           [Continue to Payment Button]                      │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       │ Form submitted via AJAX
                       ↓
┌─────────────────────────────────────────────────────────────┐
│           STEP 3: Process Booking Backend                    │
│              (process_booking.php)                           │
│                                                              │
│  • Validate all fields                                      │
│  • Generate unique Reservation ID                           │
│    Format: TMBC-YYYYMMDD-XXXXXX                            │
│  • Calculate total amount                                   │
│  • Save to bookings.json with status: 'pending_payment'    │
│  • Return reservation ID to frontend                        │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       │ Success response received
                       ↓
┌─────────────────────────────────────────────────────────────┐
│        STEP 4: Payment Section Appears                       │
│           (booking.php - payment section)                    │
│                                                              │
│  ┌───────────────────┐    ┌─────────────────────────┐      │
│  │   QR Code Box     │    │  Upload Proof Box       │      │
│  │                   │    │                         │      │
│  │  [QR Code Image]  │    │  Reservation ID:        │      │
│  │                   │    │  TMBC-XXXXXX            │      │
│  │  Scan to Pay      │    │                         │      │
│  │  via GCash        │    │  [Choose File Button]   │      │
│  │                   │    │                         │      │
│  │                   │    │  [Submit Payment Proof] │      │
│  └───────────────────┘    └─────────────────────────┘      │
│                                                              │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       │ Customer scans QR → Pays via GCash
                       │ Takes screenshot → Uploads file
                       ↓
┌─────────────────────────────────────────────────────────────┐
│         STEP 5: Upload Payment Proof                         │
│            (upload_payment.php)                              │
│                                                              │
│  • Validate file (type, size)                               │
│  • Save to uploads/payments/                                │
│  • Find booking in bookings.json                            │
│  • Update status to 'confirmed'                             │
│  • Update payment_status to 'submitted'                     │
│  • Generate email receipt                                   │
│  • Send email to customer                                   │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       │ Success
                       ↓
┌─────────────────────────────────────────────────────────────┐
│           STEP 6: Success Modal Appears                      │
│             (booking.php - modal)                            │
│                                                              │
│          ✓ Reservation Confirmed!                           │
│                                                              │
│      Your Reservation ID: TMBC-XXXXXX                        │
│                                                              │
│   A confirmation receipt has been sent to your email        │
│                                                              │
│              [Close Button]                                  │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       │ Click close
                       ↓
┌─────────────────────────────────────────────────────────────┐
│         STEP 7: Redirect to Landing Page                     │
│              (coffee-landing.php)                            │
│                                                              │
│           Customer receives email receipt                   │
└─────────────────────────────────────────────────────────────┘
```

## ADMIN JOURNEY

```
┌─────────────────────────────────────────────────────────────┐
│               Admin Dashboard Login                          │
│               (admin-dashboard.php)                          │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       │ Click "View Bookings"
                       ↓
┌─────────────────────────────────────────────────────────────┐
│            Booking Management Page                           │
│              (view_bookings.php)                             │
│                                                              │
│  ┌───────────────────────────────────────────┐              │
│  │  Statistics Dashboard                     │              │
│  │  • Total Bookings                         │              │
│  │  • Confirmed Bookings                     │              │
│  │  • Pending Payment                        │              │
│  │  • Total Revenue                          │              │
│  └───────────────────────────────────────────┘              │
│                                                              │
│  ┌───────────────────────────────────────────┐              │
│  │  All Reservations Table                   │              │
│  │  • Reservation ID                         │              │
│  │  • Customer Name                          │              │
│  │  • Email                                  │              │
│  │  • Type (Studying/Event)                  │              │
│  │  • Date & Time                            │              │
│  │  • Number of Persons                      │              │
│  │  • Amount                                 │              │
│  │  • Status Badge                           │              │
│  │  • View Payment Proof (link)              │              │
│  │  • Created timestamp                      │              │
│  └───────────────────────────────────────────┘              │
└─────────────────────────────────────────────────────────────┘
```

## DATA FLOW

```
Customer Form Input
       ↓
[Validation Layer]
       ↓
JSON Storage (bookings.json)
       ↓
    ┌─────────────────┐
    │  Booking Object │
    │  {              │
    │   id: "...",    │
    │   name: "...",  │
    │   email: "...", │
    │   status: "..." │
    │   ...           │
    │  }              │
    └─────────────────┘
       ↓
Email Service → Customer Inbox
       ↓
Admin Dashboard → View All
```

## FILE INTERACTIONS

```
booking.php
    ↓ (AJAX POST)
process_booking.php
    ↓ (Write)
bookings.json
    ↑ (Read)
view_bookings.php


booking.php
    ↓ (Upload)
upload_payment.php
    ↓ (Save file)
uploads/payments/
    ↓ (Update)
bookings.json
    ↓ (Send)
Email → Customer
```

## STATUS PROGRESSION

```
Form Submitted
      ↓
pending_payment
      ↓
[Customer pays & uploads proof]
      ↓
confirmed
      ↓
[Admin can mark as completed]
      ↓
completed (future feature)
```

---

This visual guide shows exactly how data flows through the booking system from customer input to final confirmation.
