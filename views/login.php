<section class="auth-section">
    <div class="auth-container">
        <div class="auth-image-panel">
            <div class="auth-image-content">
                <h2>Welcome Back!</h2>
                <p>Log in to access your account and continue shopping.</p>
            </div>
        </div>
        <div class="auth-form-panel">
            <div class="auth-form-content">
                <div class="auth-form-header">
                    <h1>Login</h1>
                    <p>Enter your credentials to continue</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= BASE_URL ?>/login">
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
                            <input type="password" name="password" placeholder="Enter your password" required>
                            <button type="button" class="password-toggle"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
                </form>

                <p class="auth-switch">Don't have an account? <a href="<?= BASE_URL ?>/register">Register</a></p>
            </div>
        </div>
    </div>
</section>