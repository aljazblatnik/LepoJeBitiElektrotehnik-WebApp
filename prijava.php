<?php
require 'server_data.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
  $name = mb_convert_encoding($_POST["ime"], 'UTF-8');
  $name = (strlen($name) > 50) ? substr($string,0,49) : $name; // Truncate name string to max characters
  $name = strtolower($name);
  $name = ucwords($name);

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Povezava s strežnikom ni uspela: " . $conn->connect_error);
  }
  
  $conn->set_charset("utf8");

  $sql = "INSERT INTO contestants (name) VALUES ('$name')";

  if ($conn->query($sql) !== TRUE) {
      echo "Error: " . $sql . " " . $conn->error;
  }

  $conn->close();
  }
  catch(Exception $e) {
    echo 'Prislo je do napake: ' .$e->getMessage();
  }
}

header("Location: /hvala_prijava.html");
die();
?>