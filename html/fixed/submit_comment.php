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

//Ottiene il commento dal post
$comment = $_POST['comment'];
//Ottiene l'id del post
$article_id = $_POST['article_id'];
//Ottiene il cookie dell'utente
$cookie = $_COOKIE['cookie'];

//Esegue la query per ottenere l'username dell'utente
$sql = "SELECT username FROM users WHERE cookie = '$cookie'";
$result = $conn->query($sql);

//Se la query ha avuto successo usa la funzione fetch_assoc() per ottenere l'username
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
}

//Esegue la query per inserire il commento nel database
$sql = "INSERT INTO comments (username, article_id, comment) VALUES ('$username', '$article_id', '$comment')";
$result = $conn->query($sql);

//Chiude la connessione al database
$conn->close();

//Ritorna alla pagina del post
header("Location: ./view_article.php?id=$article_id");
exit();
?>
