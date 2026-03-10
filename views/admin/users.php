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
            <a href="<?= BASE_URL ?>/admin/users" class="list-group-item active"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; background: #0d9488; color: #fff; font-weight: 500; text-decoration: none;">
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
            <a href="<?= BASE_URL ?>/products" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;">
                <i class="fas fa-box" style="width: 20px; text-align: center;"></i> View All Products
            </a>

        </div>
    </aside>

    <!-- Main Content Area -->
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
            <h2
                style="margin-bottom: 20px; font-size: 1.3rem; color: #1a1a2e; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                Registered Users</h2>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">ID</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Name</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Email</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Role</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Status</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Joined</th>
                            <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 12px 15px; color: #6b7280;">#
                                    <?= $user['id'] ?>
                                </td>
                                <td style="padding: 12px 15px; font-weight: 500; color: #111827;">
                                    <?= htmlspecialchars($user['name']) ?>
                                </td>
                                <td style="padding: 12px 15px; color: #4b5563;">
                                    <?= htmlspecialchars($user['email']) ?>
                                </td>
                                <td style="padding: 12px 15px;">
                                    <?php if ($user['role'] === 'admin'): ?>
                                        <span
                                            style="background: #fef2f2; color: #dc2626; padding: 4px 8px; border-radius: 999px; font-size: 0.75rem; font-weight: 600;">Admin</span>
                                    <?php elseif ($user['role'] === 'seller'): ?>
                                        <span
                                            style="background: #eff6ff; color: #2563eb; padding: 4px 8px; border-radius: 999px; font-size: 0.75rem; font-weight: 600;">Seller</span>
                                    <?php else: ?>
                                        <span
                                            style="background: #f3f4f6; color: #4b5563; padding: 4px 8px; border-radius: 999px; font-size: 0.75rem; font-weight: 600;">Customer</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 12px 15px;">
                                    <?php if ($user['is_active']): ?>
                                        <span
                                            style="display: inline-flex; align-items: center; gap: 5px; background: #ecfdf5; color: #059669; padding: 5px 12px; border-radius: 999px; font-size: 0.78rem; font-weight: 600;">
                                            <i class="fas fa-circle" style="font-size: 0.45rem;"></i> Active
                                        </span>
                                    <?php else: ?>
                                        <span
                                            style="display: inline-flex; align-items: center; gap: 5px; background: #fef2f2; color: #dc2626; padding: 5px 12px; border-radius: 999px; font-size: 0.78rem; font-weight: 600;">
                                            <i class="fas fa-circle" style="font-size: 0.45rem;"></i> Inactive
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 12px 15px; color: #6b7280; font-size: 0.85rem;">
                                    <?= date('M j, Y', strtotime($user['created_at'])) ?>
                                </td>
                                <td style="padding: 12px 15px;">
                                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                        <!-- View Button -->
                                        <a href="<?= BASE_URL ?>/admin/users?id=<?= $user['id'] ?>"
                                            style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 10px; background: #3b82f6; color: #fff; border-radius: 4px; text-decoration: none; font-size: 0.8rem; font-weight: 500; transition: background 0.2s;"
                                            title="View User Details">
                                            <i class="fas fa-eye"></i> View
                                        </a>

                                        <?php if ($user['id'] != 1): // Don't allow modifying the main admin ?>
                                            <!-- Activate/Deactivate Button -->
                                            <?php if ($user['is_active']): ?>
                                                <form action="<?= BASE_URL ?>/admin/update-user-status" method="POST"
                                                    style="display: inline;">
                                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                    <input type="hidden" name="is_active" value="0">
                                                    <button type="submit"
                                                        style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 10px; background: #ef4444; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 0.8rem; font-weight: 500; transition: background 0.2s;"
                                                        title="Deactivate User"
                                                        onclick="return confirm('Are you sure you want to deactivate this user?');">
                                                        <i class="fas fa-ban"></i> Deactivate
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <form action="<?= BASE_URL ?>/admin/update-user-status" method="POST"
                                                    style="display: inline;">
                                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                    <input type="hidden" name="is_active" value="1">
                                                    <button type="submit"
                                                        style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 10px; background: #10b981; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 0.8rem; font-weight: 500; transition: background 0.2s;"
                                                        title="Activate User">
                                                        <i class="fas fa-check-circle"></i> Activate
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span
                                                style="color: #9ca3af; font-size: 0.8rem; font-style: italic;">Protected</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>
</div>
</div>
</section>