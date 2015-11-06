<!-- Formulario para agregar contactos al directorio -->
<section id="nombreDatos">
  <div class="container">
    <div class="row"><!-- inicio row -->
      <form method="post" onsubmit="return false;" id="registroMedico">
        <div class="col-md-8" id="formGuardarMedico">
          <div class="row">
            <!-- Datos nombre -->
            <div class="col-md-12">
              <h3>Datos de usuario</h3>
              <div class="row">
                <input type="hidden" id="medico_id" value="">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre/s:"/>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="text" class="form-control" id="apellidoP" placeholder="Apellido paterno:"/>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="text" class="form-control" id="apellidoM" placeholder="Apellido materno:"/>
                  </div>
                </div>
              </div>
            </div>
            <!-- FIN DATOS NOMBRE: -->
            <!-- CORREO -->
            <div class="col-md-12">
              <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" class="form-control" id="email" placeholder="E-mail:"/>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="correo">Especialidad:</label>
                <select class="form-control" id="especialidad" >
                  <option value=""></option>
                  <?php
                    foreach ($especialidades as $especialidad) {
                      echo '<option value="' . $especialidad['id'] . '">'. $especialidad['especialidad'] .'</option>';
                    }
                  ?>
                </select>
              </div>
            </div>
            <!-- FIN CORREO -->
          </div>
        </div>
        <!-- BOTON PARA AGREGAR -->
        <div class="col-md-4" id="buttonGuardarMedico">
          <div class="form-group">
            <div class="col-md-12"></div>
            <div class="col-md-12">
              <button class="form-control btn btn-danger" id="agregarDatos" onclick="guardarMedico();">
                <span class="glyphicon glyphicon-star-empty"></span>
              </button>
            </div>
            <div class="col-md-12"></div>
          </div>
        </div>
      </form>
    </div><!-- fin row -->
  </div>
</section>
<hr>
<!-- segunda seccion -->
<section id="calles">
  <div class="container">
    <div class="row"><!-- Inicio row -->
      <form>
        <div class="col-md-8">
          <div class="col-md-6">
            <div class="form-group">
              <label for="direccion">Direccion/es:</label>
              <input type="text" id="direccion" class="form-control" placeholder="Calle/s:"/>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <input type="text" id="estado" class="form-control" placeholder="Estado:"/>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <input type="text" id="municipio" class="form-control" placeholder="Municipio:"/>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" class="form-control" id="ciudad" placeholder="Ciudad:" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" id="localidad" class="form-control" placeholder="localidad" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <button type="button" id="agregaCalles" class="form-control">
            <span class="glyphicon glyphicon-upload"></span>
          </button>
        </div>
      </form>
    </div><!-- FIn row -->
  </div>
</section>
<!-- Fin segunda seccion -->
<!--- INICIO TERCER SECCION -->
<section id="telefonos">
  <div class="container">
    <div class="row">
      <form>
        <div class="col-md-8">
          <div class="col-md-12">
            <div class="col-md-4">
              <div class="form-group">
                <label for="lada">Lada:</label>
                <input type="number" id="lada" class="form-control" placeholder="Lada:"/>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="number" id="numTelefono" class="form-control" placeholder="numero telefono" />
              </div>
            </div>
            <div class="col-md-4">
              <select class="form-control">
                <option value="0"></option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <button type="button" id="enviarFon" class="form-control">
            <span class="glyphicon glyphicon-leaf"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
<!-- FIN TERCER SECCION -->
<script src="<?echo base_url(); ?>js/utils-capturista.js"></script>