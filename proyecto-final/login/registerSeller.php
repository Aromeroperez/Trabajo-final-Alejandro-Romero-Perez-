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
                
                <form class="login-form height-form" action="submitRegisterSeller.php" method="post">
                    <h1>Registro de Vendedor</h1>
                    <input type="text" name="name" placeholder="Nombre"/>
                    <input type="text" name="surname" placeholder="Apellidos"/>
                    <input type="mail" name="email" placeholder="Email"/>
                    <input type="text" name="address" placeholder="Dirección del vendedor"/>
                    <input type="number" name="phonenumber" maxlength="9" placeholder="Teléfono"/>
                    <input class="password-register-sell" type="password" name="password" placeholder="Contraseña"/>
                    <input class="password-register-repeat-sell" type="password" name="password_confirm" placeholder="Repite la Contraseña"/>
                    <img class="ver-register-sell" src="../img/visibility_FILL0_wght400_GRAD0_opsz48.svg">
                    <img class="ver-register-repeat-sell" src="../img/visibility_FILL0_wght400_GRAD0_opsz48.svg">
                    <button type="submit" class="button btn-3" name="submit_registerSell"><span>Registrarse</span></button>
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