<!-- Hero Section -->
<section class="hero">
    <div class="container" style="text-align:center">
        <div class="hero-content" style="max-width:600px;margin:0 auto">
            <h1 class="hero-title">Welcome to <span class="text-gradient">LuxeCart</span></h1>
            <p class="hero-subtitle" style="margin-left:auto;margin-right:auto">Shop the best Electronics and Fashion
                products at great prices.</p>
            <div class="hero-actions" style="justify-content:center">
                <a href="<?= BASE_URL ?>/products" class="btn btn-primary btn-lg">Shop Now</a>
                <a href="<?= BASE_URL ?>/about" class="btn btn-outline btn-lg"
                    style="border-color:#fff;color:#fff">Learn More</a>
            </div>
        </div>
    </div>
</section>


<!-- Guest/User Wishlist Section -->
<?php if (!empty($wishlistItems)): ?>
<section class="section" id="guest-wishlist" style="background:#fff; padding-bottom: 0;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Your Wishlist</h2>
            <p class="section-subtitle">Items you have saved</p>
        </div>
        <div class="products-grid">
            <?php foreach ($wishlistItems as $product): ?>
                <div class="product-card" style="position: relative;">
                    <!-- Remove from wishlist button -->
                    <form action="<?= BASE_URL ?>/wishlist/remove" method="POST"
                        style="position: absolute; top: 12px; right: 12px; z-index: 10;">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" title="Remove from Wishlist"
                            style="background: #fff; border: 1px solid #eee; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6b7280; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.color='#f43f5e'; this.style.transform='scale(1.1)';"
                            onmouseout="this.style.color='#6b7280'; this.style.transform='scale(1)';">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>

                    <div class="product-image">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>" style="width:100%;height:100%;object-fit:cover">
                        <?php else: ?>
                            <div class="product-image-placeholder">
                                <i class="fas fa-image"></i>
                                <span><?= htmlspecialchars($product['name']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <span class="product-category"><?= htmlspecialchars($product['category_name']) ?></span>
                        <h3 class="product-name">
                            <a
                                href="<?= BASE_URL ?>/product/<?= $product['slug'] ?>"><?= htmlspecialchars($product['name']) ?></a>
                        </h3>
                        <div class="product-price">
                            <?php if ($product['sale_price']): ?>
                                <span class="price-current">₹<?= number_format($product['sale_price'], 2) ?></span>
                                <span class="price-original">₹<?= number_format($product['price'], 2) ?></span>
                            <?php else: ?>
                                <span class="price-current">₹<?= number_format($product['price'], 2) ?></span>
                            <?php endif; ?>
                        </div>
                        <form action="<?= BASE_URL ?>/cart/add" method="POST" style="margin-top: 12px;">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary btn-sm add-to-cart-btn" style="width: 100%; justify-content: center; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-shopping-bag"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Featured Products -->
<section class="section" style="background:#f0f0f5">
    <div class="container">
        <div class="section-header">
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'seller'): ?>
                <h2 class="section-title">Your Products</h2>
                <p class="section-subtitle">All products you have added</p>
            <?php else: ?>
                <h2 class="section-title">Featured Products</h2>
                <p class="section-subtitle">Our most popular items</p>
            <?php endif; ?>
        </div>
        <div class="products-grid">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="product-card">

                    <div class="product-image">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>" style="width:100%;height:100%;object-fit:cover">
                        <?php else: ?>
                            <div class="product-image-placeholder">
                                <i class="fas fa-image"></i>
                                <span><?= htmlspecialchars($product['name']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <span class="product-category"><?= htmlspecialchars($product['category_name']) ?></span>
                        <h3 class="product-name">
                            <a
                                href="<?= BASE_URL ?>/product/<?= $product['slug'] ?>"><?= htmlspecialchars($product['name']) ?></a>
                        </h3>
                        <div class="product-price">
                            <?php if ($product['sale_price']): ?>
                                <span class="price-current">₹<?= number_format($product['sale_price'], 2) ?></span>
                                <span class="price-original">₹<?= number_format($product['price'], 2) ?></span>
                            <?php else: ?>
                                <span class="price-current">₹<?= number_format($product['price'], 2) ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'seller'): ?>
                        <form action="<?= BASE_URL ?>/cart/add" method="POST" style="margin-top: 12px;">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary btn-sm add-to-cart-btn" style="width: 100%; justify-content: center; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-shopping-bag"></i> Add to Cart
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="section-action">
            <a href="<?= BASE_URL ?>/products" class="btn btn-outline">View All Products</a>
        </div>
    </div>
</section>