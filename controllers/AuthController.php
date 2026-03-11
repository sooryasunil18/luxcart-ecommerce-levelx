<?php
class AuthController
{
    public function login()
    {
        $pageTitle = 'Login';
        $currentPage = 'login';
        $error = '';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function loginPost()
    {
        $db = Database::getInstance();
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $error = '';

        if (empty($email) || empty($password)) {
            $error = 'Please fill in all fields.';
        } else {
            $user = $db->fetch("SELECT * FROM users WHERE email = ?", [$email]);

            if ($user && password_verify($password, $user['password'])) {
                $userRole = $user['role'] ?? 'customer';

                if ($userRole === 'seller' && ($user['seller_status'] ?? 'pending') !== 'active') {
                    $error = 'Your seller account is pending admin approval. Please wait for the admin to approve your account.';
                } else {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $userRole;

                    if ($userRole === 'admin') {
                        header('Location: ' . BASE_URL . '/admin');
                    } elseif ($userRole === 'seller') {
                        header('Location: ' . BASE_URL . '/seller');
                    } else {
                        header('Location: ' . BASE_URL . '/account');
                    }
                    exit;
                }
            } else {
                $error = 'Invalid email or password.';
            }
        }

        $pageTitle = 'Login';
        $currentPage = 'login';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function register()
    {
        $pageTitle = 'Register';
        $currentPage = 'register';
        $error = '';
        $success = '';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function registerPost()
    {
        $db = Database::getInstance();
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $role = $_POST['role'] ?? 'customer';
        if (!in_array($role, ['customer', 'seller'])) {
            $role = 'customer';
        }
        $error = '';
        $success = '';

        if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
            $error = 'Please fill in all fields.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif ($password !== $confirmPassword) {
            $error = 'Passwords do not match.';
        } else {
            $existingUser = $db->fetch("SELECT id FROM users WHERE email = ?", [$email]);

            if ($existingUser) {
                $error = 'An account with this email already exists.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $db->insert(
                    "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)",
                    [$name, $email, $hashedPassword, $role]
                );

                if ($role === 'seller') {
                    $_SESSION['register_success'] = 'Registration successful! Please wait for admin approval before logging in.';
                    $_SESSION['register_type'] = 'seller';
                } else {
                    $_SESSION['register_success'] = 'Registration successful! Please login to continue.';
                    $_SESSION['register_type'] = 'customer';
                }

                header('Location: ' . BASE_URL . '/login');
                exit;
            }
        }

        $pageTitle = 'Register';
        $currentPage = 'register';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL . '/');
        exit;
    }
}
