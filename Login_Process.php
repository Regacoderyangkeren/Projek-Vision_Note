<?php
session_start();
require_once "Db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = trim($_POST['UsernameOrEmail']);
    $password = $_POST['Password'];

    // Check for hardcoded admin credentials first
    if ($input === 'admin123' && $password === 'Gatheryourm1nd') {
        // Admin login
        $_SESSION['user_id'] = 'admin';
        $_SESSION['username'] = 'admin123';
        $_SESSION['is_admin'] = true;
        
        $_SESSION['success'] = "Welcome Admin!";
        header("Location: Admin_Dashboard.php");
        exit();
    }

    // Check admin table for database admin credentials
    $admin_stmt = $conn->prepare("SELECT id, username, email, password FROM admin WHERE username = ? OR email = ?");
    $admin_stmt->bind_param("ss", $input, $input);
    $admin_stmt->execute();
    $admin_result = $admin_stmt->get_result();

    if ($admin_result && $admin = $admin_result->fetch_assoc()) {
        // Check if password matches (assuming it's stored as plain text in your database)
        if ($password === $admin['password']) {
            // Database admin login successful
            $_SESSION['user_id'] = 'admin_' . $admin['id'];
            $_SESSION['username'] = $admin['username'];
            $_SESSION['is_admin'] = true;
            
            $_SESSION['success'] = "Welcome Admin! Redirecting to dashboard...";
            $delay_seconds = 2;
            header("Refresh: {$delay_seconds} url=Admin_Dashboard.php");
            header("Location: Login_Page.php"); // Show success message first
            exit();
        }
    }
    $admin_stmt->close();

    // Regular user login process
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            // Regular user login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = false;
            
            $_SESSION['success'] = "Login berhasil!";
            header("Location: Main_Menu.php");
            exit();
        } else {
            $_SESSION['error'] = "Password salah!";
        }
    } else {
        $_SESSION['error'] = "Username atau email tidak ditemukan!";
    }

    $stmt->close();
    header("Location: Login_Page.php");
    exit();
}
?>