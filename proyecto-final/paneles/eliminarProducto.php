<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "locallygrown";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si se recibió un valor para el id_item
    if (isset($_POST['prod_id'])) {
        $prod_id = $_POST['prod_id'];

        // Eliminar la línea del producto del carrito usando el id_item
        $stmt = $conn->prepare("DELETE FROM products WHERE id_prod = :prod_id");
        $stmt->bindParam(':prod_id', $prod_id);
        $stmt->execute();

        // Redirigir a la página shoppingcart.php
        header("Location: panelVendedor.php");
        exit();
    } else {
        // No se recibió el id_item, redirigir a la página shoppingcart.php
        header("Location: panelVendedor.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>