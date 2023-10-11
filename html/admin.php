
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <title>Admin Panel</title>
</head>
<?
if ($_SERVER['SERVER_NAME'] == 'localhost') {
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

    if (isset($_GET['ban'])) {
        $sql = "DELETE FROM users WHERE username = '" . $_GET['ban'] . "'";
        $result = $conn->query($sql);
    }

    $sql = "SELECT username, email FROM users";
    $result = $conn->query($sql); ?>

    <body class="bg-white">
        <div class="flex  flex-col justify-center items-center h-screen">
            <div class="overflow-scroll h-1/2  bg-white hover:bg-gray-50 hover:scale-105 transform transition ease-in-out duration-500 p-8 rounded-3xl shadow-md w-1/2">
                <a class=" text-blue-400 hover:underline cursor-pointer" href="./home.php"><- Torna alla home</a>
                        <div class=" text-4xl text-center mb-4">Pannello Admin</div>
                        <table class="table-auto w-full text-center">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($result as $user) {
                                    echo "
                <tr>
                <td>" . $user['username'] . "</td>
                <td>" . $user['email'] . "</td>
                <td><a class ='text-blue-400 hover:underline cursor-pointer' href='./admin.php?ban=" . $user['username'] . "'>Ban</a></td>
                </tr>";
                                }
                                ?>
                            </tbody>
                        </table>


            </div>
        </div>
    </body>



<?php
} else {
    echo "<h1 class='text-xl'>Non sei autorizzato a visualizzare questa pagina</h1>";
}
?>
