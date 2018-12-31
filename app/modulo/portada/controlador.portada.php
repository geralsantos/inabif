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
      $centro_id = $_SESSION["usuario"][0]["ID_CENTRO"];
      //$bd = isset($_SESSION["usuario"][0]["database_name"]) ? $_SESSION["usuario"][0]["database_name"] : 'portal-kpi' ;
      //$usuario = "SELECT kpi_roles_id FROM kpi_usuarios WHERE id=".$_SESSION['usuario'][0]['id']." and estado = 1 limit 1";
      //$usuario = $modelo->executeQuery( $usuario );
      //$_SESSION["nivelusuario"] = $usuario[0]['kpi_roles_id'];
      $modulos = "SELECT * FROM modulos WHERE centro_id=".$centro_id." and  estado = 1 order by id asc";
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
      /*<a href="#node11" class="list-group-item level-0" data-toggle="collapse"
    aria-expanded="true" id="gardening">Gardening 
        <i class="fa fa-caret-down"></i>
    </a>
    <div class="collapse" id="node11">
        <a href="#node13" class="list-group-item level-1" data-toggle="collapse" id="lawn-chemicals">Lawn Chemicals 
        <i class="fa fa-caret-down"></i>
        </a>
        <div class="collapse" id="node13">
            <a href="gardening/lawn-chemicals/moss-control/" class="list-group-item level-2" id="moss-control">Moss Control</a>
        </div>
    </div>*/ 
    $li = $li  . (isset($element['children']) ? ('
    <a href="#node'.$element['ID'].'" class="list-group-item level-0" data-toggle="collapse" aria-expanded="true" id="gardening">'.$element['NOMBRE'].' 
        <i class="fa fa-caret-down"></i>
    </a>
    <div class="collapse" id="node'.$element['ID'].'">
    '. $this->buildTreeHtml($element['children'],'childs').'
    </div>
      ') :
        ('
        <a href="#'.$element['URL_TEMPLATE'].'" class="list-group-item level-2" id="moss-control">'.$element['NOMBRE'].'</a>') ) ;
     // if (in_array($_SESSION["nivelusuario"],(explode(',',$element["niveles"])))) {
       /* $li = $li  . (isset($element['children']) ? ('
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
                          </li>') ) ;*/
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
        $lastid = false;
        if (isset($_POST['lastid'])) {
          if ($_POST['lastid']) {
            $sql = "SELECT seq_".$_POST['tabla'].".NEXTVAL FROM DUAL";
            $lastid = $modelo->executeQuery( $sql );
          }
        }
        /*if (!$lastid) {
          $_POST['valores']['Residente_Id'] = $_SESSION["usuario"][0]["ID"];
        }*/
        if ($_POST['tabla']!="usuarios") {
          $_POST['valores']['Tipo_Centro_Id'] = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
        }
        $_POST['valores']['Fecha_Creacion'] = "18-DEC-27";
        $_POST['valores']['Estado'] = 1;
        //$_POST['valores']['Fecha_Edicion'] = date("Y-m-d H:i:s");
        $_POST['valores']['Usuario_Crea'] =$_SESSION["usuario"][0]["ID"];
        $_POST['valores']['Usuario_Edita'] =$_SESSION["usuario"][0]["ID"];
        //aqui tu ejecutas la consulta
        
        $res = $modelo->insertData( $_POST['tabla'],$_POST["valores"],$lastid[0]["NEXTVAL"]);
        if ($res) {
          if ($lastid) {
            echo json_encode(array("resultado"=>true,"lastid"=>$lastid[0]["NEXTVAL"] )) ;
          }else{
            echo json_encode(array("resultado"=>true )) ;
          }
        }else{
          return false;
        }
        
      }else{
        return false;
      }
    }
    public function update_datos(){

      if( $_POST['tabla'] && $_POST['valores'] ){
        $modelo = new modeloPortada();
        
        $_POST['valores']['Estado'] = 1;
        $_POST['valores']['Usuario_Crea'] =$_SESSION["usuario"][0]["ID"];
        $_POST['valores']['Usuario_Edita'] =$_SESSION["usuario"][0]["ID"];
        
        $res = $modelo->updateData( $_POST['tabla'],$_POST["valores"],$_POST["where"]);
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
        $sql = "SELECT * FROM (SELECT * FROM Residente WHERE (Nombre LIKE '%".$_POST['like']."%' OR APELLIDO_M LIKE '%".$_POST['like']."%' OR APELLIDO_P LIKE '%".$_POST['like']."%' OR Documento LIKE '%".$_POST['like']."%') AND ESTADO=1 ORDER BY Id desc) WHERE ROWNUM<=10";
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
        $sql = "SELECT * FROM (SELECT * FROM ".strtoupper($_POST["tabla"])." WHERE RESIDENTE_ID = ".$_POST["residente_id"]." AND ESTADO=1 order by Id desc) WHERE ROWNUM=1";
        $res = $modelo->executeQuery( $sql );
        if ($res) {
          echo json_encode(array( "atributos"=>$res )) ;
        }else{
          return false;
        }
    
       }
    }
    public function buscar(){
      if( $_POST['tabla']){
        $modelo = new modeloPortada();
        $codigo = isset($_POST['codigo']) ? " CODIGO='".$_POST['codigo']."' AND " : "";
        $sql = "SELECT * FROM ".$_POST['tabla']." WHERE ".$codigo." ESTADO=1";
        $res = $modelo->executeQuery( $sql );
        if ($res) {
          echo json_encode(array( "data"=>$res )) ;
        }else{
          return false;
        }
    
       }
    }
    public function buscar_departamentos(){
      if( $_POST['tabla']){
        $modelo = new modeloPortada();
        $sql = "select coddept,nomdept from ".$_POST['tabla']." where estado = 1 group by coddept,nomdept";
        $res = $modelo->executeQuery( $sql );
        if ($res) {
          echo json_encode(array( "data"=>$res )) ;
        }else{
          return false;
        }
    
       }
    }
    public function buscar_provincia(){
      if( $_POST['tabla']){
        $modelo = new modeloPortada();
        $sql = "select codprov ,nomprov from ".$_POST['tabla']." where estado = 1 and SUBSTR(codprov,0,2)='".$_POST["cod"]."' group by codprov ,nomprov";
        $res = $modelo->executeQuery( $sql );
        if ($res) {
          echo json_encode(array( "data"=>$res )) ;
        }else{
          return false;
        }
    
       }
    }
    public function buscar_distritos(){
      if( $_POST['tabla']){
        $modelo = new modeloPortada();
        $sql = "select coddist, nomdist  from ".$_POST['tabla']." where estado = 1 and SUBSTR(coddist,0,4)= '".$_POST["cod"]."' group by coddist, nomdist";
        $res = $modelo->executeQuery( $sql );
        if ($res) {
          echo json_encode(array( "data"=>$res )) ;
        }else{
          return false;
        }
    
       }
    }
    public function traer_datos_usuario(){
        $modelo = new modeloPortada();
        $sql = "select *  from usuarios where estado = 1 and id =".$_SESSION["usuario"][0]["ID"];
        $res = $modelo->executeQuery( $sql );
        if ($res) {
          echo json_encode(array("data"=>$res)) ;
        }else{
          return false;
        }
    }
    public function buscar_centros(){
        $modelo = new modeloPortada();
        if ($_SESSION["usuario"][0]["NIVEL"]=="5") { //responsable de la información
          $sql = "select ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo,cad.fecha_cierre   from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id) 
          where ca.id=".$_SESSION["usuario"][0]["CENTRO_ID"]." and ca.estado = 1";
        }else if($_SESSION["usuario"][0]["NIVEL"]=="2") //supervisor
        {
          $sql = "select ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo,cad.fecha_cierre  from centro_atencion ca 
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id) 
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id) 
          where tc.id=".$_SESSION["usuario"][0]["TIPO_CENTRO_ID"]." and ca.estado = 1";
        }else if($_SESSION["usuario"][0]["NIVEL"]=="3") //USER_SEDE_GESTIÓN 
        {
          $sql = "select ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo,cad.fecha_cierre  from centro_atencion ca 
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id) 
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id) 
          where tc.id=".$_SESSION["usuario"][0]["TIPO_CENTRO_ID"]." and ca.estado = 1";
        }else if($_SESSION["usuario"][0]["NIVEL"]=="1") //ADMIN_CENTRAL
        {
          $sql = "select ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo,cad.fecha_cierre  from centro_atencion ca 
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id) 
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id) 
          where ca.estado = 1";
        }
        $res = $modelo->executeQuery($sql );
        if ($res) 
        {
          echo json_encode(array("data"=>$res) ) ;
        }else{
          return false;
        }
    }
    public function completar_matriz(){
      $modelo = new modeloPortada();
      $sql = "";
      $res = $modelo->insertData("centro_atencion_detalle",array("centro_id"=>$_POST["id_centro"],"estado_completo"=>1,"usuario_crea"=>$_SESSION["usuario"][0]["ID"],"usuario_edita"=>$_SESSION["usuario"][0]["ID"] ));

      if ($res) 
      {
        echo json_encode(array("resultado"=>true) ) ;
      }else{
        return false;
      }
  }
  public function generar_matriz(){
    $modelo = new modeloPortada();
    $sql = "";
    $res = $modelo->insertData("centro_atencion_detalle",array("centro_id"=>$_POST["id_centro"],"estado_completo"=>1,"fecha_matriz"=>date("y-M-t"),"usuario_crea"=>$_SESSION["usuario"][0]["ID"],"usuario_edita"=>$_SESSION["usuario"][0]["ID"] ));

    if ($res) 
    {
      echo json_encode(array("resultado"=>true) ) ;
    }else{
      return false;
    }
  }
  public function buscar_grupos(){
    $modelo = new modeloPortada();
    $id_centro = $_POST["id_centro"];
      $sql = "select m.id as id_modulo, m.encargado_id, md.estado_completo,md.fecha_edicion from modulos m 
      left join modulos_detalle md on (md.modulo_id=m.Id) 
      where m.centro_id = ".$id_centro;

    $res = $modelo->executeQuery($sql );
    if ($res) 
    {
      echo json_encode(array("data"=>$res) ) ;
    }else{
      return false;
    }
}
}
