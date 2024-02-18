<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $result = file_put_contents("pogled.txt",$_GET['view']);
}

header("Location: /nadzor.php");
die();
?>