<!-- Checkout Page -->
<section class="page-header">
    <div class="container">
        <h1>Secure Checkout</h1>
        <nav class="breadcrumb">
            <a href="<?= BASE_URL ?>/">Home</a>
            <i class="fas fa-chevron-right"></i>
            <a href="<?= BASE_URL ?>/cart">Cart</a>
            <i class="fas fa-chevron-right"></i>
            <span>Checkout</span>
        </nav>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/checkout/process" method="POST" id="checkoutForm">
            <div style="display: grid; grid-template-columns: 1fr 400px; gap: 40px; align-items: start;">
                
                <!-- Left Column: Forms -->
                <div>
                    <!-- Shipping Address -->
                    <div style="background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 30px;">
                        <h2 style="font-size: 1.5rem; color: #1a1a2e; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-map-marker-alt" style="color: #0d9488;"></i> Shipping Address
                        </h2>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="full_name" style="display: block; margin-bottom: 8px; font-weight: 500; color: #4a5568;">Full Name</label>
                                <input type="text" id="full_name" name="full_name" class="form-control" required 
                                    value="<?= htmlspecialchars($lastAddress['full_name'] ?? '') ?>" 
                                    style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box;">
                            </div>
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="phone" style="display: block; margin-bottom: 8px; font-weight: 500; color: #4a5568;">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="form-control" required
                                    value="<?= htmlspecialchars($lastAddress['phone'] ?? '') ?>"
                                    style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box;">
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="address" style="display: block; margin-bottom: 8px; font-weight: 500; color: #4a5568;">Address (House No, Building, Street, Area)</label>
                            <textarea id="address" name="address" class="form-control" required rows="3"
                                style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; resize: vertical;"><?= htmlspecialchars($lastAddress['address'] ?? '') ?></textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="city" style="display: block; margin-bottom: 8px; font-weight: 500; color: #4a5568;">City</label>
                                <input type="text" id="city" name="city" class="form-control" required
                                    value="<?= htmlspecialchars($lastAddress['city'] ?? '') ?>"
                                    style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box;">
                            </div>
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="state" style="display: block; margin-bottom: 8px; font-weight: 500; color: #4a5568;">State</label>
                                <input type="text" id="state" name="state" class="form-control" required
                                    value="<?= htmlspecialchars($lastAddress['state'] ?? '') ?>"
                                    style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box;">
                            </div>
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="pincode" style="display: block; margin-bottom: 8px; font-weight: 500; color: #4a5568;">Pincode</label>
                                <input type="text" id="pincode" name="pincode" class="form-control" required
                                    value="<?= htmlspecialchars($lastAddress['pincode'] ?? '') ?>"
                                    style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box;">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div style="background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #eee;">
                        <h2 style="font-size: 1.5rem; color: #1a1a2e; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-credit-card" style="color: #0d9488;"></i> Payment Method
                        </h2>
                        
                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <label style="display: flex; align-items: center; gap: 15px; padding: 20px; border: 2px solid #0d9488; border-radius: 8px; cursor: pointer; background: #f0fdfa;" id="label_cod">
                                <input type="radio" name="payment_method" value="cod" checked style="width: 20px; height: 20px; accent-color: #0d9488;" onchange="updatePaymentSelection()">
                                <div>
                                    <strong style="display: block; font-size: 1.1rem; color: #1a1a2e;">Cash on Delivery (COD)</strong>
                                    <span style="color: #666; font-size: 0.9rem;">Pay with cash upon delivery.</span>
                                </div>
                                <i class="fas fa-money-bill-wave" style="margin-left: auto; font-size: 1.5rem; color: #0d9488;"></i>
                            </label>

                            <label style="display: flex; align-items: center; gap: 15px; padding: 20px; border: 1px solid #e5e7eb; border-radius: 8px; cursor: pointer; transition: all 0.2s;" id="label_razorpay">
                                <input type="radio" name="payment_method" value="razorpay" style="width: 20px; height: 20px; accent-color: #0d9488;" onchange="updatePaymentSelection()">
                                <div>
                                    <strong style="display: block; font-size: 1.1rem; color: #1a1a2e;">Online Payment (Razorpay Dummy)</strong>
                                    <span style="color: #666; font-size: 0.9rem;">Pay securely using Razorpay test mode.</span>
                                </div>
                                <i class="fas fa-credit-card" style="margin-left: auto; font-size: 1.5rem; color: #6b7280;" id="icon_razorpay"></i>
                            </label>
                            
                            <!-- Hidden input to store Razorpay Payment ID if successful -->
                            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" value="">
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Summary (Sticky) -->
                <div style="background: #f9fafb; padding: 30px; border-radius: 12px; border: 1px solid #e5e7eb; position: sticky; top: 100px;">
                    <h2 style="font-size: 1.5rem; color: #1a1a2e; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #e5e7eb;">Order Summary</h2>
                    
                    <div style="max-height: 350px; overflow-y: auto; margin-bottom: 20px; padding-right: 10px;">
                        <?php foreach ($cartItems as $item): ?>
                            <div style="display: grid; grid-template-columns: 60px 1fr auto; gap: 15px; margin-bottom: 15px; align-items: center;">
                                <div style="position: relative;">
                                    <?php if (!empty($item['image'])): ?>
                                        <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($item['image']) ?>" alt="" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd;">
                                    <?php else: ?>
                                        <div style="width: 60px; height: 60px; background: #eee; border-radius: 6px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-image" style="color: #bbb;"></i></div>
                                    <?php endif; ?>
                                    <span style="position: absolute; top: -8px; right: -8px; background: #64748b; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold; border: 2px solid #fff;">
                                        <?= $item['quantity'] ?>
                                    </span>
                                </div>
                                <div style="line-height: 1.4;">
                                    <h4 style="margin: 0; font-size: 0.95rem; color: #1a1a2e;"><?= htmlspecialchars($item['name']) ?></h4>
                                </div>
                                <div style="font-weight: 600; color: #1a1a2e;">
                                    ₹<?= number_format(($item['sale_price'] ?? $item['price']) * $item['quantity'], 2) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div style="border-top: 1px solid #e5e7eb; padding-top: 20px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; color: #666;">
                            <span>Subtotal</span>
                            <span style="font-weight: 600; color: #1a1a2e;">₹<?= number_format($total, 2) ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; color: #666;">
                            <span>Shipping</span>
                            <span style="font-weight: 600; color: #059669;">FREE</span>
                        </div>
                    </div>

                    <div style="border-top: 2px solid #e5e7eb; margin: 20px 0; padding-top: 20px;">
                        <div style="display: flex; justify-content: space-between; font-size: 1.3rem; font-weight: 700; color: #1a1a2e;">
                            <span>Total</span>
                            <span style="color: #0d9488;">₹<span id="total_amount_display"><?= number_format($total, 2) ?></span></span>
                            <!-- Hidden total for JS access -->
                            <input type="hidden" id="order_total_amount" value="<?= $total ?>">
                        </div>
                    </div>

                    <button type="button" id="place_order_btn" class="btn btn-primary btn-lg" style="width: 100%; padding: 18px; font-size: 1.1rem; border-radius: 8px;" onclick="handleCheckout()">
                        <i class="fas fa-check-circle"></i> Place Order (₹<?= number_format($total, 2) ?>)
                    </button>
                    
                    <p style="text-align: center; color: #666; font-size: 0.85rem; margin-top: 15px;">
                        <i class="fas fa-lock"></i> Secure encrypted checkout
                    </p>
                </div>

            </div>
        </form>
    </div>
