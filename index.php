<?php
// Start session for any future session management
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vision Note - Welcome</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: Arial, sans-serif;
                background: linear-gradient(rgba(0, 0, 0, 0.72), rgba(0, 0, 0, 0.72)), url('Login-Page-BG.png');
                background-size: cover;
                background-position: center;
                color: #fff;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
            }

            .welcome-container {
                max-width: 800px;
                padding: 40px;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .logo-section {
                margin-bottom: 40px;
            }

            .logo-section img {
                margin-bottom: 20px;
            }

            .vision-note-title h1 {
                font-size: 6rem;
                font-weight: bold;
                margin: 0 0 20px 0;
                letter-spacing: 1.5px;
                color: #fff;
            }

            .motto p {
                font-size: 2.2rem;
                margin: 0 0 40px 0;
                color: #fff;
                font-weight: 300;
            }

            .mission {
                margin-bottom: 50px;
            }

            .mission p {
                font-size: 1.6rem;
                margin: 20px 0;
                color: #fff;
                line-height: 1.4;
            }

            .mission strong {
                color: #798BFF;
                font-weight: bold;
            }

            .button-container {
                display: flex;
                gap: 30px;
                justify-content: center;
                flex-wrap: wrap;
            }

            .auth-button {
                padding: 16px 40px;
                font-size: 1.4rem;
                font-weight: bold;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                transition: all 0.3s ease;
                min-width: 150px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
            }

            .login-button {
                background: #798BFF;
                color: #fff;
            }

            .login-button:hover {
                background: #5b6ee9;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(121, 139, 255, 0.4);
            }

            .signup-button {
                background: transparent;
                color: #fff;
                border: 2px solid #798BFF;
            }

            .signup-button:hover {
                background: #798BFF;
                color: #fff;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(121, 139, 255, 0.4);
            }

            .auth-button:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(121, 139, 255, 0.5);
            }

            @media (max-width: 768px) {
                .vision-note-title h1 {
                    font-size: 4rem;
                }

                .motto p {
                    font-size: 1.8rem;
                }

                .mission p {
                    font-size: 1.4rem;
                }

                .welcome-container {
                    margin: 20px;
                    padding: 30px 20px;
                }

                .button-container {
                    flex-direction: column;
                    align-items: center;
                }

                .auth-button {
                    width: 100%;
                    max-width: 250px;
                }
            }
        </style>
    </head>

    <body>
        <div class="welcome-container">
            <div class="logo-section">
                <img src="Vision-Note_Logo_White.png" width="150" height="120" alt="Vision Note Logo">
                <div class="vision-note-title">
                    <h1>Vision Note</h1>
                </div>
                <div class="motto">
                    <p>Map your mission, realize your vision.</p>
                </div>
            </div>

            <div class="mission">
                <p>Got big <strong>Ideas</strong>? Or just a bunch of <strong>Messy thoughts?</strong></p>
                <p>Vision Note helps you build ideas, map projects, and bring clarity to your chaos — all in one place.</p>
            </div>

            <div class="button-container">
                <a href="Login_Page.php" class="auth-button login-button">Login</a>
                <a href="SignUp_Page.php" class="auth-button signup-button">Sign Up</a>
            </div>
        </div>
    </body>
</html>