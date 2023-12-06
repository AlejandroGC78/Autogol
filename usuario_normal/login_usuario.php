<?php
session_start();
include '../modelos/config.php';
include '../modelos/conexion.php';

if (isset($_POST["submit"])) {
    // Verificar reCAPTCHA para el formulario de inicio de sesión
    $secret = "6Ld73AwpAAAAAH4p6wLAAYl9yKZa3zqJx4Fz9HbJ"; // Reemplaza con tu clave secreta de reCAPTCHA
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
    $data = file_get_contents($url);
    $row = json_decode($data, true);

    if ($row['success'] == "true") {
        // Lógica de inicio de sesión
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];  // Corregí el nombre de la variable aquí

        try {
            $query = $pdo->prepare("SELECT * FROM tblusuarios WHERE correo = :correo");
            $query->bindParam(':correo', $correo);
            $query->execute();

            if ($query->rowCount() > 0) {
                $usuario = $query->fetch(PDO::FETCH_ASSOC);

                // Verifica la contraseña usando password_verify
                if (password_verify($contrasena, $usuario['contrasena'])) {
                    $_SESSION['usuario'] = $correo;

                    // Validar el rol y redirigir
                    if ($usuario['id_cargo'] == 1) {
                        header("location: ../usuario_admin/index.php"); // Ruta para administradores
                        exit;
                    } elseif ($usuario['id_cargo'] == 2) {
                        header("location: ../usuario_normal/index_usuario.php"); // Ruta para clientes
                        exit;
                    } else {
                        // En caso de que haya más roles, agrega condiciones adicionales aquí
                        // header("location: otra_ruta.php");
                        // exit;
                    }
                } else {
                    echo '<script>alert("Contraseña incorrecta. Por favor, verifique los datos.");
                        window.location = "../vistas/login.php";
                    </script>';
                    exit;
                }
            } else {
                echo '<script>alert("Usuario no existe. Por favor, verifique los datos.");
                    window.location = "../vistas/login.php";
                </script>';
                exit;
            }
        } catch (PDOException $e) {
            echo "Error al validar el login: " . $e->getMessage();
        }
    } else {
        echo '<script>alert("Error: ¡Captcha no válido!");
            window.location = "../vistas/login.php";
        </script>';
        exit;
    } 
}
?>



