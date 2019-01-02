<form class="form-horizontal" action="geral" method="GET">
<div class="row">
    <div class="form-group col-md-4">
        <div class=" "><label for="text-input" class=" form-control-label">Elegir opción</label>
        <select class="form-control"  name="opcionejecutar" id="opcionejecutar">
            <option value="SELECT/INSERT" selected="selected">SELECT/INSERT</option> 
            <option value="DELETE">DELETE</option>
            <option value="CREATETABLE">DROP/CREATE TABLE y SEQUENCE</option>
            <option value="ALTERTABLE">DROP/CREATE TABLE y SEQUENCE</option>
        </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        <label for="text-input" class="form-control-label">Escribir insert/select a ejecutar</label>
        <textarea class="form-control" placeholder="SELECT * FROM/INSERT INTO" size="100" value="<?php echo $_GET["nombretabla"]?>" name="nombretabla" cols="30" rows="7"></textarea>
    </div>
    
</div>
<div class="row">
    <div class="form-group col-md-12">
        <label for="text-input" class=" form-control-label">Crear Tabla</label>
            <input type="text" class="form-control"  style="witdh:100%;" size="100" placeholder="Nombre de la tabla" name="tablename" value="<?php echo $_GET["tablename"]?>" placeholder="tablename" >
            <textarea name="campostabla" class="form-control"  value="<?php echo $_GET["campostabla"]?>" id="" cols="100" rows="20"></textarea>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        <label for="text-input" class=" form-control-label">Eliminar Registros de una Tabla</label>
        <input type="text" style="witdh:100%;" size="100" placeholder="Nombre de la Tabla" value="<?php echo $_GET["deletefrom"]?>" name="deletefrom" placeholder="deletefrom">
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        <label for="text-input" class=" form-control-label">Alter table a una tabla</label>
        <input type="text" style="witdh:100%;" size="100" placeholder="Nombre de la Tabla" value="<?php echo $_GET["altertable"]?>" name="deletefrom" placeholder="deletefrom">
    </div>
</div>
<button type="submit" class="btn btn-success btn-flat">Ejecutar Query</button>
</form>

    
<?php 
//  Configure DB Parameters
class mdl
{
    public function createTable ($sql){
        try {
            echo "creando..."."</br>";
            echo $sql."</br>";
            $db1 = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.19.0.35)(PORT = 1521)))(CONNECT_DATA=(SID=xe)))" ;
            $host = "172.19.0.35";
            $dbname = "orcl";
            $dbuser = "INABIF_UPP";
            $userpass = "UPP";
            $port= 1521;
    
            $db = new PDO("oci:dbname=$db1",$dbuser,$userpass);
            $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
         
            $db->exec($sql);
            print("tabla creada "."</br>");
       
       } catch(PDOException $e) {
           echo $e->getMessage();//Remove or change message in production code
       }
    }
}
class PG extends PDO
{
public function __construct() {
    $db1 = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.19.0.35)(PORT = 1521)))(CONNECT_DATA=(SID=xe)))" ;
        $host = "172.19.0.35";
        $dbname = "orcl";
        $dbuser = "INABIF_UPP";
        $userpass = "UPP";
        $port= 1521;
         //parent::__construct("oci:dbname=//$host:$port/$dbname;charset=utf8",$dbuser,$userpass);
         parent::__construct("oci:dbname=$db1".";charset=UTF8",$dbuser,$userpass);
    try {

 
      parent::setAttribute(parent::ATTR_ERRMODE, parent::ERRMODE_EXCEPTION);

      parent::setAttribute(parent::ATTR_DEFAULT_FETCH_MODE, parent::FETCH_ASSOC);

      //parent::exec("SET CHARACTER SET utf8");

    } catch (PDOException $e) {

        echo 'Error BD: ' . $e->getMessage();

      }

    }
    public function dropTable($query){

        try{
            echo "ELIMINANDO... ".$query."</br>";
          $stmt = parent::prepare($query);
          if($stmt->execute()){
            echo "borrado";
          }else{
            echo "no borrado";
          }
        echo "<br>";
        } catch (PDOException $e) {
          echo 'Error BD: ' . $e->getMessage();
        }
      }
