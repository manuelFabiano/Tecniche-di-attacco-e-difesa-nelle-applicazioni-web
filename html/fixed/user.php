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
    session_start();

    // Genera un token CSRF univoco
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
        overflow: hidden;
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

<body class="" scroll>

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
                <li class="nav__list-item"><a href="#" class="hover-target">contatti</a></li>
            </ul>
        </div>
    </div>
    <!-- Popup per la modifica della email -->
    <div id="emailPopup" class="relative z-10 flex flex-col items-center justify-center h-screen hidden">
        <div class="flex flex-col items-center justify-center w-1/3 h-1/3 bg-white rounded-3xl shadow-2xl">
            <h1 class="text-3xl" >Inserisci la tua nuova email:</h1>
            <form action="./change/email.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="text" name="email" class="w-2/3 px-3 py-2 mt-8 text-lg border-2 border-gray-300 rounded-lg" placeholder="Email">
                <button type="submit" name="submit" class="px-3 py-2 mt-8 text-white text-lg bg-blue-700 rounded-lg" >Conferma</button>
            </form>
        </div>
    </div>
    <!-- Card centrale con le informazioni sull'utente e il bottone di cambio email e password -->
    <div class="relative z-10 flex flex-col items-center justify-center h-screen">
        <div class="flex flex-col items-center justify-center w-1/3 h-1/3 bg-white rounded-3xl shadow-2xl">
            <h1 class="text-5xl" ><?echo $row['username']?></h1>
            <div class="flex gap-8 mt-16 w-full">
                <div class="w-1/2">
                <button onclick="modificaEmail();" class="float-right px-3 py-2 text-white text-lg bg-blue-700 rounded-lg" >Modifica email</button>
                </div>
                <div class="w-1/2">
                <button class="px-3 py-2 text-white text-lg bg-red-700 rounded-lg" >Modifica password</button>
                </div>
            </div>
            <form action="./logout.php">
            <button class="px-3 py-2 mt-5 text-white text-lg bg-green-700 rounded-lg" >Logout</button>
            </form>
        </div>
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

        //funzione che alla pressione del bottone "modifica email" apre un popup per la modifica dell'email
        function modificaEmail() {
            var popup = document.getElementById("emailPopup");
            popup.classList.remove("hidden");
        }
    </script>
</body>