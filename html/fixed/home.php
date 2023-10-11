<?
if (isset($_COOKIE['cookie'])){
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
    $cookieValue = $conn->real_escape_string($_COOKIE['cookie']);
    $sql = "SELECT * FROM users WHERE cookie = '$cookieValue'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
    }else{
        header("Location: ./login.php");
    }
    $conn->close();
}else{
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
        background: radial-gradient(circle, #000000 10%, transparent 11%),radial-gradient(circle at bottom left, #000000 5%, transparent 6%),radial-gradient(circle at bottom right, #000000 5%, transparent 6%),radial-gradient(circle at top left, #000000 5%, transparent 6%),radial-gradient(circle at top right, #000000 5%, transparent 6%);
        background-size: 3em 3em;
        background-color: #ffffff;
        opacity: 0.02
    }
</style>

<body class="" scroll">
    
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
				<li class="nav__list-item active-nav"><a href="#" class="hover-target">home</a></li>
				<li class="nav__list-item"><a href="./articles.php" class="hover-target">articoli</a></li>
				<li class="nav__list-item"><a href="./foto.php" class="hover-target">foto</a></li>
				<li class="nav__list-item"><a href="#" class="hover-target">contatti</a></li>
			</ul>
		</div>
	</div>
    <div class="z-10 relative p-5 border shadow-2xl bg-transparent w-full h-screen">
        <div class="flex flex-col justify-center items-center">
            <div class=" mt-32 w-1/2 text-justify">
                <h1 class=" text-center font-custom text-6xl mb-3">Ciao <script>
                    var pos=document.URL.indexOf("name=")+5;
                    document.write(decodeURIComponent(document.URL.substring(pos)));
                 </script></h1>
                <h1 class=" text-center font-custom text-6xl mb-3">Benvenuto nel mio blog!</h1>
                <p>Sono Manuel, un ragazzo di 20 anni che studia Ingegneria Informatica. Questo spazio è dedicato alle
                    mie passioni.</p>
                <p>Se siete amanti dei viaggi, troverete articoli in cui condivido le mie esperienze, consigli utili e
                    racconti emozionanti di luoghi visitati. Se siete interessati alla fotografia, potrete scoprire
                    consigli pratici, guide e condivisione di scatti che mi hanno affascinato durante le mie avventure.
                </p>
                <p>Ma non temete, gli appassionati di informatica e videogiochi non saranno delusi! Troverete anche
                    approfondimenti sulle ultime tendenze tecnologiche, tutorial di programmazione, recensioni di
                    hardware e software, e anche discussioni appassionate sui videogiochi che amo.</p>
                <p>Preparatevi a immergervi in un mix di conoscenza, avventura e divertimento! Vi aspetto nel mio blog.
                </p>
            </div>
            <div></div>
        </div>
    </div>

    <script>

        /* Menu */
        //Navigation

        var app = function () {
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
                menu.addEventListener('click', function () {
                    return toggleClass(body, 'nav-active');
                });
            };
            var toggleClass = function toggleClass(element, stringClass) {
                if (element.classList.contains(stringClass)) element.classList.remove(stringClass); else element.classList.add(stringClass);
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