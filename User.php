<?php
session_start();
require_once 'Db.php'; // koneksi database

// ✅ Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Gunakan user ID dari session
$userId = $_SESSION['user_id'];

// Ambil data user dari database
$sql = "SELECT username, email, Bio, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$username = $user['username'] ?? "User1";
$email = $user['email'] ?? "User@gmail.com";
$defaultBio = $user['Bio'] ?? "Halo! Saya pengguna baru.";
$profilePicture = $user['profile_picture'] ?? "Profile_Placeholder.png";

// Add success/error message variables
$updateMessage = "";
$updateSuccess = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        
        // Create uploads directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = $_FILES['profile_picture']['name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileTmpName = $_FILES['profile_picture']['tmp_name'];
        $fileType = $_FILES['profile_picture']['type'];
        
        // Get file extension
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        
        // Validate file
        if (!in_array($fileExt, $allowedExt)) {
            $updateMessage = "Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau GIF.";
        } elseif ($fileSize > 5000000) { // 5MB limit
            $updateMessage = "File terlalu besar. Maksimal 5MB.";
        } else {
            // Generate unique filename
            $uniqueFileName = uniqid() . '_' . $fileName;
            $uploadPath = $uploadDir . $uniqueFileName;
            
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                // Delete old profile picture if it's not the default
                if ($profilePicture !== 'Profile_Placeholder.png' && file_exists($profilePicture)) {
                    unlink($profilePicture);
                }
                
                // Update profile picture in database
                $updatePicSql = "UPDATE users SET profile_picture = ? WHERE id = ?";
                $updatePicStmt = $conn->prepare($updatePicSql);
                $updatePicStmt->bind_param("si", $uploadPath, $userId);
                
                if ($updatePicStmt->execute()) {
                    $profilePicture = $uploadPath;
                    $updateMessage = "Foto profil berhasil diupdate!";
                    $updateSuccess = true;
                } else {
                    $updateMessage = "Gagal menyimpan foto profil ke database.";
                    error_log("SQL Error: " . $updatePicStmt->error);
                }
                $updatePicStmt->close();
            } else {
                $updateMessage = "Gagal mengupload file.";
            }
        }
    }
    
    // Handle profile info update (username & bio)
    if (isset($_POST['username']) || isset($_POST['bio'])) {
        // Debug: Check if POST data is received
        error_log("POST data received: " . print_r($_POST, true));
        
        $newUsername = trim($_POST["username"] ?? $username);
        $newBio = trim($_POST["bio"] ?? $defaultBio);
        
        // Validate input
        if (empty($newUsername)) {
            $updateMessage = "Username tidak boleh kosong!";
        } else {
            $updateSql = "UPDATE users SET username = ?, Bio = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateSql);
            
            if ($updateStmt) {
                $updateStmt->bind_param("ssi", $newUsername, $newBio, $userId);
                
                if ($updateStmt->execute()) {
                    // Check if any rows were actually affected
                    if ($updateStmt->affected_rows > 0) {
                        $username = $newUsername;
                        $defaultBio = $newBio;
                        $updateMessage = "Profile berhasil diupdate!";
                        $updateSuccess = true;
                    } else {
                        $updateMessage = "Tidak ada perubahan data atau user tidak ditemukan.";
                    }
                } else {
                    $updateMessage = "Gagal update: " . $updateStmt->error;
                    error_log("SQL Error: " . $updateStmt->error);
                }
                $updateStmt->close();
            } else {
                $updateMessage = "Gagal menyiapkan statement: " . $conn->error;
                error_log("Prepare Error: " . $conn->error);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Editable Profile</title>
  <style>
    * {
      margin: 0; padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    html, body {
      height: 100%;
      background-color: #eee;
    }

    .upper-container {
      width: 100%;
      height: 10vh;
      background-color: #ffffff;
      position: absolute;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 4px rgba(11, 11, 11, 0.05);
      top: 0;
      left: 0;
      z-index: 1000;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      overflow: hidden;
    }

    .upper-container-content {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: 30px;
      padding-right: 20px;
      display: absolute;
      position: absolute;
      overflow: hidden;
    }

    .title {
      font-size: 1rem;
      font-weight: bold;
      color: #000000;
      position: absolute;
      display: block;
      overflow: hidden;
      left: 30px;
      top: 25px;
      z-index: 10;
      cursor: pointer;
    }

    .title a {
      text-decoration: none;
      color: inherit;
    }

    .logo {
      position: absolute;
      left: 47%;
      z-index: 1000;
      overflow: hidden;
    }

    .container {
      display: flex;
      height: 100vh;
      background: white;
    }

    .left-side {
      width: 40%;
      height: 100%;
      background-color: #a8b4ff;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .profile-wrapper {
      width: 200px;
      height: 200px;
      background: white;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      position: relative;
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .profile-wrapper:hover {
      transform: scale(1.05);
    }

    .profile-wrapper img {
      width: 180px;
      height: 180px;
      border-radius: 50%;
      object-fit: cover;
    }

    .profile-wrapper::after {
      content: "📷";
      position: absolute;
      bottom: 10px;
      right: 10px;
      background: #a259ff;
      color: white;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .profile-wrapper:hover::after {
      opacity: 1;
    }

    #profile-upload {
      display: none;
    }

    .upload-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(162, 89, 255, 0.8);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.3s ease;
      color: white;
      font-size: 16px;
      font-weight: bold;
    }

    .profile-wrapper:hover .upload-overlay {
      opacity: 1;
    }

    .right-side {
      width: 60%;
      height: 100%;
      padding: 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    h2 {
      font-size: 36px;
      margin-top: 10px;
      margin-bottom: 30px;
      text-align: center;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    .info-block {
      margin-bottom: 20px;
      font-size: 20px;
      position: relative;
      display: flex;
      align-items: center;
    }

    .info-block span {
      flex: 1;
      font-size: 18px;
      word-wrap: break-word;
    }

    .info-block input,
    .info-block textarea {
      flex: 1;
      font-size: 18px;
      padding: 8px;
      border-radius: 8px;
      border: 1px solid #ccc;
      display: none;
      resize: vertical;
    }

    .info-block.editing span {
      display: none;
    }

    .info-block.editing input,
    .info-block.editing textarea {
      display: block;
    }

    .info-block .actions {
      margin-left: 10px;
      display: flex;
      gap: 8px;
    }

    .actions button {
      background: none;
      border: none;
      cursor: pointer;
      font-size: 20px;
      line-height: 1;
      padding: 0;
      color: #555;
      transition: color 0.3s;
    }

    .actions button:hover {
      color: #a259ff;
    }

    .actions .save-btn {
      display: none;
    }

    .info-block.editing .save-btn {
      display: inline;
    }

    #email-block span {
      font-size: 18px;
      flex: 1;
    }

    button.save-all {
      padding: 14px;
      font-size: 16px;
      font-weight: bold;
      background-color: #a259ff;
      color: white;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      margin-top: 20px;
      align-self: center;
      width: 160px;
    }

    .message {
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      text-align: center;
    }

    .success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
  </style>
</head>
<body>

  <!-- Upper Navigation Bar -->
  <div class="upper-container">
    <div class="title"><h3><a href="Main_Menu.php">Menu</a></h3></div>
    <img class="logo" src="Vision-Note_Logo_Black.png" alt="Logo" width="80" height="60">
    <div class="upper-container-content">
      <a href="About_Us.php"><img src="Dev_Info.png" alt="Dev Info" width="40" height="40"></a>
      <a href="Contact.php"><img src="Chat.png" alt="Chat" width="40" height="40"></a>
      <a href="User.php"><img src="Profile_Placeholder.png" alt="Profile" width="70" height="70"></a>
    </div>
  </div>

  <!-- Main Profile Container -->
  <div class="container">
    <div class="left-side">
      <div class="profile-wrapper" onclick="document.getElementById('profile-upload').click()">
        <img src="<?= htmlspecialchars($profilePicture) ?>" alt="User Icon" id="profile-image" />
        <div class="upload-overlay">
          Click to change photo
        </div>
      </div>
      
      <!-- Hidden file input -->
      <form id="upload-form" method="POST" enctype="multipart/form-data" style="display: none;">
        <input type="file" id="profile-upload" name="profile_picture" accept="image/*" onchange="handleImageUpload(this)">
      </form>
    </div>

    <div class="right-side">
      <h2>Welcome !!</h2>
      
      <!-- Display update message -->
      <?php if (!empty($updateMessage)): ?>
        <div class="message <?= $updateSuccess ? 'success' : 'error' ?>">
          <?= htmlspecialchars($updateMessage) ?>
        </div>
      <?php endif; ?>
      
      <form method="POST" id="profileForm">
        <!-- Username -->
        <div class="info-block" id="username-block">
          <span id="username-display"><?= htmlspecialchars($username) ?></span>
          <input type="text" name="username" id="username-input" value="<?= htmlspecialchars($username) ?>" required />
          <div class="actions">
            <button type="button" onclick="editField('username-block')" title="Edit Username">✏️</button>
            <button type="button" onclick="saveUsername()" title="Save Username" class="save-btn">✅</button>
          </div>
        </div>

        <!-- Email (not editable) -->
        <div class="info-block" id="email-block">
          <span id="email-display"><?= htmlspecialchars($email) ?></span>
        </div>

        <!-- Bio -->
        <div class="info-block" id="bio-block">
            <span id="bio-display"><?= nl2br(htmlspecialchars($defaultBio)) ?></span>
            <textarea name="bio" id="bio-input" rows="4"><?= htmlspecialchars($defaultBio) ?></textarea>
            <div class="actions">
                <button type="button" onclick="editField('bio-block')">✏️</button>
                <button type="button" onclick="saveBio()" class="save-btn">✅</button>
            </div>
        </div>

        <!-- Save All Changes Button -->
        <button type="submit" class="save-all">Save All Changes</button>

        <!-- Logout -->
        <button type="button" class="save-all" onclick="window.location.href='Login_Page.php'" style="background-color: #dc3545; margin-top: 10px;">Logout</button>
      </form>
    </div>
  </div>

  <script>
    function editField(id) {
      const block = document.getElementById(id);
      block.classList.add('editing');
      const input = block.querySelector('input, textarea');
      if (input) input.focus();
    }

    function saveUsername() {
      const input = document.getElementById('username-input');
      const span = document.getElementById('username-display');

      if (!input.value.trim()) {
        alert("Username tidak boleh kosong!");
        input.focus();
        return;
      }

      // Update display
      span.textContent = input.value;
      document.getElementById('username-block').classList.remove('editing');
      
      // Submit form to save to database
      document.getElementById('profileForm').submit();
    }

    function saveBio() {
      const input = document.getElementById('bio-input');
      const span = document.getElementById('bio-display');

      // Update display (allow empty bio)
      span.innerHTML = input.value.replace(/\n/g, "<br>");
      document.getElementById('bio-block').classList.remove('editing');
      
      // Submit form to save to database
      document.getElementById('profileForm').submit();
    }

    function handleImageUpload(input) {
      if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
          alert('Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau GIF.');
          input.value = '';
          return;
        }
        
        // Validate file size (5MB)
        if (file.size > 5000000) {
          alert('File terlalu besar. Maksimal 5MB.');
          input.value = '';
          return;
        }
        
        // Preview the image
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('profile-image').src = e.target.result;
        };
        reader.readAsDataURL(file);
        
        // Show loading message
        const overlay = document.querySelector('.upload-overlay');
        overlay.innerHTML = 'Uploading...';
        
        // Submit the form
        document.getElementById('upload-form').submit();
      }
    }

    // Auto-hide success messages after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
      const successMessage = document.querySelector('.message.success');
      if (successMessage) {
        setTimeout(function() {
          successMessage.style.opacity = '0';
          setTimeout(function() {
            successMessage.style.display = 'none';
          }, 300);
        }, 3000);
      }
    });
  </script>

</body>
</html>