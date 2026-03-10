<section class="auth-section">
    <div class="auth-container">
        <div class="auth-image-panel">
            <div class="auth-image-content">
                <h2>Join LuxeCart</h2>
                <p>Create an account to start shopping the best Electronics and Fashion.</p>
            </div>
        </div>
        <div class="auth-form-panel">
            <div class="auth-form-content">
                <div class="auth-form-header">
                    <h1>Register</h1>
                    <p>Create your free account</p>
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
                            <input type="text" name="name" placeholder="Enter your name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Register As <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-user-tag"></i>
                            <select name="role" required
                                style="width: 100%; border: none; outline: none; background: transparent; padding-left: 10px; color: #555; cursor: pointer;">
                                <option value="customer">Customer (Buy Products)</option>
                                <option value="seller">Seller (Sell Products)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Create a password" required>
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
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Register</button>
                </form>

                <p class="auth-switch">Already have an account? <a href="<?= BASE_URL ?>/login">Login</a></p>
            </div>
        </div>
    </div>
</section>