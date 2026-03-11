<div style="display: flex; min-height: calc(100vh - 73px); background: #f8fafc;">
    <!-- Admin Sidebar (Full Height & Sticky) -->
    <aside
        style="width: 260px; background: #fff; border-right: 1px solid #e5e7eb; flex-shrink: 0; position: sticky; top: 0; height: calc(100vh - 73px); overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; color: #111827; font-size: 1.1rem;"><i class="fas fa-shield-alt"
                    style="color:#0d9488; margin-right:8px;"></i> Admin Panel</h3>
            <p style="margin: 5px 0 0 0; font-size: 0.85rem; color: #6b7280;">Administrator</p>
        </div>
        <div class="list-group" style="padding: 15px;">
            <a href="<?= BASE_URL ?>/admin" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;">
                <i class="fas fa-home" style="width: 20px; text-align: center;"></i> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/admin/users" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;">
                <i class="fas fa-users" style="width: 20px; text-align: center;"></i> Manage Users
            </a>
            <a href="<?= BASE_URL ?>/admin/sellers" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;">
                <i class="fas fa-store" style="width: 20px; text-align: center;"></i> Seller Management
            </a>
            <a href="<?= BASE_URL ?>/admin/categories" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;">
                <i class="fas fa-list" style="width: 20px; text-align: center;"></i> Manage Categories
            </a>
            <a href="<?= BASE_URL ?>/admin/orders" class="list-group-item active"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; background: #0d9488; color: #fff; font-weight: 500; text-decoration: none;">
                <i class="fas fa-shopping-cart" style="width: 20px; text-align: center;"></i> Manage Orders
            </a>
            <a href="<?= BASE_URL ?>/products" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;">
                <i class="fas fa-box" style="width: 20px; text-align: center;"></i> View All Products
            </a>
        </div>
    </aside>

    <!-- Admin Content Area -->
    <main style="flex: 1; padding: 40px; overflow-y: auto;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <h2 style="margin-bottom: 30px; font-size: 1.5rem; color: #111827;">Platform Orders</h2>

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
                            
                            <!-- Order Status Badge -->
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
                                <span style="display: inline-block; padding: 6px 16px; border-radius: 50px; font-size: 0.9rem; font-weight: 700; text-transform: capitalize; <?= $currentStyle ?>">
                                    <?= htmlspecialchars($order['order_status']) ?>
                                </span>
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
        </div>
    </main>
</div>
