<?php
session_start();
if (!isset($_SESSION["usuario"])){
    echo '<script>
        alert("Por favor debes iniciar sesión");
        window.location = "../vistas/login.php";
    </script>';
    session_destroy();
    die();
}
?>
<?php
//session_start();
include '../modelos/config.php';
include '../usuario_normal/carrito.php';
//include 'vistas/cabecera.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Equipos</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../assets/css/contenido.css">
  <link rel="stylesheet" href="../assets/css/styles.css">
  <link rel="stylesheet" href="../assets/css/footer.css">
  <link rel="stylesheet" href="../assets/css/login.css">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
  <style>
    /* Cambiar el color del texto a blanco en la barra de navegación */
    .navbar-light .navbar-nav .nav-link {
        color: white !important;
    }
  </style>
</head>
<body>

</body>
</html>
</head>
<body>
  <header>
    <nav class="navbar  navbar-expand-lg navbar-light " style="background-color: #2b2a2c">
        <a class="navbar-brand" href="index_usuario.php">
          <img height="75" src="../assets/imagenes/AutoGol.png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto">

            <li class="nav-item">
              <a class="nav-link" href="..\usuario_normal\equipos.php">Jersey</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../vistas/cerrar_sesion.php">cerrar sesion</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../usuario_normal/mostrarCarrito.php" id="cart-link">
                  <i class="fa fa-shopping-cart"></i> <?php 
                    echo(empty($_SESSION['CARRITO']))?0:count($_SESSION['CARRITO']);
                    ?>
                </a>
              </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Search</button>
        </form>
        
        </div>
    </nav>
     <!-- la segunda barra de navegación -->
     <nav class="navbar navbar-light bg-gold">
      <div class="container">
          <div class="text-center" style="width: 92%;">
              <a class="navbar-brand" href="#" style="margin: 0 auto;">LO MAS NUEVO DEL FUTBOL</a>
          </div>
      </div>
  </nav>
</header>
<section class="container">
<br>
<h3>Listas del carrito</h3>
<?php if(!empty($_SESSION['CARRITO'])){ ?>
<table class="table table-light table-bordered">
    <tbody>
        <tr>
        <th width="40%">Descripcion</th>
        <th width="15%" class="text-center">Cantidad</th>
        <th width="20%" class="text-center">Precio</th>
        <th width="20%" class="text-center">Total</th>
        <th width="5%">Editar</th>
        </tr>
        <?php $total=0 ?>
        <?php foreach($_SESSION['CARRITO'] as $indice=>$producto){ ?>
        <tr>
        <td width="40%"><?php echo $producto['NOMBRE'] ?></td>
        
        <td width="15%" class="text-center"><?php echo $producto['CANTIDAD'] ?></td>
        <td width="20%" class="text-center"><?php echo $producto['PRECIO'] ?></td>
        <td width="20%" class="text-center"><?php echo number_format ($producto['PRECIO']* $producto['CANTIDAD'],2 ); ?></td>
        <td width="5%">
            <form action="" method="post">
           
            <input type="hidden" name="id" value="<?php echo openssl_encrypt($producto['ID'],COD,KEY); ?>">
            <input type="hidden" name="nombre" value="<?php echo openssl_encrypt($producto['NOMBRE'], COD, KEY); ?>">
                <input type="hidden" name="precio" value="<?php echo openssl_encrypt($producto['PRECIO'], COD, KEY); ?>">
                <input type="number" name="cantidad" value="<?php echo $producto['CANTIDAD']; ?>">
                <button class="btn btn-success" type="submit" name="btnAccion" value="Editar">
                    Editar Cantidad
                </button>
            <button class="btn btn-danger" 
            type="submit"
            name="btnAccion"
            value="Eliminar"
            >Eliminar</button>
            </form>    
        
        </td>
        </tr>
        <?php $total=$total+($producto['PRECIO']*$producto['CANTIDAD']);?>
        <?php } ?>
        <tr>
            <td colspan="3" align="right"><h3>Total</h3></td>
            <td align="right"><h3>$ <?php echo number_format($total,2);?></h3></td>
            <td></td>
        </tr>
        <tr>
          <td colspan="5">
          <form action="../usuario_normal/procesar_pago.php" method="post">
           <div class="alert alert-success" role="alert">
           <div class="from-group">
              <label for="my-input">Correo de Contacto</label>
              <input id="email" name="email"
              class="form-control"
              type="email"
              placeholder="Por favor escribe tu correo"
              required>
            </div>
            <small id="emailHelp"
            class="form-text text-muted"
            >Los productos se enviaran a este correo</small>
           </div>
           <div id="smart-button-container">
           <div style="text-align: center;">
        <!--<div id="paypal-button-container"> -->
        <button class="btn btn-lg btn-block" type="submit" name="btnAccion" value="Pagar" style="background-color: #FFD700; color: white;">Pagar</button> 
        </div>
      </div>
    </div>
          <!--<button class="btn btn-lg btn-block" type="submit" name="btnAccion" value="Pagar" style="background-color: #FFD700; color: white;">Pagar</button> -->
          </form>
          </td>
        </tr>
    </tbody>
</table>
<p id="mensaje-pago" style="color: green;"></p>
<script src="https://www.paypal.com/sdk/js?client-id=AXjo-M9E0VVjkGZMaDIjSb92WN1cw5qmhWtGLqxy6Mr3IVhokKqCFGhwoUxFCCgra6mF6VrnvHtcpVTX&currency=USD"></script>
<!-- Bloque para el proceso de pago -->
    <script src="https://www.paypal.com/sdk/js?client-id=AXjo-M9E0VVjkGZMaDIjSb92WN1cw5qmhWtGLqxy6Mr3IVhokKqCFGhwoUxFCCgra6mF6VrnvHtcpVTX&currency=USD" data-sdk-integration- source="button-factory"></script>
    <script>
    function initPayPalButton() {
    paypal. Buttons({
    style: {
    size: 'resnponsive',
    shape: 'pill',
    color: 'gold',
    layout: 'vertical',
    label: 'checkout',
    },
    createOrder: function(data, actions) {
    return actions.order.create({
    purchase_units: [{"description": "THE DESCRIPTION OF YOUR PRODUCT", "amount": {"currency_code":"USD","value":13}}] });
    },
    createOrder: function(data, actions) {
    return actions.order.create({
    purchase_units: [{"description":"THE DESCRIPTION OF YOUR PRODUCT", "amount": {"currency_code":"USD","value":13}}] }); },
    onApprove: function(data, actions) { return actions.order.capture().then(function(orderData) {
    // Full available details console.log('Capture result, orderData, JSON.stringify(orderData, null, 2));
    actions.redirect('THE URL OF YOUR THANK YOU PAGE');
    });
    },
    onError: function(err) {
    console.log(err);
    }
    }).render('#paypal-button-container');
    }
    initPayPalButton();
    </script>
<?php } else { ?>
<div class="alert alert-success">
    No hay productos en el carrito..
</div>
<?php } ?>
<?php 
//include 'templates/pie.php';
?>