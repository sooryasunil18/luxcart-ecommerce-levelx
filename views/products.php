<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1>Products</h1>
        <nav class="breadcrumb">
            <a href="<?= BASE_URL ?>/">Home</a>
            <i class="fas fa-chevron-right"></i>
            <span>Products</span>
        </nav>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="products-layout">
            <!-- Sidebar -->
            <aside class="products-sidebar" id="filterSidebar">
                <div class="sidebar-header">
                    <h3><i class="fas fa-sliders-h"></i> Filters</h3>
                    <button class="filter-close" id="filterClose"><i class="fas fa-times"></i></button>
                </div>
                <div class="filter-group">
                    <h4 class="filter-title">Categories</h4>
                    <ul class="filter-list">
                        <li><a href="<?= BASE_URL ?>/products"
                                class="<?= empty($_GET['category']) ? 'active' : '' ?>">All Products</a></li>
                        <?php foreach ($categories as $cat): ?>
                            <li><a href="<?= BASE_URL ?>/products?category=<?= $cat['category_url_name'] ?>"
                                    class="<?= (isset($_GET['category']) && $_GET['category'] === $cat['category_url_name']) ? 'active' : '' ?>"><?= htmlspecialchars($cat['name']) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>

            <!-- Products -->
            <div class="products-content">
                <div class="products-toolbar">
                    <div class="toolbar-left">
                        <button class="filter-toggle" id="filterToggle"><i class="fas fa-sliders-h"></i>
                            Filters</button>
                        <span class="results-count"><?= count($products) ?> products</span>
                    </div>
                    <div class="toolbar-right">
                        <div class="sort-select">
                            <select onchange="window.location.href=this.value">
                                <option
                                    value="<?= BASE_URL ?>/products?sort=newest<?= isset($_GET['category']) ? '&category=' . $_GET['category'] : '' ?>"
                                    <?= ($sortBy ?? 'newest') === 'newest' ? 'selected' : '' ?>>Newest</option>
                                <option
                                    value="<?= BASE_URL ?>/products?sort=price_low<?= isset($_GET['category']) ? '&category=' . $_GET['category'] : '' ?>"
                                    <?= ($sortBy ?? '') === 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
                                <option
                                    value="<?= BASE_URL ?>/products?sort=price_high<?= isset($_GET['category']) ? '&category=' . $_GET['category'] : '' ?>"
                                    <?= ($sortBy ?? '') === 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="products-grid" id="productsGrid">
                    <?php if (empty($products)): ?>
                        <div class="empty-state">
                            <i class="fas fa-search"></i>
                            <h3>No products found</h3>
                            <a href="<?= BASE_URL ?>/products" class="btn btn-primary">View All</a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card">

                                <div class="product-image">
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($product['image']) ?>"
                                            alt="<?= htmlspecialchars($product['name']) ?>"
                                            style="width:100%;height:100%;object-fit:cover">
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
                                    <div class="product-rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= floor($product['rating'])): ?>
                                                <i class="fas fa-star"></i>
                                            <?php else: ?>
                                                <i class="far fa-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <span>(<?= $product['review_count'] ?>)</span>
                                    </div>
                                    <div class="product-price">
                                        <?php if ($product['sale_price']): ?>
                                            <span class="price-current">₹<?= number_format($product['sale_price'], 2) ?></span>
                                            <span class="price-original">₹<?= number_format($product['price'], 2) ?></span>
                                        <?php else: ?>
                                            <span class="price-current">₹<?= number_format($product['price'], 2) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['admin', 'seller'])): ?>
                                        <div style="display: flex; gap: 8px; margin-top: 12px; width: 100%;">
                                            <form action="<?= BASE_URL ?>/cart/add" method="POST" style="flex: 1;">
                                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary btn-sm add-to-cart-btn"
                                                    style="width: 100%; justify-content: center; display: flex; align-items: center; gap: 8px;">
                                                    <i class="fas fa-shopping-bag"></i> Add to Cart
                                                </button>
                                            </form>

                                            <!-- Add to Wishlist Button -->
                                            <form action="<?= BASE_URL ?>/wishlist/add" method="POST">
                                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                <button type="submit" class="btn btn-sm" title="Add to Wishlist"
                                                    style="background: #fff; border: 1px solid #e5e7eb; color: #f43f5e; width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 6px; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#fff1f2'; this.style.borderColor='#fecdd3';"
                                                    onmouseout="this.style.background='#fff'; this.style.borderColor='#e5e7eb';">
                                                    <i class="far fa-heart" style="font-size: 1.1rem;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>