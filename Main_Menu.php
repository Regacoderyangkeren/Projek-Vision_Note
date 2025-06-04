<?php
session_start();
include "Db.php"; // Pastikan ini mengarah ke file koneksi database yang benar
$result = mysqli_query($conn, "SELECT * FROM notes");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Main Menu </title>
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            display: absolute;
            position: absolute;
            align-items: center;
            justify-content: flex-end;
            gap: 30px;
            padding-right: 40px;
            display: flex;
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

        .down-container {
            width: 100%;
            height: 90vh;
            background-color: #d9d9d9;
            position: fixed;
            bottom: 0;
            left: 0;
        }

        .Create-Button {
            position: fixed;
            top: 100px;
            left: 30px;
            width: 170px;
            height: 50px;
            background-color: #798BFF;
            border-radius: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .Create-Button:hover {
            background-color: #546af6;
            transform: scale(1.05);
            transition: all 0.2s ease-in-out;
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
        
    <div class="down-container"> 
        <div class="Create-Button">
            <button style="
            border: none;
            background: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;"> + Create New Note </button>
        </div>
    </div>
    
    <script>
        document.querySelector('.Create-Button').addEventListener('click', async function() {
        const container = document.querySelector('.down-container');
        let boxes = container.querySelectorAll('.note-box');
        
        try {
            const response = await fetch('create_note.php', { method: 'POST' });
            if (!response.ok) throw new Error('Failed to create note');
            const data = await response.json();
            
            const box = document.createElement('div');
            box.className = 'note-box';
            box.dataset.id = data.id;  // simpan id note dari db
            box.style.cssText = `
                width: 280px;
                height: 170px;
                background-color: #ffffff;
                position: absolute;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                left: ${data.pos_x}px;
                top: ${data.pos_y}px;
            `;

            const margin = 30;
            const startTop = 100;
            const boxWidth = 280;
            const containerWidth = container.offsetWidth;
            const boxesPerRow = Math.floor((containerWidth - margin) / (boxWidth + margin));

            const row = Math.floor(boxes.length / boxesPerRow);
            const col = boxes.length % boxesPerRow;

            box.style.left = `${margin + col * (boxWidth + margin)}px`;
            box.style.top = `${startTop + row * (boxWidth + margin)}px`;

            container.appendChild(box);
        } catch (err) {
            alert(err.message);
        }
    });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('note-box')) {
                const parentBox = e.target;
                const existingChild = document.querySelector(`.child-note-box[data-parent="${parentBox.offsetLeft}-${parentBox.offsetTop}"]`);
                
                if (existingChild) {
                    existingChild.remove();
                    return;
                }
                
                const childBox = document.createElement('div');
                childBox.className = 'child-note-box';
                childBox.setAttribute('data-parent', `${parentBox.offsetLeft}-${parentBox.offsetTop}`);
                
                childBox.style.cssText = `
                    width: 250px;
                    height: 70px;
                    background-color: #e9e9e9;
                    position: absolute;
                    margin-top: -5px;   
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                    top: ${parentBox.offsetTop + parentBox.offsetHeight}px;
                    left: ${parentBox.offsetLeft}px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 0 15px;
                `;

                // Add editable text on the left
                const editableText = document.createElement('div');
                editableText.contentEditable = true;
                editableText.innerText = parentBox.dataset.title || 'Edit me';
                editableText.style.cssText = `
                    flex: 1;
                    color: #222;
                    font-size: 16px;
                    font-weight: 700;
                    outline: none;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    max-width: 140px;
                `;

            editableText.addEventListener('input', async function() {
                if (editableText.innerText.length > 20) {
                    editableText.innerText = editableText.innerText.substring(0,20);
                    // pindahkan cursor ke akhir
                    const range = document.createRange();
                    const sel = window.getSelection();
                    range.selectNodeContents(editableText);
                    range.collapse(false);
                    sel.removeAllRanges();
                    sel.addRange(range);
                }
            });

            // Kirim update ke server
            editableText.addEventListener('keydown', async function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Hindari newline

                    const noteId = parentBox.dataset.id;

                    try {
                        await fetch('update_note.php', {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json'},
                            body: JSON.stringify({
                                id: noteId,
                                title: editableText.innerText.trim(),
                                pos_x: parentBox.offsetLeft,
                                pos_y: parentBox.offsetTop,
                                content: ""
                            })
                        });
                    } catch (err) {
                        console.error('Gagal menyimpan dengan Enter:', err);
                    }

                    // Opsional: blurkan (biar keluar dari edit mode)
                    editableText.blur();
                }
            });


                // Add button on the right
                const closeButton = document.createElement('button');
                closeButton.innerText = 'Delete';
                closeButton.style.cssText = `
                    background: #ff4d4d;
                    color: #fff;
                    border: none;
                    border-radius: 5px;
                    padding: 6px 14px;
                    cursor: pointer;
                    font-weight: bold;
                `;
                
                closeButton.onclick = async function(e) {
                e.stopPropagation();
                const noteId = parentBox.dataset.id;

                try {
                    const response = await fetch('delete_note.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: noteId })
                    });

                    if (!response.ok) throw new Error('Gagal menghapus note di database');
                } catch (err) {
                    console.error(err);
                    alert('Gagal menghapus note dari database');
                    return;
                }

                // Hapus dari tampilan
                parentBox.remove();
                childBox.remove();
            };

                childBox.appendChild(editableText);
                childBox.appendChild(closeButton);
                    
                    document.querySelector('.down-container').appendChild(childBox);
                }
            });

            // Double-click on note box to go to Note.php
            document.addEventListener('dblclick', function(e) {
                if (e.target.classList.contains('note-box')) {
                    const noteId = e.target.dataset.id;
                    window.location.href = `note.php?id=${noteId}`;
                }
            });

            window.addEventListener('DOMContentLoaded', async () => {
    try {
        const response = await fetch('load_notes.php');
        const notes = await response.json();

        const container = document.querySelector('.down-container');

        notes.forEach(note => {
            const box = document.createElement('div');
            box.className = 'note-box';
            box.dataset.id = note.id;
            box.dataset.title = note.title;

            box.style.cssText = `
                width: 280px;
                height: 170px;
                background-color: #ffffff;
                position: absolute;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                left: ${note.pos_x}px;
                top: ${note.pos_y}px;
                padding: 10px;
                box-sizing: border-box;
                color: #222;
                font-weight: bold;
                font-size: 18px;
                user-select: none;
            `;

            box.innerText = note.title || "No Title";

            container.appendChild(box);
        });
    } catch (err) {
        console.error('Gagal memuat notes:', err);
    }
});

    </script>
</body>
</html>