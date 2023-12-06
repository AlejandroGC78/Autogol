<?php
session_start();
if (!isset($_SESSION["usuario"])){
    echo '<script>
        alert("Acceso de Negado");
        window.location = "../vistas/login.php";
    </script>';
    session_destroy();
    die();
}
?>
<?php 
include '../modelos/config.php';
include '../modelos/conexion.php';
include './carrito.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Producto</title>
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
    <link rel="stylesheet" href="../assets/css/styless.css">
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
              <ul class="navbar-nav mx-auto ">
                <li class="nav-item active">
                  <a class="nav-link " href="../usuario_admin/equipos.php">Jersey<span class="sr-only">(current)</span></a>
                </li>
                <a class="nav-link" href="./myperfil.php">
                 <img height="30" src="../assets/imagenes/usuarioss.png" alt="">
                 </a>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                   Cambios
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="agregar_producto_form.php">Alta</a>
                    <a class="dropdown-item" href="Eliminar.php">Eliminar</a>
                    <a class="dropdown-item" href="listar_productos.php">Actualizar</a>
                    <a class="dropdown-item" href="Graficas.php">Graficas</a>
                </li>
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
     
</head>
<body>
    <h1>Editar Producto</h1>
    <?php
    // Conexión a la base de datos
 

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = $pdo->prepare("SELECT * FROM tblproductos WHERE ID = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $product = $query->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
              

                $nombre = $_POST['nombre'];
                $precio = $_POST['precio'];
                $descripcion = $_POST['descripcion'];
                $unidadesEnStock = $_POST['unidadesEnStock'];
                $puntoDeReorden = $_POST['puntoDeReorden'];
                $unidadesComprometidas = $_POST['unidadesComprometidas'];
                $costo = $_POST['costo'];
               // $talla = $_POST['talla'];
               // $imagen1_nombre = $_FILES['imagen1']['name'];
                //$imagen2_nombre = $_FILES['imagen2']['name'];

                //$directorio_destino = __DIR__ . '/uploads/';

                // Rutas completas para los archivos temporales y de destino
               // $imagen1_temporal = $_FILES['imagen1']['tmp_name'];
               // $imagen2_temporal = $_FILES['imagen2']['tmp_name'];
               // $imagen1_destino = $directorio_destino . $imagen1_nombre;
                //$imagen2_destino = $directorio_destino . $imagen2_nombre;

               
                    // Agrega la vinculación de las imágenes a la consulta
                   // $ruta_imagen1 = '../uploads/' . $imagen1_nombre;
                   // $ruta_imagen2 = '../uploads/' . $imagen2_nombre;

                $query = $pdo->prepare("UPDATE tblproductos SET Nombre = :nombre, Precio = :precio, 
                Descripcion = :descripcion, UnidadesEnStock = :unidadesEnStock, 
                PuntoDeReorden = :puntoDeReorden,UnidadesComprometidas = :unidadesComprometidas, 
                Costo = :costo  WHERE ID = :id");
                $query->bindParam(':nombre', $nombre);
                $query->bindParam(':precio', $precio);
                $query->bindParam(':descripcion', $descripcion);
                $query->bindParam(':unidadesEnStock',$unidadesEnStock);
                $query->bindParam(':puntoDeReorden',$puntoDeReorden);
                $query->bindParam(':unidadesComprometidas',$unidadesComprometidas);
                $query->bindParam(':costo',$costo);
               // $query->bindParam(':talla',$talla);
                //$query->bindParam(':ruta_imagen1', $ruta_imagen1);
                //$query->bindParam(':ruta_imagen2', $ruta_imagen2);
                $query->bindParam(':id', $id);
                $query->execute();

                // Redirige de nuevo a la lista de productos después de la actualización
            // header("Location: ../equipos.php");
                exit;
            }
        
    ?>

<form action="" method="POST">
    <input type="hidden" name="id" value="<?php echo $product['ID']; ?>">
    
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $product['Nombre']; ?>" required>
    <br>
    
    <label for="precio">Precio:</label>
    <input type="number" name="precio" step="0.01" value="<?php echo $product['Precio']; ?>" required>
    <br>
    
    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" required><?php echo $product['Descripcion']; ?></textarea>
    <br>
    
    <label for="unidadesEnStock">Unidades en Stock:</label>
    <input type="number" name="unidadesEnStock" value="<?php echo $product['UnidadesEnStock']; ?>" required>
    <br>
    
    <label for="puntoDeReorden">Punto de Reorden:</label>
    <input type="number" name="puntoDeReorden" value="<?php echo $product['PuntoDeReorden']; ?>" required>
    <br>
    
    <label for="unidadesComprometidas">Unidades Comprometidas:</label>
    <input type="number" name="unidadesComprometidas" value="<?php echo $product['UnidadesComprometidas']; ?>" required>
    <br>
    
    <label for="costo">Costo:</label>
    <input type="number" name="costo" step="0.01" value="<?php echo $product['Costo']; ?>" required>
    <br>
    
    <input type="submit" name="actualizar" value="Actualizar Producto">
</form>


    <?php
        } else {
            echo "Producto no encontrado.";
        }
    } else {
        echo "ID de producto no especificado.";
    }
    ?>
</body>
</html>