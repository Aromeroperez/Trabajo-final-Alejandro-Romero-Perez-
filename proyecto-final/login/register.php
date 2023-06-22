<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/columns.css">
    <link rel="stylesheet" href="../css/styleLoginRegister.css">
    <link rel="stylesheet" href="../css/style.css">
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
                    <a href="login.php">Login</a>
                </div>
            </div>
        </div>
    </header>

    <main class="move-login-container">
        <div class="container-login">
            <div class="form-container sign-in-container">
                
                <form class="login-form height-form" action="submitRegister.php" method="post">
                    <div class="boton-registrarse"> 
                        <a href="login.php">Iniciar Sesion</a>
                    </div>
                    <h1>Registrarse</h1>
                    <input type="text" name="name" placeholder="Nombre" required/>
                    <input type="text" name="surname" placeholder="Apellidos" required/>
                    <input type="mail" name="email" placeholder="Email" required/>
                    <input class="password-register" type="password" name="password" placeholder="Contraseña" required/>
                    <input class="password-register-repeat" type="password" name="password_confirm" placeholder="Repite la Contraseña" required/>
                    <img class="ver-register" src="../img/visibility_FILL0_wght400_GRAD0_opsz48.svg">
                    <img class="ver-register-repeat" src="../img/visibility_FILL0_wght400_GRAD0_opsz48.svg">
                    <a href="registerSeller.php">¿Eres un vendedor?</a>
                    <button type="submit" class="button btn-3" name="submit_register"><span>Registrarse</span></button>
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