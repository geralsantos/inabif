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
      $usuario = "SELECT kpi_roles_id FROM kpi_usuarios WHERE id=".$_SESSION['usuario'][0]['id']." and estado = 1 limit 1";
      $usuario = $modelo->executeQuery( $usuario );
      $_SESSION["nivelusuario"] = $usuario[0]['kpi_roles_id'];
      $modulos = "SELECT * FROM kpi_modulos WHERE estado = 1";
      $modulos = $modelo->executeQuery( $modulos );
      $tree = $this->buildTree($modulos);
      $treeHtml = $this->buildTreeHtml($tree);
      print_r($treeHtml);
    }
    public function buildTree($elements, $parentId = 0) {
      $branch = array();
      foreach ($elements as $element) {
          if ($element['parent_id'] == $parentId) {
              $children = $this->buildTree($elements, $element['id']);
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
      if (in_array($_SESSION["nivelusuario"],(explode(',',$element["niveles"])))) {
        $li = $li  . (isset($element['children']) ? ('
                      <li class="menu-item-has-children dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true">
                            <i class="menu-icon ' . $element["icon"] . '"></i>' . $element['nombre'] .'
                          </a>
                          <ul class="sub-menu children dropdown-menu">
                          '. $this->buildTreeHtml($element['children'],'childs').'
                          </ul>
                          </li>
                        ') :
                          ( in_array($_SESSION["nivelusuario"],(explode(',',$element["niveles"]))) ? ('<li data-url="'.$element['url'].'">
                            <i class="'.$element["icon"].'"></i>
                            <a style="font-size:1em;" href="#'.$element['url'].'" class="menu_direct"> '.$element['nombre'].'</a>
                          </li>') : '' ) ) ;
      }


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
        $_POST['valores']['id_residente'] = $_SESSION["usuario"][0]["id"];
        $_POST['valores']['Tipo_Centro_Id'] = $_SESSION["usuario"][0]["tipo_centro_id"];
        $_POST['valores']['Fecha_Creacion'] = date("Y-m-d H:i:s");
        $_POST['valores']['Fecha_Edicion'] = date("Y-m-d H:i:s");
        $_POST['valores']['Usuario_Crea'] =$_SESSION["usuario"][0]["id"];
        $_POST['valores']['Usuario_Edita'] =$_SESSION["usuario"][0]["id"];
        //aqui tu ejecutas la consulta
       // $res = $modelo->selectRowDataAll( $_POST['tabla'], $_POST['campos'], $_POST['where'], $_POST['groupby'] );
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
