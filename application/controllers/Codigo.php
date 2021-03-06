<?php
  /**
  * En esta clase se manera todo lo relacionado con lo de los codigos
  * desde Generarlo hasta comprobar que exista. En caso que no exista,
  * se mandara a llamar otras funciones de otras clases para su uso, y
  * realice la tarea destinada que tiene el metodo que las esta llamando
  *
  *
  **/
  class Codigo extends CI_Controller
  {
      //metodo que carga la pagina
      public function index(){
        $this->load->helpers('url');
        $data['url'] = base_url('/codigo/pedir');
        $this->load->view('templates/header');
        $this->load->view('codigo/genera');
        $this->load->view('templates/footer');
      }
      // metodo para generar el codigo
      public function makeCode(){
        $posible = str_split("abcdefghijklmnopqrstuvwxyz0123456789");
        shuffle($posible);
        $codigo = array_slice($posible, 0,6);
        $str = implode('', $codigo);
        print_r(json_encode($str));
        /*$data['numero'] = $str;
        $this->load->view('codigo/genera', $data);*/
      }
      /**
      * funcion para enviar el correo
      *
      *
      * @param: $to el correo de la persona
      * @param: $subject: el Asunto del correo
      * @param: file la plantilla que se enviara al usuario
      **/
      public function sendMail($data = null){
          $correo = $this->input->post('correo');
          $titulo = $this->input->post('titulo');
          $codigo = $this->input->post('codigo');
          $mensaje = $this->input->post('mensaje');
          $estado = $this->input->post('estado');
          // se lee el archivo
          $fileh = realpath(APPPATH.'views/correos/headerCorreo.php');
          $fileb = realpath(APPPATH.'views/correos/bodyCorreo.php');
          $filef = realpath(APPPATH.'views/correos/footerCorreo.php');
          $fpH = fopen( $fileh,'r');
          $fpB = fopen( $fileb,'r');
          $fpF = fopen( $filef,'r');
          $html1 = "";
          $html2 = "";
          $html3 = "";
          while( $line = fgets($fpH) ){
            $html1 .= $line;
          }
          while( $line = fgets($fpB) ){
            $html2 .= $line;
          }
          while( $line = fgets($fpF) ){
            $html3 .= $line;
          }
          fclose($fpH);
          fclose($fpB);
          fclose($fpF);
          $mensajeCompleto = "";
          if($estado == 1){
          	$sustituir = '<span id="codigo">'.$codigo.'</span>';
            	$conCodigo = str_replace('<span id="codigo"></span>',$sustituir, $html2);
            	if($mensaje != ""){
	              $sustituir2 = "<span id='mensaje'><p>".$mensaje."</p></span>";
	              $conCodigo2 = str_replace('<span id="mensaje"><p></p></span>',$sustituir2, $conCodigo);
	              $mensajeCompleto = $html1.$conCodigo2.$html3;
    	        }else{
    	        	$mensajeCompleto = $html1.$conCodigo.$html3;
    	        }
              if ($codigo != ""){
                $mensajeCompleto = str_replace('{{{ruta}}}','/e/'.$codigo, $mensajeCompleto);
              } else {
                $mensajeCompleto = str_replace('{{{ruta}}}',''.$codigo, $mensajeCompleto);
              }
          }else{
          	$borrar = array(
          		'<h1>Este es tu c&oacute;digo de acceso.</h1>',
          		'<div class="codigoContainer" style="background-color: white;color: black;font-weight: bold;padding: 10px 20px;margin-top: 45px;margin-bottom: 30px;font-size: 30px;text-transform: uppercase;width: 200px;height: 45px;display: table;display: table-cell;vertical-align: middle;"><span id="codigo"></span></div>'
          	);
            $sustituir3 = "<span id='mensaje'><p>".$mensaje."</p></span>";
            $conCodigo5 = str_replace('<span id="mensaje"><p></p></span>',$sustituir3,$html2);
            $conCodigo4 = str_replace($borrar,'',$conCodigo5);
            $mensajeCompleto = $html1.$conCodigo4.$html3;
            $mensajeCompleto = str_replace('{{{ruta}}}',''.$codigo, $mensajeCompleto);
          }
          $headers = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-Type:text/html;charset=utf-8" . "\r\n";

          $headers .= 'Bcc: encuestas@newchannel.mx'."\r\n";
          $headers .= 'From: Intermed <encuesta@intermed.online>'."\r\n";

          $mensajeCompleto = str_replace('Á','&Aacute;',$mensajeCompleto);
          $mensajeCompleto = str_replace('É','&Eacute;',$mensajeCompleto);
          $mensajeCompleto = str_replace('Í','&Iacute;',$mensajeCompleto);
          $mensajeCompleto = str_replace('Ó','&Oacute;',$mensajeCompleto);
          $mensajeCompleto = str_replace('Ú','&Uacute;',$mensajeCompleto);
          $mensajeCompleto = str_replace('á','&aacute;',$mensajeCompleto);
          $mensajeCompleto = str_replace('é','&eacute;',$mensajeCompleto);
          $mensajeCompleto = str_replace('í','&iacute;',$mensajeCompleto);
          $mensajeCompleto = str_replace('ó','&oacute;',$mensajeCompleto);
          $mensajeCompleto = str_replace('ú','&uacute;',$mensajeCompleto);

          return mail($correo,$titulo,$mensajeCompleto,$headers);
      }
      /**
      * Se valida la cedula, en ser real se le envia un correo con el codigo, nuevo, y ese codigo quedara registrado
      * en caso de ser falso se le envia un correo diciendole que la cedula es falsa
      *
      * @param $cedula: el numero de cedula
      * @param $email: correo, para el envio de los datos
      */
      public function validateCedula( $correo, $email ){
        // se hace una validacion si cedula es verdadera
        // quiere decir que si es una cedula real
        if( $cedula == true ){
          //se insera ala db el codigo nuevo, se envia hacia que responda la encuesta
        }else{
          // se envia un correo diciendole que su cedula es falsa,
        }
      }
      public function pedir(){
        $data['title'] = "Cedula";
        $this->load->view('templates/header',$data);
        $this->load->view('codigo/pedir');
        $this->load->view('templates/footer2');
      }
      public function dataPostCorreo(){
        $this->load->model('PorValidar_model');
        $correo = $this->input->post('email');
        $data['correito'] = $correo;
        if( $this->PorValidar_model->insertData($correo)){
          $this->load->view('templates/header');
          $this->load->view('codigo/medico',$data);
          $this->load->view('templates/footer2');
        }
        else{
          return false;
        }
      }

      public function dataPost(){
        $this->load->model('PorValidar_model');
        $nombre = $this->input->post('nombre');
        $correo = $this->input->post('email');
        $medico = $this->input->post('medico');
        $cedula = $this->input->post('cedula');
        $justificacion = $this->input->post('justificacion');

        $data['title'] = "intermed";
        $data['nombre'] = $nombre;
        $data['correo'] = $correo;
        $data['medico'] = $medico;
        $data['cedula'] = $cedula;
        $data['justificacion'] = $justificacion;

        if( $this->PorValidar_model->insertData($nombre, $correo, $medico, $cedula, $justificacion)){
          $this->load->view('templates/header', $data);
          $this->load->view('codigo/mensaje',$data);
          $this->load->view('templates/footer2');
        }
        else{
          return false;
        }
      }
      /**
      * La siguiente funcion es para cuando le de click el administrados
      * en el boton de envio de codigo se actualize el status a 1 para que deje de aparecer y ademas
      * borre toda la linea
      *
      *
      **/
      public function actualizaStatus(){
        // se carga el modelo
        $this->load->model('PorValidar_model');
        $correo = $this->input->post('correo');
        $id = $this->input->post('ids');
        $this->PorValidar_model->actualizaStatus($correo, $id);
      }
      public function negado(){
        $this->load->model('PorValidar_model');
        $id = $this->input->post('ids');
        $correo = $this->input->post('correo');
        $this->PorValidar_model->negado($correo,$id);
      }
      public function mensajeStatus(){
        $this->load->model('PorValidar_model');
        $correo -> $this->input->post('correo');
        $this->PorValidar_model->actualizaStatus($correo);
      }
      public function insertMensaje(){
        $this->load->model('PorValidar_model');
        $mensaje = $this->input->post('mensaje');
        $id = $this->input->post('id');
        $this->PorValidar_model->insertMensaje($id,$mensaje);
      }
  }
?>
