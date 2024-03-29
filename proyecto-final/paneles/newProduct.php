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

    # Validar el tipo de archivo permitido (solo imágenes jpeg, png y webp)
    $tiposPermitidos = array('image/jpeg', 'image/png', 'image/webp');

    $nombreProducto = $_POST["nombreProducto"];
    $descripcionProducto = $_POST["descripcionProducto"];
    $precio = $_POST["precio"];
    $imagen = $_FILES["imagen"];

    # Verifica si se seleccionó un archivo
    if ($imagen['error'] == UPLOAD_ERR_OK) {
        $rutaTemporal = $imagen["tmp_name"];
        $tipoArchivo = mime_content_type($rutaTemporal);

        # Validar el tipo de archivo
        if (in_array($tipoArchivo, $tiposPermitidos)) {
            $nombreArchivo = $imagen["name"];
            $rutaDestino = "../imgprod/" . $nombreArchivo;

            # Mover el archivo a la ubicación deseada
            if (move_uploaded_file($rutaTemporal, $rutaDestino)) {

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    #Obtener id del vendedor
                    $sql = "SELECT id_seller FROM sellers WHERE user_id = :userId";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":userId", $userId);
                    $stmt->execute();
                    $vendedorId = $stmt->fetchColumn();

                    # Insertar producto
                    $sql = "INSERT INTO products (name_prod, description, price, image_url, seller_id) VALUES (:nombreProducto, :descripcionProducto, :precio, :imagen, :vendedorId)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":nombreProducto", $nombreProducto);
                    $stmt->bindParam(":descripcionProducto", $descripcionProducto);
                    $stmt->bindParam(":precio", $precio);
                    $stmt->bindParam(":imagen", $rutaDestino);
                    $stmt->bindParam(":vendedorId", $vendedorId);
                    $stmt->execute();

                    # Redirigir a la página de confirmación
                    header("Location: confirmacionNuevo.php");
                    exit();
                } catch (PDOException $e) {
                    echo "Error al conectar a la base de datos: " . $e->getMessage();
                }

                $conn = null;
            } else {
                echo "Error al mover el archivo.";
            }
        } else {
            echo "Debes insertar una imagen válida en formato JPEG, PNG o GIF.";
        }
    } else {
        echo "Error al subir el archivo.";
    }
}
?>
