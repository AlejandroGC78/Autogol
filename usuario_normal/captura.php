<?php
require_once('../modelos/config.php');
include '../modelos/conexion.php';
include './carrito.php';

$json = file_get_contents('php://input');
$datos = json_decode($json, true);

if (is_array($datos)) {
    try {
        // Conectar a la base de datos utilizando PDO
        $pdo = new PDO("mysql:dbname=" . BD . ";host=" . SERVIDOR, USUARIO, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id_transaccion = $datos['id_transaccion']; // 'id_transaccion' para reflejar la estructura del payload
        $status = $datos['detalles']['status'];
        // Actualizar el registro más reciente en la tabla tblventas con el ID de transacción proporcionado
        $query = $pdo->prepare("UPDATE tblventas SET PaypalDatos = :id_transaccion, status = :status WHERE id_ventas = (SELECT MAX(id_ventas) FROM tblventas)");

        // Bind del valor del ID a la consulta
        $query->bindParam(':id_transaccion', $id_transaccion);
        $query->bindParam(':status', $status);
        // Ejecutar la consulta
        $query->execute();

        // Verificar si la actualización fue exitosa
        if ($query->rowCount() > 0) {
            echo "Registro actualizado correctamente en la tabla tblventas.";
        } else {
            echo "No se pudo actualizar el registro en la tabla tblventas.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>