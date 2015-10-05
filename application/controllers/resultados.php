<?php
  class Resultados extends CI_Controller {


    public function __construct(){
      parent::__construct();
      $this->load->model('EncuestasM_Model');
      $this->load->model('Categorias_Model');
      $this->load->model('PreguntasM_Model');
      $this->load->model('RespuestasM_Model');
      header('Cache-Control: no cache');
    }

    public function index(){
      if(!file_exists('application/views/resultados/index.php')){
        show_404();
      }

      $resultado = array();

      $categorias = $this->Categorias_Model->get_categorias();

      $total = 0;
      foreach ($categorias as $cat) {
          $categoriasArray = array();
          $categoriasArray['name'] = $cat['categoria'];
          $preguntas = $this->PreguntasM_Model->get_preguntamByCategoria($cat['id']);
          $preguntasArray = array();
          foreach ($preguntas as $preg) {
              $pregArray = array();
              $pregArray['pregunta'] = $preg['pregunta'];
              $pregArray['respuestas'] = array();
              $respuestas = $this->RespuestasM_Model->get_respuestamByPregunta($preg['id']);

              foreach ($respuestas as $resp) {
                $respFinal = array();
                if (stripos($resp['respuesta'],':|comp:') > -1){
                  //SPLIT con :|comp:
                  $resp['respuesta'] = explode(':|comp:', $resp['respuesta'] );
                  $respFinal['respuesta'] = $resp['respuesta'][0];
                  $respFinal['total'] = $resp['Total'];
                  $respFinal['complemento'] = $resp['respuesta'][1];
                } elseif (stripos($resp['respuesta'],'|') > -1){
                  //SPLIT con |
                  echo $preg['opciones'] . '<br/>';
                  $resp['respuesta'] = explode('|', $resp['respuesta'] );
                  foreach ($resp['respuesta'] as $total) {

                  }
                  $respFinal['respuesta'] = '';
                  $respFinal['total'] = '';
                } else {
                  $respFinal['respuesta'] = $resp['respuesta'];
                  $respFinal['total'] = $resp['Total'];
                }
                $pregArray['respuestas'][] = $respFinal;
              }
              $preguntasArray[] = $pregArray;
          }
          $categoriasArray['preguntas'] = $preguntasArray;
          $resultado[] = $categoriasArray;
      }

      $data = array('resultado'=> $resultado);

      $this->load->view('templates/header', $data);
      $this->load->view('resultados/index', $data);
      $this->load->view('templates/footer', $data);

    }
  }
?>