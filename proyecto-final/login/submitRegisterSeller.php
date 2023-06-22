<?php

include('../clases/users.php');
include('register.php');

# DATOS DEL FORMULARIO
$users_name = $_POST["name"] ?? "";
$users_surname = $_POST["surname"] ?? "";
$users_email = $_POST["email"] ?? "";
$users_password = $_POST["password"] ?? "";
$users_password_confirm = $_POST["password_confirm"] ?? "";
$sellers_address = $_POST["address"] ?? "";
$sellers_phone_number = $_POST["phonenumber"] ?? "";

# VERIFICACIONES DE DATOS
$errors = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($users_name)) {
    $errors[] = "Por favor ingrese su nombre.";
  }
  if (empty($users_surname)) {
    $errors[] = "Por favor ingrese sus apellidos.";
  }
  if (empty($users_email)) {
    $errors[] = "Por favor ingrese su correo electrónico.";
  } elseif (!filter_var($users_email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Por favor ingrese un correo electrónico válido.";
  }
  if (empty($users_password)) {
    $errors[] = "Por favor ingrese su contraseña.";
  } elseif (strlen($users_password) < 8) {
    $errors[] = "La contraseña debe tener al menos 8 caracteres.";
  } elseif (!preg_match("#[0-9]+#", $users_password)) {
    $errors[] = "La contraseña debe incluir al menos un número.";
  } elseif (!preg_match("#[A-Z]+#", $users_password)) {
    $errors[] = "La contraseña debe incluir al menos una letra mayúscula.";
  }
  if ($users_password !== $users_password_confirm) {
    $errors[] = "Las contraseñas no coinciden.";
  }

  # SI NO HAY ERRORES, INSERTAR EN LA BD
  if (count($errors) == 0) {
    $created_at = date('Y-m-d H:i:s');
    $hashed_password = password_hash($users_password, PASSWORD_DEFAULT); # Hash de la contraseña

    $users = new users($users_name, $users_surname, $users_email, $hashed_password, $created_at);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "locallygrown";

    # CONEXION A LA DB
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      # Insertar en la tabla users
      $sql1 = "INSERT INTO users (name_usr, surnames, email, password, created_at) VALUES ('$users_name', '$users_surname', '$users_email', '$hashed_password', '$created_at')";
      $conn->exec($sql1);

      echo "Usuario creado correctamente";

      # Obtener el ID del usuario recién insertado
      $id_usr = $conn->lastInsertId();

      $users->id_usr = $id_usr;

      # Insertar en la tabla sellers
      $sql2 = "INSERT INTO sellers (user_id, address, phone_number) VALUES ('$id_usr', '$sellers_address', '$sellers_phone_number')";
      $conn->exec($sql2);

      session_start();
      $_SESSION["id_usr"] = $users->id_usr;

      echo $_SESSION["id_usr"];

      header("Location: ../index.php");
      exit();

    } catch (PDOException $e) {
      echo $sql1 . "<br>" . $e->getMessage();
    }

    $conn = null;

  } else {
    #ERRORES
    foreach ($errors as $error) {
      echo $error . "<br>";
    }
  }
}
?>
