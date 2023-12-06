<?php 
//session_start();
require_once('modelos/config.php');
include 'modelos/conexion.php';
include 'carrito.php';
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
        $status = "procesando"; // Puedes definir el estado de la venta
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
                header("Location: mostrarCarrito.php?mensaje=" . urlencode("Productos comprados con éxito. Se ha enviado un correo con los detalles de la compra."));
                exit;
            } else {
                // En caso de que haya un error al enviar el correo, redirige con un mensaje de error
                header("Location:mostrarCarrito.php?mensaje=" . urlencode("Error al enviar el correo."));
                exit;
            }
        } else {
            $mensaje = "Error al actualizar las unidades en stock.";
            header("Location: mostrarCarrito.php?mensaje=" . urlencode($mensaje));
            exit;
        }
    } catch (PDOException $e) {
        // En caso de error en la conexión a la base de datos
        echo "Error en la transacción: " . $e->getMessage();
    }
} else {
    header("Location: mostrarCarrito.php");
    exit;
}
?>