<!-- Admin Orders Management Page -->
<div class="admin-layout">
    <aside class="admin-sidebar" style="background: #1a1a2e; color: #fff; min-height: calc(100vh - 70px); padding: 20px 0;">
        <div style="padding: 0 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px;">
            <h3 style="margin: 0; display: flex; align-items: center; gap: 10px; color: #fff;">
                <i class="fas fa-hammer" style="color: #0ea5e9;"></i> Admin Panel
            </h3>
        </div>
        <nav class="admin-nav" style="display: flex; flex-direction: column;">
            <a href="<?= BASE_URL ?>/admin" style="padding: 12px 20px; color: #cbd5e1; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-tachometer-alt" style="width: 20px;"></i> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/admin/users" style="padding: 12px 20px; color: #cbd5e1; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-users" style="width: 20px;"></i> Manage Users
            </a>
            <a href="<?= BASE_URL ?>/admin/sellers" style="padding: 12px 20px; color: #cbd5e1; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-store" style="width: 20px;"></i> Review Sellers
            </a>
            <a href="<?= BASE_URL ?>/admin/categories" style="padding: 12px 20px; color: #cbd5e1; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-tags" style="width: 20px;"></i> Manage Categories
            </a>
            <a href="<?= BASE_URL ?>/admin/orders" class="active" style="padding: 12px 20px; color: #fff; background: rgba(14, 165, 233, 0.15); border-left: 3px solid #0ea5e9; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-shopping-cart" style="width: 20px;"></i> All Orders
            </a>
            <a href="<?= BASE_URL ?>/products" style="padding: 12px 20px; color: #cbd5e1; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-box" style="width: 20px;"></i> Global Catalog
            </a>
        </nav>
    </aside>

    <main class="admin-main" style="padding: 30px; background: #f8fafc; flex: 1;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1 style="margin: 0; color: #1a1a2e; font-size: 1.8rem;">Platform Orders</h1>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success" style="margin-bottom: 20px;">
                <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error" style="margin-bottom: 20px;">
                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (empty($orders)): ?>
            <div style="background: #fff; padding: 50px 20px; border-radius: 12px; text-align: center; border: 1px solid #e2e8f0;">
                <div style="width: 80px; height: 80px; background: #f1f5f9; color: #94a3b8; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 20px;">
                    <i class="fas fa-receipt"></i>
                </div>
                <h3 style="color: #1a1a2e;">No Orders Yet</h3>
                <p style="color: #64748b;">The platform currently has zero orders placed.</p>
            </div>
        <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <?php foreach ($orders as $order): ?>
                    <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                        
                        <!-- Order Header Context -->
                        <div style="background: #f8fafc; padding: 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                            <div style="display: grid; grid-template-columns: repeat(4, auto); gap: 40px;">
                                <div>
                                    <span style="display: block; font-size: 0.8rem; color: #64748b; text-transform: uppercase;">Order Number</span>
                                    <strong style="color: #1a1a2e; font-size: 1.1rem;">#ORD-<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></strong>
                                </div>
                                <div>
                                    <span style="display: block; font-size: 0.8rem; color: #64748b; text-transform: uppercase;">Date</span>
                                    <strong style="color: #1a1a2e;"><?= date('M j, Y H:i', strtotime($order['created_at'])) ?></strong>
                                </div>
                                <div>
                                    <span style="display: block; font-size: 0.8rem; color: #64748b; text-transform: uppercase;">Customer</span>
                                    <strong style="color: #1a1a2e;"><?= htmlspecialchars($order['customer_name']) ?></strong>
                                    <div style="font-size: 0.8rem; color: #0ea5e9;"><?= htmlspecialchars($order['customer_email']) ?></div>
                                </div>
                                <div>
                                    <span style="display: block; font-size: 0.8rem; color: #64748b; text-transform: uppercase;">Total (<span style="text-transform: uppercase;"><?= htmlspecialchars($order['payment_method']) ?></span>)</span>
                                    <strong style="color: #1a1a2e;">₹<?= number_format($order['total_amount'], 2) ?></strong>
                                </div>
                            </div>
                            
                            <!-- Master Admin Control -->
                            <div>
                                <?php
                                    $statusColors = [
                                        'pending' => 'background: #fef3c7; color: #b45309; border: 1px solid #fde68a;',
                                        'processing' => 'background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;',
                                        'shipped' => 'background: #ede9fe; color: #5b21b6; border: 1px solid #ddd6fe;',
                                        'delivered' => 'background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;',
                                        'cancelled' => 'background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;'
                                    ];
                                    $currentStyle = $statusColors[$order['order_status']] ?? $statusColors['pending'];
                                ?>
                                <form action="<?= BASE_URL ?>/admin/orders/update" method="POST" style="display: flex; align-items: center; gap: 10px;">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <span style="font-size: 0.9rem; color: #64748b;">Global Status:</span>
                                    <select name="status" class="form-control" style="padding: 6px 10px; font-size: 0.9rem; <?= $currentStyle ?>; font-weight: 600; text-transform: capitalize; border-radius: 6px; cursor: pointer; min-width: 140px;" onchange="this.form.submit()">
                                        <option value="pending" <?= $order['order_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="processing" <?= $order['order_status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                        <option value="shipped" <?= $order['order_status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                        <option value="delivered" <?= $order['order_status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                        <option value="cancelled" <?= $order['order_status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                </form>
                            </div>
                        </div>

                        <!-- Sub-items within Order -->
                        <div style="padding: 0;">
                            <table class="table" style="margin: 0; box-shadow: none; border: none; font-size: 0.95rem;">
                                <thead style="background: #f1f5f9;">
                                    <tr>
                                        <th style="padding: 12px 20px; font-weight: 600; color: #475569; width: 35%;">Product</th>
                                        <th style="padding: 12px 20px; font-weight: 600; color: #475569;">Vendor</th>
                                        <th style="padding: 12px 20px; font-weight: 600; color: #475569; text-align: center;">Qty</th>
                                        <th style="padding: 12px 20px; font-weight: 600; color: #475569; text-align: right;">Price</th>
                                        <th style="padding: 12px 20px; font-weight: 600; color: #475569; text-align: right;">Item Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order['items'] as $item): ?>
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 15px 20px;">
                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                <?php if (!empty($item['image'])): ?>
                                                    <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($item['image']) ?>" alt="" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0;">
                                                <?php else: ?>
                                                    <div style="width: 40px; height: 40px; background: #e2e8f0; border-radius: 6px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-box" style="color: #94a3b8;"></i></div>
                                                <?php endif; ?>
                                                <div style="color: #1e293b; font-weight: 500;"><?= htmlspecialchars($item['product_name']) ?></div>
                                            </div>
                                        </td>
                                        <td style="padding: 15px 20px;">
                                            <span style="display: inline-flex; align-items: center; gap: 6px; color: #475569; background: #f1f5f9; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem;">
                                                <i class="fas fa-store" style="color: #0ea5e9;"></i> <?= htmlspecialchars($item['seller_name']) ?>
                                            </span>
                                        </td>
                                        <td style="padding: 15px 20px; text-align: center; font-weight: 600; color: #475569;">
                                            <?= $item['quantity'] ?>
                                        </td>
                                        <td style="padding: 15px 20px; text-align: right; color: #1e293b; font-weight: 600;">
                                            ₹<?= number_format($item['price'], 2) ?>
                                        </td>
                                        <td style="padding: 15px 20px; text-align: right;">
                                            <?php
                                                $ist = $statusColors[$item['item_status']] ?? $statusColors['pending'];
                                            ?>
                                            <span style="display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-transform: capitalize; <?= $ist ?>">
                                                <?= $item['item_status'] ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            
                            <!-- Delivery Address Footer -->
                            <div style="background: #f8fafc; padding: 15px 20px; border-top: 1px solid #e2e8f0; display: flex; align-items: flex-start; gap: 10px; color: #475569; font-size: 0.9rem;">
                                <i class="fas fa-truck" style="margin-top: 3px; color: #64748b;"></i>
                                <div>
                                    <strong style="color: #1e293b;"><?= htmlspecialchars($order['shipping_name']) ?></strong> &bull; 
                                    <?= htmlspecialchars($order['city'] . ', ' . $order['state']) ?> <span style="color: #cbd5e1; margin: 0 5px;">|</span> 
                                    <span style="cursor: help;" title="<?= htmlspecialchars($order['address']) ?>">Hover for full address</span>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</div>

<!-- Flex layout for admin panel if missing from global css -->
<style>
.admin-layout { display: flex; min-height: calc(100vh - 70px); }
.admin-sidebar { width: 250px; flex-shrink: 0; }
@media (max-width: 900px) { .admin-layout { flex-direction: column; } .admin-sidebar { width: 100%; min-height: auto; } }
</style>
