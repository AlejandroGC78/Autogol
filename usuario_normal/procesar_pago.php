<?php 
//session_start();
require_once('../modelos/config.php');
include '../modelos/conexion.php';
include '../usuario_normal/carrito.php';
$mensaje = "";
function actualizarUnidadesEnStock($productoID, $cantidad, $pdo) {
    try {
        // Comienza una transacción
        $pdo->beginTransaction();
        // Actualiza las unidades en stock restando la cantidad comprada
        $stmt = $pdo->prepare("UPDATE tblproductos SET UnidadesEnStock = UnidadesEnStock - :cantidad WHERE ID = :productoID");
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':productoID', $productoID, PDO::PARAM_INT);
        $stmt->execute();
        // Realiza el commit para confirmar los cambios en la base de datos
        $pdo->commit();
        return true;
    } catch (PDOException $e) {
        // En caso de error, realiza un rollback para deshacer los cambios y muestra un mensaje de error
        $pdo->rollBack();
        return false;
    }
}
if (isset($_POST['btnAccion']) && $_POST['btnAccion'] == 'Pagar' && !empty($_SESSION['CARRITO'])) {
    try {
        $pdo = new PDO("mysql:dbname=" . BD . ";host=" . SERVIDOR, USUARIO, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $total = 0;
        // Genera una clave de transacción única
        $claveTransaccion = md5(uniqid());
        foreach ($_SESSION['CARRITO'] as $producto) {
            $total = $total + ($producto['PRECIO'] * $producto['CANTIDAD']);
        }
        $correo = $_POST['email'];
        // Inserta los datos de la venta en la tabla de ventas
        $fecha = date("Y-m-d H:i:s");
        $status = "NO PAGADO"; // Puedes definir el estado de la venta
        $sentencia = $pdo->prepare("INSERT INTO tblventas (clavetransaccion, fecha, total, status, correo) VALUES (?, ?, ?, ?, ?)");
        $sentencia->execute([$claveTransaccion, $fecha, $total, $status, $correo]);
        $idVenta = $pdo->lastInsertId(); // Obtén el ID de la venta insertada
        // Inserta los detalles de la venta en la tabla de ventas_detalle
        foreach ($_SESSION['CARRITO'] as $producto) {
            $idProducto = $producto['ID'];
            $precioUnitario = $producto['PRECIO'];
            $cantidad = $producto['CANTIDAD'];
            $sentencia = $pdo->prepare("INSERT INTO tblventas_detalle (id_ventas, id_productos, Precio_unitario, Cantidad) VALUES (?, ?, ?, ?)");
            $sentencia->execute([$idVenta, $idProducto, $precioUnitario, $cantidad]);
        }
        ?>
  <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Procesar Pago </title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/css/contenido.css">
  <link rel="stylesheet" href="../assets/css/styles.css">
  <link rel="stylesheet" href="../assets/css/footer.css">
  <link rel="stylesheet" href="../assets/css/login.css">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <style>
    /* Cambiar el color del texto a blanco en la barra de navegación */
    .navbar-light .navbar-nav .nav-link {
        color: white !important;
    }
  </style>
</head>
<body>
  <header>
    <nav class="navbar  navbar-expand-lg navbar-light" style="background-color: #2b2a2c">
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
              <a class="nav-link" href="../vistas/cerrar_sesion.php">Cerrar sesión</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../usuario_normal/mostrarCarrito.php" id="cart-link">
                <i class="fa fa-shopping-cart"></i> 
                <span class="badge" id="cart-badge">
                  <?php echo (empty($_SESSION['CARRITO'])) ? 0 : count($_SESSION['CARRITO']); ?>
                </span>
              </a>
            </li>
          </ul>
        </div>
    </nav>
  </header>
  <script src="https://www.paypal.com/sdk/js?client-id=AXjo-M9E0VVjkGZMaDIjSb92WN1cw5qmhWtGLqxy6Mr3IVhokKqCFGhwoUxFCCgra6mF6VrnvHtcpVTX&currency=MXN"></script>
<!-- Bloque para el proceso de pago -->
  <div class="jumbotron text-center">
    <h1 class="display-4">¡Paso Final!</h1>
    <hr class="my-4">
    <p class="lead">Estás a punto de pagar con Paypal la cantidad:
    <h4>$<?php echo number_format($total, 2); ?></h4>
    <div id="smart-button-container">
           <div style="text-align: center;">
        <div id="paypal-button-container">
        <!--<button class="btn btn-lg btn-block" type="submit" name="btnAccion" value="Pagar" style="background-color: #FFD700; color: white;">Pagar</button> -->
        </div>
      </div>
    </div>
    </p>
    <p>Los productos serán procesados cuando el pago se valide <br/>
    <strong>(Para aclaraciones: peyeale7@gmail.com)</strong>
    </p>
  </div>
  <script src="https://www.paypal.com/sdk/js?client-id=AXjo-M9E0VVjkGZMaDIjSb92WN1cw5qmhWtGLqxy6Mr3IVhokKqCFGhwoUxFCCgra6mF6VrnvHtcpVTX&currency=MXN" data-sdk-integration- source="button-factory"></script>
   
   <script src="../assets/js/paypal.js">


      
  
   /* function initPayPalButton() {
    paypal. Buttons({
    style: {
    size: 'resnponsive',
    shape: 'pill',
    color: 'gold',
    layout: 'vertical',
    label: 'checkout',
    },

   payment: function(data, actions) {
    return actions.payment.create({
        payment: {
    transactions: [{description: "Productos el autogol:$<?php echo number_format($total,2);?>",
            amount: {total: '<?php echo $total;?>',
            custom: "<?php echo $claveTransaccion;?>#<?php echo openssl_encrypt($idVenta,COD,KEY);?>",
            currency:"MXN",}
                
            }
        ] 
        }
        });
    },
    
    createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            description: "Productos el autogol: $<?php echo number_format($total, 2); ?>",
            amount: {
              value: '<?php echo $total; ?>',
              currency_code: 'MXN'
            },
          }]
        });
      },
      onAuthorize: function(data, actions) {
        return actions.order.capture().then(function(details) {
          console.log(details); // Detalles de la transacción
          // Redirigir a la página de agradecimiento o realizar otras acciones después del pago
          window.location.href = 'equipos.php';
        });
      },
      onError: function(err) {
  console.error('Error en el pago:', err);
  alert('Ocurrió un error durante el proceso de pago. Por favor, inténtalo de nuevo.');
}

    }).render('#paypal-button-container');
    }
    initPayPalButton();*/
    </script>
    <script>
    // Lógica PHP para definir valores y variables necesarias
    const total = <?php echo json_encode($total); ?>;
    const claveTransaccion = "<?php echo $claveTransaccion; ?>";
    const idVenta = "<?php echo openssl_encrypt($idVenta, COD, KEY); ?>";

    // Llamada a la función initPayPalButton después de cargar paypal.js
    initPayPalButton(total, claveTransaccion, idVenta);
  </script>
</body>
</html>


        <?php
        $actualizacionesExitosas = true;
        foreach ($_SESSION['CARRITO'] as $producto) {
            $productoID = $producto['ID'];
            $cantidad = $producto['CANTIDAD'];
            // Actualiza las unidades en stock para cada producto
            $actualizacionesExitosas = $actualizacionesExitosas && actualizarUnidadesEnStock($productoID, $cantidad, $pdo);
        }
        if ($actualizacionesExitosas) {
           
            // Limpia el carrito
            $correoDestino = $_SESSION['usuario'];

            // Construye el cuerpo del correo con los detalles de la compra
            $cuerpo = 'Gracias por tu compra. Aquí están los detalles:';
            $cuerpo .= '<ul>';
            foreach ($_SESSION['CARRITO'] as $producto) {
                $cuerpo .= '<li>Producto: ' . $producto['NOMBRE'] . ' - Cantidad: ' . $producto['CANTIDAD'] . ' - Precio Unitario: ' . $producto['PRECIO'] . '</li>';
            }
            $cuerpo .= '</ul>';

            // Limpia el carrito después de construir el cuerpo del correo
            unset($_SESSION['CARRITO']);
            $mensaje = "Productos comprados con éxito.";

            // Construye los encabezados para el correo
            $header = "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html; charset=UTF-8\r\n";
            $header .= "From: Camisetas AutoGol <peyeale7@gmail.com>\r\n"; // Reemplaza esto con la dirección de tu tienda

            // Envía el correo con los detalles de la compra al usuario
            if (mail($correoDestino, 'Detalles de tu compra', $cuerpo, $header)) {
                // Redirige de nuevo a la página del carrito con un mensaje de éxito
                //header("Location: ../usuario_normal/mostrarCarrito.php?mensaje=" . urlencode("Productos comprados con éxito. Se ha enviado un correo con los detalles de la compra."));
                exit;
            } else {
                // En caso de que haya un error al enviar el correo, redirige con un mensaje de error
                header("Location: ../usuario_normal/mostrarCarrito.php?mensaje=" . urlencode("Error al enviar el correo."));
                exit;
            }
        } else {
            $mensaje5 = "Error al actualizar las unidades en stock.";
            header("Location: ../usuario_normal/mostrarCarrito.php?mensaje=" . urlencode($mensaje));
            exit;
        }
        
    } catch (PDOException $e) {
        // En caso de error en la conexión a la base de datos
        echo "Error en la transacción: " . $e->getMessage();
    }
}/* else {
    header("Location: ../usuario_normal/mostrarCarrito.php");
    exit;
}*/

