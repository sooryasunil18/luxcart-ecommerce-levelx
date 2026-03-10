<?php
class ContactController
{
    public function index()
    {
        $pageTitle = 'Contact Us';
        $currentPage = 'contact';
        $error = '';
        $success = '';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function store()
    {
        $db = Database::getInstance();
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');
        $error = '';
        $success = '';

        if (empty($name) || empty($email) || empty($message)) {
            $error = 'Please fill in all required fields.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } else {
            $db->insert(
                "INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)",
                [$name, $email, $subject, $message]
            );
            $success = 'Thank you for your message! We will get back to you soon.';
            $name = $email = $subject = $message = '';
        }

        $pageTitle = 'Contact Us';
        $currentPage = 'contact';
        require BASE_PATH . '/views/layouts/main.php';
    }
}
