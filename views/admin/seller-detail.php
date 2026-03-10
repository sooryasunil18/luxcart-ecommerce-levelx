<div style="display: flex; min-height: calc(100vh - 73px); background: #f8fafc;">
    <!-- Admin Sidebar -->
    <aside
        style="width: 260px; background: #fff; border-right: 1px solid #e5e7eb; flex-shrink: 0; position: sticky; top: 0; height: calc(100vh - 73px); overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; color: #111827; font-size: 1.1rem;"><i class="fas fa-shield-alt"
                    style="color:#0d9488; margin-right:8px;"></i> Admin Panel</h3>
            <p style="margin: 5px 0 0 0; font-size: 0.85rem; color: #6b7280;">Administrator</p>
        </div>
        <div class="list-group" style="padding: 15px;">
            <a href="<?= BASE_URL ?>/admin" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none;">
                <i class="fas fa-home" style="width: 20px; text-align: center;"></i> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/admin/users" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none;">
                <i class="fas fa-users" style="width: 20px; text-align: center;"></i> Manage Users
            </a>
            <a href="<?= BASE_URL ?>/admin/sellers" class="list-group-item active"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; background: #0d9488; color: #fff; font-weight: 500; text-decoration: none;">
                <i class="fas fa-store" style="width: 20px; text-align: center;"></i> Seller Management
            </a>
            <a href="<?= BASE_URL ?>/admin/categories" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none;">
                <i class="fas fa-list" style="width: 20px; text-align: center;"></i> Manage Categories
            </a>
            <a href="<?= BASE_URL ?>/products" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none;">
                <i class="fas fa-box" style="width: 20px; text-align: center;"></i> View All Products
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main style="flex: 1; padding: 30px; overflow-y: auto;">
        <!-- Back Button -->
        <a href="<?= BASE_URL ?>/admin/sellers"
            style="display: inline-flex; align-items: center; gap: 6px; color: #4b5563; text-decoration: none; font-size: 0.9rem; margin-bottom: 20px;">
            <i class="fas fa-arrow-left"></i> Back to Seller Management
        </a>

        <!-- Seller Information Table -->
        <div style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 24px;">
            <h2 style="margin-bottom: 20px; font-size: 1.3rem; color: #1a1a2e; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <i class="fas fa-user-tie" style="color: #0d9488; margin-right: 8px;"></i> Seller Information
            </h2>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563; width: 200px;">Field</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px 15px; color: #6b7280; font-weight: 500;">Seller ID</td>
                            <td style="padding: 12px 15px; font-weight: 600; color: #111827;">#<?= $seller['id'] ?></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px 15px; color: #6b7280; font-weight: 500;">Name</td>
                            <td style="padding: 12px 15px; font-weight: 600; color: #111827;"><?= htmlspecialchars($seller['name']) ?></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px 15px; color: #6b7280; font-weight: 500;">Email</td>
                            <td style="padding: 12px 15px; font-weight: 600; color: #111827;"><?= htmlspecialchars($seller['email']) ?></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px 15px; color: #6b7280; font-weight: 500;">Role</td>
                            <td style="padding: 12px 15px;">
                                <span style="display: inline-block; background: #eff6ff; color: #2563eb; padding: 4px 12px; border-radius: 999px; font-size: 0.78rem; font-weight: 600;"><?= ucfirst($seller['role']) ?></span>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px 15px; color: #6b7280; font-weight: 500;">Account Status</td>
                            <td style="padding: 12px 15px;">
                                <?php if ($seller['is_active']): ?>
                                    <span style="display: inline-flex; align-items: center; gap: 5px; background: #ecfdf5; color: #059669; padding: 5px 12px; border-radius: 999px; font-size: 0.78rem; font-weight: 600;">
                                        <i class="fas fa-circle" style="font-size: 0.45rem;"></i> Active
                                    </span>
                                <?php else: ?>
                                    <span style="display: inline-flex; align-items: center; gap: 5px; background: #fef2f2; color: #dc2626; padding: 5px 12px; border-radius: 999px; font-size: 0.78rem; font-weight: 600;">
                                        <i class="fas fa-circle" style="font-size: 0.45rem;"></i> Inactive
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px 15px; color: #6b7280; font-weight: 500;">Seller Status</td>
                            <td style="padding: 12px 15px;">
                                <?php
                                    $sellerStatus = $seller['seller_status'] ?? 'pending';
                                    if ($sellerStatus === 'active') {
                                        echo '<span style="display:inline-flex;align-items:center;gap:5px;background:#ecfdf5;color:#059669;padding:5px 12px;border-radius:999px;font-size:0.78rem;font-weight:600;"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Active</span>';
                                    } elseif ($sellerStatus === 'pending') {
                                        echo '<span style="display:inline-flex;align-items:center;gap:5px;background:#fffbeb;color:#d97706;padding:5px 12px;border-radius:999px;font-size:0.78rem;font-weight:600;"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Pending</span>';
                                    } else {
                                        echo '<span style="display:inline-flex;align-items:center;gap:5px;background:#fef2f2;color:#dc2626;padding:5px 12px;border-radius:999px;font-size:0.78rem;font-weight:600;"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Disabled</span>';
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px 15px; color: #6b7280; font-weight: 500;">Registration Date</td>
                            <td style="padding: 12px 15px; font-weight: 600; color: #111827;"><?= date('M j, Y', strtotime($seller['created_at'])) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Seller Products -->
        <div style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #eee;">
            <h2
                style="margin-bottom: 20px; font-size: 1.3rem; color: #1a1a2e; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <i class="fas fa-boxes" style="color: #0d9488; margin-right: 8px;"></i> Seller Products
                <span style="font-size: 0.85rem; font-weight: 400; color: #6b7280; margin-left: 8px;">(
                    <?= count($sellerProducts) ?> products)
                </span>
            </h2>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Product Name</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Category</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Price</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($sellerProducts)): ?>
                            <tr>
                                <td colspan="4" style="padding: 30px 15px; text-align: center; color: #9ca3af;">
                                    <i class="fas fa-box-open"
                                        style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                                    This seller has no products yet.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($sellerProducts as $product): ?>
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 12px 15px; font-weight: 500; color: #111827;">
                                        <a href="<?= BASE_URL ?>/product/<?= $product['slug'] ?>"
                                            style="color: #111827; text-decoration: none;" title="View Product">
                                            <?= htmlspecialchars($product['name']) ?>
                                        </a>
                                    </td>
                                    <td style="padding: 12px 15px; color: #4b5563;">
                                        <?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?>
                                    </td>
                                    <td style="padding: 12px 15px; color: #111827; font-weight: 500;">
                                        <?php if ($product['sale_price']): ?>
                                            <span>₹
                                                <?= number_format($product['sale_price'], 2) ?>
                                            </span>
                                            <span
                                                style="text-decoration: line-through; color: #9ca3af; font-size: 0.8rem; margin-left: 4px;">₹
                                                <?= number_format($product['price'], 2) ?>
                                            </span>
                                        <?php else: ?>
                                            ₹
                                            <?= number_format($product['price'], 2) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 12px 15px;">
                                        <?php if ($product['stock'] > 0): ?>
                                            <span style="color: #059669; font-weight: 500;">
                                                <?= $product['stock'] ?>
                                            </span>
                                        <?php else: ?>
                                            <span style="color: #dc2626; font-weight: 500;">Out of Stock</span>
                                        <?php endif; ?>
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