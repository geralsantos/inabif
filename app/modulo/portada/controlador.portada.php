<?php
date_default_timezone_set('America/Lima');
ini_set('max_execution_time',0);
ini_set('memory_limit', '300M');
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
      $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
      $centro_id = $_SESSION["usuario"][0]["CENTRO_ID"];

     /* if (empty($tipo_centro_id)) {
        $tipo_centro_id = "SELECT tipo_centro_id FROM centro_atencion WHERE id=".$centro_id." and  estado = 1 order by id asc";
        $tipo_centro_id = $modelo->executeQuery( $tipo_centro_id )[0]["TIPO_CENTRO_ID"];
        $_SESSION["usuario"][0]["TIPO_CENTRO_ID"] = $tipo_centro_id;
      }*/
      //$bd = isset($_SESSION["usuario"][0]["database_name"]) ? $_SESSION["usuario"][0]["database_name"] : 'portal-kpi' ;
      //$usuario = "SELECT kpi_roles_id FROM kpi_usuarios WHERE id=".$_SESSION['usuario'][0]['id']." and estado = 1 limit 1";
      //$usuario = $modelo->executeQuery( $usuario );
      //$_SESSION["nivelusuario"] = $usuario[0]['kpi_roles_id'];
      $modulos = "SELECT * FROM modulos WHERE centro_id=".$tipo_centro_id." and  estado = 1 order by id asc";
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
    <div class="collapse tabulacionMenu" id="node'.$element['ID'].'">
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
        if ($_POST['tabla']!="usuarios" && $_POST['tabla']!="centro_atencion") {
          $_POST['valores']['Tipo_Centro_Id'] = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
        }
        if ($_POST['tabla'] == "residente") {
          $_POST['valores']['centro_id'] = $_SESSION["usuario"][0]["ID_CENTRO"];
        }
        $_POST['valores']['Fecha_Creacion'] = date("y-M-d");
        $_POST['valores']['Estado'] = 1;
        //$_POST['valores']['Fecha_Edicion'] = date("Y-m-d H:i:s");
        $_POST['valores']['Usuario_Crea'] =$_SESSION["usuario"][0]["ID"];
        $_POST['valores']['Usuario_Edita'] =$_SESSION["usuario"][0]["ID"];
        //aqui tu ejecutas la consulta
        if ($_POST['tabla'] != "residente" && $_POST['tabla'] != "usuarios" && $_POST['tabla'] != "centro_atencion") {
          $_POST['valores']['Centro_Id'] = $_SESSION["usuario"][0]["CENTRO_ID"];
        }
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
    public function delete_datos(){

      if( $_POST['tabla']){
        $modelo = new modeloPortada();
        $res = $modelo->deleteData( $_POST['tabla'],$_POST["where"]);
        if ($res) {
            echo json_encode(array("resultado"=>true )) ;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }
    public function inhabilitar_centro(){

      if( $_POST['tabla']){
        $modelo = new modeloPortada();
        $where = $_POST["where"];
        $res = $modelo->updateData("centro_atencion",array("estado"=>0),$where);
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
         $word = strtolower($_POST['like']);
        $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
        if ($tipo_centro_id == PPD) {
          $campo = "nd.Numero_Documento ";
          $like = "nd.Numero_Documento LIKE '%".$word."%'";
          $left_join = ", CarCondicionIngreso nd ";
          $where_join = "and nd.residente_id(+)=re.id ";

        }else if($tipo_centro_id == PAM){
          $campo = "dci.numero_documento_ingreso ";
          $like = "dci.numero_documento_ingreso LIKE '%".$word."%'";
          $left_join = ", pam_datosCondicionIngreso dci ";
          $where_join = "and dci.residente_id(+)=re.id ";

        }else if($tipo_centro_id == NNA){
          $campo = "cir.Numero_Doc ";
          $like = "cir.Numero_Doc LIKE '%".$word."%'";
          $left_join = ", NNACondicionIResidente cir ";
          $where_join = "and cir.residente_id(+)=re.id ";
        }
        $codigolike="";
        if (is_numeric($word)) {
          $codigolike = " OR re.id ='".$word."'";
        }
        $nivel = $_SESSION["usuario"][0]["NIVEL"];
      if (SUPERVISOR == $nivel || USER_SEDE == $nivel) {
	$tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
	$where = " AND re.tipo_centro_id = ".$tipo_centro;
	}else if (REGISTRADOR ==$nivel || RESPONSABLE_INFORMACION ==$nivel){
	$centro_id = $_SESSION["usuario"][0]["CENTRO_ID"];
	$where = " AND re.centro_id = ".$centro_id;
	}else if(ADMIN_CENTRAL == $nivel || USER_SEDE_GESTION == $nivel){
	$where ="";
	}
        $sql = "SELECT * FROM (SELECT DISTINCT re.*, ".$campo." as dni_residente  FROM Residente re ".$left_join."  WHERE (LOWER(re.Nombre) LIKE '%".$word."%' OR LOWER(re.APELLIDO_M) LIKE '%".$word."%' OR LOWER(re.APELLIDO_P) LIKE '%".$word."%' OR ".$like.$codigolike." ) AND re.ESTADO=1 ".$where." ".$where_join."  ORDER BY re.Id desc) WHERE ROWNUM<=10";
        $res = $modelo->executeQuery( $sql );
        if ($res) {
          echo json_encode(array( "data"=>$res )) ;
        }else{
          return false;
        }

       }
	}
	public function buscar_residente_nominal(){
    if( $_POST['like']){
      $modelo = new modeloPortada();
       $word = strtolower($_POST['like']);
      $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
      if ($tipo_centro_id == PPD) {
        $campo = "nd.Numero_Documento ";
        $like = "nd.Numero_Documento LIKE '%".$word."%'";
        $left_join = ", CarCondicionIngreso nd ";
        $where_join = "and nd.residente_id(+)=re.id ";

      }else if($tipo_centro_id == PAM){
        $campo = "dci.numero_documento_ingreso ";
        $like = "dci.numero_documento_ingreso LIKE '%".$word."%'";
        $left_join = ", pam_datosCondicionIngreso dci ";
        $where_join = "and dci.residente_id(+)=re.id ";

      }else if($tipo_centro_id == NNA){
        $campo = "cir.Numero_Doc ";
        $like = "cir.Numero_Doc LIKE '%".$word."%'";
        $left_join = ", NNACondicionIResidente cir ";
        $where_join = "and cir.residente_id(+)=re.id ";
      }
      $nivel = $_SESSION["usuario"][0]["NIVEL"];
      if (SUPERVISOR == $nivel || USER_SEDE == $nivel) {
	$tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
	$where = " AND re.tipo_centro_id = ".$tipo_centro;
	}else if (REGISTRADOR ==$nivel || RESPONSABLE_INFORMACION ==$nivel){
	$centro_id = $_SESSION["usuario"][0]["CENTRO_ID"];
	$where = " AND re.centro_id = ".$centro_id;
	}else if(ADMIN_CENTRAL == $nivel || USER_SEDE_GESTION == $nivel){
	$where ="";
	}
      $codigolike="";
      if (is_numeric($word)) {
        $codigolike = " OR re.id ='".$word."'";
      }
      $sql = "SELECT * FROM (SELECT DISTINCT re.*, ".$campo." as dni_residente  FROM Residente re ".$left_join."  WHERE (LOWER(re.Nombre) LIKE '%".$word."%' OR LOWER(re.APELLIDO_M) LIKE '%".$word."%' OR LOWER(re.APELLIDO_P) LIKE '%".$word."%' OR ".$like.$codigolike." ) AND re.ESTADO=1 ".$where."  ORDER BY re.Id desc) WHERE ROWNUM<=10";
      $res = $modelo->executeQuery( $sql );
      if ($res) {
        echo json_encode(array( "data"=>$res )) ;
      }else{
        return false;
      }

     }
}
    public function ejecutar_consulta_lista_nominal(){
      $modelo = new modeloPortada();
      $campo="";$left_join;
       $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
       if ($tipo_centro_id == PPD) {
          $campo = "nd.Numero_Documento ";
          $left_join = ", CarCondicionIngreso nd ";
          $where_join = "and nd.residente_id(+)=re.id ";

        }else if($tipo_centro_id == PAM){
          $campo = "dci.numero_documento_ingreso ";
          $left_join = ", pam_datosCondicionIngreso dci ";
          $where_join = "and dci.residente_id(+)=re.id ";

        }else if($tipo_centro_id == NNA){
          $campo = "cir.Numero_Doc ";
          $left_join = ", NNACondicionIResidente cir ";
          $where_join = "and cir.residente_id(+)=re.id ";
        }
        $nivel = $_SESSION["usuario"][0]["NIVEL"];
      if (SUPERVISOR == $nivel || USER_SEDE == $nivel) {
	$tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
	$where = " AND re.tipo_centro_id = ".$tipo_centro_id;
	}else if (REGISTRADOR ==$nivel || RESPONSABLE_INFORMACION ==$nivel){
	$centro_id = $_SESSION["usuario"][0]["CENTRO_ID"];
	$where = " AND re.centro_id = ".$centro_id;
	}else if(ADMIN_CENTRAL == $nivel || USER_SEDE_GESTION == $nivel){
	$where ="";
	}
	  $sql = "SELECT max(re.id) as id,max(re.nombre) as nombre,max(re.apellido_p) as apellido_p,max(re.apellido_m) as apellido_m,max(".$campo.") as dni_residente FROM Residente re ".$left_join." WHERE  re.ESTADO=1 ".$where." ".$where_join."  group by re.id ORDER BY re.Id desc";
	  $res = $modelo->executeQuery( $sql );
	  if ($res) {
	echo json_encode(array( "data"=>$res )) ;
	  }else{
	return false;
	  }
	  }
	public function ejecutar_consulta_lista(){
      $modelo = new modeloPortada();
      $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
      if ($tipo_centro_id == PPD) {
        $campo = "nd.Numero_Documento ";
        $left_join = ", CarCondicionIngreso nd ";
        $where_join = "and nd.residente_id(+)=re.id ";

      }else if($tipo_centro_id == PAM){
        $campo = "dci.numero_documento_ingreso ";
        $left_join = ", pam_datosCondicionIngreso dci ";
        $where_join = "and dci.residente_id(+)=re.id ";

      }else if($tipo_centro_id == NNA){
        $campo = "cir.Numero_Doc ";
        $left_join = ", NNACondicionIResidente cir ";
        $where_join = "and cir.residente_id(+)=re.id ";
      }
        $nivel = $_SESSION["usuario"][0]["NIVEL"];
        if (SUPERVISOR == $nivel || USER_SEDE == $nivel) {
            $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
            $where = " AND re.tipo_centro_id = ".$tipo_centro;
        }else if (REGISTRADOR ==$nivel || RESPONSABLE_INFORMACION ==$nivel){
            $centro_id = $_SESSION["usuario"][0]["CENTRO_ID"];
            $where = " AND re.centro_id = ".$centro_id;
        }else if(ADMIN_CENTRAL == $nivel || USER_SEDE_GESTION == $nivel){
            $where ="";
        }
	  $sql = "SELECT max(re.id) as id,max(re.nombre) as nombre,max(re.apellido_p) as apellido_p,max(re.apellido_m) as apellido_m,max(".$campo.") as dni_residente FROM Residente re ".$left_join." WHERE  re.ESTADO=1 ".$where." ".$where_join." group by re.id ORDER BY re.Id desc";
	  $res = $modelo->executeQuery( $sql );
	  if ($res) {
	echo json_encode(array( "data"=>$res )) ;
	  }else{
	return false;
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
        $orderby = isset($_POST['orderby']) ? ("order by ".$_POST['orderby']) : "";
        $sql = "SELECT * FROM ".$_POST['tabla']." WHERE ".$codigo." ESTADO=1 ".$orderby;
        $res = $modelo->executeQuery( $sql );
        if ($res) {
          echo json_encode(array( "data"=>$res )) ;
        }else{
          return false;
        }

       }
    }
    public function selectData(){
      if( $_POST['tabla']){
        $modelo = new modeloPortada();

        $res = $modelo->selectData( $_POST["tabla"],$_POST["where"] );
        if ($res) {
          echo json_encode(array( "data"=>$res )) ;
        }else{
          return false;
        }
       }
    }
    public function buscar_entidad(){
      if( $_POST['tabla']){

        $modelo = new modeloPortada();
        $sql = "SELECT * FROM (SELECT * FROM ".strtoupper($_POST["tabla"])." WHERE tipo_centro_id = ".$_POST["tipo_centro_id"]." AND ESTADO=1 order by Id desc) WHERE ROWNUM=1";
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
    public function buscar_centro(){
      $modelo = new modeloPortada();

        $sql = "select ca.* from centro_atencion ca
        left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
        where ca.id=".$_SESSION["usuario"][0]["CENTRO_ID"]." and ca.estado = 1";

      $res = $modelo->executeQuery($sql );
      if ($res)
      {
        echo json_encode(array("data"=>$res) ) ;
      }else{
        return false;
      }
  }
    public function buscar_centros(){
        $modelo = new modeloPortada();
        if ($_SESSION["usuario"][0]["NIVEL"]==RESPONSABLE_INFORMACION) { //responsable de la información
          $sql = "select distinct ca.id as id_centro,ca.NOM_CA as nombre_centro, ca.COD_CA as codigo_centro, cad.estado_completo, cad.fecha_matriz, cad.id, cad.fecha_cierre,tc.codigo   from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where ca.id=".$_SESSION["usuario"][0]["CENTRO_ID"]." and ca.estado = 1 AND rownum = 1 ORDER BY cad.id desc";
        }else if($_SESSION["usuario"][0]["NIVEL"]==ADMIN_CENTRAL) //ADMIN_CENTRAL
        {
          $sql = "select max(ca.id) as id_centro,max(ca.NOM_CA ) as nombre_centro, max(ca.COD_CA ) as codigo_centro, max(cad.estado_completo) as estado_completo, max(cad.fecha_matriz) as fecha_matriz,max(tc.codigo) as codigo
          max(cad.fecha_cierre) as fecha_cierre, cad.id  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where ca.estado = 1 group by ca.id order by ca.id desc";
	    }else if($_SESSION["usuario"][0]["NIVEL"]==USER_CENTRO) //USER CENTRO: SOLO VE SU SEDE ASIGNADA
        {
          $sql = "select distinct ca.id as id_centro,ca.NOM_CA as nombre_centro, ca.COD_CA as codigo_centro, cad.estado_completo, cad.fecha_matriz,
          cad.id, cad.fecha_cierre,tc.codigo  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where ca.id=".$_SESSION["usuario"][0]["CENTRO_ID"]." and ca.estado = 1 AND rownum = 1 ORDER BY cad.id desc";
	    }else if($_SESSION["usuario"][0]["NIVEL"]==SUPERVISOR) //SUPERVISOR VE TODAS LAS SEDES DE SU TIPO DE CENTRO
        {
          $sql = "select max(ca.id) as id_centro,max(ca.NOM_CA ) as nombre_centro,  max(ca.COD_CA ) as codigo_centro, max(cad.estado_completo) as estado_completo, max(cad.fecha_matriz) as fecha_matriz,
         max(cad.fecha_cierre) as fecha_cierre,max(tc.codigo) as codigo  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where tc.id=".$_SESSION["usuario"][0]["TIPO_CENTRO_ID"]." and ca.estado = 1 group by ca.id order by ca.id desc";
        }else if($_SESSION["usuario"][0]["NIVEL"]==USER_SEDE_GESTION) //USER_SEDE_GESTIÓN
        {
          /*$sql = "select distinct ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo, cad.fecha_matriz, cad.fecha_cierre  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
	  where tc.id=".$_SESSION["usuario"][0]["TIPO_CENTRO_ID"]." and ca.estado = 1 ";*/
	  $sql = "select max(ca.id) as id_centro,max(ca.NOM_CA ) as nombre_centro,  max(ca.COD_CA ) as codigo_centro, max(cad.estado_completo) as estado_completo, max(cad.fecha_matriz) as fecha_matriz, max(cad.fecha_cierre) as fecha_cierre,max(tc.codigo) as codigo from centro_atencion ca left join centro_atencion_detalle cad on (cad.centro_id=ca.id) left join tipo_centro tc on (ca.tipo_centro_id=tc.id) where ca.estado = 1 group by ca.id order by ca.id desc";
        }else if($_SESSION["usuario"][0]["NIVEL"]==USER_SEDE) //USER_SEDE
        {
          $sql = "select max(ca.id) as id_centro,max(ca.NOM_CA ) as nombre_centro,  max(ca.COD_CA ) as codigo_centro,max(cad.estado_completo) as estado_completo, max(cad.fecha_matriz) as fecha_matriz, max(cad.fecha_cierre) as fecha_cierre,max(tc.codigo) as codigo  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where tc.id=".$_SESSION["usuario"][0]["TIPO_CENTRO_ID"]." and ca.estado = 1 group by ca.id order by ca.id desc";
        }else if($_SESSION["usuario"][0]["NIVEL"]==REGISTRADOR) //REGISTRADOR
        {
          $sql = "select distinct ca.id as id_centro,ca.NOM_CA as nombre_centro, ca.COD_CA as codigo_centro, cad.estado_completo, cad.fecha_matriz, cad.id, cad.fecha_cierre,tc.codigo  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where ca.id=".$_SESSION["usuario"][0]["CENTRO_ID"]." and ca.estado = 1 AND rownum = 1 ORDER BY cad.id desc";
        }

        $res = $modelo->executeQuery($sql);
        $centros = $res;
        if ($res){
          foreach ($centros as $key => $value) {
            $contador=0;
            $grupos = $modelo->buscar_grupos( $value["ID_CENTRO"]);
            foreach($grupos as $key2 => $value2){
              if($value2["ESTADO_COMPLETO"] != 1){
                $contador++;
                break;
              }
            }
            if($contador==0){

                $centros[$key]["COMPLETADO"] = 'SI';

            }else{
              $centros[$key]["COMPLETADO"] = 'NO';
            }

          }


          echo json_encode(array("data"=>$centros,"nivel_usuario"=>$_SESSION["usuario"][0]["NIVEL"]) ) ;
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
  public function completar_grupo(){
    $modelo = new modeloPortada();

    $sql = "select * from modulos_detalle where modulo_id = " . $_POST["id_modulo"] ." AND Periodo_Mes = ".date("m") . " AND Periodo_Anio = ".date("Y");
    $res = $modelo->executeQuery($sql );
    if($res){
      $res = $modelo->updateData("modulos_detalle",array("estado_completo"=>$_POST["estado_completo"]),array("modulo_id"=>$_POST["id_modulo"],"Periodo_Mes"=>date("m"),"Periodo_Anio"=>date("Y")));
    }else{
      $res = $modelo->insertData("modulos_detalle",array("modulo_id"=>$_POST["id_modulo"],"estado_completo"=>1,"Periodo_Mes"=>date("m"),"Periodo_Anio"=>date("Y"),"usuario_crea"=>$_SESSION["usuario"][0]["ID"],"usuario_edita"=>$_SESSION["usuario"][0]["ID"] ));

    }
    if ($res){
      echo json_encode(array("resultado"=>true) ) ;
    }else{
      return false;
    }

}
  public function generar_matriz(){
    $modelo = new modeloPortada();
    $sql = "";
    $res = $modelo->insertData("centro_atencion_detalle",array("centro_id"=>$_POST["id_centro"],"estado_completo"=>1,"fecha_matriz"=>date("d-M-y g.i.s"),"usuario_crea"=>$_SESSION["usuario"][0]["ID"],"usuario_edita"=>$_SESSION["usuario"][0]["ID"] ));

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
    $nombre_centro = $modelo->executeQuery("select * from centro_atencion where id=". $_POST["id_centro"]." and estado = 1");
      $sql = "select distinct m.nombre as modulo_nombre,m.id as id_modulo, m.encargado_id,usu.nombre as encargado_nombre, md.estado_completo,md.fecha_edicion,m.nombre_tabla from modulos m
      left join modulos_detalle md on (md.modulo_id=m.Id)
      left join usuarios usu on (usu.id = m.encargado_id)
      left join centro_atencion ca on (ca.tipo_centro_id=m.centro_id)
      where ca.id = ".$id_centro." and ca.estado = 1 order by m.id desc";

    $res = $modelo->executeQuery($sql );
    if ($res)
    {
      echo json_encode(array("data"=>$res,"nivel_usuario"=>$_SESSION["usuario"][0]["NIVEL"], "datos_centro"=>$nombre_centro) ) ;
    }else{
      return false;
    }
  }
  public function mostrar_modulo(){
    $modelo = new modeloPortada();
    $nombre_centro = $modelo->executeQuery("select * from centro_atencion where id=". $_POST["id_centro"]." and estado = 1");
    $nombre_tabla = $_POST["nombre_tabla"];
    $sql = "select re.nombre,re.apellido_p, nt.* from ".$nombre_tabla." nt inner join residente re on (re.id=nt.residente_id) where to_char(nt.fecha_creacion, 'MON-YY') =UPPER('".date("M-y")."')";

    $res = $modelo->executeQuery($sql );
    if ($res)
    {
      echo json_encode(array("data"=>$res, "datos_centro"=>$nombre_centro) ) ;
    }else{
      return false;
    }
  }
  public function listar_usuarios(){
    $modelo = new modeloPortada();
    $sql = "select usu.*,nu.nombre as nivel_nombre from usuarios usu left join niveles_usuarios nu on (usu.nivel=nu.id)";

    $res = $modelo->executeQuery($sql );
    if ($res)
    {
      echo json_encode(array("data"=>$res) ) ;
    }else{
      return false;
    }
  }
  public function mostrar_matrices(){
    $modelo = new modeloPortada();
      $nivel = $_SESSION["usuario"][0]["NIVEL"];

      if (ADMIN_CENTRAL == $nivel || USER_SEDE_GESTION == $nivel) {
        $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
        $where = "";
      }else if (SUPERVISOR == $nivel || USER_SEDE== $nivel){
        $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
        $where = "ca.tipo_centro_id = ".$tipo_centro." and ";
      }else if (REGISTRADOR == $nivel || RESPONSABLE_INFORMACION== $nivel || USER_CENTRO== $nivel){
        $centro = $_SESSION["usuario"][0]["CENTRO_ID"];
        $where = "ca.id = ".$centro." and ";
      }

      /*usg, admin = matriz total */
      /*  */
      $periodo_mes = $_POST["periodo_mes"];
      $periodo_anio = $_POST["periodo_anio"];

      $matriz_consolidado = "SELECT * FROM matriz_consolidado WHERE periodo_mes=".date("m",strtotime($periodo_mes))." AND periodo_anio=".$periodo_anio;
      $matriz_consolidado = $modelo->executeQuery($matriz_consolidado);
      if (!$matriz_consolidado) {
        return false;
      }
      $month = $periodo_anio."-".$periodo_mes;
      $aux = date('d', strtotime("{$month} + 1 month"));

      $last_day = date('d', strtotime("{$aux} - 1 day"));
      $fecha = " BETWEEN UPPER('".date("01-M-y",strtotime($periodo_anio."-".$periodo_mes))."') AND UPPER('".date(($last_day."-M-y"),strtotime($periodo_anio."-".$periodo_mes))."')";

        $matrices = "select max(ca.id) as centro_id, max(ca.nom_ca) as nombre_centro, to_char(max(cad.fecha_matriz),'DD-MON-YY HH24:MI') as fecha_matriz, max(cad.ID) as id from centro_atencion_detalle cad
          left join centro_atencion ca on(ca.id=cad.centro_id)  where ".$where." to_char(cad.fecha_matriz,'DD-MON-YY') ".$fecha." and ca.estado = 1 group by ca.id ";
      $matrices = $modelo->executeQuery($matrices);

      if ($matrices)
      {
        echo json_encode(array("data"=>$matrices) ) ;
      }else{
        return false;
      }
    }

    public function descargar_reporte_matriz_general(){
      $modelo = new modeloPortada();
	  $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];


	  $matriz_id = isset($_POST["matriz_id"]) ? ($_POST["matriz_id"]!=""?" cad.id = ".$_POST["matriz_id"]." and ":"") : "";
      $periodo_mes = $_POST["periodo_mes"];
      $periodo_anio = $_POST["periodo_anio"];
      $month = $periodo_anio."-".$periodo_mes;
      $aux = date('d', strtotime("{$month} + 1 month"));

      $last_day = date('d', strtotime("{$aux} - 1 day"));

	  $fecha = " BETWEEN UPPER('".date("01-M-y",strtotime($periodo_anio."-".$periodo_mes))."') AND UPPER('".date(($last_day."-M-y"),strtotime($periodo_anio."-".$periodo_mes))."')";
        $matriz_consolidado = "SELECT * FROM matriz_consolidado WHERE periodo_mes=".date("m",strtotime($periodo_mes))." AND periodo_anio=".$periodo_anio;
        $matriz_consolidado = $modelo->executeQuery($matriz_consolidado);
        if (!$matriz_consolidado) {
          return false;
        }
      $centros = "select  max(ca.id),max(ca.nom_ca) as nombre_centro,max(ca.tipo_centro_id) as tipo_centro_id,max(tc.nombre) as nombre_tipo_centro,to_char(max(cad.fecha_matriz),'DD-MON-YY HH24:MI') as fecha_matriz,max(cad.id) from centro_atencion_detalle cad
      left join centro_atencion ca on(ca.id=cad.centro_id)
      left join tipo_centro tc on(ca.tipo_centro_id=tc.id)
        where ".$matriz_id." to_char(cad.fecha_matriz,'DD-MON-YY') ".$fecha." and ca.estado=1 group by ca.id order by ca.id desc";
      $centros = $modelo->executeQuery($centros);
	  $html2 ="";
      foreach ($centros as $key => $centro)
      {
	$centro_html ="<tr><th>Nombre del Centro</th><th>Tipo de Centro</th><th>Fecha Matriz </th></tr>";
        $centro_html .="<tr><td>".$centro["NOMBRE_CENTRO"]."</td><td>".$centro["NOMBRE_TIPO_CENTRO"]."</td><td>".$centro["FECHA_MATRIZ"]."</td></tr>";

        //$modulo_html = "<table>";
        $modulos = "select m.parent_id,m.nombre as nombre_modulo,usu.nombre as nombre_usuario,md.periodo_mes,m.nombre_tabla from modulos_detalle md
        left join modulos m on(m.id=md.modulo_id)
        left join usuarios usu on(usu.id=m.encargado_id)
          where m.centro_id in (".$centro["TIPO_CENTRO_ID"].") and md.periodo_mes = ".date("m",strtotime($periodo_mes))." and md.periodo_anio = ".$periodo_anio." order by md.id desc";
        $modulos = $modelo->executeQuery($modulos);
	$html = "";
        foreach ($modulos as $key => $modulo)
        {
        if (($modulo["NOMBRE_TABLA"])!="") {
          $modulo_html ="<tr><th></th><th>Nombre del Modulo</th><th>Encargado</th><th>Periodo Mes</th></tr>";
          $modulo_html .="<tr><td></td><td>".$modulo["NOMBRE_MODULO"]."</td><td>".$modulo["NOMBRE_USUARIO"]."</td><td>".$modulo["PERIODO_MES"]."</td></tr>";

          $grupos = "select distinct nt.* from ".$modulo["NOMBRE_TABLA"]." nt where nt.periodo_mes=".date("m",strtotime($periodo_mes))." and nt.periodo_anio=".$periodo_anio."  order by nt.id desc";
          $grupos = $modelo->executeQuery($grupos);

          $grupo_html = "";
          $residentes = [];
          foreach ($grupos as $key => $grupo)
          {
            if (!in_array($grupo["RESIDENTE_ID"],$residentes)) {
              if ($key==0) {
                $keys = array_keys($grupo);
                $grupo_html .="<tr><th></th>";
                foreach ($keys as $key)
                {
                  $grupo_html .="<th>$key</th>";
                }
                $grupo_html .="</tr>";
              }
              $grupo_values = array_values($grupo);
              $grupo_html .= "<tr><td></td>";
              foreach ($grupo_values as $key => $value) {
                $grupo_html .="<td>".$value."</td>";
              }
              $grupo_html .= "</tr>";
              $residentes[] = $grupo["RESIDENTE_ID"];
            }
	  }
	  $html .= $modulo_html.$grupo_html;
          //$modulo_html .=$grupo_html;
          }
	}
	$html2 .=$centro_html.$html;
      }

      //$modulo_html .="</table>";
      //$table = '<table><tr><td>'.$centro_html.'</td></tr><tr><td>'.$modulo_html.'</td></tr></table>';
	  $table = '<table>'.$html2.'</table>';
      if ($modulos)
      {
        echo json_encode(array("data"=>$table) ) ;
      }else{
        return false;
      }
    }
    public function descargar_reporte_matriz_general_2(){
        $modelo = new modeloPortada();
        $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];



        $matriz_id = isset($_POST["matriz_id"]) ? ($_POST["matriz_id"]!=""?" cad.id = ".$_POST["matriz_id"]." and ":"") : "";
        $periodo_mes = $_POST["periodo_mes"];
        $periodo_anio = $_POST["periodo_anio"];
        $month = $periodo_anio."-".$periodo_mes;
        $matriz_consolidado = "SELECT * FROM matriz_consolidado WHERE periodo_mes=".date("m",strtotime($periodo_mes))." AND periodo_anio=".$periodo_anio;
      $matriz_consolidado = $modelo->executeQuery($matriz_consolidado);
      if (!$matriz_consolidado) {
        return false;
      }
        $aux = date('d', strtotime("{$month} + 1 month"));
        $last_day = date('d', strtotime("{$aux} - 1 day"));

        $fecha = " BETWEEN UPPER('".date("01-M-y",strtotime($periodo_anio."-".$periodo_mes))."') AND UPPER('".date(($last_day."-M-y"),strtotime($periodo_anio."-".$periodo_mes))."')";

/*ccs.Nom_Entidad, ccs.Cod_Linea ,ccs.Linea_Intervencion , ccs.Cod_Servicio , ccs.Nom_Servicio, ccs.Ubigeo_Ine, ccs.Departamento_CAtencion, ccs.Provincia_CAtencion, ccs.Distrito_CAtencion, ccs.Centro_Poblado, ccs.Centro_Residencia*/

        $nivel = $_SESSION["usuario"][0]["NIVEL"];
        $where = "";
        if (ADMIN_CENTRAL == $nivel || USER_SEDE_GESTION == $nivel) {
          $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
          $tipo_centro_dependiente = array('1'=>'and cu.tipo_centro_id(+)= re.tipo_centro_id and cda.tipo_centro_id(+)= re.tipo_centro_id and cci.tipo_centro_id(+)= re.tipo_centro_id and csn.tipo_centro_id(+)= re.tipo_centro_id and csm.tipo_centro_id(+)= re.tipo_centro_id and ct.tipo_centro_id(+)= re.tipo_centro_id and cac.tipo_centro_id(+)= re.tipo_centro_id and cap.tipo_centro_id(+)= re.tipo_centro_id and cec.tipo_centro_id(+)= re.tipo_centro_id and cts.tipo_centro_id(+)= re.tipo_centro_id and cas.tipo_centro_id(+)= re.tipo_centro_id and cep.tipo_centro_id(+)= re.tipo_centro_id and cee.tipo_centro_id(+)= re.tipo_centro_id and ces.tipo_centro_id(+)= re.tipo_centro_id and ctf.tipo_centro_id(+)= re.tipo_centro_id and cen.tipo_centro_id(+)= re.tipo_centro_id and cets.tipo_centro_id(+)= re.tipo_centro_id and ceg.tipo_centro_id(+)= re.tipo_centro_id and ca.tipo_centro_id=1  and re.tipo_centro_id=1',
          '2'=>'and pdi.tipo_centro_id(+)= re.tipo_centro_id and pdau.tipo_centro_id(+)= re.tipo_centro_id and pdci.tipo_centro_id(+)= re.tipo_centro_id and pds.tipo_centro_id(+)= re.tipo_centro_id and psm.tipo_centro_id(+)= re.tipo_centro_id and pasc.residente_id(+)=re.id and pap.tipo_centro_id(+)= re.tipo_centro_id and pas.tipo_centro_id(+)= re.tipo_centro_id and pasa.tipo_centro_id(+)= re.tipo_centro_id and pps.tipo_centro_id(+)= re.tipo_centro_id and ps.tipo_centro_id(+)= re.tipo_centro_id and pn.tipo_centro_id(+)= re.tipo_centro_id and pt.tipo_centro_id(+)= re.tipo_centro_id and peu.tipo_centro_id(+)= re.tipo_centro_id and ca.tipo_centro_id=2  and re.tipo_centro_id=2',
          '3'=>'and nir.tipo_centro_id(+)= re.tipo_centro_id and nar.tipo_centro_id(+)= re.tipo_centro_id and nci.tipo_centro_id(+)= re.tipo_centro_id and nfr.tipo_centro_id(+)= re.tipo_centro_id and nds.tipo_centro_id(+)= re.tipo_centro_id and nts.tipo_centro_id(+)= re.tipo_centro_id and nas.tipo_centro_id(+)= re.tipo_centro_id and ns.tipo_centro_id(+)= re.tipo_centro_id and nn.tipo_centro_id(+)= re.tipo_centro_id and ntol.tipo_centro_id(+)= re.tipo_centro_id and ne.tipo_centro_id(+)= re.tipo_centro_id and nfh.tipo_centro_id(+)= re.tipo_centro_id and np.tipo_centro_id(+)= re.tipo_centro_id and nps.tipo_centro_id(+)= re.tipo_centro_id and nss.tipo_centro_id(+)= re.tipo_centro_id and nns.tipo_centro_id(+)= re.tipo_centro_id and nes.tipo_centro_id(+)= re.tipo_centro_id and ntss.tipo_centro_id(+)= re.tipo_centro_id and neu.tipo_centro_id(+)= re.tipo_centro_id and ca.tipo_centro_id=3  and re.tipo_centro_id=3');
          $centro_id_dependiente = array('1'=>'and cu.centro_id(+)= re.centro_id and cda.centro_id(+)= re.centro_id and cci.centro_id(+)= re.centro_id and csn.centro_id(+)= re.centro_id and csm.centro_id(+)= re.centro_id and ct.centro_id(+)= re.centro_id and cac.centro_id(+)= re.centro_id and cap.centro_id(+)= re.centro_id and cec.centro_id(+)= re.centro_id and cts.centro_id(+)= re.centro_id and cas.centro_id(+)= re.centro_id and cep.centro_id(+)= re.centro_id and cee.centro_id(+)= re.centro_id and ces.centro_id(+)= re.centro_id and ctf.centro_id(+)= re.centro_id and cen.centro_id(+)= re.centro_id and cets.centro_id(+)= re.centro_id and ceg.centro_id(+)= re.centro_id and ca.id(+)= re.centro_id',
          '2'=>'and pdi.centro_id(+)= re.centro_id and pdau.centro_id(+)= re.centro_id and pdci.centro_id(+)= re.centro_id and pds.centro_id(+)= re.centro_id and psm.centro_id(+)= re.centro_id and pap.centro_id(+)= re.centro_id and pas.centro_id(+)= re.centro_id and pasa.centro_id(+)= re.centro_id and pps.centro_id(+)= re.centro_id and ps.centro_id(+)= re.centro_id and pn.centro_id(+)= re.centro_id and pt.centro_id(+)= re.centro_id and peu.centro_id(+)= re.centro_id and ca.id(+)= re.centro_id',
          '3'=>'and nir.centro_id(+)= re.centro_id and nar.centro_id(+)= re.centro_id and nci.centro_id(+)= re.centro_id and nfr.centro_id(+)= re.centro_id and nds.centro_id(+)= re.centro_id and nts.centro_id(+)= re.centro_id and nas.centro_id(+)= re.centro_id and ns.centro_id(+)= re.centro_id and nn.centro_id(+)= re.centro_id and ntol.centro_id(+)= re.centro_id and ne.centro_id(+)= re.centro_id and nfh.centro_id(+)= re.centro_id and np.centro_id(+)= re.centro_id and nps.centro_id(+)= re.centro_id and nss.centro_id(+)= re.centro_id and nns.centro_id(+)= re.centro_id and nes.centro_id(+)= re.centro_id and ntss.centro_id(+)= re.centro_id and neu.centro_id(+)= re.centro_id and  ca.id(+)= re.centro_id');
        }else if (SUPERVISOR == $nivel || USER_SEDE== $nivel){
          $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
          if ($tipo_centro == PPD) {
            $where = " and cu.tipo_centro_id(+)= ".$tipo_centro." and cda.tipo_centro_id(+)= ".$tipo_centro." and cci.tipo_centro_id(+)= ".$tipo_centro." and csn.tipo_centro_id(+)= ".$tipo_centro." and csm.tipo_centro_id(+)= ".$tipo_centro." and ct.tipo_centro_id(+)= ".$tipo_centro." and cac.tipo_centro_id(+)= ".$tipo_centro." and cap.tipo_centro_id(+)= ".$tipo_centro." and cec.tipo_centro_id(+)= ".$tipo_centro." and cts.tipo_centro_id(+)= ".$tipo_centro." and cas.tipo_centro_id(+)= ".$tipo_centro." and cep.tipo_centro_id(+)= ".$tipo_centro." and cee.tipo_centro_id(+)= ".$tipo_centro." and ces.tipo_centro_id(+)= ".$tipo_centro." and ctf.tipo_centro_id(+)= ".$tipo_centro." and cen.tipo_centro_id(+)= ".$tipo_centro." and cets.tipo_centro_id(+)= ".$tipo_centro." and ceg.tipo_centro_id(+)= ".$tipo_centro." and ca.tipo_centro_id(+)= ".$tipo_centro." and re.tipo_centro_id(+)= ".$tipo_centro." ";
          }else if($tipo_centro == PAM){
            $where = " and pdi.tipo_centro_id(+)= ".$tipo_centro." and pdau.tipo_centro_id(+)= ".$tipo_centro." and pdci.tipo_centro_id(+)= ".$tipo_centro." and pds.tipo_centro_id(+)= ".$tipo_centro." and psm.tipo_centro_id(+)= ".$tipo_centro." and pasc.residente_id(+)=re.id and pap.tipo_centro_id(+)= ".$tipo_centro." and pas.tipo_centro_id(+)= ".$tipo_centro." and pasa.tipo_centro_id(+)= ".$tipo_centro." and pps.tipo_centro_id(+)= ".$tipo_centro." and ps.tipo_centro_id(+)= ".$tipo_centro." and pn.tipo_centro_id(+)= ".$tipo_centro." and pt.tipo_centro_id(+)= ".$tipo_centro." and peu.tipo_centro_id(+)= ".$tipo_centro." and ca.tipo_centro_id(+)= ".$tipo_centro." and re.tipo_centro_id(+)= ".$tipo_centro." ";
          }else if($tipo_centro == NNA){
            $where = " and nir.tipo_centro_id(+)= ".$tipo_centro." and nar.tipo_centro_id(+)= ".$tipo_centro." and nci.tipo_centro_id(+)= ".$tipo_centro." and nfr.tipo_centro_id(+)= ".$tipo_centro." and nds.tipo_centro_id(+)= ".$tipo_centro." and nts.tipo_centro_id(+)= ".$tipo_centro." and nas.tipo_centro_id(+)= ".$tipo_centro." and ns.tipo_centro_id(+)= ".$tipo_centro." and nn.tipo_centro_id(+)= ".$tipo_centro." and ntol.tipo_centro_id(+)= ".$tipo_centro." and ne.tipo_centro_id(+)= ".$tipo_centro." and nfh.tipo_centro_id(+)= ".$tipo_centro." and np.tipo_centro_id(+)= ".$tipo_centro." and nps.tipo_centro_id(+)= ".$tipo_centro." and nss.tipo_centro_id(+)= ".$tipo_centro." and nns.tipo_centro_id(+)= ".$tipo_centro." and nes.tipo_centro_id(+)= ".$tipo_centro." and ntss.tipo_centro_id(+)= ".$tipo_centro." and neu.tipo_centro_id(+)= ".$tipo_centro." and  ca.id(+)= ".$tipo_centro." and re.tipo_centro_id(+)= ".$tipo_centro." ";
          }
        }else if (REGISTRADOR == $nivel || RESPONSABLE_INFORMACION== $nivel || USER_CENTRO== $nivel){
          $centro = $_SESSION["usuario"][0]["CENTRO_ID"];
          if ($tipo_centro == PPD) {
            $where = " and cu.centro_id(+)= ".$centro." and cda.centro_id(+)= ".$centro." and cci.centro_id(+)= ".$centro." and csn.centro_id(+)= ".$centro." and csm.centro_id(+)= ".$centro." and ct.centro_id(+)= ".$centro." and cac.centro_id(+)= ".$centro." and cap.centro_id(+)= ".$centro." and cec.centro_id(+)= ".$centro." and cts.centro_id(+)= ".$centro." and cas.centro_id(+)= ".$centro." and cep.centro_id(+)= ".$centro." and cee.centro_id(+)= ".$centro." and ces.centro_id(+)= ".$centro." and ctf.centro_id(+)= ".$centro." and cen.centro_id(+)= ".$centro." and cets.centro_id(+)= ".$centro." and ceg.centro_id(+)= ".$centro." and ca.id(+)= ".$centro." and re.centro_id(+)= ".$centro." ";
          }else if($tipo_centro == PAM){
            $where = " and pdi.centro_id(+)= ".$centro." and pdau.centro_id(+)= ".$centro." and pdci.centro_id(+)= ".$centro." and pds.centro_id(+)= ".$centro." and psm.centro_id(+)= ".$centro." and pap.centro_id(+)= ".$centro." and pas.centro_id(+)= ".$centro." and pasa.centro_id(+)= ".$centro." and pps.centro_id(+)= ".$centro." and ps.centro_id(+)= ".$centro." and pn.centro_id(+)= ".$centro." and pt.centro_id(+)= ".$centro." and peu.centro_id(+)= ".$centro." and ca.id(+)= ".$centro." and re.centro_id(+)= ".$centro." ";
          }else if($tipo_centro == NNA){
            $where = " and nir.centro_id(+)= ".$centro." and nar.centro_id(+)= ".$centro." and nci.centro_id(+)= ".$centro." and nfr.centro_id(+)= ".$centro." and nds.centro_id(+)= ".$centro." and nts.centro_id(+)= ".$centro." and nas.centro_id(+)= ".$centro." and ns.centro_id(+)= ".$centro." and nn.centro_id(+)= ".$centro." and ntol.centro_id(+)= ".$centro." and ne.centro_id(+)= ".$centro." and nfh.centro_id(+)= ".$centro." and np.centro_id(+)= ".$centro." and nps.centro_id(+)= ".$centro." and nss.centro_id(+)= ".$centro." and nns.centro_id(+)= ".$centro." and nes.centro_id(+)= ".$centro." and ntss.centro_id(+)= ".$centro." and neu.centro_id(+)= ".$centro." and  ca.id(+)= ".$centro." and re.centro_id(+)= ".$centro." ";
          }
        }

        include 'consultas_preparadas.php';

        if (ADMIN_CENTRAL == $nivel || USER_SEDE_GESTION == $nivel) {
          $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
          /* no afecta en la consulta ya que se listan todos los centros de todos los tipos de centros */
        }else if (SUPERVISOR == $nivel || USER_SEDE== $nivel){
          $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
          $modulos = $modulos[$tipo_centro];
          if ($tipo_centro == PPD) {
            $modulos = $modulos.' order by cu.residente_id desc';
            }else if($tipo_centro == PAM){
            $modulos = $modulos.' order by pdi.residente_id desc';
            }else if($tipo_centro == NNA){
            $modulos = $modulos.' order by nir.residente_id desc';
            }
            $modulos = [$modulos];
        }else if (REGISTRADOR == $nivel || RESPONSABLE_INFORMACION== $nivel || USER_CENTRO== $nivel){
          $centro = $_SESSION["usuario"][0]["CENTRO_ID"];
          $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
          $modulos = $modulos[$tipo_centro];
          if ($tipo_centro == PPD) {
            $modulos = $modulos.' order by cu.residente_id desc';
            }else if($tipo_centro == PAM){
            $modulos = $modulos.' order by pdi.residente_id desc';
            }else if($tipo_centro == NNA){
            $modulos = $modulos.' order by nir.residente_id desc';
            }
          $modulos = [$modulos];

        }
        $html_modulo = "";
        foreach ($modulos as $key => $modulo)
        {
          if (ADMIN_CENTRAL == $nivel || USER_SEDE_GESTION == $nivel) {
          $modulo = $modulo.$tipo_centro_dependiente[$key].' '.$centro_id_dependiente[$key];
          if ($key == PPD) {
            $modulo = $modulo.' order by cu.residente_id desc';
            }else if($key == PAM){
            $modulo = $modulo.' order by pdi.residente_id desc';
             
            }else if($key == NNA){
            $modulo = $modulo.' order by nir.residente_id desc';
            }
          }
            $modulo = $modelo->executeQuery($modulo);
            $residentes = array();
            $grupo_html = "";
            if ($modulo) {
              foreach ($modulo as $key => $grupo) {
                if (!in_array($grupo["CODIGORESIDENTE"],$residentes)) {
                  if ($key==0) {
                    $keys = array_keys($grupo);
                    $grupo_html .="<tr>";
                    foreach ($keys as $key)
                    {
                      $grupo_html .="<th style='background-color:yellow;'>".strtoupper($key)."</th>";
                    }
                    $grupo_html .="</tr>";
                  }
                  $grupo_values = array_values($grupo);
                  $grupo_html .= "<tr>";
                  foreach ($grupo_values as $key => $value) {
                    $grupo_html .="<td style='text-align:left;'>".$value."</td>";
                  }
                  $grupo_html .= "</tr>";
                  $residentes[] = $grupo["CODIGORESIDENTE"];
                }
              }
              $html_modulo = $html_modulo . $grupo_html."<tr><td></td></tr><tr><td></td></tr>";
            }
            //break;
        }
        $table = '<table>'.$html_modulo.'</table>';
        if ($modulos)
        {
          echo json_encode(array("data"=>$table) ) ;
          return true;
        }else{
          return false;
        }
    }
  public function mostrar_reporte_rub(){
    /*$modelo = new modeloPortada();
    $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
    $fecha = " BETWEEN UPPER('".$_POST["fecha_inicial"]."') AND UPPER('".$_POST["fecha_final"]."')";
    $nivel = $_SESSION["usuario"][0]["NIVEL"];
    if (USER_CENTRO == $nivel || SUPERVISOR == $nivel || RESPONSABLE_INFORMACION == $nivel) {
      $tipo_centro = $_SESSION["usuario"][0]["CENTRO_ID"];
      $where = "ca.id = ".$tipo_centro;
    }else{
      $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
      $where = "ca.tipo_centro_id = ".$tipo_centro_id;
    }

    echo $residentes = "select  re.nombre as nombre_residente,re.apellido_p,re.apellido_m,re.fecha_creacion as fecha
    from residente re
    inner join centro_atencion ca on (re.centro_id=ca.id)
	  inner join tipo_centro tc on(tc.id=re.tipo_centro_id)
	  where to_char(re.fecha_creacion,'DD-MON-YY') ".$fecha." and ".$where." order by re.id desc";
    $residentes = $modelo->executeQuery($residentes);*/
    $modelo = new modeloPortada();
    $nivel = $_SESSION["usuario"][0]["NIVEL"];
    $innner_centro_atencion = "inner join centro_atencion ca on(ca.tipo_centro_id=tc.id) ";

    if (USER_CENTRO == $nivel || SUPERVISOR == $nivel || RESPONSABLE_INFORMACION == $nivel) {
      $tipo_centro = $_SESSION["usuario"][0]["CENTRO_ID"];
      $filtro_centro = "ca.id = ".$tipo_centro;
    }else{
      $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
      $filtro_centro = "tc.tipo_centro_id = ".$tipo_centro_id;
      $innner_centro_atencion = "";
    }
      $fecha = " BETWEEN UPPER('".$_POST["fecha_inicial"]."') AND UPPER('".$_POST["fecha_final"]."')";
    $residentes = "select distinct re.id, re.nombre as nombre_residente, re.apellido_p, re.apellido_m, pa.nombre as nombre_pais , ubi.NOMDEPT as nombre_departamento, ubi.nomprov as nombre_provincia, ubi.nomdist as nombre_distrito, (CASE sexo WHEN 'h' THEN 'Hombre' ELSE 'Mujer' END) as sexo_residente ,re.fecha_creacion as fecha from residente re
    inner join tipo_centro tc on(tc.id=re.tipo_centro_id)
    ".$innner_centro_atencion."
    inner join paises pa on(pa.id=re.pais_id)
    inner join ubigeo ubi on(ubi.coddist=re.distrito_naci_cod)
    where to_char(re.fecha_creacion,'DD-MON-YY') ".$fecha." AND ".$filtro_centro." ";
    $residentes = $modelo->executeQuery($residentes);

    if ($residentes)
    {
      echo json_encode(array("data"=>$residentes) ) ;
    }else{
      return false;
    }
  }
  public function descargar_reporte_matriz_rub(){
    $modelo = new modeloPortada();
	$nivel = $_SESSION["usuario"][0]["NIVEL"];
	$innner_centro_atencion = "inner join centro_atencion ca on(ca.tipo_centro_id=tc.id) ";

	if (USER_CENTRO == $nivel || SUPERVISOR == $nivel || RESPONSABLE_INFORMACION == $nivel) {
	$centro_id = $_SESSION["usuario"][0]["CENTRO_ID"];
	$filtro_centro = "ca.id = ".$centro_id;
	}else{
	$tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
	$filtro_centro = "tc.tipo_centro_id = ".$tipo_centro_id;
	$innner_centro_atencion = "";
  }
  $anio = date("Y",strtotime($_POST["fecha_inicial"]));
  $mes = date("F",strtotime($_POST["fecha_final"])); 
  $fecha_inicial = date("d-m-Y",strtotime($_POST["fecha_final"])); 
  $fecha_final = date("d-m-Y",strtotime($_POST["fecha_final"])); 
	$fecha = " BETWEEN UPPER('".$fecha_inicial."') AND UPPER('".$fecha_final."')";
  
  
  include 'consultas_preparadas_rub.php';

  $where = " WHERE to_char(da.fecha_edita,'DD-MON-YY') ".$fecha." AND to_char(ceg.fecha_egreso,'DD-MON-YY') ".$fecha;
  

	foreach ($modulos as $key => $modulo)
  {
    if (ADMIN_CENTRAL == $nivel || USER_SEDE_GESTION == $nivel) {
      $modulo = $modulo.$tipo_centro_dependiente[$key].' '.$centro_id_dependiente[$key];
    }
      $modulo = $modelo->executeQuery($modulo);
      $residentes = array();
      $grupo_html = "";
      if ($modulo) {
        foreach ($modulo as $key => $grupo) {
          if (!in_array($grupo["CODIGORESIDENTE"],$residentes)) {
            if ($key==0) {
              $keys = array_keys($grupo);
              $grupo_html .="<tr>";
              foreach ($keys as $key)
              {
                $grupo_html .="<th style='background-color:yellow;'>".strtoupper($key)."</th>";
              }
              $grupo_html .="</tr>";
            }
            $grupo_values = array_values($grupo);
            $grupo_html .= "<tr>";
            foreach ($grupo_values as $key => $value) {
              $grupo_html .="<td style='text-align:left;'>".$value."</td>";
            }
            $grupo_html .= "</tr>";
            $residentes[] = $grupo["CODIGORESIDENTE"];
          }
        }
        $html_modulo = $html_modulo . $grupo_html."<tr><td></td></tr><tr><td></td></tr>";
      }
      //break;
  }
  $table = '<table>'.$html_modulo.'</table>';
  if ($modulos)
  {
    echo json_encode(array("data"=>$table) ) ;
    return true;
  }else{
    return false;
  }
  }
  public function mostrar_reporte_nominal(){
    $modelo = new modeloPortada();
    $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
	$id_residente = $_POST["id_residente"];
	/*
	if (SUPERVISOR == $nivel || USER_SEDE == $nivel) {
	$tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
	$where = " AND tipo_centro_id = ".$tipo_centro;
	}else if (REGISTRADOR ==$nivel || RESPONSABLE_INFORMACION ==$nivel){
	$centro_id = $_SESSION["usuario"][0]["CENTRO_ID"];
	$where = " AND centro_id = ".$centro_id;
	}else if(ADMIN_CENTRAL == $nivel || USER_SEDE_GESTION == $nivel){
	$where ="";
	}*/
    $residente = "select distinct re.nombre as nombre_residente,tc.id as tipo_centro_id from residente re
	inner join centro_atencion ca on(ca.id=re.centro_id)
	inner join tipo_centro tc on(tc.id=re.tipo_centro_id)
	where re.id = ".$id_residente." and ca.estado=1 order by re.id desc";
    $residente = $modelo->executeQuery($residente);

    if ($residente)
    {
      echo json_encode(array("data"=>$residente) ) ;
    }else{
      return false;
    }
  }
  public function campos_tipo_centro ($tipo_centro_id=""){
    $campos = "";
    switch ($tipo_centro_id) {
      case '1': /*ppd*/
      $campos = array('DATOS GENERALES DE INGRESO DEL RESIDENTE | CarIdentificacionUsuario'=>
'Ape_Paterno as "Apellido paterno",Ape_Materno as "Apellido materno",
Nom_Usuario as "Nombre Usuario",
(SELECT nombre FROM paises WHERE id=CarIdentificacionUsuario.Pais_Procencia) as "Pai­s de procedencia",
(SELECT NOMDEPT FROM ubigeo WHERE coddist=CarIdentificacionUsuario.Distrito_Procedencia) as "Departamento de nac",
(SELECT NOMPROV FROM ubigeo WHERE coddist=CarIdentificacionUsuario.Distrito_Procedencia) as "Provincia de nac" ,
(SELECT NOMPROV FROM ubigeo WHERE coddist=CarIdentificacionUsuario.Distrito_Procedencia) as "Distrito de nac",
(CASE Sexo WHEN \'h\' THEN \'Hombre\' WHEN \'m\' THEN \'Mujer\' END) as "Sexo",
Fecha_Nacimiento as "Fecha de Nacimiento",
(SELECT nombre from pam_lengua_materna WHERE id = CarIdentificacionUsuario.Lengua_Materna) as "Lengua Materna"',

'DATOS GENERALES DE INGRESO DEL RESIDENTE | CarDatosAdmision'=>
'Fecha_Ingreso as "Fecha de ingreso",
(SELECT nombre FROM pam_instituciones WHERE id=CarDatosAdmision.Institucion_derivado) as "Entidad deriva",
Motivo_Ingreso  as "Motivo ingreso PRINCIPAL(exp)",
\'\'  as "Motivo ingreso PRINCIPAL(real)",
Numero_Documento as "Número documento de ingreso"',

'DATOS GENERALES DE INGRESO DEL RESIDENTE | CarCondicionIngreso'=>
'DNI as "DNI al ingreso",
(SELECT nombre FROM pam_tipo_documento_identidad WHERE id=CarCondicionIngreso.Tipo_Documento) as "Tipo documento de identidad",
 Numero_Documento as "Número documento de ingreso",
 Posee_Pension as "Pensión",
 (SELECT nombre FROM pam_tipo_pension WHERE id=CarCondicionIngreso.Tipo_Pension) as "Tipo de pensión",
 Lee_Escribe as "Sabe Leer y Escribir",
 (SELECT nombre FROM pam_nivel_educativo where id=CarCondicionIngreso.Nivel_Educativo) as "Nivel Educativo",
 (SELECT nombre FROM pam_clasif_socioeconomico where id = CarCondicionIngreso.Clasficacion_Socioeconomica) as "Clasificación Socio. (SISFOH)",\'\' as "Cobertura médica",
 (SELECT nombre FROM pam_tipo_seguro_salud WHERE id=CarCondicionIngreso.Tipo_Seguro) as "Tipo de aseguramiento"',

 'DATOS GENERALES DE INGRESO DEL RESIDENTE | CarSaludNutricion'=>array('Discapacidad as "Discapacidad",
 Discapacidad_Fisica as "Presenta discap. física",
 Discapacidad_Intelectual as "Presenta discap. intelectual",
  Discapacidad_Sensorial as "Presenta discap. sensorial",
  Discapacidad_mental as "Presenta discap. mental",
  Carnet_CONADIS as "Tiene carnet de CONADIS",
  \'\' as "Grado dependencia de la PAM",
  Motivo_Movilidad as "Motivo de dificultad Desplaz.",
  Patologia1 as "Patología Crónica 1",
  (SELECT nombre FROM pam_tipo_patologia WHERE id =CarSaludNutricion.Tipo_Patologia1) as "Tipo de Patología",
  Especifique1  as "Especifique"','Nivel_Hemoglobina as "Nivel de Hemoglobina",
   Peso as "Peso (Kg.)",
   Talla as "Talla (m)",
   Estado_Nutricional as "Estado Nutricional(IMC)"'),

   'DATOS FAMILIARES Y SOCIALES DEL USUARIO (Trabajo Social) | NNAtrabajoSocial_Semestral'=>
   '\'\' as "Cuenta con familiares",
    \'\' as "Tipo de parentesco"',

    'DATOS GENERALES DE INGRESO DEL RESIDENTE | CarSaludMental'=>
    'Transtorno_Neurologico as "¿Trastornos Neurológicos?",
    (SELECT nombre FROM pam_tipo_transtorno_conducta where id=CarSaludMental.Tipo_Transtorno) as "Tipo de trastorno de conducta"',

   'DATOS DE SEGUIMIENTO DEL RESIDENTE | CarEgresoSalud'=>
   'Plan_Medico as "Plan de intervención",
   Meta_PII as "Meta trazada en el PII",
   Informe_Tecnico as "Posee inf. técnico evolutivo",
   Des_Informe as "Descripción inf. evolutivo",
   Cumple_Plan as "Plan de intervención",
   Enfermedades_Cronicas as "Enfermedades crónicas deg.",
   Especificar as "Especificar la enfermedad"',

   'DATOS DE SEGUIMIENTO DEL RESIDENTE | CarEgresoTrabajoSocial'=>
   'Plan_Social as "Plan de intervención social",
   Meta_PII as "Meta trazada en el PII",
   Informe_Tecnico as "Posee inf. técnico evolutivo",
   Des_Informe as "Descripción inf. evolutivo",
   Cumple_Plan as "Cumplimiento del plan",
   Ubicacion_Familia as "Ubicación de la familia",
   Participacion_Familia as "Participación de la familia",
   Reinsercion as "Posibilidad de Reinserción",
   Colocacion_Laboral as "Posibilidad Colocación Lab."',

'DATOS DE EGRESO DEL RESIDENTE | CarEgresoGeneral'=>'Fecha_Egreso as "Fecha de Egreso",Motivo_Egreso as "Motivo de Egreso",Retiro_Voluntario as "Retiro Voluntario",Reinsercion, Grado_Parentesco as "Grado de Parentesco", Traslado, Fallecimiento, Restitucion_derechos as "Restitución de Derechos",AUS,Constancia_Naci as "Constancia de Nacimiento",Carnet_CONADIS as "CONADIS",DNI as "Documento de Identidad", Restitucion');
      break;
      case '2': /*pam*/
      $campos = array('DATOS GENERALES DE INGRESO DEL RESIDENTE | pam_datos_identificacion'=>
      'residente_apellido_paterno as "Apellido paterno",
      residente_apellido_materno as "Apellido materno",
      residente_nombre as "Nombre Usuario",
      (SELECT nombre FROM paises WHERE id=pam_datos_identificacion.pais_procedente_id) as "Pai­s de procedencia",
      (SELECT NOMDEPT FROM ubigeo WHERE coddist=pam_datos_identificacion.distrito_nacimiento_id) as "Departamento de nac",
      (SELECT NOMPROV FROM ubigeo WHERE coddist=pam_datos_identificacion.distrito_nacimiento_id) as "Provincia de nac",
      (SELECT NOMPROV FROM ubigeo WHERE coddist=pam_datos_identificacion.distrito_nacimiento_id) as "Distrito de nac",
      (CASE sexo WHEN \'h\' THEN \'Hombre\' WHEN \'m\' THEN \'Mujer\' END) as "Sexo",
      fecha_nacimiento as "Fecha de Nacimiento",
      (SELECT nombre from pam_lengua_materna WHERE id = pam_datos_identificacion.lengua_materna) as "Lengua Materna"',


      'DATOS GENERALES DE INGRESO DEL RESIDENTE | pam_datos_admision_usuario'=>
      'fecha_ingreso_usuario as "Fecha de Ingreso",
      (SELECT nombre FROM pam_instituciones_deriva WHERE id=pam_datos_admision_usuario.institucion_deriva) as "Entidad que lo deriva",
      (SELECT nombre FROM pam_motivos_ingreso WHERE id = pam_datos_admision_usuario.motivo_ingreso_principal) as "Motivo ingreso PRINCIPAL(exp)",
      (SELECT nombre FROM pam_motivos_ingreso WHERE id = pam_datos_admision_usuario.motivo_ingreso_secundario)as "Motivo ingreso PRINCIPAL(real)",
      numero_documento_ingreo_car as "Número documento de ingreso",
      perfil_ingreso as "Perfil de Ingreso"',

      'DATOS GENERALES DE INGRESO DEL RESIDENTE | pam_datosCondicionIngreso'=>array('documento_entidad as "DNI al ingreso",
      tipo_documento_entidad as "Tipo documento de identidad",
      numero_documento_ingreso as "Número documento de ingreso",
      \'\' as "Pensión",
      tipo_pension as "Tipo de pensión",
      leer_escribir as "Sabe Leer y Escribir",
      (SELECT nombre FROM pam_nivel_educativo where id=pam_datosCondicionIngreso.nivel_educativo) as "Nivel Educativo",
      \'\' as "Cobertura médica",
      (SELECT nombre FROM pam_clasif_socioeconomico where id = pam_datosCondicionIngreso.SISFOH) as "Clas.Socioeconómica(SISFOH)",
      aseguramiento_salud as "Tipo de aseguramiento"', 'familiar_ubicados as "Cuenta con familiares",
      tipo_parentesco as "Tipo de parentesco"'),


 'DATOS GENERALES DE INGRESO DEL RESIDENTE | pam_datos_saludnutric'=>array(
 'discapacidad as "Discapacidad",
 discapacidad_fisica as "Presenta discap. física",
 discapacidad_intelectual as "Presenta discap. intelectual",
 discapacidad_sensorial as "Presenta discap. sensorial",
 presenta_discapacidad_mental as  "Presenta discap. mental",
 carnet_conadis as "Tiene carnet del CONADIS",
 grado_dependencia_pam as "Grado dependencia PAM",
 motivo_dif_desplazamiento as "Motivo dif. con el desplaza.",
 enfermedad_ingreso_1 as "Patología crónica 1",
 (SELECT nombre FROM pam_tipo_patologia WHERE id =pam_datos_saludnutric.tipo_patologia) as "Tipo de patología",
 \'\' as "Especifique"','nivel_hemoglobina as "Nivel de Hemoglobina",
 peso as "Peso (Kg.)",
 talla as "Talla (m)",
 estado_nutricional as "Estado Nutricional(IMC)"'),

 'DATOS GENERALES DE INGRESO DEL RESIDENTE | pam_salud_mental'=>
 'trastorno_disociales as "Tras. comport. y/o disociales",
 tipo_trastorno as "Tipo de transtorno"',

 'DATOS DE SEGUIMIENTO DEL RESIDENTE | pam_Salud'=>
 'Plan_Intervencion as "Plan de intervención",
 Meta_PAI as "Meta trazada en el PAI",
 Informe_Tecnico as "Informe técnico evolutivo",
 Des_Informe_Tecnico as "Descripción",
 Cumple_Intervencion as "Cumplimiento del plan ",
 Grado_PAM as "Grado dependencia de las PAM",
 EnfermedaCronicasDegenerativas as "Enfermedades crónicas deg.",
 Especificar_Enfermedad as "Especificar"',

 'DATOS DE SEGUIMIENTO DEL RESIDENTE | pam_trabajoSocial'=>
 'Plan_Intervencion as "Plan de intervención",
 Meta_PAI as "Meta trazada en el PAI",
 Informe_Tecnico as "Informe técnico evolutivo",
 Des_Informe_Tecnico as "Descripción ",
 Cumple_Intervencion as "Cumplimiento del plan "',

 'DATOS DE EGRESO DEL RESIDENTE | pam_EgresoUsuario'=>
 'Fecha_Egreso as "Fecha de egreso",
 MotivoEgreso as "Motivo de egreso",
 Retiro_Voluntario as "Retiro Voluntario",
 Reinsercion_Familiar as "Reinserción familiar",

 Traslado_Entidad_Salud as "Traslado a entidad de salud",
 Traslado_Otra_Entidad as "Traslado a otra Entidad",
 Fallecimiento as "Fallecimiento",
 RestitucionAseguramientoSaludo as "Cumpl. de rest.derechos salud",
 Restitucion_Derechos_DNI as "Cumpl. de rest.derechos dni",
 RestitucionReinsercionFamiliar as "Reinserción Familiar"');
 break;
      case '3':
      $campos = array('DATOS GENERALES DE INGRESO DEL USUARIO | NNAInscripcionResidente'=>
      'residente_apellido_paterno as "Apellido paterno",
      residente_apellido_materno as "Apellido materno",
      residente_nombre as "Nombre usuario",
      (SELECT nombre FROM paises WHERE id=NNAInscripcionResidente.pais_procedente_id) as "Pai­s de procedencia",
      (SELECT NOMDEPT FROM ubigeo WHERE coddist=NNAInscripcionResidente.distrito_nacimiento_id) as "Departamento de nac",
      (SELECT NOMPROV FROM ubigeo WHERE coddist=NNAInscripcionResidente.distrito_nacimiento_id) as "Provincia de nac" ,
      (SELECT NOMPROV FROM ubigeo WHERE coddist=NNAInscripcionResidente.distrito_nacimiento_id) as "Distrito de nac",
      (CASE sexo WHEN \'h\' THEN \'Hombre\' WHEN \'m\' THEN \'Mujer\' END) as "Sexo",
      fecha_nacimiento as "Fecha de nacimiento" ,
      (SELECT nombre from pam_lengua_materna WHERE id = NNAInscripcionResidente.lengua_materna) as "Lengua materna"',

      'DATOS GENERALES DE INGRESO DEL USUARIO | NNAAdmisionResidente'=>
      'Fecha_Ingreso as "Fecha de Ingreso",
      (SELECT nombre FROM nna_instituciones WHERE id=NNAAdmisionResidente.Institucion_Derivacion) as "Entidad que lo deriva",
      (SELECT nombre FROM nna_motivos_ingreso WHERE id=NNAAdmisionResidente.Motivo_Ingreso)  as "Motivo ingreso PRINCIPAL(exp)",
      (SELECT nombre FROM nna_motivos_ingreso WHERE id=NNAAdmisionResidente.Motivo_Ingreso)  as "Motivo ingreso PRINCIPAL(real)",
      Numero_Doc as "Número documento de ingreso",
      Perfil_Ingreso_P as "Perfil de ingreso"',

      'DATOS GENERALES DE INGRESO DEL USUARIO | NNACondicionIResidente'=>
      'Numero_Doc as "DNI al ingreso",
      Tipo_Doc as "Tipo documento de identidad",
      \'\' as "Número documento de ingreso",
      \'\' as "Pensión",
      Lee_Escribe as "¿Sabe leer y escribir?",
      (SELECT nombre FROM pam_nivel_educativo WHERE id=NNACondicionIResidente.Nivel_Educativo) as "Nivel Educativo",
      (SELECT nombre FROM pam_tipo_seguro_salud WHERE id=NNACondicionIResidente.Tipo_Seguro) as "Tipo de Seguro de Salud",
      (SELECT nombre FROM pam_clasif_socioeconomico WHERE id=NNACondicionIResidente.SISFOH) as "Clasif.Socioeconómica(SISFOH)",
      \'\' as "Cobertura médica",
      \'\' as "Tipo de aseguramiento"',

      'DATOS GENERALES DE INGRESO DEL USUARIO | NNADatosSaludResi'=>
      'Discapacidad as "Discapacidad",
      Discapacidad_Fisica as "Presenta discap. física",
      Discapaciada_Intelectual as "Presenta discap. intelectual",
      Discapacidad_Sensorial as "Presenta discap. sensorial",
      Discapacidad_Mental as "Presenta discap. mental",
      Carnet_CANADIS as "Tiene carnet del CONADIS",
      \'\' as "Grado de dependencia de PAM",
      \'\' as "Motivo dif. con el desplaza.",
      \'\' as "Patología crónica 1",
      \'\' as "Tipo de patología",
      \'\' as "Especifique"',


      'DATOS GENERALES DE INGRESO DEL USUARIO | NNADatosSaludResi'=>
      'Nivel_Hemoglobina as "Nivel de Hemoglobina",
      Peso as "Peso (Kg.)",
      Talla as "Talla (m)",
      Estado_Nutricional1 as "Estado Nutricional (IMC)"',

      'DATOS GENERALES DE INGRESO DEL USUARIO | NNAFamiliaresResidente'=>
      'Familiares as "Cuenta con familiares",
      Parentesco as "Tipo de parentesco"',

      'DATOS GENERALES DE INGRESO DEL USUARIO | NNADatosSaludResi'=>
      'Transtornos_Comportamiento as "Tras. comport. y/o disociales",
      Tipo_Transtorno as "Tipo de transtorno"',

      'DATOS DE SEGUIMIENTO DEL USUARIO | NNASalud_Semestral'=>
      'Plan_Intervencion as "Plan de intervención",
      Meta_PAI as "Meta trazada en el PAI",
      Informe_tecnico as "Informe técnico evolutivo",
      Cumple_Intervencion as "Cumplimiento del Plan",
      Control_CRED as "Control CRED acorde a la Edad",
      Vacunacion as "Esq. de vac. acorde a la Edad"',

      'DATOS DE SEGUIMIENTO DEL USUARIO | NNAtrabajoSocial_Semestral'=>
      'Plan_Intervencion as "Plan de Intervención ",
      Meta_PAI as "Meta trazada en el PAI",
      Informe_Tecnico as "Informe técnico evolutivo",
      Cumple_Intervencion as "Cumplimiento del Plan",
      ParticipacionF_Activa as "Participación activa familiar",
      Reinsercion_Familiar as "Plan de Reinserción familiar",
      FamiliaR_Soporte as "Fam. usa las RSS"',

      'DATOS DE EGRESO DEL USUARIO | NNAEgresoUsuario'=>
      'Fecha_Egreso as "Fecha de egreso",
      MotivoEgreso as "Motivo de egreso",
      Detalle_Motivo as "Detalle del motivo del egreso",
      Salud_AUS as "Asegura. uni. de Salud-AUS",
      Partida_Naci as "Partida de Nacimiento",
      DNI as "DNI",
      Educacion as "Educación",
      Reinsecion_Familiar as "Reinserción Familiar"');
      break;
      default:
      $parent_id="2,25";
        break;
    }
    return $campos;
  }
  public function descargar_reporte_matriz_nominal(){
   /* ini_set('max_execution_time',0);
ini_set('memory_limit', '600M');
ini_set('session.gc_maxlifetime','1200');*/
    $modelo = new modeloPortada();
    $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
    $id_residente = $_REQUEST["id_residente"];
    $nivel = $_SESSION["usuario"][0]["NIVEL"];
    if (SUPERVISOR == $nivel || USER_SEDE == $nivel) {
      $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
      $where = " where ca.tipo_centro_id = ".$tipo_centro_id;
    }else if (REGISTRADOR ==$nivel || RESPONSABLE_INFORMACION ==$nivel || USER_CENTRO ==$nivel){
      $centro_id = $_SESSION["usuario"][0]["CENTRO_ID"];
      $where = " where ca.id = ".$centro_id;
    }else if(ADMIN_CENTRAL == $nivel || USER_SEDE_GESTION == $nivel){
      $where ="";
    }
    $campos = "";
    $tipo_centro_id;


	$centros = "select distinct ca.id,ca.nom_ca as nombre_centro,ca.tipo_centro_id,tc.nombre as nombre_tipo_centro,tc.codigo from centro_atencion ca
	left join tipo_centro tc on(ca.tipo_centro_id=tc.id) ".$where." order by ca.tipo_centro_id desc";
	$centros = $modelo->executeQuery($centros);
  $modulo_html = "";
  $centro_html= "";
  $html ="";
  $html2 ="";
  $contar = 0;
	foreach ($centros as $key => $centro)
	{
	$centro_html ="<tr><th>Nombre del Centro</th><th>Tipo de Centro</th></tr>";
    $centro_html .="<tr><td>".$centro["NOMBRE_CENTRO"]."</td><td>".$centro["NOMBRE_TIPO_CENTRO"]." - ".$centro["CODIGO"]."</td></tr>";
    $campos = $this->campos_tipo_centro($centro["TIPO_CENTRO_ID"]);
    $orderby = $centro["TIPO_CENTRO_ID"]=="2"?"m.id asc":"m.parent_id asc";
	$modulos = "select m.parent_id,m.nombre as nombre_modulo,m.nombre_tabla from modulos m
	where m.centro_id in (".$centro["TIPO_CENTRO_ID"].") order by ".$orderby;
	$modulos = $modelo->executeQuery($modulos);
    $html ="";
    $contar = 0;
    $contar_modulos_2 = 1;
    $fasenombrerepite=array();
	foreach ($modulos as $key => $modulo)
	{
      $contar_modulos = 1;
      $nombretabla = "";
      $fasenombre ="";
      $fasenombrehtml ="";

      foreach ($campos as $key => $value) {
        if (isset(explode(" | ",$key)[0] ) ) {

          if (explode(" | ",$key)[1]==$modulo["NOMBRE_TABLA"]) {

            $nombretabla=explode(" | ",$key)[1];
            $valortabla=$value;
            $fasenombre=explode(" | ",$key)[0];
            if (!in_array($fasenombre,$fasenombrerepite)) {
              $fasenombrehtml = "<tr><td style='background-color:yellow;'>".$fasenombre."</td></tr>";
              $fasenombrerepite[]=$fasenombre;
            }
            break;
          }
        }
      }

      if (!empty($nombretabla) && $nombretabla!="" && !empty($modulo["NOMBRE_TABLA"]) && $modulo["NOMBRE_TABLA"]!="")
      {

        $modulo_html ="";
        $modulo_html .=$fasenombrehtml."<tr><td style='background-color:#DDA0DD' colspan='2'>".($contar_modulos_2).". ".$modulo["NOMBRE_MODULO"]."</td></tr>";
        $contar_modulos_2++;
        if (is_array($valortabla)) {
          foreach ($valortabla as $key => $value) {
            $grupos = "select ".$value.",residente_id from ".$modulo["NOMBRE_TABLA"]." where  periodo_mes=".date("n")." and periodo_anio=".date("Y")." and residente_id= ". $id_residente." and centro_id=".$centro["ID"]." order by id desc";
            $grupos = $modelo->executeQuery($grupos);
            $grupo_html = "";
            $residente_repite=array();
            foreach ($grupos as $key => $grupo)
            {
              if (!in_array($grupo["RESIDENTE_ID"],$residente_repite)) {
                if ($key==0) {
                  $keys = array_keys($grupo);
                  //$grupo_html .="<tr>";
                  foreach ($keys as $index=>$key)
                  {
                    if ($key != "RESIDENTE_ID") {
                      $grupo_html .="<tr><th style='border:1px solid;'>$key</th>";
                        $grupo_values = array_values($grupo);
                        //$grupo_html .= "<tr>";
                        foreach ($grupo_values as $key2 => $value) {
                          if($index==$key2){
                            $grupo_html .="<td style='border:1px solid;'>".$value."</td></tr>";
                            $contar++;

                            break;
                          }
                        }
                        $grupo_html .= "</tr>";
                    }
                  }
                  $grupo_html .="</tr>"."<tr><td></td></tr>";
                }
                $residente_repite[]=$grupo["RESIDENTE_ID"];
              }
            }
            if(empty($grupos)){
              $contar_modulos=1;
              $modulo_html = "";
              $grupo_html = "";
            }
            $html .= $modulo_html.$grupo_html;
          }
        }else {
        $grupos = "select ".$valortabla.",residente_id from ".$modulo["NOMBRE_TABLA"]." where  periodo_mes=".date("n")." and periodo_anio=".date("Y")." and residente_id= ". $id_residente." and centro_id=".$centro["ID"]." order by id desc";
          $grupos = $modelo->executeQuery($grupos);

          $grupo_html = "";
          $residente_repite=array();
          foreach ($grupos as $key => $grupo)
          {
            if (!in_array($grupo["RESIDENTE_ID"],$residente_repite)) {
              if ($key==0) {
                $keys = array_keys($grupo);
                //$grupo_html .="<tr>";
                foreach ($keys as $index=>$key)
                {
                  if ($key != "RESIDENTE_ID") {
                    $grupo_html .="<tr><th style='border:1px solid;'>$key</th>";
                      $grupo_values = array_values($grupo);
                      //$grupo_html .= "<tr>";
                      foreach ($grupo_values as $key2 => $value) {
                        if($index==$key2){
                          $grupo_html .="<td style='border:1px solid;'>".$value."</td></tr>";
                          $contar++;
                          break;
                        }
                      }
                      $grupo_html .= "</tr>";
                  }
                }
                $grupo_html .="</tr>"."<tr><td></td></tr>";
              }
              $residente_repite[]=$grupo["RESIDENTE_ID"];
            }
          }
          if(empty($grupos)){
            $contar_modulos =0;
            $modulo_html = "";
            $grupo_html = "";
          }
          $html .= $modulo_html.$grupo_html;
        }
      }

    }
    if ($contar==0) {
      $centro_html = "";
    }
    
    $html2 .=$centro_html.$html;
	}
  //$centro_html .=$modulo_html;
 //ob_start();
    $table = '<table id="geral_table">'.$html2.'</table>';
   // ob_end_clean();
    if ($modulos)
    {
      /*$file="descarga.xlsx";
      header("Content-type: application/octet-stream");
      header("Content-Disposition: attachment; filename=$file");
      echo $table;*/

      echo json_encode(array("data"=>$table) ) ;
    }else{
      return false;
    }
  }
  public function adjuntar_archivo(Type $var = null)
  {

	$upload_folder  = "/var/www/html/inabif/app/cargas/";

	$nombre_archivo = $_FILES['archivo']['name'];
	$tipo_archivo   = $_FILES['archivo']['type'];
	$tamano_archivo = $_FILES['archivo']['size'];
	$tmp_archivo    = $_FILES['archivo']['tmp_name'];
	$extension	= pathinfo($nombre_archivo, PATHINFO_EXTENSION);
	$result=[];
  $fichero_subido = $upload_folder . basename($nombre_archivo);
  $id_residente = $_POST["residente_id"];
  $tipo_documento = $_POST["tipo_documento"];
	if (move_uploaded_file($tmp_archivo, $fichero_subido))
	{
    $modelo = new modeloPortada();
    $valores = array("residente_id"=>$id_residente,"tipo_documento"=>$tipo_documento,"centro_id"=>$_SESSION["usuario"][0]["ID_CENTRO"],"tipo_centro_id"=>$_SESSION["usuario"][0]["TIPO_CENTRO_ID"],"nombre"=>$nombre_archivo,"ruta"=>$fichero_subido,"tipo"=>$extension,"tamano"=>$tamano_archivo,"fecha_creacion"=> date("y-M-d g.i.s"),"usuario_crea"=>$_SESSION["usuario"][0]["ID"],"usuario_edita"=>$_SESSION["usuario"][0]["ID"]);
    $res = $modelo->insertData('archivos_adjuntados',$valores);
    if ($res)
    {
      echo json_encode(array("resultado"=>true) ) ;
    }else{
      return false;
    }
	}
  }
  public function traer_tipo_centro_completado(){
    $modelo = new modeloPortada();
    $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
	  $sql = "select * from tipo_centro_estado where  Periodo_Mes = ".date("m") . " AND Periodo_Anio = ".date("Y");
    $res = $modelo->executeQuery($sql );

    if ($res){
      echo json_encode(array("data"=>$res) ) ;
    }else{
      return false;
    }

  }

  public function buscar_tipo_centro(){
    $modelo = new modeloPortada();
    $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
    $sql = "select * from tipo_centro_estado where tipo_centro_id=".$tipo_centro."  AND Periodo_Mes = ".date("m") . " AND Periodo_Anio = ".date("Y");
    $res = $modelo->executeQuery($sql );
    if ($res){
      echo json_encode(array("data"=>$res[0]) ) ;
    }else{
      return false;
    }
  }

  public function completar_tipo_centro(){
    $modelo = new modeloPortada();

    if($_SESSION["usuario"][0]["TIPO_CENTRO_ID"]){
      $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
      $estado = $_POST["estado"];
	    $sql = "select * from tipo_centro_estado where tipo_centro_id=".$tipo_centro."  AND Periodo_Mes = ".date("m") . " AND Periodo_Anio = ".date("Y");

      $res = $modelo->executeQuery($sql );

      if($res){

        $res2 = $modelo->updateData("tipo_centro_estado",array("estado"=>$estado),array("tipo_centro_id"=>$tipo_centro,"Periodo_Mes"=>date("m"),"Periodo_Anio"=>date("Y")));
      }else{

        $res2 = $modelo->insertData("tipo_centro_estado",array("estado"=>1,"tipo_centro_id"=>$tipo_centro,"Periodo_Mes"=>date("m"),"Periodo_Anio"=>date("Y"),"usuario_crea"=>$_SESSION["usuario"][0]["ID"],"usuario_edita"=>$_SESSION["usuario"][0]["ID"] ));

      }
      if ($res2){
        echo json_encode(array("resultado"=>true) ) ;
      }else{
        return false;
      }
    }else{
        return false;
      }




  }
  public function generar_matriz_consolidado(){
    $modelo = new modeloPortada();

       $sql = "select * from tipo_centro_estado where estado=0 AND Periodo_Mes = ".date("m") . " AND Periodo_Anio = ".date("Y");
      $res = $modelo->executeQuery($sql );
      if($res){
        echo json_encode(array("resultado"=>false, "mensaje"=>"No puede generar matriz hasta que todas las matrices de los tipos de centro estén generadas") ) ;
      }else{
        $res = $modelo->executeQuery("select * from matriz_consolidado where Periodo_Mes = ".date("m") . " AND Periodo_Anio = ".date("Y"));
      if($res){
        $res = $modelo->updateData( "matriz_consolidado",array("fecha_edicion"=>date("d-M-y g.i.s")),array("id"=>$res[0]["ID"]));

        if($res){
          echo json_encode(array("resultado"=>true, "mensaje"=>"La matriz ha sido actualizada"));
        }else{
          echo json_encode(array("resultado"=>false, "mensaje"=>"Ha ocurrido un error") ) ;
        }

      }else{
      $res = $modelo->insertData("matriz_consolidado",array("estado"=>1, "Fecha_Creacion"=>date("d-M-y g.i.s"), "Periodo_Mes"=>date("m"),"Periodo_Anio"=>date("Y"),"usuario_crea"=>$_SESSION["usuario"][0]["ID"],"usuario_edita"=>$_SESSION["usuario"][0]["ID"] ));
      if ($res){
      echo json_encode(array("resultado"=>true, "mensaje"=>"Matriz General Generada") ) ;
      }else{
      echo json_encode(array("resultado"=>false, "mensaje"=>"Ha ocurrido un error") ) ;
      }
      }

      }
    }
    public function buscar_fecha_matriz_general(){
      $modelo = new modeloPortada();
      $res = $modelo->executeQuery("select * from matriz_consolidado where Periodo_Mes = ".date("m") . " AND Periodo_Anio = ".date("Y"));
      if($res){
        echo json_encode(array("resultado"=>true, "fecha"=>$res[0]["FECHA_EDICION"]) );
      }else{
        echo json_encode(array("resultado"=>false, "mensaje"=>"Ha ocurrido un error") ) ;
      }
    }
  public function consulta_reniec(){
    $modelo = new modeloPortada();
    $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
    $dni = $_POST["dni"];
    $nivel = $_SESSION["usuario"][0]["NIVEL"];
    require VENDOR;
    try {
      $wsdlurl = "https://ws5.pide.gob.pe/services/ReniecConsultaDni";
     
      $file_get_contents = file_get_contents('https://ws5.pide.gob.pe/Rest/Reniec/Consultar?nuDniConsulta=76934495&nuDniUsuario=45050812&nuRucUsuario=20507920722&password=45050812');
      //$xml_to_array = json_decode(json_encode(simplexml_load_string($file_get_contents)), 1);
      print_r(($file_get_contents));
      print_r(simplexml_load_string('<?xml version=\'1.0\' encoding=\'UTF-8\'?><S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/"><S:Body><w:consultarResponse xmlns:w="http://ws.reniec.gob.pe/"><return><coResultado>0000</coResultado><datosPersona><apPrimer>POMA</apPrimer><apSegundo>SANTOS</apSegundo><direccion>CALLE S/N MZ.B LT.77 URB. LA CAPULLANA</direccion><estadoCivil>SOLTERO</estadoCivil><foto>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</foto><prenombres>MARIANO GERAL</prenombres><restriccion>NINGUNA</restriccion><ubigeo>LIMA/LIMA/SANTIAGO DE SURCO</ubigeo></datosPersona><deResultado>Consulta realizada correctamente</deResultado></return></w:consultarResponse></S:Body></S:Envelope>'));
     /* $client = new nusoap_client("https://ws5.pide.gob.pe/services/ReniecConsultaDni");
      $client->call("consultar",array("nuDniConsulta"=>76934495,"nuDniUsuario"=>45050812,"nuRucUsuario"=>20507920722,"password"=>45050812));

      $client = new nusoap_client("https://ws5.pide.gob.pe/services/ReniecConsultaDni?wsdl",true);
      $client->soap_defencoding = 'UTF-8';
      $client->decode_utf8 = FALSE;
      $result = $client->call("consultar",array("nuDniConsulta"=>76934495,"nuDniUsuario"=>45050812,"nuRucUsuario"=>20507920722,"password"=>45050812));*/
    
      } catch (SoapFault $exception) {
        echo $exception->getMessage();
      }
  }

}

