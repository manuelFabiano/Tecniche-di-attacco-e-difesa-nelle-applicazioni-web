<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <title>HackThisBlog</title>
    <link rel="stylesheet" href="nav.css">
</head>

<style>

@import url('https://fonts.googleapis.com/css2?family=Rubik&display=swap');

    .terminal {
        background-color: #1a202c;
        color: #a0aec0;
        padding: 1rem;
        font-family: 'Courier New', Courier, monospace;
        font-size: 0.9rem;
    }

    .font-custom {
        font-family: 'Rubik', sans-serif;
    }

    @font-face {
        font-family: PixelOperator;
        src: url(../font/PixelOperatorMono.ttf);
    }

    .font-pixel {
        font-family: PixelOperator;
        font-size: 1.5rem;
    }

    @keyframes rotate {
        from {
            rotate: 0deg;
        }

        50% {
            scale: 1 1.5;
        }

        to {
            rotate: 360deg;
        }
    }

    #blob {
        background-color: white;
        height: 40vmax;
        aspect-ratio: 1;
        position: absolute;
        left: 50%;
        top: 50%;
        translate: -50% -50%;
        border-radius: 50%;
        background: linear-gradient(to right, blue, aquamarine);
        animation: rotate 10s infinite;
        opacity: 0.8;
    }

    #blur {
        height: 100%;
        width: 100%;
        position: fixed;
        z-index: 2;
        backdrop-filter: blur(12vmax);
    }

    html,
    body {
        height: 100%;
        margin: 0;
        background-color: #e9e6e4;
    }
    #bg {
        height: 100%;
        width: 100%;
        position: fixed;
        z-index: 2;
        background: radial-gradient(circle, #000000 10%, transparent 11%),radial-gradient(circle at bottom left, #000000 5%, transparent 6%),radial-gradient(circle at bottom right, #000000 5%, transparent 6%),radial-gradient(circle at top left, #000000 5%, transparent 6%),radial-gradient(circle at top right, #000000 5%, transparent 6%);
        background-size: 3em 3em;
        background-color: #ffffff;
        opacity: 0.02
    }
</style>

