<?php
$servername = "localhost";
$username = "root";
$password = "Passw0rd!";
$dbname = "LocallyGrown";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    # Verificar si se recibió un valor para el id_item
    if (isset($_POST['item_id'])) {
        $item_id = $_POST['item_id'];

        # Eliminar la línea del producto del carrito usando el id_item
        $stmt = $conn->prepare("DELETE FROM cart_items WHERE id_item = :item_id");
        $stmt->bindParam(':item_id', $item_id);
        $stmt->execute();

        # Redirigir a la página shoppingcart.php
        header("Location: shoppingcart.php");
        exit();
    } else {
        # No se recibió el id_item, redirigir a la página shoppingcart.php
        header("Location: shoppingcart.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
