<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

if (isset($_POST['Send'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $msg ='';

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'visionnoteproject@gmail.com'; 
        $mail->Password = 'bdbhaomdwlwnpjdv';     
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS ; 
        $mail->Port = 587;         

        $mail->setFrom('visionnoteproject@gmail.com', 'Vision Notes'); 
        $mail->addAddress('visionnoteproject@gmail.com'); 
        $mail->addReplyTo($email, $name); 

        $mail->isHTML(true);
        $mail->Subject = 'New Message from Contact Form';
        $mail->Body = "
        <h3>New Message from Contact Form</h3>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Message:</strong><br>$message</p>";
        $mail->AltBody = "Name: $name\nEmail: $email\nMessage:\n$message";
      
        if($mail->send()){
          $msg = "Your Report Has Been Sent Successfully!";
        }
        else {
          $msg = "Ooops! Something Went Wrong. Try Again Later. Error: {$mail->ErrorInfo}";
        }
       
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us</title> 
  <style>
    body {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
      background: #222;
      color: #fff;
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
      padding-right: 40px;
      position: absolute;
      overflow: hidden;
    }

    .title {
      font-size: 1rem;
      font-weight: bold;
      color: #000000;
      position: absolute;
      display: block;
      left: 30px;
      top: 6px;
      overflow: hidden;
      z-index: 10;
      cursor: pointer;
    }

    .logo {
      position: fixed;
      left: 47%;
      overflow: hidden;
      z-index: 1000;
    }

    .contact-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin-top: 10vh;
      padding: 62px 20px;
      background-color: #f9f9f9;
    }

    .contact-title {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 10px;
      color: #333;
    }

    .contact-description {
      font-size: 1rem;
      color: #555;
      margin-bottom: 30px;
      text-align: center;
      max-width: 500px;
    }

    .contact-form {
      background: #fff;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.07);
      display: flex;
      flex-direction: column;
      gap: 18px;
      width: 100%;
      max-width: 400px;
    }

    .contact-form label {
      font-weight: 500;
      margin-bottom: 5px;
      color: #222;
    }

    .contact-form input,
    .contact-form textarea {
      box-sizing: border-box;
      padding: 10px 10px 10px 14px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      resize: none;
      width: 100%;
    }


    .contact-form textarea {
      min-height: 80px;
    }

    .contact-form button {
      padding: 10px 0;
      border: none;
      border-radius: 8px;
      background-color: #3f51b5;
      color: white;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.2s;
    }

    .contact-form button:hover {
      background-color: #2c387e;
    }

    .contact-info {
      margin-top: 30px;
      color: #666;
      font-size: 0.95rem;
      text-align: center;
    }

    .contact-info a {
      color: #3f51b5;
      text-decoration: underline;
    }


  </style>
</head>
<body>

  <!-- HEADER -->
  <div class="upper-container">
    <div class="title"><h3><a href="Main_Menu.php" style="color: inherit; text-decoration: none;">Menu</a></h3></div>
    <img class="logo" src="Vision-Note_Logo_Black.png" alt="Logo" width="80" height="60">
    <div class="upper-container-content">
      <a href="About_Us.php"><img src="Dev_Info.png" alt="Dev_Info" width="40" height="40"></a>
      <a href="Contact.php"><img src="Chat.png" alt="Chat" width="40" height="40"></a>
      <a href="User.php"><img src="Profile_Placeholder.png" alt="Profile_Placeholder" width="70" height="70"></a>
    </div>
  </div>

  <!-- CONTACT SECTION -->
  <div class="contact-container">
    <div class="contact-title">Contact Us</div>
    <div class="contact-description">
      Have questions, feedback, or need support? Fill out the form below and our team will get back to you as soon as possible.
    </div>
    <form  method="POST" action="" class="contact-form">
      <?php if (!empty($msg)) { ?>
      <p style="color:green;"><?= $msg ?></p>
      <?php } ?>
      <div>
        <label for="name">Name</label>
        <input id="name" name="name" type="text" required placeholder="Your Name">
      </div>
      <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required placeholder="you@example.com">
      </div>
      <div>
        <label for="message">Message</label>
        <textarea id="message" name="message" required placeholder="Type your message here..."></textarea>
      </div>
      <button type="submit" name="Send" id="Send">Send Message</button>
    </form>
    <div class="contact-info">
      Or email us directly at <a href="https://mail.google.com/mail/?view=cm&fs=1&to=visionnoteproject@gmail.com&su=&body=&tf=1" target="_blank"">visionnoteproject@gmail.com</a>  
    </div>
  </div>

</body>
</html>
