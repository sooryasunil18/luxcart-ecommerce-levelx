<div style="display: flex; min-height: calc(100vh - 130px); background: #f8fafc;">
    <!-- Seller Sidebar (Full Height & Sticky) -->
    <aside
        style="width: 260px; background: #fff; border-right: 1px solid #e5e7eb; flex-shrink: 0; position: sticky; top: 0; height: calc(100vh - 130px); overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; color: #111827; font-size: 1.1rem;"><i class="fas fa-store"
                    style="color:#0d9488; margin-right:8px;"></i> Seller Panel</h3>
            <p style="margin: 5px 0 0 0; font-size: 0.85rem; color: #6b7280;">
                <?= htmlspecialchars($_SESSION['user_name']) ?>
            </p>
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
            <a href="<?= BASE_URL ?>/seller/customer-history" class="list-group-item active"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; background: #0d9488; color: #fff; font-weight: 500; text-decoration: none;">
                <i class="fas fa-history" style="width: 20px; text-align: center;"></i> Customer History
            </a>
            <a href="<?= BASE_URL ?>/seller/orders" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;"
                onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
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
    <main style="flex: 1; padding: 30px; overflow-y: auto;">
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <h1 style="font-size: 1.8rem; color: #111827; margin: 0 0 8px 0;">Customer History</h1>
                <p style="color: #6b7280; margin: 0;">See which customers have interacted with your products.</p>
            </div>
        </div>

        <div
            style="background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                            <th
                                style="padding: 16px; font-weight: 600; color: #4b5563; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                Product Name</th>
                            <th
                                style="padding: 16px; font-weight: 600; color: #4b5563; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                Customer Name</th>
                            <th
                                style="padding: 16px; font-weight: 600; color: #4b5563; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                Customer Email</th>
                            <th
                                style="padding: 16px; font-weight: 600; color: #4b5563; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                Action Type</th>
                            <th
                                style="padding: 16px; font-weight: 600; color: #4b5563; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($historyData)): ?>
                            <tr>
                                <td colspan="5" style="padding: 40px 20px; text-align: center; color: #6b7280;">
                                    <div style="font-size: 3rem; color: #d1d5db; margin-bottom: 15px;"><i
                                            class="fas fa-history"></i></div>
                                    <h3 style="margin: 0 0 8px 0; color: #374151; font-size: 1.2rem;">No History Yet</h3>
                                    <p style="margin: 0; font-size: 0.95rem;">There is no interaction history for your
                                        products at the moment.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($historyData as $row): ?>
                                <tr style="border-bottom: 1px solid #e5e7eb; transition: background 0.2s;"
                                    onmouseover="this.style.background='#f9fafb'"
                                    onmouseout="this.style.background='transparent'">
                                    <td style="padding: 16px; color: #111827; font-weight: 500;">
                                        <?= htmlspecialchars($row['product_name']) ?>
                                    </td>
                                    <td style="padding: 16px; color: #4b5563;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <div
                                                style="width: 28px; height: 28px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem;">
                                                <?= strtoupper(substr($row['customer_name'], 0, 1)) ?>
                                            </div>
                                            <?= htmlspecialchars($row['customer_name']) ?>
                                        </div>
                                    </td>
                                    <td style="padding: 16px; color: #6b7280; font-size: 0.9rem;">
                                        <?= htmlspecialchars($row['customer_email']) ?>
                                    </td>
                                    <td style="padding: 16px;">
                                        <?php if ($row['action_type'] === 'Cart'): ?>
                                            <span
                                                style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; background: #eff6ff; color: #2563eb; border-radius: 999px; font-size: 0.75rem; font-weight: 600; border: 1px solid #bfdbfe;">
                                                <i class="fas fa-shopping-cart"></i> Added to Cart
                                            </span>
                                        <?php elseif ($row['action_type'] === 'Wishlist'): ?>
                                            <span
                                                style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; background: #fff1f2; color: #e11d48; border-radius: 999px; font-size: 0.75rem; font-weight: 600; border: 1px solid #fecdd3;">
                                                <i class="fas fa-heart"></i> Added to Wishlist
                                            </span>
                                        <?php elseif ($row['action_type'] === 'Order Placed'): ?>
                                            <div style="display: flex; flex-direction: column; gap: 5px;">
                                                <span
                                                    style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; background: #ecfdf5; color: #059669; border-radius: 999px; font-size: 0.75rem; font-weight: 600; border: 1px solid #a7f3d0;">
                                                    <i class="fas fa-check-circle"></i> Order Placed
                                                </span>
                                                <div style="font-size: 0.7rem; color: #6b7280; display: flex; align-items: center; gap: 4px; padding-left: 5px;">
                                                    <?php if ($row['payment_method'] === 'razorpay'): ?>
                                                        <i class="fas fa-credit-card"></i> Razorpay
                                                    <?php else: ?>
                                                        <i class="fas fa-money-bill-wave"></i> COD
                                                    <?php endif; ?>
                                                    <span style="color: #cbd5e1;">|</span>
                                                    <span style="color: <?= $row['payment_status'] === 'paid' ? '#059669' : '#d97706' ?>; font-weight: 600;">
                                                        <?= strtoupper($row['payment_status'] ?? 'PENDING') ?>
                                                    </span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 16px; color: #6b7280; font-size: 0.9rem;">
                                        <?= date('M j, Y, g:i A', strtotime($row['added_at'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>