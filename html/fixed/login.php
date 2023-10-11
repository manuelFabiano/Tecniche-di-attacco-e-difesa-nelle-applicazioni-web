<?php
if (isset($_POST['username'])) {

    $servername = "mysql-server";
    $username = "root";
    $password = "secret";
    $dbname = "HackMe";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $fail = false;

    // Inizializza il prepared statement per eseguire la query
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $statement = $conn->prepare($query);

    // Associa i parametri alla prepared statement
    $statement->bind_param("ss", $username, $password);

    // Esegue la query e ottiene il risultato
    $statement->execute();
    $result = $statement->get_result();
    
    //stampa l'errore in caso di errore
    if (!$result) {
        echo "<script>alert(\"Invalid query: " . $conn->error . " \")</script>";
    }

    if ($result->num_rows > 0) {
        // Genera un valore casuale per il cookie
        $cookieValue = bin2hex(random_bytes(16));

        // Imposta il cookie con un nome desiderato 
        setcookie("cookie", $cookieValue);

        $query = "UPDATE users SET cookie = '$cookieValue' WHERE username = '$username'";
        $conn->query($query);

        // Autenticazione riuscita, reindirizza l'utente alla pagina di destinazione
        header("Location: ./home.php?name=$username");
        exit();
    } else {
        // Autenticazione fallita
        $fail = true;
    }

    $conn->close();
}
?>



<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <title>Login Page</title>
</head>

<style>
    .terminal {
        background-color: #1a202c;
        color: #a0aec0;
        padding: 1rem;
        font-family: 'Courier New', Courier, monospace;
        font-size: 0.9rem;
    }
</style>

<body class="bg-white">
    <div class="flex  flex-col justify-center items-center h-screen">
        <div class="bg-white hover:bg-gray-50 hover:scale-105 transform transition ease-in-out duration-500 p-8 rounded-3xl shadow-md w-96">
            <div class=" text-4xl text-center mb-1">Accedi</div>

            <form action="./login.php" method="post">
                <div class="mb-4 ">
                    <label class="block text-base font-bold mb-2" for="username">
                        Username
                    </label>
                    <input type="text" id="username" name="username" class=" bg-transparent border rounded py-2 px-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" autocomplete="off">
                </div>

                <div class="mb-4">
                    <label class="block text-base font-bold mb-2" for="password">
                        Password
                    </label>
                    <input type="password" id="password" name="password" class="bg-transparent border rounded py-2 px-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" autocomplete="off">
                </div>

                <? if ($fail == true)
                    echo '<div class="-mt-2 mb-2 text-red-500">Username o password errati</div>';
                ?>
                <div class="flex items-center mb-4">
                    <label for="showQuery" class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" id="showQuery" name="showQuery" class="hidden">
                            <div class="w-12 h-6 bg-gray-300 rounded-full shadow-inner"></div>
                            <div id="switchKnob" class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow transition-transform transform translate-x-0"></div>
                        </div>
                        <div class="ml-3 font-bold text-sm">
                            Mostra Query SQL
                        </div>
                    </label>
                </div>


                <button type="submit" id="loginButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full mt-4">
                    Login
                </button>
        </div>
        </form>
        <div id="queryBox" class="terminal mt-2 p-4 rounded-3xl opacity-0 transition duration-300">
            <span class="text-white" id="queryText"></span>
        </div>
    </div>

    <script>
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const loginButton = document.getElementById('loginButton');
        const queryElement = document.getElementById('queryText');
        const switchKnob = document.getElementById('switchKnob');
        const showQueryCheckbox = document.getElementById('showQuery');
        const queryBox = document.getElementById('queryBox');


        function generateSQLQuery() {
            const username = usernameInput.value;
            const password = passwordInput.value;

            const query = `SELECT * FROM users WHERE username='${username}' AND password='${password}';`;
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

        usernameInput.addEventListener('input', generateSQLQuery);
        passwordInput.addEventListener('input', generateSQLQuery);
    </script>
</body>

</html>