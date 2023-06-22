<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Vendedor</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/columns.css">
    <link rel="stylesheet" href="../css/stylePanelVendedor.css">
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

    <div class="titulo">
    <h1 style="text-align: center;">Bienvenido a tu panel de vendedor</h1>
    </div>
    <div class="container">
        <div class="productos-container">

            <h2>Tus productos</h2>

            <div class="productos-scroll">
            <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if (isset($_SESSION["id_usr"])) {

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

                        // Obtener los productos del vendedor
                        $vendedorId = $stmt->fetchColumn(); // Obtenemos el ID del vendedor
                        $sql = "SELECT * FROM products WHERE seller_id = :vendedorId";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':vendedorId', $vendedorId, PDO::PARAM_INT);
                        $stmt->execute();

                        // Verificar si se encontraron productos
                        if ($stmt->rowCount() > 0) {
                            // Mostrar los productos
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<div class="productos">';
                                echo '<img src="' . $row['image_url'] . '" alt="' . $row['name_prod'] . '">';
                                echo '<p>' . $row['name_prod'] .'</p>';
                                echo '<p>' . $row['price'] . '€' . '</p>'; 
                                echo '<button class="button btn-5" onclick="location.href = \'modificarForm.php?id_prod=' . $row['id_prod'] . '\';"><span>Modificar</span></button>';
                                echo '<form action="eliminarProducto.php" method="post">';
                                echo '<input type="hidden" name="prod_id" value="' . $row['id_prod'] . '">';
                                echo '<button type="submit" class="btn-4"><span>Eliminar</span></button>';
                                echo '</form>';
                                echo '</div>';
                            }
                        } else {
                            echo '<span style="color: white;">Aún no tiene ningún producto.</span>';

                        }
                    }
                } catch (PDOException $e) {
                    echo "Error al conectar a la base de datos: " . $e->getMessage();
                }

                $conn = null;
            }
            ?>
        </div>
        </div>
        <div class="formulario">
            <h1>Añadir Producto</h1>
            <form action="newProduct.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="nombreProducto" placeholder="Nombre" required />
                <input type="text" name="descripcionProducto" placeholder="Descripción" required />
                <input type="number" name="precio" placeholder="Precio" required />
                <input type="file" name="imagen" placeholder="Imagen" required />
                <button type="submit" class="button btn-3" name="newProduct"><span>Añadir</span></button>
            </form>
        </div>
    </div>

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