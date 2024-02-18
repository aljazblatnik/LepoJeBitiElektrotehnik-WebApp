<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $result = file_put_contents("izbran_tekmovalec.txt","");
}

header("Location: /nadzor.php");
die();
?>