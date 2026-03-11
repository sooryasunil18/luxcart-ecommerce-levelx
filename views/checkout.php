<!-- Secure Checkout Page (Beginner Friendly Design) -->
<div style="min-height: calc(100vh - 130px); background: #f8fafc; padding: 50px 0; font-family: 'Inter', Arial, sans-serif; line-height: 1.6;">
    <div style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
        <!-- Simple Header -->
        <div style="margin-bottom: 40px; text-align: center;">
            <div style="font-size: 2.5rem; color: #0d9488; margin-bottom: 15px;"><i class="fas fa-lock"></i></div>
            <h1 style="font-size: 1.5rem; color: #1a1a2e; font-weight: 700; margin: 0 0 10px 0;">Secure Checkout</h1>
            <p style="color: #4b5563; font-size: 1rem;">Almost there! Just a few more details to complete your order.</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div style="background: #fee2e2; color: #b91c1c; padding: 15px 25px; border-radius: 12px; border: 1px solid #fecaca; margin-bottom: 30px; font-weight: 600;">
                <i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i> <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/checkout/process" method="POST" id="checkoutForm">
            <div style="display: grid; grid-template-columns: 1fr 400px; gap: 40px; align-items: start;">
                
                <!-- Left Column: Details -->
                <div>
                    <!-- Shipping Section -->
                    <div style="background: #fff; border: 2px solid #eee; border-radius: 20px; padding: 40px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                        <h2 style="font-size: 1.6rem; color: #111; margin-bottom: 30px; font-weight: 800; display: flex; align-items: center; gap: 15px;">
                            <span style="width: 35px; height: 35px; background: #0d9488; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem;">1</span>
                            Where should we send your order?
                        </h2>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #444; font-size: 0.9rem; text-transform: uppercase;">Full Name</label>
                                <input type="text" name="full_name" required value="<?= htmlspecialchars($lastAddress['full_name'] ?? '') ?>" 
                                    style="width: 100%; padding: 15px; border: 2px solid #eee; border-radius: 12px; font-size: 1rem; outline: none; transition: border-color 0.2s;" 
                                    onfocus="this.style.borderColor='#0d9488'" onblur="this.style.borderColor='#eee'">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #444; font-size: 0.9rem; text-transform: uppercase;">Phone Number</label>
                                <input type="tel" name="phone" required value="<?= htmlspecialchars($lastAddress['phone'] ?? '') ?>"
                                    style="width: 100%; padding: 15px; border: 2px solid #eee; border-radius: 12px; font-size: 1rem; outline: none;"
                                    onfocus="this.style.borderColor='#0d9488'" onblur="this.style.borderColor='#eee'">
                            </div>
                        </div>

                        <div style="margin-bottom: 25px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #444; font-size: 0.9rem; text-transform: uppercase;">Full Address</label>
                            <textarea name="address" required rows="3"
                                style="width: 100%; padding: 15px; border: 2px solid #eee; border-radius: 12px; font-size: 1rem; outline: none; resize: none;"
                                onfocus="this.style.borderColor='#0d9488'" onblur="this.style.borderColor='#eee'"><?= htmlspecialchars($lastAddress['address'] ?? '') ?></textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #444; font-size: 0.9rem; text-transform: uppercase;">City</label>
                                <input type="text" name="city" required value="<?= htmlspecialchars($lastAddress['city'] ?? '') ?>"
                                    style="width: 100%; padding: 15px; border: 2px solid #eee; border-radius: 12px; font-size: 1rem; outline: none;"
                                    onfocus="this.style.borderColor='#0d9488'" onblur="this.style.borderColor='#eee'">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #444; font-size: 0.9rem; text-transform: uppercase;">State</label>
                                <input type="text" name="state" required value="<?= htmlspecialchars($lastAddress['state'] ?? '') ?>"
                                    style="width: 100%; padding: 15px; border: 2px solid #eee; border-radius: 12px; font-size: 1rem; outline: none;"
                                    onfocus="this.style.borderColor='#0d9488'" onblur="this.style.borderColor='#eee'">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #444; font-size: 0.9rem; text-transform: uppercase;">Pincode</label>
                                <input type="text" name="pincode" required value="<?= htmlspecialchars($lastAddress['pincode'] ?? '') ?>"
                                    style="width: 100%; padding: 15px; border: 2px solid #eee; border-radius: 12px; font-size: 1rem; outline: none;"
                                    onfocus="this.style.borderColor='#0d9488'" onblur="this.style.borderColor='#eee'">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div style="background: #fff; border: 2px solid #eee; border-radius: 20px; padding: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                        <h2 style="font-size: 1.6rem; color: #111; margin-bottom: 30px; font-weight: 800; display: flex; align-items: center; gap: 15px;">
                            <span style="width: 35px; height: 35px; background: #0d9488; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem;">2</span>
                            How would you like to pay?
                        </h2>
                        
                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            <label style="display: flex; align-items: center; gap: 20px; padding: 25px; border: 2px solid #0d9488; border-radius: 15px; cursor: pointer; background: #f0fdfa; transition: all 0.2s;" id="label_cod">
                                <input type="radio" name="payment_method" value="cod" checked style="width: 25px; height: 25px; accent-color: #0d9488;" onchange="updatePaymentSelection()">
                                <div>
                                    <strong style="display: block; font-size: 1.2rem; color: #111;">Cash on Delivery (COD)</strong>
                                    <span style="color: #666; font-size: 1rem;">Pay with cash when your package arrives.</span>
                                </div>
                                <i class="fas fa-money-bill-wave" style="margin-left: auto; font-size: 2rem; color: #0d9488;"></i>
                            </label>

                            <label style="display: flex; align-items: center; gap: 20px; padding: 25px; border: 2px solid #eee; border-radius: 15px; cursor: pointer; transition: all 0.2s;" id="label_razorpay">
                                <input type="radio" name="payment_method" value="razorpay" style="width: 25px; height: 25px; accent-color: #0d9488;" onchange="updatePaymentSelection()">
                                <div>
                                    <strong style="display: block; font-size: 1.2rem; color: #111;">Online Payment (Razorpay)</strong>
                                    <span style="color: #666; font-size: 1rem;">Pay securely using your preferred online method.</span>
                                </div>
                                <i class="fas fa-credit-card" style="margin-left: auto; font-size: 2rem; color: #aaa;" id="icon_razorpay"></i>
                            </label>

                            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" value="">
                        </div>
                    </div>
                </div>

                <!-- Right Column: Summary -->
                <div style="position: sticky; top: 50px;">
                    <div style="background: #fff; border: 2px solid #eee; border-radius: 20px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                        <h3 style="margin: 0 0 25px 0; font-size: 1.4rem; color: #111; font-weight: 800;">Order Summary</h3>
                        
                        <div style="max-height: 250px; overflow-y: auto; margin-bottom: 25px; padding-right: 5px;">
                            <?php foreach ($cartItems as $item): ?>
                                <div style="display: flex; gap: 15px; margin-bottom: 20px; align-items: center;">
                                    <div style="width: 60px; height: 60px; background: #f9f9f9; border-radius: 10px; overflow: hidden; border: 1px solid #eee; flex-shrink: 0; position: relative;">
                                        <?php if (!empty($item['image'])): ?>
                                            <img src="<?= BASE_URL ?>/public/images/<?= rawurlencode($item['image']) ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                        <?php endif; ?>
                                        <span style="position: absolute; top: -5px; right: -5px; background: #333; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800; border: 2px solid #fff;"><?= $item['quantity'] ?></span>
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-size: 0.95rem; color: #111; font-weight: 600; line-height: 1.3;"><?= htmlspecialchars($item['name']) ?></div>
                                        <div style="font-weight: 700; color: #0d9488; margin-top: 4px;">₹<?= number_format(($item['sale_price'] ?? $item['price']) * $item['quantity'], 2) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div style="border-top: 2px solid #f9f9f9; padding-top: 20px; margin-bottom: 30px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; color: #666; font-size: 1.1rem;">
                                <span>Subtotal</span>
                                <span style="color: #111; font-weight: 700;">₹<?= number_format($total, 2) ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 20px; color: #0d9488; font-size: 1.1rem; font-weight: 700;">
                                <span>Shipping</span>
                                <span>FREE</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 1.6rem; color: #111; font-weight: 800; border-top: 2px solid #f9f9f9; padding-top: 15px;">
                                <span>Total</span>
                                <span style="color: #0d9488;">₹<?= number_format($total, 2) ?></span>
                            </div>
                            <input type="hidden" id="order_total_amount" value="<?= $total ?>">
                        </div>

                        <button type="button" id="place_order_btn" style="display: block; width: 100%; padding: 14px; border-radius: 50px; border: none; background: #0d9488; color: #fff; font-size: 1rem; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(13, 148, 136, 0.15); transition: background 0.2s;" 
                            onclick="handleCheckout()" onmouseover="this.style.background='#0a7a70'" onmouseout="this.style.background='#0d9488'">
                            <i class="fas fa-check-circle" style="margin-right: 10px;"></i> Confirm Order
                        </button>
                        
                        <div style="text-align: center; margin-top: 20px; color: #888; font-size: 0.9rem;">
                            <i class="fas fa-shield-alt"></i> 256-bit Secure Encryption
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>


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
