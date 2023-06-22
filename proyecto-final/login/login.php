<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                
                <form class="login-form" action="submitLogin.php" method="post">
                    <div class="boton-registrarse"> 
                        <a href="register.php">Registrarse</a>
                    </div>
                    <h1>Inicia sesión</h1>
                    <input type="email" name="email" placeholder="Email"/>
                    <input class="contraseña" type="password" name="password" placeholder="Contraseña"/>
                    <img class="ver" src="../img/visibility_FILL0_wght400_GRAD0_opsz48.svg">
                    <a href="#">¿Has olvidado la contraseña?</a>
                    <button type="submit" class="button btn-3" name="submit_login"><span>Login</span></button>
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