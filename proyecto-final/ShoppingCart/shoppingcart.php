<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="../css/columns.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/styleShoppingCart.css">
    <script type="module" src="../js/main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</head>

<body>
    <header>
        <div class="two-columns">
            <div class="column">
                <div class="logo">
                    <a href="index.php">
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
                        // Verificar si el usuario tiene un ID de vendedor
                        $userId = $_SESSION["id_usr"];
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "locallygrown";

                        // CONEXION A LA DB
                        try {
                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $sql = "SELECT id_seller FROM sellers WHERE user_id = :userId";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(":userId", $userId);
                            $stmt->execute();

                            if ($stmt->rowCount() > 0) {
                                // El usuario es un vendedor
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
                                // El usuario es un usuario normal
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
                        // Mostrar el botón de inicio de sesión
                        echo '<a href="../login/login.php">Login</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </header>


    <main class="container">

        <h1 class="heading">
            <ion-icon name="cart-outline"></ion-icon> Carrito
        </h1>

        <div class="item-flex">

            <!--Formulario de pago-->
            <section class="checkout">

                <h2 class="section-heading">Detalles de pago</h2>

                <div class="payment-form">

                    <div class="payment-method">

                        <button class="method selected">
                            <ion-icon name="card"></ion-icon>

                            <span>Tarjeta de Crédito</span>

                            <ion-icon class="checkmark fill" name="checkmark-circle"></ion-icon>
                        </button>

                        <button class="method">
                            <ion-icon name="logo-paypal"></ion-icon>

                            <span>PayPal</span>

                            <ion-icon class="checkmark" name="checkmark-circle-outline"></ion-icon>
                        </button>

                    </div>

                    <form action="#">

                        <div class="cardholder-name">
                            <input placeholder="Nombre del titular" type="text" name="cardholder-name"
                                id="cardholder-name" class="input-default">
                        </div>

                        <div class="card-number">
                            <input placeholder="Número de Tarjeta" type="number" name="card-number" id="card-number"
                                class="input-default">
                        </div>

                        <div class="input-flex">

                            <div class="expire-date">
                                <label for="expire-date" class="label-default">Fecha de caducidad</label>

                                <div class="input-flex">

                                    <input type="number" name="day" id="expire-date" placeholder="31" min="1" max="31"
                                        class="input-default">
                                    /
                                    <input type="number" name="month" id="expire-date" placeholder="12" min="1" max="12"
                                        class="input-default">

                                </div>
                            </div>

                            <div class="cvv">
                                <label for="cvv" class="label-default">CVV</label>
                                <input type="number" name="cvv" id="cvv" class="input-default">
                            </div>

                        </div>

                        <div class="info">
                            <div class="address">
                                <input placeholder="Dirección" type="text" name="address" id="address"
                                    class="input-default">
                            </div>
                            <div class="input-flex">
                                <div class="city">
                                    <input placeholder="Ciudad" type="text" name="city" id="city" class="input-default">
                                </div>

                                <div class="postal-code">
                                    <input placeholder="Código Postal" type="number" name="postal-code" id="postal-code"
                                        class="input-default">
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

                <button class="btn btn-primary">
                    <b>Pagar</b> <span><span id="payAmount">0.00</span>€</span>
                </button>

            </section>


            <!--Resumen y total-->
            <section class="cart">


                <div class="cart-item-box">
                    <h2 class="section-heading">Resumen del pedido</h2>
                    <div id="product-container" class="product-container-scroll">
                        <?php
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        $user_id = $_SESSION['id_usr'];

                        # Conexión
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "locallygrown";

                        try {
                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            # Obtener el ID del carrito del usuario
                            $stmt = $conn->prepare("SELECT id_cart FROM carts WHERE user_id = :user_id");
                            $stmt->bindParam(':user_id', $user_id);
                            $stmt->execute();

                            if ($stmt->rowCount() > 0) {
                                # Si el usuario tiene un carrito creado, obtener los productos del carrito
                                $cart_id = $stmt->fetchColumn();

                                # Obtener los productos del carrito con sus detalles
                                $stmt = $conn->prepare("SELECT p.name_prod, p.price, p.image_url, ci.quantity, ci.id_item
                               FROM cart_items ci
                               INNER JOIN products p ON ci.product_id = p.id_prod
                               WHERE ci.cart_id = :cart_id");
                                $stmt->bindParam(':cart_id', $cart_id);
                                $stmt->execute();
                                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                # Mostrar los productos del carrito
                                foreach ($products as $product) {

                                    echo '
            <div class="product-card">
                <div class="card">
                    <div class="img-box">
                        <img src="../imgprod/' . $product['image_url'] . '" alt="' . $product['name_prod'] . '" width="60%" class="product-img">
                    </div>
                    <div class="detail">
                        <h4 class="product-name">' . $product['name_prod'] . '</h4>
                        <div class="wrapper">
                            <div class="product-qty">
                                <button id="decrement">
                                    <div name="remove-outline">-</div>
                                </button>
                                <span id="quantity">' . $product['quantity'] . '</span>
                                <button id="increment">
                                    <div name="add-outline">+</div>
                                </button>
                            </div>
                            <div class="price">
                                <span><span id="price">' . $product['price'] . '</span>€</span>
                            </div>
                            <form action="eliminar_producto.php" method="post">
                                <input type="hidden" name="item_id" value="' . $product['id_item'] . '">
                                <button type="submit" class="btn-delete" aria-label="Eliminar producto">
                                    <ion-icon name="close"></ion-icon>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
                                }
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>

                    </div>
                </div>
        </div>

        <div class="wrapper">

            <div class="amount">

                <div class="subtotal">
                    <span>Subtotal</span><span><span id="subtotal">0.00</span>€</span>
                </div>

                <div class="tax">
                    <span>IVA</span> <span><span id="tax">0.00</span>€</span>
                </div>

                <div class="shipping">
                    <span>Envio</span> <span><span id="shipping">0.00</span>€</span>
                </div>

                <div class="total">
                    <span>Total</span> <span><span id="total">0.00</span>€</span>
                </div>

            </div>

        </div>

        </section>

        </div>

    </main>

    <footer>
        <div class="container-footer">
            <div class="column">
                <div class="texto-footer">
                    <span>© 2023 Todos los derechos reservados</span>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>