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
            <a href="<?= BASE_URL ?>/admin/orders" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none;">
                <i class="fas fa-shopping-cart" style="width: 20px; text-align: center;"></i> Manage Orders
            </a>
            <a href="<?= BASE_URL ?>/products" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none;">
                <i class="fas fa-box" style="width: 20px; text-align: center;"></i> View All Products
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main style="flex: 1; padding: 30px; overflow-y: auto;">
        <?php if (isset($_SESSION['success'])): ?>
            <div
                style="background: #ecfdf5; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #10b981;">
                <?= htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div
                style="background: #fef2f2; color: #dc2626; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #ef4444;">
                <?= htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #eee;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; flex-wrap: wrap; gap: 12px;">
                <h2 style="margin: 0; font-size: 1.3rem; color: #1a1a2e;">Seller Management</h2>
                <!-- Search Bar -->
                <form method="GET" action="<?= BASE_URL ?>/admin/sellers" style="display: flex; gap: 8px;">
                    <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                        placeholder="Search by name or email..."
                        style="padding: 8px 14px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.85rem; width: 260px;">
                    <button type="submit"
                        style="padding: 8px 16px; background: #0d9488; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 500;">
                        <i class="fas fa-search"></i> Search
                    </button>
                </form>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Seller ID</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Seller Name</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Email</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Status</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Registered Date</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($sellers)): ?>
                            <tr>
                                <td colspan="6" style="padding: 30px 15px; text-align: center; color: #9ca3af;">
                                    <i class="fas fa-store-slash"
                                        style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                                    No sellers found.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($sellers as $seller): ?>
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 12px 15px; color: #6b7280;">#
                                        <?= $seller['id'] ?>
                                    </td>
                                    <td style="padding: 12px 15px; font-weight: 500; color: #111827;">
                                        <?= htmlspecialchars($seller['name']) ?>
                                    </td>
                                    <td style="padding: 12px 15px; color: #4b5563;">
                                        <?= htmlspecialchars($seller['email']) ?>
                                    </td>
                                    <td style="padding: 12px 15px;">
                                        <?php
                                        $status = $seller['seller_status'] ?? 'pending';
                                        if ($status === 'active') {
                                            echo '<span style="display:inline-flex;align-items:center;gap:5px;background:#ecfdf5;color:#059669;padding:5px 12px;border-radius:999px;font-size:0.78rem;font-weight:600;"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Active</span>';
                                        } elseif ($status === 'pending') {
                                            echo '<span style="display:inline-flex;align-items:center;gap:5px;background:#fffbeb;color:#d97706;padding:5px 12px;border-radius:999px;font-size:0.78rem;font-weight:600;"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Pending</span>';
                                        } else {
                                            echo '<span style="display:inline-flex;align-items:center;gap:5px;background:#fef2f2;color:#dc2626;padding:5px 12px;border-radius:999px;font-size:0.78rem;font-weight:600;"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Disabled</span>';
                                        }
                                        ?>
                                    </td>
                                    <td style="padding: 12px 15px; color: #6b7280; font-size: 0.85rem;">
                                        <?= date('M j, Y', strtotime($seller['created_at'])) ?>
                                    </td>
                                    <td style="padding: 12px 15px;">
                                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                            <!-- View -->
                                            <a href="<?= BASE_URL ?>/admin/seller/<?= $seller['id'] ?>" title="View Seller"
                                                style="display:inline-flex;align-items:center;gap:4px;padding:6px 10px;background:#3b82f6;color:#fff;border-radius:4px;text-decoration:none;font-size:0.78rem;font-weight:500;">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <!-- Approve -->
                                            <?php if ($status !== 'active'): ?>
                                                <form action="<?= BASE_URL ?>/admin/sellers" method="POST" style="margin:0;">
                                                    <input type="hidden" name="action" value="approve">
                                                    <input type="hidden" name="seller_id" value="<?= $seller['id'] ?>">
                                                    <button type="submit" title="Approve Seller"
                                                        style="display:inline-flex;align-items:center;gap:4px;padding:6px 10px;background:#10b981;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:0.78rem;font-weight:500;">
                                                        <i class="fas fa-check-circle"></i> Approve
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <!-- Disable -->
                                            <?php if ($status !== 'disabled'): ?>
                                                <form action="<?= BASE_URL ?>/admin/sellers" method="POST" style="margin:0;">
                                                    <input type="hidden" name="action" value="disable">
                                                    <input type="hidden" name="seller_id" value="<?= $seller['id'] ?>">
                                                    <button type="submit" title="Disable Seller"
                                                        style="display:inline-flex;align-items:center;gap:4px;padding:6px 10px;background:#f59e0b;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:0.78rem;font-weight:500;">
                                                        <i class="fas fa-ban"></i> Disable
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <!-- Delete -->
                                            <form action="<?= BASE_URL ?>/admin/sellers" method="POST" style="margin:0;"
                                                onsubmit="return confirm('Are you sure you want to delete this seller?');">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="seller_id" value="<?= $seller['id'] ?>">
                                                <button type="submit" title="Delete Seller"
                                                    style="display:inline-flex;align-items:center;gap:4px;padding:6px 10px;background:#fff;color:#dc2626;border:1px solid #dc2626;border-radius:4px;cursor:pointer;font-size:0.78rem;font-weight:500;">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
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