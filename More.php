<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>More About Us</title>
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

            .Description {
                background: #e4e4e4;
                color: #222;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                justify-content: flex-start;
                padding: 40px;
                padding-top: 20px;
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 81.8%;
                overflow: auto;
            }   

            .Big-text {
                font-size: 2.3rem;
                font-weight: bold;
                margin: 0 0 0 0;
                color: #222;
                letter-spacing: 1.5px;
                margin-top: -40px;
            }

            .line {
                width: 93%;
                background-color: #000000;
                margin-left: 0px;
                margin-top: -10px;
                height: 1rem;
            }

            .text {
                max-width: 92%;
                font-size: 1.2rem;
                color: #222;
                padding-bottom: 30px;
                margin-top: -20px;
                font-weight: bold;
                font-size: 25px;
            }

            .gallery {
                display: flex;
                flex-wrap: wrap;
                width: 180vh;
                gap: 30vh;
            }

            .photo-box {
                position: relative;
                width: 200px;
                height: 200px;
            }

            .photo-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 10px;
                cursor: pointer;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .info-box {
                position: absolute;
                top: 0;
                left: 100%;
                margin-left: 10px;
                width: 180px;
                padding: 12px;
                background-color: #798bff;
                font-weight: bold;
                font-size: 20px;
                color: #fff;
                border: 1px solid #ccc;
                border-radius: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
                z-index: 10;
            }

            .photo-box:hover .info-box {
                opacity: 1;
                pointer-events: auto;
            }
        </style>
    </head>

    <body>
        <div class="upper-container">
            <a href="Main_Menu.php"><div class="title"> <h3> Menu </h3> </div></a>
            <img class="logo" src="Vision-Note_Logo_Black.png" alt = "Logo" width = "80" height = "60">
            <div class="upper-container-content">
            <a href="About_Us.php"><img src="Dev_Info.png" alt="Dev_Info" width="40" height="40"></a>
            <a href="Contact.php"><img src="Chat.png" alt="Chat" width="40" height="40"></a>
            <a href="User.php"><img src="Profile_Placeholder.png" alt="Profile_Placeholder" width="70" height="70"></a>
        </div>

        <div class="Description">
            <div class="Big-text">
                <h1>We've been stuck at full-stack mode please help</h1>
            </div>
            <hr class="line"></hr>
            <div class="text">
                <p>We're six students who started Vision Note as a school project. Originally, we had a grand idea called “Web Canvas”. It was ambitious, bold, and way too hard. We even asked a pro for feedback, and they basically said, “You sure you can finish this?” So we change it.</p>
                <p>Now we're in full-stack mode, building something visual, useful, and way more within our skill level (barely). Powered by caffeine, group chats, and chaotic good energy, Vision Note was born. a creative space to map ideas, manage projects, and organize brain chaos.</p>
                <p>We're still learning, still debugging, and still wondering how we got here… But if Vision Note helps even one person untangle their thoughts? Totally worth it. And yes, we take direct inspiration from "Milanote" because that note web is cool as hell.</p>
            </div>
            <hr class="line"></hr>
            <div class="Big-text"> <h1> Meet The Dev > </div> </h1>
            <div class="gallery">
                <div class="photo-box"><img src="Fotorega.png" class="photo-img" alt="Dev_Info">
                    <div class="info-box"> <p> Rega <br><br> Group Leader, Creative team, back-end coder</p></div>
                </div>
                
                <div class="photo-box"><img src="Fotosamuel.png" class="photo-img" alt="Dev_Info">
                    <div class="info-box"> <p> Samuel <br><br>User Service, Creative team</p></div>
                </div>

                <div class="photo-box"><img src="Fotokhanza.png" class="photo-img" alt="Dev_Info">
                    <div class="info-box"> <p> Khanza <br><br>Database manager, back-end coder</p></div>
                </div>

                <div class="photo-box"><img src="Fotorizki.png" class="photo-img" alt="Dev_Info">
                    <div class="info-box"> <p> Rizky <br><br> full-stack back-end Coder</p></div>
                </div>
                
                <div class="photo-box"><img src="Fotoaurel.png" class="photo-img" alt="Dev_Info">
                    <div class="info-box"> <p> Aurelia <br><br> UI designer, creative team </p></div>
                </div>

                <div class="photo-box"><img src="Fotoazka.png" class="photo-img" alt="Dev_Info">
                    <div class="info-box"> <p> Azka <br><br> UI designer, Front-end coder </p></div>
                </div>
            </div>
    </body>

