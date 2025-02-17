<?php
session_start();
error_reporting(0);
$correo = $_SESSION['correo'];

if ($correo == null || $correo == '') {
  echo '<script language="javascript">alert("Por favor inicie sesión o regístrese");window.location.href="../HTML/login.php"</script>';
  die();
} else {
  include("../PHP/conex.php");

  // Consulta SQL para obtener el ID del usuario según el correo electrónico
  $query = "SELECT id FROM registro WHERE correo = '$correo'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $_SESSION['usuario_id'] = $row['id'];
  }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Donaciones realizadas</title>
    <link rel="shortcut icon" href="../Imagenes/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
<nav class="bg-white p-4">
        <div class="flex justify-between items-center">
            <!-- Logo o nombre del sitio -->
            <a href="#" class="text-green text-2xl font-bold">SaludRural</a>

            <!-- Menú de navegación -->
            <ul class="flex space-x-4">
                <li><a href="Index.php" class="text-black hover:bg-blue-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Inicio</a></li>
                <li class="relative">
                    <!-- Enlace con menú desplegable -->
                    <a href="#" class="text-black hover:bg-blue-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium" id="donaciones-menu">
                        <span>Donaciones</span>
                        <i class="fas fa-chevron-down ml-1"></i> <!-- Flecha hacia abajo -->
                    </a>

                    <!-- Menú desplegable -->
                    <ul class="absolute top-10 left-1/2 transform -translate-x-1/2 bg-white shadow-md rounded-md hidden" id="donaciones-menu-items">
                        <li><a href="form-medica.php" class="block px-4 py-2 text-gray-800 hover:bg-blue-600 hover:text-white">Medicamentos</a></li>
                        <li><a href="form-equipo.php" class="block px-4 py-2 text-gray-800 hover:bg-blue-600 hover:text-white">Equipos medicos</a></li>
                        <li><a href="form-insumo.php" class="block px-4 py-2 text-gray-800 hover:bg-blue-600 hover:text-white">Isumos medicos</a></li>
                        <li><a href="form-mone.php" class="block px-4 py-2 text-gray-800 hover:bg-blue-600 hover:text-white">Monetaria</a></li>
                        <li><a href="donaciones-reali.php" class="block px-4 py-2 text-gray-800 hover:bg-blue-600 hover:text-white">Realizadas</a></li>
                    </ul>
                </li>
                <li><a href="blog.php" class="text-black hover:bg-blue-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Blog</a></li>
                <li><a href="AcercaDe.php" class="text-black hover:bg-blue-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Nosotros</a></li>
                <li class="relative">
                    <!-- Enlace con menú desplegable -->
                    <a href="#" class="text-black hover:bg-blue-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium" id="hospitales-menu">
                        <span>Hospitales</span>
                        <i class="fas fa-chevron-down ml-1"></i> <!-- Flecha hacia abajo -->
                    </a>

                    <!-- Menú desplegable -->
                    <ul class="absolute top-10 left-1/2 transform -translate-x-1/2 bg-white shadow-md rounded-md hidden" id="hospitales-menu-items">
                        <li><a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-600 hover:text-white">Necesidades actuales</a></li>
                        <!-- <li><a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-600 hover:text-white">Historias de exito</a></li> -->
                    </ul>
                </li>
            </ul>

            <div class="relative">
                <button type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                    <span class="absolute -inset-1.5"></span>
                    <span class="sr-only">Open user menu</span>
                    <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                </button>
                <!-- Menú desplegable del usuario -->
                <ul class="absolute right-0 mt-2 py-2 w-50 bg-white rounded-lg shadow-md hidden" id="user-menu">
                <?php
                // Mostrar nombre del usuario si está disponible en la sesión
                if (isset($_SESSION['correo']) && !empty($_SESSION['correo'])) {
                    echo '<li><a href="#" class="block px-1 py-2 text-gray-800 hover:bg-blue-600 hover:text-white">' . $_SESSION['correo'] . '</a></li>';
                }
                ?>
                <li><a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-600 hover:text-white">Configuración</a></li>
                <li><a href="../PHP/cerrar.php" class="block px-4 py-2 text-red-600 hover:bg-red-600 hover:text-white">Cerrar Sesión</a></li>
            </ul>
            </div>
    </nav>

    <div class="w-full max-w-mn p-8  rounded-lg shadow-lg  mx-auto p-4">
        <h1 class="text-4xl font-bold mb-4 text-center">Donaciones realizadas</h1>
        <ul class="flex space-x-4 ">
                <li class="relative">
                    <!-- Enlace con menú desplegable -->
                    <a href="#" class="bg-white text-black hover:bg-blue-600 hover:text-white rounded-md px-3 py-2 text-sm font-medium" id="donaciones-menu-cate">
                        <span>Donaciones Monetarias</span>
                        <i class="fas fa-chevron-down ml-1"></i> <!-- Flecha hacia abajo -->
                    </a>

                    <!-- Menú desplegable -->
                    <ul class="absolute top-10 left-1/2 transform -translate-x-1/2 bg-white shadow-md rounded-md hidden" id="donaciones-cate-items">
                        <li><a href="donaciones-reali2.php" class="block px-4 py-2 text-gray-800 hover:bg-blue-600 hover:text-white">Donaciones Medicamentos</a></li>
                        <li><a href="donaciones-reali3.php" class="block px-4 py-2 text-gray-800 hover:bg-blue-600 hover:text-white">Donaciones Equipos medicos</a></li>
                        <li><a href="donaciones-reali4.php" class="block px-4 py-2 text-gray-800 hover:bg-blue-600 hover:text-white">Donaciones Isumos medicos</a></li>
                        <li><a href="donaciones-reali.php" class="block px-4 py-2 text-gray-800 hover:bg-blue-600 hover:text-white">Donaciones Monetaria</a></li>
                    </ul>
                </li>
        </ul>
        <?php

            // Verificar si el usuario ha iniciado sesión
            if (!isset($_SESSION['usuario_id'])) {
                // Redirigir al usuario a la página de inicio de sesión o mostrar un mensaje de error
                header('Location: login.php');
                exit();
            }
            
            // Realizar la conexión a la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "saludrural";
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            // Verificar la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }
            
            // Obtener el usuario_id de la sesión
            $usuarioId = $_SESSION['usuario_id'];
            
            // Realizar la consulta para obtener las donaciones del usuario
            $sql = "SELECT id_donacion, id_hospital, fecha, medicamento, descripcion FROM medicamentos WHERE id_usuario = $usuarioId";
            $resultado = $conn->query($sql);
            
            // Verificar si hubo algún error en la consulta
            if ($resultado === false) {
                // Manejo de errores
                echo "Error en la consulta: " . $conn->error;
            } else {
                if ($resultado->num_rows > 0) {
                    echo '<div class="grid grid-cols-2 gap-8">';
                    while ($donacion = $resultado->fetch_assoc()) {
                        echo '<div class="bg-white p-4 rounded-lg shadow-md">';
                        echo '<div><span class="font-semibold">ID:</span> ' . $donacion['id_donacion'] . '</div>';
                        echo '<div><span class="font-semibold">Hospital:</span> ' . obtenerNombreHospital($conn, $donacion['id_hospital']) . '</div>';
                        echo '<div><span class="font-semibold">Fecha de Donación:</span> ' . $donacion['fecha'] . '</div>';
                        echo '<div><span class="font-semibold">Nombre del medicamento:</span> ' . $donacion['medicamento'] . '</div>';
                        echo '<div><span class="font-semibold">Descripción:</span> ' . $donacion['descripcion'] . '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo '<div class="text-center mt-4">No se encontraron donaciones para este usuario.</div>';
                }
            }
            
            // Cerrar la conexión
            $conn->close();
            
            // Función para obtener el nombre del hospital por su ID
            function obtenerNombreHospital($conn, $id_hospital) {
                // Realizar la consulta para obtener el nombre del hospital por su ID
                $sql = "SELECT nombre FROM hospitales WHERE id = $id_hospital";
                $resultado = $conn->query($sql);
            
                // Verificar si hubo algún error en la consulta
                if ($resultado === false) {
                    // Manejo de errores
                    return "Hospital Desconocido";
                } else {
                    if ($resultado->num_rows > 0) {
                        $nombre_hospital = $resultado->fetch_assoc()['nombre'];
                        return $nombre_hospital;
                    } else {
                        return "Hospital Desconocido";
                    }
                }
            }
            ?>

    </div>

    <script>
        // Script para mostrar/ocultar el menú desplegable al hacer clic en "Donaciones"
        const donacionesMenu = document.getElementById('donaciones-menu');
        const donacionesMenuItems = document.getElementById('donaciones-menu-items');
        donacionesMenu.addEventListener('click', () => {
            donacionesMenuItems.classList.toggle('hidden');
        });

        // Script para mostrar/ocultar el menú desplegable al hacer clic en "Donaciones"
        const donacionesMenuCate = document.getElementById('donaciones-menu-cate');
        const donacionesMenuItemsCate = document.getElementById('donaciones-cate-items');
        donacionesMenuCate.addEventListener('click', () => {
            donacionesMenuItemsCate.classList.toggle('hidden');
        });

        // Script para mostrar/ocultar el menú desplegable del usuario al hacer clic en el botón del usuario
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });
                // Script para mostrar/ocultar el menú desplegable de donaciones al hacer clic en el botón de donaciones
                const hospitalesMenuButton = document.getElementById('hospitales-menu');
        const hospitalesMenuItems = document.getElementById('hospitales-menu-items');
        hospitalesMenuButton.addEventListener('click', () => {
            hospitalesMenuItems.classList.toggle('hidden');
        });
    </script>
</body>
<footer class="bg-gray-800 text-center text-white py-8">
  <div class="container mx-auto">
    <p class="text-lg font-bold">SaludRural</p>
    <p class="text-sm mt-2 mb-4">Si deseas saber más información sobre nosotros, puedes buscarnos y contactarnos en nuestras redes sociales.</p>
    <div class="flex justify-center space-x-4 mb-4">
      <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
      <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
      <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
      <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin-in"></i></a>
    </div>
    <ul class="flex items-center justify-center space-x-4">
      <li><a href="#" class="text-gray-400 hover:text-white">Inicio</a></li>
      <li><a href="#" class="text-gray-400 hover:text-white">Donaciones</a></li>
      <li><a href="#" class="text-gray-400 hover:text-white">Blog</a></li>
      <li><a href="#" class="text-gray-400 hover:text-white">Acerca de</a></li>
    </ul>
  </div>
</footer>
</html>
 


