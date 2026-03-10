<!-- Order Success Page -->
<section class="section">
    <div class="container" style="max-width: 800px; margin: 0 auto; text-align: center; padding: 60px 20px;">
        
        <div style="background: #fff; padding: 50px 30px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f0f0f0;">
            
            <div style="width: 80px; height: 80px; background: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 20px;">
                <i class="fas fa-check"></i>
            </div>
            
            <h1 style="color: #1a1a2e; margin-bottom: 10px; font-size: 2rem;">Order Confirmed!</h1>
            <p style="color: #64748b; font-size: 1.1rem; margin-bottom: 30px;">
                Thank you for your purchase. Your order has been received and is being processed.
            </p>
            
            <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 25px; margin-bottom: 40px; text-align: left; display: inline-block; min-width: 300px;">
                <div style="margin-bottom: 15px;">
                    <span style="color: #64748b; display: block; font-size: 0.9rem; margin-bottom: 5px;">Order Number:</span>
                    <strong style="color: #0d9488; font-size: 1.2rem; font-family: monospace;">#ORD-<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></strong>
                </div>
                <div style="margin-bottom: 15px;">
                    <span style="color: #64748b; display: block; font-size: 0.9rem; margin-bottom: 5px;">Total Amount:</span>
                    <strong style="color: #1a1a2e; font-size: 1.2rem;">₹<?= number_format($order['total_amount'], 2) ?></strong>
                </div>
                <div>
                    <span style="color: #64748b; display: block; font-size: 0.9rem; margin-bottom: 5px;">Payment Method:</span>
                    <strong style="color: #1a1a2e; font-size: 1.1rem; text-transform: uppercase;">
                        <?php if ($order['payment_method'] === 'razorpay'): ?>
                            <i class="fas fa-credit-card" style="color: #0d9488;"></i> Razorpay
                        <?php else: ?>
                            <i class="fas fa-money-bill-wave" style="color: #0ea5e9;"></i> Cash on Delivery
                        <?php endif; ?>
                    </strong>
                </div>
                <div style="margin-top: 15px;">
                    <span style="color: #64748b; display: block; font-size: 0.9rem; margin-bottom: 5px;">Payment Status:</span>
                    <?php if ($order['payment_status'] === 'paid'): ?>
                        <span style="background: #ecfdf5; color: #059669; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 0.85rem;"><i class="fas fa-check-circle"></i> Paid</span>
                    <?php else: ?>
                        <span style="background: #fffbeb; color: #d97706; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 0.85rem;"><i class="fas fa-clock"></i> Pending (COD)</span>
                    <?php endif; ?>
                </div>
                <?php if ($order['razorpay_payment_id']): ?>
                <div style="margin-top: 15px;">
                    <span style="color: #64748b; display: block; font-size: 0.9rem; margin-bottom: 5px;">Transaction ID:</span>
                    <strong style="color: #64748b; font-size: 0.95rem; font-family: monospace;"><?= htmlspecialchars($order['razorpay_payment_id']) ?></strong>
                </div>
                <?php endif; ?>
            </div>
            
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="<?= BASE_URL ?>/customer/orders" class="btn btn-primary" style="padding: 12px 25px;">
                    <i class="fas fa-box-open"></i> View My Orders
                </a>
                <a href="<?= BASE_URL ?>/products" class="btn btn-outline" style="padding: 12px 25px;">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
            </div>
            
        </div>
        
    </div>
</section>
