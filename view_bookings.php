<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
    header('Location: login.php');
    exit();
}

// Load bookings
$bookings_file = 'bookings.json';
$bookings = [];

if (file_exists($bookings_file)) {
    $bookings = json_decode(file_get_contents($bookings_file), true) ?? [];
}

// Sort by most recent first
usort($bookings, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Management - Admin</title>
    <link rel="icon" type="image/png" href="./images/logoo.png">
    <script src="https://kit.fontawesome.com/8196c78746.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        h1 {
            color: #2c1810;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #d4b896;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .stat-card .number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #d4b896;
        }

        .bookings-table-wrapper {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #2c1810;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr:hover {
            background: #f9fafb;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-confirmed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pending_payment {
            background: #fee2e2;
            color: #991b1b;
        }

        .view-proof {
            background: #d4b896;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.85rem;
            display: inline-block;
        }

        .view-proof:hover {
            background: #c9964c;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #d4b896;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .no-bookings {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        @media (max-width: 768px) {
            .bookings-table-wrapper {
                padding: 15px;
            }

            table {
                font-size: 0.85rem;
            }

            th, td {
                padding: 10px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin-dashboard.php" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>

        <h1><i class="fa-solid fa-calendar-check"></i> Booking Management</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Bookings</h3>
                <div class="number"><?php echo count($bookings); ?></div>
            </div>
            <div class="stat-card">
                <h3>Confirmed</h3>
                <div class="number">
                    <?php echo count(array_filter($bookings, fn($b) => $b['status'] === 'confirmed')); ?>
                </div>
            </div>
            <div class="stat-card">
                <h3>Pending Payment</h3>
                <div class="number">
                    <?php echo count(array_filter($bookings, fn($b) => $b['status'] === 'pending_payment')); ?>
                </div>
            </div>
            <div class="stat-card">
                <h3>Total Revenue</h3>
                <div class="number">
                    ₱<?php echo number_format(array_sum(array_column(array_filter($bookings, fn($b) => $b['status'] === 'confirmed'), 'total_amount')), 2); ?>
                </div>
            </div>
        </div>

        <div class="bookings-table-wrapper">
            <h2 style="margin-bottom: 20px; color: #2c1810;">All Reservations</h2>
            
            <?php if (empty($bookings)): ?>
                <div class="no-bookings">
                    <i class="fa-solid fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 15px;"></i>
                    <p>No bookings yet.</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Reservation ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Hours</th>
                            <th>Persons</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment Proof</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($booking['reservation_id']); ?></strong></td>
                                <td><?php echo htmlspecialchars($booking['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($booking['email']); ?></td>
                                <td><?php echo htmlspecialchars($booking['reservation_type']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($booking['date'])); ?></td>
                                <td><?php echo isset($booking['start_time']) ? date('g:i A', strtotime($booking['start_time'])) : (isset($booking['time']) ? date('g:i A', strtotime($booking['time'])) : '-'); ?></td>
                                <td><?php echo isset($booking['end_time']) ? date('g:i A', strtotime($booking['end_time'])) : '-'; ?></td>
                                <td><?php echo isset($booking['hours']) ? $booking['hours'] . 'h' : '-'; ?></td>
                                <td><?php echo $booking['persons']; ?></td>
                                <td>₱<?php echo number_format($booking['total_amount'], 2); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $booking['status']; ?>">
                                        <?php echo ucfirst(str_replace('_', ' ', $booking['status'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($booking['proof_of_payment'])): ?>
                                        <a href="<?php echo $booking['proof_of_payment']; ?>" target="_blank" class="view-proof">
                                            <i class="fa-solid fa-image"></i> View
                                        </a>
                                    <?php else: ?>
                                        <span style="color: #999;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('M d, Y g:i A', strtotime($booking['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
