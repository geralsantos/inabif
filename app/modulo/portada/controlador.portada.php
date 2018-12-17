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
    public function cargar_datos_all_pantalla_principal(){

      if( $_POST['tabla'] && $_POST['where'] ){
        $modelo = new modeloPortada();
        $_POST['where']["estado"] = ["estado",1];
        $res = $modelo->selectRowDataAll( $_POST['tabla'], $_POST['campos'], $_POST['where'], $_POST['groupby'] );
        if ($res) {
          echo json_encode(array("atributos"=>$res )) ;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }
    public function cargar_datos_all(){

      if( $_POST['tabla'] && $_POST['where'] ){
        $modelo = new modeloPortada();

        $_POST['where']["estado"] = ["estado",1];
        $res = $modelo->selectDataAll( $_POST['tabla'], $_POST['where'] );
        if ($res) {
          echo json_encode(array("atributos"=>$res )) ;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }

    public function insertar_datos_x(){

      if( $_POST['tabla'] && $_POST['campos'] ){

        $modelo = new modeloPortada();
        $res = $modelo->insertData( $_POST['tabla'], $_POST['campos'] );

        if ($res) {
          echo json_encode(array("resultado"=>true )) ;
        }else{
          return false;
        }
      }

    }

     public function cargar_datos_groupby(){

      if( $_POST['tabla'] ){
        $modelo = new modeloPortada();
        $where = !isset($_POST["where"]) ? '' : $_POST["where"];
        $_POST['where']["estado"] = 1;
        $res = $modelo->selectRowDataAll( $_POST['tabla'], $_POST['campos'], $where, $_POST['groupby'] );

        if ($res) {
          $arr = array();
          $personas = array();
          foreach ($res as $key => $value) {
            $arr[]=$value["servicios"];
          }
          $arr = array_count_values($arr);
          $rr = [];
          foreach ($arr as $key => $value) {
            $rr[]= array("personas"=>floatval($value),"servicios"=>$key);
          }
          echo json_encode(array("atributos"=>$rr)) ;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }
    public function cargar_datos_all_admin(){

      if( $_POST['tabla'] && $_POST['where'] ){
        $modelo = new modeloPortada();
        $_POST['where']["estado"] = ["estado",1];
        $res = $modelo->selectDataAll( $_POST['tabla'], $_POST['where'] );
        if ($res) {
          $result = [];$before_turno_1=0;$before_turno_2=0;$before_date='';$count=[];
         //print_r(($res));die();
          foreach ($res as $key => $value) {
            $date = date("n",strtotime($value["fecha"]));
            $result[$date] = array("mes"=> $date, "turno_1"=>($value["turno_1"]+$before_turno_1), "turno_2"=>($value["turno_2"]+$before_turno_2),"incidentes_resueltos"=>($value["incidentes_resueltos"]), "incidentes_identificados"=>($value["incidentes_identificados"]),"incidentes_resueltos_t2"=>($value["incidentes_resueltos_t2"]), "incidentes_identificados_t2"=>($value["incidentes_identificados_t2"]),"count"=>(!isset($count[$date])?1:($count[$date]+1)));
            $before_turno_1=$before_date ==""? $value["turno_1"] : ($before_date == $date ? ($value["turno_1"]+$before_turno_1) : 0);
            $before_turno_2=$before_date ==""? $value["turno_2"] : ($before_date == $date ? ($value["turno_2"]+$before_turno_2) : 0);
            $before_date = $date;
            $count[$date] = !isset($count[$date])?1:($count[$date]+1);
          }
          $arr=[];
          foreach ($result as $key => $value) {
            $arr[] = $value;
          }
          echo json_encode(array("atributos"=>$arr )) ;
        }else{
          return false;
        }
      }else{
        return false;
      }

    }
    /*public function cargar_datos_sqlserver(){

        $modelo = new modeloPortada();
        $mes = date('n');

        $semestre = $mes>6 ? 2 :1 ;
        $where = array("Estado"=>array("Estado","Activo"));
        $campos = array('Todo'=>'count(*) as total_cantidad');
        $fecha = date('Y-m-d H:i:s');

        $groupby='';
        $tickets_totales = $modelo->selectRowDataAll( 'kpi_asistencia_personal', $campos, $where, $groupby );
        if ($tickets_totales) {
          $result = $tickets_totales[0]["total_cantidad"];
          $campos_insert = array("total_personal"=>$result,"fecha_modificacion"=>$fecha);
          $modelo->updateDataAll('kpi_indicador_ref19',$campos_insert,array("anio"=>array('anio',date('Y',strtotime($fecha) ) ),'semestre'=>array('semestre',$semestre) ) );
        }else{
          return false;
        }
    }*/
    public function cargar_excel(){
      if ($_SESSION["usuario"][0]["kpi_roles_id"] == '2') {
        $modelo = new modeloPortada();
      $res = json_decode(archivoExcel(),true);$response=true;
      if ($res["Error"]=="") {
        $anio = ($_POST["anio"]);
        $mes = ($_POST["mes"]);
        $exist_delete = $modelo->deleteData("kpi_indicador_ref104",array("anio"=>$anio,"mes"=>$mes));
        $Cabeceras = ["llamadas_accesadas_ivr","llamadas_recibidas","llamadas_atendidas","llamadas_atendidas_seg","llamadas_abandonadas","nivel_servicio","nivel_atencion","TMO","tiempo_total_ivr"];
        $x=0;
        $fecha = date('Y-m-d H:i:s');
        $usuario = $_SESSION["usuario"][0]["id"];
        $campos_auditoria = array("dia"=>"dia","anio"=>$anio,"mes"=>$mes,"fecha_creacion"=>$fecha,"fecha_modificacion"=>$fecha,"kpi_usuario_registro"=>$usuario,"kpi_usuario_modificacion"=>$usuario);
        $data = $res["Success"];
        $values=[];$Cabeceras_new=[];$values_excel=[];
        foreach ($data as $key_row => $row) {
          $campos_insert=[];$campos_insert_data=[];
          foreach ($row as $key_column => $column) {
            if ($Cabeceras[$key_column]=="nivel_servicio" || $Cabeceras[$key_column]=="nivel_atencion") {
              $column[1] = $column[1] * 100;
            }
            if ($key_row==0) {
              $Cabeceras_new[] = $Cabeceras[$key_column];
            }

            $campos_insert[]=round($column[1],1);
            $campos_insert_data[]=round($column[1],1);
            if ((count($row)-1)==$key_column) {
              foreach ($campos_auditoria as $key => $value) {
                if ($value=="dia") {
                  $value =$key_row+1;
                }
                $campos_insert[] ='"'.$value.'"';
                $campos_insert_data[] =$value;
              }
            }

          }
          if ($key_row==0) {
            foreach (array_keys($campos_auditoria) as $key => $value) {
              $Cabeceras_new[] = $value;
            }
          }
          $values_excel[]=$campos_insert_data;
          $values[]='('.implode(',',$campos_insert).')';
        }
        //campos de auditoria
        $insert = $modelo->insertDataMasivo("kpi_indicador_ref104",$Cabeceras_new,$values);
        if (!$insert) {
          $response = false;
        }else{
          $response = true;
        }
        //$campos_insert = array("llamadas_recibidas"=>$response,"fecha"=>$fecha,"fecha_creacion"=>$fecha);

      }else{
        $response=false;
      }

      echo json_encode(array("resultado"=>$response));
      }else{
        echo json_encode(array("resultado"=>false, "mensaje"=>"No posee permisos para cargar este excel" ));
      }

    }
    public function cargar_datos_union(){

      if( $_POST['consulta'] ){
        $modelo = new modeloPortada();


        $query = " ". $_POST['consulta'] . " UNION ALL " . $_POST['consulta_2'];
        $res = $modelo->executeQuery($query  );
        if ($res) {
          echo json_encode(array("data"=>$res)) ;
        }else{
          return false;
        }
     }

    }
    public function cargar_datos_fecha(){

      if( $_POST['consulta'] ){
        $modelo = new modeloPortada();


        $query = " ". $_POST['consulta'] . " UNION ALL " . $_POST['consulta_2'];

        $res = $modelo->executeQuery($query  );
        if ($res) {
          foreach ($res as $value) {
            if ( $value["tipo"] == '1' ){
              $val = a_romano($value["trimestre"]);
              if( $value["trimestre"] == '1' ){
                $data["trimestre_1"]["programados"] = floatval($value["cantidad"]);
                 $data["trimestre_1"]["category"] = 'Trimestre ' . $val;
                 $data["trimestre_1"]["trimestre"] = $value["trimestre"];

               }
              if( $value["trimestre"] == '2' ){
                $data["trimestre_2"]["programados"] = floatval($value["cantidad"]);
                 $data["trimestre_2"]["category"] = 'Trimestre ' . $val;
                 $data["trimestre_2"]["trimestre"] = $value["trimestre"];
              }
              if( $value["trimestre"] == '3' ){
                $data["trimestre_3"]["programados"] = floatval($value["cantidad"]);
                $data["trimestre_3"]["category"] = 'Trimestre ' . $val;
                $data["trimestre_3"]["trimestre"] = $value["trimestre"];
              }
              if( $value["trimestre"] == '4' ){
                $data["trimestre_4"]["programados"] = floatval($value["cantidad"]);
                $data["trimestre_4"]["category"] = 'Trimestre ' . $val;
                $data["trimestre_4"]["trimestre"] = $value["trimestre"];
              }


            }
            if ( $value["tipo"] == '2' ){
              if( $value["trimestre"] == '1' ){
                $data["trimestre_1"]["ejecutados"] = floatval($value["cantidad"]);
              }
              if( $value["trimestre"] == '2' ){
                $data["trimestre_2"]["ejecutados"] = floatval($value["cantidad"]);
              }
              if( $value["trimestre"] == '3' ){
                $data["trimestre_3"]["ejecutados"] = floatval($value["cantidad"]);
              }
              if( $value["trimestre"] == '4' ){
                $data["trimestre_4"]["ejecutados"] = floatval($value["cantidad"]);
              }

            }

          }

          echo json_encode(array("data"=>$data)) ;
        }else{
          return false;
        }
     }

    }


public function insertar_datos(){

  //tinee que ser nivel 2 para insertar o editar
  if ($_SESSION["usuario"][0]["kpi_roles_id"] == '2') {

    if( $_POST['tabla'] && $_POST['insert'] && $_POST['update'] && $_POST['where'] ){

      $modelo = new modeloPortada();
      $res = $modelo->selectRowData($_POST['tabla'],'*', $_POST['where']);

      if($res){

        //ya existe, se actualiza

        if(date("Y-m-d", strtotime($res["fecha_creacion"])) == date("Y-m-d") ){

          //está dentro del mismo día el registro se puede editar

          $_POST['update']['kpi_usuario_modificacion'] = $_SESSION["usuario"][0]["id"];
          $_POST['update']['fecha_modificacion'] = date("Y-m-d H:i:s");
          $_POST['update']['estado'] = 1;
          $id_registro = $res["id"];
          $res = $modelo->updateData( $_POST['tabla'], $_POST['update'], array("id"=>$res["id"]));

          if ($res) {

            echo json_encode(array("resultado"=>true, "mensaje"=>"Registro actualizado", "editado"=>"0" ));
          }else{
            return false;
          }

        }else{

          //está fuera del rango de fechas.su registro va a lista de espera
          $_POST['temporal']['kpi_usuario_modificacion'] = $_SESSION["usuario"][0]["id"];
          $id_registro = $res["id"];
          $_POST['temporal']['fecha_modificacion'] = date("Y-m-d H:i:s");
          $_POST['temporal']['estado'] = 1;

          $res = $modelo->updateData( $_POST['tabla'], $_POST['temporal'], array("id"=>$res["id"]));

          if ($res) {
              $res = $modelo->selectRowData('kpi_lista_cambios','*', array( "nombre_tabla"=>$_POST['tabla'],
                                        "id_registro"=>$id_registro, "estado"=>1));

              if($res){
                //existe no hace nada porque ya está regsitrado
                $valores = array("usuario_nombre"=> $_SESSION["usuario"][0]["nombre"] .' '. $_SESSION["usuario"][0]["apellido"],
                "kpi_usuario_modificacion" => $_SESSION["usuario"][0]["id"], "fecha_modificacion" => date("Y-m-d H:i:s"), "estado"=> 1);
                  $res = $modelo->updateData( 'kpi_lista_cambios', $valores, array( "nombre_tabla"=>$_POST['tabla'], "id_registro"=>$id_registro));

                  if($res){
                    echo json_encode(array("resultado"=>true, "mensaje"=>"Campo editado. Los cambios se visualizarán luego de ser aprobados", "editado"=>"1" ));
                  }else{
                    echo json_encode(array("resultado"=>false, "mensaje"=>"Ha ocurrido un error" ));
                  }


              }else{
                //registra
                $valores = array("nombre_tabla"=>$_POST['tabla'],
                      "id_registro"=> $id_registro,
                      "usuario_nombre"=> $_SESSION["usuario"][0]["nombre"] .' '. $_SESSION["usuario"][0]["apellido"],
                      "kpi_usuario_modificacion" => $_SESSION["usuario"][0]["id"],
                      "kpi_usuario_registro" => $_SESSION["usuario"][0]["id"],
                      "fecha_creacion"=>date("Y-m-d H:i:s"));
                      $resultado = $modelo->insertData( 'kpi_lista_cambios', $valores );
                      if ($resultado) {
                        echo json_encode(array("resultado"=>true, "mensaje"=>"Campo editado. Los cambios se visualizarán luego de ser aprobados", "editado"=>"1" ));
                      }else{
                        echo json_encode(array("resultado"=>false, "mensaje"=>"Ha ocurrido un error" ));
                    }
              }
            }else{
              return false;
            }
        }


      }else{
        //registra

          $_POST['insert']['kpi_usuario_modificacion'] = $_SESSION["usuario"][0]["id"];
          $_POST['insert']['kpi_usuario_registro'] = $_SESSION["usuario"][0]["id"];
          $_POST['insert']['fecha_creacion'] = date("Y-m-d H:i:s");

          $res = $modelo->insertData( $_POST['tabla'], $_POST['insert'] );
          if ($res) {
            echo json_encode(array("resultado"=>true, "mensaje"=>"Campo registrado", "editado"=>"0" ));
          }else{
            return false;
          }
      }

    }else{
      return false;
    }

  }else{
    echo json_encode(array("resultado"=>false, "mensaje"=>"No posee permisos para insertar este registro" ));
  }


}
public function insertar_datos_only(){

  if( $_POST['tabla'] && $_POST['insert']  && $_POST['where'] ){

    $modelo = new modeloPortada();
    $res = $modelo->selectRowData($_POST['tabla'],'*', $_POST['where']);
    if($res){


        return false;

    }else{
      //registra

      $_POST['insert']['kpi_usuario_modificacion'] = $_SESSION["usuario"][0]["id"];
      $_POST['insert']['kpi_usuario_registro'] = $_SESSION["usuario"][0]["id"];
      $_POST['insert']['fecha_creacion'] = date("Y-m-d H:i:s");


    $res = $modelo->insertData( $_POST['tabla'], $_POST['insert'] );

    if ($res) {
      echo json_encode(array("resultado"=>true )) ;
    }else{
      return false;
    }
    }

  }else{
    return false;
  }
}

public function update_data(){

  if( $_POST['tabla'] && $_POST['where'] && $_POST['update']){
    $_POST['update']['fecha_modificacion'] = date("Y-m-d H:i:s");
    $modelo = new modeloPortada();
    $res = $modelo->updateData( $_POST['tabla'], $_POST['update'], $_POST['where']);
       if ($res) {
        echo json_encode(array("resultado"=>true )) ;
      }else{
        return false;
      }
  }
 }

 public function update_data_lista_cambios(){

  if( $_POST['tabla'] && $_POST['where']){

    $modelo = new modeloPortada();

    $res = $modelo->selectRowData($_POST['tabla'],'*', $_POST['where']);
    if($res){
      $valores = [];

      foreach($res as $item => $value ){

        if(substr($item, 0, 4) == "tmp_"){
          $nuevo_item=substr($item, 4);
          $valores[$nuevo_item] = $value;
          $valores[$item] = 0;
        }

      }

      $res = $modelo->updateData( $_POST['tabla'], $valores, $_POST['where']);

      if ($res) {
        echo json_encode(array("resultado"=>true, "mensaje"=>"Resistro aprobado exitosamente" ));
      }else{
        return false;
      }
    }

  }
 }
 public function descartar_data_lista_cambios(){

  if( $_POST['tabla'] && $_POST['where']){

    $modelo = new modeloPortada();

    $res = $modelo->selectRowData($_POST['tabla'],'*', $_POST['where']);
    if($res){
      $valores = [];

      foreach($res as $item => $value ){

        if(substr($item, 0, 4) == "tmp_"){

          $valores[$item] = 0;
        }

      }

      $res = $modelo->updateData( $_POST['tabla'], $valores, $_POST['where']);

      if ($res) {
        echo json_encode(array("resultado"=>true, "mensaje"=>"Resistro descartado exitosamente" ));
      }else{
        return false;
      }
    }

  }
 }

 public function cargar_datos_sin_editado(){

  if( $_POST['tabla'] && $_POST['where'] ){

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

public function ejecutar_consulta(){
  if( $_POST['tabla'] && $_POST['campo'] &&  $_POST['like']){
    $modelo = new modeloPortada();
    $sql = "SELECT * FROM " . $_POST['tabla'] . " WHERE ". $_POST['campo'] . " LIKE '%".$_POST['like']."%' AND estado=1";
    $res = $modelo->executeQuery( $sql );
    if ($res) {
      echo json_encode(array( "data"=>$res )) ;
    }else{
      return false;
    }

   }
}

public function verificar_nivel_usuario(){
  $id = $_SESSION["usuario"][0]["id"];
  $modelo = new modeloPortada();
  $query = "SELECT * FROM kpi_usuarios WHERE id=".$id;
  $res = $modelo->executeQuery( $query );
  $nivel = $res[0]["kpi_roles_id"];
  echo json_encode(array( "nivel"=>$nivel )) ;
}

public function cargar_datos_rubro_grupo(){
  $modelo = new modeloPortada();
  $query = "SELECT a.*, b.nombre_grupo as nombre_grupo FROM kpi_rubro as a LEFT JOIN kpi_grupo as b ON a.id_grupo = b.id ORDER BY b.id";
  $res = $modelo->executeQuery( $query );
  if ($res) {
    echo json_encode(array( "data"=>$res )) ;
  }else{
    return false;
  }

}
public function cargar_lista_cambios(){
  $modelo = new modeloPortada();
  $query = "SELECT a.*, b.nombre as nombre_indicador FROM kpi_lista_cambios as a LEFT JOIN kpi_modulos as b ON a.nombre_tabla  = b.codigo WHERE a.estado =1";
  $res = $modelo->executeQuery( $query );
  if ($res) {
    echo json_encode(array( "data"=>$res )) ;
  }else{
    return false;
  }

}

}
