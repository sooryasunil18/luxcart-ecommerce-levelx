<div style="display: flex; min-height: calc(100vh - 130px); background: #f8fafc;">
    <!-- Seller Sidebar (Full Height & Sticky) -->
    <aside style="width: 260px; background: #fff; border-right: 1px solid #e5e7eb; flex-shrink: 0; position: sticky; top: 0; height: calc(100vh - 130px); overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; color: #111827; font-size: 1.1rem;"><i class="fas fa-store" style="color:#0d9488; margin-right:8px;"></i> Seller Panel</h3>
        </div>
        <div class="list-group" style="padding: 15px;">
            <a href="<?= BASE_URL ?>/seller" class="list-group-item" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
                <i class="fas fa-home" style="width: 20px; text-align: center;"></i> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/seller/products" class="list-group-item" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
                <i class="fas fa-box" style="width: 20px; text-align: center;"></i> My Products
            </a>
            <a href="<?= BASE_URL ?>/seller/customer-history" class="list-group-item" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; color: #4b5563; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
                <i class="fas fa-history" style="width: 20px; text-align: center;"></i> Customer History
            </a>
            <a href="<?= BASE_URL ?>/seller/products/create" class="list-group-item <?= !$isEdit ? 'active' : '' ?>" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; <?= !$isEdit ? 'background: #0d9488; color: #fff; font-weight: 500;' : 'color: #4b5563;' ?> text-decoration: none;">
                <i class="fas fa-plus" style="width: 20px; text-align: center;"></i> Add Product
            </a>
        </div>
    </aside>

    <!-- Seller Content Area -->
    <main style="flex: 1; padding: 40px; overflow-y: auto;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <?php if (isset($_SESSION['error'])): ?>
                    <div
                        style="background: #fef2f2; color: #b91c1c; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #ef4444;">
                        <?= htmlspecialchars($_SESSION['error']);
                        unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <div style="background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #eee;">
                    <h2
                        style="margin-bottom: 25px; font-size: 1.3rem; color: #1a1a2e; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                        Product Details</h2>

                    <form action="<?= BASE_URL ?>/seller/products/save" method="POST" enctype="multipart/form-data"
                        style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <?php if ($isEdit): ?>
                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                            <!-- Keep old image name if not changed -->
                            <input type="hidden" name="old_image" value="<?= htmlspecialchars($product['image']) ?>">
                        <?php endif; ?>

                        <!-- Name -->
                        <div style="grid-column: span 2;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Product
                                Name <span style="color: #dc2626;">*</span></label>
                            <input type="text" name="name" id="productName"
                                value="<?= htmlspecialchars($product['name']) ?>" required
                                style="width: 100%; padding: 10px 15px; border: 1px solid #d1d5db; border-radius: 6px; font-family: inherit;">
                        </div>

                        <!-- Slug -->
                        <div style="grid-column: span 2;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Product
                                Slug-URL <span style="color: #dc2626;">*</span></label>
                            <input type="text" name="slug" id="productSlug"
                                value="<?= htmlspecialchars($product['slug']) ?>" required
                                placeholder="e.g. blue-denim-jeans"
                                style="width: 100%; padding: 10px 15px; border: 1px solid #d1d5db; border-radius: 6px; font-family: inherit;">
                            <small style="color: #6b7280; display: block; margin-top: 4px;">Only lowercase letters,
                                numbers, and hyphens.</small>
                        </div>

                        <!-- Category -->
                        <div style="grid-column: span 2;">
                            <label
                                style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Category
                                <span style="color: #dc2626;">*</span></label>
                            <select name="category_id" required
                                style="width: 100%; padding: 10px 15px; border: 1px solid #d1d5db; border-radius: 6px; font-family: inherit; background: #fff;">
                                <option value="">Select a Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= $product['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Price -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Regular
                                Price (₹) <span style="color: #dc2626;">*</span></label>
                            <input type="number" step="0.01" min="0" name="price"
                                value="<?= $product['price'] ? htmlspecialchars($product['price']) : '' ?>" required
                                style="width: 100%; padding: 10px 15px; border: 1px solid #d1d5db; border-radius: 6px; font-family: inherit;">
                        </div>

                        <!-- Sale Price -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Sale
                                Price (₹) <span
                                    style="color: #6b7280; font-weight: normal; font-size: 0.85rem;">(Optional)</span></label>
                            <input type="number" step="0.01" min="0" name="sale_price"
                                value="<?= $product['sale_price'] ? htmlspecialchars($product['sale_price']) : '' ?>"
                                style="width: 100%; padding: 10px 15px; border: 1px solid #d1d5db; border-radius: 6px; font-family: inherit;">
                        </div>

                        <!-- Stock -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Stock
                                Quantity <span style="color: #dc2626;">*</span></label>
                            <input type="number" min="0" name="stock"
                                value="<?= $product['stock'] !== '' ? htmlspecialchars($product['stock']) : '10' ?>"
                                required
                                style="width: 100%; padding: 10px 15px; border: 1px solid #d1d5db; border-radius: 6px; font-family: inherit;">
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Product Image <span style="color: #6b7280; font-weight: normal; font-size: 0.85rem;">(Optional)</span></label>
                            <?php if ($isEdit && !empty($product['image'])): ?>
                                <div style="margin-bottom: 10px; display: flex; align-items: center; gap: 15px;">
                                    <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($product['image']) ?>" alt="Current Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #eee;">
                                    <span style="font-size: 0.85rem; color: #6b7280; word-break: break-all;">Current: <?= htmlspecialchars($product['image']) ?></span>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="image" accept="image/*" style="width: 100%; padding: 8px 15px; border: 1px solid #d1d5db; border-radius: 6px; font-family: inherit; background: #f9fafb;">
                        </div>

                        <!-- Description -->
                        <div style="grid-column: span 2;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Product
                                Description</label>
                            <textarea name="description" rows="5"
                                style="width: 100%; padding: 10px 15px; border: 1px solid #d1d5db; border-radius: 6px; font-family: inherit; resize: vertical;"><?= htmlspecialchars($product['description']) ?></textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div
                            style="grid-column: span 2; display: flex; gap: 15px; justify-content: flex-end; margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px;">
                            <a href="<?= BASE_URL ?>/seller/products" class="btn btn-outline">Cancel</a>
                            <button type="submit" class="btn btn-primary"
                                style="padding: 12px 30px; font-size: 1rem;"><i class="fas fa-save"></i>
                                <?= $isEdit ? 'Save Changes' : 'Create Product' ?>
                            </button>
                        </div>
                    </form>
                </div>
        </div>
    </main>
</div>

<script>
    // Simple script to auto-generate slug from name if not edit mode
    const nameInput = document.getElementById('productName');
    const slugInput = document.getElementById('productSlug');
    
    <?php if (!$isEdit): ?>
            nameInput.addEventListener('input', function () {
                if (document.activeElement === nameInput) {
                    let slug = this.value.toLowerCase()
                        .replace(/[^\w\s-]/g, '') // remove special chars
                        .replace(/\s+/g, '-')     // replace spaces with hyphens
                        .replace(/-+/g, '-');     // remove consecutive hyphens
                    slugInput.value = slug;
                }
            });
    <?php endif; ?>
</script>