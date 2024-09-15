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
  <link rel="stylesheet" href="vistas/dist/libs/prismjs/themes/prism-okaidia.min.css">

  <link rel="stylesheet" href="vistas/dist/libs/jquery-raty-js/lib/jquery.raty.css">
  <link rel="stylesheet" href="vistas/dist/libs/sweetalert2/dist/sweetalert2.min.css">
  <!-- --------------------------------------------------- -->
  <!-- Datatable -->
  <!-- --------------------------------------------------- -->
  <link rel="stylesheet" href="vistas/dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">


  <!-- Core Css -->
  <link id="themeColors" rel="stylesheet" href="vistas/dist/css/style.min.css" />

  <script src="vistas/dist/js/plugins/toastr-init.js"></script>


</head>
<style>
  .dataTables_wrapper .dataTables_length,
  .dataTables_wrapper .dataTables_filter {}

  .dataTables_wrapper .dataTables_length {
    margin-right: auto;
  }

  .dataTables_wrapper .dataTables_filter {
    margin-left: auto;
  }

  .dataTables_wrapper .dataTables_filter input {
    border-radius: 4px;
    padding: 5px 10px;
    font-size: 14px;
  }

  .dataTables_wrapper .dataTables_length select {
    border-radius: 4px;
    padding: 5px 10px;
    font-size: 14px;
  }

  table.dataTable.no-footer {
    border-bottom: none;
  }

  table.dataTable thead th,
  table.dataTable tbody td {
    border: none;
    padding: 11px;
    font-size: 13px;
  }

  table.dataTable.stripe tbody tr.odd,
  table.dataTable.display tbody tr.odd {
    background-color: #f9f9f9;
  }

  table.dataTable.stripe tbody tr.even,
  table.dataTable.display tbody tr.even {
    background-color: #fff;
  }

  table.dataTable.hover tbody tr:hover {
    background-color: #f1f1f1;
  }
</style>

<body>
  <?php
  echo '<div 
class="page-wrapper"
id="main-wrapper"
data-layout="vertical"
data-navbarbg="skin6"
data-sidebartype="full"
data-sidebar-position="fixed"
data-header-position="fixed"
>';

  if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {

    // Verificar el perfil del usuario
    if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 5) {

      include "modulos/empresa/navbar_empresa.php";
      echo '<div class="body-wrapper">';

      include "modulos/empresa/menu_empresa.php";

      /*=============================================
      CONTENIDO
      =============================================*/

      if (isset($_GET["ruta"])) {

        if (
          $_GET["ruta"] == "enviosempresa" ||
          $_GET["ruta"] == "registrarenv" ||
          $_GET["ruta"] == "listaenvios" ||
          $_GET["ruta"] == "pagoexitoso" ||
          $_GET["ruta"] == "cliente" ||
          $_GET["ruta"] == "sucursal" ||
          $_GET["ruta"] == "reportesx" ||
          $_GET["ruta"] == "ajustes" ||
          $_GET["ruta"] == "logout"
        ) {
          include "modulos/empresa/" . $_GET["ruta"] . ".php";
          echo '</div>';
        } else {
          include "modulos/404.php";
        }
      } else {
        // Si no se especifica una ruta y el perfil es 5, redirigir automáticamente a "envios_empresa"
        header("Location: index.php?ruta=enviosempresa");
        exit();
      }
    } else {

      /*=============================================
      NAVBAR
      =============================================*/

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
          $_GET["ruta"] == "pagoexitoso" ||
          $_GET["ruta"] == "cliente" ||
          $_GET["ruta"] == "sucursal" ||
          $_GET["ruta"] == "reportesx" ||
          $_GET["ruta"] == "usuarios" ||
          $_GET["ruta"] == "envios_empresa" ||
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
    }
  } else {
    include "modulos/login.php";
  }
  ?>





  <!--  Customizer -->
  <!--  Import Js Files -->


  <!--  core files -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!--  current page js files -->
  <script src="vistas/dist/libs/moment-js/build/moment.min.js"></script>
  <script src="vistas/dist/libs/owl.carousel/dist/owl.carousel.min.js"></script>


  <script src="vistas/dist/libs/jquery/dist/jquery.min.js"></script>
  <script src="vistas/dist/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="vistas/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="vistas/dist/libs/prismjs/prism.js"></script>

  <script src="dist/libs/jquery/dist/jquery.min.js"></script>
  <script src="dist/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- ---------------------------------------------- -->
  <!-- core files -->
  <!-- ---------------------------------------------- -->
  <script src="dist/js/app.min.js"></script>
  <script src="dist/js/app.init.js"></script>
  <script src="dist/js/app-style-switcher.js"></script>
  <script src="dist/js/sidebarmenu.js"></script>

  <script src="dist/js/custom.js"></script>
  <!-- ---------------------------------------------- -->
  <!-- current page js files -->
  <!-- ---------------------------------------------- -->
  <script src="dist/js/apps/contact.js"></script>
  <!-- ---------------------------------------------- -->
  <!-- core files -->
  <!-- ---------------------------------------------- -->
  <script src="vistas/dist/js/app.min.js"></script>
  <script src="vistas/dist/js/app.minisidebar.init.js"></script>
  <script src="vistas/dist/js/app-style-switcher.js"></script>
  <script src="vistas/dist/js/sidebarmenu.js"></script>
  <script src="vistas/dist/js/apps/contact.js"></script>
  <script src="vistas/dist/js/custom.js"></script>

  <!-- ---------------------------------------------- -->
  <!-- current page js files -->
  <!-- ---------------------------------------------- -->
  <script src="vistas/dist/js/apps/contact.js"></script>
  <script src="vistas/dist/libs/jquery-steps/build/jquery.steps.min.js"></script>
  <script src="vistas/dist/libs/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="vistas/dist/js/forms/form-wizard.js"></script>
  <script src="vistas/dist/libs/datatables.net/js/jquery.dataTables.min.js"></script>

  <script src="vistas/dist/js/datatable/datatable-basic.init.js"></script>
  <!-- DataTables JS -->
  <script src="vistas/dist/libs/sweetalert2/dist/sweetalert2.min.js"></script>
  <script src="vistas/dist/js/forms/sweet-alert.init.js"></script>


  <script src="vistas/dist/js/dashboard.js"></script>
  <script src="vistas/dist/js/plugins/toastr-init.js"></script>

  <script src="vistas/js/plantilla.js"></script>
  <script src="vistas/js/sucursal.js"></script>

  <script src="vistas/js/cliente.js"></script>
  <script src="vistas/js/usuarios.js"></script>
  <script src="vistas/js/paquetes.js"></script>





</body>

</html>