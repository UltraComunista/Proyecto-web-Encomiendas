    <?php

    require_once "../controladores/paquetes.controlador.php";
    require_once "../modelos/paquetes.modelo.php";

    class AjaxPaquetes
    {
        // Método para buscar paquetes
        public $terminoDeBusqueda;

        public function ajaxBuscarPaquetes()
        {
            $valor = $this->terminoDeBusqueda;
            $respuesta = ControladorPaquetes::ctrBuscarPaquetes($valor);
            echo json_encode($respuesta);
        }
    }

    // Capturar el término de búsqueda
    if (isset($_POST["terminoDeBusqueda"])) {
        $buscar = new AjaxPaquetes();
        $buscar->terminoDeBusqueda = $_POST["terminoDeBusqueda"];
        $buscar->ajaxBuscarPaquetes();
    }




    if (isset($_POST["departamento"])) {
        $departamento = $_POST["departamento"];
    
        // Obtener provincias por departamento
        $provincias = ControladorPaquetes::ctrMostrarProvinciasPorDepartamento($departamento);
        echo json_encode($provincias);
    }
    
    if (isset($_POST["departamentoSucursales"])) {
        $departamento = $_POST["departamentoSucursales"];
    
        // Obtener sucursales por departamento
        $sucursales = ControladorPaquetes::ctrMostrarSucursalesPorDepartamento($departamento);
        echo json_encode($sucursales);
    }
