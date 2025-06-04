<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About Us</title>
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
                display: inline-block;
                flex-direction: column;
                align-items: flex-start;
                justify-content: flex-start;
                padding: 40px;
                padding-top: 20px;
                position: fixed;
                bottom: -60px;
                left: 0;
                width: 56%;
                height: 90vh;
            }

            .hello-there {
                font-size: 6rem;
                font-weight: bold;
                margin: 0 0 0 0;
                color: #222;
                letter-spacing: 1.5px;  
            }

            .line {
                width: 66%;
                height: 2px;
                background-color: #000000;
                margin: 20px 0;
            }

            .text p {
                font-size: 1.3rem;
                margin: 0px 0;
                max-width: 90%;
                font-weight: bold;
                padding-bottom: 30px;
            }

            .Learn-Button {
                margin-top: 30px;
                width: 170px;
                height: 50px;
                background-color: #798BFF;
                border-radius: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                position: static    ;
            }

            .Learn-Button:hover {
                background-color: #546af6;
                transform: scale(1.05);
                transition: all 0.2s ease-in-out;
            }

            .Foto-Kelompok {
                display: inline-block;
                position: fixed;
                top: 10vh;
                right: 0px;
                align-items: flex-end;
                justify-content: flex-end;
                bottom: 0;
            }
        </style>
    </head>

    <body>
        <div class="upper-container">
            <div class="title"> <h3> <a href="Main_Menu.php" style="color: inherit; text-decoration: none;"> Menu </a> </h3> </div>
            <img class="logo" src="Vision-Note_Logo_Black.png" alt = "Logo" width = "80" height = "60">
            <div class="upper-container-content">
            <a href="About_Us.php"><img src="Dev_Info.png" alt="Dev_Info" width="40" height="40"></a>
            <a href="Contact.php"><img src="Chat.png" alt="Chat" width="40" height="40"></a>
            <a href="User.php"><img src="Profile_Placeholder.png" alt="Profile_Placeholder" width="70" height="70"></a>
        </div>

    
        <div class="Description"> 
            <div class="hello-there"> Hello There! </div>
            <hr class="line">
            <div class="text">
                <p> At Vision Note, we believe ideas deserve more than a checklist or a forgotten tab. We're here for the thinkers, planners, and creators — anyone turning thoughts into something real. </p>
                <p> Whether you're mapping out a big idea, organizing your workflow, or just capturing that midnight spark, Vision Note helps bring clarity and structure to the creative process. </p>
                <p> We're not just a note app. </p>
                <p> We're a space to think visually, plan clearly, and move ideas forward. </p>
            </div>
            
            <div class="Learn-Button">
                <a href="More.php"> <button style="
                border: none;
                background: none;
                color: white;
                font-weight: bold;
                cursor: pointer;
                font-size: 16px;"> Learn More </button> </a>
            </div>  
        </div>
        
        <div class="Foto-Kelompok">
            <img src="Foto-Kelompok.png" width="671" height="750" alt="Foto-Kelompok">
        </div>
    </body>
</html> 