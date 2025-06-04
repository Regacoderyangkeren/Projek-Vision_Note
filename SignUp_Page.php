<?php
// Mulai sesi supaya kita bisa simpan pesan error atau sukses
session_start();
?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Sign Up - Vision Note</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: Arial, sans-serif;
                background: #222;
                color: #fff;
            }

            .Login-Container {
                background: #fff;
                color: #222;
                width: 50vw;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                justify-content: flex-start;
                padding: 50px 60px 25px 40px;
                box-sizing: border-box;
            }

            .Login h1 {
                font-size: 6rem;
                font-weight: bold;
                margin: 0 0 30px 0;
                color: #222;
                letter-spacing: 1.5px;
            }

            .Sign-Up p {
                font-size: 1.5rem;
                color: #444;
                padding-bottom: 30px;
            }

            .Sign-Up strong {
                font-weight: bold;
                color: #222;
            }

            input[type="text"], input[type="email"], input[type="password"] {
                width: 100%;
                max-width: 700px;
                padding: 12px;
                margin-bottom: 20px;
                border: 1.5px solid #000000;
                font-size: 1.2rem;
                background: #ffffff;
                color: #222;
                box-sizing: border-box;
                border-radius: 6px;
                transition: border 0.2s;
            }

            input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
                border: 1.5px solid #798BFF;
                outline: none;
            }

            .submit-button input[type="submit"] {
                width: 100%;
                max-width: 700px;
                padding: 14px;
                border: none;
                font-size: 1.3rem;
                background: #798BFF;
                color: #fff;
                cursor: pointer;
                box-sizing: border-box;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                border-radius: 8px;
                transition: background 0.3s ease;
            }

            .submit-button input[type="submit"]:hover {
                background: #5b6ee9;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            }

            .submit-button input[type="submit"]:focus {
                outline: none;
            }

            .error-message {
                background-color: #ffb3b3;
                color: #800000;
                padding: 10px 15px;
                border-radius: 6px;
                margin-bottom: 20px;
                max-width: 700px;
            }

            .success-message {
                background-color: #b3ffb3;
                color: #006400;
                padding: 10px 15px;
                border-radius: 6px;
                margin-bottom: 20px;
                max-width: 700px;
            }

            a {
                color: inherit;
                text-decoration: none;
                font-weight: bold;
            }

            a:hover {
                text-decoration: underline;
            }

            .Motto-Mission-Container {
                position: absolute;
                top: 0;
                right: 0;
                width: 50vw;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: top;
                text-align: center;
                background: linear-gradient(rgba(0, 0, 0, 0.72), rgba(0, 0, 0, 0.72)), url('Login-Page-BG.png');
                background-size: cover;
                background-position: center;
                padding-top: 40px;
                box-sizing: border-box;
            }

            .vision-Note-Title h1 {
                font-size: 6.5rem;
                margin: 20px 0;
            }

            .Motto p {
                font-size: 2rem;
                margin: -40px;
                padding-bottom: 60px;
            }

            .Mission p {
                font-size: 1.5rem;
                margin: 30px 0;
                max-width: 90%;
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    </head>

    <body>
        <div class="Login-Container">
            <div class="Login">
                <h1>Sign Up</h1>
            </div>

            <div class="Sign-Up">
                <p> Already have an account? <strong> <a href="Login_Page.php"> Login </a> </strong> </p>
            </div>

            <!-- Tampilkan pesan error jika ada -->
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="error-message">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Tampilkan pesan sukses jika ada -->
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="success-message">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <!-- FORM SIGNUP -->
            <form method="POST" action="SignUp_Process.php">
                <input type="text" id="Username" name="Username" placeholder="Buat Username" required>
                <input type="email" id="Email" name="Email" placeholder="Email kamu" required>
                <input type="password" id="Password" name="Password" placeholder="Buat Password" required>
                <input type="password" id="ConfirmPassword" name="ConfirmPassword" placeholder="Konfirmasi Password" required>

                <div class="submit-button">
                    <input type="submit" value="Daftar Sekarang">
                </div>
            </form>
        </div>

        <div class="Motto-Mission-Container">
            <img src="Vision-Note_Logo_White.png" width="150" height="120">
            <div class="vision-Note-Title"> <h1> Vision Note </h1> </div> <br>
            <div class="Motto"> <p> Map your mission, realize your vision. </p> </div> <br><br>
            <div class="Mission">
                <p> Got big <strong> Ideas </strong>? Or just a bunch of <strong> Messy thoughts? </strong> </p>
                <p> Vision Note helps you build ideas, map projects, and bring clarity to your chaos — all in one place. </p>
            </div>
        </div>
    </body>
</html>