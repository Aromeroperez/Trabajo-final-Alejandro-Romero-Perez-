<?php


// Configurar conexión con PDO
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "locallygrown";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  # Consultar los primeros 9 productos
  $stmt = $conn->prepare("SELECT * FROM products ORDER BY created_at DESC LIMIT 9");
  $stmt->execute();
}
catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;

?>
