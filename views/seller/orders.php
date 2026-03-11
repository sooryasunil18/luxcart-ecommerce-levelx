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
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;">
                <i class="fas fa-home" style="width: 20px; text-align: center;"></i> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/seller/products" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;">
                <i class="fas fa-box" style="width: 20px; text-align: center;"></i> My Products
            </a>
            <a href="<?= BASE_URL ?>/seller/customer-history" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;">
                <i class="fas fa-history" style="width: 20px; text-align: center;"></i> Customer History
            </a>
            <a href="<?= BASE_URL ?>/seller/orders" class="list-group-item active"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; background: #0d9488; color: #fff; font-weight: 500; text-decoration: none;">
                <i class="fas fa-shopping-cart" style="width: 20px; text-align: center;"></i> Orders
            </a>
            <a href="<?= BASE_URL ?>/seller/products/create" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;">
                <i class="fas fa-plus" style="width: 20px; text-align: center;"></i> Add Product
            </a>
        </div>
    </aside>

    <!-- Seller Content Area -->
    <main style="flex: 1; padding: 40px; overflow-y: auto;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h2 style="font-size: 1.5rem; color: #1a1a2e; margin: 0;">Orders Received</h2>
                <div style="font-size: 0.9rem; color: #64748b;">Managing orders for your products</div>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div style="background: #ecfdf5; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #10b981;">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div style="background: #fef2f2; color: #b91c1c; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #ef4444;">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #eee; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <?php if (empty($orders)): ?>
                    <div style="text-align: center; padding: 60px 0; color: #6b7280;">
                        <i class="fas fa-box-open" style="font-size: 4rem; margin-bottom: 15px; color: #d1d5db;"></i>
                        <h3 style="color: #4b5563; margin-bottom: 10px;">No Orders Yet</h3>
                        <p>When customers buy your products, they will appear here.</p>
                    </div>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left;">
                            <thead>
                                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                                    <th style="padding: 15px; font-weight: 600; color: #4b5563;">Order Info</th>
                                    <th style="padding: 15px; font-weight: 600; color: #4b5563;">Product</th>
                                    <th style="padding: 15px; font-weight: 600; color: #4b5563;">Customer</th>
                                    <th style="padding: 15px; font-weight: 600; color: #4b5563;">Amount & Qty</th>
                                    <th style="padding: 15px; font-weight: 600; color: #4b5563; width: 220px;">Status & Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr style="border-bottom: 1px solid #e5e7eb; transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                                        <td style="padding: 15px;">
                                            <div style="font-weight: 600; color: #111827;">#ORD-<?= str_pad($order['order_id'], 6, '0', STR_PAD_LEFT) ?></div>
                                            <div style="font-size: 0.75rem; color: #6b7280; margin-top: 4px;">
                                                <?= date('M j, Y', strtotime($order['order_date'])) ?>
                                            </div>
                                            <div style="margin-top: 6px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">
                                                <?php if ($order['payment_method'] === 'razorpay'): ?>
                                                    <span style="color: #0d9488;"><i class="fas fa-credit-card"></i> RAZORPAY</span>
                                                <?php else: ?>
                                                    <span style="color: #0ea5e9;"><i class="fas fa-money-bill-wave"></i> COD</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td style="padding: 15px;">
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <?php if (!empty($order['image'])): ?>
                                                    <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($order['image']) ?>" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover; border: 1px solid #eee;">
                                                <?php else: ?>
                                                    <div style="width: 40px; height: 40px; background: #f3f4f6; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #9ca3af;"><i class="fas fa-image"></i></div>
                                                <?php endif; ?>
                                                <div style="font-weight: 500; font-size: 0.9rem; color: #111827; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    <?= htmlspecialchars($order['product_name']) ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 15px;">
                                            <div style="font-weight: 500; color: #374151; font-size: 0.9rem;"><?= htmlspecialchars($order['customer_name']) ?></div>
                                            <div style="font-size: 0.75rem; color: #6b7280; margin-top: 2px;">
                                                <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($order['city']) ?>
                                            </div>
                                        </td>
                                        <td style="padding: 15px;">
                                            <div style="font-weight: 600; color: #111827;">₹<?= number_format($order['price'], 2) ?></div>
                                            <div style="font-size: 0.75rem; color: #6b7280; margin-top: 2px;">Qty: <strong><?= $order['quantity'] ?></strong></div>
                                        </td>
                                        <td style="padding: 15px;">
                                            <?php
                                                $statusColors = [
                                                    'pending' => 'background: #fef3c7; color: #b45309; border-color: #fde68a;',
                                                    'processing' => 'background: #e0f2fe; color: #0369a1; border-color: #bae6fd;',
                                                    'shipped' => 'background: #ede9fe; color: #5b21b6; border-color: #ddd6fe;',
                                                    'delivered' => 'background: #dcfce7; color: #15803d; border-color: #bbf7d0;',
                                                    'cancelled' => 'background: #fee2e2; color: #b91c1c; border-color: #fecaca;'
                                                ];
                                                $style = $statusColors[$order['item_status']] ?? $statusColors['pending'];
                                            ?>
                                            <form action="<?= BASE_URL ?>/seller/orders/update" method="POST" style="display: flex; flex-direction: column; gap: 8px;">
                                                <input type="hidden" name="item_id" value="<?= $order['id'] ?>">
                                                <div style="display: flex; gap: 5px;">
                                                    <select name="status" onchange="this.form.submit()" style="flex: 1; padding: 6px 10px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; text-transform: capitalize; cursor: pointer; border: 1px solid; <?= $style ?>">
                                                        <option value="pending" <?= $order['item_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                        <option value="processing" <?= $order['item_status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                                        <option value="shipped" <?= $order['item_status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                                        <option value="delivered" <?= $order['item_status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                                        <option value="cancelled" <?= $order['item_status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                                    </select>
                                                    <a href="<?= BASE_URL ?>/seller/order/<?= $order['id'] ?>" class="btn btn-outline btn-sm" style="padding: 6px 10px; font-size: 0.85rem;" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
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
