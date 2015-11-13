<?php
  class Capcapturista_model extends CI_Model
  {
    public function __construct(){
        $this->db_capturista = $this->load->database('capturista', TRUE);
        $this->db_encuesta = $this->load->database('encuesta', TRUE);
    }
    public function insertDatosCapturista($id,$nombre,$apellido,$correo){
      $data = array(
        'id_master' => $id,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'correo' => $correo
      );
      if( $this->db_capturista->insert('capturista', $data) ){
        return true;
      }else{
        return false;
      }
    }
    public function getDatosNombres($id){
      $this->db_capturista->where('id_master',$id);
      $query = $this->db_capturista->get('capturista');
      return $query;
    }
    public function cargandoInfo(){
      $query = $this->db_capturista->get('capturista');
      return $query;
    }
    public function usuarioInfo($id){
      $this->db_encuesta->where('id',$id);
      $this->db_encuesta->select('usuario');
      $query = $this->db_encuesta->get('master');
      $usuario = "";
      foreach( $query->result() as $row ){
        $usuario = $row->usuario;
      }
      return $usuario;
    }
    public function actualizainfoCapturista($id_usaurio, $dataMaster, $dataCapturista){
      $this->db_encuesta->where('id',$id_usuario);
      $query = $this->db_encuesta->update('master',$dataMaster);
      
    }
    public function getCapturista($id_usuario){

    }
  }
?>
