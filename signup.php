<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portafolio de Maira y Juan Carlos: Desarrollo web y diseño UI/UX">
    <meta name="keywords" content="desarrollo web, diseño UI/UX, frontend, backend, portafolio">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/signup_styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="assets/img/icon.png" type="image/png"> </head>
    
</head>
<body>
    <header class="main-header">
        <div class="container">
            <h1 class="logo"><a href="index.html"> <img src="assets/img/logo.jpg" alt="logo principal" class="logo"></a></h1>
            <nav class="main-nav">
                <ul class="nav-list">
                    <li class="nav-item dropdown">
                        <a href="#" class="dropbtn">Nuestro Equipo <span class="arrow-down"></span></a>
                        <div class="dropdown-content">
                            <a href="cv-individual/cv1.html">Maira Alejandra</a>
                            <a href="cv-individual/cv2.html">Juan Carlos</a>
                        </div>
                    </li>
                    <li class="nav-item"><a href="index.html#about">Sobre Nosotros</a></li>
                    <li class="nav-item"><a href="index.html#contact">Contacto</a></li>
                    <li class="nav-item"><a href="signup.php">Login</a></li> 
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="register-container">
            <h2>Registro de Usuario</h2>

            <?php
            // Configuración de la base de datos
            $servername = "127.0.0.1:3307"; // ¡Puerto especificado aquí!
            $username = "root";             // Usuario por defecto de XAMPP
            $password = "";                 // Contraseña por defecto de XAMPP (vacía)
            $dbname = "conexion";           // Nombre de la base de datos

            // Mensajes de estado
            $message = '';
            $message_type = ''; // 'success' o 'error'

            // Verificar si se envió el formulario
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Obtener los datos del formulario
                $user = $_POST['user'] ?? '';
                $pass = $_POST['password'] ?? '';
                $mail = $_POST['mail'] ?? '';
                $tel = $_POST['tel'] ?? '';

                // Validar que los campos no estén vacíos
                if (empty($user) || empty($pass) || empty($mail)) {
                    $message = "Por favor, complete todos los campos obligatorios (Usuario, Contraseña, Correo).";
                    $message_type = 'error';
                } else {
                    // *** HASHEAR LA CONTRASEÑA ***
                    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

                    // Conexión a la base de datos
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Verificar la conexión
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    // Preparar la consulta SQL para evitar inyecciones SQL
                    $stmt = $conn->prepare("INSERT INTO usuarios (user, password, mail, tel) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $user, $hashed_password, $mail, $tel); // "ssss" indica 4 strings

                    // Ejecutar la consulta
                    if ($stmt->execute()) {
                        $message = "¡Registro exitoso! Ya puedes iniciar sesión.";
                        $message_type = 'success';
                    } else {
                        // Capturar errores específicos, como usuario o correo duplicado
                        if ($conn->errno == 1062) { // Código de error para entrada duplicada
                            $message = "Error: El nombre de usuario o el correo electrónico ya existen.";
                        } else {
                            $message = "Error al registrar usuario: " . $stmt->error;
                        }
                        $message_type = 'error';
                    }

                    // Cerrar la conexión y el statement
                    $stmt->close();
                    $conn->close();
                }
            }
            ?>

            <?php if (!empty($message)): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form action="signup.php" method="POST">
                <div class="form-group">
                    <label for="user" class="sr-only">Usuario:</label> <div class="input-icon-group">
                        <i class="fas fa-user icon-prefix"></i> <input type="text" id="user" name="user" placeholder="Usuario" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="sr-only">Contraseña:</label>
                    <div class="input-icon-group">
                        <i class="fas fa-lock icon-prefix"></i> <input type="password" id="password" name="password" placeholder="Contraseña" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mail" class="sr-only">Correo Electrónico:</label>
                    <div class="input-icon-group">
                        <i class="fas fa-envelope icon-prefix"></i> <input type="email" id="mail" name="mail" placeholder="Correo Electrónico" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel" class="sr-only">Teléfono (Opcional):</label>
                    <div class="input-icon-group">
                        <i class="fas fa-phone icon-prefix"></i> <input type="tel" id="tel" name="tel" placeholder="Teléfono (Opcional)">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Registrarse</button>
            </form>
        </div>
    </div>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2025 Desarrollado por Maira Alejandra & Juan Carlos. Todos los derechos reservados.</p>
            <div class="social-links">
                <a href="www.google.com" class="social-icon" aria-label="LinkedIn Maira"><i class="fab fa-linkedin"></i></a>
                <a href="www.google.com" class="social-icon" aria-label="GitHub Juan Carlos"><i class="fab fa-github"></i></a>
                </div>
        </div>
    </footer>
</body>
</html>