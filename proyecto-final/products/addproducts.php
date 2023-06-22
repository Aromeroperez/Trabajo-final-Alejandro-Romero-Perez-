<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user_id = $_SESSION['id_usr'] ?? null;

# Verifica si el usuario ha iniciado sesión
if (!$user_id) {
    header("Location: ../login/login.php");
    exit();
}
# Conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "locallygrown";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['add_product'])) {
        # Verificamos si el usuario tiene un carrito creado
        $stmt = $conn->prepare("SELECT id_cart FROM carts WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            # El usuario ya tiene un carrito creado, añade el producto al carrito existente
            $cart_id = $stmt->fetchColumn();
        } else {
            # El usuario no tiene un carrito creado, crea uno nuevo y obtenemos su ID
            $stmt = $conn->prepare("INSERT INTO carts (user_id) VALUES (:user_id)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            $cart_id = $conn->lastInsertId();
        }

        # Obtenemos los datos del producto del formulario
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];

        # Añadimos el producto al carrito
        $stmt = $conn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, 1)");
        $stmt->bindParam(':cart_id', $cart_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        # Mensaje de confirmación
        $message = "¡El producto '$product_name' ha sido añadido al carrito!";

        # Redirigimos a la página de confirmación con el mensaje como parámetro en la URL
        header("Location: confirmation.php?message=" . urlencode($message));
        exit();

    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>