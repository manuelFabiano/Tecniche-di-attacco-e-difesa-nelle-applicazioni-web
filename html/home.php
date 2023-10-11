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
    $cookieValue = $_COOKIE['cookie'];
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
    <link rel="stylesheet" href="style.css">
</head>

<style>
    html,
    body {
        overflow: hidden;
    }
</style>

<body class="" scroll>
    
    <div id="blob"></div>
    <div id="blur"></div>
    <div id="bg"></div>
    <?include("header.html");?>
    <div class="z-10 relative p-5 border shadow-2xl bg-transparent w-full h-screen">
        <div class="flex flex-col justify-center items-center">
            <div class=" mt-32 w-1/2 text-justify">
                <h1 class=" text-center font-custom text-6xl mb-3"> <script>
                    var pos=document.URL.indexOf("name=")+5;
                    if(pos>5){
                    document.write("Ciao " + decodeURIComponent(document.URL.substring(pos)));
                    }
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
    
    <script src="./js/menu.js"></script>
    <script src="./js/glow.js"></script>
</body>