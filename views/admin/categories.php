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
            <a href="<?= BASE_URL ?>/admin/categories" class="list-group-item active"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; background: #0d9488; color: #fff; font-weight: 500; text-decoration: none;">
                <i class="fas fa-list" style="width: 20px; text-align: center;"></i> Manage Categories
            </a>
            <a href="<?= BASE_URL ?>/admin/orders" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;">
                <i class="fas fa-shopping-cart" style="width: 20px; text-align: center;"></i> Manage Orders
            </a>
            <a href="<?= BASE_URL ?>/products" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;">
                <i class="fas fa-box" style="width: 20px; text-align: center;"></i> View All Products
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main style="flex: 1; padding: 30px; overflow-y: auto;">
        <?php if (isset($_SESSION['error'])): ?>
            <div
                style="background: #fef2f2; color: #b91c1c; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #ef4444;">
                <?= htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1fr 300px; gap: 24px;">
            <!-- Categories List -->
            <div style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #eee;">
                <h2
                    style="margin-bottom: 20px; font-size: 1.3rem; color: #1a1a2e; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                    Existing Categories</h2>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Name</th>
                                <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Category URL Name</th>
                                <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $cat): ?>
                                <!-- Display Row -->
                                <tr style="border-bottom: 1px solid #e5e7eb;" id="row-<?= $cat['id'] ?>">
                                    <td style="padding: 12px 15px; font-weight: 500; color: #111827;">
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </td>
                                    <td style="padding: 12px 15px; color: #4b5563;">
                                        <?= htmlspecialchars($cat['category_url_name']) ?>
                                    </td>
                                    <td style="padding: 12px 15px;">
                                        <div style="display: flex; gap: 8px;">
                                            <button type="button" onclick="toggleEditForm(<?= $cat['id'] ?>)"
                                                style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; background: #3b82f6; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 0.8rem; font-weight: 500;">
                                                <i class="fas fa-pen" style="font-size: 0.7rem;"></i> Edit
                                            </button>
                                            <form action="<?= BASE_URL ?>/admin/categories" method="POST"
                                                onsubmit="return confirm('Delete this category?');" style="margin: 0;">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                                <button type="submit"
                                                    style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; background: #fff; color: #dc2626; border: 1px solid #dc2626; border-radius: 4px; cursor: pointer; font-size: 0.8rem; font-weight: 500;">
                                                    <i class="fas fa-trash" style="font-size: 0.7rem;"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Edit Form Row (hidden by default) -->
                                <tr id="edit-row-<?= $cat['id'] ?>"
                                    style="display: none; background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                    <td colspan="3" style="padding: 16px 15px;">
                                        <form action="<?= BASE_URL ?>/admin/categories" method="POST"
                                            style="display: flex; align-items: flex-end; gap: 16px; flex-wrap: wrap;">
                                            <input type="hidden" name="action" value="update">
                                            <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                            <div>
                                                <label
                                                    style="display: block; margin-bottom: 4px; font-size: 0.8rem; font-weight: 500; color: #374151;">Name</label>
                                                <input type="text" name="name" value="<?= htmlspecialchars($cat['name']) ?>"
                                                    required
                                                    style="padding: 8px 10px; border: 1px solid #d1d5db; border-radius: 6px; width: 180px; font-size: 0.9rem;">
                                            </div>
                                            <div>
                                                <label
                                                    style="display: block; margin-bottom: 4px; font-size: 0.8rem; font-weight: 500; color: #374151;">Category
                                                    URL Name</label>
                                                <input type="text" name="category_url_name"
                                                    value="<?= htmlspecialchars($cat['category_url_name']) ?>" required
                                                    style="padding: 8px 10px; border: 1px solid #d1d5db; border-radius: 6px; width: 180px; font-size: 0.9rem;">
                                            </div>
                                            <div style="display: flex; gap: 8px;">
                                                <button type="submit"
                                                    style="padding: 8px 16px; background: #0d9488; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 500;">
                                                    <i class="fas fa-check" style="margin-right: 4px;"></i> Save
                                                </button>
                                                <button type="button" onclick="toggleEditForm(<?= $cat['id'] ?>)"
                                                    style="padding: 8px 16px; background: #f3f4f6; color: #4b5563; border: 1px solid #d1d5db; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 500;">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add New Category -->
            <div
                style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #eee; height: fit-content;">
                <h2
                    style="margin-bottom: 20px; font-size: 1.3rem; color: #1a1a2e; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                    Add Category</h2>

                <form action="<?= BASE_URL ?>/admin/categories" method="POST"
                    style="display: flex; flex-direction: column; gap: 16px;">
                    <input type="hidden" name="action" value="add">

                    <div>
                        <label
                            style="display: block; margin-bottom: 6px; font-size: 0.9rem; font-weight: 500; color: #374151;">Category
                            Name</label>
                        <input type="text" name="name" required placeholder="e.g. Home Decor"
                            style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px;">
                    </div>

                    <div>
                        <label
                            style="display: block; margin-bottom: 6px; font-size: 0.9rem; font-weight: 500; color: #374151;">Category
                            URL Name</label>
                        <input type="text" name="category_url_name" required placeholder="e.g. home-decor"
                            style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px;">
                        <span style="display: block; margin-top: 4px; font-size: 0.75rem; color: #6b7280;">Only
                            lowercase letters and hyphens.</span>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>
</div>
</div>
</div>
</section>

<script>
    function toggleEditForm(id) {
        const editRow = document.getElementById('edit-row-' + id);
        if (editRow.style.display === 'none') {
            document.querySelectorAll('[id^="edit-row-"]').forEach(row => row.style.display = 'none');
            editRow.style.display = 'table-row';
        } else {
            editRow.style.display = 'none';
        }
    }
</script>