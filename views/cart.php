<!-- Shopping Cart Page (Beginner Friendly Design) -->
<div style="min-height: calc(100vh - 130px); background: #f8fafc; padding: 50px 0; font-family: 'Inter', Arial, sans-serif; line-height: 1.6;">
    <div style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
        <!-- Simple Header -->
        <div style="margin-bottom: 40px; text-align: center;">
            <div style="font-size: 2.5rem; color: #0d9488; margin-bottom: 15px;"><i class="fas fa-shopping-cart"></i></div>
            <h1 style="font-size: 1.5rem; color: #1a1a2e; font-weight: 700; margin: 0 0 10px 0;">Your Shopping Bag</h1>
            <p style="color: #4b5563; font-size: 1rem;">Review your items and proceed to checkout whenever you're ready.</p>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div style="background: #dcfce7; color: #15803d; padding: 15px 25px; border-radius: 12px; border: 1px solid #bdf0d2; margin-bottom: 30px; font-weight: 600;">
                <i class="fas fa-check-circle" style="margin-right: 10px;"></i> <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div style="background: #fee2e2; color: #b91c1c; padding: 15px 25px; border-radius: 12px; border: 1px solid #fecaca; margin-bottom: 30px; font-weight: 600;">
                <i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i> <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (empty($cartItems)): ?>
            <div style="background: #fff; padding: 80px 40px; border-radius: 20px; border: 2px solid #eee; text-align: center;">
                <div style="font-size: 4rem; color: #ddd; margin-bottom: 25px;"><i class="fas fa-shopping-bag"></i></div>
                <h2 style="color: #333; margin-bottom: 10px; font-weight: 800;">Your bag is empty</h2>
                <p style="color: #888; margin-bottom: 35px; font-size: 1.1rem;">Looks like you haven't added anything yet. Let's change that!</p>
                <a href="<?= BASE_URL ?>/products" class="btn btn-primary btn-lg" style="padding: 15px 40px; border-radius: 50px; font-size: 1.1rem;">Go Shopping</a>
            </div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: 1fr 350px; gap: 40px; align-items: start;">
                <!-- Product List -->
                <div>
                    <div style="background: #fff; border: 2px solid #eee; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                        <div style="padding: 20px 30px; background: #fcfcfc; border-bottom: 2px solid #f9f9f9; display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="margin: 0; font-size: 1.2rem; color: #333;">Items (<?= array_sum(array_column($cartItems, 'quantity')) ?>)</h3>
                            <form action="<?= BASE_URL ?>/cart/clear" method="POST" onsubmit="return confirm('Clear your entire bag?');">
                                <button type="submit" style="background: none; border: none; color: #e11d48; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-trash-alt"></i> Clear All
                                </button>
                            </form>
                        </div>
                        
                        <div style="padding: 0 30px;">
                            <?php foreach ($cartItems as $item): ?>
                                <div style="display: flex; gap: 25px; padding: 30px 0; border-bottom: 1px solid #f5f5f5; align-items: center;">
                                    <!-- Product Image -->
                                    <div style="width: 110px; height: 110px; flex-shrink: 0; background: #f9f9f9; border-radius: 15px; overflow: hidden; border: 1px solid #eee;">
                                        <?php if (!empty($item['image'])): ?>
                                            <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($item['image']) ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                        <?php else: ?>
                                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #ccc;"><i class="fas fa-image" style="font-size: 2rem;"></i></div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Details -->
                                    <div style="flex: 1;">
                                        <h4 style="margin: 0 0 5px 0; font-size: 1.2rem; color: #111;"><?= htmlspecialchars($item['name']) ?></h4>
                                        <div style="font-size: 1.2rem; color: #333; font-weight: 800; margin-bottom: 15px;">
                                            <?php if ($item['sale_price']): ?>
                                                <span style="color: #0d9488;">₹<?= number_format($item['sale_price'], 2) ?></span>
                                                <span style="color: #bbb; text-decoration: line-through; font-size: 0.9rem; margin-left: 10px;">₹<?= number_format($item['price'], 2) ?></span>
                                            <?php else: ?>
                                                ₹<?= number_format($item['price'], 2) ?>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Quantity Control -->
                                        <form action="<?= BASE_URL ?>/cart/update" method="POST" style="display: flex; align-items: center; gap: 15px;">
                                            <input type="hidden" name="cart_id" value="<?= isset($_SESSION['user_id']) ? $item['id'] : $item['product_id'] ?>">
                                            <div style="display: flex; align-items: center; background: #fafafa; border: 2px solid #eee; border-radius: 12px; padding: 2px;">
                                                <button type="button" onclick="updateQty(this, -1)" style="width: 35px; height: 35px; border: none; background: none; color: #666; cursor: pointer; font-size: 1rem;"><i class="fas fa-minus"></i></button>
                                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" readonly style="width: 40px; text-align: center; border: none; background: none; font-weight: 800; color: #111; outline: none;">
                                                <button type="button" onclick="updateQty(this, 1)" style="width: 35px; height: 35px; border: none; background: none; color: #666; cursor: pointer; font-size: 1rem;"><i class="fas fa-plus"></i></button>
                                            </div>
                                            <span style="font-size: 0.85rem; color: #888; font-weight: 600;">(<?= $item['stock'] ?> in stock)</span>
                                        </form>
                                    </div>

                                    <!-- Item Total & Remove -->
                                    <div style="text-align: right;">
                                        <div style="font-size: 1.4rem; font-weight: 800; color: #111; margin-bottom: 10px;">₹<?= number_format(($item['sale_price'] ?? $item['price']) * $item['quantity'], 2) ?></div>
                                        <form action="<?= BASE_URL ?>/cart/remove" method="POST" onsubmit="return confirm('Remove this item?');">
                                            <input type="hidden" name="cart_id" value="<?= isset($_SESSION['user_id']) ? $item['id'] : $item['product_id'] ?>">
                                            <button type="submit" style="background: none; border: none; color: #888; font-weight: 600; cursor: pointer; font-size: 0.9rem; text-decoration: underline;">Remove Item</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Summary Panel -->
                <div style="position: sticky; top: 50px;">
                    <div style="background: #fff; border: 2px solid #eee; border-radius: 20px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                        <h3 style="margin: 0 0 25px 0; font-size: 1.4rem; color: #111; font-weight: 800;">Bag Summary</h3>
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; color: #666; font-size: 1.1rem;">
                            <span>Subtotal</span>
                            <span style="color: #111; font-weight: 700;">₹<?= number_format($total, 2) ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 25px; color: #0d9488; font-size: 1.1rem; font-weight: 700;">
                            <span>Shipping</span>
                            <span>FREE</span>
                        </div>
                        
                        <div style="border-top: 2px solid #f9f9f9; padding-top: 20px; margin-bottom: 30px;">
                            <div style="display: flex; justify-content: space-between; font-size: 1.6rem; color: #111; font-weight: 800;">
                                <span>Total</span>
                                <span style="color: #0d9488;">₹<?= number_format($total, 2) ?></span>
                            </div>
                        </div>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="<?= BASE_URL ?>/checkout" class="btn btn-primary" style="display: block; width: 100%; padding: 14px; border-radius: 50px; text-align: center; font-size: 1rem; font-weight: 700; text-decoration: none; background: #0d9488; box-shadow: 0 4px 12px rgba(13, 148, 136, 0.15);">Proceed to Checkout</a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>/login" class="btn btn-primary" style="display: block; width: 100%; padding: 14px; border-radius: 50px; text-align: center; font-size: 1rem; font-weight: 700; text-decoration: none; background: #333;">Login to Checkout</a>
                            <p style="text-align: center; margin-top: 15px; color: #888; font-size: 0.9rem;">Please login to complete your order.</p>
                        <?php endif; ?>

                        <div style="margin-top: 30px; padding: 20px; background: #fcfcfc; border-radius: 15px; border: 1px solid #f1f1f1;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px; color: #444; font-weight: 600;">
                                <i class="fas fa-truck" style="color: #0d9488;"></i>
                                <span>Free Fast Shipping</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px; color: #444; font-weight: 600;">
                                <i class="fas fa-shield-alt" style="color: #0d9488;"></i>
                                <span>Secure Checkout</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

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

