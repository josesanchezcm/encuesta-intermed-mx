<?php
//Si no tiene permisos de rol admin, redirect a pagina principal
if (!(isset($_SESSION['rol']) && $_SESSION['rol'] == "admin")){
  redirect(base_url().'admin');
}
?>
<div id="suscripciones" class="container-fluid flama">
<div class="row">
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#home" onclick="obtenerSeleccionados()">Seleccionados</a></li>
  <li><a data-toggle="tab" href="#menu1" onclick="obtenerNoSeleccionados()">No seleccionados</a></li>
</ul>
</div>
<div class="tab-content">
<div id="home" class="tab-pane fade in active" >
      <h3>Médicos seleccionados</h3>
      <div class="table-responsive">
        <table id="pa" class="table table-striped table-condensed">
          <thead>
            <tr>
              <th style="width:20%">Nombre</th>
              <th style="width:10%" class="text-center">Correo</th>
              <th style="width:10%" class="text-center">Especialidad</th>
              <th style="width:15%" class="text-center">Telefonos</th>
              <th style="width:45%" class="text-center">Direcciones</th>
            </tr>
          </thead>
          <tbody id="seleccionadosList">

          </tbody>
        </table>
      </div>
    </div>
    <div id="menu1" class="tab-pane fade in">
        <h3>Médicos no seleccionados</h3>
        <div class="table-responsive">
          <table id="pa" class="table table-striped table-condensed">
            <thead>
              <tr>
                <th style="width:20%">Nombre</th>
                <th style="width:10%" class="text-center">Correo</th>
                <th style="width:10%" class="text-center">Especialidad</th>
                <th style="width:15%" class="text-center">Telefonos</th>
                <th style="width:45%" class="text-center">Direcciones</th>
              </tr>
            </thead>
            <tbody id="noSeleccionadosList">

            </tbody>
          </table>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ActualizarMedico">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modificar médico</h4>
      </div>
      <div class="modal-body">
        <div id="nombreDatos" class="container-fluid" >
          <form method="post" onsubmit="guardarMedico();return false;" id="registroMedico" class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Datos Generales del Medico</h3>
            </div>
            <div class="panel-body">
              <input type="hidden" id="medico_id" value="">
              <div class="row">
                <div class="col-md-8">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <input type="text" class="form-control" id="nombre" placeholder="Nombre(s)">
                    </div>
                    <div class="form-group col-md-4">
                      <input type="text" class="form-control" id="apellidoP" placeholder="Apellido paterno">
                    </div>
                    <div class="form-group col-md-4">
                      <input type="text" class="form-control" id="apellidoM" placeholder="Apellido materno">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="email" class="form-control" id="email" placeholder="E-mail:">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="especialidad" placeholder="Especialidad:">
                      <?php
                        echo '<script type="text/javascript">var autocompleteEspecialidades = [];</script>';
                        foreach ($especialidades as $especialidad) {
                          echo '<script type="text/javascript">autocompleteEspecialidades.push("'.$especialidad['especialidad'].'")</script>';
                        }
                      ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <button class="btn btn-info btn-block" id="agregarDatos" type="submit">Guardar Medico</button>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-warning btn-block" id="editarDatos">Editar</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div id="direccionDatos" class="container-fluid " >
          <form method="post" onsubmit="return false;" id="registroDireccion" class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Direcciones</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <input type="text" class="form-control" id="nombreDireccion" placeholder="Nombre">
                    </div>
                    <div class="form-group col-md-5">
                      <input type="text" class="form-control" id="direccion" placeholder="Calle">
                    </div>
                    <div class="form-group col-md-3">
                      <input type="text" class="form-control" id="numero" placeholder="Numero">
                    </div>
                    <div class="form-group col-md-4">
                      <input type="text" class="form-control" id="cp" placeholder="Codigo Postal">
                    </div>
                    <div class="form-group col-md-4">
                      <input type="text" class="form-control" id="estado" placeholder="Estado">
                    </div>
                    <div class="form-group col-md-4">
                      <input type="text" class="form-control" id="municipio" placeholder="Municipio">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="ciudad" placeholder="Ciudad">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="localidad" placeholder="Colonia / Localidad">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <button class="btn btn-info btn-block" id="agregarDireccion">Añadir Dirección</button>
                  </div>
                  <div class="form-group">
                    <ul class="list-inline" id="direccionesGuardadas">
                      <li>
                        <button id="direccionGuardada-1" class="btn btn-sm editar">Direccion 1</button>
                      </li>
                      <li>
                        <button id="direccionGuardada-2" class="btn btn-sm borrar">Direccion 2</button>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div id="telefonos" class="container-fluid " >
            <form method="post" onsubmit="guardarTelefono();return false;" id="registroTelefonos" class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Teléfonos</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="row">
                    <div class="form-group col-md-3">
                      <input type="text" id="ladaTelefono" class="form-control solo-numero" placeholder="Lada:" maxlength="5" onpaste="soloNumeros()"/>
                    </div>
                    <div class="form-group col-md-4">
                      <input type="text" id="numTelefono" class="form-control solo-numero" placeholder="Número:" maxlength="8" onpaste="soloNumeros()"/>
                    </div>
                    <div class="form-group col-md-5">
                      <select class="form-control" id="tipoTelefono">
                        <option value="casa">Casa</option>
                        <option value="celular">Celular</option>
                        <option value="oficina">Oficina</option>
                        <option value="localizador">Localizador</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <button type="submit" class="btn btn-info btn-block" id="enviarFon">Añadir Telefono</button>
                  </div>
                  <div class="form-group">
                    <ul class="list-inline" id="telefonosGuardados">
                    </ul>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) {
  obtenerSeleccionados();
});

</script>