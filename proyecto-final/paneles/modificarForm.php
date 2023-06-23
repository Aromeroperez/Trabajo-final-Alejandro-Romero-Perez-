<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/styleLoginRegister.css">
    <link rel="stylesheet" href="../css/columns.css">
    <script type="module" src="../js/main.js"></script>
</head>

<body class="login">

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
                        <a href="login.php">Login</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="move-login-container">
            <div class="container-login">
                <div class="form-container sign-in-container">
                    <form class="modificar-form" action="submitModificar.php" method="post">
                        <h1>Modificar Producto</h1>
                        <?php
                        $id_prod = $_GET['id_prod']; 
                        ?>
                        <input type="hidden" name="id_prod" value="<?php echo $id_prod; ?>">
                        <select name="campo" class="select" id="campo" placeholder="Campo a modificar">
                            <option value="name_prod">Nombre del Producto</option>
                            <option value="description">Descripción</option>
                            <option value="price">Precio</option>
                        </select>
                        <input class="nuevo" type="text" name="nuevo" placeholder="Nuevo valor" />
                        <button type="submit" class="button btn-3"
                            name="submit_modificar"><span>Modificar</span></button>
                    </form>
                </div>
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