<?php
// sidebar.php
if (!isset($conn)) {
    include 'db_connect.php';
}

// Fetch top 5 active suppliers for the sidebar preview
$sidebar_query = "SELECT shop_name, supplier_id FROM suppliers ORDER BY shop_name ASC LIMIT 5";
$sidebar_result = mysqli_query($conn, $sidebar_query);

// Helper to check current supplier ID for active state
$current_supplier_id = $_GET['id'] ?? null;
?>

<style>
    /* Essential Sidebar Structure */
    .sidebar {
    width: 280px;
    height: 94vh;
    margin: 3vh 0 3vh 20px;
    background: var(--sidebar-bg);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: 2px;
    display: flex;
    flex-direction: column;
    /* REMOVE position: fixed; */
    /* REMOVE z-index: 1000; */
    flex-shrink: 0; 
}

    .sidebar-header {
        padding: 40px 25px;
        text-align: center;
    }

    .brand-name {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 900;
        letter-spacing: 2px;
        color: #fff;
    }

    .brand-role {
        font-size: 0.6rem;
        letter-spacing: 3px;
        color: var(--accent-blue);
        margin-top: 5px;
        opacity: 0.8;
    }

    /* Navigation Items */
    .nav-item {
        display: flex;
        align-items: center;
        padding: 14px 25px;
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: all 0.3s;
        font-size: 0.9rem;
        font-weight: 500;
        gap: 15px;
    }

    .nav-item i {
        width: 20px;
        font-size: 1.1rem;
    }

    .nav-item:hover, .nav-item.active {
        color: #fff;
        background: rgba(56, 189, 248, 0.1);
    }

    .nav-item.active {
        color: var(--accent-blue);
        border-right: 3px solid var(--accent-blue);
    }

    /* Sidebar Logout Styling */
    .logout-box {
        margin-top: auto;
        padding: 20px 15px;
    }
    
    .logout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 12px;
        background: rgba(251, 113, 133, 0.1);
        border: 1px solid rgba(251, 113, 133, 0.2);
        color: #fb7185 !important;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        transition: 0.3s;
    }

    .logout-btn:hover {
        background: rgba(251, 113, 133, 0.2);
        transform: translateY(-2px);
    }

    /* Partner Sub-menu Styling */
    .sidebar-divider {
        height: 1px;
        background: rgba(255,255,255,0.1);
        margin: 15px 25px;
    }

    .section-label {
        font-size: 0.65rem;
        font-weight: 800;
        color: rgba(255,255,255,0.3);
        margin: 20px 0 10px 25px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .sub-nav-item {
        display: flex;
        align-items: center;
        padding: 8px 25px 8px 35px;
        color: rgba(255,255,255,0.4);
        text-decoration: none;
        font-size: 0.75rem;
        transition: 0.3s;
    }

    .sub-nav-item i {
        font-size: 0.4rem;
        margin-right: 12px;
    }

    .sub-nav-item:hover, .sub-nav-item.active {
        color: var(--accent-blue);
        padding-left: 40px;
    }
    
    .sub-nav-item.active {
        font-weight: 700;
    }
</style>

<div class="sidebar">
    <div class="sidebar-header">
        <h1 class="brand-name">GONPREAKS</h1>
        <div class="brand-role">
            <?php echo strtoupper($_SESSION['role'] ?? 'ADMIN'); ?>
        </div>
    </div>
    
    <nav>
        <a href="dashboard.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
            <i class="fas fa-th-large"></i> 
            <span>Dashboard</span>
        </a>
        
        <a href="pos.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'pos.php') ? 'active' : ''; ?>">
            <i class="fas fa-cash-register"></i> 
            <span>POS System</span>
        </a>

        <a href="inventory.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'inventory.php') ? 'active' : ''; ?>">
            <i class="fas fa-boxes"></i> 
            <span>Inventory</span>
        </a>

        <div class="sidebar-divider"></div>
        <div class="section-label">Partners</div>

        <a href="suppliers.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'suppliers.php') ? 'active' : ''; ?>">
            <i class="fas fa-truck-ramp-box"></i> 
            <span>Suppliers</span>
        </a>

        <div class="sub-menu">
            <?php if ($sidebar_result): ?>
                <?php while($side_row = mysqli_fetch_assoc($sidebar_result)): ?>
                    <?php $active_sub = ($current_supplier_id == $side_row['supplier_id']) ? 'active' : ''; ?>
                    <a href="supplier_products.php?id=<?php echo $side_row['supplier_id']; ?>" class="sub-nav-item <?php echo $active_sub; ?>">
                        <i class="fas fa-circle"></i>
                        <span><?php echo htmlspecialchars($side_row['shop_name']); ?></span>
                    </a>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </nav>

    <div class="logout-box">
        <a href="logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> 
            <span>Logout Session</span>
        </a>
    </div>
</div>