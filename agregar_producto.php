<?php
require_once('modelos/config.php');
include 'modelos/conexion.php';

$response = array(); // Crear una respuesta que contendrá el mensaje

if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $unidadesEnStock = $_POST['unidadesEnStock'];
    $puntoDeReorden = $_POST['puntoDeReorden'];
    $unidadesComprometidas = $_POST['unidadesComprometidas'];
    $costo = $_POST['costo'];
    $imagen1_nombre = $_FILES['imagen1']['name'];
    $imagen2_nombre = $_FILES['imagen2']['name'];

    // Directorio de destino para las imágenes (ajusta esta ruta según tu estructura de directorios)
    $directorio_destino = __DIR__ . '/uploads/';

    // Rutas completas para los archivos temporales y de destino
    $imagen1_temporal = $_FILES['imagen1']['tmp_name'];
    $imagen2_temporal = $_FILES['imagen2']['tmp_name'];
    $imagen1_destino = $directorio_destino . $imagen1_nombre;
    $imagen2_destino = $directorio_destino . $imagen2_nombre;

    // Verifica si los archivos se han subido correctamente antes de la inserción
    if (move_uploaded_file($imagen1_temporal, $imagen1_destino) && move_uploaded_file($imagen2_temporal, $imagen2_destino)) {
        // Agrega la vinculación de las imágenes a la consulta
        $ruta_imagen1 = '../uploads/' . $imagen1_nombre;
        $ruta_imagen2 = '../uploads/' . $imagen2_nombre;

        $consulta = $pdo->prepare("INSERT INTO tblproductos (Nombre, Precio, Descripcion, UnidadesEnStock, PuntoDeReorden, UnidadesComprometidas, Costo, Imagen, Imagen2) VALUES (:nombre, :precio, :descripcion, :unidadesEnStock, :puntoDeReorden, :unidadesComprometidas, :costo, :ruta_imagen1, :ruta_imagen2)");

        // Agregar la vinculación para 'talla' si es necesario
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':precio', $precio);
        $consulta->bindParam(':descripcion', $descripcion);
        $consulta->bindParam(':unidadesEnStock', $unidadesEnStock);
        $consulta->bindParam(':puntoDeReorden', $puntoDeReorden);
        $consulta->bindParam(':unidadesComprometidas', $unidadesComprometidas);
        $consulta->bindParam(':costo', $costo);
        $consulta->bindParam(':ruta_imagen1', $ruta_imagen1);
        $consulta->bindParam(':ruta_imagen2', $ruta_imagen2);

        if ($consulta->execute()) {
            header('Location: agregar_producto_form.php');
            exit();
        } else {
            $response['success'] = false;
            $response['message'] = "Error al agregar el producto.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Error al subir las imágenes.";
    }
} else {
    $response['success'] = false;
    $response['message'] = "No se recibieron datos para agregar el producto.";
}

echo json_encode($response);
?>
