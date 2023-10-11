<?php
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

if(isset($_GET['search']) and $_GET['search'] != ""){
    $searchTerm = $_GET['search'];
    $sql = "SELECT id, title, body, publication_date FROM articles WHERE title LIKE '%$searchTerm%' ORDER BY publication_date DESC";
    $results = $conn->query($sql);
}else{
    // Esegui la query per ottenere la lista di tutti gli articoli
    $sql = "SELECT id, title, body, publication_date FROM articles ORDER BY publication_date DESC";
    $results = $conn->query($sql);
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
    <link rel="stylesheet" href="../nav.css">
    <link rel="stylesheet" href="../style.css">
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Rubik&display=swap');

    .font-custom1 {
        font-family: 'Rubik', sans-serif;
    }
</style>

<body>

    <div id="blob"></div>
    <div id="blur"></div>
    <div id="bg"></div>
    <?include("../header.html");?>
    <div class="z-10 relative p-5 overflow-visible bg-transparent w-full h-full">
        <div class="flex flex-col justify-center items-center">
            <!--Campo di ricerca articoli -->
            <form action="articles.php" method="get" class="mt-14 w-1/2">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                        <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </span>
                    <input type="search" name="search" class="bg-transparent border border-gray-400 rounded-2xl py-2 px-3 pl-10 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Cerca un articolo..." autocomplete="off">
                </div>
                <!--<input placeholder="Cerca un articolo..." type="text" id="searchInput" class=" mt-14 bg-transparent border border-gray-400 rounded-2xl py-2 px-3 w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-400"> -->
            </form>
            <div class=" mt-10 w-1/2 text-justify">
                <?if(isset($_GET['search']) and $_GET['search'] != ""){
                    echo '<h1 class="font-custom1 text-5xl ">Hai cercato: ' . htmlentities($searchTerm, ENT_QUOTES, 'UTF-8') . '</h1>';
                }else{
                    echo '<h1 class="font-custom1 text-5xl ">Articoli pubblicati</h1>';
                } ?>
                <hr class="border-black mt-2 mb-5">
                <div class="flex flex-col ">
                    <?if($results->num_rows == 0){echo '<h2 class="w-3/4 text-3xl">La ricerca non ha prodotto nessun risultato</h2>';}?>
                    <? foreach ($results as $article) {
                        echo '<div>
                        <div class="flex">
                            <a href="./view_article.php?id=' . $article['id'] . '" class="w-3/4 text-3xl">' . $article['title'] . '</a>
                            <p class="right-0 ml-10">19/07/2022</p>
                        </div>
                        <p class="max-h-36 overflow-hidden">' . $article['body'] . '</p>
                        <hr class="w-48 h-1 mx-auto my-4 bg-gray-600 border-0 rounded md:my-10">
                    </div>';
                    } ?>
                </div>
            </div>
            <div></div>
        </div>
    </div>

    <script src="../js/menu.js"></script>
    <script src="../js/glow.js"></script>
</body>