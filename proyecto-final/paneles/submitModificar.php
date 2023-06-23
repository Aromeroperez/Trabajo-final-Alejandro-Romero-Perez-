<?php
$id_prod = $_POST['id_prod'];
$campo = $_POST['campo'];
$nuevoValor = $_POST['nuevo'];

$servername = "localhost";
$username = "root";
$password = "Passw0rd!";
$dbname = "LocallyGrown";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE products SET $campo = :nuevoValor WHERE id_prod = :id_prod";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nuevoValor', $nuevoValor);
    $stmt->bindParam(':id_prod', $id_prod);
    $stmt->execute();

    $affectedRows = $stmt->rowCount();
    if ($affectedRows > 0) {
        header("Location: confirmacionModificar.php");
        exit();
    } else {
        header("Location: panelVendedor.php");
        exit();
    }

} catch (PDOException $e) {
    header("Location: panelVendedor.php");
    exit();
} finally {
    $conn = null;
}
?>
