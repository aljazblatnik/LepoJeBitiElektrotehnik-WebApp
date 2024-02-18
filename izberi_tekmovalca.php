<?php
header('Content-Type: text/html; charset=utf-8');
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $result = file_put_contents("izbran_tekmovalec.txt",$_GET['name']);
    $id = $_GET['id'];

    if($result === FALSE){
        die("Napaka pri nastavljanju tekmovalca. Vnesi ročno v programu kviza");
    }

    require 'server_data.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Povezava s strežnikom ni uspela: " . $conn->connect_error);
    }

    $sql = "DELETE FROM contestants WHERE ID='$id'";

    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . " " . $conn->error;
    }
    $conn->close();

}

header("Location: /nadzor.php");
die();
?>