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
include './carrito.php';
//include 'vistas/cabecera.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoGol</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@1&family=PT+Serif:ital@1&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
            <!-- Para que se puedan mostrar el contenido del desplegable -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/css/contenido.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- JavaScript de Bootstrap y jQuery (asegúrate de que jQuery esté incluido) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
      /* Cambiar el color del texto a blanco en la barra de navegación */
      .navbar-light .navbar-nav .nav-link {
          color: white !important;
      }
  </style>
</head>
<body>
    <header>
        <nav class="navbar  navbar-expand-lg navbar-light " style="background-color: #2b2a2c">
            <a class="navbar-brand" href="../usuario_admin/index.php">
              <img height="75" src="../assets/imagenes/AutoGol.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mx-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="../usuario_admin/equipos.php">Jersey<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./myperfil.php">mi perfil</a>
                </li>
                <li class="nav-item">
              <a class="nav-link" href="../vistas/cerrar_sesion.php">cerrar sesion</a>
            </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                   Cambios
                  </a>
                  <div class="dropdown-menu">
                  <a class="dropdown-item" href="../agregar_producto_form.php">Alta</a>
                    <a class="dropdown-item" href="./Eliminar.php">Eliminar</a>
                    <a class="dropdown-item" href="./listar_productos.php">Actualizar</a>
                    <a class="dropdown-item" href="./graficos.php">Graficos</a>
                </li>
                
    <a class="nav-link" href="./mostrarCarrito.php" id="cart-link">
        <i class="fa fa-shopping-cart"></i> 
        <span class="badge" id="cart-badge">
            <?php
            echo (empty($_SESSION['CARRITO'])) ? 0 : count($_SESSION['CARRITO']);
            ?>
        </span>
    </a>
</li>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Obtiene la cantidad de productos en el carrito desde PHP
        var cantidadProductosEnCarrito = <?php
            echo (empty($_SESSION['CARRITO'])) ? 0 : count($_SESSION['CARRITO']);
        ?>;
        
        // Actualiza el contenido del badge con la cantidad de productos
        $("#cart-badge").text(cantidadProductosEnCarrito);
    });
</script>
<br>
    <?php if($mensaje!=""){?>
        <div class="alert alert-success">
           
            <?php echo $mensaje;?>
            <a href="./mostrarCarrito.php" class="badge badge-success">Ver carrito</a>
        </div>
    <?php }?>
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
          <form action="./procesar_pago.php" method="post">
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
          <button class="btn btn-lg btn-block" type="submit" name="btnAccion" value="Pagar" style="background-color: #FFD700; color: white;">Pagar</button>
          </form>
          </td>
        </tr>
    </tbody>
</table>
<p id="mensaje-pago" style="color: green;"></p>
<?php } else { ?>
    <div class="alert alert-success">
        No hay productos en el carrito..
    </div>
    <?php } ?>
<?php 
//include 'templates/pie.php';
?>