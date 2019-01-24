<?php
class acceso extends App{

    public function index(){

        if(isset($_SESSION["usuario"])){
            $this->vista->reenviar("index", "portada");
        }
        if(isset($_POST["usuario"]) and $_POST["usuario"]!="" and isset($_POST["clave"]) and $_POST["clave"]!=""){
            $modelo = new modeloAcceso();
            $usuario = $modelo->getSesion($_POST["usuario"], $_POST["clave"]);
            if(!empty($usuario)){
                $_SESSION["usuario"] = $usuario;
                $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
                $centro_id = $_SESSION["usuario"][0]["CENTRO_ID"];
                if (empty($tipo_centro_id)) {
                    $tipo_centro_id = "SELECT tipo_centro_id FROM centro_atencion WHERE id=".$centro_id." and  estado = 1 order by id asc";
                    $tipo_centro_id = $modelo->executeQuery( $tipo_centro_id )[0]["TIPO_CENTRO_ID"];
                    $_SESSION["usuario"][0]["TIPO_CENTRO_ID"] = $tipo_centro_id;
                  }
                  echo  $tipo_centro_id;
                $this->vista->reenviar("index", "portada");
            }else{
                $this->vista->MensajeAlerta("Usuario no válido.","error");
            }
        }
    }
    public function captcha()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          // Creamos el enlace para solicitar la verificación con la API de Google.
          $params = array();  // Array donde almacenar los parámetros de la petición
          if ($_SERVER['HTTP_HOST']=="localhost") {
            $params['secret'] = '6LdHmIYUAAAAAHVfpV2ip7Yc4Lic-pJut_oYH9lm'; // Clave privada
          }else {
            $params['secret'] = '6LcysIcUAAAAAEKGI89m657mqwqez6coPvn_Mw3w'; // Clave privada
          }
          
          if (!empty($_POST) && isset($_POST['g-recaptcha-response'])) {
          $params['response'] = urlencode($_POST['g-recaptcha-response']);
          }
          $params['remoteip'] = $_SERVER['REMOTE_ADDR'];

          // Generar una cadena de consulta codificada estilo URL
          $params_string = http_build_query($params);
          // Creamos la URL para la petición
          $requestURL = 'https://www.google.com/recaptcha/api/siteverify?' . $params_string;

          // Inicia sesión cURL
          $curl = curl_init();
          // Establece las opciones para la transferencia cURL
          curl_setopt_array($curl, array(
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => $requestURL,
          ));

          // Enviamos la solicitud y obtenemos la respuesta en formato json
          $response = curl_exec($curl);
          // Cerramos la solicitud para liberar recursos
          curl_close($curl);
          // Devuelve la respuesta en formato JSON
          echo $response;
          }
    }
    public function cerrar(){
        unset($_SESSION);
        session_destroy();
        $this->vista->reenviar("index");
    }



}
