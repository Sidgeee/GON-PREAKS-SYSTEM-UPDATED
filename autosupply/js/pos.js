let cart = [];

// Listen for the "Enter" key on the barcode scanner input
document.getElementById('barcode-scan').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        const partNumber = this.value;
        if (partNumber) {
            addItemToCart(partNumber);
            this.value = ''; // Clear input for next scan
        }
    }
});

function addItemToCart(partNumber) {
    fetch(`get_product.php?part_number=${partNumber}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const existingItem = cart.find(item => item.part_number === partNumber);
                
                if (existingItem) {
                    existingItem.qty++;
                } else {
                    cart.push({
                        part_number: data.product.part_number,
                        name: data.product.name,
                        brand: data.product.brand,
                        price: parseFloat(data.product.price),
                        qty: 1
                    });
                }
                renderCart();
            } else {
                alert("Product not found!");
            }
        });
}

function renderCart() {
    const tbody = document.getElementById('cart-body');
    const totalDisplay = document.getElementById('grand-total');
    const subtotalDisplay = document.getElementById('subtotal');
    const countDisplay = document.getElementById('item-count');
    
    tbody.innerHTML = '';
    let grandTotal = 0;

    cart.forEach((item, index) => {
        const itemTotal = item.price * item.qty;
        grandTotal += itemTotal;

        tbody.innerHTML += `
            <tr>
                <td><strong>${item.name}</strong><br><small>${item.part_number}</small></td>
                <td>${item.brand}</td>
                <td>₱${item.price.toLocaleString()}</td>
                <td>
                    <input type="number" value="${item.qty}" min="1" 
                           onchange="updateQty(${index}, this.value)" 
                           style="width: 50px; background: transparent; color: white; border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; padding: 5px;">
                </td>
                <td>₱${itemTotal.toLocaleString()}</td>
                <td style="text-align: center;">
                    <button onclick="removeItem(${index})" style="color: #ef4444; background: none; border: none; cursor: pointer;">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    totalDisplay.innerText = `₱ ${grandTotal.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
    subtotalDisplay.innerText = `₱ ${grandTotal.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
    countDisplay.innerText = cart.length;
}

function updateQty(index, newQty) {
    cart[index].qty = parseInt(newQty);
    renderCart();
}

function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

// --- UPDATED PROCESS CHECKOUT ---
function processCheckout() {
    if (cart.length === 0) return alert("Cart is empty!");

    const paymentMethod = document.getElementById('payment-method').value;
    const grandTotal = document.getElementById('grand-total').innerText;

    fetch('save_sale.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            cart: cart,
            payment_method: paymentMethod
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // 1. Open Print Window
            printReceipt(data.sale_id, grandTotal, paymentMethod);
            
            // 2. Alert and Refresh
            alert("Sale Completed Successfully!");
            window.location.reload(); 
        } else {
            alert("Error saving sale. Please check your database connection.");
        }
    });
}

// --- NEW PRINT FUNCTION ---
function printReceipt(saleId, total, payment) {
    const receiptWindow = window.open('', 'PRINT', 'height=600,width=400');

    let itemsHtml = '';
    cart.forEach(item => {
        itemsHtml += `
            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 3px;">
                <span>${item.qty}x ${item.name}</span>
                <span>₱${(item.price * item.qty).toLocaleString()}</span>
            </div>
        `;
    });

    receiptWindow.document.write(`
        <html>
            <head><title>Receipt #${saleId}</title></head>
            <body style="font-family: 'Courier New', monospace; padding: 20px; color: black; line-height: 1.2;">
                <div style="text-align: center; margin-bottom: 10px;">
                    <h2 style="margin:0;">GONPREAKS</h2>
                    <p style="font-size: 12px; margin: 2px;">AUTOSUPPLY ENTERPRISE<br>Quezon City, Philippines</p>
                    <p style="font-size: 12px; margin: 2px;">OR#: 000${saleId}</p>
                    <hr style="border: 0.5px dashed black;">
                </div>
                ${itemsHtml}
                <hr style="border: 0.5px dashed black;">
                <div style="text-align: right; font-weight: bold; font-size: 15px; margin: 10px 0;">
                    TOTAL: ${total}
                </div>
                <div style="font-size: 11px; margin-top: 5px;">
                    Payment: ${payment.replace('_', ' ')}<br>
                    Date: ${new Date().toLocaleString()}<br>
                    Cashier: System Admin
                </div>
                <div style="text-align: center; margin-top: 15px; font-size: 12px; border-top: 0.5px solid #ccc; padding-top: 5px;">
                    THANK YOU FOR CHOOSING GONPREAKS!
                </div>
                <script>
                    window.onload = function() { 
                        window.print(); 
                        setTimeout(function(){ window.close(); }, 500); 
                    }
                </script>
            </body>
        </html>
    `);

    receiptWindow.document.close();
}