</section>

<!-- Razorpay Checkout Script (Custom Dummy Modal) -->
<style>
/* Dummy Modal Styles */
.rzp-modal-overlay {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.6); display: none; align-items: center; justify-content: center; z-index: 9999;
}
.rzp-modal {
    background: #fff; width: 100%; max-width: 400px; border-radius: 8px; overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2); animation: rzpSlide 0.3s ease-out;
}
@keyframes rzpSlide { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.rzp-header { background: #0d9488; color: #fff; padding: 20px; text-align: center; position: relative; }
.rzp-close { position: absolute; right: 15px; top: 15px; cursor: pointer; color: rgba(255,255,255,0.8); font-size: 1.2rem; }
.rzp-body { padding: 30px 20px; text-align: center; }
.rzp-btn { background: #0d9488; color: #fff; border: none; padding: 12px 20px; border-radius: 4px; width: 100%; font-size: 1rem; cursor: pointer; font-weight: bold; margin-bottom: 15px; }
.rzp-btn-fail { background: #fff; color: #dc2626; border: 1px solid #dc2626; padding: 10px 20px; border-radius: 4px; width: 100%; font-size: 0.9rem; cursor: pointer; }
</style>

<div class="rzp-modal-overlay" id="rzpDummyModal">
    <div class="rzp-modal">
        <div class="rzp-header">
            <span class="rzp-close" onclick="closeDummyRazorpay()"><i class="fas fa-times"></i></span>
            <div style="font-size: 1.5rem; margin-bottom: 5px; font-weight: bold;">Razorpay <span style="font-size:0.8rem; background:rgba(255,255,255,0.2); padding: 2px 6px; border-radius:4px; vertical-align:middle;">TEST</span></div>
            <div style="font-size: 0.9rem; opacity: 0.9;">Secure Payment Gateaway</div>
        </div>
        <div class="rzp-body">
            <div style="font-size: 1.8rem; font-weight: bold; color: #1a1a2e; margin-bottom: 5px;" id="rzpDummyAmount">₹0.00</div>
            <div style="color: #64748b; font-size: 0.9rem; margin-bottom: 25px;">Pay to LuxeCart</div>
            
            <p style="color: #4b5563; font-size: 0.9rem; margin-bottom: 20px;">This is a simulated test payment environment. No real money will be deducted.</p>
            
            <button type="button" class="rzp-btn" onclick="simulateSuccess()">Simulate Successful Payment</button>
            <button type="button" class="rzp-btn-fail" onclick="closeDummyRazorpay()">Cancel Payment</button>
        </div>
    </div>
</div>

<script>
    function updatePaymentSelection() {
        const method = document.querySelector('input[name="payment_method"]:checked').value;
        const labelCod = document.getElementById('label_cod');
        const labelRazorpay = document.getElementById('label_razorpay');
        const iconRazorpay = document.getElementById('icon_razorpay');

        if (method === 'cod') {
            labelCod.style.border = '2px solid #0d9488';
            labelCod.style.background = '#f0fdfa';
            labelRazorpay.style.border = '1px solid #e5e7eb';
            labelRazorpay.style.background = 'transparent';
            iconRazorpay.style.color = '#6b7280';
        } else {
            labelRazorpay.style.border = '2px solid #0d9488';
            labelRazorpay.style.background = '#f0fdfa';
            labelCod.style.border = '1px solid #e5e7eb';
            labelCod.style.background = 'transparent';
            iconRazorpay.style.color = '#0d9488';
        }
    }

    function handleCheckout() {
        const form = document.getElementById('checkoutForm');
        
        // Basic HTML5 validation trigger
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const method = document.querySelector('input[name="payment_method"]:checked').value;
        const totalAmount = document.getElementById('order_total_amount').value;
        
        if (method === 'razorpay') {
            // Open Dummy Modal
            document.getElementById('rzpDummyAmount').innerText = '₹' + parseFloat(totalAmount).toFixed(2);
            document.getElementById('rzpDummyModal').style.display = 'flex';
        } else {
            // standard COD submission
            form.submit();
        }
    }
    
    function closeDummyRazorpay() {
        document.getElementById('rzpDummyModal').style.display = 'none';
    }
    
    function simulateSuccess() {
        const form = document.getElementById('checkoutForm');
        // Generate a fake Razorpay ID
        const fakeId = 'pay_' + Math.random().toString(36).substr(2, 14);
        document.getElementById('razorpay_payment_id').value = fakeId;
        
        // Close modal and submit
        closeDummyRazorpay();
        form.submit();
    }
</script>
