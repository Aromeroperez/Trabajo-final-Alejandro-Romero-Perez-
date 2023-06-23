<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Usuario</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/columns.css">
    <link rel="stylesheet" href="../css/stylePanelUsuario.css">
    <script type="module" src="../js/main.js"></script>
</head>

<body>
    <header>
        <div class="two-columns">
            <div class="column">
                <div class="logo">
                    <a href="../index.php">
                        <img src="../img/logopagina.png" alt="Logo">
                    </a>
                </div>
            </div>
            <div class="column">
                <div class="menu">
                    <a href="../index.php">Inicio</a>
                    <a href="../products/products.php">Productos</a>
                    <?php
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }

                    if (isset($_SESSION["id_usr"])) {
                        # Verificar si el usuario tiene un ID de vendedor
                        $userId = $_SESSION["id_usr"];
                        $servername = "localhost";
                        $username = "root";
                        $password = "Passw0rd!";
                        $dbname = "LocallyGrown";

                        #Conexion
                        try {
                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $sql = "SELECT id_seller FROM sellers WHERE user_id = :userId";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(":userId", $userId);
                            $stmt->execute();

                            if ($stmt->rowCount() > 0) {
                                # El usuario es un vendedor
                                echo '
                <a href="../ShoppingCart/shoppingcart.php"><img src="../img/icons8-shopping-cart-48.png" alt=""></a>
                <div class="dropdown">
                <a href=""><img src="../img/user-01-svgrepo-com.svg" alt="Usuario"></a>
                <div class="dropdown-content">
                    <a href="../paneles/panelVendedor.php">Mi cuenta</a>
                    <a href="../login/logout.php">Cerrar sesión</a>
                </div>
            </div>';
                            } else {
                                # El usuario es un usuario normal
                                echo '
                <a href="../ShoppingCart/shoppingcart.php"><img src="../img/icons8-shopping-cart-48.png" alt=""></a>
                <div class="dropdown">
                <a href=""><img src="../img/user-01-svgrepo-com.svg" alt="Usuario"></a>
                <div class="dropdown-content">
                    <a href="../paneles/panelUsuario.php">Mi cuenta</a>
                    <a href="../login/logout.php">Cerrar sesión</a>
                </div>
            </div>';
                            }
                        } catch (PDOException $e) {
                            echo "Error al conectar a la base de datos: " . $e->getMessage();
                        }

                        $conn = null;
                    } else {
                        # Mostrar el botón de inicio de sesión
                        echo '<a href="../login/login.php">Login</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </header>

    <div class="titulo">
        <h1 style="text-align: center;">Bienvenido a tu panel de usuario</h1>
    </div>
    <div class="container">
        <div class="pedidos-container">

            <h2>Tus pedidos pasados</h2>

            <div class="pedidos-scroll">
                <?php
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                if (isset($_SESSION["id_usr"])) {
                    $userId = $_SESSION["id_usr"];
                    $servername = "localhost";
                    $username = "root";
                    $password = "Passw0rd!";
                    $dbname = "LocallyGrown";

                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        # Buscar los pedidos del usuario
                        $sql = "SELECT orders.id_order, orders.created_at
                FROM orders
                WHERE orders.user_id = :userId";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":userId", $userId);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
                            # Recorrer todos los pedidos del usuario
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $orderId = $row['id_order'];
                                $orderDate = $row['created_at'];

                                echo '<div class="pedido">';
                                echo '<div class="linea-1">';
                                echo '<h3>Pedido ' . $orderId . '</h3>';
                                echo '<p>Fecha: ' . $orderDate . '</p>';
                                echo '</div>';


                                # Obtener los detalles de cada pedido
                                $sqlDetails = "SELECT order_items.quantity, products.name_prod, products.price, products.image_url
                               FROM order_items
                               INNER JOIN products ON order_items.product_id = products.id_prod
                               WHERE order_items.order_id = :orderId";
                                $stmtDetails = $conn->prepare($sqlDetails);
                                $stmtDetails->bindParam(":orderId", $orderId);
                                $stmtDetails->execute();

                                if ($stmtDetails->rowCount() > 0) {
                                    # Mostrar los detalles de cada pedido
                                    while ($rowDetails = $stmtDetails->fetch(PDO::FETCH_ASSOC)) {
                                        $quantity = $rowDetails['quantity'];
                                        $productName = $rowDetails['name_prod'];
                                        $price = $rowDetails['price'];
                                        $imageUrl = $rowDetails['image_url'];

                                        echo '<div class="productos">
                                <img src="' . $imageUrl . '" alt="' . $productName . '">
                                <h4>' . $productName . '</h4>
                                <p>Precio: ' . $price . '€' . '</p>
                                <p>Cantidad: ' . $quantity . '</p>
                              </div>';
                                    }
                                } else {
                                    echo '<span style="color: white;">No se encontraron productos en este pedido.</span>';
                                }

                                echo '</div>'; 
                            }
                        } else {
                            echo '<p>No tiene ningún pedido.</p>';
                        }
                    } catch (PDOException $e) {
                        echo "Error al conectar a la base de datos: " . $e->getMessage();
                    }

                    $conn = null;
                } else {
                    echo '<Error';
                }
                ?>



            </div>
        </div>

    </div>
</body>

</html>