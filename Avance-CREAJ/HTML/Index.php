<?php
session_start();
error_reporting(0);

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    echo '<script language="javascript">alert("Por favor inicie sesión o regístrese");window.location.href="../HTML/login.php"</script>';
    die();
} else {
    include("../PHP/conex.php");

    // Consulta SQL para obtener el ID del usuario según el correo electrónico
    $correo = $_SESSION['correo'];
    $query = "SELECT id FROM registro WHERE correo = '$correo'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['usuario_id'] = $row['id'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
  <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>SaludRural</title>
    <link rel="shortcut icon" href="../Imagenes/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  </head>
  <body>
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





    <main>
    <section class="bg-blue-600 text-white py-24">
      <div class="container mx-auto text-center">
        <h1 class="text-4xl font-bold mb-4">¡Ayúdanos a llevar la salud a zonas rurales!</h1>
        <p class="text-lg mb-8">Tu generosa donación marca la diferencia en la vida de quienes más lo necesitan.</p>
        <a href="#" class="bg-green-500 hover:bg-green-600 text-white py-2 px-6 rounded-full text-lg font-semibold transition duration-300 ease-in-out">Realizar Donación</a>
      </div>
    </section>
    <section class="bg-white py-24">
      <div class="container mx-auto text-center">
        <h2 class="text-2xl font-bold mb-4">¿Cual es la importancia de que se realicen donaciones a hospitales necesitados?</h2>
        <p class="text-lg mb-8">Recursos Limitados: Muchos centros hospitalarios, especialmente en áreas de bajos recursos o en momentos de crisis, pueden enfrentar limitaciones financieras y carecer de los recursos necesarios para proporcionar atención médica de calidad. Las donaciones monetarias pueden ayudar a compensar estas limitaciones y garantizar que los hospitales tengan acceso a los equipos, suministros y personal necesarios para brindar atención médica adecuada.

        Respuesta a Emergencias: En situaciones de emergencia, como desastres naturales o epidemias, los hospitales pueden verse abrumados por la demanda de atención médica. Las donaciones permiten a los hospitales estar mejor preparados para responder a estas situaciones críticas al proporcionar los recursos necesarios para manejar un aumento repentino en la demanda de atención médica.

        Atención a Grupos Vulnerables: Los hospitales que atienden a poblaciones desfavorecidas o marginadas a menudo enfrentan desafíos adicionales para proporcionar atención médica adecuada. Las donaciones pueden ayudar a abordar estas disparidades al proporcionar recursos adicionales para garantizar que todos tengan acceso a atención médica de calidad.

        Mejora de la Infraestructura: Los hospitales a menudo necesitan actualizar su infraestructura, como la renovación de instalaciones obsoletas, la compra de equipos médicos modernos y la mejora de la capacidad de atención. Las donaciones pueden permitir que los hospitales realicen estas mejoras, lo que a su vez beneficia a los pacientes al ofrecer un entorno más seguro y cómodo para recibir atención médica.
        </p>
        <a href="#" class="text-blue-600 hover:underline">Leer más sobre nuestra misión</a>
      </div>
    </section>

    </main>
    <main>
      <section id="hero">
        <h1>¡Bienvenido a SaludRural!</h1>
        <p>
          Ayudanos a apoyar a los mas necesitados
        </p></br>
        </p>
      </section>
    </main>
    <script>
    // Script para mostrar/ocultar el menú desplegable del usuario al hacer clic en el botón del usuario
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    userMenuButton.addEventListener('click', () => {
        userMenu.classList.toggle('hidden');
    });

    // Script para mostrar/ocultar el menú desplegable de donaciones al hacer clic en el botón de donaciones
    const donacionesMenuButton = document.getElementById('donaciones-menu');
    const donacionesMenuItems = document.getElementById('donaciones-menu-items');
    donacionesMenuButton.addEventListener('click', () => {
        donacionesMenuItems.classList.toggle('hidden');
    });

    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const header = document.querySelector('.flex'); // Cambia esto al selector correcto de tu encabezado

    mobileMenuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
      header.classList.toggle('h-16'); // Ajusta la altura del encabezado según tus necesidades
    });
        // Script para mostrar/ocultar el menú desplegable de donaciones al hacer clic en el botón de donaciones
        const hospitalesMenuButton = document.getElementById('hospitales-menu');
        const hospitalesMenuItems = document.getElementById('hospitales-menu-items');
        hospitalesMenuButton.addEventListener('click', () => {
            hospitalesMenuItems.classList.toggle('hidden');
        });
</script>
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

  </body>
</html>