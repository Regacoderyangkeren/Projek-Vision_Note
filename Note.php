<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Note</title>
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
            background-color: #fff;
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(11, 11, 11, 0.05);
            top: 0;
            left: 0;
            font-family: inherit;
            overflow: hidden;
            z-index: 10;
        }

        .upper-container-content {
            width: 100%;
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 30px;
            padding-right: 40px;
            overflow: hidden;
        }

        .title {
            font-size: 1rem;
            font-weight: bold;
            color: #000;
            position: absolute;
            left: 30px;
            top: 6px;
            z-index: 10;
            cursor: pointer;
        }

        .logo {
            position: fixed;
            left: 47%;
            z-index: 1000;
        }

        .down-container {
            width: 100%;
            height: 90vh;
            background-color: #d9d9d9;
            position: fixed;
            bottom: 0;
            left: 0;
            z-index: 2;
        }

        .Left-Container {
            width: 8%;
            height: 90vh;
            align-items: center;
            position: absolute;
            background-color: #e4e4e4;
            bottom: 0;
            left: 0;
            z-index: 5;
        }

        .Note-elements {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            padding-top: 20px;
        }

        .Text-elements {
            font-size: 1rem;
            font-weight: bold;
            color: #222;
            letter-spacing: 1.5px;
            margin-top: -20px;
        }

        .draggable-item {
            cursor: grab;
            user-select: none;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Draggable notes... */
        .text-box {
            width: 240px;
            height: 40px;
            padding: 8px;
            margin: -10px;
            font-size: 1rem;
            color: #222;
            background-color: #fff;
            border: 2px solid #999;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: absolute;
            cursor: move;
        }

        .card-base {
            width: 250px;
            height: 50px;
            padding-left: 10px;
            margin-left: -10px;
            font-size: 1.5rem;
            font-weight: bold;
            background-color: #ababab;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: absolute;
            cursor: move;
            color: #222;
            text-align: left;
        }

        .card-base p {
            margin: 0;
        }

        .card-base hr {
            margin: 10px 0;
            border: none;
            max-width: 90%;
            height: 5px;
            border-top: 1px solid #999;
            color: black
        }

        .image {
            width: 260px;
            height: 150px;
            background-color: #ababab;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-image: url('Image.png');
            background-repeat: no-repeat;
            background-position: center center;
            position: absolute;
            cursor: move;
            font-size: 1.2rem;
            font-weight: bold;
            color: #222;
            text-align: center;
        }

        .image p {
            margin-top: 15vh;
        }

        .checklist {
            width: 200px;
            height: 150px;
            background-color: #ababab;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: absolute;
            cursor: move;
            font-size: 1.2rem;
            font-weight: bold;
            color: #222;
            text-align: center;
        }

        .checklist-box {
            width: 233px;
            min-height: 120px;
            margin: -13px;
            margin-top: -18px;
            background: #fff;
            border: 2px solid #999;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 16px 12px 12px 12px;
            color: #222;
            position: absolute;
            cursor: move;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .checklist-box label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            font-weight: 400;
        }

        .link-box {
            width: 234px;
            margin-left: -13px;
            min-height: 50px;
            background: #fff;
            border: 2px solid #4a90e2;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px 12px;
            color: #222;
            position: absolute;
            cursor: move;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .link-box input {
            border: none;
            outline: none;
            background: transparent;
            color: #222;
            font-size: 1rem;
            width: 140px;
        }

        .link-box a {
            color: #4a90e2;
            text-decoration: underline;
            font-size: 1rem;
            word-break: break-all;
        }

        .arrow-box {
            width: 200px;
            height: 200px;
            background: transparent;
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: auto;
        }

        .arrow-svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        .delete-btn {
            background-color: black;
            position: absolute;
            top: -18px;
            right: -18px;
            width: 32px;
            height: 32px;
            background: #ff4d4f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            opacity: 0.85;
            z-index: 9999;
            cursor: pointer;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transition: background 0.2s;
            pointer-events: auto;
        }

        .delete-btn:hover {
            background: #d9363e;
        }

        .max-w-full {
            max-width: 100%;
        }

        .max-h-full {
            max-height: 100%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body x-data="noteBoard()" @mousemove.window="onDragMove($event)" @mouseup.window="endDrag()">

    <div class="upper-container" x-ref="upper"></div>
    <div class="down-container" x-ref="down" @drop.prevent="onDrop($event)" @dragover.prevent
        @mousedown.window="closeDeleteButtons($event)">
        <div class="Left-Container" x-ref="left"></div>
        <!-- NOTE TOOLBAR -->
        <div class="Note-elements" style="position:absolute;top:0;left:0;width:8%;height:90vh;z-index:9">
            <!-- Note Draggable Icon -->
            <div class="draggable-item" draggable="true" @dragstart="startDrag('note', $event)">
                <img src="Note.png" alt="Note" width="60" height="40">
            </div>
            <p class="Text-elements">Note</p>
            <!-- Card Draggable Icon -->
            <div class="draggable-item" draggable="true" @dragstart="startDrag('card', $event)">
                <img src="Card.png" alt="Card" width="60" height="40">
            </div>
            <p class="Text-elements">Card</p>
            <div class="draggable-item" draggable="true" @dragstart="startDrag('image', $event)">
                <img src="Image.png" alt="Image" width="60" height="60">
            </div>
            <p class="Text-elements">Image</p>
            <div class="draggable-item" draggable="true" @dragstart="startDrag('checklist', $event)">
                <img src="Checklist.png" alt="Checklist" width="60" height="40">
            </div>
            <p class="Text-elements">Checklist</p>
            <div class="draggable-item" draggable="true" @dragstart="startDrag('link', $event)">
                <img src="Link.png" alt="Link" width="60" height="60">
            </div>
            <p class="Text-elements">Link</p>
            <div class="draggable-item" draggable="true" @dragstart="startDrag('arrow', $event)">
                <img src="arrow.png" alt="arrow" width="60" height="40">
            </div>
            <p class="Text-elements">arrow</p>
        </div>
        <!-- /NOTE TOOLBAR -->

        <!-- DROPPED ELEMENTS -->
        <template x-for="(elem, idx) in elements" :key="elem.id">
            <div :class="getElemClass(elem)" :style="elemStyle(elem)" @mousedown="beginMove(elem, $event)"
                @click.stop="showDelete(elem)" @dblclick.stop x-show="!elem.isDeleted">

                <!-- Note -->
                <template x-if="elem.type === 'note'">
                    <input class="text-box" type="text" x-model="elem.text">
                </template>

                <!-- Card -->
                <template x-if="elem.type === 'card'">
                    <div class="card-base">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <p x-text="elem.text"></p>
                            <button @click.stop="elem.hasChildArea = !elem.hasChildArea" 
                                    style="margin-right: 10px; padding: 2px 8px; background: #666; color: white; border: none; border-radius: 4px;">
                                +
                            </button>
                        </div>
                        <hr>
                        <div x-show="elem.hasChildArea" 
                             :style="`position: absolute; left: 0; width: 99%; 
                                    height: ${elem.children ? (60 + elem.children.length * 60) : 150}px; 
                                    top: 100%; background: rgba(171, 171, 171, 0.3); 
                                    border: 2px dashed #666;`"
                             @dragover.prevent="$el.style.background = 'rgba(171, 171, 171, 0.5)'"
                             @dragleave.prevent="$el.style.background = 'rgba(171, 171, 171, 0.3)'"
                             @drop.prevent="
                            if (dragType || (draggingElem && draggingElem !== elem && draggingElem.type !== 'arrow')) {
                                let child = draggingElem;
                                if (dragType) {
                                    child = defaultElem(dragType, 0, 0, nextId++);
                                    elements.push(child);
                                    dragType = null;
                                }
                                child.parentId = elem.id;
                                
                                // Different widths for different element types
                                let cardWidth = 250; // Base card width
                                let childWidth;
                                let childHeight;
                                
                                // Set dimensions based on child type
                                switch(child.type) {
                                    case 'note':
                                        childWidth = 250;
                                        childHeight = 40;
                                        break;
                                    case 'card':
                                        childWidth = 250;
                                        childHeight = 50;
                                        break;
                                    case 'image':
                                        childWidth = 260;
                                        childHeight = 150;
                                        break;
                                    case 'checklist':
                                        childWidth = 233;
                                        childHeight = 120;
                                        break;
                                    case 'link':
                                        childWidth = 234;
                                        childHeight = 50;
                                        break;
                                    case 'arrow':
                                        childWidth = 200;
                                        childHeight = 40;
                                        break;
                                    default:
                                        childWidth = 240;
                                        childHeight = 40;
                                }
                                
                                // Center the child element
                                child.x = elem.x + (cardWidth - childWidth) / 2;
                                child.locked = true;
                                child.offsetY = 60;
                                
                                if (!elem.children) elem.children = [];
                                if (!elem.children.includes(child.id)) {
                                    elem.children.push(child.id);
                                    child.y = elem.y + 60 + (elem.children.length - 1) * (childHeight + 10); // Add 10px spacing
                                    child.offsetY = child.y - elem.y;
                                    
                                    // Expand the container height
                                    $el.style.height = (60 + elem.children.length * (childHeight + 200)) + 'px';
                                }
                                
                                // Update positions of all children
                                let totalHeight = 60; // Initial offset
                                elem.children.forEach((childId, index) => {
                                    let childElem = elements.find(e => e.id === childId);
                                    if (childElem) {
                                        childElem.y = elem.y + totalHeight;
                                        childElem.offsetY = childElem.y - elem.y;
                                        
                                        // Get width and height for this specific child type
                                        let thisChildWidth, thisChildHeight;
                                        switch(childElem.type) {
                                            case 'note': 
                                                thisChildWidth = 240; 
                                                thisChildHeight = 40;
                                                break;
                                            case 'card': 
                                                thisChildWidth = 250; 
                                                thisChildHeight = 50;
                                                break;
                                            case 'image': 
                                                thisChildWidth = 260; 
                                                thisChildHeight = 150;
                                                break;
                                            case 'checklist': 
                                                thisChildWidth = 233; 
                                                thisChildHeight = 120;
                                                break;
                                            case 'link': 
                                                thisChildWidth = 234; 
                                                thisChildHeight = 50;
                                                break;
                                            case 'arrow': 
                                                thisChildWidth = 200; 
                                                thisChildHeight = 40;
                                                break;
                                            default: 
                                                thisChildWidth = 240; 
                                                thisChildHeight = 40;
                                        }
                                        childElem.x = elem.x + (cardWidth - thisChildWidth) / 2;
                                        totalHeight += thisChildHeight + 10; // Add height plus spacing
                                    }
                                });
                            }
                            $el.style.background = 'rgba(171, 171, 171, 0.3)';
                        "
                             @mousedown.stop="$event.preventDefault()"
                             x-init="
                                $watch('elem.isDeleted', value => {
                                    if (value && elem.children) {
                                        elem.children.forEach(childId => {
                                            let child = elements.find(e => e.id === childId);
                                            if (child) child.isDeleted = true;
                                        });
                                    }
                                });
                                $watch('elem.x', value => {
                                    if (elem.children) {
                                        elem.children.forEach(childId => {
                                            let child = elements.find(e => e.id === childId);
                                            if (child) {
                                                let childWidth;
                                                switch(child.type) {
                                                    case 'note': childWidth = 240; break;
                                                    case 'card': childWidth = 250; break;
                                                    case 'image': childWidth = 260; break;
                                                    case 'checklist': childWidth = 233; break;
                                                    case 'link': childWidth = 234; break;
                                                    case 'arrow': childWidth = 200; break;
                                                    default: childWidth = 240;
                                                }
                                                child.x = value + (250 - childWidth) / 2;
                                            }
                                        });
                                    }
                                });
                                $watch('elem.y', value => {
                                    if (elem.children) {
                                        elem.children.forEach(childId => {
                                            let child = elements.find(e => e.id === childId);
                                            if (child) child.y = value + child.offsetY;
                                        });
                                    }
                                });">
                        </div>
                    </div>
                </template>

                <!-- image -->
                <template x-if="elem.type === 'image'">
                    <div x-data="{ src: elem.src || '' }" class="relative">
                        <!-- Hidden file input -->
                        <input type="file" accept="image/*" x-ref="fileInput" class="hidden" @change="
                            const file = $event.target.files[0];
                            if (file) {
                            const reader = new FileReader();
                            reader.onload = e => {
                                src = e.target.result;
                                elem.src = e.target.result; // persist to elem
                            };
                            reader.readAsDataURL(file);
                            }
                        " />

                        <!-- Show placeholder box if no image is selected -->
                        <template x-if="!src">
                            <div class="w-40 h-40 bg-gray-300 flex items-center justify-center shadow cursor-pointer"
                                @dblclick="$refs.fileInput.click()">
                                <span class="text-gray-600 text-sm"></span>
                            </div>
                        </template>

                        <!-- Show image if selected -->
                        <template x-if="src">
                            <img :src="src" class="cursor-pointer max-w-full max-h-full object-contain"
                                @dblclick="$refs.fileInput.click()" />
                        </template>
                    </div>
                </template>

                <!-- checklist -->
                <template x-if="elem.type === 'checklist'">
                    <div class="checklist-box">
                        <!-- Loop through checklist items -->
                        <template x-for="(checked, index) in elem.list" :key="index">
                            <label class="block">
                                <input type="checkbox" x-model="elem.list[index]">
                                <textarea
                                    x-model="elem.tasks && elem.tasks[index] ? elem.tasks[index] : (elem.tasks ? elem.tasks[index] = '' : (elem.tasks = [], elem.tasks[index] = ''))"
                                    rows="1" class="w-full resize-none"
                                    style="min-height:25px; width:23vh; overflow:hidden; background:transparent; border:none; outline: solid 1px black;"
                                    @input="
                                        $el.style.height = 'auto';
                                        $el.style.height = $el.scrollHeight + 'px';
                                    " placeholder="Task description">
                                </textarea>
                            </label>
                        </template>

                        <!-- Add Task Button -->
                        <button type="button" class="mt-2 px-2 py-1 bg-blue-500 text-white rounded text-sm"
                            @click="elem.list.push(false)">
                            Add Task
                        </button>
                    </div>
                </template>

                <!-- link -->
                <template x-if="elem.type === 'link'">
                    <div class="link-box" x-data="{ editing: false }" @click="editing = true"
                        style="cursor: text; padding: 5px; margin-left: -10px; border: 1px solid #fff; border-radius: 4px;">
                        <!-- Non-editable clickable link -->
                        <template x-if="!editing">
                            <a :href="elem.url.startsWith('http') ? elem.url : `https://${elem.url}`" target="_blank"
                                rel="noopener noreferrer" class="text-blue-600 underline break-words"
                                style="display: block; word-break: break-word;">
                                <span x-text="elem.url || 'Click to edit link...'"></span>
                            </a>
                        </template>

                        <!-- Editable input (appears when editing) -->
                        <template x-if="editing">
                            <input type="text" x-model="elem.url" @click.stop @blur="editing = false"
                                placeholder="Enter link..." class="w-full border px-2 py-1 text-sm text-blue-700"
                                style="outline: none;">
                        </template>
                    </div>
                </template>

                <!-- arrow -->
                <template x-if="elem.type === 'arrow'">
                    <div class="arrow-box" x-data="arrowDrag(elem)">
                        <svg class="arrow-svg" :viewBox="`0 0 100 40`" style="pointer-events: none;">
                            <!-- Arrow line -->
                            <line :x1="start.x" :y1="start.y" :x2="end.x" :y2="end.y"
                                style="stroke:#4a90e2;stroke-width:6" />

                            <!-- Arrow head -->
                            <polygon :points="arrowHeadPoints" style="fill:#4a90e2;" />
                        </svg>

                        <!-- Start marker -->
                        <div x-show="selected"
                            :style="`position:absolute;left:${start.x-8}px;top:${start.y-8}px;width:16px;height:16px;z-index:10000;cursor:pointer;background:#fff;border:2px solid #4a90e2;border-radius:50%;box-shadow:0 1px 4px #0002;`"
                            @mousedown.stop="beginMove('start', $event)"></div>

                        <!-- End marker -->
                        <div x-show="selected"
                            :style="`position:absolute;left:${end.x-8}px;top:${end.y-8}px;width:16px;height:16px;z-index:10000;cursor:pointer;background:#fff;border:2px solid #4a90e2;border-radius:50%;box-shadow:0 1px 4px #0002;`"
                            @mousedown.stop="beginMove('end', $event)"></div>

                        <!-- Click to select arrow -->
                        <div style="position:absolute;left:0;top:0;width:100%;height:100%;z-index:1;cursor:pointer;background:transparent;"
                            @click.stop="selected = !selected"></div>
                        >
                    </div>
            </div>
        </template>
        <script>
            function arrowDrag(elem) {
                // Default positions if not set
                if (!elem.start) elem.start = { x: 5, y: 20 };
                if (!elem.end) elem.end = { x: 85, y: 20 };
                return {
                    start: elem.start,
                    end: elem.end,
                    selected: false,
                    dragging: null,
                    offset: { x: 0, y: 0 },
                    get arrowHeadPoints() {
                        // Arrow head at end
                        const dx = this.end.x - this.start.x;
                        const dy = this.end.y - this.start.y;
                        const len = Math.sqrt(dx * dx + dy * dy) || 1;
                        const ux = dx / len, uy = dy / len;
                        // Arrow tip
                        const tipX = this.end.x, tipY = this.end.y;
                        // Base of arrow head
                        const baseX = tipX - ux * 15, baseY = tipY - uy * 15;
                        // Perpendicular
                        const perpX = -uy, perpY = ux;
                        // Two base corners
                        const leftX = baseX + perpX * 10, leftY = baseY + perpY * 10;
                        const rightX = baseX - perpX * 10, rightY = baseY - perpY * 10;
                        return `${leftX},${leftY} ${tipX},${tipY} ${rightX},${rightY}`;
                    },
                    beginMove(which, e) {
                        this.dragging = which;
                        this.offset = {
                            x: e.clientX - this[which].x,
                            y: e.clientY - this[which].y
                        };
                        document.addEventListener('mousemove', this.onMove);
                        document.addEventListener('mouseup', this.onUp);
                    },
                    onMove: null,
                    onUp: null,
                    init() {
                        this.onMove = (e) => {
                            if (!this.dragging) return;
                            let x = e.clientX - this.offset.x;
                            let y = e.clientY - this.offset.y;
                            
                            // No clamping, allow anywhere
                            this[this.dragging].x = x;
                            this[this.dragging].y = y;
                        };

                        // Mouse up handler to stop dragging
                        this.onUp = () => {
                            this.dragging = null;
                            document.removeEventListener('mousemove', this.onMove);
                            document.removeEventListener('mouseup', this.onUp);
                        };
                    }
                }
            }
        </script>

        <!-- Delete Button -->
        <button class="delete-btn" x-show="elem.showDelete" @click.stop="removeElem(elem)" title="Delete">x</button>
    </div>
    </template>
    <!-- /DROPPED ELEMENTS -->
    </div>

    <!-- TOP BAR, LOGO, UPPER NAVS, etc (unchanged) -->
    <div class="upper-container"
        style="pointer-events: none; background: transparent; box-shadow:none; height:10vh;z-index:1001;">
        <div class="title" style="pointer-events: auto;">
            <h3>
                <a href="Main_Menu.php" style="color: inherit; text-decoration: none;">Menu</a>
            </h3>
        </div>
        <img class="logo" src="Vision-Note_Logo_Black.png" alt="Logo" width="80" height="60"
            style="pointer-events: auto;">
        <div class="upper-container-content" style="pointer-events: auto;">
            <a href="About_Us.php"><img src="Dev_Info.png" alt="Dev_Info" width="40" height="40"></a>
            <a href="Contact.php"><img src="Chat.png" alt="Chat" width="40" height="40"></a>
            <a href="User.php"><img src="Profile_Placeholder.png" alt="Profile_Placeholder" width="70" height="70"></a>
        </div>
    </div>
    <!-- END of upper navs etc. -->

    <script>
// Alpine.js component definition

function noteBoard() {
    return {
        elements: [],
        dragType: null,
        dragOffset: { x: 0, y: 0 },
        draggingElem: null,
        offsetInside: { x: 0, y: 0 },
        nextId: 1,
        noteId: 1, // Default note ID, you can make this dynamic later
        
        // Initialize - Load elements from database
        async init() {
            await this.loadElements();
        },

        // Load elements from database
        async loadElements() {
            try {
                const response = await fetch(`note_api.php?note_id=${this.noteId}`);
                const data = await response.json();
                if (data.success) {
                    this.elements = data.elements;
                    // Update nextId to avoid conflicts
                    this.nextId = Math.max(...this.elements.map(e => e.id), 0) + 1;
                }
            } catch (error) {
                console.error('Failed to load elements:', error);
            }
        },

        // Save element to database
        async saveElement(element) {
            try {
                const response = await fetch('note_api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        ...element,
                        note_id: this.noteId
                    })
                });
                const data = await response.json();
                if (data.success) {
                    element.id = data.id; // Update with database ID
                    console.log("Sending element to save:", element);
                }
                return data.success;
            } catch (error) {
                console.error('Failed to save element:', error);
                return false;
            }
        },

        // Update element in database
        async updateElement(element) {
            try {
                const response = await fetch('note_api.php', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(element)
                });
                const data = await response.json();
                return data.success;
            } catch (error) {
                console.error('Failed to update element:', error);
                return false;
            }
        },

        // Delete element from database
        async deleteElement(element) {
            try {
                const response = await fetch('note_api.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: element.id })
                });
                const data = await response.json();
                return data.success;
            } catch (error) {
                console.error('Failed to delete element:', error);
                return false;
            }
        },

        // Utility: get class for element type
        getElemClass(elem) {
            switch (elem.type) {
                case 'note': return "text-box";
                case 'card': return "card-base";
                case 'image': return "image";
                case 'checklist': return "checklist-box";
                case 'link': return "link-box";
                case 'arrow': return "arrow-box";
                default: return "";
            }
        },

        // Utility: get style attribute string for an elem
        elemStyle(elem) {
            return `left:${elem.x}px;top:${elem.y}px;z-index:${elem.z || 3};${elem.width ? `width:${elem.width}px;` : ''}${elem.height ? `height:${elem.height}px;` : ''}`;
        },

        // Start dragging from TOOLBAR
        startDrag(type, e) {
            e.dataTransfer.effectAllowed = "copy";
            this.dragType = type;
        },

        // Dropping somewhere on bottom container - MODIFIED TO SAVE TO DB
        onDrop(e) {
            if (!this.dragType) return;
            
            let downRect = this.$refs.down.getBoundingClientRect();
            let x = e.clientX - downRect.left;
            let y = e.clientY - downRect.top;

            // Check boundaries
            let leftWidth = this.$refs.left.offsetWidth;
            let upHeight = this.$refs.upper.offsetHeight;
            if (x < leftWidth || y < 0 || y + upHeight < upHeight) {
                this.dragType = null;
                return;
            }

            // Constrain to usable area
            x = Math.max(leftWidth + 5, Math.min(x, downRect.width - 230));
            y = Math.max(20, Math.min(y, downRect.height - 170));

            // Create new element
            let elem = this.defaultElem(this.dragType, x, y, this.nextId++);
            
            // Add to elements immediately so user sees it
            this.elements.push(elem);
            
            // Save to database in background
            this.saveElement(elem).catch(error => {
                console.error('Failed to save element to database:', error);
                // Could remove from elements array if save fails
            });
            
            this.dragType = null;
        },

        // Default prop generator for dropped types
        defaultElem(type, x, y, id) {
            const base = { id, type, x, y, showDelete: false, isDeleted: false };
            
            switch(type) {
                case 'note':
                    return { ...base, text: "Note" };
                case 'card':
                    return { ...base, text: "Card" };
                case 'image':
                    return { ...base };
                case 'checklist':
                    return { ...base, list: [false, false], tasks: ["", ""] };
                case 'link':
                    return { ...base, url: "https://" };
                case 'arrow':
                    return { ...base, start: { x: 5, y: 20 }, end: { x: 85, y: 20 } };
                default:
                    return base;
            }
        },

        // Delete Button popup
        showDelete(elem) {
            this.elements.forEach(el => el.showDelete = false);
            elem.showDelete = true;
        },

        closeDeleteButtons(event) {
            if (!event.target.closest('.delete-btn')) {
                this.elements.forEach(el => el.showDelete = false);
            }
        },

        // Remove elem - MODIFIED TO DELETE FROM DB
        async removeElem(elem) {
            const deleted = await this.deleteElement(elem);
            if (deleted) {
                elem.isDeleted = true;
                setTimeout(() => {
                    this.elements = this.elements.filter(e => e != elem);
                }, 250);
            } else {
                console.error('Failed to delete element from database');
            }
        },

        // Begin move
        beginMove(elem, event) {
            if (event.button !== 0) return;
            if (elem.locked) return;
            
            this.draggingElem = elem;
            elem.z = 99;

            let rect = event.target.getBoundingClientRect();
            this.dragOffset = {
                x: event.clientX - rect.left,
                y: event.clientY - rect.top
            };
            document.body.style.userSelect = 'none';
        },

        // Drag move
        onDragMove(event) {
            if (!this.draggingElem) return;
            
            let downRect = this.$refs.down.getBoundingClientRect();
            let leftWidth = this.$refs.left.offsetWidth;
            let upHeight = this.$refs.upper.offsetHeight;
            
            // Element dimensions
            let elWidth = 200, elHeight = 150;
            switch(this.draggingElem.type) {
                case 'note': elWidth = 200; elHeight = 40; break;
                case 'card': elWidth = 200; elHeight = 150; break;
                case 'image': elWidth = 200; elHeight = 150; break;
                case 'checklist': elWidth = 200; elHeight = 120; break;
                case 'link': elWidth = 220; elHeight = 70; break;
                case 'arrow': elWidth = 100; elHeight = 40; break;
            }

            let x = event.clientX - downRect.left - this.dragOffset.x;
            let y = event.clientY - downRect.top - this.dragOffset.y;

            // Constrain movement
            x = Math.max(leftWidth + 5, Math.min(downRect.width - elWidth - 5, x));
            y = Math.max(10, Math.min(downRect.height - elHeight - 5, y));

            this.draggingElem.x = x;
            this.draggingElem.y = y;
        },

        // End drag - MODIFIED TO UPDATE DB
        endDrag() {
            if (this.draggingElem) {
                this.draggingElem.z = 3;
                
                // Update in database in background
                this.updateElement(this.draggingElem).catch(error => {
                    console.error('Failed to update element:', error);
                });
                
                this.draggingElem = null;
                document.body.style.userSelect = '';
            }
        },

        // Auto-save when content changes
        async autoSave(elem) {
            clearTimeout(elem.saveTimeout);
            elem.saveTimeout = setTimeout(async () => {
                await this.updateElement(elem);
            }, 1000); // Save 1 second after user stops typing
        }
    }
}
    </script>
</body>

</html>