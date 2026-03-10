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
            <a href="<?= BASE_URL ?>/admin" class="list-group-item active"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; background: #0d9488; color: #fff; font-weight: 500; text-decoration: none;">
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
            <a href="<?= BASE_URL ?>/products" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;">
                <i class="fas fa-box" style="width: 20px; text-align: center;"></i> View All Products
            </a>
        </div>
    </aside>

    <!-- Admin Content Area -->
    <main style="flex: 1; padding: 40px; overflow-y: auto;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <!-- Welcome Header -->
            <div
                style="background: #fff; padding: 24px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #e5e7eb;">
                <h2 style="margin: 0 0 8px 0; font-size: 1.5rem; color: #111827;">Welcome back,
                    <?= htmlspecialchars($_SESSION['user_name']) ?>!</h2>
                <p style="margin: 0; color: #6b7280; font-size: 0.95rem;">You are logged in as an Administrator with
                    full access to manage users and categories.</p>
            </div>

            <!-- Stats Grid -->
            <h3 style="margin-bottom: 20px; font-size: 1.3rem; color: #111827;">Site Overview</h3>

            <div class="stats-grid"
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                <!-- Stat Card 1 - Users -->
                <div class="stat-card"
                    style="background: #fff; padding: 30px 20px; border-radius: 12px; border: 1px solid #e5e7eb; text-align: center;">
                    <div class="stat-icon" style="font-size: 2.5rem; color: #0d9488; margin-bottom: 15px;">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 style="font-size: 2rem; margin-bottom: 5px; color: #111827;"><?= $stats['users'] ?></h3>
                    <p style="color: #6b7280; font-size: 0.95rem; margin: 0;">Total Users</p>
                </div>

                <!-- Stat Card 2 - Products -->
                <div class="stat-card"
                    style="background: #fff; padding: 30px 20px; border-radius: 12px; border: 1px solid #e5e7eb; text-align: center;">
                    <div class="stat-icon" style="font-size: 2.5rem; color: #eab308; margin-bottom: 15px;">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <h3 style="font-size: 2rem; margin-bottom: 5px; color: #111827;"><?= $stats['products'] ?></h3>
                    <p style="color: #6b7280; font-size: 0.95rem; margin: 0;">Total Products</p>
                </div>

                <!-- Stat Card 3 - Categories -->
                <div class="stat-card"
                    style="background: #fff; padding: 30px 20px; border-radius: 12px; border: 1px solid #e5e7eb; text-align: center;">
                    <div class="stat-icon" style="font-size: 2.5rem; color: #f43f5e; margin-bottom: 15px;">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h3 style="font-size: 2rem; margin-bottom: 5px; color: #111827;"><?= $stats['categories'] ?></h3>
                    <p style="color: #6b7280; font-size: 0.95rem; margin: 0;">Categories</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div style="background: #fff; padding: 24px; border-radius: 8px; border: 1px solid #e5e7eb;">
                <h4 style="margin: 0 0 16px 0; font-size: 1.1rem; color: #111827;">Quick Actions</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                    <a href="<?= BASE_URL ?>/admin/users"
                        style="display: block; padding: 14px 18px; background: #f3f4f6; border-radius: 6px; text-decoration: none; color: #111827; font-weight: 500; transition: background 0.2s;">
                        <i class="fas fa-user-plus" style="margin-right: 8px; color: #0d9488;"></i> Manage Users
                    </a>
                    <a href="<?= BASE_URL ?>/admin/categories"
                        style="display: block; padding: 14px 18px; background: #f3f4f6; border-radius: 6px; text-decoration: none; color: #111827; font-weight: 500; transition: background 0.2s;">
                        <i class="fas fa-folder-plus" style="margin-right: 8px; color: #0d9488;"></i> Add Category
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>