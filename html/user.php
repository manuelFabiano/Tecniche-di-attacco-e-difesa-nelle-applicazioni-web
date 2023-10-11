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

<body class="" scroll>

    <div id="blob"></div>
    <div id="blur"></div>
    <div id="bg"></div>
    <?include("header.html");?>
    <!-- Popup per la modifica della email -->
    <div id="emailPopup" class="relative z-10 flex flex-col items-center justify-center h-screen hidden">
        <div class="flex flex-col items-center justify-center w-1/3 h-1/3 bg-white rounded-3xl shadow-2xl">
            <h1 class="text-3xl" >Inserisci la tua nuova email:</h1>
            <form action="./change/email.php" method="POST">
                <input type="text" name="email" class="w-2/3 px-3 py-2 mt-8 text-lg border-2 border-gray-300 rounded-lg" placeholder="Email">
                <button type="submit" class="px-3 py-2 mt-8 text-white text-lg bg-blue-700 rounded-lg" >Conferma</button>
            </form>
        </div>
    </div>
    <!-- Popup per la modifica della password -->
    <div id="passwordPopup" class="relative z-10 flex flex-col items-center justify-center h-screen hidden">
        <div class="flex flex-col items-center justify-center w-1/3 h-1/3 bg-white rounded-3xl shadow-2xl">
            <h1 class="text-3xl" >Inserisci la tua nuova password:</h1>
            <form action="./change/password.php" method="GET">
                <input type="password" name="password" class="w-2/3 px-3 py-2 mt-8 text-lg border-2 border-gray-300 rounded-lg" placeholder="Password">
                <button type="submit" class="px-3 py-2 mt-8 text-white text-lg bg-blue-700 rounded-lg" >Conferma</button>
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
                <button onclick="modificaPassword();" class="px-3 py-2 text-white text-lg bg-red-700 rounded-lg" >Modifica password</button>
                </div>
            </div>
            <form action="./logout.php">
            <button class="px-3 py-2 mt-5 text-white text-lg bg-green-700 rounded-lg" >Logout</button>
            </form>
        </div>
    </div>
            
    <script>
        //funzione che alla pressione del bottone "modifica email" apre un popup per la modifica dell'email
        function modificaEmail() {
            var popup = document.getElementById("emailPopup");
            popup.classList.remove("hidden");
        }
        //funzione che alla pressione del bottone "modifica password" apre un popup per la modifica della password
        function modificaPassword() {
            var popup = document.getElementById("passwordPopup");
            popup.classList.remove("hidden");
        }
    </script>
    <script src="./js/menu.js"></script>
    <script src="./js/glow.js"></script>
</body>