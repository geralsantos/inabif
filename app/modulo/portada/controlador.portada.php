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
          $campo = "cir.Numero_Doc ";
          $like = "dci.numero_documento_ingreso LIKE '%".$word."%'";
          $left_join = " left join pam_datosCondicionIngreso dci on (dci.residente_id=re.id) ";
        }else if($tipo_centro_id == NNA){
          $campo = "cir.Numero_Doc ";
          $like = "cir.Numero_Doc LIKE '%".$word."%'";
          $left_join = " left join NNACondicionIResidente cir on (cir.residente_id=re.id) ";
        }
        $sql = "SELECT * FROM (SELECT re.*,".$campo." as dni_residente  FROM Residente re ".$left_join."  WHERE (LOWER(re.Nombre) LIKE '%".$word."%' OR LOWER(re.APELLIDO_M) LIKE '%".$word."%' OR LOWER(re.APELLIDO_P) LIKE '%".$word."%' OR ".$like.") AND re.ESTADO=1 AND re.centro_id = ".$_SESSION["usuario"][0]["ID_CENTRO"]."  ORDER BY re.Id desc) WHERE ROWNUM<=10";
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
      $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
        if ($tipo_centro_id == PPD) {
          $campo = "nd.Numero_Documento ";
          $left_join = " left join CarCondicionIngreso nd on (nd.residente_id=re.id) ";
        }else if($tipo_centro_id == PAM){
          $campo = "cir.Numero_Doc ";
          $left_join = " left join pam_datosCondicionIngreso dci on (dci.residente_id=re.id) ";
        }else if($tipo_centro_id == NNA){
          $campo = "cir.Numero_Doc ";
          $left_join = " left join NNACondicionIResidente cir on (cir.residente_id=re.id) ";
        }
		  $sql = "SELECT re.*,".$campo." as dni_residente FROM Residente re ".$left_join." WHERE  re.ESTADO=1  AND re.centro_id = ".$_SESSION["usuario"][0]["ID_CENTRO"]." ORDER BY re.Id desc";
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
          $sql = "select distinct ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo,cad.fecha_cierre   from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where ca.id=".$_SESSION["usuario"][0]["CENTRO_ID"]." and ca.estado = 1";
        }else if($_SESSION["usuario"][0]["NIVEL"]==SUPERVISOR) //supervisor
        {
          $sql = "select distinct ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo,cad.fecha_cierre  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where tc.id=".$_SESSION["usuario"][0]["TIPO_CENTRO_ID"]." and ca.estado = 1";
        }else if($_SESSION["usuario"][0]["NIVEL"]==USER_SEDE_GESTION) //USER_SEDE_GESTIÓN
        {
          $sql = "select distinct ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo,cad.fecha_cierre  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where tc.id=".$_SESSION["usuario"][0]["TIPO_CENTRO_ID"]." and ca.estado = 1 ";
        }else if($_SESSION["usuario"][0]["NIVEL"]==ADMIN_CENTRAL) //ADMIN_CENTRAL
        {
          $sql = "select distinct ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo,cad.fecha_cierre  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where ca.estado = 1 ";
		}else if($_SESSION["usuario"][0]["NIVEL"]==USER_SEDE) //USER_SEDE
        {
          $sql = "select distinct ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo,cad.fecha_cierre  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where tc.id=".$_SESSION["usuario"][0]["TIPO_CENTRO_ID"]." and ca.estado = 1 ";
        }else if($_SESSION["usuario"][0]["NIVEL"]==REGISTRADOR) //USER_SEDE
        {
          $sql = "select distinct ca.id as id_centro,ca.NOM_CA as nombre_centro,cad.estado_completo,cad.fecha_cierre  from centro_atencion ca
          left join centro_atencion_detalle cad on (cad.centro_id=ca.id)
          left join tipo_centro tc on (ca.tipo_centro_id=tc.id)
          where ca.id=".$_SESSION["usuario"][0]["CENTRO_ID"]." and ca.estado = 1 ";
        }

        $res = $modelo->executeQuery($sql);
        if ($res)
        {
          echo json_encode(array("data"=>$res,"nivel_usuario"=>$_SESSION["usuario"][0]["NIVEL"]) ) ;
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
    $sql = "";
    $res = $modelo->insertData("modulos_detalle",array("modulo_id"=>$_POST["id_modulo"],"estado_completo"=>1,"Periodo_Mes"=>date("m"),"Periodo_Anio"=>date("Y"),"usuario_crea"=>$_SESSION["usuario"][0]["ID"],"usuario_edita"=>$_SESSION["usuario"][0]["ID"] ));

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
      $sql = "select distinct m.nombre as modulo_nombre,m.id as id_modulo, m.encargado_id,usu.nombre as encargado_nombre, md.estado_completo,md.fecha_edicion,m.nombre_tabla from modulos m
      left join modulos_detalle md on (md.modulo_id=m.Id)
      left join usuarios usu on (usu.id = m.encargado_id)
      left join centro_atencion ca on (ca.tipo_centro_id=m.centro_id)
      where ca.id = ".$id_centro." order by m.id desc";

    $res = $modelo->executeQuery($sql );
    if ($res)
    {
      echo json_encode(array("data"=>$res,"nivel_usuario"=>$_SESSION["usuario"][0]["NIVEL"]) ) ;
    }else{
      return false;
    }
  }
  public function mostrar_modulo(){
    $modelo = new modeloPortada();
    $nombre_tabla = $_POST["nombre_tabla"];
    $sql = "select * from ".$nombre_tabla." where  to_char(fecha_creacion, 'MON-YY') =UPPER('".date("M-y")."')";

    $res = $modelo->executeQuery($sql );
    if ($res)
    {
      echo json_encode(array("data"=>$res) ) ;
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

	if (SUPERVISOR == $nivel || USER_SEDE == $nivel || RESPONSABLE_INFORMACION == $nivel || ADMIN_CENTRAL == $nivel || USER_CENTRO == $nivel) {
		$tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
		$where = "ca.tipo_centro_id = ".$tipo_centro;
	}else{
		$id_centro = $_SESSION["usuario"][0]["CENTRO_ID"];
		$where = "ca.id = ".$id_centro;
	}
    $periodo = $_POST["periodo"];
    if ($periodo=="mensual") {
      $fecha = " = UPPER('".date("y-M")."') ";
    }else {
      if (floatval(date("m")) <= 6 ) {
        $semestral = "'".date("y")."-JAN' AND '".date("y")."-JUN'";
      }else{
        $semestral = "'".date("y")."-JUL' AND '".date("y")."-DEC'";
      }
      $fecha = " BETWEEN $semestral ";
    }
    $matrices = "select ca.nom_ca as nombre_centro, cad.fecha_matriz, cad.ID  from centro_atencion_detalle cad
      left join centro_atencion ca on(ca.id=cad.centro_id)  where ".$where." and to_char(cad.fecha_matriz,'YY-MON') ".$fecha." order by cad.id desc";
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
    $periodo = $_POST["periodo"];
    $matriz_id = $_POST["matriz_id"];

    if ($periodo=="mensual") {
      $fecha = " md.periodo_mes = ".date("m")." ";
    }else {
      if (floatval(date("m")) <= 6 ) {
        $semestral = " md.periodo_mes >= 1 AND md.periodo_mes <= 6 ";
      }else{
        $semestral = " md.periodo_mes >= 7 AND md.periodo_mes <= 12 ";
      }
      $fecha = " BETWEEN $semestral ";
    }
    $centro_html = "<table>";
    $centro_html .="<tr><th>Nombre del Centro</th><th>Tipo de Centro</th><th>Fecha Matriz </th></tr>";

    $centros = "select distinct ca.nom_ca as nombre_centro,ca.tipo_centro_id,tc.nombre as nombre_tipo_centro,cad.fecha_matriz from centro_atencion_detalle cad
    left join centro_atencion ca on(ca.id=cad.centro_id)
    left join tipo_centro tc on(ca.tipo_centro_id=tc.id)
      where cad.id = ".$matriz_id."  order by cad.id desc";
    $centros = $modelo->executeQuery($centros);

    $centro_html .="<tr><th>".$centros[0]["NOMBRE_CENTRO"]."</th><th>".$centros[0]["NOMBRE_TIPO_CENTRO"]."</th><th>".$centros[0]["FECHA_MATRIZ"]."</th></tr></table>";

    $modulo_html = "<table>";
    $modulos = "select m.parent_id,m.nombre as nombre_modulo,usu.nombre as nombre_usuario,md.periodo_mes,m.nombre_tabla from modulos_detalle md
    left join modulos m on(m.id=md.modulo_id)
    left join usuarios usu on(usu.id=m.encargado_id)
      where m.centro_id in (".$centros[0]["TIPO_CENTRO_ID"].") and ".$fecha." and md.periodo_anio = ".date("Y")." order by md.id desc";
    $modulos = $modelo->executeQuery($modulos);

    foreach ($modulos as $key => $modulo)
    {
		if (($modulo["NOMBRE_TABLA"])!="") {
			$modulo_html .="<tr><th></th><th>Nombre del Modulo</th><th>Encargado</th><th>Periodo Mes</th></tr>";
			$modulo_html .="<tr><td></td><td>".$modulo["NOMBRE_MODULO"]."</td><td>".$modulo["NOMBRE_USUARIO"]."</td><td>".$modulo["PERIODO_MES"]."</td></tr>";

			$grupos = "select distinct * from ".$modulo["NOMBRE_TABLA"]." order by id desc";
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
  public function mostrar_reporte_rub(){
    $modelo = new modeloPortada();
    $tipo_centro = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
    $fecha = " BETWEEN UPPER('".$_POST["fecha_inicial"]."') AND UPPER('".$_POST["fecha_final"]."')";

    if (USER_CENTRO == $nivel || SUPERVISOR == $nivel || RESPONSABLE_INFORMACION == $nivel) {
      $tipo_centro = $_SESSION["usuario"][0]["CENTRO_ID"];
      $where = "ca.id = ".$tipo_centro;
    }else{
      $tipo_centro_id = $_SESSION["usuario"][0]["TIPO_CENTRO_ID"];
      $where = "ca.tipo_centro_id = ".$tipo_centro_id;
    }

    $residentes = "select  re.nombre as nombre_residente,re.apellido_p,re.apellido_m,re.fecha_creacion as fecha 
    from residente re
    inner join centro_atencion ca on (re.centro_id=ca.id) 
	  inner join tipo_centro tc on(tc.id=re.tipo_centro_id) 
	  where to_char(re.fecha_creacion,'DD-MON-YY') ".$fecha." and ".$where." order by re.id desc";
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
	$residente_html = "";
	foreach ($residentes as $key => $value) {
		$residente_html .="<tr><td>".$value["NOMBRE_RESIDENTE"]."</td><td>".$value["APELLIDO_P"]."</td><td>".$value["APELLIDO_M"]."</td><td>".$value["NOMBRE_PAIS"]."</td><td>".$value["NOMBRE_DEPARTAMENTO"]."</td><td>".$value["NOMBRE_PROVINCIA"]."</td><td>".$value["NOMBRE_DISTRITO"]."</td><td>".$value["SEXO_RESIDENTE"]."</td><td>".$value["FECHA"]."</td></tr>";
	}
    $table = '<table><thead><tr><th>Nombre del Residente</th><th>Apellido Paterno</th><th>Apellido Materno</th><th>País</th><th>Departamento Nacimiento</th><th>Provincia Nacimiento</th><th>Distrito Nacimiento</th><th>Sexo</th><th>Fecha Registro</th></tr></thead><tbody>'.$residente_html.'</tbody></table>';

    if ($residentes)
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
	where re.id = ".$id_residente." order by re.id desc";
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
  $id_residente = $_POST["id_residente"];
	if (move_uploaded_file($tmp_archivo, $fichero_subido))
	{
    $modelo = new modeloPortada();
    $valores = array("id_residente"=>$id_residente,"centro_id"=>$_SESSION["usuario"][0]["ID_CENTRO"],"tipo_centro_id"=>$_SESSION["usuario"][0]["TIPO_CENTRO_ID"],"nombre"=>$nombre_archivo,"ruta"=>$fichero_subido,"tipo"=>$extension,"tamano"=>$tamano_archivo,"fecha_creacion"=> date("y-M-d g.i.s"),"usuario_crea"=>$_SESSION["usuario"][0]["ID"],"usuario_edita"=>$_SESSION["usuario"][0]["ID"]);
    $res = $modelo->insertData('archivos_adjuntados',$valores);
    if ($res)
    {
      echo json_encode(array("resultado"=>true) ) ;
    }else{
      return false;
    }
	}
  }
}
