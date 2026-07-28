<?php
// Session Management & Security Helper for Admin Panel
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Credentials (Pode ser estendido para banco de dados)
define('ADMIN_USER', 'admin@caninde.se.gov.br');
define('ADMIN_PASS', 'admin123');

function checkAuth() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: login.php');
        exit;
    }
}

function loginAdmin($email, $password) {
    if ($email === ADMIN_USER && $password === ADMIN_PASS) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $email;
        $_SESSION['admin_name'] = 'Administrador da Prefeitura';
        return true;
    }
    return false;
}

function logoutAdmin() {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
