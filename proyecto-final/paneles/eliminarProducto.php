<?php
$servername = "localhost";
$username = "root";
$password = "Passw0rd!";
$dbname = "LocallyGrown";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    if (isset($_POST['prod_id'])) {
        $prod_id = $_POST['prod_id'];

        # Eliminar la línea del producto del carrito usando el id_item
        $stmt = $conn->prepare("DELETE FROM products WHERE id_prod = :prod_id");
        $stmt->bindParam(':prod_id', $prod_id);
        $stmt->execute();

        # Redirigir a la página verificarEliminar.php
        header("Location: confirmacionEliminar.php");
        exit();
    } else {
        # Si no se recibe el prod_id, redirigir a la página panelVendedor.php
        header("Location: panelVendedor.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>