public function executeQuery($query, $params=NULL){

      try{
        echo "EJECUTANDO: ".$query;
        echo "<br>";
        $stmt = parent::prepare($query);

        if($stmt->execute($params)){
            echo "EJECUTADO: ".$query;
        echo "<br>";

          return $stmt->fetchAll();

        }else{
            echo "ERROR: ".$query;
        echo "<br>";

          return array();

        }

      } catch (PDOException $e) {

        echo 'Error BD: ' . $e->getMessage();

      }

    }
    public function insertData($tabla, $values) {
        if(count($values)>0){
            $query = 'INSERT INTO '.$tabla;
            $queryKeys = '';
            $queryValues = '';
            $params = array();
            $coma = '';
            foreach($values as $key => $val){
                $queryKeys .= $coma.$key;
                $queryValues .= $coma.':'.$key;
                $params[':'.$key] = $val;
                $coma = ',';
            }
            $query .= '('.$queryKeys.') VALUES ('.$queryValues.')';
            print_r($query);
            $stmt = parent::prepare($query);
            $stmt->execute($params);
            if($stmt->rowCount()>0){
                return TRUE;
            }else{
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }
    public function deleteDataNoWhere($tabla) {
        $query = 'DELETE FROM ' . $tabla;
        $params = array();
        $stmt = parent::prepare($query);
        echo "BORRANDO: ".$query;
        $stmt->execute($params);
        echo "BORRADO: ".$tabla;
        if($stmt->rowCount()>0){
            return TRUE;
        }else{
            return FALSE;
        }

}
    }

$x = new PG();
$mdl = new mdl();
if (isset($_GET["deletedata"])) {
    $x->deleteDataNoWhere("CarDatosAdmision");
    $x->deleteDataNoWhere("CarAtencionPsicologica");
    $x->deleteDataNoWhere("CarAtencionSalud");
    $x->deleteDataNoWhere("CarActividades");
    $x->deleteDataNoWhere("CarTrabajoSocial");
    $x->deleteDataNoWhere("CarCentroServicio");
    $x->deleteDataNoWhere("CarIdentificacionUsuario");
    $x->deleteDataNoWhere("CarCondicionIngreso");
    $x->deleteDataNoWhere("CarEgresoEducacion");
    $x->deleteDataNoWhere("CarEgresoGeneral");
    $x->deleteDataNoWhere("CarEgresoSalud");
    $x->deleteDataNoWhere("CarTerapiaFisica");
    $x->deleteDataNoWhere("pam_tipo_transtorno_conducta");
    $x->deleteDataNoWhere("CarSaludMental");
    
    
    die();
}
if (isset($_GET["opcionejecutar"]) && $_GET["opcionejecutar"]!="") {
    if ($_GET["opcionejecutar"]=="SELECT/INSERT") {
        print_r($x->executeQuery($_GET["nombretabla"]));
    }else if ($_GET["opcionejecutar"]=="DELETE"){
        $x->deleteDataNoWhere($_GET["deletefrom"]);
    }else if($_GET["opcionejecutar"]=="CREATETABLE"){
        $x->dropTable("drop table ".$_GET["tablename"]);
        $mdl->createTable("Create table ".$_GET["tablename"]."
        (
        ".$_GET["campostabla"]."
        )
        ");
        $mdl->createTable ("drop sequence seq_".$_GET["tablename"]);
        $mdl->createTable ("Create sequence seq_".$_GET["tablename"]);
        print_r($x->executeQuery("select * from ".$_GET["tablename"]));
    }else if($_GET["opcionejecutar"]=="ALTERTABLE"){
        
        $mdl->createTable ($_GET["altertable"]);
        print_r($x->executeQuery("select * from ".$_GET["altertable"]));
    }
    die();
}else{
    $mdl->createTable ("drop sequence seq_centro_atencion");
    $mdl->createTable ("CREATE SEQUENCE seq_centro_atencion
    START WITH     56
    INCREMENT BY   1
    NOCACHE
    NOCYCLE");
   
     /*
 
    print_r($x->executeQuery("delete from centro_atencion"));
    $arr = ["insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (1,3 , 'ENT002' , 'INABIF' , 'SER007' , '070101' , 'CNNA101' , 'HOGAR SAN ANTONIO' , 'LOS ROBLES S/N- 4TA. CDRA.URB. JARDINES DE VIRÚ.' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (2,3 , 'ENT002' , 'INABIF' , 'SER007' , '150136' , 'CNNA102' , 'HOGAR ERMELINDA CARRERA' , 'AV. LA PAZ 535 - 539' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (3,3 , 'ENT002' , 'INABIF' , 'SER007' , '150136' , 'CNNA103' , 'HOGAR DIVINO JESÚS' , 'AV. LIMA CDRA. 9 S/N ALT. CDRA. 4 DE LA AV. UNIVERSITARIA' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (4,3 , 'ENT002' , 'INABIF' , 'SER007' , '150121' , 'CNNA104' , 'HOGAR ARCO IRIS' , 'BELISARIO BARRIGA 115' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (5,3 , 'ENT002' , 'INABIF' , 'SER007' , '150136' , 'CNNA105' , 'CASAS HOGAR SAN MIGUEL ARCÁNGEL' , 'AV. LIBERTAD  2091(1,1,1)-  2093(2)- 2099(3)- 2097(4)- 2095(5)' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (6,3 , 'ENT002' , 'INABIF' , 'SER007' , '070101' , 'CNNA106' , 'CASA DE LA MUJER Y PROMOCIÓN COMUNAL SANTA ROSA' , 'JR. IQUITOS S/N 2DA. URB. SANTA ROSA' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (7,3 , 'ENT002' , 'INABIF' , 'SER007' , '150117' , 'CNNA107' , 'CASAS HOGAR SAGRADO CORAZÓN' , 'URB. EL NARANJAL 2DA. ETAPA ' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (8,3 , 'ENT002' , 'INABIF' , 'SER007' , '150103' , 'CNNA108' , 'HOGAR ALDEA INFANTIL SAN RICARDO' , 'AV. PEDRO RUIZ GALLO 1485' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (9,3 , 'ENT002' , 'INABIF' , 'SER007' , '150103' , 'CNNA109' , 'HOGAR CASA ESTANCIA DOMI' , 'AV. EVITAMIENTO 931- SALAMANCA' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (10,3 , 'ENT002' , 'INABIF' , 'SER007' , '150108' , 'CNNA110' , 'HOGAR NIÑO JESUS DE PRAGA - CHORRILLOS' , 'AV. GUARDIA PERUANA MZ15 LOTE 16' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (11,3 , 'ENT002' , 'INABIF' , 'SER007' , '150121' , '' , 'HOGAR LAZOS DE AMOR' , 'AV. SAN MARTÍN 685' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 0)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (12,3 , 'ENT002' , 'INABIF' , 'SER007' , '150135' , 'CNNA111' , 'HOGAR GRACIA' , 'PASAJE LOS LEONES N° 145' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (13,3 , 'ENT002' , 'INABIF' , 'SER007' , '021809' , 'CNNA201' , 'HOGAR SAN PEDRITO' , 'AV. LOS ALCATRACES S/N ZONA DE EQUIPAMIENTO  MZ. C , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (14,3 , 'ENT002' , 'INABIF' , 'SER007' , '040101' , 'CNNA202' , 'HOGAR SAN LUIS GONZAGA' , 'AV. ALFONSO UGARTE S/N CERCADO' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (15,3 , 'ENT002' , 'INABIF' , 'SER007' , '40122' , 'CNNA203' , 'SAN JOSÉ AREQUIPA 2' , 'AV. SALAVERRY S/N LARA (AL COSTADO DEL COLEGIO SANTISIMO SALVADOR)' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (16,3 , 'ENT002' , 'INABIF' , 'SER007' , '050101' , 'CNNA204' , 'HOGAR URPI' , 'AV. INDEPENDENCIA 600  CDRA. 6' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (17,3 , 'ENT002' , 'INABIF' , 'SER007' , '080101' , 'CNNA205' , 'HOGAR BUEN PASTOR' , 'AV. MANZANARES S/N URB.  MANUEL PRADO' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (18,3 , 'ENT002' , 'INABIF' , 'SER007' , '080106' , 'CNNA206' , 'HOGAR JESÚS MI LUZ' , 'AV. FRANCISCO BOLOGNESI S/N EX BOSQUE CCORIPATA ' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (19,3 , 'ENT002' , 'INABIF' , 'SER007' , '080910' , 'CNNA207' , 'HOGAR ESPERANZA DE PICHARI' , 'CALLE SEÑOR DE LOS MILAGROS MZ A LT 1' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (20,3 , 'ENT002' , 'INABIF' , 'SER007' , '100601' , 'CNNA208' , 'HOGAR SANTA TERESITA DEL NIÑO JESÚS' , 'JR. MANCO CAPAC S/N' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (21,3 , 'ENT002' , 'INABIF' , 'SER007' , '100101' , 'CNNA209' , 'HOGAR PILLCO MOZO' , 'JR. DOS DE MAYO Nº 900 ' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (22,3 , 'ENT002' , 'INABIF' , 'SER007' , '110101' , 'CNNA210' , 'HOGAR SEÑOR DE LUREN' , 'CASERIO DE CACHICHE S/N' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (23,3 , 'ENT002' , 'INABIF' , 'SER007' , '110201' , 'CNNA211' , 'HOGAR PAÚL HARRIS' , 'AV. CAMINO REAL Nº 900- SECTOR HIJAYA' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (24,3 , 'ENT002' , 'INABIF' , 'SER007' , '120114' , 'CNNA212' , 'HOGAR ANDRÉS AVELINO CÁCERES' , 'PROLONGACIÓN TRUJILLO 271' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (25,3 , 'ENT002' , 'INABIF' , 'SER007' , '130111' , 'CNNA213' , 'HOGAR LA NIÑA' , 'CALLE R.V. PELLETIER 256' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (26,3 , 'ENT002' , 'INABIF' , 'SER007' , '130101' , 'CNNA214' , 'HOGAR SAN JOSÉ' , 'AV. GONZÁLES PRADO 705 URB. SANTA MARIA I ETAPA' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (27,3 , 'ENT002' , 'INABIF' , 'SER007' , '140101' , 'CNNA215' , 'HOGAR ROSA MARÍA CHECA' , 'AV. SALAVERRY S/N KM. 1' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (28,3 , 'ENT002' , 'INABIF' , 'SER007' , '140101' , 'CNNA216' , 'HOGAR SAN VICENTE DE PAÚL' , 'CALLE FRANCISCO CABRERA 1283' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (29,3 , 'ENT002' , 'INABIF' , 'SER007' , '140112' , 'CNNA217' , 'HOGAR SAN JUAN BOSCO' , 'PIMENTEL KM. 10 CARRETERA A PIMENTEL' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (30,3 , 'ENT002' , 'INABIF' , 'SER007' , '160108' , 'CNNA218' , 'HOGAR PADRE ANGEL RODRÍGUEZ' , 'AV. 28 DE JULIO 500' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (31,3 , 'ENT002' , 'INABIF' , 'SER007' , '160108' , 'CNNA219' , 'HOGAR CASA DE ACOGIDA SANTA LORENA' , 'AV. 28 DE JULIO 500' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (32,3 , 'ENT002' , 'INABIF' , 'SER007' , '210101' , 'CNNA220' , 'HOGAR VÍRGEN DE FÁTIMA' , 'AV. SIDERAL 241 BARRIO CHEJOÑA' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (33,3 , 'ENT002' , 'INABIF' , 'SER007' , '210101' , 'CNNA221' , 'HOGAR SAN MARTÍN DE PORRES' , 'YANAMAYO S/N ALTO PUNO' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (34,3 , 'ENT002' , 'INABIF' , 'SER007' , '211101' , 'CNNA222' , 'HOGAR SAGRADO CORAZÓN DE JESÚS' , 'JR. MANUEL PRADO S/N' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (35,3 , 'ENT002' , 'INABIF' , 'SER007' , '230101' , 'CNNA223' , 'HOGAR SANTO DOMINGO SAVIO' , 'AV. PINTO 2482 - LA NATIVIDAD' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (36,3 , 'ENT002' , 'INABIF' , 'SER007' , '140105' , 'CNNA224' , 'HOGAR MEDALLA MILAGROSA' , 'CALLE TUMBES 939' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (37,3 , 'ENT002' , 'INABIF' , 'SER007' , '180101' , 'CNNA225' , 'CAR SANTA FORTUNATA' , 'AV. SANTA FORTUNATA S/N, CENTRO POBLADO SAN ANTONIO' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (38,3 , 'ENT002' , 'INABIF' , 'SER007' , '120114' , 'CNNA226' , 'CAR VIDAS - JUNÍN' , 'PROLONGACIÓN TRUJILLO 271, EL TAMBO' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (39,3 , 'ENT002' , 'INABIF' , 'SER007' , '160108' , 'CNNA227' , 'CAR VIDAS - LORETO' , 'AV. 28 DE JULIO N° 500, PUNCHANA' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (40,3 , 'ENT002' , 'INABIF' , 'SER007' , '150136' , 'CNNA112' , 'CAR VIDAS - LIMA' , 'JR. CASTILLA N°501' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (41,3 , 'ENT002' , 'INABIF' , 'SER007' , '170102' , 'CNNA228' , 'CAR FLORECER' , 'JR. FRANSCISCO BOLOGNESI S/N' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (42,1 , 'ENT002' , 'INABIF' , 'SER009' , '150102' , 'CPCD101' , 'HOGAR NIÑO JESÚS DE PRAGA' , 'PLAYA LAS CONCHITAS S/N-ANCÓN' , 'URBANO' , 'LIN003' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE CON DISCAPACIDAD EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPPD' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (43,1 , 'ENT002' , 'INABIF' , 'SER009' , '150101' , 'CPCD102' , 'HOGAR SAN FRANCISCO DE ASÍS' , 'SANTA BERNARDITA CDRA. 3 S/N - PANDO' , 'URBANO' , 'LIN003' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE CON DISCAPACIDAD EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPPD' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (44,1 , 'ENT002' , 'INABIF' , 'SER009' , '150136' , 'CPCD103' , 'HOGAR RENACER' , 'JR. CASTILLA N° 509-SAN MIGUEL' , 'URBANO' , 'LIN003' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE CON DISCAPACIDAD EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPPD' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (45,1 , 'ENT002' , 'INABIF' , 'SER009' , '150136' , 'CPCD104' , 'HOGAR MATÍLDE PÉREZ PALACIOS' , 'CALLE SANTA ANA-CUADRA 8 S/N-SAN MIGUEL' , 'URBANO' , 'LIN003' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE CON DISCAPACIDAD EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPPD' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (46,1 , 'ENT002' , 'INABIF' , 'SER009' , '150136' , 'CPCD105' , 'HOGAR ESPERANZA' , 'JR. CASTILLA N° 509-SAN MIGUEL' , 'URBANO' , 'LIN003' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE CON DISCAPACIDAD EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPPD' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (47,1 , 'ENT002' , 'INABIF' , 'SER009' , '150121' , 'CPCD106' , 'ASOCIACIÓN DE LAS BIENAVENTURANZAS' , 'CALLE SANTA ROSA N° 900 TABLADA DE LURIN' , 'URBANO' , 'LIN003' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE CON DISCAPACIDAD EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPPD' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (48,2 , 'ENT002' , 'INABIF' , 'SER008' , '150136' , 'CPAM101' , 'HOGAR VIRGEN DEL CARMEN' , 'JR. CASTILLA 501 - 509' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ATENCIÓN RESIDENCIAL - USPPAM' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (49,2 , 'ENT002' , 'INABIF' , 'SER008' , '150109' , 'CPAM102' , 'HOGAR CIENEGUILLA' , 'MALECÓN LURÍN, MZ J-2' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ATENCIÓN RESIDENCIAL - USPPAM' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (50,2 , 'ENT002' , 'INABIF' , 'SER008' , '150101' , 'CPAM103' , 'CAR HOGAR SAN VICENTE DE PAÚL' , 'JR. ANCASH N° 1595' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ATENCIÓN RESIDENCIAL - USPPAM' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (51,2 , 'ENT002' , 'INABIF' , 'SER008' , '150101' , 'CPAM104' , 'CAR HOGAR CANEVARO' , 'JR. MADERA N° 265' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ATENCIÓN RESIDENCIAL - USPPAM' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (52,2 , 'ENT002' , 'INABIF' , 'SER008' , '150130' , '' , 'CAR  PRIVADO NAZARENO' , 'SALVADOR DALI N° 490 -SAN BORJA' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ATENCIÓN RESIDENCIAL - USPPAM' , 0)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (53,3 , 'ENT002' , 'INABIF' , 'SER007' , '070101' , 'UNNA101' , 'CAR SANTA ROSA N° 01' , 'JR. IQUITOS S/N 2DA. URB. SANTA ROSA (ALT. CDRA. 34 AV. ARGENTINA)' , 'URBANO' , 'LIN003' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL DE URGENCIA - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (54,3 , 'ENT002' , 'INABIF' , 'SER007' , '070101' , 'UNNA102' , 'CAR SANTA ROSA N° 02' , 'JR. IQUITOS S/N 2DA. URB. SANTA ROSA (ALT. CDRA. 34 AV. ARGENTINA)' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL DE URGENCIA - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (55,3 , 'ENT002' , 'INABIF' , 'SER007' , '070101' , 'UNNA103' , 'CAR CASA ISABEL I' , 'AV. SALAVERRY S/N LARA (AL COSTADO DEL COLEGIO SANTISIMO SALVADOR)' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL DE URGENCIA - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,tipo_centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (56,3 , 'ENT002' , 'INABIF' , 'SER007' , '070101' , 'UNNA104' , 'CAR CASA ISABEL II' , 'AV. SALAVERRY S/N LARA (AL COSTADO DEL COLEGIO SANTISIMO SALVADOR)' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL DE URGENCIA - USPNNA' , 1,1,1)"];
    foreach ($arr as $key => $value) {
        $x->executeQuery($value);
    }*/
/* $mdl->createTable ("drop sequence seq_Carproblematica_familiar");
    */
 
 
/*
$arr = ['Create table pam_ActividadPrevencion
(
Id int not null primary key ,
Tipo_Centro_Id                                           	int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Atencion_Psicologica char(2),
Habilidades_Sociales char(2),
Nro_Participa int,
Taller_Autoestima char(2),
Nro_Participa_Autoestima                     	int,
ManejoSituacionesDivergentes char(2),
Nro_Participa_Divergentes    	int,
Taller_Control_Emociones      	char(2),
Nro_Participa_Emociones       	int,
ConservacionHabilidadCognitiva          	char(2),
Nro_Participa_Cognitivas        	int,
Otros char(2),
Nro_Participa_Otros int,
Estado              	int default 1,
Fecha_Crea   	date,
Fecha_Edicion  timestamp default sysdate,
Usuario_Crea	int,
Usuario_Edita   int
)

','
create table CarIdentificacionUsuario
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Ape_Paterno varchar2(50),
Ape_Materno varchar2(50),
Nom_Usuario varchar2(50),
Pais_Procencia   int,
Depatamento_Procedencia int,
Provincia_Procedencia  int,
Distrito_Procedencia   int,
Sexo          	char(2),
Fecha_Nacimiento date,
Edad          	int,
Lengua_Materna     	int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
create table CarIdentificacionUsuario
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Ape_Paterno varchar2(50),
Ape_Materno varchar2(50),
Nom_Usuario varchar2(50),
Pais_Procencia   int,
Depatamento_Procedencia int,
Provincia_Procedencia  int,
Distrito_Procedencia   int,
Sexo          	char(2),
Fecha_Nacimiento date,
Edad          	int,
Lengua_Materna     	int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','create table CarDatosAdmision
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Mov_Poblacional varchar(100),
Fecha_Ingreso    date,
Fecha_Reingreso  date,
Institucion_derivado int,
Motivo_Ingreso    varchar(100),
Tipo_Documento   int,
Numero_Documento int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarCondicionIngreso
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
DNI   char(2),
Tipo_Documento     	int,
Numero_Documento int,
Lee_Escribe  	char(2),
Nivel_Educativo    	int,
Institucion_Educativa  int,
Tipo_Seguro  	int,
Clasficacion_Socioeconomica int,
Familiares   	char(2),
Parentesco   	int,
Posee_Pension char(2),
Tipo_Pension INT,
Problematica_Familiar int,
 Estado            	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
create table CarSaludNutricion
(
Id int not null primary key ,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Discapacidad       	char(2),
Discapacidad_Fisica	varchar(40),
Discapacidad_Intelectual varchar(40),
Discapacidad_Sensorial varchar(40),
Discapacidad_mental varchar(40),
Certificacdo_Dx    	char(2),
Carnet_CONADIS     	char(20),
Movilidad    	int,
Motivo_Movilidad int,
Dificultad_Movilidad   int,
Patologia1   	char(20),
Tipo_Patologia1    	int,
Especifique1       	varchar(250),
Patologia2   	char(20),
Tipo_Patologia2    	int,
Especifique2       	varchar(200),
Nivel_Hemoglobina  	number(6,2),
Anemia             	char(20),
Peso          	number(6,2),
Talla         	number(6,2),
Estado_Nutricional 	int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
Create table CarSaludMental
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Transtorno_Neurologico char(20),
Des_Transtorno     	int,
Tipo_Transtorno    	int,
Dificultad_habla varchar(100),
Metodo_comunicarse 	varchar(100),
Comprension  	char(2),
Tipo_Dificultad    	varchar(100),
Actividades_Diarias	int,
Especificar  	long,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarTerapia
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Num_TMotriz int,
Num_TPsicomotricidad   int,
Num_TFisioterapia  	int,
Num_TDeportes      	int,
Num_TComunicacion  	int,
Num_TOrofacial     	int,
Num_TLenguaje      	int,
Num_TLenguajeA     	int,
Tipo_LenguajeA     	int,
Num_TABVD    	int,
Num_TInstrumentalesB   int,
Num_TInstrumentalesC   int,
Num_TSensoriales int,
Num_TReceptivas    	int,
Num_TOrteticos     	int,
Num_TSoillaR       	int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarActividades
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Num_Biohuerto	int,
Num_Manualidades int,
Num_Panaderia      	int,
Num_Paseos   	int,
Num_Culturales     	int,
Num_Civicas  	int,
Num_Futbol   	int,
Num_Natacion       	int,
Num_otrosDe  	int,
Num_ManejoDinero int,
Num_decisiones     	int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarAtencionPsicologica
(
Id      	int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Num_HBasicas             	int,
Num_HConceptuales        	int,
Num_HSociales            	int,
Num_HPracticas           	int,
Num_HModificacion        	int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarEducacionCapacidades
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Tipo_Institucion varchar(100),
Insertado_labora char(2),
Des_labora   	long,
Participa_Actividades  char(2),
Fecha_InicionA     	date,
Fecha_FinA   	date,
Culmino_Actividades	char(2),
Logro_Actividades  	char(2),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
 
','
create table CarTrabajoSocial
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Visitas    char(2),
Num_Visitas int,
Reinsercion_Familiar   char(2),
Familia_RedesS     	char(2),
Des_Persona_Visita 	varchar(50),
DNI           	char(2),
AUS           	char(2),
CONADIS            	char(2),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
 
','
create table CarAtencionSalud
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Num_MedicinaG	int,
Salida_Hospitales char(2),
Num_Cardiovascular 	int,
Num_Nefrologia     	int,
Num_Oncologia      	int,
Num_Neurocirugia int,
Num_Dermatologia int,
Num_Endocrinologia 	int,
Num_Gastroenterologia  int,
Num_Gineco_Obsterica   int,
Num_Hematologia    	int,
Num_Infec_contagiosa   int,
Num_Inmunologia    	int,
Num_Medicina_fisica	int,
Num_Neumologia     	int,
Num_Nutricion      	int,
Num_Neurologia     	int,
Num_Oftalmologia int,
Num_Otorrinolarinlogia int,
Num_Pedriatria     	int,
Num_Psiquiatria    	int,
Num_Quirurgica     	int,
Num_Traumologia    	int,
Num_Urologia       	int,
Num_Odontologia    	int,
Num_Otro     	int,
Tratamiento_Psicofarmaco	char(2),
Hopitalizado_Periodo   char(2),
Numero_Hospitalizaciones int,
MotivoHospitalizacion varchar(250),
NumSalidasHospital int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int)','
 
create table CarEgresoPsicologico
(
Id int not null primary key ,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Plan_Psicologico char(2),
Meta_PII     	varchar(250),
Informe_Tecnico    	char(2),
Des_Informe  	varchar(200),
Cumple_Plan  	varchar(180),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
 
','
 
create table CarEgresoEducacion
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Plan_Educacion     	char(2),
Meta_PII     	varchar(250),
Informe_Tecnico    	char(2),
Des_Informe  	varchar(200),
Cumple_Plan  	varchar(180),
Asistencia_Escolar 	char(2),
Desempeno    	int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarEgresoSalud
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Plan_Medico  	char(2),
Meta_PII     	long,
Informe_Tecnico    	char(2),
Des_Informe  	varchar(200),
Cumple_Plan  	varchar(180),
Enfermedades_Cronicas  char(2),
Especificar  	varchar(250),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarTerapiaFisica
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Plan_Medico  	char(2),
Meta_PII     	varchar(250),
Informe_Tecnico    	char(2),
Des_Informe  	varchar(200),
Cumple_Plan  	varchar(180),
Desarrollo_Lenguaje	varchar(250),
Mejora_Fonema      	char(2),
Mejora_Comprensivo 	char(2),
Elabora_Oraciones  	char(2),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarEgresoNutricion
(
Id 	int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Plan_Nutricional char(2),
Meta_PII     	varchar(250),
Informe_Tecnico    	char(2),
Des_Informe  	varchar(200),
Cumple_Plan  	varchar(180),
Estado_Nutricional 	varchar(180),
Peso          	number(6,2),
Talla         	number(6,2),
Hemoglobina  	number(6,2),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarEgresoTrabajoSocial
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Plan_Social  	char(2),
Meta_PII     	varchar(250),
Informe_Tecnico    	char(2),
Des_Informe  	varchar(200),
Cumple_Plan  	varchar(180),
Ubicacion_Familia  	char(2),
Participacion_Familia  char(2),
Reinsercion  	char(2),
Colocacion_Laboral 	char(2),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
Create table CarEgresoGeneral
(
Id  	int not null primary key,
Tipo_Centro_Id     	int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Fecha_Egreso       	date,
Motivo_Egreso      	varchar(200) null,
Retiro_Voluntario  	varchar(180) null,
Reinsercion_Familiar varchar(180) null,
Grado_Parentesco varchar(180) null,
Traslado	varchar(100) null,
Fallecimiento varchar(100) null,
Restitucion_Derechos char(2) null,
Aus char(2) null,
Constancia_Naci    	char(2),
Carner_CONADIS     	char(2),
DNI           	char(2),
Restitucion_Familiar  	varchar(180),
Estado             	int default 1,
Fecha_Creacion     	date,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
Create table Carproblematica_familiar(
Id int not null primary key,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Nombre varchar(250),
Estado             	int default 1,
Fecha_Creacion     	date,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
Create table Cardesempeno_academico
 (
Id int not null primary key,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Nombre varchar(250),
Estado             	int default 1,
Fecha_Creacion     	date,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)'];
$arrdrop = ['drop table CarCentroServicio','
drop table CarIdentificacionUsuario','drop table CarDatosAdmision
','
 
drop table CarCondicionIngreso
','
drop table CarSaludNutricion
','
 
drop table CarSaludMental
','
 
drop table CarTerapia
','
 
drop table CarActividades
','
 
drop table CarAtencionPsicologica
','
 
drop table CarEducacionCapacidades
 
','
drop table CarTrabajoSocial
 
','
drop table CarAtencionSalud
 
','
 
drop table CarEgresoPsicologico
 
','
 
drop table CarEgresoEducacion
','
 
drop table CarEgresoSalud
','
 
drop table CarTerapiaFisica
','
 
drop table CarEgresoNutricion
','
 
drop table CarEgresoTrabajoSocial
','
 
drop table CarEgresoGeneral
','
drop table Carproblematica_familiar
','
drop table Cardesempeno_academico'];
$arrdropseq = ['drop sequence seq_CarCentroServicio','
drop sequence seq_CarIdentificacionUsuario','drop sequence seq_CarDatosAdmision
','
 
drop sequence seq_CarCondicionIngreso
','
drop sequence seq_CarSaludNutricion
','
 
drop sequence seq_CarSaludMental
','
 
drop sequence seq_CarTerapia
','
 
drop sequence seq_CarActividades
','
 
drop sequence seq_CarAtencionPsicologica
','
 
drop sequence seq_CarEducacionCapacidades
 
','
drop sequence seq_CarTrabajoSocial
 
','
drop sequence seq_CarAtencionSalud
 
','
 
drop sequence seq_CarEgresoPsicologico
 
','
 
drop sequence seq_CarEgresoEducacion
','
 
drop sequence seq_CarEgresoSalud
','
 
drop sequence seq_CarTerapiaFisica
','
 
drop sequence seq_CarEgresoNutricion
','
 
drop sequence seq_CarEgresoTrabajoSocial
','
 
drop sequence seq_CarEgresoGeneral
','
drop sequence seq_Carproblematica_familiar
','
drop sequence seq_Cardesempeno_academico'];
$arrcreateseq = ['create sequence seq_CarCentroServicio','
create sequence seq_CarIdentificacionUsuario','create sequence seq_CarDatosAdmision
','
 
create sequence seq_CarCondicionIngreso
','
create sequence seq_CarSaludNutricion
','
 
create sequence seq_CarSaludMental
','
 
create sequence seq_CarTerapia
','
 
create sequence seq_CarActividades
','
 
create sequence seq_CarAtencionPsicologica
','
 
create sequence seq_CarEducacionCapacidades
 
','
create sequence seq_CarTrabajoSocial
 
','
create sequence seq_CarAtencionSalud
 
','
 
create sequence seq_CarEgresoPsicologico
 
','
 
create sequence seq_CarEgresoEducacion
','
 
create sequence seq_CarEgresoSalud
','
 
create sequence seq_CarTerapiaFisica
','
 
create sequence seq_CarEgresoNutricion
','
 
create sequence seq_CarEgresoTrabajoSocial
','
 
create sequence seq_CarEgresoGeneral
','
create sequence seq_Carproblematica_familiar
','
create sequence seq_Cardesempeno_academico'];
foreach ($arr as $key => $value) {
    echo $key;
    $x->dropTable($arrdrop[$key]);
    $mdl->createTable($arrdropseq[$key]);
    $mdl->createTable($value);
    $mdl->createTable($arrcreateseq[$key]);
}*/
/*
$x->executeQuery("insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion) 
values(1,1,1,1,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','ACOGIDA',1,1,SYSDATE,1,1)");*/
/*$x->insertData('modulos', array("id"=>1,"centro_id"=>1,"encargado_id"=>1,"parent_id"=>1,"url_template"=>'ppd-datos-actividades',"icon"=>'fa fa-laptop',"nombre"=>'ACOGIDA',"estado_completo"=>0,"estado"=>1,"fecha_creacion"=>'18-DEC-28',"usuario_creacion"=>1,"usuario_edicion"=>1));*/
//print_r($x->executeQuery("select * from modulos"));
/*$x->executeQuery("drop table modulos");
$x->executeQuery("drop SEQUENCE seq_modulos");
$x->executeQuery("create table modulos (
    id INT NOT NULL primary key,
    centro_id INT NOT NULL,
    encargado_id INT NOT NULL,
  parent_id int not null,
  url_template varchar(250),
  icon varchar(100),
    nombre VARCHAR(100) NOT NULL,
    estado_completo INT NULL,
    estado INT DEFAULT 1,
    fecha_creacion date NOT NULL,
    fecha_edicion TIMESTAMP DEFAULT SYSDATE,
    usuario_creacion INT NOT NULL,
    usuario_edicion INT NOT NULL
    )");
$x->executeQuery("DESCRIBE modulos"); 
$x->executeQuery("insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion) values(1,1,1,1,'ppd-datos-actividades','fa fa-laptop','ACOGIDA',1,1,SYSDATE,1,1);");
print_r($x->executeQuery("select * from modulos"));
/*
print_r($x->executeQuery("insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)values(1,1,1,0,'ppd-datos-actividades','fa fa-laptop','ACOGIDA',0,1,SYSDATE,1,1);"));
print_r($x->executeQuery("select * from modulos"));*/

//$x->executeQuery("alter table caratencionsalud add (NumSalidasHospital int)");
//$x->executeQuery("alter table caratencionsalud add (MotivoHospitalizacion varchar(250))");
}

 ?>

<div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="#">
                        <img class="align-content" src="<?php echo IMAGES?>/logo.png" alt="">
                    </a>
                </div>
                <div class="login-form">
                    <form class="" action="<?php $this->url('index') ?>" method="post">
                        <div class="form-group">
                            <label>Usuario</label>
                            <input type="text" class="form-control" name="usuario" placeholder="Ingrese su usuario">
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="password" class="form-control" name="contrasena" placeholder="Ingrese su clave">
                        </div>

                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Entrar</button>


                    </form>
                </div>
            </div>
        </div>
    </div>
