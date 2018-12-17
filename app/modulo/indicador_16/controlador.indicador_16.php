<?php
class indicador_16 extends App{

    public function index(){

    }

    public function enviar(){
        $this->vista->reenviar("index", "comprobantes");
    }

    public function guardar(){

        if( isset( $_POST["sugerencias_respondidas"], $_POST["sugerencias_reportadas"], $_POST["anio"], $_POST["mes"] )
        && $_POST["sugerencias_respondidas"]!=""  && $_POST["sugerencias_reportadas"] && $_POST["anio"]!=""  && $_POST["mes"]  ){

            $modelo = new modeloIndicador_16();
            $params = array( "sugerencias_respondidas"=>$_POST["sugerencias_respondidas"], "sugerencias_reportadas"=>$_POST["sugerencias_reportadas"],
            "anio"=>$_POST["anio"], "mes"=>$_POST["mes"], "kpi_usuario_registro"=>"admin", "kpi_usuario_modificacion"=>"admin");
            $res = $modelo->insertData("kpi_indicador_ref16", $params);
            if( $res ){
                //mensaje de exito
                $this->vista->reenviar("index");
            }else{
                //mensaje de error
            }

        }else{
            // mensaje de error
        }

    }

    public function cargar_datos(){

        if( $_POST['tabla'] && $_POST['where'] ){
          $modelo = new portada();
          $res = $modelo->selectData( $_POST['tabla'], $_POST['where'] );
          if ($res) {
            echo json_encode(array("resultado"=>true )) ;
          }else{
            return false;
          }
        }else{
          return false;
        }

      }

      public function insertar_datos(){

        if( $_POST['tabla'] && $_POST['campos'] ){
          $modelo = new portada();
          $res = $modelo->insertData( $_POST['tabla'], $_POST['campos'] );
          if ($res) {
            echo json_encode(array("resultado"=>true )) ;
          }else{
            return false;
          }
        }else{
          return false;
        }

      }
}
