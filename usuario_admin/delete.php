<?php
include '../modelos/config.php';
include '../modelos/conexion.php';

//  la conexión a la base de datos y cualquier verificación de autenticación necesario
?>

<?php 
if (isset($_GET['id'])) {
    try {
        $productID = $_GET['id'];

        // Realiza una consulta SQL para eliminar el producto
        $sql = "DELETE FROM tblproductos WHERE ID = :productID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Producto eliminado con éxito
            header("Location: Eliminar.php"); 
            exit();
        } else {
            // Error al eliminar el producto
            echo "Error al eliminar el producto.";
        }
    } catch (PDOException $e) {
        // Manejo de errores de la base de datos
        echo "Error de base de datos: " . $e->getMessage();
    }
} else {
    echo "ID de producto no válido.";
}
?>