<?php
include '../modelos/config.php';
include '../modelos/conexion.php';

function limpiarInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST["register_submit"])) {
    // Verificar reCAPTCHA para el formulario de registro
    $secret = "6Ld73AwpAAAAAH4p6wLAAYl9yKZa3zqJx4Fz9HbJ"; // Reemplaza con tu clave secreta de reCAPTCHA
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
    $data = file_get_contents($url);
    $row = json_decode($data, true);

    if ($row['success'] == "true") {
        // Lógica de registro
        $nombre = limpiarInput($_POST['nombre']);
        $primer_apellido = limpiarInput($_POST['primer_apellido']);
        $segundo_apellido = limpiarInput($_POST['segundo_apellido']);
        $nuevo_numero_telefono = limpiarInput($_POST['numero_telefono']);
        $correo = limpiarInput($_POST['correo']);
        $usuario = limpiarInput($_POST['usuario']);
        $contrasena = password_hash(limpiarInput($_POST['contrasena']), PASSWORD_DEFAULT);

        // Validar el formato del correo electrónico usando filter_var
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            echo "El formato del correo electrónico es inválido.";
        } else {
            try {
                // Verificar si el correo ya existe
                $verificar_correo = $pdo->prepare("SELECT * FROM tblusuarios WHERE correo = :correo");
                $verificar_correo->bindParam(':correo', $correo);
                $verificar_correo->execute();

                // Verificar si el nombre de usuario ya existe
                $verificar_usuario = $pdo->prepare("SELECT * FROM tblusuarios WHERE usuario = :usuario");
                $verificar_usuario->bindParam(':usuario', $usuario);
                $verificar_usuario->execute();

                if ($verificar_correo->rowCount() > 0) {
                    echo "El correo ya está registrado. Por favor, elija otro correo.";
                } elseif ($verificar_usuario->rowCount() > 0) {
                    echo "El nombre de usuario ya está en uso. Por favor, elija otro nombre de usuario.";
                } else {
                    // El correo y el nombre de usuario no existen, proceder a registrar el usuario
                    $query = $pdo->prepare("INSERT INTO tblusuarios (nombre, primer_apellido, segundo_apellido, numero_telefono ,correo, usuario, contrasena) VALUES (:nombre, :primer_apellido, :segundo_apellido, :numero_telefono ,:correo, :usuario, :contrasena)");
                    
                    $query->bindParam(':nombre', $nombre);
                    $query->bindParam(':primer_apellido', $primer_apellido);
                    $query->bindParam(':segundo_apellido', $segundo_apellido);
                    $query->bindParam(':numero_telefono', $nuevo_numero_telefono);
                    $query->bindParam(':correo', $correo);
                    $query->bindParam(':usuario', $usuario);
                    $query->bindParam(':contrasena', $contrasena);

                    if ($query->execute()) {
                        echo '<script> window.location = "index_usuario.php"; </script>';
                    } else {
                        echo "Error al registrar el usuario.";
                    }
                }
            } catch (PDOException $e) {
                echo "Error al registrar el usuario: " . $e->getMessage();
            }
        }
    } else {
        echo '<script>alert("Error: ¡Captcha no válido!");
            window.location = "registro_usuarios.php";
        </script>';
        exit;
    }
}
?>
