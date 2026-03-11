<!-- Order Success Page (Beginner Friendly Design) -->
<div style="min-height: calc(100vh - 130px); background: #f8fafc; padding: 80px 20px; font-family: 'Inter', Arial, sans-serif; line-height: 1.6; display: flex; align-items: center; justify-content: center;">
    <div style="max-width: 600px; width: 100%; background: #fff; border: 2px solid #eee; border-radius: 30px; padding: 60px 40px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
        
        <!-- Success Icon -->
        <div style="width: 100px; height: 100px; background: #0d9488; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto 30px; box-shadow: 0 10px 20px rgba(13, 148, 136, 0.2);">
            <i class="fas fa-check"></i>
        </div>
        
        <h1 style="font-size: 1.5rem; color: #1a1a2e; font-weight: 700; margin-bottom: 15px;">Order Placed!</h1>
        <p style="color: #4b5563; font-size: 1rem; margin-bottom: 40px;">
            Thank you so much for your order! We've received it and our team is already getting it ready for you.
        </p>
        
        <!-- Order Summary Box -->
        <div style="background: #fafafa; border: 2px solid #eee; border-radius: 20px; padding: 30px; margin-bottom: 40px; text-align: left;">
            <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                <span style="color: #888; font-weight: 700; text-transform: uppercase; font-size: 0.85rem;">Order Number</span>
                <strong style="color: #0d9488; font-size: 1.1rem; font-family: monospace;">#ORD-<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></strong>
            </div>
            <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                <span style="color: #888; font-weight: 700; text-transform: uppercase; font-size: 0.85rem;">Total Paid</span>
                <strong style="color: #111; font-size: 1.1rem;">₹<?= number_format($order['total_amount'], 2) ?></strong>
            </div>
            <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                <span style="color: #888; font-weight: 700; text-transform: uppercase; font-size: 0.85rem;">Method</span>
                <strong style="color: #111; font-size: 1rem; text-transform: capitalize;">
                    <?= $order['payment_method'] === 'razorpay' ? 'Online Payment' : 'Cash on Delivery' ?>
                </strong>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="color: #888; font-weight: 700; text-transform: uppercase; font-size: 0.85rem;">Status</span>
                <span style="background: <?= $order['payment_status'] === 'paid' ? '#dcfce7' : '#fef3c7' ?>; color: <?= $order['payment_status'] === 'paid' ? '#15803d' : '#b45309' ?>; padding: 5px 15px; border-radius: 50px; font-weight: 700; font-size: 0.85rem; text-transform: uppercase;">
                    <?= $order['payment_status'] === 'paid' ? 'Paid' : 'Payment Pending' ?>
                </span>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <a href="<?= BASE_URL ?>/customer/orders" class="btn btn-primary" style="display: block; width: 100%; padding: 14px; border-radius: 50px; text-align: center; font-size: 1rem; font-weight: 700; text-decoration: none; background: #0d9488; box-shadow: 0 4px 12px rgba(13, 148, 136, 0.15);">Track My Order</a>
            <a href="<?= BASE_URL ?>/products" style="color: #666; font-weight: 700; text-decoration: none; font-size: 1rem;">Continue Shopping <i class="fas fa-arrow-right" style="margin-left: 5px; font-size: 0.8rem;"></i></a>
        </div>
        
    </div>
</div>

