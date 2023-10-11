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

// Ottieni il termine di ricerca dalla query string
$searchTerm = $_GET['search'];

// Esegue la query per ottenere i post corrispondenti alla ricerca
$sql = "SELECT title, image FROM posts WHERE private = '0' AND title LIKE '%$searchTerm'";
$result = $conn->query($sql);

$posts = array();

if ($result->num_rows > 0) {
    // Itera sui risultati della query e aggiungi le auto all'array
    while ($row = $result->fetch_assoc()) {
        $post = array(
            'title' => $row['title'],
            'image' => $row['image'],
        );
        $posts[] = $post;
    }
}

// Restituisci i risultati come JSON
header('Content-Type: application/json');
echo json_encode($posts);

// Chiudi la connessione al database
$conn->close();
?>
