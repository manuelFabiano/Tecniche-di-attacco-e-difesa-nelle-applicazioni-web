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
    <link rel="stylesheet" href="style.css">
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Chivo:ital@1&family=Pridi:wght@300&display=swap');

    .font-custom1 {
        font-family: 'Chivo', sans-serif;
    }
</style>

<body>

    <div id="blob"></div>
    <div id="blur"></div>
    <div id="bg"></div>
    <?include("header.html");?>
    <div class="z-10 relative p-5 bg-transparent w-full h-full">
        <div class="flex flex-col justify-center items-center">
            <h1 class=" text-center font-custom1 text-6xl mb-3 mt-24">Contatti</h1>
            <p class="text-justify text-xl font-custom1">Per qualsiasi informazione o chiarimento, non esitare a contattarmi!</p>
            <div class="grid grid-cols-3 gap-4 w-full h-80 p-8">
                <div class="bg-white rounded-2xl shadow-xl w-full h-full flex flex-col justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                    </svg>
                    <p class="text-xl font-custom1 mt-8">Telefono</p>
                    <p class="text-lg text-gray-400 font-custom1">+39 333 1234567</p>
                </div>
                <div class="bg-white rounded-2xl shadow-xl w-full h-full flex flex-col justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                    <p class="text-xl font-custom1 mt-8">Email</p>
                    <p class="text-lg text-gray-400 font-custom1">manuel.fabiano.36@gmail.com</p>
                </div>
                <div class="bg-white rounded-2xl shadow-xl w-full h-full flex flex-col justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <p class="text-xl font-custom1 mt-8">Indirizzo</p>
                    <p class="text-lg text-gray-400 font-custom1">Via Brescia 5, Messina </p>
                </div>
            </div>
            <h1 class=" text-center font-custom1 text-6xl mb-3 mt-12">Mandami una foto!</h1>
            <p class="text-justify text-xl font-custom1 mb-2">Se anche a te piace la fotografia, mandami una foto scattata da te e io ti dirò cosa ne penso.</p>

            <form method="POST">
                <label for="url">Inserisci l'URL:</label>
                <input class =" w-64 " type="text" name="url" id="url">
                <input class="rounded-md px-1 cursor-pointer" type="submit" value="Manda">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $url = $_POST["url"];
                echo "<h2>Immagine:</h2>";
                echo "<img class='w-1/2 mb-5' src=\"" . htmlentities($url) . "\" alt=\"Immagine\">";
            }
            ?>
        </div>

    </div>
    <script src="./js/menu.js"></script>
    <script src="./js/glow.js"></script>
</body>