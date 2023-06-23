<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user_id = $_SESSION['id_usr'];
$servername = "localhost";
$username = "root";
$password = "Passw0rd!";
$dbname = "LocallyGrown";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT id_cart FROM carts WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $cart_id = $stmt->fetchColumn();

        # Obtener los productos del carrito con sus detalles
        $stmt = $conn->prepare("SELECT p.id_prod, ci.quantity
                                   FROM cart_items ci
                                   INNER JOIN products p ON ci.product_id = p.id_prod
                                   WHERE ci.cart_id = :cart_id");
        $stmt->bindParam(':cart_id', $cart_id);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        # Insertar en la tabla 'orders' el usuario y la fecha de creación
        $stmt = $conn->prepare("INSERT INTO orders (user_id) VALUES (:user_id)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $order_id = $conn->lastInsertId();

        # Insertar en la tabla 'order_items' los productos del carrito y la cantidad
        foreach ($products as $product) {
            $product_id = $product['id_prod'];
            $quantity = $product['quantity'];

            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)");
            $stmt->bindParam(':order_id', $order_id);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->execute();
        }

        # Obtener los datos del formulario
        $address = $_POST['address'];
        $city = $_POST['city'];
        $postal_code = $_POST['postal-code'];

        # Obtener los productos del carrito con sus detalles
        $stmt = $conn->prepare("SELECT p.id_prod, p.price, ci.quantity
                           FROM cart_items ci
                           INNER JOIN products p ON ci.product_id = p.id_prod
                           WHERE ci.cart_id = :cart_id");
        $stmt->bindParam(':cart_id', $cart_id);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = 0;

        # Calcular el total de la compra
        foreach ($products as $product) {
            $price = $product['price'];
            $quantity = $product['quantity'];
            $subtotal = $price * $quantity;
            $total += $subtotal;
        }

        # Insertar en la tabla 'purchase_details' los datos del formulario y el total de la compra
        $stmt = $conn->prepare("INSERT INTO purchase_details (user_id, order_id, address, city, postal_code, total_amount) VALUES (:user_id, :order_id, :address, :city, :postal_code, :total_amount)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':postal_code', $postal_code);
        $stmt->bindParam(':total_amount', $total);
        $stmt->execute();

        # Vaciar el carrito eliminando los items del mismo
        $stmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = :cart_id");
        $stmt->bindParam(':cart_id', $cart_id);
        $stmt->execute();

        header("Location: confirmacionPedido.php");
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>