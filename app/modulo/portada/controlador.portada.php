<?php
date_default_timezone_set('America/Lima');

class portada extends App{
    public function index(){
      if(!isset($_SESSION["usuario"])){
          $this->vista->reenviar("index", "acceso");
      }
      $this->vista->setTitle("Inicio");
    }
    public function cerrar(){
      unset($_SESSION);
      session_destroy();
      $this->vista->reenviar("index");
    }
    public function list_modulos()
    {
      $modelo = new modeloPortada();
      //$nivel = $_SESSION["usuario"][0]["kpi_roles_id"];
      //$bd = isset($_SESSION["usuario"][0]["database_name"]) ? $_SESSION["usuario"][0]["database_name"] : 'portal-kpi' ;
      //$usuario = "SELECT kpi_roles_id FROM kpi_usuarios WHERE id=".$_SESSION['usuario'][0]['id']." and estado = 1 limit 1";
      //$usuario = $modelo->executeQuery( $usuario );
      //$_SESSION["nivelusuario"] = $usuario[0]['kpi_roles_id'];
      $modulos = "SELECT * FROM modulos WHERE estado = 1";
      $modulos = $modelo->executeQuery( $modulos );
      $tree = $this->buildTree($modulos);
      $treeHtml = $this->buildTreeHtml($tree);
      print_r($treeHtml);
    }
    public function buildTree($elements, $parentId = 0) {
      $branch = array();
      foreach ($elements as $element) {
          if ($element['PARENT_ID'] == $parentId) {
              $children = $this->buildTree($elements, $element['ID']);
              if ($children) {
                  $element['children'] = $children;
              }
              $branch[] = $element;
          }
          
      }
      return $branch;
  }
  public function buildTreeHtml($elements,$opt="")
  {
    $branch = array();
    $li = '';
    foreach ($elements as $element)
    {
     // if (in_array($_SESSION["nivelusuario"],(explode(',',$element["niveles"])))) {
        $li = $li  . (isset($element['children']) ? ('
                      <li class="menu-item-has-children dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true">
                            <i class="menu-icon ' . $element["ICON"] . '"></i>' . $element['NOMBRE'] .'
                          </a>
                          <ul class="sub-menu children dropdown-menu">
                          '. $this->buildTreeHtml($element['children'],'childs').'
                          </ul>
                          </li>
                        ') :
                          ('<li data-url="'.$element['URL_TEMPLATE'].'">
                            <i class="'.$element["ICON"].'"></i>
                            <a style="font-size:1em;" href="#'.$element['URL_TEMPLATE'].'" class=""> '.$element['NOMBRE'].'</a>
                          </li>') ) ;
     // }


    }
    return $li;
  }
    public function enviar(){
        $this->vista->reenviar("index", "portal");
    }

    public function cargar_datos(){

      if( $_POST['tabla'] && $_POST['where'] ){

        $_POST['where']["estado"] = 1;
        $modelo = new modeloPortada();
        $res = $modelo->selectData( $_POST['tabla'], $_POST['where'] );
        if ($res) {
          echo json_encode(array( "atributos"=>$res )) ;
        }else{
          return false;
        }
      }else{
        return false;
      }

    }
    public function insertar_datos(){

      if( $_POST['tabla'] && $_POST['valores'] ){
        $modelo = new modeloPortada();
        //$modelo->executeQuery("delete from CarActividades");
        $_POST['valores']['Residente_Id'] = $_SESSION["usuario"][0]["ID"];
        $_POST['valores']['Tipo_Centro_Id'] = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
        $_POST['valores']['Fecha_Creacion'] = "18-DEC-27";
        $_POST['valores']['Estado'] = 1;
        //$_POST['valores']['Fecha_Edicion'] = date("Y-m-d H:i:s");
        $_POST['valores']['Usuario_Crea'] =$_SESSION["usuario"][0]["ID"];
        $_POST['valores']['Usuario_Edita'] =$_SESSION["usuario"][0]["ID"];
        //aqui tu ejecutas la consulta
        $res = $modelo->insertData( $_POST['tabla'],$_POST["valores"]);
        if ($res) {
          echo json_encode(array("resultado"=>true )) ;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }
    public function ejecutar_consulta(){
      if( $_POST['like']){
        $modelo = new modeloPortada();
        $sql = "SELECT * FROM Residente WHERE (Nombre LIKE '%".$_POST['like']."%' OR Apellido LIKE '%".$_POST['like']."%' OR Documento LIKE '%".$_POST['like']."%') AND ESTADO=1";
        $res = $modelo->executeQuery( $sql );
        if ($res) {
          echo json_encode(array( "data"=>$res )) ;
        }else{
          return false;
        }
    
       }
    }
    public function cargar_datos_residente(){
      if( $_POST['tabla'] && $_POST['residente_id']){
        $modelo = new modeloPortada();
        $sql = "SELECT * FROM ".strtoupper($_POST["tabla"])." WHERE RESIDENTE_ID = ".$_POST["residente_id"]." AND ESTADO=1";
        $res = $modelo->executeQuery( $sql );
        if ($res) {
          echo json_encode(array( "atributos"=>$res )) ;
        }else{
          return false;
        }
    
       }
    }
    

}
