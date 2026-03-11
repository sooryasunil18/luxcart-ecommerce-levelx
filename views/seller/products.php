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
            <a href="<?= BASE_URL ?>/seller/products" class="list-group-item active"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; background: #0d9488; color: #fff; font-weight: 500; text-decoration: none;">
                <i class="fas fa-box" style="width: 20px; text-align: center;"></i> My Products
            </a>
            <a href="<?= BASE_URL ?>/seller/customer-history" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;"
                onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
                <i class="fas fa-history" style="width: 20px; text-align: center;"></i> Customer History
            </a>
            <a href="<?= BASE_URL ?>/seller/orders" class="list-group-item"
                style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;">
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
            <?php if (isset($_SESSION['success'])): ?>
                <div
                    style="background: #ecfdf5; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #10b981;">
                    <?= htmlspecialchars($_SESSION['success']);
                    unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <div style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #eee;">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px;">
                    <h2 style="font-size: 1.3rem; color: #1a1a2e; margin: 0;">All Products</h2>
                    <a href="<?= BASE_URL ?>/seller/products/create" class="btn btn-primary btn-sm"><i
                            class="fas fa-plus"></i> Add New Product</a>
                </div>

                <?php if (empty($products)): ?>
                    <div style="text-align: center; padding: 60px 0; color: #6b7280;">
                        <i class="fas fa-box-open" style="font-size: 4rem; margin-bottom: 15px; color: #d1d5db;"></i>
                        <h3 style="color: #4b5563; margin-bottom: 10px;">No Products Found</h3>
                        <p>You haven't added any products to your store yet.</p>
                        <a href="<?= BASE_URL ?>/seller/products/create" class="btn btn-primary"
                            style="margin-top: 15px;">Add Your First Product</a>
                    </div>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left;">
                            <thead>
                                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                                    <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Image</th>
                                    <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Product Details
                                    </th>
                                    <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Price</th>
                                    <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Stock</th>
                                    <th style="padding: 12px 15px; font-weight: 600; color: #4b5563;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr style="border-bottom: 1px solid #e5e7eb;">
                                        <td style="padding: 12px 15px;">
                                            <?php if (!empty($product['image'])): ?>
                                                <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($product['image']) ?>"
                                                    style="width: 50px; height: 50px; border-radius: 4px; object-fit: cover;">
                                            <?php else: ?>
                                                <div
                                                    style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 1.2rem;">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding: 12px 15px;">
                                            <div style="font-weight: 600; color: #111827; margin-bottom: 4px;">
                                                <?= htmlspecialchars($product['name']) ?>
                                            </div>
                                            <div style="font-size: 0.75rem; color: #6b7280;">Category:
                                                <?= htmlspecialchars($product['category_name']) ?>
                                            </div>
                                            <div style="font-size: 0.75rem; color: #6b7280;">Added:
                                                <?= date('M j, Y', strtotime($product['created_at'])) ?>
                                            </div>
                                        </td>
                                        <td style="padding: 12px 15px;">
                                            <div style="color: #111827; font-weight: 500;">₹
                                                <?= number_format($product['price'], 2) ?>
                                            </div>
                                            <?php if ($product['sale_price']): ?>
                                                <div style="font-size: 0.75rem; color: #059669;">Sale: ₹
                                                    <?= number_format($product['sale_price'], 2) ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding: 12px 15px;">
                                            <?php if ($product['stock'] > 10): ?>
                                                <span
                                                    style="background: #ecfdf5; color: #065f46; padding: 4px 8px; border-radius: 999px; font-size: 0.75rem; font-weight: 600;">
                                                    <?= $product['stock'] ?> in stock
                                                </span>
                                            <?php elseif ($product['stock'] > 0): ?>
                                                <span
                                                    style="background: #fffbeb; color: #b45309; padding: 4px 8px; border-radius: 999px; font-size: 0.75rem; font-weight: 600;">Low:
                                                    <?= $product['stock'] ?> left
                                                </span>
                                            <?php else: ?>
                                                <span
                                                    style="background: #fef2f2; color: #dc2626; padding: 4px 8px; border-radius: 999px; font-size: 0.75rem; font-weight: 600;">Out
                                                    of Stock</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding: 12px 15px; display: flex; gap: 8px;">
                                            <a href="<?= BASE_URL ?>/product/<?= $product['slug'] ?>"
                                                class="btn btn-outline btn-sm" style="padding: 6px 10px; font-size: 0.8rem;"
                                                target="_blank"><i class="fas fa-eye"></i></a>
                                            <a href="<?= BASE_URL ?>/seller/products/edit/<?= $product['id'] ?>"
                                                class="btn btn-primary btn-sm" style="padding: 6px 10px; font-size: 0.8rem;"><i
                                                    class="fas fa-edit"></i></a>
                                            <form action="<?= BASE_URL ?>/seller/products/delete" method="POST"
                                                onsubmit="return confirm('WARNING: Are you sure you want to delete this product? This action cannot be undone.');"
                                                style="margin: 0;">
                                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                                <button type="submit" class="btn btn-outline btn-sm"
                                                    style="padding: 6px 10px; font-size: 0.8rem; color: #dc2626; border-color: #dc2626;"><i
                                                        class="fas fa-trash-alt"></i></button>
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