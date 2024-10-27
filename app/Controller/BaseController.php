<?php namespace App\Controller;

class BaseController {
    protected function render($view, $data = []) {
        // Extract data to be used in the view
        extract($data);
        // Include the view file
        include "Views/$view.php";
    }

    protected function isAuthenticated() {
        // Example check: assuming you store user info in session
        return isset($_SESSION['user']);
    }
}
