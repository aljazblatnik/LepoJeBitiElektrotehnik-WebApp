<?php
require 'server_data.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    $ID = $_POST["Qid"];
    $odgovor = $_POST["odgovor"];

    $sql = "";
    switch ($odgovor) {
      case "A": 
        $sql = "UPDATE question SET ACount = ACount + 1 WHERE ID = '$ID'";
        break;
      case "B": 
        $sql = "UPDATE question SET BCount = BCount + 1 WHERE ID = '$ID'";
        break;
      case "C": 
        $sql = "UPDATE question SET CCount = CCount + 1 WHERE ID = '$ID'";
        break;
      case "D": 
        $sql = "UPDATE question SET DCount = DCount + 1 WHERE ID = '$ID'";
        break;
      default:
        $sql = "";
    }

    if($sql != ""){
      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Povezava s strežnikom ni uspela: " . $conn->connect_error);
      }
      if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . " " . $conn->error;
      }
      $conn->close();
    }
  }
  catch(Exception $e) {
    echo 'Prislo je do napake: ' .$e->getMessage();
  }
}
header("Location: /hvala_glasovanje.html");
die();
?>