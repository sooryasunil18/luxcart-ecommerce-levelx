<!-- Customer wishlist.php (Beginner Friendly Design) -->
<div style="display: flex; min-height: calc(100vh - 130px); background: #f8fafc; font-family: 'Inter', Arial, sans-serif; line-height: 1.6;">
    <!-- Simple Sidebar -->
    <aside style="width: 250px; background: #fff; border-right: 1px solid #e5e7eb; flex-shrink: 0;">
        <div style="padding: 30px 20px; text-align: center; border-bottom: 2px solid #e5e7eb;">
            <h3 style="margin: 0; font-size: 1.1rem; color: #111827; font-weight: 700;">Hello, <?= htmlspecialchars(explode(' ', trim($_SESSION['user_name']))[0]) ?>!</h3>
        </div>
        <nav style="padding: 20px;">
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="margin-bottom: 10px;">
                    <a href="<?= BASE_URL ?>/account" style="display: block; padding: 12px 15px; border-radius: 8px; color: #4b5563; text-decoration: none; font-weight: 500; font-size: 1rem;">
                        <i class="fas fa-th-large" style="margin-right: 10px; width: 20px; text-align: center;"></i> Dashboard
                    </a>
                </li>
                <li style="margin-bottom: 10px;">
                    <a href="<?= BASE_URL ?>/customer/orders" style="display: block; padding: 12px 15px; border-radius: 8px; color: #4b5563; text-decoration: none; font-weight: 500; font-size: 1rem;">
                        <i class="fas fa-box" style="margin-right: 10px; width: 20px; text-align: center;"></i> My Orders
                    </a>
                </li>
                <li style="margin-bottom: 10px;">
                    <a href="<?= BASE_URL ?>/customer/wishlist" style="display: block; padding: 12px 15px; border-radius: 8px; background: #0d9488; color: #fff; text-decoration: none; font-weight: 700; font-size: 1rem;">
                        <i class="fas fa-heart" style="margin-right: 10px; width: 20px; text-align: center;"></i> Wishlist
                    </a>
                </li>
                <li style="margin-top: 30px;">
                    <a href="<?= BASE_URL ?>/logout" style="display: block; padding: 12px 15px; color: #e11d48; text-decoration: none; font-weight: 600;">
                        <i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Simple Main Content -->
    <main style="flex: 1; padding: 50px; background: #fafafa;">
        <div style="max-width: 900px; margin: 0 auto;">
            <div style="margin-bottom: 40px;">
                <h1 style="font-size: 1.5rem; color: #1a1a2e; margin-bottom: 10px; font-weight: 800;">Wishlist</h1>
                <p style="color: #4b5563; font-size: 1rem;">A list of all the products you've saved to buy later.</p>
            </div>

            <?php if (empty($wishlistItems)): ?>
                <div style="background: #fff; padding: 60px; border-radius: 20px; border: 2px solid #eee; text-align: center;">
                    <i class="far fa-heart" style="font-size: 4rem; color: #ddd; margin-bottom: 20px; display: block;"></i>
                    <h2 style="color: #333; margin-bottom: 10px;">Your list is empty!</h2>
                    <p style="color: #888; margin-bottom: 30px; font-size: 1.1rem;">You haven't saved any products yet. Let's find some favorites!</p>
                    <a href="<?= BASE_URL ?>/products" class="btn btn-primary btn-lg" style="padding: 15px 40px; border-radius: 50px; font-size: 1.1rem;">Start Shopping</a>
                </div>
            <?php else: ?>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <?php foreach ($wishlistItems as $product): ?>
                        <div style="background: #fff; border: 2px solid #eee; border-radius: 20px; overflow: hidden; padding: 20px; display: flex; align-items: center; gap: 30px;">
                            <!-- Product Image -->
                            <div style="width: 120px; height: 120px; flex-shrink: 0; background: #f9f9f9; border-radius: 15px; overflow: hidden; border: 1px solid #f1f1f1;">
                                <?php if (!empty($product['image'])): ?>
                                    <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($product['image']) ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #ccc;"><i class="fas fa-image" style="font-size: 2rem;"></i></div>
                                <?php endif; ?>
                            </div>

                            <!-- Product Info -->
                            <div style="flex: 1;">
                                <div style="font-size: 0.85rem; color: #0d9488; font-weight: 700; text-transform: uppercase; margin-bottom: 5px;"><?= htmlspecialchars($product['category_name']) ?></div>
                                <h3 style="margin: 0 0 10px 0; font-size: 1.4rem; color: #111;"><?= htmlspecialchars($product['name']) ?></h3>
                                <div style="font-size: 1.4rem; color: #333; font-weight: 800;">₹<?= number_format($product['price'], 2) ?></div>
                            </div>

                            <!-- Actions -->
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <?php if ($product['stock'] > 0): ?>
                                    <form action="<?= BASE_URL ?>/cart/add" method="POST">
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" style="background: #0d9488; color: #fff; border: none; padding: 12px 30px; border-radius: 50px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 10px;">
                                            <i class="fas fa-shopping-bag"></i> Add to Cart
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div style="background: #f1f1f1; color: #888; padding: 12px 30px; border-radius: 50px; font-weight: 700; text-align: center;">Out of Stock</div>
                                <?php endif; ?>
                                
                                <form action="<?= BASE_URL ?>/wishlist/remove" method="POST">
                                    <input type="hidden" name="wishlist_id" value="<?= $product['wishlist_id'] ?>">
                                    <button type="submit" style="background: #fff; border: 2px solid #eee; color: #e11d48; padding: 10px 30px; border-radius: 50px; font-weight: 700; cursor: pointer; width: 100%;">
                                        <i class="fas fa-trash-alt" style="margin-right: 8px;"></i> Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>