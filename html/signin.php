<?php
if (isset($_POST['username'])){
    if($_POST['password'] === $_POST['passwordconfirm']){
    $servername = "mysql-server";
    $username = "root";
    $password = "secret";
    $dbname = "HackMe";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn->connect_error) {
        die("Connessione fallita: " . $conn->error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $passwordconfirm = $_POST['passwordconfirm'];
    $fail = false;

    $query="INSERT INTO users (email, username, password) VALUES ('$email', '$username', '$password')";
    $result = $conn->query($query);
    //stampa l'errore in caso di errore
    if (!$result) {
        echo "<script>alert(\"Invalid query: " . $conn->error . " \")</script>";
        $fail = true;
    }else{
        // Genera un valore casuale per il cookie
        $cookieValue = bin2hex(random_bytes(16));

        // Imposta il cookie con un nome desiderato 
        setcookie("cookie", $cookieValue);

        $query="UPDATE users SET cookie = '$cookieValue' WHERE username = '$username'";
        $conn->query($query);

        // Autenticazione riuscita, reindirizza l'utente alla pagina di destinazione
        header("Location: ./home.php?name=$username");
        exit();
    }
    $conn->close();
}
    else{
        echo "<script>alert(\"Le password non coincidono\")</script>";
    }
}
?>



<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <title>Signin Page</title>
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
            <div class=" text-4xl text-center mb-1">Registrati</div>

            <form action="./signin.php" method= "post">
            <div class="mb-4 ">
                <label class="block text-base font-bold mb-2" for="username">
                Username
                </label>
                <input type="text" id="username" name="username" class=" bg-transparent border rounded py-2 px-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" autocomplete="off">
            </div>

            <div class="mb-4 ">
                <label class="block text-base font-bold mb-2" for="username">
                Email
                </label>
                <input type="text" id="email" name="email" class=" bg-transparent border rounded py-2 px-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" autocomplete="off">
            </div>

            <div class="mb-4">
                <label class="block text-base font-bold mb-2" for="password">
                Password
                </label>
                <input type="password" id="password" name="password" class="bg-transparent border rounded py-2 px-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" autocomplete="off">
            </div>
            <div class="mb-4">
                <label class="block text-base font-bold mb-2" for="passwordconfirm">
                Conferma password
                </label>
                <input type="password" id="passwordconfirm" name="passwordconfirm" class="bg-transparent border rounded py-2 px-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" autocomplete="off">
            </div>

<?if($fail == true)
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
                Registrati
            </button>
        </div>
        </form>
    </div>
</body>

</html>