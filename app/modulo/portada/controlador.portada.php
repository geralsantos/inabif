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
          $left_join = " left join CarCondicionIngreso nd on (nd.residente_id=re.id) ";
        }else if($tipo_centro_id == PAM){
          $campo = "dci.numero_documento_ingreso ";
          $like = "dci.numero_documento_ingreso LIKE '%".$word."%'";
          $left_join = " left join pam_datosCondicionIngreso dci on (dci.residente_id=re.id) ";
        }else if($tipo_centro_id == NNA){
          $campo = "cir.Numero_Doc ";
          $like = "cir.Numero_Doc LIKE '%".$word."%'";
          $left_join = " left join NNACondicionIResidente cir on (cir.residente_id=re.id) ";
        }
        $codigolike="";
        if (is_numeric($word)) {
          $codigolike = " OR re.id ='".$word."'";
        }
        $sql = "SELECT * FROM (SELECT DISTINCT re.*, ".$campo." as dni_residente  FROM Residente re ".$left_join."  WHERE (LOWER(re.Nombre) LIKE '%".$word."%' OR LOWER(re.APELLIDO_M) LIKE '%".$word."%' OR LOWER(re.APELLIDO_P) LIKE '%".$word."%' OR ".$like.$codigolike." ) AND re.ESTADO=1 AND re.centro_id = ".$_SESSION["usuario"][0]["ID_CENTRO"]."  ORDER BY re.Id desc) WHERE ROWNUM<=10";
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
      $nivel = $_SESSION["usuario"][0]["NIVEL"];
			if (SUPERVISOR == $nivel || USER_SEDE == $nivel) {
				$tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
				$where = " AND tipo_centro_id = ".$tipo_centro;
			}else if (REGISTRADOR ==$nivel || RESPONSABLE_INFORMACION ==$nivel){
				$centro_id = $_SESSION["usuario"][0]["CENTRO_ID"];
				$where = " AND centro_id = ".$centro_id;
			}else if(ADMIN_CENTRAL == $nivel || USER_SEDE_GESTION == $nivel){
				$where ="";
			}
			$sql = "SELECT * FROM (SELECT * FROM Residente WHERE (Nombre LIKE '%".$_POST['like']."%' OR APELLIDO_M LIKE '%".$_POST['like']."%' OR APELLIDO_P LIKE '%".$_POST['like']."%' OR Documento LIKE '%".$_POST['like']."%') AND ESTADO=1 ".$where." ORDER BY Id desc) WHERE ROWNUM<=10";
			$res = $modelo->executeQuery( $sql );
			if ($res) {
			echo json_encode(array( "data"=>$res )) ;
			}else{
			return false;
			}

		 }
	  }
	public function ejecutar_consulta_lista(){
      $modelo = new modeloPortada();
      echo $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
        if ($tipo_centro_id == PPD) {
          $campo = "nd.Numero_Documento ";
          $left_join = " left join CarCondicionIngreso nd on (nd.residente_id=re.id) ";
        }else if($tipo_centro_id == PAM){
          $campo = "dci.numero_documento_ingreso ";
          $left_join = " left join pam_datosCondicionIngreso dci on (dci.residente_id=re.id) ";
        }else if($tipo_centro_id == NNA){
          $campo = "cir.Numero_Doc ";
          $left_join = " left join NNACondicionIResidente cir on (cir.residente_id=re.id) ";
        }
		  $sql = "SELECT max(re.id) as id,max(re.nombre) as nombre,max(re.apellido_p) as apellido_p,max(re.apellido_m) as apellido_m,max(".$campo.") as dni_residente FROM Residente re ".$left_join." WHERE  re.ESTADO=1  AND re.centro_id = ".$_SESSION["usuario"][0]["ID_CENTRO"]." group by re.id ORDER BY re.Id desc";
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
          $sql = "select distinct ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo, cad.fecha_matriz, cad.id, cad.fecha_cierre   from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where ca.id=".$_SESSION["usuario"][0]["CENTRO_ID"]." and ca.estado = 1 AND rownum = 1 ORDER BY cad.id desc";
        }else if($_SESSION["usuario"][0]["NIVEL"]==ADMIN_CENTRAL) //ADMIN_CENTRAL
        {
          $sql = "select max(ca.id) as id_centro,max(ca.NOM_CA ) as nombre_centro,max(cad.estado_completo) as estado_completo, max(cad.fecha_matriz) as fecha_matriz,
          max(cad.fecha_cierre) as fecha_cierre, cad.id  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where ca.estado = 1 group by ca.id order by ca.id desc";
		    }else if($_SESSION["usuario"][0]["NIVEL"]==USER_CENTRO) //USER CENTRO: SOLO VE SU SEDE ASIGNADA
        {
          $sql = "select distinct ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo, cad.fecha_matriz,
          cad.id, cad.fecha_cierre  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where ca.id=".$_SESSION["usuario"][0]["CENTRO_ID"]." and ca.estado = 1 AND rownum = 1 ORDER BY cad.id desc";
		    }else if($_SESSION["usuario"][0]["NIVEL"]==SUPERVISOR) //SUPERVISOR VE TODAS LAS SEDES DE SU TIPO DE CENTRO
        {
          $sql = "select max(ca.id) as id_centro,max(ca.NOM_CA ) as nombre_centro,max(cad.estado_completo) as estado_completo, max(cad.fecha_matriz) as fecha_matriz,
         max(cad.fecha_cierre) as fecha_cierre  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where tc.id=".$_SESSION["usuario"][0]["TIPO_CENTRO_ID"]." and ca.estado = 1 group by ca.id order by ca.id desc";
        }else if($_SESSION["usuario"][0]["NIVEL"]==USER_SEDE_GESTION) //USER_SEDE_GESTIÓN
        {
          /*$sql = "select distinct ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo, cad.fecha_matriz, cad.fecha_cierre  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
		  where tc.id=".$_SESSION["usuario"][0]["TIPO_CENTRO_ID"]." and ca.estado = 1 ";*/
		  $sql = "select max(ca.id) as id_centro,max(ca.NOM_CA ) as nombre_centro,max(cad.estado_completo) as estado_completo, max(cad.fecha_matriz) as fecha_matriz, max(cad.fecha_cierre) as fecha_cierre from centro_atencion ca left join centro_atencion_detalle cad on (cad.centro_id=ca.id) left join tipo_centro tc on (ca.tipo_centro_id=tc.id) where ca.estado = 1 group by ca.id order by ca.id desc";
        }else if($_SESSION["usuario"][0]["NIVEL"]==USER_SEDE) //USER_SEDE
        {
          $sql = "select max(ca.id) as id_centro,max(ca.NOM_CA ) as nombre_centro,max(cad.estado_completo) as estado_completo, max(cad.fecha_matriz) as fecha_matriz, max(cad.fecha_cierre) as fecha_cierre  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where tc.id=".$_SESSION["usuario"][0]["TIPO_CENTRO_ID"]." and ca.estado = 1 group by ca.id order by ca.id desc";
        }else if($_SESSION["usuario"][0]["NIVEL"]==REGISTRADOR) //REGISTRADOR
        {
          $sql = "select distinct ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo, cad.fecha_matriz, cad.id, cad.fecha_cierre  from centro_atencion ca
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
	$fecha = " BETWEEN UPPER('".$_POST["fecha_inicial"]."') AND UPPER('".$_POST["fecha_final"]."')";
   /* $fecha = " BETWEEN UPPER('".$_POST["fecha_inicial"]."') AND UPPER('".$_POST["fecha_final"]."')";
	$residentes = "select distinct re.id, re.nombre as nombre_residente, re.apellido_p, re.apellido_m, pa.nombre as nombre_pais , ubi.NOMDEPT as nombre_departamento, ubi.nomprov as nombre_provincia, ubi.nomdist as nombre_distrito, (CASE sexo WHEN 'h' THEN 'Hombre' ELSE 'Mujer' END) as sexo_residente ,re.fecha_creacion as fecha from residente re
	inner join tipo_centro tc on(tc.id=re.tipo_centro_id)
	".$innner_centro_atencion."
	inner join paises pa on(pa.id=re.pais_id)
	inner join ubigeo ubi on(ubi.coddist=re.distrito_naci_cod)
	where to_char(re.fecha_creacion,'DD-MON-YY') ".$fecha." AND ".$filtro_centro." ";
	$residentes = $modelo->executeQuery($residentes);*/
  $residente_html = "";
  $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
    switch ($tipo_centro_id) {
		case '1': /*ppd*/
		$parent_id="2,25";
		/*$campos = array("CarCentroServicio"=>"COD_ENTIDAD,NOM_ENTIDAD as ENTIDAD,COD_LINEA,LINEA_INTERVENCION,COD_SERVICIO,NOM_SERVICIO,UBIGEO_INE as UBIGEO_CA,(select NOMDEPT,NOMPROV,NOMDIST from ubigeo where CODDIST=CarCentroServicio.UBIGEO_INE) as UBIGEO_TODO,CENTRO_POBLADO as CCPP_CA,CENTRO_RESIDENCIA as AREA_RES_CA,COD_CENTROATENCION as COD_CA,NOM_CENTROATENCION AS NOM_CA,re.id as COD_RESIDENTE,re.NOMBRE AS NOM_RESIDENTE, re.apellido_pd AS APE_PAT_RESIDENTE, re.apellido_m as APE_MAT_RESIDENTE, ");*/
		/*$campos = "cs.COD_ENTIDAD,cs.NOM_ENTIDAD as ENTIDAD,cs.COD_LINEA,cs.LINEA_INTERVENCION,cs.COD_SERVICIO,cs.NOM_SERVICIO,cs.UBIGEO_INE as UBIGEO_CA,(select NOMDEPT,NOMPROV,NOMDIST from ubigeo where CODDIST=cs.UBIGEO_INE) as UBIGEO_TODO,cs.CENTRO_POBLADO as CCPP_CA,cs.CENTRO_RESIDENCIA as AREA_RES_CA,cs.COD_CENTROATENCION as COD_CA,cs.NOM_CENTROATENCION AS NOM_CA,re.id as COD_RESIDENTE,re.NOMBRE AS NOM_RESIDENTE, re.apellido_pd AS APE_PAT_RESIDENTE, re.apellido_m as APE_MAT_RESIDENTE, ci.Tipo_Documento as TIP_DOC_USU, ci.Numero_Documento as NRO_DOC_USU,iu.Fecha_Nacimiento as FEC_NAC_RESIDENTE, iu.Edad as EDAD_RESIDENTE, iu.Sexo as SEXO_RESIDENTE, '' as DIR_USU, re.distrito_naci_cod as UBIGEO_USU,(select NOMDEPT,NOMPROV,NOMDIST from ubigeo where CODDIST=re.distrito_naci_cod) as UBIGEO_USU,ci.FECHA_CREACION as FEC_INGRESO, '' as PERFIL_ING,da.Institucion_derivado as VIA_ING, sn.Discapacidad as FLG_DISCAP, re.Estado as EST_RESIDENTE,eg.Fecha_Egreso as FEC_EGRE, eg.Motivo_Egreso as MOTIVO_EGRE, da.Fecha_Reingreso as FEC_REING, '' as Grupo etario,eg.Traslado as TRASLADO, eg.Fallecimiento as FALLECIMIENTO,eg.Reinsercion AS Reinsercion, eg.Aus as ASEGURAMIENTO_UNIVERSAL, eg.Constancia_Naci as PARTIDA_DE_NACIMIENTO, eg.DNI AS DNI,'' as EDUCACION ,eg.Reinsercion AS Reinsercion_Familiar ";
		$from = " residente re inner join CarCentroServicio cs on (re.id = cs.residente_id ) left join CarCondicionIngreso ci on (ci.Residente_Id=re.id) left join CarIdentificacionUsuario iu on (iu.Residente_Id=re.id) left join CarDatosAdmision da on (da.Residente_Id=re.id) left join CarSaludNutricion sn on (sn.Residente_Id=re.id) left join CarEgresoGeneral eg on (eg.Residente_Id=re.id)";*/
		$campos = "cs.COD_ENTIDAD,cs.NOM_ENTIDAD as ENTIDAD,cs.COD_LINEA,cs.LINEA_INTERVENCION,cs.COD_SERVICIO,cs.NOM_SERVICIO,cs.UBIGEO_INE as UBIGEO_CA,cs.CENTRO_POBLADO as CCPP_CA,cs.CENTRO_RESIDENCIA as AREA_RES_CA,cs.COD_CENTROATENCION as COD_CA,cs.NOM_CENTROATENCION AS NOM_CA,re.id as COD_RESIDENTE,re.NOMBRE AS NOM_RESIDENTE, re.apellido_p AS APE_PAT_RESIDENTE, re.apellido_m as APE_MAT_RESIDENTE, ci.Tipo_Documento as TIP_DOC_USU, ci.Numero_Documento as NRO_DOC_USU,iu.Fecha_Nacimiento as FEC_NAC_RESIDENTE, iu.Edad as EDAD_RESIDENTE, iu.Sexo as SEXO_RESIDENTE, '' as DIR_USU, re.distrito_naci_cod as UBIGEO_USU,ci.FECHA_CREACION as FEC_INGRESO, '' as PERFIL_ING,da.Institucion_derivado as VIA_ING, sn.Discapacidad as FLG_DISCAP, re.Estado as EST_RESIDENTE,eg.Fecha_Egreso as FEC_EGRE, eg.Motivo_Egreso as MOTIVO_EGRE, da.Fecha_Reingreso as FEC_REING, '' as Grupo_etario,eg.Traslado as TRASLADO, eg.Fallecimiento as FALLECIMIENTO,eg.Reinsercion AS Reinsercion, eg.Aus as ASEGURAMIENTO_UNIVERSAL, eg.Constancia_Naci as PARTIDA_DE_NACIMIENTO, eg.DNI AS DNI,'' as EDUCACION ,eg.Reinsercion AS Reinsercion_Familiar ";
		$from = " residente re left join CarCentroServicio cs on (re.id = cs.residente_id ) left join CarCondicionIngreso ci on (ci.Residente_Id=re.id) left join CarIdentificacionUsuario iu on (iu.Residente_Id=re.id) left join CarDatosAdmision da on (da.Residente_Id=re.id) left join CarSaludNutricion sn on (sn.Residente_Id=re.id) left join CarEgresoGeneral eg on (eg.Residente_Id=re.id)";
		break;
		case '2': /*pam*/
		$parent_id="27,43";
		break;
		case '3':
		$parent_id="46,70";
		break;
		default:
		$parent_id="2,25";
			break;
	}
	$where = " WHERE to_char(da.fecha_edita,'DD-MON-YY') ".$fecha." AND to_char(eg.fecha_egreso,'DD-MON-YY') ".$fecha;
	$query = "SELECT distinct ".$campos." FROM ".$from;
	$residentes = $modelo->executeQuery($query);
	$head_html = "";
	$body_html = "";
	foreach ($residentes as $key => $value) {
		if ($key==0) {
            $keys = array_keys($value);
            $head_html .="<tr>";
            foreach ($keys as $key)
            {
              $head_html .="<th>$key</th>";
            }
            $head_html .="</tr>";
          }else {
			$body_html .="<tr>";
			$keys = array_keys($value);
            foreach ($keys as $key)
            {
              $body_html .="<td>".$value[$key]."</td>";
			}
			$body_html .="</tr>";
		  }

	}
    $table = '<table><thead>'.$head_html.'</thead><tbody>'.$body_html.'</tbody></table>';
    if ($body_html)
    {
      echo json_encode(array("data"=>$table) ) ;
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
  public function descargar_reporte_matriz_nominal(){
    $modelo = new modeloPortada();
    $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
    $id_residente = $_POST["id_residente"];
    $tipo_centro_id = $_POST["tipo_centro_id"];
    switch ($tipo_centro_id) {
		case '1': /*ppd*/
		$parent_id="2,25";
		break;
		case '2': /*pam*/
		$parent_id="27,43";
		break;
		case '3':
		$parent_id="46,70";
		break;
		default:
		$parent_id="2,25";
			break;
	}
	$centro_html="";
    $modulo_html = "<table>";
	$modulos = "select m.nombre as nombre_modulo,m.nombre_tabla
	from modulos m
    where m.centro_id in (".$tipo_centro_id.") and m.parent_id  in (".$parent_id.") order by m.id desc";
    $modulos = $modelo->executeQuery($modulos);

    foreach ($modulos as $key => $modulo)
    {
		$modulo_html .="<tr><th></th><th>Nombre del Modulo</th></tr>";
		$modulo_html .="<tr><td></td><td>".$modulo["NOMBRE_MODULO"]."</td></tr>";

		$grupos = "select distinct * from ".$modulo["NOMBRE_TABLA"]." where residente_id= ". $id_residente." order by id desc";
		$grupos = $modelo->executeQuery($grupos);

		$grupo_html = "<table>";
      foreach ($grupos as $key => $grupo)
      {
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
	  }
      $modulo_html .=$grupo_html;
    }
    $modulo_html .="</table>";
    $table = '<table><tr><td>'.$centro_html.'</td></tr><tr><td>'.$modulo_html.'</td></tr></table>';

    if ($modulos)
    {
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
	$extension		= pathinfo($nombre_archivo, PATHINFO_EXTENSION);
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
        echo json_encode(array("resultado"=>false, "mensaje"=>"La matriz ya ha sido generada", "fecha"=>$res[0]["FECHA_CREACION"]) );
      }else{
        $res = $modelo->insertData("matriz_consolidado",array("estado"=>1, "Fecha_Creacion"=>date("d-M-y g.i.s"), "Periodo_Mes"=>date("m"),"Periodo_Anio"=>date("Y"),"usuario_crea"=>$_SESSION["usuario"][0]["ID"],"usuario_edita"=>$_SESSION["usuario"][0]["ID"] ));
        if ($res){
          echo json_encode(array("resultado"=>true) ) ;
        }else{
          echo json_encode(array("resultado"=>false, "mensaje"=>"Ha ocurrido un error") ) ;
        }
      }

    }


  }


}
