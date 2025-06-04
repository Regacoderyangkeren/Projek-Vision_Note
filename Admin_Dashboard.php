<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: Login_Page.php");
    exit();
}

require_once "Db.php";

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'delete_user':
                $user_id = intval($_POST['user_id']);
                $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
                $stmt->bind_param("i", $user_id);
                if ($stmt->execute()) {
                    $_SESSION['success'] = "User deleted successfully!";
                } else {
                    $_SESSION['error'] = "Failed to delete user!";
                }
                $stmt->close();
                header("Location: Admin_Dashboard.php");
                exit();
                break;
                
            case 'add_admin':
                $username = trim($_POST['username']);
                $email = trim($_POST['email']);
                $password = $_POST['password'];
                
                if (!empty($username) && !empty($email) && !empty($password)) {
                    // Check if admin already exists
                    $check_stmt = $conn->prepare("SELECT id FROM admin WHERE username = ? OR email = ?");
                    $check_stmt->bind_param("ss", $username, $email);
                    $check_stmt->execute();
                    $check_result = $check_stmt->get_result();
                    
                    if ($check_result->num_rows > 0) {
                        $_SESSION['error'] = "Admin with this username or email already exists!";
                    } else {
                        $stmt = $conn->prepare("INSERT INTO admin (username, email, password) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $username, $email, $password);
                        if ($stmt->execute()) {
                            $_SESSION['success'] = "New admin added successfully!";
                        } else {
                            $_SESSION['error'] = "Failed to add admin!";
                        }
                        $stmt->close();
                    }
                    $check_stmt->close();
                } else {
                    $_SESSION['error'] = "Please fill all fields!";
                }
                header("Location: Admin_Dashboard.php");
                exit();
                break;
        }
    }
}

// Get all users
$users_query = "SELECT id, username, email, created_at FROM users ORDER BY created_at DESC";
$users_result = $conn->query($users_query);
$users = $users_result ? $users_result->fetch_all(MYSQLI_ASSOC) : [];

// Count users
$user_count = count($users);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard - Vision Note</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: Arial, sans-serif;
                background: #222;
                color: #fff;
                min-height: 100vh;
            }

            .header {
                background: #333;
                padding: 20px 40px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 3px solid #798BFF;
            }

            .header h1 {
                color: #798BFF;
                font-size: 2.5rem;
                font-weight: bold;
                margin: 0;
            }

            .user-info {
                display: flex;
                align-items: center;
                gap: 20px;
                font-size: 1.1rem;
            }

            .logout-btn {
                background: #e74c3c;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                text-decoration: none;
                font-size: 1rem;
                font-weight: bold;
                transition: background 0.3s ease;
            }

            .logout-btn:hover {
                background: #c0392b;
            }

            .container {
                max-width: 1000px;
                margin: 30px auto;
                padding: 0 30px;
            }

            .section {
                background: #333;
                border-radius: 10px;
                padding: 30px;
                margin-bottom: 30px;
                border: 1px solid #444;
            }

            .section-title {
                font-size: 1.8rem;
                color: #798BFF;
                margin-bottom: 20px;
                font-weight: bold;
            }

            .alert {
                padding: 15px;
                border-radius: 6px;
                margin-bottom: 20px;
                font-weight: bold;
            }

            .alert-success {
                background: #2ecc71;
                color: white;
            }

            .alert-error {
                background: #e74c3c;
                color: white;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                display: block;
                margin-bottom: 8px;
                font-weight: bold;
                color: #798BFF;
            }

            input[type="text"], input[type="email"], input[type="password"] {
                width: 100%;
                max-width: 400px;
                padding: 12px;
                border: 1.5px solid #555;
                background: #444;
                color: #fff;
                border-radius: 6px;
                font-size: 1rem;
                box-sizing: border-box;
            }

            input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
                border-color: #798BFF;
                outline: none;
            }

            .btn {
                padding: 12px 20px;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                font-size: 1rem;
                font-weight: bold;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-block;
            }

            .btn-primary {
                background: #798BFF;
                color: white;
            }

            .btn-primary:hover {
                background: #5b6ee9;
            }

            .btn-danger {
                background: #e74c3c;
                color: white;
                padding: 8px 15px;
                font-size: 0.9rem;
            }

            .btn-danger:hover {
                background: #c0392b;
            }

            .users-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
            }

            .users-table th,
            .users-table td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #555;
            }

            .users-table th {
                background: #444;
                color: #798BFF;
                font-weight: bold;
            }

            .users-table tr:hover {
                background: #444;
            }

            .user-count {
                background: #798BFF;
                color: white;
                padding: 10px 20px;
                border-radius: 6px;
                display: inline-block;
                margin-bottom: 20px;
                font-weight: bold;
            }

            .no-users {
                text-align: center;
                color: #888;
                font-style: italic;
                padding: 40px;
            }

            @media (max-width: 768px) {
                .header {
                    flex-direction: column;
                    gap: 15px;
                    text-align: center;
                }

                .container {
                    padding: 0 20px;
                }

                .section {
                    padding: 20px;
                }

                input[type="text"], input[type="email"], input[type="password"] {
                    max-width: 100%;
                }

                .users-table {
                    font-size: 0.9rem;
                }
            }
        </style>
    </head>

    <body>
        <div class="header">
            <h1>🎯 Admin Dashboard</h1>
            <div class="user-info">
                <span>Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
                <a href="Login_Page.php" class="logout-btn">Logout</a>
            </div>
        </div>

        <div class="container">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    ✅ <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    ❌ <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Add New Admin Section -->
            <div class="section">
                <h2 class="section-title">➕ Add New Admin</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="add_admin">
                    
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" name="username" required placeholder="Enter admin username">
                    </div>
                    
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" required placeholder="Enter admin email">
                    </div>
                    
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" name="password" required placeholder="Enter admin password">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add Admin</button>
                </form>
            </div>

            <!-- User Management Section -->
            <div class="section">
                <h2 class="section-title">👥 User Management</h2>
                <div class="user-count">Total Users: <?= $user_count ?></div>
                
                <?php if (!empty($users)): ?>
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Joined Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>#<?= htmlspecialchars($user['id']) ?></td>
                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                                    <td>
                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete user: <?= htmlspecialchars($user['username']) ?>?')">
                                            <input type="hidden" name="action" value="delete_user">
                                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                            <button type="submit" class="btn btn-danger">🗑️ Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-users">
                        <p>📭 No users found in the database.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </body>
</html>