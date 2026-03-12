<?php
$registerSuccess = '';
$registerType = '';
if (isset($_SESSION['register_success'])) {
    $registerSuccess = $_SESSION['register_success'];
    $registerType = $_SESSION['register_type'] ?? 'customer';
    unset($_SESSION['register_success'], $_SESSION['register_type']);
}
?>

<?php if (!empty($registerSuccess)): ?>
<div class="register-toast-overlay" id="registerToastOverlay">
    <div class="register-toast <?= $registerType === 'seller' ? 'register-toast-warning' : 'register-toast-success' ?>" id="registerToast">
        <div class="register-toast-icon">
            <?php if ($registerType === 'seller'): ?>
                <i class="fas fa-clock"></i>
            <?php else: ?>
                <i class="fas fa-check-circle"></i>
            <?php endif; ?>
        </div>
        <div class="register-toast-body">
            <h3><?= $registerType === 'seller' ? 'Approval Pending' : 'Registration Successful!' ?></h3>
            <p><?= htmlspecialchars($registerSuccess) ?></p>
        </div>
        <button class="register-toast-close" onclick="closeRegisterToast()"><i class="fas fa-times"></i></button>
    </div>
</div>
<style>
    .register-toast-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        animation: fadeInOverlay 0.3s ease;
    }
    .register-toast {
        background: #fff;
        border-radius: 16px;
        padding: 32px 36px;
        max-width: 440px;
        width: 90%;
        display: flex;
        align-items: flex-start;
        gap: 18px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.25);
        animation: slideUp 0.4s ease;
        position: relative;
    }
    .register-toast-icon {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 24px;
    }
    .register-toast-success .register-toast-icon {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
    }
    .register-toast-warning .register-toast-icon {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #fff;
    }
    .register-toast-body h3 {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 6px 0;
        color: #1e293b;
    }
    .register-toast-body p {
        font-size: 14px;
        color: #64748b;
        margin: 0;
        line-height: 1.5;
    }
    .register-toast-success .register-toast-body h3 { color: #059669; }
    .register-toast-warning .register-toast-body h3 { color: #d97706; }
    .register-toast-close {
        position: absolute;
        top: 12px;
        right: 14px;
        background: none;
        border: none;
        color: #94a3b8;
        font-size: 16px;
        cursor: pointer;
        padding: 4px;
        transition: color 0.2s;
    }
    .register-toast-close:hover { color: #334155; }
    @keyframes fadeInOverlay { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(30px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
    .register-toast-overlay.fade-out { animation: fadeOutOverlay 0.4s ease forwards; }
    .register-toast-overlay.fade-out .register-toast { animation: slideDown 0.4s ease forwards; }
    @keyframes fadeOutOverlay { from { opacity: 1; } to { opacity: 0; } }
    @keyframes slideDown { from { opacity: 1; transform: translateY(0) scale(1); } to { opacity: 0; transform: translateY(20px) scale(0.95); } }
</style>
<script>
    function closeRegisterToast() {
        var overlay = document.getElementById('registerToastOverlay');
        overlay.classList.add('fade-out');
        setTimeout(function() { overlay.remove(); }, 400);
    }
    setTimeout(closeRegisterToast, 5000);
</script>
<?php endif; ?>

<section class="auth-section">
    <div class="auth-container">
        <div class="auth-image-panel">
            <!-- Decorative floating shapes -->
            <div class="auth-floating-shape shape-1"></div>
            <div class="auth-floating-shape shape-2"></div>
            <div class="auth-floating-shape shape-3"></div>

            <div class="auth-image-content">
                <div class="auth-brand">
                    <i class="fas fa-shopping-bag logo-icon"></i>
                    <h2>Luxe<span>Cart</span></h2>
                </div>
                <h2>Welcome Back!</h2>
                <p>Log in to your account and continue exploring the best deals on Electronics and Fashion.</p>
                <div class="auth-features">
                    <div class="auth-feature">
                        <div class="auth-feature-icon"><i class="fas fa-truck"></i></div>
                        <span>Free Shipping on orders over ₹499</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-icon"><i class="fas fa-shield-alt"></i></div>
                        <span>100% Secure Payment Gateway</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-icon"><i class="fas fa-headset"></i></div>
                        <span>24/7 Dedicated Customer Support</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-icon"><i class="fas fa-undo"></i></div>
                        <span>Easy Returns & Refund Policy</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="auth-form-panel">
            <div class="auth-form-content">
                <div class="auth-form-header">
                    <h1>Login</h1>
                    <p>Enter your credentials to access your account</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= BASE_URL ?>/login">
                    <div class="form-group">
                        <label>Email Address <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" placeholder="you@example.com" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Enter your password" required>
                            <button type="button" class="password-toggle"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Sign In</button>
                </form>

                <p class="auth-switch">Don't have an account? <a href="<?= BASE_URL ?>/register">Create Account</a></p>
            </div>
        </div>
    </div>
</section>