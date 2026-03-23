<?php
session_start();
include 'db_connect.php'; 
mysqli_set_charset($conn, "utf8"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Line | GonPreaks AutoSupply</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        :root { --accent: #00d2ff; --bg: #0b0f1a; --panel: rgba(255, 255, 255, 0.03); --border: rgba(255, 255, 255, 0.08); --glass: rgba(255, 255, 255, 0.05); }
        body { margin: 0; overflow: hidden; height: 100vh; background: var(--bg); font-family: 'Inter', sans-serif; color: #e1e1e1; }
        .main-content { margin-left: 260px; padding: 25px; display: flex; gap: 20px; height: 100vh; width: calc(100% - 260px); box-sizing: border-box; }
        .terminal-panel { flex: 2.5; display: flex; flex-direction: column; background: var(--panel); backdrop-filter: blur(20px); border: 1px solid var(--border); border-radius: 24px; padding: 30px; min-width: 0; }
        
        .search-input { width: 100%; padding: 15px 45px; background: var(--glass); border: 1px solid var(--border); border-radius: 12px; color: white; outline: none; margin-bottom: 20px; box-sizing: border-box; }
        .nav-section { margin-bottom: 15px; }
        .nav-label { font-size: 0.65rem; color: #6a7282; text-transform: uppercase; margin-bottom: 8px; display: block; }
        .tab-group { display: flex; gap: 8px; flex-wrap: wrap; padding-bottom: 15px; border-bottom: 1px solid var(--border); }
        
        /* Fixed Button Styling */
        .tab-btn { background: var(--glass); border: 1px solid var(--border); color: rgba(255,255,255,0.4); font-size: 0.7rem; padding: 8px 14px; border-radius: 8px; cursor: pointer; transition: 0.2s; outline: none; }
        .tab-btn.active { background: var(--accent) !important; color: #000 !important; font-weight: 700; border-color: var(--accent); box-shadow: 0 0 15px rgba(0, 210, 255, 0.3); }

        .inventory-scroll { flex-grow: 1; overflow-y: auto; margin-top: 10px; }
        .item-row { display: grid; grid-template-columns: 1fr 140px; padding: 15px 20px; border-bottom: 1px solid var(--border); cursor: pointer; border-radius: 8px; }
        .item-row:hover { background: rgba(0, 210, 255, 0.05); }
        .item-price { font-family: 'JetBrains Mono'; color: var(--accent); text-align: right; font-weight: 700; }

        .checkout-panel { width: 380px; background: var(--panel); border-radius: 24px; padding: 25px; display: flex; flex-direction: column; border: 1px solid var(--border); }
        #grand-total { font-family: 'JetBrains Mono'; font-size: 2rem; color: var(--accent); margin-top: 10px; }
        .btn-pay { width: 100%; padding: 18px; background: var(--accent); color: #000; border: none; border-radius: 12px; font-weight: 800; cursor: pointer; margin-top: 20px; }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="terminal-panel">
        <h2 style="color: var(--accent); margin-top:0;">ORDER LINE</h2>
        <input type="text" id="productSearch" class="search-input" placeholder="Search product..." oninput="handleFilters()">

        <div class="nav-section">
            <span class="nav-label">Ordering Method</span>
            <div class="tab-group" id="group-order-type">
                <button type="button" class="tab-btn active" onclick="setOrderType('Personal', this)">PERSONAL</button>
                <button type="button" class="tab-btn" onclick="setOrderType('Email', this)">EMAIL</button>
                <button type="button" class="tab-btn" onclick="setOrderType('Viber', this)">VIBER</button>
                <button type="button" class="tab-btn" onclick="setOrderType('Phone No.', this)">PHONE NO.</button>
                <button type="button" class="tab-btn" onclick="setOrderType('Tel. No.', this)">TEL. NO.</button>
            </div>
        </div>

        <div class="nav-section">
            <span class="nav-label">Filter by Shop</span>
            <div class="tab-group" id="group-suppliers" style="border:none;">
                <button type="button" class="tab-btn active" onclick="updateSupplierFilter('All', this)">ALL SHOPS</button>
                <?php
                $sup_query = mysqli_query($conn, "SELECT shop_name FROM suppliers ORDER BY shop_name ASC");
                if($sup_query) {
                    while($sup = mysqli_fetch_assoc($sup_query)): ?>
                        <button type="button" class="tab-btn" onclick="updateSupplierFilter('<?php echo addslashes($sup['shop_name']); ?>', this)">
                            <?php echo strtoupper($sup['shop_name']); ?>
                        </button>
                    <?php endwhile; 
                } ?>
            </div>
        </div>

        <div class="inventory-scroll" id="inventory-list"></div>
    </div>

    <div class="checkout-panel">
        <h3>Basket</h3>
        <div id="cart-items" style="flex-grow:1; overflow-y:auto;"></div>
        <div id="grand-total">₱ 0.00</div>
        <button class="btn-pay" onclick="processOrder()">Complete Order</button>
    </div>
</div>

<script id="products-json" type="application/json">
    <?php 
        $res = mysqli_query($conn, "SELECT id, product_name, price, stock, shop_name FROM products");
        $data = [];
        if($res) {
            while($row = mysqli_fetch_assoc($res)) {
                $data[] = [
                    'id' => (int)$row['id'],
                    'name' => htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8'),
                    'price' => (float)$row['price'],
                    'stock' => (int)$row['stock'],
                    'supplier' => $row['shop_name']
                ];
            }
        }
        echo json_encode($data); 
    ?>
</script>

<script>
    // Global State
    let products = [];
    let cart = [];
    let currentSupplier = 'All';
    let currentOrderType = 'Personal';

    // 1. FIXED ORDER TYPE FUNCTION
    function setOrderType(type, btn) {
        // Find all buttons in the specific group
        const parent = document.getElementById('group-order-type');
        const btns = parent.getElementsByClassName('tab-btn');
        
        // Remove active class from all
        for(let b of btns) {
            b.classList.remove('active');
        }
        
        // Add active class to clicked
        btn.classList.add('active');
        currentOrderType = type;
        console.log("Order Method changed to:", currentOrderType);
    }

    // 2. SUPPLIER FILTER FUNCTION
    function updateSupplierFilter(brand, btn) {
        const parent = document.getElementById('group-suppliers');
        const btns = parent.getElementsByClassName('tab-btn');
        
        for(let b of btns) {
            b.classList.remove('active');
        }
        
        btn.classList.add('active');
        currentSupplier = brand;
        handleFilters();
    }

    // 3. PRODUCT HANDLING
    function handleFilters() {
        const query = document.getElementById('productSearch').value.toLowerCase();
        const filtered = products.filter(p => {
            const matchName = p.name.toLowerCase().includes(query);
            const matchSup = (currentSupplier === 'All' || p.supplier === currentSupplier);
            return matchName && matchSup;
        });
        renderProducts(filtered);
    }

    function renderProducts(list) {
        const container = document.getElementById('inventory-list');
        if (!container) return;
        
        container.innerHTML = list.map(p => `
            <div class="item-row" onclick="addToCart(${p.id}, '${p.name.replace(/'/g, "\\'")}', ${p.price})">
                <div>
                    <div style="font-weight:600; color:#fff;">${p.name}</div>
                    <div style="font-size:0.7rem; color:#6a7282;">${p.stock} units • ${p.supplier}</div>
                </div>
                <div class="item-price">₱ ${p.price.toLocaleString(undefined, {minimumFractionDigits:2})}</div>
            </div>
        `).join('');
    }

    function addToCart(id, name, price) {
        const item = cart.find(i => i.id === id);
        if (item) item.qty++;
        else cart.push({ id, name, price, qty: 1 });
        updateCartUI();
    }

    function updateCartUI() {
        let total = 0;
        const container = document.getElementById('cart-items');
        container.innerHTML = cart.map(item => {
            total += item.price * item.qty;
            return `<div style="display:flex; justify-content:space-between; margin-bottom:10px; font-size:0.85rem;">
                        <span>${item.name} x${item.qty}</span>
                        <span>₱${(item.price * item.qty).toLocaleString()}</span>
                    </div>`;
        }).join('');
        document.getElementById('grand-total').innerText = `₱ ${total.toLocaleString(undefined, {minimumFractionDigits:2})}`;
    }

    function processOrder() {
        if(cart.length === 0) return alert("Basket is empty!");
        alert(`Success!\nOrder Method: ${currentOrderType}\nItems: ${cart.length}`);
    }

    // Initialize on Load
    window.addEventListener('DOMContentLoaded', () => {
        try {
            const dataText = document.getElementById('products-json').textContent;
            products = JSON.parse(dataText);
            renderProducts(products);
        } catch (e) {
            console.error("Failed to load products:", e);
        }
    });
</script>

</body>
</html>