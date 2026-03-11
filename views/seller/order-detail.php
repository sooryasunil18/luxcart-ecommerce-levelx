<div style="display: flex; min-height: calc(100vh - 130px); background: #f8fafc;">
    <!-- Seller Sidebar (Full Height & Sticky) -->
    <aside
        style="width: 260px; background: #fff; border-right: 1px solid #e5e7eb; flex-shrink: 0; position: sticky; top: 0; height: calc(100vh - 130px); overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; color: #111827; font-size: 1.1rem;"><i class="fas fa-store"
                    style="color:#0d9488; margin-right:8px;"></i> Seller Panel</h3>
            <p style="margin: 5px 0 0 0; font-size: 0.85rem; color: #6b7280;"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Seller') ?></p>
        </div>
        <div class="list-group" style="padding: 15px;">
            <a href="<?= BASE_URL ?>/seller" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;"
                onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
                <i class="fas fa-home" style="width: 20px; text-align: center;"></i> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/seller/products" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;"
                onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
                <i class="fas fa-box" style="width: 20px; text-align: center;"></i> My Products
            </a>
            <a href="<?= BASE_URL ?>/seller/customer-history" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;"
                onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
                <i class="fas fa-history" style="width: 20px; text-align: center;"></i> Customer History
            </a>
            <a href="<?= BASE_URL ?>/seller/orders" class="list-group-item active"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; background: #0d9488; color: #fff; font-weight: 500; text-decoration: none;">
                <i class="fas fa-shopping-cart" style="width: 20px; text-align: center;"></i> Orders
            </a>
            <a href="<?= BASE_URL ?>/seller/products/create" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;"
                onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
                <i class="fas fa-plus" style="width: 20px; text-align: center;"></i> Add Product
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main style="flex: 1; padding: 40px; overflow-y: auto;">
        <div style="max-width: 1100px; margin: 0 auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <div>
                    <a href="<?= BASE_URL ?>/seller/orders" style="color: #64748b; text-decoration: none; font-size: 0.9rem; display: flex; align-items: center; gap: 5px; margin-bottom: 15px; transition: color 0.2s;" onmouseover="this.style.color='#0d9488'" onmouseout="this.style.color='#64748b'">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                    <h1 style="margin: 0; font-size: 1.8rem; color: #1e293b;">Order Item Details</h1>
                    <p style="color: #64748b; margin: 5px 0 0 0;">Transaction: <code style="background: #f1f5f9; padding: 2px 5px; border-radius: 4px;">#ORD-<?= str_pad($order['order_id'], 6, '0', STR_PAD_LEFT) ?></code></p>
                </div>
                
                <div style="text-align: right;">
                    <?php
                        $statusColors = [
                            'pending' => 'background: #fef3c7; color: #b45309; border: 1px solid #fde68a;',
                            'processing' => 'background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;',
                            'shipped' => 'background: #ede9fe; color: #5b21b6; border: 1px solid #ddd6fe;',
                            'delivered' => 'background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;',
                            'cancelled' => 'background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;'
                        ];
                        $statusStyle = $statusColors[$order['item_status']] ?? $statusColors['pending'];
                    ?>
                    <div style="padding: 10px 20px; border-radius: 50px; font-weight: 700; text-transform: capitalize; font-size: 0.95rem; <?= $statusStyle ?>">
                        <i class="fas fa-circle" style="font-size: 0.5rem; vertical-align: middle; margin-right: 8px;"></i> <?= $order['item_status'] ?>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1.8fr 1fr; gap: 30px;">
                <!-- Left Column -->
                <div style="display: flex; flex-direction: column; gap: 30px;">
                    <!-- Product Card -->
                    <div style="background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                        <h3 style="margin: 0 0 20px 0; font-size: 1.1rem; color: #334155; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-box" style="color: #0d9488;"></i> Product Details
                        </h3>
                        <div style="display: flex; gap: 25px; align-items: start;">
                            <?php if (!empty($order['image'])): ?>
                                <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($order['image']) ?>" style="width: 140px; height: 140px; object-fit: cover; border-radius: 10px; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                            <?php else: ?>
                                <div style="width: 140px; height: 140px; background: #f8fafc; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #cbd5e1; border: 1px solid #f1f5f9;"><i class="fas fa-image fa-3x"></i></div>
                            <?php endif; ?>
                            <div style="flex: 1;">
                                <h4 style="margin: 0 0 10px 0; font-size: 1.3rem; color: #1e293b;"><?= htmlspecialchars($order['product_name']) ?></h4>
                                <div style="display: flex; flex-wrap: wrap; gap: 30px; margin-top: 20px; padding: 15px; background: #f9fafb; border-radius: 8px;">
                                    <div>
                                        <p style="margin: 0; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 600;">Item Price</p>
                                        <p style="margin: 4px 0 0 0; font-weight: 700; font-size: 1.1rem; color: #0d9488;">₹<?= number_format($order['price'], 2) ?></p>
                                    </div>
                                    <div>
                                        <p style="margin: 0; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 600;">Quantity</p>
                                        <p style="margin: 4px 0 0 0; font-weight: 700; font-size: 1.1rem; color: #1e293b;">x <?= $order['quantity'] ?></p>
                                    </div>
                                    <div>
                                        <p style="margin: 0; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 600;">Total Earned</p>
                                        <p style="margin: 4px 0 0 0; font-weight: 800; font-size: 1.2rem; color: #111827;">₹<?= number_format($order['price'] * $order['quantity'], 2) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Card -->
                    <div style="background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                        <h3 style="margin: 0 0 20px 0; font-size: 1.1rem; color: #334155; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-truck" style="color: #0d9488;"></i> Shipping & Delivery
                        </h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                            <div style="border-right: 1px solid #f1f5f9; padding-right: 20px;">
                                <p style="margin: 0 0 12px 0; font-weight: 700; color: #1e293b; font-size: 1rem;"><?= htmlspecialchars($order['shipping_name']) ?></p>
                                <p style="margin: 0; color: #475569; line-height: 1.6; font-size: 0.95rem;">
                                    <?= htmlspecialchars($order['address']) ?><br>
                                    <strong><?= htmlspecialchars($order['city']) ?></strong>, <?= htmlspecialchars($order['state']) ?><br>
                                    <span style="display: inline-block; margin-top: 5px; background: #f1f5f9; padding: 2px 8px; border-radius: 4px; font-weight: 600;">PIN: <?= htmlspecialchars($order['pincode']) ?></span>
                                </p>
                            </div>
                            <div>
                                <div style="margin-bottom: 15px;">
                                    <p style="margin: 0 0 4px 0; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 600;">Customer Contact</p>
                                    <p style="margin: 0; color: #1e293b; font-weight: 500;"><i class="fas fa-phone-alt" style="color: #0d9488; width: 20px;"></i> <?= htmlspecialchars($order['phone']) ?></p>
                                    <p style="margin: 4px 0 0 0; color: #64748b; font-size: 0.9rem;"><i class="fas fa-envelope" style="color: #0d9488; width: 20px;"></i> <?= htmlspecialchars($order['customer_email']) ?></p>
                                </div>
                                <div style="background: #fffbeb; border: 1px solid #fef3c7; padding: 10px; border-radius: 8px;">
                                    <p style="margin: 0; font-size: 0.8rem; color: #92400e; display: flex; align-items: start; gap: 8px;">
                                        <i class="fas fa-info-circle" style="margin-top: 3px;"></i>
                                        <span>Please verify the delivery address before dispatching the item.</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div style="display: flex; flex-direction: column; gap: 30px;">
                    <!-- Update Status -->
                    <div style="background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #0d9488; box-shadow: 0 10px 15px -3px rgba(13, 148, 136, 0.1);">
                        <h3 style="margin: 0 0 20px 0; font-size: 1.1rem; color: #0f766e;">Status Management</h3>
                        <form action="<?= BASE_URL ?>/seller/orders/update" method="POST">
                            <input type="hidden" name="item_id" value="<?= $order['id'] ?>">
                            <div style="margin-bottom: 20px;">
                                <label style="display: block; margin-bottom: 10px; font-size: 0.9rem; color: #475569; font-weight: 600;">Update Item Progress:</label>
                                <select name="status" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-family: inherit; background: #f8fafc; cursor: pointer; font-weight: 500; color: #1e293b;">
                                    <option value="pending" <?= $order['item_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="processing" <?= $order['item_status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="shipped" <?= $order['item_status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                    <option value="delivered" <?= $order['item_status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                    <option value="cancelled" <?= $order['item_status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 1rem;">
                                Update Status
                            </button>
                        </form>
                    </div>

                    <!-- Payment Summary -->
                    <div style="background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                        <h3 style="margin: 0 0 20px 0; font-size: 1.1rem; color: #334155; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-receipt" style="color: #0d9488;"></i> Payment Check
                        </h3>
                        <div style="display: grid; gap: 15px;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: #64748b; font-size: 0.95rem;">Payment Method</span>
                                <span style="font-weight: 700; color: #1e293b; text-transform: uppercase; font-size: 0.85rem;">
                                    <?= $order['payment_method'] === 'razorpay' ? '<i class="fas fa-credit-card" style="color:#0ea5e9"></i> Razorpay' : '<i class="fas fa-wallet" style="color:#f59e0b"></i> COD' ?>
                                </span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: #64748b; font-size: 0.95rem;">Payment Status</span>
                                <span style="font-weight: 800; color: <?= $order['payment_status'] === 'paid' ? '#059669' : '#d97706' ?>; text-transform: uppercase; font-size: 0.85rem; background: <?= $order['payment_status'] === 'paid' ? '#f0fdf4' : '#fffbeb' ?>; padding: 4px 10px; border-radius: 6px;">
                                    <?= $order['payment_status'] ?>
                                </span>
                            </div>
                            <?php if (!empty($order['razorpay_payment_id'])): ?>
                                <div style="margin-top: 5px; padding: 12px; background: #f8fafc; border-radius: 8px; border: 1px dashed #cbd5e1;">
                                    <p style="margin: 0 0 6px 0; font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Razorpay ID</p>
                                    <code style="display: block; font-size: 0.8rem; color: #0d9488; word-break: break-all; font-weight: 600;"><?= htmlspecialchars($order['razorpay_payment_id']) ?></code>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
