<?php
  class Resultados extends CI_Controller {


    public function __construct(){
      parent::__construct();
      $this->load->model('Encuestam_model');
      $this->load->model('Categorias_model');
      $this->load->model('Preguntasm_model');
      $this->load->model('Respuestasm_model');
      header('Cache-Control: no cache');
    }

    public function index(){
      if(!file_exists('application/views/resultados/index.php')){
        show_404();
      }

      $resultado = array();

      $categorias = $this->Categorias_model->get_categorias();

      $total = 0;
      foreach ($categorias as $cat) {
          $categoriasArray = array();
          $categoriasArray['name'] = $cat['categoria'];
          $preguntas = $this->Preguntasm_model->get_preguntamByCategoria($cat['id']);
          $preguntasArray = array();
          foreach ($preguntas as $preg) {
              $pregArray = array();
              $pregArray['pregunta'] = $preg['pregunta'];
              $pregArray['respuestas'] = array();
              $respuestas = $this->Respuestasm_model->get_respuestamByPregunta($preg['id']);
              $opciones = array();
              $resultadoTextEnum = array();
              $resultadoRadioComplemento = array();
              if ($preg['tipo'] == 'text|enum'){
                $opciones = explode('|', $preg['opciones'] );
                $num = 0;
                foreach ($opciones as $key) {
                  $value = $key;
                  if (substr($key,-1) == ':'){
                    $opciones[$num] = substr($key,0,strlen($key)-1);
                    $num++;
                    $value = $opciones[$num];
                  }
                  if (strlen($value) > 0){
                    $resultadoTextEnum[$value] = 0;
                  }
                }
              } else if ($preg['tipo'] == 'checkbox' || $preg['tipo'] == 'checkbox'){
                $opciones = explode('|', $preg['opciones'] );
                foreach ($opciones as $key) {
                  $resultadoTextEnum[$key] = array();
                  $resultadoRadioComplemento[$key] = 0;
                }
              }

              foreach ($respuestas as $resp) {
                $respFinal = array();

                if ($preg['tipo'] == "radio"){

                  $resp['respuesta'] = explode('|comp:', $resp['respuesta']);

                  if (count($resp['respuesta']) == 1){
                    $resultadoRadioComplemento[$resp['respuesta'][0]] = $resp['total'];
                  } else {
                    $resp['respuesta'][1] = strtolower($resp['respuesta'][1]);
                    if (array_key_exists($resp['respuesta'][0],$resultadoRadioComplemento)){
                      $resultadoRadioComplemento[$resp['respuesta'][0]]['total'] =  $resultadoRadioComplemento[$resp['respuesta'][0]]['total'] + $resp['total'];
                      if (array_key_exists($resp['respuesta'][1], $resultadoRadioComplemento[$resp['respuesta'][0]]['comp'])){
                        $cant =   $resultadoRadioComplemento[$resp['respuesta'][0]]['comp'][$resp['respuesta'][1]];
                        $resultadoRadioComplemento[$resp['respuesta'][0]]['comp'][$resp['respuesta'][1]] = $cant + $resp['total'];
                      } else {
                        $resultadoRadioComplemento[$resp['respuesta'][0]]['comp'][$resp['respuesta'][1]] = $resp['total'];
                      }
                    } else {
                      $resultadoRadioComplemento[$resp['respuesta'][0]]['total'] = $resp['total'];
                      $resultadoRadioComplemento[$resp['respuesta'][0]]['comp'][$resp['respuesta'][1]] = $resp['total'];
                    }
                  }
                  $respFinal['respuesta'] = $resultadoRadioComplemento;
                  $pregArray['respuestas'][0] = $respFinal;

                } elseif ($preg['tipo'] == "text|enum"){
                  //SPLIT con |
                  $resp['respuesta'] = explode('|', $resp['respuesta'] );
                  for ($i = 0; $i < count($resp['respuesta']); $i++) {
                    if (array_key_exists($opciones[$i],$resultadoTextEnum)){
                      $resultadoTextEnum[$opciones[$i]] = $resultadoTextEnum[$opciones[$i]] + (count($opciones) + 1 - $resp['respuesta'][$i]);
                    } else {
                      $resultadoTextEnum[$opciones[$i]] = (count($opciones) + 1 - $resp['respuesta'][$i]);
                    }
                  }
                  arsort($resultadoTextEnum);
                  $respFinal['respuesta'] = $resultadoTextEnum;
                  $respFinal['total'] = '';
                  $pregArray['respuestas'][0] = $respFinal;
                } elseif ($preg['tipo'] == "checkbox"){
                  $resp['respuesta'] = explode('|', $resp['respuesta'] );
                  for ($i = 0; $i < count($resp['respuesta']); $i++) {
                    if (stripos($resp['respuesta'][$i],'comp:') === false){
                      $respuestaf = $resp['respuesta'][$i];
                      $complemento = '';
                      if (substr($resp['respuesta'][$i],-1) == ":" && array_key_exists($i+1,$resp['respuesta']) && stripos($resp['respuesta'][$i+1],'comp:') === 0){
                          $complemento = explode('comp:',$resp['respuesta'][$i+1])[1];
                      }
                      if (!empty($respuestaf) && $respuestaf != ""){
                        if (array_key_exists($respuestaf,$resultadoTextEnum)){
                          if (!(array_key_exists('total',$resultadoTextEnum[$respuestaf]))){
                            $resultadoTextEnum[$respuestaf]['total'] = 0;
                          }
                          $cant = intval($resultadoTextEnum[$respuestaf]['total']);
                          $resultadoTextEnum[$respuestaf]['total'] = $cant + $resp['total'];
                        } else {
                          $resultadoTextEnum[$respuestaf]['total'] =  $resp['total'];
                        }
                        if (!empty($complemento)){
                          if (!array_key_exists('comp',$resultadoTextEnum[$respuestaf])){
                            $resultadoTextEnum[$respuestaf]['comp'] = array();
                          }
                          if (array_key_exists($complemento,$resultadoTextEnum[$respuestaf]['comp'])){
                            $cant = intval($resultadoTextEnum[$respuestaf]['comp'][$complemento]);
                            $resultadoTextEnum[$respuestaf]['comp'][$complemento] = $cant +  $resp['total'];
                          } else {
                            $resultadoTextEnum[$respuestaf]['comp'][$complemento] =  $resp['total'];
                          }
                        }
                      }
                    }
                  }
                  arsort($resultadoTextEnum);
                  $respFinal['respuesta'] = $resultadoTextEnum;
                  $respFinal['total'] = '';
                  $pregArray['respuestas'][0] = $respFinal;
                } else {
                  $respFinal['respuesta'] = $resp['respuesta'];
                  $respFinal['total'] = $resp['total'];
                  $pregArray['respuestas'][] = $respFinal;
                }
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