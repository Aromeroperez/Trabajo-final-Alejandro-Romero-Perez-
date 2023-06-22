<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styleIndex.css">
    <link rel="stylesheet" href="css/columns.css">
    <script type="module" src="js/main.js"></script>
</head>

<body>
    <header>
        <div class="two-columns">
            <div class="column">
                <div class="logo">
                    <a href="index.php">
                        <img src="img/logopagina.png" alt="Logo">
                    </a>
                </div>
            </div>
            <div class="column">
                <div class="menu">
                    <a href="index.php">Inicio</a>
                    <a href="products/products.php">Productos</a>
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
                    <a href="paneles/panelVendedor.php">Mi cuenta</a>
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
                    <a href="paneles/panelUsuario.php">Mi cuenta</a>
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


    <main>
        <div class="banner-container">
            <div class="two-columns">
                <div class="column">
                    <div class="banner-text">
                        <h1>¡Bienvenido a LocallyGrown!</h1>
                        <p>Donde podras encontrar el producto más fresco.</p>
                        <a href="products/products.php">Productos</a>
                    </div>
                </div>
                <div class="column">
                    <div class="banner-image">
                        <img src="img/principal.webp">
                    </div>
                </div>
            </div>
        </div>
        <?php
        include('products/generaterandom3.php');
        if (isset($stmt)): ?>

            <div class="fav-product-container">
                <div class="three-columns">
                    <?php while ($row = $stmt->fetch()): ?>
                        <div class="column">
                            <div class="fav-product">
                                <img src="<?php echo $row['image_url']; ?>">
                                <div class="fav-product-text">
                                    <h3>
                                        <?php echo $row['name_prod']; ?>
                                    </h3>
                                    <p>
                                        <?php echo $row['price']; ?>
                                        €
                                    </p>
                                    <p>
                                        <?php echo $row['description']; ?>
                                    </p>
                                    <form method="POST" action="../products/addproducts.php">
                                        <input type="hidden" name="product_id" value="<?php echo $row['id_prod']; ?>">
                                        <input type="hidden" name="product_name" value="<?php echo $row['name_prod']; ?>">
                                        <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                                        <button type="submit" class="button btn-3"
                                            name="add_product"><span>Añadir al carrito</span>
 
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

        <?php endif; ?>



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