<?
if (isset($_COOKIE['cookie'])) {
    $servername = "mysql-server";
    $username = "root";
    $password = "secret";
    $dbname = "HackMe";

    // Crea la connessione al database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica se la connessione ha avuto successo
    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }
    $cookieValue = $_COOKIE['cookie'];
    $sql = "SELECT * FROM users WHERE cookie = '$cookieValue'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        header("Location: ./login.php");
    }
    $conn->close();
} else {
    header("Location: ./login.php");
}
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HackThisBlog</title>
    <!-- Foglio di stile di Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font personalizzato -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="nav.css">
</head>

<style>
    .font-custom {
        font-family: 'Cabin', sans-serif;
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
        background-color: #e9e6e4;
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
        margin: 0;
        height: 100%;
        background-color: #e9e6e4;
    }

    #bg {
        height: 100%;
        width: 100%;
        position: fixed;
        z-index: 2;
        background: radial-gradient(circle, #000000 10%, transparent 11%), radial-gradient(circle at bottom left, #000000 5%, transparent 6%), radial-gradient(circle at bottom right, #000000 5%, transparent 6%), radial-gradient(circle at top left, #000000 5%, transparent 6%), radial-gradient(circle at top right, #000000 5%, transparent 6%);
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
                <a href="./home.php" class="text-black">HackThisBlog</a>
            </div>

            <div class="nav-but-wrap">
                <div class="menu-icon hover-target">
                    <span class="menu-icon__line menu-icon__line-left"></span>
                    <span class="menu-icon__line"></span>
                    <span class="menu-icon__line menu-icon__line-right"></span>
                </div>
            </div>
            <a class="nav-but-wrap cursor-pointer" href="./user.php">
                <div class="relative w-10 h-10 -mt-3 overflow-hidden rounded-full ">
                    <svg class="absolute w-12 h-12 text-black -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </a>
        </div>
    </header>

    <div class="nav">
        <div class="nav__content">
            <ul class="nav__list">
                <li class="nav__list-item active-nav"><a href="#" class="hover-target">home</a></li>
                <li class="nav__list-item"><a href="./articles.php" class="hover-target">articoli</a></li>
                <li class="nav__list-item"><a href="./foto.php" class="hover-target">foto</a></li>
                <li class="nav__list-item"><a href="./contacts.php" class="hover-target">contatti</a></li>
            </ul>
        </div>
    </div>
    <div class="z-10 relative p-5 border shadow-2xl bg-transparent w-full h-screen">
        <div class="flex flex-col justify-center items-center">
            <h1 class=" text-center font-custom text-6xl mb-3 mt-24">Contatti</h1>
            <p class="text-justify text-xl font-custom">Per qualsiasi informazione o chiarimento, non esitare a contattarmi!</p>
            <div class="grid grid-cols-3 gap-4 w-full h-80 p-8">
                <div class="bg-white rounded-2xl shadow-xl w-full h-full flex flex-col justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                    </svg>
                    <p class="text-xl font-custom mt-8">Telefono</p>
                    <p class="text-lg text-gray-400 font-custom">+39 333 1234567</p>
                </div>
                <div class="bg-white rounded-2xl shadow-xl w-full h-full flex flex-col justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                    <p class="text-xl font-custom mt-8">Email</p>
                    <p class="text-lg text-gray-400 font-custom">manuel.fabiano.36@gmail.com</p>
                </div>
                <div class="bg-white rounded-2xl shadow-xl w-full h-full flex flex-col justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <p class="text-xl font-custom mt-8">Indirizzo</p>
                    <p class="text-lg text-gray-400 font-custom">Via Salandra 30, Messina </p>
                </div>
            </div>
        </div>
        <h1>Recupera URL</h1>
    
    <form method="POST">
        <label for="url">Inserisci l'URL:</label>
        <input type="text" name="url" id="url">
        <input type="submit" value="Recupera">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $url = $_POST["url"];
        echo "<h2>Immagine:</h2>";
        echo "<img src=\"" . htmlentities($url) . "\" alt=\"Immagine\">";
    }
    ?>   
    </div>
    
    <script>
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
    </script>
</body>