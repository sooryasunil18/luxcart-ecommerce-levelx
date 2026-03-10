<!-- Customer dashboard.php (Beginner Friendly Design) -->
<div style="display: flex; min-height: calc(100vh - 130px); background: #fdfdfd; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <!-- Simple Sidebar -->
    <aside style="width: 250px; background: #fff; border-right: 2px solid #eee; flex-shrink: 0;">
        <div style="padding: 40px 20px; text-align: center; border-bottom: 2px solid #f9f9f9;">
            <div style="width: 60px; height: 60px; background: #0d9488; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 15px;">
                <i class="fas fa-user"></i>
            </div>
            <h3 style="margin: 0; font-size: 1.1rem; color: #333;">Hello, <?= htmlspecialchars(explode(' ', trim($_SESSION['user_name']))[0]) ?>!</h3>
        </div>
        <nav style="padding: 20px;">
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="margin-bottom: 10px;">
                    <a href="<?= BASE_URL ?>/account" style="display: block; padding: 12px 15px; border-radius: 8px; background: #0d9488; color: #fff; text-decoration: none; font-weight: 700;">
                        <i class="fas fa-home" style="margin-right: 10px;"></i> My Home
                    </a>
                </li>
                <li style="margin-bottom: 10px;">
                    <a href="<?= BASE_URL ?>/customer/orders" style="display: block; padding: 12px 15px; border-radius: 8px; color: #666; text-decoration: none; font-weight: 600;">
                        <i class="fas fa-box" style="margin-right: 10px;"></i> My Orders
                    </a>
                </li>
                <li style="margin-bottom: 10px;">
                    <a href="<?= BASE_URL ?>/customer/wishlist" style="display: block; padding: 12px 15px; border-radius: 8px; color: #666; text-decoration: none; font-weight: 600;">
                        <i class="fas fa-heart" style="margin-right: 10px;"></i> My Favorites
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
            <div style="margin-bottom: 40px; text-align: center;">
                <div style="font-size: 4rem; color: #0d9488; margin-bottom: 20px;"><i class="fas fa-heart"></i></div>
                <h1 style="font-size: 2.2rem; color: #111; margin-bottom: 10px; font-weight: 800;">Welcome to Your Home</h1>
                <p style="color: #666; font-size: 1.1rem;">Manage your account and see your recommended products here.</p>
            </div>

            <div style="background: #fff; padding: 40px; border-radius: 20px; border: 2px solid #eee; margin-bottom: 50px; text-align: center;">
                <h2 style="color: #333; margin-bottom: 25px; font-size: 1.5rem;">Your Account Info</h2>
                <div style="display: flex; gap: 40px; justify-content: center; align-items: center; max-width: 600px; margin: 0 auto;">
                    <div style="text-align: left; flex: 1; padding: 20px; background: #fdfdfd; border-radius: 12px; border: 1px solid #f0f0f0;">
                        <div style="font-size: 0.85rem; color: #888; font-weight: 700; text-transform: uppercase;">Full Name</div>
                        <div style="font-size: 1.1rem; color: #333; font-weight: 600;"><?= htmlspecialchars($_SESSION['user_name']) ?></div>
                    </div>
                    <div style="text-align: left; flex: 1; padding: 20px; background: #fdfdfd; border-radius: 12px; border: 1px solid #f0f0f0;">
                        <div style="font-size: 0.85rem; color: #888; font-weight: 700; text-transform: uppercase;">Email Address</div>
                        <div style="font-size: 1.1rem; color: #333; font-weight: 600;"><?= htmlspecialchars($_SESSION['user_email']) ?></div>
                    </div>
                </div>
            </div>

            <h3 style="font-size: 1.6rem; color: #111; margin-bottom: 30px; text-align: center;">Recommended For You</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 30px;">
                <?php foreach ($products as $product): ?>
                    <div style="background: #fff; border: 2px solid #eee; border-radius: 20px; overflow: hidden; padding: 15px; position: relative;">
                        <a href="<?= BASE_URL ?>/product/<?= $product['slug'] ?>" style="text-decoration: none; color: inherit;">
                            <div style="width: 100%; aspect-ratio: 1; background: #f9f9f9; border-radius: 12px; overflow: hidden; margin-bottom: 15px; border: 1px solid #f1f1f1;">
                                <?php if (!empty($product['image'])): ?>
                                    <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($product['image']) ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #ccc;"><i class="fas fa-image" style="font-size: 2rem;"></i></div>
                                <?php endif; ?>
                            </div>
                            <h4 style="margin: 0 0 5px 0; font-size: 1.1rem; color: #111; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars($product['name']) ?></h4>
                            <div style="color: #0d9488; font-size: 1.2rem; font-weight: 800; text-align: center; margin-bottom: 15px;">₹<?= number_format($product['price'], 2) ?></div>
                        </a>
                        <form action="<?= BASE_URL ?>/cart/add" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" style="width: 100%; background: #0d9488; color: #fff; border: none; padding: 10px; border-radius: 12px; font-weight: 700; cursor: pointer;">Add to Cart</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div style="text-align: center; margin-top: 50px;">
                <a href="<?= BASE_URL ?>/products" class="btn btn-primary btn-lg" style="padding: 15px 40px; border-radius: 50px; font-size: 1.1rem;">See All Products</a>
            </div>
        </div>
    </main>
</div>