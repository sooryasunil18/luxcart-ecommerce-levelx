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
                <h2>Join LuxeCart Today</h2>
                <p>Create your free account and start shopping the best Electronics and Fashion products.</p>
                <div class="auth-features">
                    <div class="auth-feature">
                        <div class="auth-feature-icon"><i class="fas fa-tag"></i></div>
                        <span>Exclusive Member-Only Discounts</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-icon"><i class="fas fa-bolt"></i></div>
                        <span>Early Access to Flash Sales</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-icon"><i class="fas fa-heart"></i></div>
                        <span>Save Favorites to Your Wishlist</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-icon"><i class="fas fa-store"></i></div>
                        <span>Sell Your Products as a Seller</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="auth-form-panel">
            <div class="auth-form-content">
                <div class="auth-form-header">
                    <h1>Create Account</h1>
                    <p>Fill in the details below to get started</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= BASE_URL ?>/register">
                    <div class="form-group">
                        <label>Full Name <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name" placeholder="Enter your full name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Register As <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-user-tag"></i>
                            <select name="role" required>
                                <option value="customer">Customer (Buy Products)</option>
                                <option value="seller">Seller (Sell Products)</option>
                            </select>
                        </div>
                    </div>
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
                            <input type="password" name="password" placeholder="Create a strong password" required>
                            <button type="button" class="password-toggle"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="confirm_password" placeholder="Confirm your password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Create Account</button>
                </form>

                <p class="auth-switch">Already have an account? <a href="<?= BASE_URL ?>/login">Sign In</a></p>
            </div>
        </div>
    </div>
</section>