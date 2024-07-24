<?php

session_start();

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <!--  Title -->
  <title>Mordenize</title>
  <!--  Required Meta Tag -->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="handheldfriendly" content="true" />
  <meta name="MobileOptimized" content="width" />
  <meta name="description" content="Mordenize" />
  <meta name="author" content="" />
  <meta name="keywords" content="Mordenize" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!--  Favicon -->
  <link rel="shortcut icon" type="image/png" href="vistas/dist/images/logos/favicon.ico" />

  <!-- --------------------------------------------------- -->
  <!-- Prism Js -->
  <!-- --------------------------------------------------- -->
  <link rel="stylesheet" href="vistas/dist/libs/owl.carousel/dist/assets/owl.carousel.min.css">


  <link rel="stylesheet" href="vistas/dist/libs/sweetalert2/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="vistas/dist/libs/jquery-raty-js/lib/jquery.raty.css">

  <!-- --------------------------------------------------- -->
  <!-- Datatable -->
  <!-- --------------------------------------------------- -->
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">


  <!-- Core Css -->
  <link id="themeColors" rel="stylesheet" href="vistas/dist/css/style.min.css" />
  <script src="vistas/dist/libs/sweetalert2/dist/sweetalert2.min.js"></script>
  <script src="vistas/dist/js/forms/sweet-alert.init.js"></script>
  <script src="vistas/dist/js/plugins/toastr-init.js"></script>


</head>

<body>
  <?php


  if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {
    /*=============================================
    NAVBAR
    =============================================*/
    echo '<div class="page-wrapper" id="main-wrapper" data-theme="blue_theme"  data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">';

    include "modulos/navbar.php";


    /*=============================================
    MENU
    =============================================*/
    echo '<div class="body-wrapper">';
    include "modulos/menu.php";


    /*=============================================
    CONTENIDO
    =============================================*/

    if (isset($_GET["ruta"])) {

      if (
        $_GET["ruta"] == "inicio" ||
        $_GET["ruta"] == "registrarenv" ||
        $_GET["ruta"] == "listaenvios" ||
        $_GET["ruta"] == "remitente" ||
        $_GET["ruta"] == "destinatario" ||
        $_GET["ruta"] == "sucursal" ||
        $_GET["ruta"] == "prueba" ||
        $_GET["ruta"] == "usuarios"  ||
        $_GET["ruta"] == "logout"
      ) {

        include "modulos/" . $_GET["ruta"] . ".php";
      } else {

        include "modulos/404.php";
      }
    } else {

      include "modulos/inicio.php";
    }

    include "modulos/footer.php";

    echo '</div>';
  } else {

    include "modulos/login.php";
  }

  ?>






  <!--  Customizer -->
  <!--  Import Js Files -->
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <script src="vistas/dist/libs/jquery/dist/jquery.min.js"></script>
  <script src="vistas/dist/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="vistas//dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--  core files -->
  <script src="vistas/dist/js/app.min.js"></script>
  <script src="vistas/dist/js/app-style-switcher.js"></script>
  <script src="vistas/dist/js/custom.js"></script>
  <script src="vistas/dist/libs/prismjs/prism.js"></script>
  <script src="vistas/dist/js/app.minisidebar.init.js"></script>
  <script src="vistas/dist/js/sidebarmenu.js"></script>
    
  <script src="vistas/dist/js/custom.js"></script>

  <!--  current page js files -->
  <script src="vistas/dist/libs/moment-js/build/moment.min.js"></script>
  <script src="vistas/dist/libs/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="vistas/dist/libs/bootstrap-switch/dist/js/bootstrap-switch.min.js"></script>
  <script src="vistas/dist/js/forms/bootstrap-switch.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="vistas/dist/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="vistas/dist/js/dashboard.js"></script>
  <script src="vistas/dist/js/plugins/toastr-init.js"></script>
  <script src="vistas/dist/js/apps/contact.js"></script>
  <script src="vistas/js/validaciones.js"></script>
  <script src="vistas/js/usuarios.js"></script>
  <script src="vistas/js/sucursal.js"></script>
  <script src="vistas/js/remitente.js"></script>
  <script src="vistas/js/paquetes.js"></script>
  <script src="vistas/js/destinatario.js"></script>
  
  <script src="vistas/js/validacionesUsuarios.js"></script>
  <script src="vistas/js/validacionesEnvios.js"></script>




</body>

</html>

