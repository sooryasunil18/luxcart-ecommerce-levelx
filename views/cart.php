<!-- Cart Page -->
<section class="page-header">
    <div class="container">
        <h1>Shopping Cart</h1>
        <nav class="breadcrumb">
            <a href="<?= BASE_URL ?>/">Home</a>
            <i class="fas fa-chevron-right"></i>
            <span>Cart</span>
        </nav>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (empty($cartItems)): ?>
            <div class="empty-state" style="padding: 80px 20px; text-align: center;">
                <i class="fas fa-shopping-cart" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                <h3 style="color: #1a1a2e; margin-bottom: 10px; font-size: 1.5rem;">Your cart is empty</h3>
                <p style="color: #666; margin-bottom: 20px;">Add some products to get started!</p>
                <a href="<?= BASE_URL ?>/products" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag"></i> Browse Products
                </a>
            </div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px; align-items: start;">
                <!-- Cart Items -->
                <div style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #eee;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #e5e7eb;">
                        <h2 style="font-size: 1.3rem; color: #1a1a2e; margin: 0;">
                            <?= count($cartItems) ?> Item<?= count($cartItems) > 1 ? 's' : '' ?> in Cart
                        </h2>
                        <form action="<?= BASE_URL ?>/cart/clear" method="POST" onsubmit="return confirm('Are you sure you want to clear your cart?');">
                            <button type="submit" class="btn btn-outline btn-sm" style="color: #dc2626; border-color: #dc2626;">
                                <i class="fas fa-trash-alt"></i> Clear All
                            </button>
                        </form>
                    </div>

                    <?php foreach ($cartItems as $item): ?>
                        <div style="display: grid; grid-template-columns: 100px 1fr auto; gap: 20px; padding: 20px 0; border-bottom: 1px solid #e5e7eb; align-items: center;">
                            <!-- Product Image -->
                            <div style="border-radius: 8px; overflow: hidden; background: #f0f0f0;">
                                <?php if (!empty($item['image'])): ?>
                                    <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($item['image']) ?>" 
                                        alt="<?= htmlspecialchars($item['name']) ?>" 
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                <?php else: ?>
                                    <div style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; color: #bbb;">
                                        <i class="fas fa-image" style="font-size: 2rem;"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Product Details -->
                            <div>
                                <h3 style="font-size: 1.1rem; color: #1a1a2e; margin-bottom: 5px;">
                                    <a href="<?= BASE_URL ?>/product/<?= $item['slug'] ?>" style="color: inherit; text-decoration: none;">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </a>
                                </h3>
                                <div style="color: #666; font-size: 0.9rem; margin-bottom: 10px;">
                                    <?php if ($item['sale_price']): ?>
                                        <span style="color: #0d9488; font-weight: 600;">₹<?= number_format($item['sale_price'], 2) ?></span>
                                        <span style="color: #aaa; text-decoration: line-through; margin-left: 8px;">₹<?= number_format($item['price'], 2) ?></span>
                                    <?php else: ?>
                                        <span style="color: #1a1a2e; font-weight: 600;">₹<?= number_format($item['price'], 2) ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Quantity Controls -->
                                <form action="<?= BASE_URL ?>/cart/update" method="POST" style="display: flex; align-items: center; gap: 10px;">
                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <!-- For logged-in users, use cart ID -->
                                        <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                    <?php else: ?>
                                        <!-- For guest users, use product ID -->
                                        <input type="hidden" name="cart_id" value="<?= $item['product_id'] ?>">
                                    <?php endif; ?>
                                    <div class="quantity-selector" style="display: flex; align-items: center; border: 2px solid #ddd; border-radius: 6px; overflow: hidden;">
                                        <button type="button" class="qty-btn" onclick="updateQty(this, -1)" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; color: #555; background: none; border: none;">
                                            <i class="fas fa-minus" style="font-size: 0.7rem;"></i>
                                        </button>
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" 
                                            onchange="this.form.submit()" 
                                            style="width: 50px; text-align: center; border: none; outline: none; font-weight: 600; font-size: 0.9rem; color: #1a1a2e;">
                                        <button type="button" class="qty-btn" onclick="updateQty(this, 1)" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; color: #555; background: none; border: none;">
                                            <i class="fas fa-plus" style="font-size: 0.7rem;"></i>
                                        </button>
                                    </div>
                                    <span style="color: #666; font-size: 0.85rem;">In stock: <?= $item['stock'] ?></span>
                                </form>
                            </div>

                            <!-- Price & Remove -->
                            <div style="text-align: right;">
                                <div style="font-size: 1.3rem; font-weight: 700; color: #1a1a2e; margin-bottom: 10px;">
                                    ₹<?= number_format(($item['sale_price'] ?? $item['price']) * $item['quantity'], 2) ?>
                                </div>
                                <form action="<?= BASE_URL ?>/cart/remove" method="POST" onsubmit="return confirm('Remove this item?');" style="margin: 0;">
                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <!-- For logged-in users, use cart ID -->
                                        <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                    <?php else: ?>
                                        <!-- For guest users, use product ID -->
                                        <input type="hidden" name="cart_id" value="<?= $item['product_id'] ?>">
                                    <?php endif; ?>
                                    <button type="submit" class="btn btn-outline btn-sm" style="color: #dc2626; border-color: #dc2626;">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Cart Summary -->
                <div style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #eee; position: sticky; top: 100px;">
                    <h2 style="font-size: 1.3rem; color: #1a1a2e; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #e5e7eb;">Order Summary</h2>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; color: #666;">
                        <span>Subtotal (<?= array_sum(array_column($cartItems, 'quantity')) ?> items)</span>
                        <span style="font-weight: 600; color: #1a1a2e;">₹<?= number_format($total, 2) ?></span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; color: #666;">
                        <span>Shipping</span>
                        <span style="font-weight: 600; color: #059669;">FREE</span>
                    </div>
                    
                    <div style="border-top: 2px solid #e5e7eb; margin: 20px 0; padding-top: 15px;">
                        <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 700; color: #1a1a2e;">
                            <span>Total</span>
                            <span style="color: #0d9488;">₹<?= number_format($total, 2) ?></span>
                        </div>
                    </div>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- For logged-in users -->
                        <a href="<?= BASE_URL ?>/checkout" class="btn btn-primary btn-lg" style="width: 100%; margin-top: 20px; padding: 16px; font-size: 1.1rem; text-align: center; display: block; box-sizing: border-box; text-decoration: none;">
                            <i class="fas fa-lock"></i> Proceed to Checkout 
                        </a>
                    <?php else: ?>
                        <!-- For guest users -->
                        <button class="btn btn-primary btn-lg" style="width: 100%; margin-top: 20px; padding: 16px; font-size: 1.1rem;" 
                            onclick="window.location.href='<?= BASE_URL ?>/login'">
                            <i class="fas fa-sign-in-alt"></i> Login to Checkout
                        </button>
                        <div style="background: #f0fdfa; padding: 15px; border-radius: 8px; margin-top: 15px; border-left: 4px solid #0d9488;">
                            <p style="margin: 0; color: #0f766e; font-weight: 500;">
                                <i class="fas fa-info-circle"></i> Create an account or login to save your cart and complete checkout.
                            </p>
                        </div>
                    <?php endif; ?>

                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                        <div style="display: flex; align-items: center; gap: 10px; color: #666; font-size: 0.9rem; margin-bottom: 8px;">
                            <i class="fas fa-truck" style="color: #0d9488;"></i>
                            <span>Free shipping on all orders</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; color: #666; font-size: 0.9rem;">
                            <i class="fas fa-undo" style="color: #0d9488;"></i>
                            <span>Easy returns within 30 days</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
function updateQty(button, change) {
    var input = button.parentElement.querySelector('input[type="number"]');
    var newVal = parseInt(input.value) + change;
    var min = parseInt(input.min) || 1;
    var max = parseInt(input.max) || 999;
    
    if (newVal >= min && newVal <= max) {
        input.value = newVal;
        input.form.submit();
    }
}
</script>
