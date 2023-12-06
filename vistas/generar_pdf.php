<?php
session_start();
require_once('../modelos/config.php');
include '../modelos/conexion.php';
require('../fpdf/fpdf.php'); // Ruta correcta a la librería FPDF

// Crear una clase extendida de FPDF
class PDF extends FPDF
{
    private $pdo; // Añadimos una propiedad para almacenar el objeto PDO

    // Método para establecer el objeto PDO
    public function setPDO($pdo)
    {
        $this->pdo = $pdo;
    }
    // Encabezado
    function Header()
    {
        // Establecer fuente Arial en negrita de 15 puntos
        $this->SetFont('Arial', 'B', 15);
        // Mover a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 10, 'Historial de Compras', 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Contenido del PDF
    function Body($compras)
    {
        $this->SetFont('Arial', '', 12);

        foreach ($compras as $compra) {
            // Mostrar la fecha y el total de la compra
            $this->Cell(0, 10, 'Fecha: ' . $compra['fecha'] . ', Total: ' . $compra['total'], 0, 1);

            // Obtener los detalles de la compra (nombres de productos, cantidad, precio unitario y total por producto)
            $detallesQuery = $this->pdo->prepare("SELECT p.nombre, d.cantidad, d.precio_unitario, d.cantidad * d.precio_unitario AS total_producto
                                            FROM tblventas_detalle d
                                            INNER JOIN tblproductos p ON d.id_productos = p.Id
                                            WHERE d.id_ventas = :id_venta");
            $detallesQuery->bindParam(':id_venta', $compra['id_ventas']); // Asegúrate de tener el campo correspondiente
            $detallesQuery->execute();
            $detalles = $detallesQuery->fetchAll(PDO::FETCH_ASSOC);

            $lineHeight = 6;

            // Crear una tabla para mostrar los detalles de los productos
            $this->Cell(50, $lineHeight, 'Producto', 1, 0, 'C');
            $this->Cell(30, $lineHeight, 'Cantidad', 1, 0, 'C');
            $this->Cell(40, $lineHeight, 'Precio Unitario', 1, 0, 'C');
            $this->Cell(40, $lineHeight, 'Total', 1, 1, 'C');
    
            // Mostrar los detalles de los productos en una tabla en el PDF
            foreach ($detalles as $detalle) {
                $detallesNombre = $detalle['nombre'];
                $this->MultiCell(50, $lineHeight, $detallesNombre, 1, 'C'); // Ajusta MultiCell para evitar relleno negro
                $this->Cell(30, $lineHeight, $detalle['cantidad'], 1, 0, 'C');
                $this->Cell(40, $lineHeight, $detalle['precio_unitario'], 1, 0, 'C');
                $this->Cell(40, $lineHeight, $detalle['total_producto'], 1, 1, 'C');
            }
            $this->Ln(10); // Espacio entre cada compra
        }
    }
}



// Inicializar el objeto PDF
$pdf = new PDF();
$pdf->AddPage();

if (isset($_SESSION['usuario'])) {
    $correo = $_SESSION['usuario'];

    try {
        // Crear una conexión a la base de datos...
        
        $pdo = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BD, USUARIO, PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Realizar la consulta y obtener los datos...
        
        $query = $pdo->prepare("SELECT v.fecha, v.total, v.id_ventas FROM tblventas v INNER JOIN tblventas_detalle d ON v.id_ventas = d.id_venta_detalles WHERE v.correo = :correo");
        $query->bindParam(':correo', $correo);
        $query->execute();
        $compras = $query->fetchAll(PDO::FETCH_ASSOC);

        // Establecer el objeto PDO en la instancia de PDF
        $pdf->setPDO($pdo);

        // Mostrar el cuerpo del PDF con los detalles de las compras
        $pdf->Body($compras);
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="historial_compras.pdf"');

        // Descargar el PDF
        $pdf->Output('historial_compras.pdf', 'D');
        // Descargar el PDF...
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "La sesión de usuario no está iniciada o el usuario no está definido.";
}
?>

