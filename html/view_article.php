<?php
if (isset($_GET['id'])) {
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
    $id = $_GET['id'];

    if (strpos($id, "UNION") == false) { //Controlla se l'utente ha provato a fare un UNION attack

        $sql = "SELECT title, body FROM articles WHERE id = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            //preleva dal database i commenti relativi a questo articolo
            $sql = "SELECT username, comment FROM comments WHERE article_id = '$id'";
            $comments = $conn->query($sql);
        } else {
            $row['title'] = "Articolo non trovato!";
        }
    } else {
        $row['title'] = "Tentativo di hacking fallito!";
    }
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
    .text-article {
        font-family: 'Pridi', serif;
    }
    .text-article:first-letter {
        float: left;
        font-weight: bold;
        font-size: 60px;
        font-size: 6rem;
        line-height: 40px;
        line-height: 4rem;
        height: 4rem;
        text-transform: uppercase;
    }
    .terminal {
        background-color: #1a202c;
        color: #a0aec0;
        padding: 1rem;
        font-family: 'Courier New', Courier, monospace;
        font-size: 0.9rem;
    }
</style>

<body>

    <div id="blob"></div>
    <div id="blur"></div>
    <div id="bg"></div>
    <?include("header.html");?>
    <div class="z-10 relative p-5 overflow-visible bg-transparent w-full h-full">
        <div class="flex flex-col justify-center items-center">
            <div class=" mt-20 w-2/3 text-justify">
                <h1 class="font-custom1 text-5xl "><? echo $row['title'] ?></h1>
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
                <div id="queryBox" class="terminal p-4 rounded-3xl hidden transition duration-300">
                    <span class="text-white" id="queryText"></span>
                </div>
                <hr class="border-black mt-2 mb-5">
                <div class="text-article"><? echo $row['body'] ?></div>
            </div>
            <!-- Il box per commentare -->
            <div class="bg-gray-200 rounded-lg shadow p-4 mt-5 mb-5 w-2/3">
                <!-- Titolo del box -->
                <h2 class="text-xl font-semibold mb-4">Pubblica un commento</h2>
                <!-- Form per inserire il commento -->
                <form action="./submit_comment.php" method="post">
                    <!-- Campo nascosto per l'id del post -->
                    <input type="hidden" name="article_id" value="<? echo $id ?>">
                    <!-- Campo per il commento -->
                    <textarea class=" mb-4 bg-gray-200 border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="comment" name="comment" placeholder="Inserisci il tuo commento"></textarea>
                    <!-- Pulsante per inviare il commento -->
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Pubblica
                    </button>
                </form>
            </div>
            <!--commenti -->
            <div class="w-2/3">
                <?php
                if ($comments->num_rows > 0) {
                   echo '<h2 class="text-xl font-semibold mb-4">Commenti</h2>';
                    // Itera con un foreach sui risultati della query
                    foreach ($comments as $comment) {
                        echo '<div class="bg-gray-200 rounded-lg shadow p-4 mt-5 mb-5">';
                        echo '<div class="flex justify-between">';
                        echo '<div class="font-semibold">' . $comment['username'] . '</div>';
                        echo '</div>';
                        echo '<div class="mt-2">' . $comment['comment'] . '</div>';
                        echo '</div>';
                    }
                }
                ?>

            <div></div>
        </div>
    </div>

    <script>
        //Show Query
        const queryElement = document.getElementById('queryText');
        const switchKnob = document.getElementById('switchKnob');
        const showQueryCheckbox = document.getElementById('showQuery');
        const queryBox = document.getElementById('queryBox');

        function generateSQLQuery() {
            const url = window.location.href;
            var searchParams = new URLSearchParams(url.substring(url.indexOf("?") + 1));
            var id = searchParams.get("id");


            const query = `SELECT title, body FROM articles WHERE id = '${id}'`;
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
            queryBox.classList.toggle('hidden');
            if (!queryBox.classList.contains('hidden')) {
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


        //Chiama la funzione generateSQLQuery() quando la pagina è stata caricata
        window.addEventListener('load', generateSQLQuery);
    </script>
    <script src="./js/menu.js"></script>
    <script src="./js/glow.js"></script>
</body>