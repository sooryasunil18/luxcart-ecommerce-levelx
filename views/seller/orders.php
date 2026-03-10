<!-- Seller Orders Management Page -->
<div class="seller-layout">
    <aside class="seller-sidebar">
        <div class="seller-logo">
            <i class="fas fa-store"></i>
            <span>Seller Panel</span>
        </div>
        <nav class="seller-nav">
            <a href="<?= BASE_URL ?>/seller" class="<?= ($currentPage ?? '') === 'seller/dashboard' ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/seller/products" class="<?= ($currentPage ?? '') === 'seller/products' ? 'active' : '' ?>">
                <i class="fas fa-box"></i> My Products
            </a>
            <a href="<?= BASE_URL ?>/seller/orders" class="<?= ($currentPage ?? '') === 'seller/orders' ? 'active' : '' ?>">
                <i class="fas fa-shopping-cart"></i> Orders Received
            </a>
            <a href="<?= BASE_URL ?>/seller/customer-history" class="<?= ($currentPage ?? '') === 'seller/customer-history' ? 'active' : '' ?>">
                <i class="fas fa-history"></i> Customer History
            </a>
        </nav>
        <div style="margin-top: auto; padding: 20px;">
            <a href="<?= BASE_URL ?>/" class="btn btn-outline" style="width: 100%; text-align: center; border-color: rgba(255,255,255,0.2); color: #fff;">
                <i class="fas fa-external-link-alt"></i> View Store
            </a>
        </div>
    </aside>

    <main class="seller-main">
        <div class="seller-header">
            <h1>Orders Received</h1>
            <div class="seller-user">
                <span><?= htmlspecialchars($_SESSION['user_name'] ?? 'Seller') ?></span>
                <a href="<?= BASE_URL ?>/logout" class="btn btn-sm" style="background: transparent; border: 1px solid #dc2626; color: #dc2626;">Logout</a>
            </div>
        </div>

        <div class="seller-content">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <div class="seller-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 style="margin: 0; font-size: 1.2rem;">All Order Items</h2>
                </div>

                <?php if (empty($orders)): ?>
                    <div style="text-align: center; padding: 40px 20px; color: #64748b;">
                        <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 15px; color: #cbd5e1;"></i>
                        <h3>No orders received yet</h3>
                        <p>When customers buy your products, they will appear here.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table" style="min-width: 1000px;">
                            <thead>
                                <tr>
                                    <th>Order Info</th>
                                    <th>Product</th>
                                    <th>Customer Details</th>
                                    <th>Price & Qty</th>
                                    <th>Status (Update)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <!-- Order Info -->
                                        <td>
                                            <div style="font-weight: 600; color: #1a1a2e; margin-bottom: 4px;">#ORD-<?= str_pad($order['order_id'], 6, '0', STR_PAD_LEFT) ?></div>
                                            <div style="font-size: 0.85rem; color: #64748b;"><i class="fas fa-calendar-alt"></i> <?= date('M j, Y h:i A', strtotime($order['order_date'])) ?></div>
                                            <div style="font-size: 0.85rem; margin-top: 4px; font-weight: 600; text-transform: uppercase;">
                                                <?php if ($order['payment_method'] === 'razorpay'): ?>
                                                    <span style="color: #0d9488;"><i class="fas fa-credit-card"></i> Razorpay</span>
                                                <?php else: ?>
                                                    <span style="color: #0ea5e9;"><i class="fas fa-money-bill-wave"></i> COD</span>
                                                <?php endif; ?>
                                                
                                                <?php if (isset($order['payment_status'])): ?>
                                                    <?php if ($order['payment_status'] === 'paid'): ?>
                                                        <span style="background: #ecfdf5; color: #059669; padding: 2px 6px; border-radius: 12px; font-size: 0.75rem; margin-left: 5px;"><i class="fas fa-check-circle"></i> Paid</span>
                                                    <?php else: ?>
                                                        <span style="background: #fffbeb; color: #d97706; padding: 2px 6px; border-radius: 12px; font-size: 0.75rem; margin-left: 5px;">Pending</span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        
                                        <!-- Product -->
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <?php if (!empty($order['image'])): ?>
                                                    <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($order['image']) ?>" alt="" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div style="width: 40px; height: 40px; background: #eee; border-radius: 4px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-image" style="color: #bbb;"></i></div>
                                                <?php endif; ?>
                                                <div style="font-weight: 500; font-size: 0.95rem; line-height: 1.3;">
                                                    <?= htmlspecialchars($order['product_name']) ?>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Customer Details -->
                                        <td>
                                            <div style="font-weight: 600; color: #1a1a2e; margin-bottom: 4px; display: flex; align-items: center; gap: 5px;">
                                                <i class="fas fa-user-circle" style="color: #0d9488;"></i> <?= htmlspecialchars($order['customer_name']) ?>
                                            </div>
                                            <div style="font-size: 0.8rem; color: #64748b; margin-bottom: 4px;">
                                                <i class="fas fa-envelope"></i> <?= htmlspecialchars($order['customer_email']) ?>
                                            </div>
                                            <div style="font-size: 0.8rem; color: #64748b; background: #f8fafc; padding: 5px; border-radius: 4px; border: 1px dashed #cbd5e1; margin-top: 5px;">
                                                <strong style="color: #475569;">Delivery:</strong> <?= htmlspecialchars($order['shipping_name']) ?> <br>
                                                <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($order['city'] . ', ' . $order['state'] . ' ' . $order['pincode']) ?> <br>
                                                <i class="fas fa-phone"></i> <?= htmlspecialchars($order['phone']) ?>
                                            </div>
                                        </td>
                                        
                                        <!-- Price & Qty -->
                                        <td>
                                            <div style="font-weight: 700; color: #1a1a2e; font-size: 1.1rem; margin-bottom: 4px;">
                                                ₹<?= number_format($order['price'], 2) ?>
                                            </div>
                                            <div style="font-size: 0.9rem; color: #64748b;">
                                                Qty: <span style="background: #e2e8f0; color: #334155; padding: 1px 6px; border-radius: 10px; font-weight: 600;"><?= $order['quantity'] ?></span>
                                            </div>
                                            <div style="font-size: 0.85rem; color: #0d9488; margin-top: 4px; font-weight: 600;">
                                                Total: ₹<?= number_format($order['price'] * $order['quantity'], 2) ?>
                                            </div>
                                        </td>
                                        
                                        <!-- Status Update Form -->
                                        <td>
                                            <?php
                                                $statusColors = [
                                                    'pending' => 'background: #fef3c7; color: #b45309; border: 1px solid #fde68a;',
                                                    'processing' => 'background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;',
                                                    'shipped' => 'background: #ede9fe; color: #5b21b6; border: 1px solid #ddd6fe;',
                                                    'delivered' => 'background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;',
                                                    'cancelled' => 'background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;'
                                                ];
                                                $currentStyle = $statusColors[$order['item_status']] ?? $statusColors['pending'];
                                            ?>
                                            <form action="<?= BASE_URL ?>/seller/orders/update" method="POST" style="display: flex; flex-direction: column; gap: 8px;">
                                                <input type="hidden" name="item_id" value="<?= $order['id'] ?>">
                                                
                                                <select name="status" class="form-control" style="padding: 6px; font-size: 0.9rem; <?= $currentStyle ?>; font-weight: 600; text-transform: capitalize; border-radius: 6px; cursor: pointer; height: auto;" onchange="this.form.submit()">
                                                    <option value="pending" <?= $order['item_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                    <option value="processing" <?= $order['item_status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                                    <option value="shipped" <?= $order['item_status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                                    <option value="delivered" <?= $order['item_status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                                    <option value="cancelled" <?= $order['item_status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>
