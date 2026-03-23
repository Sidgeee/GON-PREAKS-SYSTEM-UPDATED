<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
include 'db_connect.php'; 
$date_col = "created_at"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | GonPreaks AutoSupply</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Specialized Dashboard Overrides */
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        
        /* Live Clock Style */
        .live-clock { 
            background: var(--glass-bg); 
            padding: 12px 25px; 
            border-radius: 15px; 
            border: 1px solid var(--glass-border); 
            text-align: right; 
            backdrop-filter: blur(10px);
        }
        #clock-time { font-size: 1.5rem; font-weight: 800; color: var(--accent-blue); display: block; letter-spacing: 1px; }
        #clock-date { font-size: 0.7rem; opacity: 0.5; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600; }

        .dash-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 25px; margin-bottom: 30px; }
        
        .stat-card {
            background: var(--glass-bg);
            padding: 30px; 
            border-radius: 20px; 
            border: 1px solid var(--glass-border);
            position: relative; 
            overflow: hidden; 
            transition: 0.3s ease;
            backdrop-filter: blur(15px);
        }
        .stat-card:hover { transform: translateY(-5px); border-color: var(--accent-blue); box-shadow: var(--shadow); }
        .card-icon { font-size: 3.5rem; opacity: 0.05; position: absolute; right: -10px; bottom: -10px; transform: rotate(-15deg); color: var(--text-color); }
        
        .role-badge { font-size: 0.65rem; background: var(--accent-blue); color: #0f172a; padding: 3px 10px; border-radius: 6px; font-weight: 800; text-transform: uppercase; margin-left: 10px; }
        
        .alert-item { padding: 15px; background: rgba(239, 68, 68, 0.05); border-left: 4px solid var(--accent-red); margin-bottom: 12px; border-radius: 8px; transition: 0.3s; }
        .alert-item:hover { background: rgba(239, 68, 68, 0.1); }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="header-flex">
            <div>
                <h1 style="margin:0; font-size: 2.2rem; font-weight: 800;">Welcome, <?php echo $_SESSION['name']; ?> <span class="role-badge"><?php echo $_SESSION['role']; ?></span></h1>
                <p style="opacity: 0.5; margin: 8px 0 0 0; letter-spacing: 0.5px;">GonPreaks AutoSupply Enterprise System</p>
            </div>
            <div class="live-clock">
                <span id="clock-time">00:00:00</span>
                <span id="clock-date">LOADING DATE...</span>
            </div>
        </div>

        <div class="dash-grid">
            <div class="stat-card">
                <p style="margin:0; opacity: 0.5; font-size: 0.75rem; font-weight: 700; letter-spacing: 1px;">TODAY'S SALES</p>
                <?php $today = date('Y-m-d'); $q = $conn->query("SELECT SUM(total_amount) as total FROM sales WHERE DATE($date_col) = '$today'"); $s = $q->fetch_assoc(); ?>
                <h2 style="color: var(--accent-green); margin: 15px 0; font-size: 2rem;">₱ <?php echo number_format($s['total'] ?? 0, 2); ?></h2>
                <i class="fas fa-coins card-icon"></i>
            </div>

            <div class="stat-card">
                <p style="margin:0; opacity: 0.5; font-size: 0.75rem; font-weight: 700; letter-spacing: 1px;">LOW STOCK ALERTS</p>
                <?php $q = $conn->query("SELECT COUNT(*) as c FROM inventory WHERE stock_quantity <= 5"); $l = $q->fetch_assoc(); ?>
                <h2 style="color: var(--accent-red); margin: 15px 0; font-size: 2rem;"><?php echo $l['c']; ?> Items</h2>
                <i class="fas fa-exclamation-triangle card-icon"></i>
            </div>

            <div class="stat-card">
                <p style="margin:0; opacity: 0.5; font-size: 0.75rem; font-weight: 700; letter-spacing: 1px;">TOTAL CATALOG</p>
                <?php $q = $conn->query("SELECT COUNT(*) as c FROM inventory"); $p = $q->fetch_assoc(); ?>
                <h2 style="color: var(--accent-blue); margin: 15px 0; font-size: 2rem;"><?php echo $p['c']; ?> Parts</h2>
                <i class="fas fa-database card-icon"></i>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1.2fr; gap: 30px;">
            <div class="glass-card">
                <h3 style="margin-top: 0; font-size: 1.1rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 15px;">
                    <i class="fas fa-history" style="color:var(--accent-blue); margin-right: 10px;"></i> Recent Transactions
                </h3>
                <table class="table-glass">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Time</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $res = $conn->query("SELECT * FROM sales ORDER BY $date_col DESC LIMIT 5"); 
                        if ($res->num_rows > 0):
                            while($r = $res->fetch_assoc()): ?>
                            <tr>
                                <td style="font-family: monospace; opacity: 0.5;">#<?php echo $r['sale_id']; ?></td>
                                <td><?php echo date('h:i A', strtotime($r[$date_col])); ?></td>
                                <td style="color:var(--accent-blue); font-weight: 700;">₱<?php echo number_format($r['total_amount'], 2); ?></td>
                            </tr>
                            <?php endwhile; 
                        else: ?>
                            <tr><td colspan="3" style="text-align: center; padding: 40px; opacity: 0.5;">No transactions today.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="glass-card">
                <h3 style="margin-top: 0; font-size: 1.1rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 15px;">
                    <i class="fas fa-bell" style="color:var(--accent-red); margin-right: 10px;"></i> Stock Critical
                </h3>
                <div style="margin-top:20px;">
                    <?php 
                    $al = $conn->query("SELECT part_name, stock_quantity FROM inventory WHERE stock_quantity <= 5 LIMIT 4");
                    if ($al->num_rows > 0):
                        while($a = $al->fetch_assoc()): ?>
                            <div class="alert-item">
                                <small style="opacity:0.5; font-weight: 800; font-size: 0.6rem; text-transform: uppercase;">Needs Restock</small><br>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 5px;">
                                    <strong><?php echo $a['part_name']; ?></strong>
                                    <span style="color: var(--accent-red); font-weight: 800;"><?php echo $a['stock_quantity']; ?> left</span>
                                </div>
                            </div>
                        <?php endwhile; 
                    else: ?>
                        <div style="text-align: center; padding: 40px; opacity: 0.5;">
                            <i class="fas fa-check-circle" style="font-size: 2rem; display: block; margin-bottom: 10px; color: var(--accent-green);"></i>
                            All stock levels healthy.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('clock-time').innerText = now.toLocaleTimeString();
            document.getElementById('clock-date').innerText = now.toLocaleDateString(undefined, options);
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>