<?php

include('../clases/users.php');
include('login.php');

# DATOS DEL FORMULARIO
$users_email = $_POST["email"];
$users_password = $_POST["password"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "locallygrown";

# CONEXION A LA DB
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error al conectarse a la base de datos: " . $e->getMessage();
}

$sql = "SELECT * FROM users WHERE email=:email";
$stmt = $conn->prepare($sql);
$stmt->execute(array(':email' => $users_email));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    # Verificar la contraseña ingresada
    if (password_verify($users_password, $row['password'])) {
        session_start();
        $_SESSION['id_usr'] = $row['id_usr'];
        header('Location: ../index.php');
        exit;
    } else {
        # Si la contraseña es incorrecta, muestra un mensaje de error
        echo "La contraseña es incorrecta";
    }
} else {
    # Si el usuario no ha sido encontrado, muestra un mensaje de error
    echo "El usuario no ha sido encontrado";
}

?>