<body class="">
    <div id="blob"></div>
    <div id="blur"></div>
    <div id="bg"></div>
    <header class="cd-header">
        <div class="header-wrapper">
            <div class="logo-wrap">
                <a href="#" class="text-black">HackThisBlog</a>
            </div>
            <div class="nav-but-wrap">
                <div class="menu-icon hover-target">
                    <span class="menu-icon__line menu-icon__line-left"></span>
                    <span class="menu-icon__line"></span>
                    <span class="menu-icon__line menu-icon__line-right"></span>
                </div>
            </div>
        </div>
    </header>

    <div class="nav">
        <div class="nav__content">
            <ul class="nav__list">
                <li class="nav__list-item "><a href="#" class="hover-target">home</a></li>
                <li class="nav__list-item"><a href="./articles.php" class="hover-target">articoli</a></li>
                <li class="nav__list-item active-nav"><a href="./foto.php" class="hover-target">foto</a></li>
                <li class="nav__list-item"><a href="#" class="hover-target">contatti</a></li>
            </ul>
        </div>
    </div>
    <div class="z-10 relative">
        <div class="flex flex-col justify-center items-center">
            <!--
            <h1 id="obiettivi" data-value="[OBIETTIVI]" class="text-4xl font-bold text-green-500 mb-8">[OBIETTIVI]</h1>
            <h2>- Trovare la versione del database</h2>
            <h2>- Trovare i nomi delle tabelle disponibili</h2>
            <h2>- Trovare il post nascosto</h2> -->
            
            <div class="mt-24 flex flex-col w-full justify-center items-center ">
                <div class="font-custom text-2xl">Cerca una foto:</div>
                <input type="text" id="searchInput" class="bg-transparent border rounded-2xl py-2 px-3 w-2/3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <div id="BottoneMostraQuery" class="flex right-3 items-center mb-4 mt-4">
                    <label for="showQuery" class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" id="showQuery" name="showQuery" class="hidden">
                            <div class="w-12 h-6 bg-gray-600 rounded-full shadow-inner"></div>
                            <div id="switchKnob" class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow transition-transform transform translate-x-0"></div>
                        </div>
                        <div class="ml-3 text-gray-600 font-bold text-sm">
                            Mostra Query SQL
                        </div>
                    </label>
                </div>
            </div>
            <div id="queryBox" class="terminal p-4 rounded-3xl opacity-0 transition duration-300">
                <span class="text-white" id="queryText"></span>
            </div>

            <div id="Grid" class="w-5/6 mt-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Card post verranno inserite qui -->
            </div>

        </div>
    </div>
    <script>
        const searchInput = document.getElementById('searchInput');
        const Grid = document.getElementById('Grid');

        function fetchAllPosts() {
            // Effettua una richiesta AJAX al backend per ottenere tutti i post
            const request = new XMLHttpRequest();
            const searchValue = "";
            request.open('GET', `search.php?search=${searchValue}`, true);
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    const posts = JSON.parse(request.responseText);
                    updateGrid(posts);
                } else {
                    console.error('Errore nella richiesta AJAX');
                }
            };
            request.send();
        }

        window.addEventListener('DOMContentLoaded', fetchAllPosts);

        searchInput.addEventListener('input', () => {
            const searchValue = searchInput.value;

            // Effettua una richiesta AJAX al backend per ottenere i post
            const request = new XMLHttpRequest();
            request.open('GET', `search.php?search=${searchValue}`, true);
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    const posts = JSON.parse(request.responseText);
                    updateGrid(posts);
                } else {
                    console.error('Errore nella richiesta AJAX');
                }
            };
            request.send();
        });

        function updateGrid(posts) {
            Grid.innerHTML = '';

            if (posts.length > 0) {
                posts.forEach(post => {
                    const Card = createCard(post);
                    Grid.appendChild(Card);
                });
            } else {
                Grid.innerHTML = '<div></div><div class="text-4xl" >Nessuna foto trovata che corrisponde alla ricerca ' + searchInput.value +'</div>';
            }
        }

        function createCard(post) {
            const Card = document.createElement('div');
            Card.className = 'border border-gray-500 bg-transparent hover:bg-white hover:scale-105 transform transition ease-in-out duration-500 rounded-xl shadow-md p-4';

            const Image = document.createElement('img');
            Image.src = post.image;
            Image.alt = post.title;
            Image.className = 'w-full h-48 object-cover mb-4';
            Card.appendChild(Image);

            const title = document.createElement('h2');
            title.classtitle = 'text-xl text-gray-700 font-bold mb-2';
            title.textContent = post.title;
            Card.appendChild(title);

            return Card;
        }



        const queryElement = document.getElementById('queryText');
        const switchKnob = document.getElementById('switchKnob');
        const showQueryCheckbox = document.getElementById('showQuery');
        const queryBox = document.getElementById('queryBox');


        function generateSQLQuery() {
            const input = searchInput.value;


            const query = `SELECT title, image FROM posts WHERE private = '0' AND title LIKE '%${input}%'`;
            queryElement.innerHTML = highlightQuery(query);
        }

        function highlightQuery(query) {
            const keywords = ['SELECT', 'FROM', 'WHERE', 'AND', 'OR', 'INSERT', 'INTO', 'VALUES', 'UPDATE', 'SET', 'DELETE', 'UNION'];

            const highlightedQuery = query.replace(
                /( -- -)([\s\S]*)$/,
                (match, group1, group2) => `${group1} <span class="text-gray-500">${group2}</span>`
            );

            var normalQuery = "";
            var commentedQuery = "";
            if (highlightedQuery.includes('<span class="text-gray-500">')) {
                const splittedQuery = highlightedQuery.split('<span class="text-gray-500">');
                normalQuery = splittedQuery[0];
                commentedQuery = '<span class="text-gray-500">' + splittedQuery[1];
            } else normalQuery = highlightedQuery;

            console.log(normalQuery);
            console.log(commentedQuery);

            const highlightedNormalQuery = normalQuery.replace(
                new RegExp(keywords.join('|'), 'g'),
                (match) => `<span class="text-blue-500">${match}</span>`
            );

            return highlightedNormalQuery + commentedQuery;
        }



        function toggleQueryBox() {
            queryBox.classList.toggle('opacity-0');
            if (!queryBox.classList.contains('opacity-0')) {
                generateSQLQuery();
            }
        }



        function toggleSwitch() {
            if (showQueryCheckbox.checked) {
                switchKnob.classList.add('translate-x-6');
            } else {
                switchKnob.classList.remove('translate-x-6');
            }
        }

        showQueryCheckbox.addEventListener('change', toggleSwitch);



        showQueryCheckbox.addEventListener('change', toggleQueryBox);

        searchInput.addEventListener('input', generateSQLQuery);

        /* -- Glow effect -- */

        const blob = document.getElementById("blob");

        window.onpointermove = event => {
            const {
                clientX,
                clientY
            } = event;

            blob.animate({
                left: `${clientX}px`,
                top: `${clientY}px`
            }, {
                duration: 3000,
                fill: "forwards"
            });
        }

        /* Menu */
        //Navigation

        var app = function() {
            var body = undefined;
            var menu = undefined;
            var menuItems = undefined;
            var init = function init() {
                body = document.querySelector('body');
                menu = document.querySelector('.menu-icon');
                menuItems = document.querySelectorAll('.nav__list-item');
                applyListeners();
            };
            var applyListeners = function applyListeners() {
                menu.addEventListener('click', function() {
                    return toggleClass(body, 'nav-active');
                });
            };
            var toggleClass = function toggleClass(element, stringClass) {
                if (element.classList.contains(stringClass)) element.classList.remove(stringClass);
                else element.classList.add(stringClass);
            };
            init();
        }();
   
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>