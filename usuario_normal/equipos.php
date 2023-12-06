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
require_once ( '../modelos/config.php');
include '../modelos/conexion.php';
include './carrito.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Equipos</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
              <a class="nav-link" href="../vistas/myperfil.php">Mi perfil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../vistas/cerrar_sesion.php">cerrar sesion</a>
            </li>
             <!-- <li class="nav-item">
                <a class="nav-link" href="../mostrarCarrito.php" id="cart-link">
                  <i class="fa fa-shopping-cart"></i> Carrito(<?php 
                    echo(empty($_SESSION['CARRITO']))?0:count($_SESSION['CARRITO']);
                    ?>)
                </a>
              </li> -->
              <li class="nav-item">
    <a class="nav-link" href="../usuario_normal/mostrarCarrito.php" id="cart-link">
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
    <?php if($mensaje!=""){?>
        <div class="alert alert-success">
           
            <?php echo $mensaje;?>
            <a href="../usuario_normal/mostrarCarrito.php" class="badge badge-success">Ver carrito</a>
        </div>
    <?php }?>

<div class="row" id="row">
    <?php 
    //Estructura PDO
    $sentencia = $pdo->prepare("SELECT * FROM `tblproductos`");
    $sentencia->execute();
    $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($listaProductos as $producto) { // Abre el bucle foreach 
    ?>
        <div class="col-md-3 col-sm-6">
            <div class="fila">
                <div class="product-grid5" onclick="cargar(this)">
                    <div class="product-image5">
                        <a href="#">
                            <img title="<?php echo $producto['Nombre'];?>" class="pic-1" 
                            src="<?php echo $producto['Imagen'];?>"
                            >
                            <img class="pic-2" src="<?php echo $producto['Imagen2'];?>">
                        </a>
                        <ul class="social">
                            <li><a href="" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                            <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                            <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                        <a href="#" class="select-options"><i class="fa fa-arrow-right "></i> Select Options</a>
                    </div>
                  <!--   <div class="product-content">
                        <h3 class="title"><a href="#"><?php echo $producto['Nombre'];?></a></h3>
                        <p class="card-text"><?php echo $producto['Descripcion'];?></p>
                        <h5 class="precio">$<?php echo $producto['Precio'];?></h5>
                      
                    </div>-->
                </div>
            </div>
            <div class="card-body">
                        <span><?php echo $producto['Nombre'];?></span>
                        <h5 class="card-title">$<?php echo $producto['Precio'];?></h5>
                        <h5 class="card-title">Cantidad Disponible: <?php echo $producto['UnidadesEnStock'];?></h5>
                  
                        <form action="" method="post">
                        <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'],COD,KEY);?>">
                        <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'],COD,KEY);?>">
                        <input type="hidden" name="precio" id="precio" value="<?php echo  openssl_encrypt($producto['Precio'],COD,KEY);?>">
                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1,COD,KEY);?>">
                        
                        <button class="btn btn-primary" name="btnAccion" value="Agregar" 
                        type="submit" style="background-color: #FFD700; color: white;">Agregar al carrito</button>

                        </form>  
                    </div>
        </div>

    <?php
    } 
    ?>
</div>

</div>
</body>
</html>