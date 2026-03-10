<!-- Customer Order History Page (Beginner Friendly Design) -->
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
                    <a href="<?= BASE_URL ?>/account" style="display: block; padding: 12px 15px; border-radius: 8px; color: #666; text-decoration: none; font-weight: 600;">
                        <i class="fas fa-home" style="margin-right: 10px;"></i> My Home
                    </a>
                </li>
                <li style="margin-bottom: 10px;">
                    <a href="<?= BASE_URL ?>/customer/orders" style="display: block; padding: 12px 15px; border-radius: 8px; background: #0d9488; color: #fff; text-decoration: none; font-weight: 700;">
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
            <div style="margin-bottom: 40px;">
                <h1 style="font-size: 2.2rem; color: #111; margin-bottom: 10px; font-weight: 800;">My Orders</h1>
                <p style="color: #666; font-size: 1.1rem;">Here you can see everything you've bought from us.</p>
            </div>

            <?php if (empty($orders)): ?>
                <div style="background: #fff; padding: 60px; border-radius: 20px; border: 2px solid #eee; text-align: center;">
                    <i class="fas fa-shopping-bag" style="font-size: 4rem; color: #ddd; margin-bottom: 20px;"></i>
                    <h2 style="color: #333; margin-bottom: 10px;">Your bag is empty!</h2>
                    <p style="color: #888; margin-bottom: 30px; font-size: 1.1rem;">You haven't ordered anything yet. Let's find something you love!</p>
                    <a href="<?= BASE_URL ?>/products" class="btn btn-primary btn-lg" style="padding: 15px 40px; border-radius: 50px; font-size: 1.1rem;">Go Shopping</a>
                </div>
            <?php else: ?>
                <div style="display: flex; flex-direction: column; gap: 30px;">
                    <?php foreach ($orders as $order): ?>
                        <div style="background: #fff; border: 2px solid #eee; border-radius: 20px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.02);">
                            <!-- Order Info Header -->
                            <div style="padding: 25px 35px; border-bottom: 2px solid #f9f9f9; background: #fcfcfc; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <div style="font-size: 0.9rem; color: #888; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Order Details</div>
                                    <div style="font-size: 1.1rem; color: #333; display: flex; gap: 20px;">
                                        <span>Ordered on: <strong><?= date('M j, Y', strtotime($order['created_at'])) ?></strong></span>
                                        <span>Order Number: <strong>#ORD-<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></strong></span>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 0.9rem; color: #888; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Price</div>
                                    <div style="font-size: 1.4rem; color: #0d9488; font-weight: 800;">₹<?= number_format($order['total_amount'], 2) ?></div>
                                </div>
                            </div>

                            <!-- Payment Detail -->
                            <div style="padding: 15px 35px; background: #f8fafc; border-bottom: 2px solid #f1f5f9; display: flex; align-items: center; gap: 15px; font-weight: 600; color: #475569;">
                                <i class="fas fa-wallet" style="color: #94a3b8;"></i>
                                <?php if ($order['payment_method'] === 'razorpay'): ?>
                                    <span>Paid with Online Payment</span>
                                    <span style="background: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 50px; font-size: 0.8rem; text-transform: uppercase;">Payment Received</span>
                                <?php else: ?>
                                    <span>Paying with Cash on Delivery</span>
                                    <span style="background: #fef3c7; color: #b45309; padding: 4px 12px; border-radius: 50px; font-size: 0.8rem; text-transform: uppercase;">Payment Pending</span>
                                <?php endif; ?>
                            </div>

                            <!-- Products -->
                            <div style="padding: 20px 35px;">
                                <?php foreach ($order['items'] as $item): ?>
                                    <div style="display: flex; gap: 30px; padding: 25px 0; border-bottom: 1px solid #f5f5f5; align-items: center;">
                                        <!-- Product Image -->
                                        <div style="width: 100px; height: 100px; flex-shrink: 0; background: #f9f9f9; border-radius: 15px; overflow: hidden; border: 1px solid #eee;">
                                            <?php if (!empty($item['image'])): ?>
                                                <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($item['image']) ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php else: ?>
                                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #ccc;"><i class="fas fa-image" style="font-size: 2rem;"></i></div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Product Info -->
                                        <div style="flex: 1;">
                                            <h4 style="margin: 0 0 8px 0; font-size: 1.2rem; color: #111;"><?= htmlspecialchars($item['product_name']) ?></h4>
                                            <div style="color: #666; font-size: 1rem; margin-bottom: 12px;">
                                                Quantity: <strong><?= $item['quantity'] ?></strong> <span style="margin: 0 10px; color: #ddd;">|</span> Price: <strong>₹<?= number_format($item['price'], 2) ?></strong>
                                            </div>
                                            
                                            <!-- Simple Status Label -->
                                            <?php
                                                $stColor = '#666'; $stLabel = $item['item_status']; $stBg = '#f5f5f5';
                                                switch($item['item_status']) {
                                                    case 'pending': $stColor = '#b45309'; $stBg = '#fef3c7'; $stLabel = "Order Received"; break;
                                                    case 'delivered': $stColor = '#15803d'; $stBg = '#dcfce7'; $stLabel = "Arrived / Delivered"; break;
                                                    case 'shipped': $stColor = '#4338ca'; $stBg = '#e0e7ff'; $stLabel = "On the way / Shipped"; break;
                                                    case 'cancelled': $stColor = '#b91c1c'; $stBg = '#fee2e2'; break;
                                                }
                                            ?>
                                            <div style="display: inline-block; padding: 6px 15px; background: <?= $stBg ?>; color: <?= $stColor ?>; border-radius: 50px; font-weight: 700; font-size: 0.9rem; text-transform: capitalize;">
                                                Status: <?= $stLabel ?>
                                            </div>
                                        </div>

                                        <!-- Simple Action -->
                                        <div>
                                            <a href="<?= BASE_URL ?>/product/<?= $item['slug'] ?>" class="btn btn-primary" style="background: #0d9488; padding: 12px 25px; border-radius: 50px; font-weight: 700;">Buy Again</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

