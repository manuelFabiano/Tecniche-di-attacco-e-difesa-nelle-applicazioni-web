<?
session_start();

if (isset($_COOKIE['cookie'])) {
    // Verifica se il token CSRF inviato nel modulo corrisponde a quello nella sessione
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {

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
            if (isset($_POST['email'])) {
                $email = $_POST['email'];
                $sql = "UPDATE users SET email = '$email' WHERE cookie = '$cookieValue'";
                $result = $conn->query($sql);
                header("Location: ../user.php");
            }
        } else {
            header("Location: ./login.php");
        }
        $conn->close();
    } else {
        header("Location: ../user.php");
    }
} else {
    header("Location: ./login.php");
}
?>