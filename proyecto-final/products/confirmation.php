<!DOCTYPE html>
<html>

<head>
    <title>Confirmación</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/styleconfirm.css">
</head>

<body>
    <div class="container">
        <h1>Confirmación de producto añadido</h1>
        <p>
            <?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : ''; ?>
        </p>
    
    <div class="container2">
    <button class="button btn-3" onclick="location.href = '../ShoppingCart/shoppingcart.php';"><span>Ver
            carrito</span></button>
    <button class="button btn-3" onclick="location.href = 'products.php';"><span>Seguir comprando</span></button>
    </div>
    </div>
</body>

</html>