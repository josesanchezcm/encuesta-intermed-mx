<?php
  /**
  * En esta clase se manera todo lo relacionado con lo de los codigos
  * desde Generarlo hasta comprobar que exista. En caso que no exista,
  * se mandara a llamar otras funciones de otras clases para su uso, y
  * realice la tarea destinada que tiene el metodo que las esta llamando
  *
  *
  **/
  class Capturista extends CI_Controller
  {
      public function __construct(){
        parent::__construct();
        $this->load->helpers('url');
        $this->load->model('Capespecialidades_model');
        $this->load->model('Capmedicos_model');
        $this->load->model('Capdirecciones_model');
        $this->load->model('Captelefonos_model');
      }
      /*
      public function index(){
        $especialides = $this->Capespecialidades_model->get_especialidades();
        foreach ($especialides as $value) {
          # code...
          echo $value['id'] . ' - ' . $value['especialidad'] . '<br/>';
        }
      }
      */
      public function guardarMedico(){
        //$usuario = $this->input->post('user');
        $data = array(
          'nombre'=>$this->input->post('nombre'),
          'apellidop'=>$this->input->post('apellidoP'),
          'apellidom'=>$this->input->post('apellidoM'),
          'correo'=>$this->input->post('email')
        );
        //'especialidad_id'=>$this->input->post('especialidad'),

        $especialidad = $this->input->post('especialidad');

        if ($especialidad != ''){
          //Buscar la especialidad, traer id
          $id = $this->Capespecialidades_model->get_especialidadId($especialidad);
          //Si no id, insertarlo y traer el id
          if ($id <= 0){
            $id = $this->Capespecialidades_model->create_especialidad($especialidad);
          }
          $data['especialidad_id'] = $id;
        }

        $id = $this->Capmedicos_model->create_medico($data);
        echo json_encode(array('success'=>true,'medico_id'=>$id));
      }

      public function guardarTelefono(){
        //$usuario = $this->input->post('user');
        $data = array(
          'medico_id'=>$this->input->post('medico_id'),
          'claveRegion'=>$this->input->post('claveRegion'),
          'numero'=>$this->input->post('numero'),
          'tipo'=>$this->input->post('tipo')
        );

        $result = $this->Captelefonos_model->create_telefono($data);
        echo json_encode(array('success'=>$result));
      }


      /**
      * Recibe los valores por post para su envio al modelo y los inserte en su
      * correspondiente tabla en la base de datos
      * @param NO PARAMS
      **/
      public function insertDireccion(){
        $consultorio = $this->input->post('consultorio');
        $calle = $this->input->post('calle');
        $estado = $this->input->post('estado');
        $municipio = $this->input->post('municipio');
        $ciudad = $this->input->post('ciudad');
        $localidad = $this->input->post('localidad');
        $id_medico = $this->input->post('id_medico');
        $cp = $this->input->post('cp');
        $numero = $this->input->post('numero');
        $data = array(
          'nombre'=>$consultorio,
          'estado'=>$estado,
          'municipio'=>$municipio,
          'ciudad'=>$ciudad,
          'localidad'=>$localidad,
          'cp'=>$cp,
          'calle'=>$calle,
          'numero'=>$numero,
          'medico_id'=>$id_medico
        );
        return $this->Capdirecciones_model->insertDireccion($data);
      }
      /**
      * Funcion para poder editar todos los campos de la vista
      * donde aparecen los datos generales del medico, al presionar
      * el boton de guardar se habilitara el boton de editar y se podran
      * editar todos los campos.
      **/
      public function editDatos(){
        //variables atrapadas por post
        $nombre = $this->input->post('nombre');
        $apellidoP = $this->input->post('apellidoP');
        $apellidoM = $this->input->post('apellidoM');
        $especialidad = $this->input->post('especialidad');
        $email = $this->input->post('email');
        $medico_id = $this->input->post('medico_id');
        $arreglo = array(
          'nombre' => $nombre,
          'apellidoP' => $apellidoP,
          'apellidoM' => $apellidoM,
          'especialidad_id' => $especialidad,
          'correo' => $email
        );
        //llamado a la funcion del modelo para hacer la actualizacion
         $this->Capmedicos_model->updateMedico($arreglo, $medico_id);
         return true;
      }
      /**
      * function para retornar todos los datos del usuario recien insertado
      */
      public function editarDirecciones(){
        $medico_id = $this->input->post('medico_id');
        //llamada a la funcion del modelo
        $arreglo = $this->Capdirecciones_model->editarDirecciones($medico_id);
        echo json_encode($arreglo);
      }
  }
?>
