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
require_once('./modelos/config.php');
include './modelos/conexion.php';

$usuario = $_SESSION["usuario"];

try {
    $pdo = new PDO("mysql:dbname=" . BD . ";host=" . SERVIDOR, USUARIO, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultar el ID del rol de administrador desde tblcargo
    $queryRolAdmin = $pdo->prepare("SELECT id_cargoo FROM tblcargo WHERE descripcion = 'Administrador'");
    $queryRolAdmin->execute();
    $idRolAdmin = $queryRolAdmin->fetchColumn();

    // Consultar el ID del rol del usuario desde tblusuarios
    $queryRolUsuario = $pdo->prepare("SELECT id_cargo FROM tblusuarios WHERE id_cargo = :usuario");
    $queryRolUsuario->bindParam(':usuario', $usuario);
    $queryRolUsuario->execute();
    $idRolUsuario = $queryRolUsuario->fetchColumn();

    // Verificar si el usuario tiene el rol de administrador (id_cargoo = 1)
    if ($idRolUsuario != $idRolAdmin) {
        echo '<script>
            alert("No tienes permisos para acceder a esta página");
            window.location = "usuario_normal/index_usuario.php"; // Ruta a la página a la que quieres redirigir si no es administrador
        </script>';
        die();
    }

?>
<?php 
//require_once('modelos/config.php');
//include 'modelos/conexion.php';
//include 'usuario_admin/carrito.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario para Agregar Producto</title>
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
    <link rel="stylesheet" href="assets/css/contenido.css">
    <link rel="stylesheet" href="assets/css/styless.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/footer.css">
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
            <a class="navbar-brand" href="./usuario_admin/index.php">
              <img height="75" src="assets/imagenes/AutoGol.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mx-auto ">
                <li class="nav-item active">
                  <a class="nav-link " href="./usuario_admin/equipos.php">Jersey<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./usuario_admin/myperfil.php">Mi perfil</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                   Cambios
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="agregar_producto_form.php">Alta</a>
                    <a class="dropdown-item" href="./usuario_admin/Eliminar.php">Eliminar</a>
                    <a class="dropdown-item" href="./usuario_admin/listar_productos.php">Actualizar</a>
                    <a class="dropdown-item" href="./usuario_admin/Graficas.php">Graficas</a>
                </li>
    <a class="nav-link" href="./usuario_admin/mostrarCarrito.php" id="cart-link">
        <i class="fa fa-shopping-cart"></i> 
        <span class="badge" id="cart-badge">
            <?php
            echo (empty($_SESSION['CARRITO'])) ? 0 : count($_SESSION['CARRITO']);
            ?>
        </span>
    </a>
</li>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!--<script>
    $(document).ready(function () {
        // Obtiene la cantidad de productos en el carrito desde PHP
        var cantidadProductosEnCarrito = <?php
            echo (empty($_SESSION['CARRITO'])) ? 0 : count($_SESSION['CARRITO']);
        ?>;
        
        // Actualiza el contenido del badge con la cantidad de productos
        $("#cart-badge").text(cantidadProductosEnCarrito);
    });
</script> -->
<br>

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
    <h2>Formulario para Agregar Producto</h2>
    <form action="agregar_producto.php" method="POST" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="nombre">Nombre:</label></td>
                <td><input type="text" name="nombre" required></td>
            </tr>
            <tr>
                <td><label for="precio">Precio:</label></td>
                <td><input type="number" name="precio" step="0.01" required></td>
            </tr>
            <tr>
                <td><label for="descripcion">Descripción:</label></td>
                <td><textarea name="descripcion" required></textarea></td>
            </tr>
            <tr>
                <td><label for="unidadesEnStock">Unidades en Stock:</label></td>
                <td><input type="number" name="unidadesEnStock" required></td>
            </tr>
            <tr>
                <td><label for="puntoDeReorden">Punto de Reorden:</label></td>
                <td><input type="number" name="puntoDeReorden" required></td>
            </tr>
            <tr>
                <td><label for="unidadesComprometidas">Unidades Comprometidas:</label></td>
                <td><input type="number" name="unidadesComprometidas" required></td>
            </tr>
            <tr>
                <td><label for="costo">Costo:</label></td>
                <td><input type="number" name="costo" step="0.01" required></td>
            </tr>
            <tr>
                <td><label for="talla">Talla:</label></td>
                <td><input type="text" name="talla"></td>
            </tr>
            <tr>
                <td><label for="imagen1">Imagen 1:</label></td>
                <td><input type="file" name="imagen1" accept="image/*" required></td>
            </tr>
            <tr>
                <td><label for="imagen2">Imagen 2:</label></td>
                <td><input type="file" name="imagen2" accept="image/*" required></td>
            </tr>
        </table>
        <br>
        <input type="submit" class="custom-button btn-actualizar" name="agregar" value="Agregar Producto">
    </form>
    <div id="mensaje"></div>
    <script>
$(document).ready(function() {
    $('#formularioAgregarProducto').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: 'agregar_producto.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function() {
                $('#formularioAgregarProducto')[0].reset(); // Limpia el formulario
            },
            error: function() {
                alert('Error al agregar el producto');
            }
        });
    });
});
</script>
</body>
</html>
<?php
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>/