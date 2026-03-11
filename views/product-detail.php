<!-- Breadcrumb -->
<section class="page-header page-header-sm">
    <div class="container">
        <nav class="breadcrumb">
            <a href="<?= BASE_URL ?>/">Home</a>
            <i class="fas fa-chevron-right"></i>
            <a href="<?= BASE_URL ?>/products">Products</a>
            <i class="fas fa-chevron-right"></i>
            <span><?= htmlspecialchars($product['name']) ?></span>
        </nav>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="product-detail-grid">
            <!-- Image -->
            <div class="product-gallery">
                <div class="gallery-main">
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                            style="width:100%;height:100%;object-fit:cover;border-radius:12px">
                    <?php else: ?>
                        <div class="product-image-placeholder large">
                            <i class="fas fa-image"></i>
                            <span><?= htmlspecialchars($product['name']) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Info -->
            <div class="product-detail-info">
                <span class="product-category-tag"><?= htmlspecialchars($product['category_name']) ?></span>
                <h1 class="product-detail-title"><?= htmlspecialchars($product['name']) ?></h1>

                <div class="product-detail-rating">
                    <div class="stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="<?= $i <= floor($product['rating']) ? 'fas' : 'far' ?> fa-star"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="rating-text"><?= $product['rating'] ?> (<?= $product['review_count'] ?> reviews)</span>
                </div>

                <div class="product-detail-price">
                    <?php if ($product['sale_price']): ?>
                        <span class="detail-price-current">₹<?= number_format($product['sale_price'], 2) ?></span>
                        <span class="detail-price-original">₹<?= number_format($product['price'], 2) ?></span>
                    <?php else: ?>
                        <span class="detail-price-current">₹<?= number_format($product['price'], 2) ?></span>
                    <?php endif; ?>
                </div>

                <p class="product-detail-description"><?= htmlspecialchars($product['description']) ?></p>

                <div class="product-detail-meta">
                    <div class="meta-item">
                        <span class="meta-label">Availability:</span>
                        <?php if ($product['stock'] > 0): ?>
                            <span class="meta-value in-stock"><i class="fas fa-check-circle"></i> In Stock
                                (<?= $product['stock'] ?>)</span>
                        <?php else: ?>
                            <span class="meta-value out-of-stock"><i class="fas fa-times-circle"></i> Out of Stock</span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['admin', 'seller'])): ?>
                    <!-- Quantity & Add to Cart -->
                    <div class="product-actions-row">
                        <div style="display: flex; gap: 12px; width: 100%;">
                            <form action="<?= BASE_URL ?>/cart/add" method="POST"
                                style="display: flex; align-items: center; gap: 12px; flex: 1;">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <div class="quantity-selector">
                                    <button type="button" class="qty-btn" id="qtyMinus"><i
                                            class="fas fa-minus"></i></button>
                                    <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>"
                                        class="qty-input" id="qtyInput">
                                    <button type="button" class="qty-btn" id="qtyPlus"><i class="fas fa-plus"></i></button>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg add-to-cart-btn" style="flex: 1;">
                                    <i class="fas fa-shopping-bag"></i> Add to Cart
                                </button>
                            </form>

                            <!-- Add to Wishlist Button -->
                            <form action="<?= BASE_URL ?>/wishlist/add" method="POST">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <button type="submit" class="btn btn-lg" title="Add to Wishlist"
                                    style="background: #fff; border: 2px solid #e5e7eb; color: #f43f5e; height: 100%; min-height: 48px; padding: 0 20px; display: flex; align-items: center; justify-content: center; border-radius: 8px; cursor: pointer; transition: all 0.2s;"
                                    onmouseover="this.style.background='#fff1f2'; this.style.borderColor='#fda4af';"
                                    onmouseout="this.style.background='#fff'; this.style.borderColor='#e5e7eb';">
                                    <i class="far fa-heart" style="font-size: 1.3rem;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Description Tab -->
        <div class="product-tabs">
            <div class="tab-nav">
                <button class="tab-btn active" data-tab="description">Description</button>
                <button class="tab-btn" data-tab="reviews">Reviews (<?= $product['review_count'] ?>)</button>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="tab-description">
                    <h3>Product Details</h3>
                    <p><?= htmlspecialchars($product['description']) ?></p>
                </div>
                <div class="tab-pane" id="tab-reviews">
                    <div class="reviews-average">
                        <span class="avg-number"><?= $product['rating'] ?></span>
                        <div class="avg-stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="<?= $i <= floor($product['rating']) ? 'fas' : 'far' ?> fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="avg-count"><?= $product['review_count'] ?> reviews</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <?php if (!empty($relatedProducts)): ?>
            <div class="related-products">
                <h2 class="section-title">Related Products</h2>
                <div class="products-grid">
                    <?php foreach ($relatedProducts as $rp): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <div class="product-image-placeholder">
                                    <i class="fas fa-image"></i>
                                    <span><?= htmlspecialchars($rp['name']) ?></span>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">
                                    <a
                                        href="<?= BASE_URL ?>/product/<?= $rp['slug'] ?>"><?= htmlspecialchars($rp['name']) ?></a>
                                </h3>
                                <div class="product-price">
                                    <?php if ($rp['sale_price']): ?>
                                        <span class="price-current">₹<?= number_format($rp['sale_price'], 2) ?></span>
                                        <span class="price-original">₹<?= number_format($rp['price'], 2) ?></span>
                                    <?php else: ?>
                                        <span class="price-current">₹<?= number_format($rp['price'], 2) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
                <?php if (!empty($alsoBought)): ?>
            <div class="related-products" style="margin-top: 50px;">
                <h2 class="section-title">Customers Also Bought</h2>
                <div class="products-grid">
                    <?php foreach ($alsoBought as $ab): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <?php if (!empty($ab['image'])): ?>
                                    <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($ab['image']) ?>"
                                         alt="<?= htmlspecialchars($ab['name']) ?>"
                                         style="width:100%;height:100%;object-fit:cover;">
                                <?php else: ?>
                                    <div class="product-image-placeholder">
                                        <i class="fas fa-image"></i>
                                        <span><?= htmlspecialchars($ab['name']) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">
                                    <a href="<?= BASE_URL ?>/product/<?= $ab['slug'] ?>"><?= htmlspecialchars($ab['name']) ?></a>
                                </h3>
                                <div class="product-price">
                                    <?php if ($ab['sale_price']): ?>
                                        <span class="price-current">₹<?= number_format($ab['sale_price'], 2) ?></span>
                                        <span class="price-original">₹<?= number_format($ab['price'], 2) ?></span>
                                    <?php else: ?>
                                        <span class="price-current">₹<?= number_format($ab['price'], 2) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>