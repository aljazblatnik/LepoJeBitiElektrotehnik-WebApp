<?php
require 'server_data.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  try {
    $question = $_GET["Q"];
    $A = $_GET["A"];
    $B = $_GET["B"];
    $C = $_GET["C"];
    $D = $_GET["D"];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Povezava s strežnikom ni uspela: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
    $sql = "INSERT INTO question (questionText, AText, BText, CText, DText) VALUES ('$question', '$A', '$B', '$C', '$D')";

    if ($conn->query($sql) !== TRUE) {
        echo "ERR";
    }
    else
    {
        echo "OK";
        file_put_contents("pogled.txt","2");
    }

    $conn->close();
    }
    catch(Exception $e) {
        echo "ERR";
    }
}
?>