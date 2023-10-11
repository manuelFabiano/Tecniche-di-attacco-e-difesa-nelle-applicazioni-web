<?
setcookie ("cookie", "", time() - 3600);
header("Location: ./login.php");
?>