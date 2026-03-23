<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
include 'db_connect.php'; 

// Role Check: Only Admin, Driver, and Restocker can manage deliveries
if (!in_array($_SESSION['role'], ['Admin', 'Driver', 'Restocker'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deliveries | GonPreaks AutoSupply</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .delivery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px; margin-top: 20px; }
        .delivery-card { border-top: 4px solid #38bdf8; transition: 0.3s; }
        .delivery-card:hover { transform: scale(1.02); }
        
        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase; }
        .status-pending { background: rgba(251, 191, 36, 0.1); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.2); }
        .status-shipping { background: rgba(56, 189, 248, 0.1); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.2); }
        .status-delivered { background: rgba(34, 197, 94, 0.1); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.2); }

        .info-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; opacity: 0.8; font-size: 0.9rem; }
        .info-row i { width: 20px; color: #38bdf8; }
        
        .update-btn { 
            width: 100%; padding: 10px; background: rgba(56, 189, 248, 0.1); 
            border: 1px solid #38bdf8; color: #38bdf8; border-radius: 8px; 
            cursor: pointer; margin-top: 15px; font-weight: bold; transition: 0.3s;
        }
        .update-btn:hover { background: #38bdf8; color: #0f172a; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div style="padding: 20px; text-align: center;">
            <h2 style="color: #38bdf8; margin-bottom: 5px;">GONPREAKS</h2>
            <div style="font-size: 0.75rem; color: #38bdf8; opacity: 0.8;"><?php echo strtoupper($_SESSION['role']); ?></div>
        </div>
        <nav>
            <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="deliveries.php" class="active"><i class="fas fa-truck"></i> Deliveries</a>
            <a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a>
            <a href="logout.php" style="color: #ef4444; margin-top: 20px;"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </div>

    <div style="margin-left: 260px; padding: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1 style="margin:0;">Active Deliveries</h1>
                <p style="opacity:0.5;">Manage outbound logistics and supplier pickups.</p>
            </div>
            <?php if($_SESSION['role'] == 'Admin'): ?>
                <button class="btn-pos" style="width:auto; padding: 10px 20px;"><i class="fas fa-plus"></i> Assign New Delivery</button>
            <?php endif; ?>
        </div>

        <div class="delivery-grid">
            <?php
            // Using the deliveries table we planned earlier
            $sql = "SELECT * FROM deliveries ORDER BY CASE WHEN delivery_status = 'Delivered' THEN 2 ELSE 1 END, delivery_id DESC";
            $res = $conn->query($sql);

            if($res && $res->num_rows > 0):
                while($d = $res->fetch_assoc()):
                    $status_class = "status-" . strtolower($d['delivery_status']);
            ?>
                <div class="glass-card delivery-card">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <span style="font-weight: bold; font-size: 1.1rem;">#TRK-<?php echo str_pad($d['delivery_id'], 5, '0', STR_PAD_LEFT); ?></span>
                        <span class="status-badge <?php echo $status_class; ?>"><?php echo $d['delivery_status']; ?></span>
                    </div>

                    <div class="info-row">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo $d['customer_address']; ?></span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-user"></i>
                        <span><?php echo $d['customer_name'] ?? 'Supplier Pickup'; ?></span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-clock"></i>
                        <span>Expected: <?php echo date('M d, h:i A', strtotime($d['expected_delivery_date'])); ?></span>
                    </div>

                    <?php if($d['delivery_status'] != 'Delivered'): ?>
                        <form action="update_delivery.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $d['delivery_id']; ?>">
                            <select name="status" class="update-btn" onchange="this.form.submit()" style="appearance: none; text-align: center;">
                                <option value="">Update Progress...</option>
                                <option value="Pending">Pending</option>
                                <option value="Shipping">Out for Delivery</option>
                                <option value="Delivered">Mark as Delivered</option>
                            </select>
                        </form>
                    <?php else: ?>
                        <div style="text-align: center; padding: 10px; color: #22c55e; font-size: 0.8rem; border: 1px dashed rgba(34,197,94,0.3); border-radius: 8px; margin-top: 15px;">
                            <i class="fas fa-check-circle"></i> Completed
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile; else: ?>
                <div class="glass-card" style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                    <i class="fas fa-truck-loading" style="font-size: 3rem; opacity: 0.2; margin-bottom: 20px;"></i>
                    <h3>No Active Deliveries</h3>
                    <p style="opacity: 0.5;">Routes will appear here once assigned.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>