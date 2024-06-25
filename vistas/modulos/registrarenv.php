<div class="container-fluid mw-100">
  <div class="row justify-content-center mt-3">
    <div class="col-lg-12 text-center">
      <h3>REGISTRAR NUEVO ENVÍO</h3>
    </div>
  </div>
  <div class="row mt-2 justify-content-center">
    <div class="row mt-2">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header text-white">
            <div class="row align-items-center">
              <div class="col-md-3 bg-black ">
                <?php
                $proximoNumeroRegistro = ControladorPaquetes::ctrObtenerSiguienteNumeroRegistro();
                ?>
                <h4 class="text-white">Número [Ult. Registro <?php echo $proximoNumeroRegistro - 1; ?>]</h4>
              </div>
              <div class="col-md-8">
                <input type="text" class="form-control text-center" id="nro_registro" value="<?php echo $proximoNumeroRegistro; ?>" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header bg-secondary">
            <h4 class="mb-0 text-white text-center">Datos del Remitente</h4>
          </div>
          <form method="post">
            <div>
              <div class="card-body">
                <div class="row pt-3">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="control-label">Cedula</label>
                      <input type="text" class="form-control" name="cedula_enviador" id="cedula_enviador" required onchange="buscarCliente('enviador')" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="control-label">Nombre</label>
                      <input type="text" class="form-control" name="nombre_enviador" id="nombre_enviador" required />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="control-label">Telefono</label>
                      <input type="text" class="form-control" name="telefono_enviador" id="telefono_enviador" required />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="control-label">Direccion</label>
                      <input type="text" class="form-control" name="direccion_enviador" id="direccion_enviador" required />
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-header bg-secondary">
                <h4 class="mb-0 text-white text-center">Datos del Destinatario</h4>
              </div>
              <div class="card-body">
                <div class="row pt-3">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="control-label">Cedula</label>
                      <input type="text" class="form-control" name="cedula_remitente" id="cedula_remitente" required onchange="buscarCliente('remitente')" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="control-label">Nombre</label>
                      <input type="text" class="form-control" name="nombre_remitente" id="nombre_remitente" required />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="control-label">Telefono</label>
                      <input type="text" class="form-control" name="telefono_remitente" id="telefono_remitente" required />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="control-label">Direccion</label>
                      <input type="text" class="form-control" name="direccion_remitente" id="direccion_remitente" required />
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-header bg-secondary">
                <h4 class="mb-0 text-white text-center">Lugar de Salida - Llegada</h4>
              </div>
              <div class="card-body">
                <h5 class="bg-secondary" style="color: white; width: 140px">Lugar de partida</h5>
                <div class="row pt-3">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="control-label">Departamento</label>
                      <select class="select2 form-control" name="departamentoPartida" id="departamentoPartida" style="width: 100%; height: 36px" required>
                        <option value="">Seleccionar Departamento</option>
                        <?php
                        $departamentos = ControladorSucursales::ctrMostrarDepartamentos();
                        foreach ($departamentos as $departamento) {
                          echo '<option value="' . $departamento['departamento'] . '">' . $departamento['departamento'] . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="control-label">Provincia</label>
                      <select class="select2 form-control" name="provinciaPartida" id="provinciaPartida" style="width: 100%; height: 36px" required>
                        <option value="">Seleccionar Provincia</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="control-label">Sucursal</label>
                      <select class="select2 form-control" name="sucursalPartida" id="sucursalPartida" style="width: 100%; height: 36px" required>
                        <option value="">Seleccionar Sucursal</option>
                      </select>
                    </div>
                  </div>
                </div>

                <h5 class="bg-secondary" style="color: white; width: 140px">Lugar de llegada</h5>
                <div class="row pt-3">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="control-label">Departamento</label>
                      <select class="select2 form-control" name="departamentoLlegada" id="departamentoLlegada" style="width: 100%; height: 36px" required>
                        <option value="">Seleccionar Departamento</option>
                        <?php
                        $departamentos = ControladorSucursales::ctrMostrarDepartamentos();
                        foreach ($departamentos as $departamento) {
                          echo '<option value="' . $departamento['departamento'] . '">' . $departamento['departamento'] . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="control-label">Provincia</label>
                      <select class="select2 form-control" name="provinciaLlegada" id="provinciaLlegada" style="width: 100%; height: 36px" required>
                        <option value="">Seleccionar Provincia</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="control-label">Sucursal</label>
                      <select class="select2 form-control" name="sucursalLlegada" id="sucursalLlegada" style="width: 100%; height: 36px" required>
                        <option value="">Seleccionar Sucursal</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label class="control-label">Tipo de Envío</label>
                      <select class="select2 form-control" name="tipoEnvio" id="tipoEnvio" style="width: 100%; height: 36px" required>
                        <option value="Normal">Normal</option>
                        <option value="Domiciliario">Domiciliario</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3" id="direccionDiv" style="display: none;">
                      <label class="control-label">Dirección</label>
                      <input type="text" class="form-control" name="direccionLlegada" id="direccionLlegada" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-header bg-secondary">
                <h4 class="mb-0 text-white text-center">Datos del Envio</h4>
              </div>
              <div class="card-body">
                <div class="row pt-3">
                  <div class="col-md-2">
                    <div class="mb-3">
                      <label class="control-label">Cantidad</label>
                      <input type="text" class="form-control" name="cantidad" required />
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="mb-3">
                      <label class="control-label">Precio</label>
                      <input type="text" class="form-control" name="precio" required />
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="mb-3">
                      <label class="control-label">Estado de pago</label>
                      <div class="col form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="estadoPago" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="mb-3">
                      <label class="control-label">Fecha Recepcionado</label>
                      <input type="date" class="form-control" name="fechaRecepcion" id="fechaRecepcion" value="<?php echo date('Y-m-d'); ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="mb-3">
                      <label class="control-label">Tipo</label>
                      <select class="select2 form-control" name="tipo" style="width: 100%; height: 36px" required>
                        <option value="">Seleccionar...</option>
                        <option value="Electronico">Electrónico</option>
                        <option value="Oficina">Oficina</option>
                        <option value="Ropa">Ropa</option>
                        <option value="Comestibles">Comestibles</option>
                        <option value="Medicamentos">Medicamentos</option>
                        <option value="Documentos">Documentos</option>
                        <option value="Muebles">Muebles</option>
                        <option value="Juguetes">Juguetes</option>
                        <option value="Herramientas">Herramientas</option>
                        <option value="Cosmeticos">Cosméticos</option>
                        <option value="Libros">Libros</option>
                        <option value="Otros">Otros</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label class="control-label">Descripcion</label>
                      <input type="text" class="form-control" name="descripcion" required />
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="card-body border-top">
                  <button type="submit" class="btn btn-secondary rounded-pill px-4">
                    <div class="d-flex align-items-center">
                      <i class="ti ti-device-floppy me-1 fs-4"></i>
                      Guardar
                    </div>
                  </button>
                  <button type="button" class="btn btn-danger rounded-pill px-4 ms-2 text-white">
                    Cancelar
                  </button>
                </div>
              </div>
            </div>

        </div>

      </div>
      <?php
      $crearPaquete = new ControladorPaquetes();
      $crearPaquete->ctrCrearPaquete();
      ?>
      </form>
    </div>
  </div>
</div>