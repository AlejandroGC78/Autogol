<?php
session_start();
require_once ( '../modelos/config.php');
include '../modelos/conexion.php';
include '../usuario_admin/carrito.php';


// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../vistas/login.php");
    exit;
}

// Obtiene el correo electrónico del usuario de la sesión
$correo = $_SESSION['usuario'];

try {
    // Realiza una consulta para obtener los datos del usuario a partir del correo electrónico
    $query = $pdo->prepare("SELECT * FROM tblusuarios WHERE correo = :correo");
    $query->bindParam(':correo', $correo);
    $query->execute();

    // Verifica si se encontraron resultados
    if ($query->rowCount() > 0) {
        // Obtiene los datos del usuario
        $usuario = $query->fetch(PDO::FETCH_ASSOC);

        // Verifica si se ha enviado el formulario de actualización del código postal
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            // Obtiene el nuevo código postal del formulario
            $nuevo_codigo_postal = $_POST['codigo_postal'];

            // Actualiza el código postal en la base de datos
            $update_query = $pdo->prepare("UPDATE tblusuarios SET codigo_postal = :nuevo_codigo_postal WHERE correo = :correo");
            $update_query->bindParam(':nuevo_codigo_postal', $nuevo_codigo_postal);
            $update_query->bindParam(':correo', $correo);
            $update_query->execute();

            if ($update_query->rowCount() > 0) {
                echo "Código postal actualizado correctamente.";
                // Actualiza el valor en la sesión actual
                $usuario['codigo_postal'] = $nuevo_codigo_postal;
            } else {
                echo "No se pudo actualizar el código postal.";
            }
        }

        // Verifica si se ha enviado el formulario de actualización del número de teléfono
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_phone'])) {
            // Obtiene el nuevo número de teléfono del formulario
            $nuevo_numero_telefono = $_POST['numero_telefono'];

            // Actualiza el número de teléfono en la base de datos
            $update_phone_query = $pdo->prepare("UPDATE tblusuarios SET numero_telefono = :nuevo_numero_telefono WHERE correo = :correo");
            $update_phone_query->bindParam(':nuevo_numero_telefono', $nuevo_numero_telefono);
            $update_phone_query->bindParam(':correo', $correo);
            $update_phone_query->execute();

            if ($update_phone_query->rowCount() > 0) {
                echo "Número de teléfono actualizado correctamente.";
                // Actualiza el valor en la sesión actual
                $usuario['numero_telefono'] = $nuevo_numero_telefono;
            } else {
                // Muestra el mensaje de error de la base de datos
                $errorInfo = $update_phone_query->errorInfo();
                echo "No se pudo actualizar el número de teléfono. Error: " . $errorInfo[2];
            }
        }
    } else {
        echo "Usuario no encontrado.";
    }
} catch (PDOException $e) {
    echo "Error al obtener información del usuario: " . $e->getMessage();
}
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
    <link rel="stylesheet" href="../assets/css/sytles_perfil.css">
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
          <a class="nav-link" href="./myperfil.php">
                 <img height="30" src="../assets/imagenes/usuarioss.png" alt="">
                 </a>
            <li class="nav-item">
              <a class="nav-link" href="../usuario_admin/equipos.php">Jersey</a>
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
             <!-- <li class="nav-item">
                <a class="nav-link" href="../mostrarCarrito.php" id="cart-link">
                  <i class="fa fa-shopping-cart"></i> Carrito(<?php 
                    echo(empty($_SESSION['CARRITO']))?0:count($_SESSION['CARRITO']);
                    ?>)
                </a>
              </li> -->
              <li class="nav-item">
    <a class="nav-link" href="../usuario_admin/mostrarCarrito.php" id="cart-link">
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
    <div class="perfil-container">
        <h1>Mi Perfil</h1>
        <div class="info">
            <label>Nombre:</label>
            <span><?php echo $usuario['nombre']; ?></span>
        </div>
        <div class="info">
            <label>Apellidos:</label>
            <span><?php echo $usuario['primer_apellido'] . ' ' . $usuario['segundo_apellido']; ?></span>
        </div>
        <div class="info">
            <label>Correo Electrónico:</label>
            <span><?php echo $usuario['correo']; ?></span>
        </div>
        <div class="info">
            <label>Usuario:</label>
            <span><?php echo $usuario['usuario']; ?></span>
        </div>
        <form method="POST" action="">
                <div class="info">
                    <label>Código Postal:</label>
                    <span>
                        <input type="text" name="codigo_postal" value="<?php echo $usuario['codigo_postal']; ?>">
                    </span>
                </div>
                <div class="info">
                    <input type="submit" name="submit" value="Actualizar Código Postal">
                </div>
                <div class="info">
         <a href="generar_pdf.php" target="_blank" class="btn btn-primary">Descargar Historial de Compras en PDF</a>
</div>
        </form>
</div>  
        <!-- Puedes mostrar más información aquí según tu base de datos -->
        <!-- Agrega más campos HTML según sea necesario -->
    </div>
</body>
</html>
