<?php
session_start();
function is_logged_in() {
    return isset($_SESSION['user']);
}
function require_role($role) {
    if(!is_logged_in() || $_SESSION['user']['role'] !== $role) {
        header('Location: /login.php');
        exit;
    }
}
