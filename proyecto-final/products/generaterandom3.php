<?php


// Configurar conexión con PDO
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "locallygrown";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  # Consultar 3 productos al azarar
  $stmt = $conn->prepare("SELECT * FROM products ORDER BY RAND() LIMIT 3");
  $stmt->execute();  
}
catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;

?>