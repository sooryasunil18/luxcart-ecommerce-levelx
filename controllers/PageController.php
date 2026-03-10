<?php
class PageController
{
    public function about()
    {
        $pageTitle = 'About Us';
        $currentPage = 'about';
        require BASE_PATH . '/views/layouts/main.php';
    }
}
