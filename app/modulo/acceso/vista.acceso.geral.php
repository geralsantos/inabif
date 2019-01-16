<form class="form-horizontal" action="geral" method="GET">
<div class="row">
    <div class="form-group col-md-4">
        <div class=" "><label for="text-input" class=" form-control-label">Elegir opción</label>
        <select class="form-control"  name="opcionejecutar" id="opcionejecutar">
            <option value="SELECT/INSERT" selected="selected">SELECT/INSERT</option> 
            <option value="DELETE">DELETE</option>
            <option value="CREATETABLE">DROP/CREATE TABLE y SEQUENCE</option>
            <option value="ALTERTABLE">ALTER TABLE</option>
            <option value="" >EJECUTAR CODIGO INTERNO</option> 
        </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        <label for="text-input" class="form-control-label">Escribir insert/select a ejecutar</label>
        <textarea class="form-control" placeholder="SELECT * FROM/INSERT INTO" size="100" value="<?php echo $_GET["nombretabla"]?>" name="nombretabla" cols="30" rows="7"><?php echo $_GET["nombretabla"]?></textarea>
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
        <input type="text" style="witdh:100%;" size="100" placeholder="Nombre de la Tabla" value="<?php echo $_GET["altertable"]?>" name="altertable" placeholder="altertable">
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

          return false;

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
 
    print_r($x->executeQuery("truncate table ubigeo"));
    $arr = ["insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1,'01','AMAZONAS','0101','CHACHAPOYAS','010101','CHACHAPOYAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (2,'01','AMAZONAS','0101','CHACHAPOYAS','010102','ASUNCION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (3,'01','AMAZONAS','0101','CHACHAPOYAS','010103','BALSAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (4,'01','AMAZONAS','0101','CHACHAPOYAS','010104','CHETO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (5,'01','AMAZONAS','0101','CHACHAPOYAS','010105','CHILIQUIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (6,'01','AMAZONAS','0101','CHACHAPOYAS','010106','CHUQUIBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (7,'01','AMAZONAS','0101','CHACHAPOYAS','010107','GRANADA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (8,'01','AMAZONAS','0101','CHACHAPOYAS','010108','HUANCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (9,'01','AMAZONAS','0101','CHACHAPOYAS','010109','LA JALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (10,'01','AMAZONAS','0101','CHACHAPOYAS','010110','LEIMEBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (11,'01','AMAZONAS','0101','CHACHAPOYAS','010111','LEVANTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (12,'01','AMAZONAS','0101','CHACHAPOYAS','010112','MAGDALENA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (13,'01','AMAZONAS','0101','CHACHAPOYAS','010113','MARISCAL CASTILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (14,'01','AMAZONAS','0101','CHACHAPOYAS','010114','MOLINOPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (15,'01','AMAZONAS','0101','CHACHAPOYAS','010115','MONTEVIDEO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (16,'01','AMAZONAS','0101','CHACHAPOYAS','010116','OLLEROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (17,'01','AMAZONAS','0101','CHACHAPOYAS','010117','QUINJALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (18,'01','AMAZONAS','0101','CHACHAPOYAS','010118','SAN FRANCISCO DE DAGUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (19,'01','AMAZONAS','0101','CHACHAPOYAS','010119','SAN ISIDRO DE MAINO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (20,'01','AMAZONAS','0101','CHACHAPOYAS','010120','SOLOCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (21,'01','AMAZONAS','0101','CHACHAPOYAS','010121','SONCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (22,'01','AMAZONAS','0102','BAGUA','010201','BAGUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (23,'01','AMAZONAS','0102','BAGUA','010202','ARAMANGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (24,'01','AMAZONAS','0102','BAGUA','010203','COPALLIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (25,'01','AMAZONAS','0102','BAGUA','010204','EL PARCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (26,'01','AMAZONAS','0102','BAGUA','010205','IMAZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (27,'01','AMAZONAS','0102','BAGUA','010206','LA PECA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (28,'01','AMAZONAS','0103','BONGARA','010301','JUMBILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (29,'01','AMAZONAS','0103','BONGARA','010302','CHISQUILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (30,'01','AMAZONAS','0103','BONGARA','010303','CHURUJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (31,'01','AMAZONAS','0103','BONGARA','010304','COROSHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (32,'01','AMAZONAS','0103','BONGARA','010305','CUISPES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (33,'01','AMAZONAS','0103','BONGARA','010306','FLORIDA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (34,'01','AMAZONAS','0103','BONGARA','010307','JAZAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (35,'01','AMAZONAS','0103','BONGARA','010308','RECTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (36,'01','AMAZONAS','0103','BONGARA','010309','SAN CARLOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (37,'01','AMAZONAS','0103','BONGARA','010310','SHIPASBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (38,'01','AMAZONAS','0103','BONGARA','010311','VALERA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (39,'01','AMAZONAS','0103','BONGARA','010312','YAMBRASBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (40,'01','AMAZONAS','0104','CONDORCANQUI','010401','NIEVA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (41,'01','AMAZONAS','0104','CONDORCANQUI','010402','EL CENEPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (42,'01','AMAZONAS','0104','CONDORCANQUI','010403','RIO SANTIAGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (43,'01','AMAZONAS','0105','LUYA','010501','LAMUD')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (44,'01','AMAZONAS','0105','LUYA','010502','CAMPORREDONDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (45,'01','AMAZONAS','0105','LUYA','010503','COCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (46,'01','AMAZONAS','0105','LUYA','010504','COLCAMAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (47,'01','AMAZONAS','0105','LUYA','010505','CONILA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (48,'01','AMAZONAS','0105','LUYA','010506','INGUILPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (49,'01','AMAZONAS','0105','LUYA','010507','LONGUITA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (50,'01','AMAZONAS','0105','LUYA','010508','LONYA CHICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (51,'01','AMAZONAS','0105','LUYA','010509','LUYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (52,'01','AMAZONAS','0105','LUYA','010510','LUYA VIEJO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (53,'01','AMAZONAS','0105','LUYA','010511','MARIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (54,'01','AMAZONAS','0105','LUYA','010512','OCALLI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (55,'01','AMAZONAS','0105','LUYA','010513','OCUMAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (56,'01','AMAZONAS','0105','LUYA','010514','PISUQUIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (57,'01','AMAZONAS','0105','LUYA','010515','PROVIDENCIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (58,'01','AMAZONAS','0105','LUYA','010516','SAN CRISTOBAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (59,'01','AMAZONAS','0105','LUYA','010517','SAN FRANCISCO DEL YESO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (60,'01','AMAZONAS','0105','LUYA','010518','SAN JERONIMO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (61,'01','AMAZONAS','0105','LUYA','010519','SAN JUAN DE LOPECANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (62,'01','AMAZONAS','0105','LUYA','010520','SANTA CATALINA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (63,'01','AMAZONAS','0105','LUYA','010521','SANTO TOMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (64,'01','AMAZONAS','0105','LUYA','010522','TINGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (65,'01','AMAZONAS','0105','LUYA','010523','TRITA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (66,'01','AMAZONAS','0106','RODRIGUEZ DE MENDOZA','010601','SAN NICOLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (67,'01','AMAZONAS','0106','RODRIGUEZ DE MENDOZA','010602','CHIRIMOTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (68,'01','AMAZONAS','0106','RODRIGUEZ DE MENDOZA','010603','COCHAMAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (69,'01','AMAZONAS','0106','RODRIGUEZ DE MENDOZA','010604','HUAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (70,'01','AMAZONAS','0106','RODRIGUEZ DE MENDOZA','010605','LIMABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (71,'01','AMAZONAS','0106','RODRIGUEZ DE MENDOZA','010606','LONGAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (72,'01','AMAZONAS','0106','RODRIGUEZ DE MENDOZA','010607','MARISCAL BENAVIDES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (73,'01','AMAZONAS','0106','RODRIGUEZ DE MENDOZA','010608','MILPUC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (74,'01','AMAZONAS','0106','RODRIGUEZ DE MENDOZA','010609','OMIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (75,'01','AMAZONAS','0106','RODRIGUEZ DE MENDOZA','010610','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (76,'01','AMAZONAS','0106','RODRIGUEZ DE MENDOZA','010611','TOTORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (77,'01','AMAZONAS','0106','RODRIGUEZ DE MENDOZA','010612','VISTA ALEGRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (78,'01','AMAZONAS','0107','UTCUBAMBA','010701','BAGUA GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (79,'01','AMAZONAS','0107','UTCUBAMBA','010702','CAJARURO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (80,'01','AMAZONAS','0107','UTCUBAMBA','010703','CUMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (81,'01','AMAZONAS','0107','UTCUBAMBA','010704','EL MILAGRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (82,'01','AMAZONAS','0107','UTCUBAMBA','010705','JAMALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (83,'01','AMAZONAS','0107','UTCUBAMBA','010706','LONYA GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (84,'01','AMAZONAS','0107','UTCUBAMBA','010707','YAMON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (85,'02','ANCASH','0201','HUARAZ','020101','HUARAZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (86,'02','ANCASH','0201','HUARAZ','020102','COCHABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (87,'02','ANCASH','0201','HUARAZ','020103','COLCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (88,'02','ANCASH','0201','HUARAZ','020104','HUANCHAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (89,'02','ANCASH','0201','HUARAZ','020105','INDEPENDENCIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (90,'02','ANCASH','0201','HUARAZ','020106','JANGAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (91,'02','ANCASH','0201','HUARAZ','020107','LA LIBERTAD')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (92,'02','ANCASH','0201','HUARAZ','020108','OLLEROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (93,'02','ANCASH','0201','HUARAZ','020109','PAMPAS GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (94,'02','ANCASH','0201','HUARAZ','020110','PARIACOTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (95,'02','ANCASH','0201','HUARAZ','020111','PIRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (96,'02','ANCASH','0201','HUARAZ','020112','TARICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (97,'02','ANCASH','0202','AIJA','020201','AIJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (98,'02','ANCASH','0202','AIJA','020202','CORIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (99,'02','ANCASH','0202','AIJA','020203','HUACLLAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (100,'02','ANCASH','0202','AIJA','020204','LA MERCED')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (101,'02','ANCASH','0202','AIJA','020205','SUCCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (102,'02','ANCASH','0203','ANTONIO RAYMONDI','020301','LLAMELLIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (103,'02','ANCASH','0203','ANTONIO RAYMONDI','020302','ACZO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (104,'02','ANCASH','0203','ANTONIO RAYMONDI','020303','CHACCHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (105,'02','ANCASH','0203','ANTONIO RAYMONDI','020304','CHINGAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (106,'02','ANCASH','0203','ANTONIO RAYMONDI','020305','MIRGAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (107,'02','ANCASH','0203','ANTONIO RAYMONDI','020306','SAN JUAN DE RONTOY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (108,'02','ANCASH','0204','ASUNCION','020401','CHACAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (109,'02','ANCASH','0204','ASUNCION','020402','ACOCHACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (110,'02','ANCASH','0205','BOLOGNESI','020501','CHIQUIAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (111,'02','ANCASH','0205','BOLOGNESI','020502','ABELARDO PARDO LEZAMETA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (112,'02','ANCASH','0205','BOLOGNESI','020503','ANTONIO RAYMONDI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (113,'02','ANCASH','0205','BOLOGNESI','020504','AQUIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (114,'02','ANCASH','0205','BOLOGNESI','020505','CAJACAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (115,'02','ANCASH','0205','BOLOGNESI','020506','CANIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (116,'02','ANCASH','0205','BOLOGNESI','020507','COLQUIOC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (117,'02','ANCASH','0205','BOLOGNESI','020508','HUALLANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (118,'02','ANCASH','0205','BOLOGNESI','020509','HUASTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (119,'02','ANCASH','0205','BOLOGNESI','020510','HUAYLLACAYAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (120,'02','ANCASH','0205','BOLOGNESI','020511','LA PRIMAVERA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (121,'02','ANCASH','0205','BOLOGNESI','020512','MANGAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (122,'02','ANCASH','0205','BOLOGNESI','020513','PACLLON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (123,'02','ANCASH','0205','BOLOGNESI','020514','SAN MIGUEL DE CORPANQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (124,'02','ANCASH','0205','BOLOGNESI','020515','TICLLOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (125,'02','ANCASH','0206','CARHUAZ','020601','CARHUAZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (126,'02','ANCASH','0206','CARHUAZ','020602','ACOPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (127,'02','ANCASH','0206','CARHUAZ','020603','AMASHCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (128,'02','ANCASH','0206','CARHUAZ','020604','ANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (129,'02','ANCASH','0206','CARHUAZ','020605','ATAQUERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (130,'02','ANCASH','0206','CARHUAZ','020606','MARCARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (131,'02','ANCASH','0206','CARHUAZ','020607','PARIAHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (132,'02','ANCASH','0206','CARHUAZ','020608','SAN MIGUEL DE ACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (133,'02','ANCASH','0206','CARHUAZ','020609','SHILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (134,'02','ANCASH','0206','CARHUAZ','020610','TINCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (135,'02','ANCASH','0206','CARHUAZ','020611','YUNGAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (136,'02','ANCASH','0207','CARLOS FERMIN FITZCARRALD','020701','SAN LUIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (137,'02','ANCASH','0207','CARLOS FERMIN FITZCARRALD','020702','SAN NICOLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (138,'02','ANCASH','0207','CARLOS FERMIN FITZCARRALD','020703','YAUYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (139,'02','ANCASH','0208','CASMA','020801','CASMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (140,'02','ANCASH','0208','CASMA','020802','BUENA VISTA ALTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (141,'02','ANCASH','0208','CASMA','020803','COMANDANTE NOEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (142,'02','ANCASH','0208','CASMA','020804','YAUTAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (143,'02','ANCASH','0209','CORONGO','020901','CORONGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (144,'02','ANCASH','0209','CORONGO','020902','ACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (145,'02','ANCASH','0209','CORONGO','020903','BAMBAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (146,'02','ANCASH','0209','CORONGO','020904','CUSCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (147,'02','ANCASH','0209','CORONGO','020905','LA PAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (148,'02','ANCASH','0209','CORONGO','020906','YANAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (149,'02','ANCASH','0209','CORONGO','020907','YUPAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (150,'02','ANCASH','0210','HUARI','021001','HUARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (151,'02','ANCASH','0210','HUARI','021002','ANRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (152,'02','ANCASH','0210','HUARI','021003','CAJAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (153,'02','ANCASH','0210','HUARI','021004','CHAVIN DE HUANTAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (154,'02','ANCASH','0210','HUARI','021005','HUACACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (155,'02','ANCASH','0210','HUARI','021006','HUACCHIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (156,'02','ANCASH','0210','HUARI','021007','HUACHIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (157,'02','ANCASH','0210','HUARI','021008','HUANTAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (158,'02','ANCASH','0210','HUARI','021009','MASIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (159,'02','ANCASH','0210','HUARI','021010','PAUCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (160,'02','ANCASH','0210','HUARI','021011','PONTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (161,'02','ANCASH','0210','HUARI','021012','RAHUAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (162,'02','ANCASH','0210','HUARI','021013','RAPAYAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (163,'02','ANCASH','0210','HUARI','021014','SAN MARCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (164,'02','ANCASH','0210','HUARI','021015','SAN PEDRO DE CHANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (165,'02','ANCASH','0210','HUARI','021016','UCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (166,'02','ANCASH','0211','HUARMEY','021101','HUARMEY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (167,'02','ANCASH','0211','HUARMEY','021102','COCHAPETI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (168,'02','ANCASH','0211','HUARMEY','021103','CULEBRAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (169,'02','ANCASH','0211','HUARMEY','021104','HUAYAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (170,'02','ANCASH','0211','HUARMEY','021105','MALVAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (171,'02','ANCASH','0212','HUAYLAS','021201','CARAZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (172,'02','ANCASH','0212','HUAYLAS','021202','HUALLANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (173,'02','ANCASH','0212','HUAYLAS','021203','HUATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (174,'02','ANCASH','0212','HUAYLAS','021204','HUAYLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (175,'02','ANCASH','0212','HUAYLAS','021205','MATO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (176,'02','ANCASH','0212','HUAYLAS','021206','PAMPAROMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (177,'02','ANCASH','0212','HUAYLAS','021207','PUEBLO LIBRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (178,'02','ANCASH','0212','HUAYLAS','021208','SANTA CRUZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (179,'02','ANCASH','0212','HUAYLAS','021209','SANTO TORIBIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (180,'02','ANCASH','0212','HUAYLAS','021210','YURACMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (181,'02','ANCASH','0213','MARISCAL LUZURIAGA','021301','PISCOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (182,'02','ANCASH','0213','MARISCAL LUZURIAGA','021302','CASCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (183,'02','ANCASH','0213','MARISCAL LUZURIAGA','021303','ELEAZAR GUZMAN BARRON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (184,'02','ANCASH','0213','MARISCAL LUZURIAGA','021304','FIDEL OLIVAS ESCUDERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (185,'02','ANCASH','0213','MARISCAL LUZURIAGA','021305','LLAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (186,'02','ANCASH','0213','MARISCAL LUZURIAGA','021306','LLUMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (187,'02','ANCASH','0213','MARISCAL LUZURIAGA','021307','LUCMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (188,'02','ANCASH','0213','MARISCAL LUZURIAGA','021308','MUSGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (189,'02','ANCASH','0214','OCROS','021401','OCROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (190,'02','ANCASH','0214','OCROS','021402','ACAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (191,'02','ANCASH','0214','OCROS','021403','CAJAMARQUILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (192,'02','ANCASH','0214','OCROS','021404','CARHUAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (193,'02','ANCASH','0214','OCROS','021405','COCHAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (194,'02','ANCASH','0214','OCROS','021406','CONGAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (195,'02','ANCASH','0214','OCROS','021407','LLIPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (196,'02','ANCASH','0214','OCROS','021408','SAN CRISTOBAL DE RAJAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (197,'02','ANCASH','0214','OCROS','021409','SAN PEDRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (198,'02','ANCASH','0214','OCROS','021410','SANTIAGO DE CHILCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (199,'02','ANCASH','0215','PALLASCA','021501','CABANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (200,'02','ANCASH','0215','PALLASCA','021502','BOLOGNESI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (201,'02','ANCASH','0215','PALLASCA','021503','CONCHUCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (202,'02','ANCASH','0215','PALLASCA','021504','HUACASCHUQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (203,'02','ANCASH','0215','PALLASCA','021505','HUANDOVAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (204,'02','ANCASH','0215','PALLASCA','021506','LACABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (205,'02','ANCASH','0215','PALLASCA','021507','LLAPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (206,'02','ANCASH','0215','PALLASCA','021508','PALLASCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (207,'02','ANCASH','0215','PALLASCA','021509','PAMPAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (208,'02','ANCASH','0215','PALLASCA','021510','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (209,'02','ANCASH','0215','PALLASCA','021511','TAUCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (210,'02','ANCASH','0216','POMABAMBA','021601','POMABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (211,'02','ANCASH','0216','POMABAMBA','021602','HUAYLLAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (212,'02','ANCASH','0216','POMABAMBA','021603','PAROBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (213,'02','ANCASH','0216','POMABAMBA','021604','QUINUABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (214,'02','ANCASH','0217','RECUAY','021701','RECUAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (215,'02','ANCASH','0217','RECUAY','021702','CATAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (216,'02','ANCASH','0217','RECUAY','021703','COTAPARACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (217,'02','ANCASH','0217','RECUAY','021704','HUAYLLAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (218,'02','ANCASH','0217','RECUAY','021705','LLACLLIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (219,'02','ANCASH','0217','RECUAY','021706','MARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (220,'02','ANCASH','0217','RECUAY','021707','PAMPAS CHICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (221,'02','ANCASH','0217','RECUAY','021708','PARARIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (222,'02','ANCASH','0217','RECUAY','021709','TAPACOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (223,'02','ANCASH','0217','RECUAY','021710','TICAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (224,'02','ANCASH','0218','SANTA','021801','CHIMBOTE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (225,'02','ANCASH','0218','SANTA','021802','CACERES DEL PERU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (226,'02','ANCASH','0218','SANTA','021803','COISHCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (227,'02','ANCASH','0218','SANTA','021804','MACATE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (228,'02','ANCASH','0218','SANTA','021805','MORO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (229,'02','ANCASH','0218','SANTA','021806','NEPEÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (230,'02','ANCASH','0218','SANTA','021807','SAMANCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (231,'02','ANCASH','0218','SANTA','021808','SANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (232,'02','ANCASH','0218','SANTA','021809','NUEVO CHIMBOTE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (233,'02','ANCASH','0219','SIHUAS','021901','SIHUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (234,'02','ANCASH','0219','SIHUAS','021902','ACOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (235,'02','ANCASH','0219','SIHUAS','021903','ALFONSO UGARTE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (236,'02','ANCASH','0219','SIHUAS','021904','CASHAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (237,'02','ANCASH','0219','SIHUAS','021905','CHINGALPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (238,'02','ANCASH','0219','SIHUAS','021906','HUAYLLABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (239,'02','ANCASH','0219','SIHUAS','021907','QUICHES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (240,'02','ANCASH','0219','SIHUAS','021908','RAGASH')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (241,'02','ANCASH','0219','SIHUAS','021909','SAN JUAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (242,'02','ANCASH','0219','SIHUAS','021910','SICSIBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (243,'02','ANCASH','0220','YUNGAY','022001','YUNGAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (244,'02','ANCASH','0220','YUNGAY','022002','CASCAPARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (245,'02','ANCASH','0220','YUNGAY','022003','MANCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (246,'02','ANCASH','0220','YUNGAY','022004','MATACOTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (247,'02','ANCASH','0220','YUNGAY','022005','QUILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (248,'02','ANCASH','0220','YUNGAY','022006','RANRAHIRCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (249,'02','ANCASH','0220','YUNGAY','022007','SHUPLUY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (250,'02','ANCASH','0220','YUNGAY','022008','YANAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (251,'03','APURIMAC','0301','ABANCAY','030101','ABANCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (252,'03','APURIMAC','0301','ABANCAY','030102','CHACOCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (253,'03','APURIMAC','0301','ABANCAY','030103','CIRCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (254,'03','APURIMAC','0301','ABANCAY','030104','CURAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (255,'03','APURIMAC','0301','ABANCAY','030105','HUANIPACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (256,'03','APURIMAC','0301','ABANCAY','030106','LAMBRAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (257,'03','APURIMAC','0301','ABANCAY','030107','PICHIRHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (258,'03','APURIMAC','0301','ABANCAY','030108','SAN PEDRO DE CACHORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (259,'03','APURIMAC','0301','ABANCAY','030109','TAMBURCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (260,'03','APURIMAC','0302','ANDAHUAYLAS','030201','ANDAHUAYLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (261,'03','APURIMAC','0302','ANDAHUAYLAS','030202','ANDARAPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (262,'03','APURIMAC','0302','ANDAHUAYLAS','030203','CHIARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (263,'03','APURIMAC','0302','ANDAHUAYLAS','030204','HUANCARAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (264,'03','APURIMAC','0302','ANDAHUAYLAS','030205','HUANCARAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (265,'03','APURIMAC','0302','ANDAHUAYLAS','030206','HUAYANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (266,'03','APURIMAC','0302','ANDAHUAYLAS','030207','KISHUARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (267,'03','APURIMAC','0302','ANDAHUAYLAS','030208','PACOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (268,'03','APURIMAC','0302','ANDAHUAYLAS','030209','PACUCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (269,'03','APURIMAC','0302','ANDAHUAYLAS','030210','PAMPACHIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (270,'03','APURIMAC','0302','ANDAHUAYLAS','030211','POMACOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (271,'03','APURIMAC','0302','ANDAHUAYLAS','030212','SAN ANTONIO DE CACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (272,'03','APURIMAC','0302','ANDAHUAYLAS','030213','SAN JERONIMO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (273,'03','APURIMAC','0302','ANDAHUAYLAS','030214','SAN MIGUEL DE CHACCRAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (274,'03','APURIMAC','0302','ANDAHUAYLAS','030215','SANTA MARIA DE CHICMO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (275,'03','APURIMAC','0302','ANDAHUAYLAS','030216','TALAVERA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (276,'03','APURIMAC','0302','ANDAHUAYLAS','030217','TUMAY HUARACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (277,'03','APURIMAC','0302','ANDAHUAYLAS','030218','TURPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (278,'03','APURIMAC','0302','ANDAHUAYLAS','030219','KAQUIABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (279,'03','APURIMAC','0302','ANDAHUAYLAS','030220','JOSE MARIA ARGUEDAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (280,'03','APURIMAC','0303','ANTABAMBA','030301','ANTABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (281,'03','APURIMAC','0303','ANTABAMBA','030302','EL ORO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (282,'03','APURIMAC','0303','ANTABAMBA','030303','HUAQUIRCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (283,'03','APURIMAC','0303','ANTABAMBA','030304','JUAN ESPINOZA MEDRANO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (284,'03','APURIMAC','0303','ANTABAMBA','030305','OROPESA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (285,'03','APURIMAC','0303','ANTABAMBA','030306','PACHACONAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (286,'03','APURIMAC','0303','ANTABAMBA','030307','SABAINO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (287,'03','APURIMAC','0304','AYMARAES','030401','CHALHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (288,'03','APURIMAC','0304','AYMARAES','030402','CAPAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (289,'03','APURIMAC','0304','AYMARAES','030403','CARAYBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (290,'03','APURIMAC','0304','AYMARAES','030404','CHAPIMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (291,'03','APURIMAC','0304','AYMARAES','030405','COLCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (292,'03','APURIMAC','0304','AYMARAES','030406','COTARUSE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (293,'03','APURIMAC','0304','AYMARAES','030407','IHUAYLLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (294,'03','APURIMAC','0304','AYMARAES','030408','JUSTO APU SAHUARAURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (295,'03','APURIMAC','0304','AYMARAES','030409','LUCRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (296,'03','APURIMAC','0304','AYMARAES','030410','POCOHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (297,'03','APURIMAC','0304','AYMARAES','030411','SAN JUAN DE CHACÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (298,'03','APURIMAC','0304','AYMARAES','030412','SAÑAYCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (299,'03','APURIMAC','0304','AYMARAES','030413','SORAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (300,'03','APURIMAC','0304','AYMARAES','030414','TAPAIRIHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (301,'03','APURIMAC','0304','AYMARAES','030415','TINTAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (302,'03','APURIMAC','0304','AYMARAES','030416','TORAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (303,'03','APURIMAC','0304','AYMARAES','030417','YANACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (304,'03','APURIMAC','0305','COTABAMBAS','030501','TAMBOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (305,'03','APURIMAC','0305','COTABAMBAS','030502','COTABAMBAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (306,'03','APURIMAC','0305','COTABAMBAS','030503','COYLLURQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (307,'03','APURIMAC','0305','COTABAMBAS','030504','HAQUIRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (308,'03','APURIMAC','0305','COTABAMBAS','030505','MARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (309,'03','APURIMAC','0305','COTABAMBAS','030506','CHALLHUAHUACHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (310,'03','APURIMAC','0306','CHINCHEROS','030601','CHINCHEROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (311,'03','APURIMAC','0306','CHINCHEROS','030602','ANCO_HUALLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (312,'03','APURIMAC','0306','CHINCHEROS','030603','COCHARCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (313,'03','APURIMAC','0306','CHINCHEROS','030604','HUACCANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (314,'03','APURIMAC','0306','CHINCHEROS','030605','OCOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (315,'03','APURIMAC','0306','CHINCHEROS','030606','ONGOY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (316,'03','APURIMAC','0306','CHINCHEROS','030607','URANMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (317,'03','APURIMAC','0306','CHINCHEROS','030608','RANRACANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (318,'03','APURIMAC','0306','CHINCHEROS','030609','ROCCHACC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (319,'03','APURIMAC','0306','CHINCHEROS','030610','EL PORVENIR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (320,'03','APURIMAC','0306','CHINCHEROS','030611','LOS CHANKAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (321,'03','APURIMAC','0307','GRAU','030701','CHUQUIBAMBILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (322,'03','APURIMAC','0307','GRAU','030702','CURPAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (323,'03','APURIMAC','0307','GRAU','030703','GAMARRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (324,'03','APURIMAC','0307','GRAU','030704','HUAYLLATI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (325,'03','APURIMAC','0307','GRAU','030705','MAMARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (326,'03','APURIMAC','0307','GRAU','030706','MICAELA BASTIDAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (327,'03','APURIMAC','0307','GRAU','030707','PATAYPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (328,'03','APURIMAC','0307','GRAU','030708','PROGRESO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (329,'03','APURIMAC','0307','GRAU','030709','SAN ANTONIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (330,'03','APURIMAC','0307','GRAU','030710','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (331,'03','APURIMAC','0307','GRAU','030711','TURPAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (332,'03','APURIMAC','0307','GRAU','030712','VILCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (333,'03','APURIMAC','0307','GRAU','030713','VIRUNDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (334,'03','APURIMAC','0307','GRAU','030714','CURASCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (335,'04','AREQUIPA','0401','AREQUIPA','040101','AREQUIPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (336,'04','AREQUIPA','0401','AREQUIPA','040102','ALTO SELVA ALEGRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (337,'04','AREQUIPA','0401','AREQUIPA','040103','CAYMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (338,'04','AREQUIPA','0401','AREQUIPA','040104','CERRO COLORADO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (339,'04','AREQUIPA','0401','AREQUIPA','040105','CHARACATO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (340,'04','AREQUIPA','0401','AREQUIPA','040106','CHIGUATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (341,'04','AREQUIPA','0401','AREQUIPA','040107','JACOBO HUNTER')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (342,'04','AREQUIPA','0401','AREQUIPA','040108','LA JOYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (343,'04','AREQUIPA','0401','AREQUIPA','040109','MARIANO MELGAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (344,'04','AREQUIPA','0401','AREQUIPA','040110','MIRAFLORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (345,'04','AREQUIPA','0401','AREQUIPA','040111','MOLLEBAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (346,'04','AREQUIPA','0401','AREQUIPA','040112','PAUCARPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (347,'04','AREQUIPA','0401','AREQUIPA','040113','POCSI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (348,'04','AREQUIPA','0401','AREQUIPA','040114','POLOBAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (349,'04','AREQUIPA','0401','AREQUIPA','040115','QUEQUEÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (350,'04','AREQUIPA','0401','AREQUIPA','040116','SABANDIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (351,'04','AREQUIPA','0401','AREQUIPA','040117','SACHACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (352,'04','AREQUIPA','0401','AREQUIPA','040118','SAN JUAN DE SIGUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (353,'04','AREQUIPA','0401','AREQUIPA','040119','SAN JUAN DE TARUCANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (354,'04','AREQUIPA','0401','AREQUIPA','040120','SANTA ISABEL DE SIGUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (355,'04','AREQUIPA','0401','AREQUIPA','040121','SANTA RITA DE SIGUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (356,'04','AREQUIPA','0401','AREQUIPA','040122','SOCABAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (357,'04','AREQUIPA','0401','AREQUIPA','040123','TIABAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (358,'04','AREQUIPA','0401','AREQUIPA','040124','UCHUMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (359,'04','AREQUIPA','0401','AREQUIPA','040125','VITOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (360,'04','AREQUIPA','0401','AREQUIPA','040126','YANAHUARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (361,'04','AREQUIPA','0401','AREQUIPA','040127','YARABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (362,'04','AREQUIPA','0401','AREQUIPA','040128','YURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (363,'04','AREQUIPA','0401','AREQUIPA','040129','JOSE LUIS BUSTAMANTE Y RIVERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (364,'04','AREQUIPA','0402','CAMANA','040201','CAMANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (365,'04','AREQUIPA','0402','CAMANA','040202','JOSE MARIA QUIMPER')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (366,'04','AREQUIPA','0402','CAMANA','040203','MARIANO NICOLAS VALCARCEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (367,'04','AREQUIPA','0402','CAMANA','040204','MARISCAL CACERES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (368,'04','AREQUIPA','0402','CAMANA','040205','NICOLAS DE PIEROLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (369,'04','AREQUIPA','0402','CAMANA','040206','OCOÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (370,'04','AREQUIPA','0402','CAMANA','040207','QUILCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (371,'04','AREQUIPA','0402','CAMANA','040208','SAMUEL PASTOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (372,'04','AREQUIPA','0403','CARAVELI','040301','CARAVELI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (373,'04','AREQUIPA','0403','CARAVELI','040302','ACARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (374,'04','AREQUIPA','0403','CARAVELI','040303','ATICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (375,'04','AREQUIPA','0403','CARAVELI','040304','ATIQUIPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (376,'04','AREQUIPA','0403','CARAVELI','040305','BELLA UNION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (377,'04','AREQUIPA','0403','CARAVELI','040306','CAHUACHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (378,'04','AREQUIPA','0403','CARAVELI','040307','CHALA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (379,'04','AREQUIPA','0403','CARAVELI','040308','CHAPARRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (380,'04','AREQUIPA','0403','CARAVELI','040309','HUANUHUANU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (381,'04','AREQUIPA','0403','CARAVELI','040310','JAQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (382,'04','AREQUIPA','0403','CARAVELI','040311','LOMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (383,'04','AREQUIPA','0403','CARAVELI','040312','QUICACHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (384,'04','AREQUIPA','0403','CARAVELI','040313','YAUCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (385,'04','AREQUIPA','0404','CASTILLA','040401','APLAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (386,'04','AREQUIPA','0404','CASTILLA','040402','ANDAGUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (387,'04','AREQUIPA','0404','CASTILLA','040403','AYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (388,'04','AREQUIPA','0404','CASTILLA','040404','CHACHAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (389,'04','AREQUIPA','0404','CASTILLA','040405','CHILCAYMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (390,'04','AREQUIPA','0404','CASTILLA','040406','CHOCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (391,'04','AREQUIPA','0404','CASTILLA','040407','HUANCARQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (392,'04','AREQUIPA','0404','CASTILLA','040408','MACHAGUAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (393,'04','AREQUIPA','0404','CASTILLA','040409','ORCOPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (394,'04','AREQUIPA','0404','CASTILLA','040410','PAMPACOLCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (395,'04','AREQUIPA','0404','CASTILLA','040411','TIPAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (396,'04','AREQUIPA','0404','CASTILLA','040412','UÑON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (397,'04','AREQUIPA','0404','CASTILLA','040413','URACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (398,'04','AREQUIPA','0404','CASTILLA','040414','VIRACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (399,'04','AREQUIPA','0405','CAYLLOMA','040501','CHIVAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (400,'04','AREQUIPA','0405','CAYLLOMA','040502','ACHOMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (401,'04','AREQUIPA','0405','CAYLLOMA','040503','CABANACONDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (402,'04','AREQUIPA','0405','CAYLLOMA','040504','CALLALLI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (403,'04','AREQUIPA','0405','CAYLLOMA','040505','CAYLLOMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (404,'04','AREQUIPA','0405','CAYLLOMA','040506','COPORAQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (405,'04','AREQUIPA','0405','CAYLLOMA','040507','HUAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (406,'04','AREQUIPA','0405','CAYLLOMA','040508','HUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (407,'04','AREQUIPA','0405','CAYLLOMA','040509','ICHUPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (408,'04','AREQUIPA','0405','CAYLLOMA','040510','LARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (409,'04','AREQUIPA','0405','CAYLLOMA','040511','LLUTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (410,'04','AREQUIPA','0405','CAYLLOMA','040512','MACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (411,'04','AREQUIPA','0405','CAYLLOMA','040513','MADRIGAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (412,'04','AREQUIPA','0405','CAYLLOMA','040514','SAN ANTONIO DE CHUCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (413,'04','AREQUIPA','0405','CAYLLOMA','040515','SIBAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (414,'04','AREQUIPA','0405','CAYLLOMA','040516','TAPAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (415,'04','AREQUIPA','0405','CAYLLOMA','040517','TISCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (416,'04','AREQUIPA','0405','CAYLLOMA','040518','TUTI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (417,'04','AREQUIPA','0405','CAYLLOMA','040519','YANQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (418,'04','AREQUIPA','0405','CAYLLOMA','040520','MAJES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (419,'04','AREQUIPA','0406','CONDESUYOS','040601','CHUQUIBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (420,'04','AREQUIPA','0406','CONDESUYOS','040602','ANDARAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (421,'04','AREQUIPA','0406','CONDESUYOS','040603','CAYARANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (422,'04','AREQUIPA','0406','CONDESUYOS','040604','CHICHAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (423,'04','AREQUIPA','0406','CONDESUYOS','040605','IRAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (424,'04','AREQUIPA','0406','CONDESUYOS','040606','RIO GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (425,'04','AREQUIPA','0406','CONDESUYOS','040607','SALAMANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (426,'04','AREQUIPA','0406','CONDESUYOS','040608','YANAQUIHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (427,'04','AREQUIPA','0407','ISLAY','040701','MOLLENDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (428,'04','AREQUIPA','0407','ISLAY','040702','COCACHACRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (429,'04','AREQUIPA','0407','ISLAY','040703','DEAN VALDIVIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (430,'04','AREQUIPA','0407','ISLAY','040704','ISLAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (431,'04','AREQUIPA','0407','ISLAY','040705','MEJIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (432,'04','AREQUIPA','0407','ISLAY','040706','PUNTA DE BOMBON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (433,'04','AREQUIPA','0408','LA UNION','040801','COTAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (434,'04','AREQUIPA','0408','LA UNION','040802','ALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (435,'04','AREQUIPA','0408','LA UNION','040803','CHARCANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (436,'04','AREQUIPA','0408','LA UNION','040804','HUAYNACOTAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (437,'04','AREQUIPA','0408','LA UNION','040805','PAMPAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (438,'04','AREQUIPA','0408','LA UNION','040806','PUYCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (439,'04','AREQUIPA','0408','LA UNION','040807','QUECHUALLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (440,'04','AREQUIPA','0408','LA UNION','040808','SAYLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (441,'04','AREQUIPA','0408','LA UNION','040809','TAURIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (442,'04','AREQUIPA','0408','LA UNION','040810','TOMEPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (443,'04','AREQUIPA','0408','LA UNION','040811','TORO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (444,'05','AYACUCHO','0501','HUAMANGA','050101','AYACUCHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (445,'05','AYACUCHO','0501','HUAMANGA','050102','ACOCRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (446,'05','AYACUCHO','0501','HUAMANGA','050103','ACOS VINCHOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (447,'05','AYACUCHO','0501','HUAMANGA','050104','CARMEN ALTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (448,'05','AYACUCHO','0501','HUAMANGA','050105','CHIARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (449,'05','AYACUCHO','0501','HUAMANGA','050106','OCROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (450,'05','AYACUCHO','0501','HUAMANGA','050107','PACAYCASA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (451,'05','AYACUCHO','0501','HUAMANGA','050108','QUINUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (452,'05','AYACUCHO','0501','HUAMANGA','050109','SAN JOSE DE TICLLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (453,'05','AYACUCHO','0501','HUAMANGA','050110','SAN JUAN BAUTISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (454,'05','AYACUCHO','0501','HUAMANGA','050111','SANTIAGO DE PISCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (455,'05','AYACUCHO','0501','HUAMANGA','050112','SOCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (456,'05','AYACUCHO','0501','HUAMANGA','050113','TAMBILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (457,'05','AYACUCHO','0501','HUAMANGA','050114','VINCHOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (458,'05','AYACUCHO','0501','HUAMANGA','050115','JESUS NAZARENO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (459,'05','AYACUCHO','0501','HUAMANGA','050116','ANDRES AVELINO CACERES DORREGARAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (460,'05','AYACUCHO','0502','CANGALLO','050201','CANGALLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (461,'05','AYACUCHO','0502','CANGALLO','050202','CHUSCHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (462,'05','AYACUCHO','0502','CANGALLO','050203','LOS MOROCHUCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (463,'05','AYACUCHO','0502','CANGALLO','050204','MARIA PARADO DE BELLIDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (464,'05','AYACUCHO','0502','CANGALLO','050205','PARAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (465,'05','AYACUCHO','0502','CANGALLO','050206','TOTOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (466,'05','AYACUCHO','0503','HUANCA SANCOS','050301','SANCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (467,'05','AYACUCHO','0503','HUANCA SANCOS','050302','CARAPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (468,'05','AYACUCHO','0503','HUANCA SANCOS','050303','SACSAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (469,'05','AYACUCHO','0503','HUANCA SANCOS','050304','SANTIAGO DE LUCANAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (470,'05','AYACUCHO','0504','HUANTA','050401','HUANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (471,'05','AYACUCHO','0504','HUANTA','050402','AYAHUANCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (472,'05','AYACUCHO','0504','HUANTA','050403','HUAMANGUILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (473,'05','AYACUCHO','0504','HUANTA','050404','IGUAIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (474,'05','AYACUCHO','0504','HUANTA','050405','LURICOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (475,'05','AYACUCHO','0504','HUANTA','050406','SANTILLANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (476,'05','AYACUCHO','0504','HUANTA','050407','SIVIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (477,'05','AYACUCHO','0504','HUANTA','050408','LLOCHEGUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (478,'05','AYACUCHO','0504','HUANTA','050409','CANAYRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (479,'05','AYACUCHO','0504','HUANTA','050410','UCHURACCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (480,'05','AYACUCHO','0504','HUANTA','050411','PUCACOLPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (481,'05','AYACUCHO','0504','HUANTA','050412','CHACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (482,'05','AYACUCHO','0505','LA MAR','050501','SAN MIGUEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (483,'05','AYACUCHO','0505','LA MAR','050502','ANCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (484,'05','AYACUCHO','0505','LA MAR','050503','AYNA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (485,'05','AYACUCHO','0505','LA MAR','050504','CHILCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (486,'05','AYACUCHO','0505','LA MAR','050505','CHUNGUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (487,'05','AYACUCHO','0505','LA MAR','050506','LUIS CARRANZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (488,'05','AYACUCHO','0505','LA MAR','050507','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (489,'05','AYACUCHO','0505','LA MAR','050508','TAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (490,'05','AYACUCHO','0505','LA MAR','050509','SAMUGARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (491,'05','AYACUCHO','0505','LA MAR','050510','ANCHIHUAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (492,'05','AYACUCHO','0505','LA MAR','050511','ORONCCOY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (493,'05','AYACUCHO','0506','LUCANAS','050601','PUQUIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (494,'05','AYACUCHO','0506','LUCANAS','050602','AUCARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (495,'05','AYACUCHO','0506','LUCANAS','050603','CABANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (496,'05','AYACUCHO','0506','LUCANAS','050604','CARMEN SALCEDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (497,'05','AYACUCHO','0506','LUCANAS','050605','CHAVIÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (498,'05','AYACUCHO','0506','LUCANAS','050606','CHIPAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (499,'05','AYACUCHO','0506','LUCANAS','050607','HUAC-HUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (500,'05','AYACUCHO','0506','LUCANAS','050608','LARAMATE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (501,'05','AYACUCHO','0506','LUCANAS','050609','LEONCIO PRADO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (502,'05','AYACUCHO','0506','LUCANAS','050610','LLAUTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (503,'05','AYACUCHO','0506','LUCANAS','050611','LUCANAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (504,'05','AYACUCHO','0506','LUCANAS','050612','OCAÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (505,'05','AYACUCHO','0506','LUCANAS','050613','OTOCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (506,'05','AYACUCHO','0506','LUCANAS','050614','SAISA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (507,'05','AYACUCHO','0506','LUCANAS','050615','SAN CRISTOBAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (508,'05','AYACUCHO','0506','LUCANAS','050616','SAN JUAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (509,'05','AYACUCHO','0506','LUCANAS','050617','SAN PEDRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (510,'05','AYACUCHO','0506','LUCANAS','050618','SAN PEDRO DE PALCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (511,'05','AYACUCHO','0506','LUCANAS','050619','SANCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (512,'05','AYACUCHO','0506','LUCANAS','050620','SANTA ANA DE HUAYCAHUACHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (513,'05','AYACUCHO','0506','LUCANAS','050621','SANTA LUCIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (514,'05','AYACUCHO','0507','PARINACOCHAS','050701','CORACORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (515,'05','AYACUCHO','0507','PARINACOCHAS','050702','CHUMPI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (516,'05','AYACUCHO','0507','PARINACOCHAS','050703','CORONEL CASTAÑEDA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (517,'05','AYACUCHO','0507','PARINACOCHAS','050704','PACAPAUSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (518,'05','AYACUCHO','0507','PARINACOCHAS','050705','PULLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (519,'05','AYACUCHO','0507','PARINACOCHAS','050706','PUYUSCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (520,'05','AYACUCHO','0507','PARINACOCHAS','050707','SAN FRANCISCO DE RAVACAYCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (521,'05','AYACUCHO','0507','PARINACOCHAS','050708','UPAHUACHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (522,'05','AYACUCHO','0508','PAUCAR DEL SARA SARA','050801','PAUSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (523,'05','AYACUCHO','0508','PAUCAR DEL SARA SARA','050802','COLTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (524,'05','AYACUCHO','0508','PAUCAR DEL SARA SARA','050803','CORCULLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (525,'05','AYACUCHO','0508','PAUCAR DEL SARA SARA','050804','LAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (526,'05','AYACUCHO','0508','PAUCAR DEL SARA SARA','050805','MARCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (527,'05','AYACUCHO','0508','PAUCAR DEL SARA SARA','050806','OYOLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (528,'05','AYACUCHO','0508','PAUCAR DEL SARA SARA','050807','PARARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (529,'05','AYACUCHO','0508','PAUCAR DEL SARA SARA','050808','SAN JAVIER DE ALPABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (530,'05','AYACUCHO','0508','PAUCAR DEL SARA SARA','050809','SAN JOSE DE USHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (531,'05','AYACUCHO','0508','PAUCAR DEL SARA SARA','050810','SARA SARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (532,'05','AYACUCHO','0509','SUCRE','050901','QUEROBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (533,'05','AYACUCHO','0509','SUCRE','050902','BELEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (534,'05','AYACUCHO','0509','SUCRE','050903','CHALCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (535,'05','AYACUCHO','0509','SUCRE','050904','CHILCAYOC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (536,'05','AYACUCHO','0509','SUCRE','050905','HUACAÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (537,'05','AYACUCHO','0509','SUCRE','050906','MORCOLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (538,'05','AYACUCHO','0509','SUCRE','050907','PAICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (539,'05','AYACUCHO','0509','SUCRE','050908','SAN PEDRO DE LARCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (540,'05','AYACUCHO','0509','SUCRE','050909','SAN SALVADOR DE QUIJE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (541,'05','AYACUCHO','0509','SUCRE','050910','SANTIAGO DE PAUCARAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (542,'05','AYACUCHO','0509','SUCRE','050911','SORAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (543,'05','AYACUCHO','0510','VICTOR FAJARDO','051001','HUANCAPI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (544,'05','AYACUCHO','0510','VICTOR FAJARDO','051002','ALCAMENCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (545,'05','AYACUCHO','0510','VICTOR FAJARDO','051003','APONGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (546,'05','AYACUCHO','0510','VICTOR FAJARDO','051004','ASQUIPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (547,'05','AYACUCHO','0510','VICTOR FAJARDO','051005','CANARIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (548,'05','AYACUCHO','0510','VICTOR FAJARDO','051006','CAYARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (549,'05','AYACUCHO','0510','VICTOR FAJARDO','051007','COLCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (550,'05','AYACUCHO','0510','VICTOR FAJARDO','051008','HUAMANQUIQUIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (551,'05','AYACUCHO','0510','VICTOR FAJARDO','051009','HUANCARAYLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (552,'05','AYACUCHO','0510','VICTOR FAJARDO','051010','HUAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (553,'05','AYACUCHO','0510','VICTOR FAJARDO','051011','SARHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (554,'05','AYACUCHO','0510','VICTOR FAJARDO','051012','VILCANCHOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (555,'05','AYACUCHO','0511','VILCAS HUAMAN','051101','VILCAS HUAMAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (556,'05','AYACUCHO','0511','VILCAS HUAMAN','051102','ACCOMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (557,'05','AYACUCHO','0511','VILCAS HUAMAN','051103','CARHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (558,'05','AYACUCHO','0511','VILCAS HUAMAN','051104','CONCEPCION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (559,'05','AYACUCHO','0511','VILCAS HUAMAN','051105','HUAMBALPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (560,'05','AYACUCHO','0511','VILCAS HUAMAN','051106','INDEPENDENCIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (561,'05','AYACUCHO','0511','VILCAS HUAMAN','051107','SAURAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (562,'05','AYACUCHO','0511','VILCAS HUAMAN','051108','VISCHONGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (563,'06','CAJAMARCA','0601','CAJAMARCA','060101','CAJAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (564,'06','CAJAMARCA','0601','CAJAMARCA','060102','ASUNCION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (565,'06','CAJAMARCA','0601','CAJAMARCA','060103','CHETILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (566,'06','CAJAMARCA','0601','CAJAMARCA','060104','COSPAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (567,'06','CAJAMARCA','0601','CAJAMARCA','060105','ENCAÑADA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (568,'06','CAJAMARCA','0601','CAJAMARCA','060106','JESUS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (569,'06','CAJAMARCA','0601','CAJAMARCA','060107','LLACANORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (570,'06','CAJAMARCA','0601','CAJAMARCA','060108','LOS BAÑOS DEL INCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (571,'06','CAJAMARCA','0601','CAJAMARCA','060109','MAGDALENA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (572,'06','CAJAMARCA','0601','CAJAMARCA','060110','MATARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (573,'06','CAJAMARCA','0601','CAJAMARCA','060111','NAMORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (574,'06','CAJAMARCA','0601','CAJAMARCA','060112','SAN JUAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (575,'06','CAJAMARCA','0602','CAJABAMBA','060201','CAJABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (576,'06','CAJAMARCA','0602','CAJABAMBA','060202','CACHACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (577,'06','CAJAMARCA','0602','CAJABAMBA','060203','CONDEBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (578,'06','CAJAMARCA','0602','CAJABAMBA','060204','SITACOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (579,'06','CAJAMARCA','0603','CELENDIN','060301','CELENDIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (580,'06','CAJAMARCA','0603','CELENDIN','060302','CHUMUCH')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (581,'06','CAJAMARCA','0603','CELENDIN','060303','CORTEGANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (582,'06','CAJAMARCA','0603','CELENDIN','060304','HUASMIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (583,'06','CAJAMARCA','0603','CELENDIN','060305','JORGE CHAVEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (584,'06','CAJAMARCA','0603','CELENDIN','060306','JOSE GALVEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (585,'06','CAJAMARCA','0603','CELENDIN','060307','MIGUEL IGLESIAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (586,'06','CAJAMARCA','0603','CELENDIN','060308','OXAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (587,'06','CAJAMARCA','0603','CELENDIN','060309','SOROCHUCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (588,'06','CAJAMARCA','0603','CELENDIN','060310','SUCRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (589,'06','CAJAMARCA','0603','CELENDIN','060311','UTCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (590,'06','CAJAMARCA','0603','CELENDIN','060312','LA LIBERTAD DE PALLAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (591,'06','CAJAMARCA','0604','CHOTA','060401','CHOTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (592,'06','CAJAMARCA','0604','CHOTA','060402','ANGUIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (593,'06','CAJAMARCA','0604','CHOTA','060403','CHADIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (594,'06','CAJAMARCA','0604','CHOTA','060404','CHIGUIRIP')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (595,'06','CAJAMARCA','0604','CHOTA','060405','CHIMBAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (596,'06','CAJAMARCA','0604','CHOTA','060406','CHOROPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (597,'06','CAJAMARCA','0604','CHOTA','060407','COCHABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (598,'06','CAJAMARCA','0604','CHOTA','060408','CONCHAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (599,'06','CAJAMARCA','0604','CHOTA','060409','HUAMBOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (600,'06','CAJAMARCA','0604','CHOTA','060410','LAJAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (601,'06','CAJAMARCA','0604','CHOTA','060411','LLAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (602,'06','CAJAMARCA','0604','CHOTA','060412','MIRACOSTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (603,'06','CAJAMARCA','0604','CHOTA','060413','PACCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (604,'06','CAJAMARCA','0604','CHOTA','060414','PION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (605,'06','CAJAMARCA','0604','CHOTA','060415','QUEROCOTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (606,'06','CAJAMARCA','0604','CHOTA','060416','SAN JUAN DE LICUPIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (607,'06','CAJAMARCA','0604','CHOTA','060417','TACABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (608,'06','CAJAMARCA','0604','CHOTA','060418','TOCMOCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (609,'06','CAJAMARCA','0604','CHOTA','060419','CHALAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (610,'06','CAJAMARCA','0605','CONTUMAZA','060501','CONTUMAZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (611,'06','CAJAMARCA','0605','CONTUMAZA','060502','CHILETE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (612,'06','CAJAMARCA','0605','CONTUMAZA','060503','CUPISNIQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (613,'06','CAJAMARCA','0605','CONTUMAZA','060504','GUZMANGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (614,'06','CAJAMARCA','0605','CONTUMAZA','060505','SAN BENITO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (615,'06','CAJAMARCA','0605','CONTUMAZA','060506','SANTA CRUZ DE TOLEDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (616,'06','CAJAMARCA','0605','CONTUMAZA','060507','TANTARICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (617,'06','CAJAMARCA','0605','CONTUMAZA','060508','YONAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (618,'06','CAJAMARCA','0606','CUTERVO','060601','CUTERVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (619,'06','CAJAMARCA','0606','CUTERVO','060602','CALLAYUC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (620,'06','CAJAMARCA','0606','CUTERVO','060603','CHOROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (621,'06','CAJAMARCA','0606','CUTERVO','060604','CUJILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (622,'06','CAJAMARCA','0606','CUTERVO','060605','LA RAMADA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (623,'06','CAJAMARCA','0606','CUTERVO','060606','PIMPINGOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (624,'06','CAJAMARCA','0606','CUTERVO','060607','QUEROCOTILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (625,'06','CAJAMARCA','0606','CUTERVO','060608','SAN ANDRES DE CUTERVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (626,'06','CAJAMARCA','0606','CUTERVO','060609','SAN JUAN DE CUTERVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (627,'06','CAJAMARCA','0606','CUTERVO','060610','SAN LUIS DE LUCMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (628,'06','CAJAMARCA','0606','CUTERVO','060611','SANTA CRUZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (629,'06','CAJAMARCA','0606','CUTERVO','060612','SANTO DOMINGO DE LA CAPILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (630,'06','CAJAMARCA','0606','CUTERVO','060613','SANTO TOMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (631,'06','CAJAMARCA','0606','CUTERVO','060614','SOCOTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (632,'06','CAJAMARCA','0606','CUTERVO','060615','TORIBIO CASANOVA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (633,'06','CAJAMARCA','0607','HUALGAYOC','060701','BAMBAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (634,'06','CAJAMARCA','0607','HUALGAYOC','060702','CHUGUR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (635,'06','CAJAMARCA','0607','HUALGAYOC','060703','HUALGAYOC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (636,'06','CAJAMARCA','0608','JAEN','060801','JAEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (637,'06','CAJAMARCA','0608','JAEN','060802','BELLAVISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (638,'06','CAJAMARCA','0608','JAEN','060803','CHONTALI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (639,'06','CAJAMARCA','0608','JAEN','060804','COLASAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (640,'06','CAJAMARCA','0608','JAEN','060805','HUABAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (641,'06','CAJAMARCA','0608','JAEN','060806','LAS PIRIAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (642,'06','CAJAMARCA','0608','JAEN','060807','POMAHUACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (643,'06','CAJAMARCA','0608','JAEN','060808','PUCARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (644,'06','CAJAMARCA','0608','JAEN','060809','SALLIQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (645,'06','CAJAMARCA','0608','JAEN','060810','SAN FELIPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (646,'06','CAJAMARCA','0608','JAEN','060811','SAN JOSE DEL ALTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (647,'06','CAJAMARCA','0608','JAEN','060812','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (648,'06','CAJAMARCA','0609','SAN IGNACIO','060901','SAN IGNACIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (649,'06','CAJAMARCA','0609','SAN IGNACIO','060902','CHIRINOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (650,'06','CAJAMARCA','0609','SAN IGNACIO','060903','HUARANGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (651,'06','CAJAMARCA','0609','SAN IGNACIO','060904','LA COIPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (652,'06','CAJAMARCA','0609','SAN IGNACIO','060905','NAMBALLE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (653,'06','CAJAMARCA','0609','SAN IGNACIO','060906','SAN JOSE DE LOURDES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (654,'06','CAJAMARCA','0609','SAN IGNACIO','060907','TABACONAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (655,'06','CAJAMARCA','0610','SAN MARCOS','061001','PEDRO GALVEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (656,'06','CAJAMARCA','0610','SAN MARCOS','061002','CHANCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (657,'06','CAJAMARCA','0610','SAN MARCOS','061003','EDUARDO VILLANUEVA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (658,'06','CAJAMARCA','0610','SAN MARCOS','061004','GREGORIO PITA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (659,'06','CAJAMARCA','0610','SAN MARCOS','061005','ICHOCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (660,'06','CAJAMARCA','0610','SAN MARCOS','061006','JOSE MANUEL QUIROZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (661,'06','CAJAMARCA','0610','SAN MARCOS','061007','JOSE SABOGAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (662,'06','CAJAMARCA','0611','SAN MIGUEL','061101','SAN MIGUEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (663,'06','CAJAMARCA','0611','SAN MIGUEL','061102','BOLIVAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (664,'06','CAJAMARCA','0611','SAN MIGUEL','061103','CALQUIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (665,'06','CAJAMARCA','0611','SAN MIGUEL','061104','CATILLUC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (666,'06','CAJAMARCA','0611','SAN MIGUEL','061105','EL PRADO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (667,'06','CAJAMARCA','0611','SAN MIGUEL','061106','LA FLORIDA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (668,'06','CAJAMARCA','0611','SAN MIGUEL','061107','LLAPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (669,'06','CAJAMARCA','0611','SAN MIGUEL','061108','NANCHOC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (670,'06','CAJAMARCA','0611','SAN MIGUEL','061109','NIEPOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (671,'06','CAJAMARCA','0611','SAN MIGUEL','061110','SAN GREGORIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (672,'06','CAJAMARCA','0611','SAN MIGUEL','061111','SAN SILVESTRE DE COCHAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (673,'06','CAJAMARCA','0611','SAN MIGUEL','061112','TONGOD')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (674,'06','CAJAMARCA','0611','SAN MIGUEL','061113','UNION AGUA BLANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (675,'06','CAJAMARCA','0612','SAN PABLO','061201','SAN PABLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (676,'06','CAJAMARCA','0612','SAN PABLO','061202','SAN BERNARDINO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (677,'06','CAJAMARCA','0612','SAN PABLO','061203','SAN LUIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (678,'06','CAJAMARCA','0612','SAN PABLO','061204','TUMBADEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (679,'06','CAJAMARCA','0613','SANTA CRUZ','061301','SANTA CRUZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (680,'06','CAJAMARCA','0613','SANTA CRUZ','061302','ANDABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (681,'06','CAJAMARCA','0613','SANTA CRUZ','061303','CATACHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (682,'06','CAJAMARCA','0613','SANTA CRUZ','061304','CHANCAYBAÑOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (683,'06','CAJAMARCA','0613','SANTA CRUZ','061305','LA ESPERANZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (684,'06','CAJAMARCA','0613','SANTA CRUZ','061306','NINABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (685,'06','CAJAMARCA','0613','SANTA CRUZ','061307','PULAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (686,'06','CAJAMARCA','0613','SANTA CRUZ','061308','SAUCEPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (687,'06','CAJAMARCA','0613','SANTA CRUZ','061309','SEXI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (688,'06','CAJAMARCA','0613','SANTA CRUZ','061310','UTICYACU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (689,'06','CAJAMARCA','0613','SANTA CRUZ','061311','YAUYUCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (690,'07','CALLAO','0701','CALLAO','070101','CALLAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (691,'07','CALLAO','0701','CALLAO','070102','BELLAVISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (692,'07','CALLAO','0701','CALLAO','070103','CARMEN DE LA LEGUA REYNOSO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (693,'07','CALLAO','0701','CALLAO','070104','LA PERLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (694,'07','CALLAO','0701','CALLAO','070105','LA PUNTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (695,'07','CALLAO','0701','CALLAO','070106','VENTANILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (696,'07','CALLAO','0701','CALLAO','070107','MI PERU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (697,'08','CUSCO','0801','CUSCO','080101','CUSCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (698,'08','CUSCO','0801','CUSCO','080102','CCORCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (699,'08','CUSCO','0801','CUSCO','080103','POROY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (700,'08','CUSCO','0801','CUSCO','080104','SAN JERONIMO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (701,'08','CUSCO','0801','CUSCO','080105','SAN SEBASTIAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (702,'08','CUSCO','0801','CUSCO','080106','SANTIAGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (703,'08','CUSCO','0801','CUSCO','080107','SAYLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (704,'08','CUSCO','0801','CUSCO','080108','WANCHAQ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (705,'08','CUSCO','0802','ACOMAYO','080201','ACOMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (706,'08','CUSCO','0802','ACOMAYO','080202','ACOPIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (707,'08','CUSCO','0802','ACOMAYO','080203','ACOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (708,'08','CUSCO','0802','ACOMAYO','080204','MOSOC LLACTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (709,'08','CUSCO','0802','ACOMAYO','080205','POMACANCHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (710,'08','CUSCO','0802','ACOMAYO','080206','RONDOCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (711,'08','CUSCO','0802','ACOMAYO','080207','SANGARARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (712,'08','CUSCO','0803','ANTA','080301','ANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (713,'08','CUSCO','0803','ANTA','080302','ANCAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (714,'08','CUSCO','0803','ANTA','080303','CACHIMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (715,'08','CUSCO','0803','ANTA','080304','CHINCHAYPUJIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (716,'08','CUSCO','0803','ANTA','080305','HUAROCONDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (717,'08','CUSCO','0803','ANTA','080306','LIMATAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (718,'08','CUSCO','0803','ANTA','080307','MOLLEPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (719,'08','CUSCO','0803','ANTA','080308','PUCYURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (720,'08','CUSCO','0803','ANTA','080309','ZURITE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (721,'08','CUSCO','0804','CALCA','080401','CALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (722,'08','CUSCO','0804','CALCA','080402','COYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (723,'08','CUSCO','0804','CALCA','080403','LAMAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (724,'08','CUSCO','0804','CALCA','080404','LARES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (725,'08','CUSCO','0804','CALCA','080405','PISAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (726,'08','CUSCO','0804','CALCA','080406','SAN SALVADOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (727,'08','CUSCO','0804','CALCA','080407','TARAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (728,'08','CUSCO','0804','CALCA','080408','YANATILE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (729,'08','CUSCO','0805','CANAS','080501','YANAOCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (730,'08','CUSCO','0805','CANAS','080502','CHECCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (731,'08','CUSCO','0805','CANAS','080503','KUNTURKANKI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (732,'08','CUSCO','0805','CANAS','080504','LANGUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (733,'08','CUSCO','0805','CANAS','080505','LAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (734,'08','CUSCO','0805','CANAS','080506','PAMPAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (735,'08','CUSCO','0805','CANAS','080507','QUEHUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (736,'08','CUSCO','0805','CANAS','080508','TUPAC AMARU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (737,'08','CUSCO','0806','CANCHIS','080601','SICUANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (738,'08','CUSCO','0806','CANCHIS','080602','CHECACUPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (739,'08','CUSCO','0806','CANCHIS','080603','COMBAPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (740,'08','CUSCO','0806','CANCHIS','080604','MARANGANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (741,'08','CUSCO','0806','CANCHIS','080605','PITUMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (742,'08','CUSCO','0806','CANCHIS','080606','SAN PABLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (743,'08','CUSCO','0806','CANCHIS','080607','SAN PEDRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (744,'08','CUSCO','0806','CANCHIS','080608','TINTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (745,'08','CUSCO','0807','CHUMBIVILCAS','080701','SANTO TOMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (746,'08','CUSCO','0807','CHUMBIVILCAS','080702','CAPACMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (747,'08','CUSCO','0807','CHUMBIVILCAS','080703','CHAMACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (748,'08','CUSCO','0807','CHUMBIVILCAS','080704','COLQUEMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (749,'08','CUSCO','0807','CHUMBIVILCAS','080705','LIVITACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (750,'08','CUSCO','0807','CHUMBIVILCAS','080706','LLUSCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (751,'08','CUSCO','0807','CHUMBIVILCAS','080707','QUIÑOTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (752,'08','CUSCO','0807','CHUMBIVILCAS','080708','VELILLE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (753,'08','CUSCO','0808','ESPINAR','080801','ESPINAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (754,'08','CUSCO','0808','ESPINAR','080802','CONDOROMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (755,'08','CUSCO','0808','ESPINAR','080803','COPORAQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (756,'08','CUSCO','0808','ESPINAR','080804','OCORURO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (757,'08','CUSCO','0808','ESPINAR','080805','PALLPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (758,'08','CUSCO','0808','ESPINAR','080806','PICHIGUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (759,'08','CUSCO','0808','ESPINAR','080807','SUYCKUTAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (760,'08','CUSCO','0808','ESPINAR','080808','ALTO PICHIGUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (761,'08','CUSCO','0809','LA CONVENCION','080901','SANTA ANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (762,'08','CUSCO','0809','LA CONVENCION','080902','ECHARATE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (763,'08','CUSCO','0809','LA CONVENCION','080903','HUAYOPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (764,'08','CUSCO','0809','LA CONVENCION','080904','MARANURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (765,'08','CUSCO','0809','LA CONVENCION','080905','OCOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (766,'08','CUSCO','0809','LA CONVENCION','080906','QUELLOUNO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (767,'08','CUSCO','0809','LA CONVENCION','080907','KIMBIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (768,'08','CUSCO','0809','LA CONVENCION','080908','SANTA TERESA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (769,'08','CUSCO','0809','LA CONVENCION','080909','VILCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (770,'08','CUSCO','0809','LA CONVENCION','080910','PICHARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (771,'08','CUSCO','0809','LA CONVENCION','080911','INKAWASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (772,'08','CUSCO','0809','LA CONVENCION','080912','VILLA VIRGEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (773,'08','CUSCO','0809','LA CONVENCION','080913','VILLA KINTIARINA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (774,'08','CUSCO','0809','LA CONVENCION','080914','MEGANTONI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (775,'08','CUSCO','0810','PARURO','081001','PARURO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (776,'08','CUSCO','0810','PARURO','081002','ACCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (777,'08','CUSCO','0810','PARURO','081003','CCAPI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (778,'08','CUSCO','0810','PARURO','081004','COLCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (779,'08','CUSCO','0810','PARURO','081005','HUANOQUITE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (780,'08','CUSCO','0810','PARURO','081006','OMACHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (781,'08','CUSCO','0810','PARURO','081007','PACCARITAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (782,'08','CUSCO','0810','PARURO','081008','PILLPINTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (783,'08','CUSCO','0810','PARURO','081009','YAURISQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (784,'08','CUSCO','0811','PAUCARTAMBO','081101','PAUCARTAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (785,'08','CUSCO','0811','PAUCARTAMBO','081102','CAICAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (786,'08','CUSCO','0811','PAUCARTAMBO','081103','CHALLABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (787,'08','CUSCO','0811','PAUCARTAMBO','081104','COLQUEPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (788,'08','CUSCO','0811','PAUCARTAMBO','081105','HUANCARANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (789,'08','CUSCO','0811','PAUCARTAMBO','081106','KOSÑIPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (790,'08','CUSCO','0812','QUISPICANCHI','081201','URCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (791,'08','CUSCO','0812','QUISPICANCHI','081202','ANDAHUAYLILLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (792,'08','CUSCO','0812','QUISPICANCHI','081203','CAMANTI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (793,'08','CUSCO','0812','QUISPICANCHI','081204','CCARHUAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (794,'08','CUSCO','0812','QUISPICANCHI','081205','CCATCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (795,'08','CUSCO','0812','QUISPICANCHI','081206','CUSIPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (796,'08','CUSCO','0812','QUISPICANCHI','081207','HUARO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (797,'08','CUSCO','0812','QUISPICANCHI','081208','LUCRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (798,'08','CUSCO','0812','QUISPICANCHI','081209','MARCAPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (799,'08','CUSCO','0812','QUISPICANCHI','081210','OCONGATE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (800,'08','CUSCO','0812','QUISPICANCHI','081211','OROPESA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (801,'08','CUSCO','0812','QUISPICANCHI','081212','QUIQUIJANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (802,'08','CUSCO','0813','URUBAMBA','081301','URUBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (803,'08','CUSCO','0813','URUBAMBA','081302','CHINCHERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (804,'08','CUSCO','0813','URUBAMBA','081303','HUAYLLABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (805,'08','CUSCO','0813','URUBAMBA','081304','MACHUPICCHU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (806,'08','CUSCO','0813','URUBAMBA','081305','MARAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (807,'08','CUSCO','0813','URUBAMBA','081306','OLLANTAYTAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (808,'08','CUSCO','0813','URUBAMBA','081307','YUCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (809,'09','HUANCAVELICA','0901','HUANCAVELICA','090101','HUANCAVELICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (810,'09','HUANCAVELICA','0901','HUANCAVELICA','090102','ACOBAMBILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (811,'09','HUANCAVELICA','0901','HUANCAVELICA','090103','ACORIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (812,'09','HUANCAVELICA','0901','HUANCAVELICA','090104','CONAYCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (813,'09','HUANCAVELICA','0901','HUANCAVELICA','090105','CUENCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (814,'09','HUANCAVELICA','0901','HUANCAVELICA','090106','HUACHOCOLPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (815,'09','HUANCAVELICA','0901','HUANCAVELICA','090107','HUAYLLAHUARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (816,'09','HUANCAVELICA','0901','HUANCAVELICA','090108','IZCUCHACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (817,'09','HUANCAVELICA','0901','HUANCAVELICA','090109','LARIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (818,'09','HUANCAVELICA','0901','HUANCAVELICA','090110','MANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (819,'09','HUANCAVELICA','0901','HUANCAVELICA','090111','MARISCAL CACERES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (820,'09','HUANCAVELICA','0901','HUANCAVELICA','090112','MOYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (821,'09','HUANCAVELICA','0901','HUANCAVELICA','090113','NUEVO OCCORO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (822,'09','HUANCAVELICA','0901','HUANCAVELICA','090114','PALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (823,'09','HUANCAVELICA','0901','HUANCAVELICA','090115','PILCHACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (824,'09','HUANCAVELICA','0901','HUANCAVELICA','090116','VILCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (825,'09','HUANCAVELICA','0901','HUANCAVELICA','090117','YAULI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (826,'09','HUANCAVELICA','0901','HUANCAVELICA','090118','ASCENSION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (827,'09','HUANCAVELICA','0901','HUANCAVELICA','090119','HUANDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (828,'09','HUANCAVELICA','0902','ACOBAMBA','090201','ACOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (829,'09','HUANCAVELICA','0902','ACOBAMBA','090202','ANDABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (830,'09','HUANCAVELICA','0902','ACOBAMBA','090203','ANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (831,'09','HUANCAVELICA','0902','ACOBAMBA','090204','CAJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (832,'09','HUANCAVELICA','0902','ACOBAMBA','090205','MARCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (833,'09','HUANCAVELICA','0902','ACOBAMBA','090206','PAUCARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (834,'09','HUANCAVELICA','0902','ACOBAMBA','090207','POMACOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (835,'09','HUANCAVELICA','0902','ACOBAMBA','090208','ROSARIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (836,'09','HUANCAVELICA','0903','ANGARAES','090301','LIRCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (837,'09','HUANCAVELICA','0903','ANGARAES','090302','ANCHONGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (838,'09','HUANCAVELICA','0903','ANGARAES','090303','CALLANMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (839,'09','HUANCAVELICA','0903','ANGARAES','090304','CCOCHACCASA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (840,'09','HUANCAVELICA','0903','ANGARAES','090305','CHINCHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (841,'09','HUANCAVELICA','0903','ANGARAES','090306','CONGALLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (842,'09','HUANCAVELICA','0903','ANGARAES','090307','HUANCA-HUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (843,'09','HUANCAVELICA','0903','ANGARAES','090308','HUAYLLAY GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (844,'09','HUANCAVELICA','0903','ANGARAES','090309','JULCAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (845,'09','HUANCAVELICA','0903','ANGARAES','090310','SAN ANTONIO DE ANTAPARCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (846,'09','HUANCAVELICA','0903','ANGARAES','090311','SANTO TOMAS DE PATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (847,'09','HUANCAVELICA','0903','ANGARAES','090312','SECCLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (848,'09','HUANCAVELICA','0904','CASTROVIRREYNA','090401','CASTROVIRREYNA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (849,'09','HUANCAVELICA','0904','CASTROVIRREYNA','090402','ARMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (850,'09','HUANCAVELICA','0904','CASTROVIRREYNA','090403','AURAHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (851,'09','HUANCAVELICA','0904','CASTROVIRREYNA','090404','CAPILLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (852,'09','HUANCAVELICA','0904','CASTROVIRREYNA','090405','CHUPAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (853,'09','HUANCAVELICA','0904','CASTROVIRREYNA','090406','COCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (854,'09','HUANCAVELICA','0904','CASTROVIRREYNA','090407','HUACHOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (855,'09','HUANCAVELICA','0904','CASTROVIRREYNA','090408','HUAMATAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (856,'09','HUANCAVELICA','0904','CASTROVIRREYNA','090409','MOLLEPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (857,'09','HUANCAVELICA','0904','CASTROVIRREYNA','090410','SAN JUAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (858,'09','HUANCAVELICA','0904','CASTROVIRREYNA','090411','SANTA ANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (859,'09','HUANCAVELICA','0904','CASTROVIRREYNA','090412','TANTARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (860,'09','HUANCAVELICA','0904','CASTROVIRREYNA','090413','TICRAPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (861,'09','HUANCAVELICA','0905','CHURCAMPA','090501','CHURCAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (862,'09','HUANCAVELICA','0905','CHURCAMPA','090502','ANCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (863,'09','HUANCAVELICA','0905','CHURCAMPA','090503','CHINCHIHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (864,'09','HUANCAVELICA','0905','CHURCAMPA','090504','EL CARMEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (865,'09','HUANCAVELICA','0905','CHURCAMPA','090505','LA MERCED')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (866,'09','HUANCAVELICA','0905','CHURCAMPA','090506','LOCROJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (867,'09','HUANCAVELICA','0905','CHURCAMPA','090507','PAUCARBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (868,'09','HUANCAVELICA','0905','CHURCAMPA','090508','SAN MIGUEL DE MAYOCC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (869,'09','HUANCAVELICA','0905','CHURCAMPA','090509','SAN PEDRO DE CORIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (870,'09','HUANCAVELICA','0905','CHURCAMPA','090510','PACHAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (871,'09','HUANCAVELICA','0905','CHURCAMPA','090511','COSME')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (872,'09','HUANCAVELICA','0906','HUAYTARA','090601','HUAYTARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (873,'09','HUANCAVELICA','0906','HUAYTARA','090602','AYAVI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (874,'09','HUANCAVELICA','0906','HUAYTARA','090603','CORDOVA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (875,'09','HUANCAVELICA','0906','HUAYTARA','090604','HUAYACUNDO ARMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (876,'09','HUANCAVELICA','0906','HUAYTARA','090605','LARAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (877,'09','HUANCAVELICA','0906','HUAYTARA','090606','OCOYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (878,'09','HUANCAVELICA','0906','HUAYTARA','090607','PILPICHACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (879,'09','HUANCAVELICA','0906','HUAYTARA','090608','QUERCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (880,'09','HUANCAVELICA','0906','HUAYTARA','090609','QUITO-ARMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (881,'09','HUANCAVELICA','0906','HUAYTARA','090610','SAN ANTONIO DE CUSICANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (882,'09','HUANCAVELICA','0906','HUAYTARA','090611','SAN FRANCISCO DE SANGAYAICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (883,'09','HUANCAVELICA','0906','HUAYTARA','090612','SAN ISIDRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (884,'09','HUANCAVELICA','0906','HUAYTARA','090613','SANTIAGO DE CHOCORVOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (885,'09','HUANCAVELICA','0906','HUAYTARA','090614','SANTIAGO DE QUIRAHUARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (886,'09','HUANCAVELICA','0906','HUAYTARA','090615','SANTO DOMINGO DE CAPILLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (887,'09','HUANCAVELICA','0906','HUAYTARA','090616','TAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (888,'09','HUANCAVELICA','0907','TAYACAJA','090701','PAMPAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (889,'09','HUANCAVELICA','0907','TAYACAJA','090702','ACOSTAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (890,'09','HUANCAVELICA','0907','TAYACAJA','090703','ACRAQUIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (891,'09','HUANCAVELICA','0907','TAYACAJA','090704','AHUAYCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (892,'09','HUANCAVELICA','0907','TAYACAJA','090705','COLCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (893,'09','HUANCAVELICA','0907','TAYACAJA','090706','DANIEL HERNANDEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (894,'09','HUANCAVELICA','0907','TAYACAJA','090707','HUACHOCOLPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (895,'09','HUANCAVELICA','0907','TAYACAJA','090709','HUARIBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (896,'09','HUANCAVELICA','0907','TAYACAJA','090710','ÑAHUIMPUQUIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (897,'09','HUANCAVELICA','0907','TAYACAJA','090711','PAZOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (898,'09','HUANCAVELICA','0907','TAYACAJA','090713','QUISHUAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (899,'09','HUANCAVELICA','0907','TAYACAJA','090714','SALCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (900,'09','HUANCAVELICA','0907','TAYACAJA','090715','SALCAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (901,'09','HUANCAVELICA','0907','TAYACAJA','090716','SAN MARCOS DE ROCCHAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (902,'09','HUANCAVELICA','0907','TAYACAJA','090717','SURCUBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (903,'09','HUANCAVELICA','0907','TAYACAJA','090718','TINTAY PUNCU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (904,'09','HUANCAVELICA','0907','TAYACAJA','090719','QUICHUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (905,'09','HUANCAVELICA','0907','TAYACAJA','090720','ANDAYMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (906,'09','HUANCAVELICA','0907','TAYACAJA','090721','ROBLE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (907,'09','HUANCAVELICA','0907','TAYACAJA','090722','PICHOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (908,'09','HUANCAVELICA','0907','TAYACAJA','090723','SANTIAGO DE TUCUMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (909,'10','HUANUCO','1001','HUANUCO','100101','HUANUCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (910,'10','HUANUCO','1001','HUANUCO','100102','AMARILIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (911,'10','HUANUCO','1001','HUANUCO','100103','CHINCHAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (912,'10','HUANUCO','1001','HUANUCO','100104','CHURUBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (913,'10','HUANUCO','1001','HUANUCO','100105','MARGOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (914,'10','HUANUCO','1001','HUANUCO','100106','QUISQUI (KICHKI)')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (915,'10','HUANUCO','1001','HUANUCO','100107','SAN FRANCISCO DE CAYRAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (916,'10','HUANUCO','1001','HUANUCO','100108','SAN PEDRO DE CHAULAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (917,'10','HUANUCO','1001','HUANUCO','100109','SANTA MARIA DEL VALLE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (918,'10','HUANUCO','1001','HUANUCO','100110','YARUMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (919,'10','HUANUCO','1001','HUANUCO','100111','PILLCO MARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (920,'10','HUANUCO','1001','HUANUCO','100112','YACUS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (921,'10','HUANUCO','1001','HUANUCO','100113','SAN PABLO DE PILLAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (922,'10','HUANUCO','1002','AMBO','100201','AMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (923,'10','HUANUCO','1002','AMBO','100202','CAYNA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (924,'10','HUANUCO','1002','AMBO','100203','COLPAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (925,'10','HUANUCO','1002','AMBO','100204','CONCHAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (926,'10','HUANUCO','1002','AMBO','100205','HUACAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (927,'10','HUANUCO','1002','AMBO','100206','SAN FRANCISCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (928,'10','HUANUCO','1002','AMBO','100207','SAN RAFAEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (929,'10','HUANUCO','1002','AMBO','100208','TOMAY KICHWA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (930,'10','HUANUCO','1003','DOS DE MAYO','100301','LA UNION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (931,'10','HUANUCO','1003','DOS DE MAYO','100307','CHUQUIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (932,'10','HUANUCO','1003','DOS DE MAYO','100311','MARIAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (933,'10','HUANUCO','1003','DOS DE MAYO','100313','PACHAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (934,'10','HUANUCO','1003','DOS DE MAYO','100316','QUIVILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (935,'10','HUANUCO','1003','DOS DE MAYO','100317','RIPAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (936,'10','HUANUCO','1003','DOS DE MAYO','100321','SHUNQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (937,'10','HUANUCO','1003','DOS DE MAYO','100322','SILLAPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (938,'10','HUANUCO','1003','DOS DE MAYO','100323','YANAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (939,'10','HUANUCO','1004','HUACAYBAMBA','100401','HUACAYBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (940,'10','HUANUCO','1004','HUACAYBAMBA','100402','CANCHABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (941,'10','HUANUCO','1004','HUACAYBAMBA','100403','COCHABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (942,'10','HUANUCO','1004','HUACAYBAMBA','100404','PINRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (943,'10','HUANUCO','1005','HUAMALIES','100501','LLATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (944,'10','HUANUCO','1005','HUAMALIES','100502','ARANCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (945,'10','HUANUCO','1005','HUAMALIES','100503','CHAVIN DE PARIARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (946,'10','HUANUCO','1005','HUAMALIES','100504','JACAS GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (947,'10','HUANUCO','1005','HUAMALIES','100505','JIRCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (948,'10','HUANUCO','1005','HUAMALIES','100506','MIRAFLORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (949,'10','HUANUCO','1005','HUAMALIES','100507','MONZON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (950,'10','HUANUCO','1005','HUAMALIES','100508','PUNCHAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (951,'10','HUANUCO','1005','HUAMALIES','100509','PUÑOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (952,'10','HUANUCO','1005','HUAMALIES','100510','SINGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (953,'10','HUANUCO','1005','HUAMALIES','100511','TANTAMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (954,'10','HUANUCO','1006','LEONCIO PRADO','100601','RUPA-RUPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (955,'10','HUANUCO','1006','LEONCIO PRADO','100602','DANIEL ALOMIA ROBLES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (956,'10','HUANUCO','1006','LEONCIO PRADO','100603','HERMILIO VALDIZAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (957,'10','HUANUCO','1006','LEONCIO PRADO','100604','JOSE CRESPO Y CASTILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (958,'10','HUANUCO','1006','LEONCIO PRADO','100605','LUYANDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (959,'10','HUANUCO','1006','LEONCIO PRADO','100606','MARIANO DAMASO BERAUN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (960,'10','HUANUCO','1006','LEONCIO PRADO','100607','PUCAYACU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (961,'10','HUANUCO','1006','LEONCIO PRADO','100608','CASTILLO GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (962,'10','HUANUCO','1006','LEONCIO PRADO','100609','PUEBLO NUEVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (963,'10','HUANUCO','1006','LEONCIO PRADO','100610','SANTO DOMINGO DE ANDA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (964,'10','HUANUCO','1007','MARAÑON','100701','HUACRACHUCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (965,'10','HUANUCO','1007','MARAÑON','100702','CHOLON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (966,'10','HUANUCO','1007','MARAÑON','100703','SAN BUENAVENTURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (967,'10','HUANUCO','1007','MARAÑON','100704','LA MORADA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (968,'10','HUANUCO','1007','MARAÑON','100705','SANTA ROSA DE ALTO YANAJANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (969,'10','HUANUCO','1008','PACHITEA','100801','PANAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (970,'10','HUANUCO','1008','PACHITEA','100802','CHAGLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (971,'10','HUANUCO','1008','PACHITEA','100803','MOLINO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (972,'10','HUANUCO','1008','PACHITEA','100804','UMARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (973,'10','HUANUCO','1009','PUERTO INCA','100901','PUERTO INCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (974,'10','HUANUCO','1009','PUERTO INCA','100902','CODO DEL POZUZO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (975,'10','HUANUCO','1009','PUERTO INCA','100903','HONORIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (976,'10','HUANUCO','1009','PUERTO INCA','100904','TOURNAVISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (977,'10','HUANUCO','1009','PUERTO INCA','100905','YUYAPICHIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (978,'10','HUANUCO','1010','LAURICOCHA','101001','JESUS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (979,'10','HUANUCO','1010','LAURICOCHA','101002','BAÑOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (980,'10','HUANUCO','1010','LAURICOCHA','101003','JIVIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (981,'10','HUANUCO','1010','LAURICOCHA','101004','QUEROPALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (982,'10','HUANUCO','1010','LAURICOCHA','101005','RONDOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (983,'10','HUANUCO','1010','LAURICOCHA','101006','SAN FRANCISCO DE ASIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (984,'10','HUANUCO','1010','LAURICOCHA','101007','SAN MIGUEL DE CAURI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (985,'10','HUANUCO','1011','YAROWILCA','101101','CHAVINILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (986,'10','HUANUCO','1011','YAROWILCA','101102','CAHUAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (987,'10','HUANUCO','1011','YAROWILCA','101103','CHACABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (988,'10','HUANUCO','1011','YAROWILCA','101104','APARICIO POMARES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (989,'10','HUANUCO','1011','YAROWILCA','101105','JACAS CHICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (990,'10','HUANUCO','1011','YAROWILCA','101106','OBAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (991,'10','HUANUCO','1011','YAROWILCA','101107','PAMPAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (992,'10','HUANUCO','1011','YAROWILCA','101108','CHORAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (993,'11','ICA','1101','ICA','110101','ICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (994,'11','ICA','1101','ICA','110102','LA TINGUIÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (995,'11','ICA','1101','ICA','110103','LOS AQUIJES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (996,'11','ICA','1101','ICA','110104','OCUCAJE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (997,'11','ICA','1101','ICA','110105','PACHACUTEC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (998,'11','ICA','1101','ICA','110106','PARCONA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (999,'11','ICA','1101','ICA','110107','PUEBLO NUEVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1000,'11','ICA','1101','ICA','110108','SALAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1001,'11','ICA','1101','ICA','110109','SAN JOSE DE LOS MOLINOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1002,'11','ICA','1101','ICA','110110','SAN JUAN BAUTISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1003,'11','ICA','1101','ICA','110111','SANTIAGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1004,'11','ICA','1101','ICA','110112','SUBTANJALLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1005,'11','ICA','1101','ICA','110113','TATE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1006,'11','ICA','1101','ICA','110114','YAUCA DEL ROSARIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1007,'11','ICA','1102','CHINCHA','110201','CHINCHA ALTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1008,'11','ICA','1102','CHINCHA','110202','ALTO LARAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1009,'11','ICA','1102','CHINCHA','110203','CHAVIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1010,'11','ICA','1102','CHINCHA','110204','CHINCHA BAJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1011,'11','ICA','1102','CHINCHA','110205','EL CARMEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1012,'11','ICA','1102','CHINCHA','110206','GROCIO PRADO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1013,'11','ICA','1102','CHINCHA','110207','PUEBLO NUEVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1014,'11','ICA','1102','CHINCHA','110208','SAN JUAN DE YANAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1015,'11','ICA','1102','CHINCHA','110209','SAN PEDRO DE HUACARPANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1016,'11','ICA','1102','CHINCHA','110210','SUNAMPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1017,'11','ICA','1102','CHINCHA','110211','TAMBO DE MORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1018,'11','ICA','1103','NASCA','110301','NASCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1019,'11','ICA','1103','NASCA','110302','CHANGUILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1020,'11','ICA','1103','NASCA','110303','EL INGENIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1021,'11','ICA','1103','NASCA','110304','MARCONA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1022,'11','ICA','1103','NASCA','110305','VISTA ALEGRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1023,'11','ICA','1104','PALPA','110401','PALPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1024,'11','ICA','1104','PALPA','110402','LLIPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1025,'11','ICA','1104','PALPA','110403','RIO GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1026,'11','ICA','1104','PALPA','110404','SANTA CRUZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1027,'11','ICA','1104','PALPA','110405','TIBILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1028,'11','ICA','1105','PISCO','110501','PISCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1029,'11','ICA','1105','PISCO','110502','HUANCANO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1030,'11','ICA','1105','PISCO','110503','HUMAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1031,'11','ICA','1105','PISCO','110504','INDEPENDENCIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1032,'11','ICA','1105','PISCO','110505','PARACAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1033,'11','ICA','1105','PISCO','110506','SAN ANDRES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1034,'11','ICA','1105','PISCO','110507','SAN CLEMENTE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1035,'11','ICA','1105','PISCO','110508','TUPAC AMARU INCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1036,'12','JUNIN','1201','HUANCAYO','120101','HUANCAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1037,'12','JUNIN','1201','HUANCAYO','120104','CARHUACALLANGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1038,'12','JUNIN','1201','HUANCAYO','120105','CHACAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1039,'12','JUNIN','1201','HUANCAYO','120106','CHICCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1040,'12','JUNIN','1201','HUANCAYO','120107','CHILCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1041,'12','JUNIN','1201','HUANCAYO','120108','CHONGOS ALTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1042,'12','JUNIN','1201','HUANCAYO','120111','CHUPURO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1043,'12','JUNIN','1201','HUANCAYO','120112','COLCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1044,'12','JUNIN','1201','HUANCAYO','120113','CULLHUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1045,'12','JUNIN','1201','HUANCAYO','120114','EL TAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1046,'12','JUNIN','1201','HUANCAYO','120116','HUACRAPUQUIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1047,'12','JUNIN','1201','HUANCAYO','120117','HUALHUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1048,'12','JUNIN','1201','HUANCAYO','120119','HUANCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1049,'12','JUNIN','1201','HUANCAYO','120120','HUASICANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1050,'12','JUNIN','1201','HUANCAYO','120121','HUAYUCACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1051,'12','JUNIN','1201','HUANCAYO','120122','INGENIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1052,'12','JUNIN','1201','HUANCAYO','120124','PARIAHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1053,'12','JUNIN','1201','HUANCAYO','120125','PILCOMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1054,'12','JUNIN','1201','HUANCAYO','120126','PUCARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1055,'12','JUNIN','1201','HUANCAYO','120127','QUICHUAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1056,'12','JUNIN','1201','HUANCAYO','120128','QUILCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1057,'12','JUNIN','1201','HUANCAYO','120129','SAN AGUSTIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1058,'12','JUNIN','1201','HUANCAYO','120130','SAN JERONIMO DE TUNAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1059,'12','JUNIN','1201','HUANCAYO','120132','SAÑO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1060,'12','JUNIN','1201','HUANCAYO','120133','SAPALLANGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1061,'12','JUNIN','1201','HUANCAYO','120134','SICAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1062,'12','JUNIN','1201','HUANCAYO','120135','SANTO DOMINGO DE ACOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1063,'12','JUNIN','1201','HUANCAYO','120136','VIQUES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1064,'12','JUNIN','1202','CONCEPCION','120201','CONCEPCION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1065,'12','JUNIN','1202','CONCEPCION','120202','ACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1066,'12','JUNIN','1202','CONCEPCION','120203','ANDAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1067,'12','JUNIN','1202','CONCEPCION','120204','CHAMBARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1068,'12','JUNIN','1202','CONCEPCION','120205','COCHAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1069,'12','JUNIN','1202','CONCEPCION','120206','COMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1070,'12','JUNIN','1202','CONCEPCION','120207','HEROINAS TOLEDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1071,'12','JUNIN','1202','CONCEPCION','120208','MANZANARES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1072,'12','JUNIN','1202','CONCEPCION','120209','MARISCAL CASTILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1073,'12','JUNIN','1202','CONCEPCION','120210','MATAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1074,'12','JUNIN','1202','CONCEPCION','120211','MITO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1075,'12','JUNIN','1202','CONCEPCION','120212','NUEVE DE JULIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1076,'12','JUNIN','1202','CONCEPCION','120213','ORCOTUNA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1077,'12','JUNIN','1202','CONCEPCION','120214','SAN JOSE DE QUERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1078,'12','JUNIN','1202','CONCEPCION','120215','SANTA ROSA DE OCOPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1079,'12','JUNIN','1203','CHANCHAMAYO','120301','CHANCHAMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1080,'12','JUNIN','1203','CHANCHAMAYO','120302','PERENE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1081,'12','JUNIN','1203','CHANCHAMAYO','120303','PICHANAQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1082,'12','JUNIN','1203','CHANCHAMAYO','120304','SAN LUIS DE SHUARO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1083,'12','JUNIN','1203','CHANCHAMAYO','120305','SAN RAMON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1084,'12','JUNIN','1203','CHANCHAMAYO','120306','VITOC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1085,'12','JUNIN','1204','JAUJA','120401','JAUJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1086,'12','JUNIN','1204','JAUJA','120402','ACOLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1087,'12','JUNIN','1204','JAUJA','120403','APATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1088,'12','JUNIN','1204','JAUJA','120404','ATAURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1089,'12','JUNIN','1204','JAUJA','120405','CANCHAYLLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1090,'12','JUNIN','1204','JAUJA','120406','CURICACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1091,'12','JUNIN','1204','JAUJA','120407','EL MANTARO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1092,'12','JUNIN','1204','JAUJA','120408','HUAMALI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1093,'12','JUNIN','1204','JAUJA','120409','HUARIPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1094,'12','JUNIN','1204','JAUJA','120410','HUERTAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1095,'12','JUNIN','1204','JAUJA','120411','JANJAILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1096,'12','JUNIN','1204','JAUJA','120412','JULCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1097,'12','JUNIN','1204','JAUJA','120413','LEONOR ORDOÑEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1098,'12','JUNIN','1204','JAUJA','120414','LLOCLLAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1099,'12','JUNIN','1204','JAUJA','120415','MARCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1100,'12','JUNIN','1204','JAUJA','120416','MASMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1101,'12','JUNIN','1204','JAUJA','120417','MASMA CHICCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1102,'12','JUNIN','1204','JAUJA','120418','MOLINOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1103,'12','JUNIN','1204','JAUJA','120419','MONOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1104,'12','JUNIN','1204','JAUJA','120420','MUQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1105,'12','JUNIN','1204','JAUJA','120421','MUQUIYAUYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1106,'12','JUNIN','1204','JAUJA','120422','PACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1107,'12','JUNIN','1204','JAUJA','120423','PACCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1108,'12','JUNIN','1204','JAUJA','120424','PANCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1109,'12','JUNIN','1204','JAUJA','120425','PARCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1110,'12','JUNIN','1204','JAUJA','120426','POMACANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1111,'12','JUNIN','1204','JAUJA','120427','RICRAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1112,'12','JUNIN','1204','JAUJA','120428','SAN LORENZO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1113,'12','JUNIN','1204','JAUJA','120429','SAN PEDRO DE CHUNAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1114,'12','JUNIN','1204','JAUJA','120430','SAUSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1115,'12','JUNIN','1204','JAUJA','120431','SINCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1116,'12','JUNIN','1204','JAUJA','120432','TUNAN MARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1117,'12','JUNIN','1204','JAUJA','120433','YAULI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1118,'12','JUNIN','1204','JAUJA','120434','YAUYOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1119,'12','JUNIN','1205','JUNIN','120501','JUNIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1120,'12','JUNIN','1205','JUNIN','120502','CARHUAMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1121,'12','JUNIN','1205','JUNIN','120503','ONDORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1122,'12','JUNIN','1205','JUNIN','120504','ULCUMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1123,'12','JUNIN','1206','SATIPO','120601','SATIPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1124,'12','JUNIN','1206','SATIPO','120602','COVIRIALI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1125,'12','JUNIN','1206','SATIPO','120603','LLAYLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1126,'12','JUNIN','1206','SATIPO','120604','MAZAMARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1127,'12','JUNIN','1206','SATIPO','120605','PAMPA HERMOSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1128,'12','JUNIN','1206','SATIPO','120606','PANGOA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1129,'12','JUNIN','1206','SATIPO','120607','RIO NEGRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1130,'12','JUNIN','1206','SATIPO','120608','RIO TAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1131,'12','JUNIN','1206','SATIPO','120609','VIZCATAN DEL ENE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1132,'12','JUNIN','1207','TARMA','120701','TARMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1133,'12','JUNIN','1207','TARMA','120702','ACOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1134,'12','JUNIN','1207','TARMA','120703','HUARICOLCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1135,'12','JUNIN','1207','TARMA','120704','HUASAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1136,'12','JUNIN','1207','TARMA','120705','LA UNION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1137,'12','JUNIN','1207','TARMA','120706','PALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1138,'12','JUNIN','1207','TARMA','120707','PALCAMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1139,'12','JUNIN','1207','TARMA','120708','SAN PEDRO DE CAJAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1140,'12','JUNIN','1207','TARMA','120709','TAPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1141,'12','JUNIN','1208','YAULI','120801','LA OROYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1142,'12','JUNIN','1208','YAULI','120802','CHACAPALPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1143,'12','JUNIN','1208','YAULI','120803','HUAY-HUAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1144,'12','JUNIN','1208','YAULI','120804','MARCAPOMACOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1145,'12','JUNIN','1208','YAULI','120805','MOROCOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1146,'12','JUNIN','1208','YAULI','120806','PACCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1147,'12','JUNIN','1208','YAULI','120807','SANTA BARBARA DE CARHUACAYAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1148,'12','JUNIN','1208','YAULI','120808','SANTA ROSA DE SACCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1149,'12','JUNIN','1208','YAULI','120809','SUITUCANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1150,'12','JUNIN','1208','YAULI','120810','YAULI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1151,'12','JUNIN','1209','CHUPACA','120901','CHUPACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1152,'12','JUNIN','1209','CHUPACA','120902','AHUAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1153,'12','JUNIN','1209','CHUPACA','120903','CHONGOS BAJO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1154,'12','JUNIN','1209','CHUPACA','120904','HUACHAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1155,'12','JUNIN','1209','CHUPACA','120905','HUAMANCACA CHICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1156,'12','JUNIN','1209','CHUPACA','120906','SAN JUAN DE ISCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1157,'12','JUNIN','1209','CHUPACA','120907','SAN JUAN DE JARPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1158,'12','JUNIN','1209','CHUPACA','120908','TRES DE DICIEMBRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1159,'12','JUNIN','1209','CHUPACA','120909','YANACANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1160,'13','LA LIBERTAD','1301','TRUJILLO','130101','TRUJILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1161,'13','LA LIBERTAD','1301','TRUJILLO','130102','EL PORVENIR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1162,'13','LA LIBERTAD','1301','TRUJILLO','130103','FLORENCIA DE MORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1163,'13','LA LIBERTAD','1301','TRUJILLO','130104','HUANCHACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1164,'13','LA LIBERTAD','1301','TRUJILLO','130105','LA ESPERANZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1165,'13','LA LIBERTAD','1301','TRUJILLO','130106','LAREDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1166,'13','LA LIBERTAD','1301','TRUJILLO','130107','MOCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1167,'13','LA LIBERTAD','1301','TRUJILLO','130108','POROTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1168,'13','LA LIBERTAD','1301','TRUJILLO','130109','SALAVERRY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1169,'13','LA LIBERTAD','1301','TRUJILLO','130110','SIMBAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1170,'13','LA LIBERTAD','1301','TRUJILLO','130111','VICTOR LARCO HERRERA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1171,'13','LA LIBERTAD','1302','ASCOPE','130201','ASCOPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1172,'13','LA LIBERTAD','1302','ASCOPE','130202','CHICAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1173,'13','LA LIBERTAD','1302','ASCOPE','130203','CHOCOPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1174,'13','LA LIBERTAD','1302','ASCOPE','130204','MAGDALENA DE CAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1175,'13','LA LIBERTAD','1302','ASCOPE','130205','PAIJAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1176,'13','LA LIBERTAD','1302','ASCOPE','130206','RAZURI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1177,'13','LA LIBERTAD','1302','ASCOPE','130207','SANTIAGO DE CAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1178,'13','LA LIBERTAD','1302','ASCOPE','130208','CASA GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1179,'13','LA LIBERTAD','1303','BOLIVAR','130301','BOLIVAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1180,'13','LA LIBERTAD','1303','BOLIVAR','130302','BAMBAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1181,'13','LA LIBERTAD','1303','BOLIVAR','130303','CONDORMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1182,'13','LA LIBERTAD','1303','BOLIVAR','130304','LONGOTEA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1183,'13','LA LIBERTAD','1303','BOLIVAR','130305','UCHUMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1184,'13','LA LIBERTAD','1303','BOLIVAR','130306','UCUNCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1185,'13','LA LIBERTAD','1304','CHEPEN','130401','CHEPEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1186,'13','LA LIBERTAD','1304','CHEPEN','130402','PACANGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1187,'13','LA LIBERTAD','1304','CHEPEN','130403','PUEBLO NUEVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1188,'13','LA LIBERTAD','1305','JULCAN','130501','JULCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1189,'13','LA LIBERTAD','1305','JULCAN','130502','CALAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1190,'13','LA LIBERTAD','1305','JULCAN','130503','CARABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1191,'13','LA LIBERTAD','1305','JULCAN','130504','HUASO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1192,'13','LA LIBERTAD','1306','OTUZCO','130601','OTUZCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1193,'13','LA LIBERTAD','1306','OTUZCO','130602','AGALLPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1194,'13','LA LIBERTAD','1306','OTUZCO','130604','CHARAT')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1195,'13','LA LIBERTAD','1306','OTUZCO','130605','HUARANCHAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1196,'13','LA LIBERTAD','1306','OTUZCO','130606','LA CUESTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1197,'13','LA LIBERTAD','1306','OTUZCO','130608','MACHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1198,'13','LA LIBERTAD','1306','OTUZCO','130610','PARANDAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1199,'13','LA LIBERTAD','1306','OTUZCO','130611','SALPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1200,'13','LA LIBERTAD','1306','OTUZCO','130613','SINSICAP')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1201,'13','LA LIBERTAD','1306','OTUZCO','130614','USQUIL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1202,'13','LA LIBERTAD','1307','PACASMAYO','130701','SAN PEDRO DE LLOC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1203,'13','LA LIBERTAD','1307','PACASMAYO','130702','GUADALUPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1204,'13','LA LIBERTAD','1307','PACASMAYO','130703','JEQUETEPEQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1205,'13','LA LIBERTAD','1307','PACASMAYO','130704','PACASMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1206,'13','LA LIBERTAD','1307','PACASMAYO','130705','SAN JOSE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1207,'13','LA LIBERTAD','1308','PATAZ','130801','TAYABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1208,'13','LA LIBERTAD','1308','PATAZ','130802','BULDIBUYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1209,'13','LA LIBERTAD','1308','PATAZ','130803','CHILLIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1210,'13','LA LIBERTAD','1308','PATAZ','130804','HUANCASPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1211,'13','LA LIBERTAD','1308','PATAZ','130805','HUAYLILLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1212,'13','LA LIBERTAD','1308','PATAZ','130806','HUAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1213,'13','LA LIBERTAD','1308','PATAZ','130807','ONGON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1214,'13','LA LIBERTAD','1308','PATAZ','130808','PARCOY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1215,'13','LA LIBERTAD','1308','PATAZ','130809','PATAZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1216,'13','LA LIBERTAD','1308','PATAZ','130810','PIAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1217,'13','LA LIBERTAD','1308','PATAZ','130811','SANTIAGO DE CHALLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1218,'13','LA LIBERTAD','1308','PATAZ','130812','TAURIJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1219,'13','LA LIBERTAD','1308','PATAZ','130813','URPAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1220,'13','LA LIBERTAD','1309','SANCHEZ CARRION','130901','HUAMACHUCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1221,'13','LA LIBERTAD','1309','SANCHEZ CARRION','130902','CHUGAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1222,'13','LA LIBERTAD','1309','SANCHEZ CARRION','130903','COCHORCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1223,'13','LA LIBERTAD','1309','SANCHEZ CARRION','130904','CURGOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1224,'13','LA LIBERTAD','1309','SANCHEZ CARRION','130905','MARCABAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1225,'13','LA LIBERTAD','1309','SANCHEZ CARRION','130906','SANAGORAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1226,'13','LA LIBERTAD','1309','SANCHEZ CARRION','130907','SARIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1227,'13','LA LIBERTAD','1309','SANCHEZ CARRION','130908','SARTIMBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1228,'13','LA LIBERTAD','1310','SANTIAGO DE CHUCO','131001','SANTIAGO DE CHUCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1229,'13','LA LIBERTAD','1310','SANTIAGO DE CHUCO','131002','ANGASMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1230,'13','LA LIBERTAD','1310','SANTIAGO DE CHUCO','131003','CACHICADAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1231,'13','LA LIBERTAD','1310','SANTIAGO DE CHUCO','131004','MOLLEBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1232,'13','LA LIBERTAD','1310','SANTIAGO DE CHUCO','131005','MOLLEPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1233,'13','LA LIBERTAD','1310','SANTIAGO DE CHUCO','131006','QUIRUVILCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1234,'13','LA LIBERTAD','1310','SANTIAGO DE CHUCO','131007','SANTA CRUZ DE CHUCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1235,'13','LA LIBERTAD','1310','SANTIAGO DE CHUCO','131008','SITABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1236,'13','LA LIBERTAD','1311','GRAN CHIMU','131101','CASCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1237,'13','LA LIBERTAD','1311','GRAN CHIMU','131102','LUCMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1238,'13','LA LIBERTAD','1311','GRAN CHIMU','131103','MARMOT')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1239,'13','LA LIBERTAD','1311','GRAN CHIMU','131104','SAYAPULLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1240,'13','LA LIBERTAD','1312','VIRU','131201','VIRU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1241,'13','LA LIBERTAD','1312','VIRU','131202','CHAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1242,'13','LA LIBERTAD','1312','VIRU','131203','GUADALUPITO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1243,'14','LAMBAYEQUE','1401','CHICLAYO','140101','CHICLAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1244,'14','LAMBAYEQUE','1401','CHICLAYO','140102','CHONGOYAPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1245,'14','LAMBAYEQUE','1401','CHICLAYO','140103','ETEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1246,'14','LAMBAYEQUE','1401','CHICLAYO','140104','ETEN PUERTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1247,'14','LAMBAYEQUE','1401','CHICLAYO','140105','JOSE LEONARDO ORTIZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1248,'14','LAMBAYEQUE','1401','CHICLAYO','140106','LA VICTORIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1249,'14','LAMBAYEQUE','1401','CHICLAYO','140107','LAGUNAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1250,'14','LAMBAYEQUE','1401','CHICLAYO','140108','MONSEFU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1251,'14','LAMBAYEQUE','1401','CHICLAYO','140109','NUEVA ARICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1252,'14','LAMBAYEQUE','1401','CHICLAYO','140110','OYOTUN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1253,'14','LAMBAYEQUE','1401','CHICLAYO','140111','PICSI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1254,'14','LAMBAYEQUE','1401','CHICLAYO','140112','PIMENTEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1255,'14','LAMBAYEQUE','1401','CHICLAYO','140113','REQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1256,'14','LAMBAYEQUE','1401','CHICLAYO','140114','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1257,'14','LAMBAYEQUE','1401','CHICLAYO','140115','SAÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1258,'14','LAMBAYEQUE','1401','CHICLAYO','140116','CAYALTI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1259,'14','LAMBAYEQUE','1401','CHICLAYO','140117','PATAPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1260,'14','LAMBAYEQUE','1401','CHICLAYO','140118','POMALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1261,'14','LAMBAYEQUE','1401','CHICLAYO','140119','PUCALA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1262,'14','LAMBAYEQUE','1401','CHICLAYO','140120','TUMAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1263,'14','LAMBAYEQUE','1402','FERREÑAFE','140201','FERREÑAFE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1264,'14','LAMBAYEQUE','1402','FERREÑAFE','140202','CAÑARIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1265,'14','LAMBAYEQUE','1402','FERREÑAFE','140203','INCAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1266,'14','LAMBAYEQUE','1402','FERREÑAFE','140204','MANUEL ANTONIO MESONES MURO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1267,'14','LAMBAYEQUE','1402','FERREÑAFE','140205','PITIPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1268,'14','LAMBAYEQUE','1402','FERREÑAFE','140206','PUEBLO NUEVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1269,'14','LAMBAYEQUE','1403','LAMBAYEQUE','140301','LAMBAYEQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1270,'14','LAMBAYEQUE','1403','LAMBAYEQUE','140302','CHOCHOPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1271,'14','LAMBAYEQUE','1403','LAMBAYEQUE','140303','ILLIMO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1272,'14','LAMBAYEQUE','1403','LAMBAYEQUE','140304','JAYANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1273,'14','LAMBAYEQUE','1403','LAMBAYEQUE','140305','MOCHUMI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1274,'14','LAMBAYEQUE','1403','LAMBAYEQUE','140306','MORROPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1275,'14','LAMBAYEQUE','1403','LAMBAYEQUE','140307','MOTUPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1276,'14','LAMBAYEQUE','1403','LAMBAYEQUE','140308','OLMOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1277,'14','LAMBAYEQUE','1403','LAMBAYEQUE','140309','PACORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1278,'14','LAMBAYEQUE','1403','LAMBAYEQUE','140310','SALAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1279,'14','LAMBAYEQUE','1403','LAMBAYEQUE','140311','SAN JOSE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1280,'14','LAMBAYEQUE','1403','LAMBAYEQUE','140312','TUCUME')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1281,'15','LIMA','1501','LIMA','150101','LIMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1282,'15','LIMA','1501','LIMA','150102','ANCON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1283,'15','LIMA','1501','LIMA','150103','ATE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1284,'15','LIMA','1501','LIMA','150104','BARRANCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1285,'15','LIMA','1501','LIMA','150105','BREÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1286,'15','LIMA','1501','LIMA','150106','CARABAYLLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1287,'15','LIMA','1501','LIMA','150107','CHACLACAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1288,'15','LIMA','1501','LIMA','150108','CHORRILLOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1289,'15','LIMA','1501','LIMA','150109','CIENEGUILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1290,'15','LIMA','1501','LIMA','150110','COMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1291,'15','LIMA','1501','LIMA','150111','EL AGUSTINO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1292,'15','LIMA','1501','LIMA','150112','INDEPENDENCIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1293,'15','LIMA','1501','LIMA','150113','JESUS MARIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1294,'15','LIMA','1501','LIMA','150114','LA MOLINA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1295,'15','LIMA','1501','LIMA','150115','LA VICTORIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1296,'15','LIMA','1501','LIMA','150116','LINCE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1297,'15','LIMA','1501','LIMA','150117','LOS OLIVOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1298,'15','LIMA','1501','LIMA','150118','LURIGANCHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1299,'15','LIMA','1501','LIMA','150119','LURIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1300,'15','LIMA','1501','LIMA','150120','MAGDALENA DEL MAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1301,'15','LIMA','1501','LIMA','150121','PUEBLO LIBRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1302,'15','LIMA','1501','LIMA','150122','MIRAFLORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1303,'15','LIMA','1501','LIMA','150123','PACHACAMAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1304,'15','LIMA','1501','LIMA','150124','PUCUSANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1305,'15','LIMA','1501','LIMA','150125','PUENTE PIEDRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1306,'15','LIMA','1501','LIMA','150126','PUNTA HERMOSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1307,'15','LIMA','1501','LIMA','150127','PUNTA NEGRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1308,'15','LIMA','1501','LIMA','150128','RIMAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1309,'15','LIMA','1501','LIMA','150129','SAN BARTOLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1310,'15','LIMA','1501','LIMA','150130','SAN BORJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1311,'15','LIMA','1501','LIMA','150131','SAN ISIDRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1312,'15','LIMA','1501','LIMA','150132','SAN JUAN DE LURIGANCHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1313,'15','LIMA','1501','LIMA','150133','SAN JUAN DE MIRAFLORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1314,'15','LIMA','1501','LIMA','150134','SAN LUIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1315,'15','LIMA','1501','LIMA','150135','SAN MARTIN DE PORRES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1316,'15','LIMA','1501','LIMA','150136','SAN MIGUEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1317,'15','LIMA','1501','LIMA','150137','SANTA ANITA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1318,'15','LIMA','1501','LIMA','150138','SANTA MARIA DEL MAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1319,'15','LIMA','1501','LIMA','150139','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1320,'15','LIMA','1501','LIMA','150140','SANTIAGO DE SURCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1321,'15','LIMA','1501','LIMA','150141','SURQUILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1322,'15','LIMA','1501','LIMA','150142','VILLA EL SALVADOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1323,'15','LIMA','1501','LIMA','150143','VILLA MARIA DEL TRIUNFO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1324,'15','LIMA','1502','BARRANCA','150201','BARRANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1325,'15','LIMA','1502','BARRANCA','150202','PARAMONGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1326,'15','LIMA','1502','BARRANCA','150203','PATIVILCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1327,'15','LIMA','1502','BARRANCA','150204','SUPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1328,'15','LIMA','1502','BARRANCA','150205','SUPE PUERTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1329,'15','LIMA','1503','CAJATAMBO','150301','CAJATAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1330,'15','LIMA','1503','CAJATAMBO','150302','COPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1331,'15','LIMA','1503','CAJATAMBO','150303','GORGOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1332,'15','LIMA','1503','CAJATAMBO','150304','HUANCAPON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1333,'15','LIMA','1503','CAJATAMBO','150305','MANAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1334,'15','LIMA','1504','CANTA','150401','CANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1335,'15','LIMA','1504','CANTA','150402','ARAHUAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1336,'15','LIMA','1504','CANTA','150403','HUAMANTANGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1337,'15','LIMA','1504','CANTA','150404','HUAROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1338,'15','LIMA','1504','CANTA','150405','LACHAQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1339,'15','LIMA','1504','CANTA','150406','SAN BUENAVENTURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1340,'15','LIMA','1504','CANTA','150407','SANTA ROSA DE QUIVES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1341,'15','LIMA','1505','CAÑETE','150501','SAN VICENTE DE CAÑETE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1342,'15','LIMA','1505','CAÑETE','150502','ASIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1343,'15','LIMA','1505','CAÑETE','150503','CALANGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1344,'15','LIMA','1505','CAÑETE','150504','CERRO AZUL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1345,'15','LIMA','1505','CAÑETE','150505','CHILCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1346,'15','LIMA','1505','CAÑETE','150506','COAYLLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1347,'15','LIMA','1505','CAÑETE','150507','IMPERIAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1348,'15','LIMA','1505','CAÑETE','150508','LUNAHUANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1349,'15','LIMA','1505','CAÑETE','150509','MALA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1350,'15','LIMA','1505','CAÑETE','150510','NUEVO IMPERIAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1351,'15','LIMA','1505','CAÑETE','150511','PACARAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1352,'15','LIMA','1505','CAÑETE','150512','QUILMANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1353,'15','LIMA','1505','CAÑETE','150513','SAN ANTONIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1354,'15','LIMA','1505','CAÑETE','150514','SAN LUIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1355,'15','LIMA','1505','CAÑETE','150515','SANTA CRUZ DE FLORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1356,'15','LIMA','1505','CAÑETE','150516','ZUÑIGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1357,'15','LIMA','1506','HUARAL','150601','HUARAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1358,'15','LIMA','1506','HUARAL','150602','ATAVILLOS ALTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1359,'15','LIMA','1506','HUARAL','150603','ATAVILLOS BAJO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1360,'15','LIMA','1506','HUARAL','150604','AUCALLAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1361,'15','LIMA','1506','HUARAL','150605','CHANCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1362,'15','LIMA','1506','HUARAL','150606','IHUARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1363,'15','LIMA','1506','HUARAL','150607','LAMPIAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1364,'15','LIMA','1506','HUARAL','150608','PACARAOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1365,'15','LIMA','1506','HUARAL','150609','SAN MIGUEL DE ACOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1366,'15','LIMA','1506','HUARAL','150610','SANTA CRUZ DE ANDAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1367,'15','LIMA','1506','HUARAL','150611','SUMBILCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1368,'15','LIMA','1506','HUARAL','150612','VEINTISIETE DE NOVIEMBRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1369,'15','LIMA','1507','HUAROCHIRI','150701','MATUCANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1370,'15','LIMA','1507','HUAROCHIRI','150702','ANTIOQUIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1371,'15','LIMA','1507','HUAROCHIRI','150703','CALLAHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1372,'15','LIMA','1507','HUAROCHIRI','150704','CARAMPOMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1373,'15','LIMA','1507','HUAROCHIRI','150705','CHICLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1374,'15','LIMA','1507','HUAROCHIRI','150706','CUENCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1375,'15','LIMA','1507','HUAROCHIRI','150707','HUACHUPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1376,'15','LIMA','1507','HUAROCHIRI','150708','HUANZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1377,'15','LIMA','1507','HUAROCHIRI','150709','HUAROCHIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1378,'15','LIMA','1507','HUAROCHIRI','150710','LAHUAYTAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1379,'15','LIMA','1507','HUAROCHIRI','150711','LANGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1380,'15','LIMA','1507','HUAROCHIRI','150712','SAN PEDRO DE LARAOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1381,'15','LIMA','1507','HUAROCHIRI','150713','MARIATANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1382,'15','LIMA','1507','HUAROCHIRI','150714','RICARDO PALMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1383,'15','LIMA','1507','HUAROCHIRI','150715','SAN ANDRES DE TUPICOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1384,'15','LIMA','1507','HUAROCHIRI','150716','SAN ANTONIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1385,'15','LIMA','1507','HUAROCHIRI','150717','SAN BARTOLOME')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1386,'15','LIMA','1507','HUAROCHIRI','150718','SAN DAMIAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1387,'15','LIMA','1507','HUAROCHIRI','150719','SAN JUAN DE IRIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1388,'15','LIMA','1507','HUAROCHIRI','150720','SAN JUAN DE TANTARANCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1389,'15','LIMA','1507','HUAROCHIRI','150721','SAN LORENZO DE QUINTI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1390,'15','LIMA','1507','HUAROCHIRI','150722','SAN MATEO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1391,'15','LIMA','1507','HUAROCHIRI','150723','SAN MATEO DE OTAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1392,'15','LIMA','1507','HUAROCHIRI','150724','SAN PEDRO DE CASTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1393,'15','LIMA','1507','HUAROCHIRI','150725','SAN PEDRO DE HUANCAYRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1394,'15','LIMA','1507','HUAROCHIRI','150726','SANGALLAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1395,'15','LIMA','1507','HUAROCHIRI','150727','SANTA CRUZ DE COCACHACRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1396,'15','LIMA','1507','HUAROCHIRI','150728','SANTA EULALIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1397,'15','LIMA','1507','HUAROCHIRI','150729','SANTIAGO DE ANCHUCAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1398,'15','LIMA','1507','HUAROCHIRI','150730','SANTIAGO DE TUNA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1399,'15','LIMA','1507','HUAROCHIRI','150731','SANTO DOMINGO DE LOS OLLEROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1400,'15','LIMA','1507','HUAROCHIRI','150732','SURCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1401,'15','LIMA','1508','HUAURA','150801','HUACHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1402,'15','LIMA','1508','HUAURA','150802','AMBAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1403,'15','LIMA','1508','HUAURA','150803','CALETA DE CARQUIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1404,'15','LIMA','1508','HUAURA','150804','CHECRAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1405,'15','LIMA','1508','HUAURA','150805','HUALMAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1406,'15','LIMA','1508','HUAURA','150806','HUAURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1407,'15','LIMA','1508','HUAURA','150807','LEONCIO PRADO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1408,'15','LIMA','1508','HUAURA','150808','PACCHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1409,'15','LIMA','1508','HUAURA','150809','SANTA LEONOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1410,'15','LIMA','1508','HUAURA','150810','SANTA MARIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1411,'15','LIMA','1508','HUAURA','150811','SAYAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1412,'15','LIMA','1508','HUAURA','150812','VEGUETA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1413,'15','LIMA','1509','OYON','150901','OYON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1414,'15','LIMA','1509','OYON','150902','ANDAJES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1415,'15','LIMA','1509','OYON','150903','CAUJUL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1416,'15','LIMA','1509','OYON','150904','COCHAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1417,'15','LIMA','1509','OYON','150905','NAVAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1418,'15','LIMA','1509','OYON','150906','PACHANGARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1419,'15','LIMA','1510','YAUYOS','151001','YAUYOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1420,'15','LIMA','1510','YAUYOS','151002','ALIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1421,'15','LIMA','1510','YAUYOS','151003','ALLAUCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1422,'15','LIMA','1510','YAUYOS','151004','AYAVIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1423,'15','LIMA','1510','YAUYOS','151005','AZANGARO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1424,'15','LIMA','1510','YAUYOS','151006','CACRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1425,'15','LIMA','1510','YAUYOS','151007','CARANIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1426,'15','LIMA','1510','YAUYOS','151008','CATAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1427,'15','LIMA','1510','YAUYOS','151009','CHOCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1428,'15','LIMA','1510','YAUYOS','151010','COCHAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1429,'15','LIMA','1510','YAUYOS','151011','COLONIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1430,'15','LIMA','1510','YAUYOS','151012','HONGOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1431,'15','LIMA','1510','YAUYOS','151013','HUAMPARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1432,'15','LIMA','1510','YAUYOS','151014','HUANCAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1433,'15','LIMA','1510','YAUYOS','151015','HUANGASCAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1434,'15','LIMA','1510','YAUYOS','151016','HUANTAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1435,'15','LIMA','1510','YAUYOS','151017','HUAÑEC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1436,'15','LIMA','1510','YAUYOS','151018','LARAOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1437,'15','LIMA','1510','YAUYOS','151019','LINCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1438,'15','LIMA','1510','YAUYOS','151020','MADEAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1439,'15','LIMA','1510','YAUYOS','151021','MIRAFLORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1440,'15','LIMA','1510','YAUYOS','151022','OMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1441,'15','LIMA','1510','YAUYOS','151023','PUTINZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1442,'15','LIMA','1510','YAUYOS','151024','QUINCHES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1443,'15','LIMA','1510','YAUYOS','151025','QUINOCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1444,'15','LIMA','1510','YAUYOS','151026','SAN JOAQUIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1445,'15','LIMA','1510','YAUYOS','151027','SAN PEDRO DE PILAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1446,'15','LIMA','1510','YAUYOS','151028','TANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1447,'15','LIMA','1510','YAUYOS','151029','TAURIPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1448,'15','LIMA','1510','YAUYOS','151030','TOMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1449,'15','LIMA','1510','YAUYOS','151031','TUPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1450,'15','LIMA','1510','YAUYOS','151032','VIÑAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1451,'15','LIMA','1510','YAUYOS','151033','VITIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1452,'16','LORETO','1601','MAYNAS','160101','IQUITOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1453,'16','LORETO','1601','MAYNAS','160102','ALTO NANAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1454,'16','LORETO','1601','MAYNAS','160103','FERNANDO LORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1455,'16','LORETO','1601','MAYNAS','160104','INDIANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1456,'16','LORETO','1601','MAYNAS','160105','LAS AMAZONAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1457,'16','LORETO','1601','MAYNAS','160106','MAZAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1458,'16','LORETO','1601','MAYNAS','160107','NAPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1459,'16','LORETO','1601','MAYNAS','160108','PUNCHANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1460,'16','LORETO','1601','MAYNAS','160110','TORRES CAUSANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1461,'16','LORETO','1601','MAYNAS','160112','BELEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1462,'16','LORETO','1601','MAYNAS','160113','SAN JUAN BAUTISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1463,'16','LORETO','1602','ALTO AMAZONAS','160201','YURIMAGUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1464,'16','LORETO','1602','ALTO AMAZONAS','160202','BALSAPUERTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1465,'16','LORETO','1602','ALTO AMAZONAS','160205','JEBEROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1466,'16','LORETO','1602','ALTO AMAZONAS','160206','LAGUNAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1467,'16','LORETO','1602','ALTO AMAZONAS','160210','SANTA CRUZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1468,'16','LORETO','1602','ALTO AMAZONAS','160211','TENIENTE CESAR LOPEZ ROJAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1469,'16','LORETO','1603','LORETO','160301','NAUTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1470,'16','LORETO','1603','LORETO','160302','PARINARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1471,'16','LORETO','1603','LORETO','160303','TIGRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1472,'16','LORETO','1603','LORETO','160304','TROMPETEROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1473,'16','LORETO','1603','LORETO','160305','URARINAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1474,'16','LORETO','1604','MARISCAL RAMON CASTILLA','160401','RAMON CASTILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1475,'16','LORETO','1604','MARISCAL RAMON CASTILLA','160402','PEBAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1476,'16','LORETO','1604','MARISCAL RAMON CASTILLA','160403','YAVARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1477,'16','LORETO','1604','MARISCAL RAMON CASTILLA','160404','SAN PABLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1478,'16','LORETO','1605','REQUENA','160501','REQUENA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1479,'16','LORETO','1605','REQUENA','160502','ALTO TAPICHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1480,'16','LORETO','1605','REQUENA','160503','CAPELO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1481,'16','LORETO','1605','REQUENA','160504','EMILIO SAN MARTIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1482,'16','LORETO','1605','REQUENA','160505','MAQUIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1483,'16','LORETO','1605','REQUENA','160506','PUINAHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1484,'16','LORETO','1605','REQUENA','160507','SAQUENA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1485,'16','LORETO','1605','REQUENA','160508','SOPLIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1486,'16','LORETO','1605','REQUENA','160509','TAPICHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1487,'16','LORETO','1605','REQUENA','160510','JENARO HERRERA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1488,'16','LORETO','1605','REQUENA','160511','YAQUERANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1489,'16','LORETO','1606','UCAYALI','160601','CONTAMANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1490,'16','LORETO','1606','UCAYALI','160602','INAHUAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1491,'16','LORETO','1606','UCAYALI','160603','PADRE MARQUEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1492,'16','LORETO','1606','UCAYALI','160604','PAMPA HERMOSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1493,'16','LORETO','1606','UCAYALI','160605','SARAYACU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1494,'16','LORETO','1606','UCAYALI','160606','VARGAS GUERRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1495,'16','LORETO','1607','DATEM DEL MARAÑON','160701','BARRANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1496,'16','LORETO','1607','DATEM DEL MARAÑON','160702','CAHUAPANAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1497,'16','LORETO','1607','DATEM DEL MARAÑON','160703','MANSERICHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1498,'16','LORETO','1607','DATEM DEL MARAÑON','160704','MORONA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1499,'16','LORETO','1607','DATEM DEL MARAÑON','160705','PASTAZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1500,'16','LORETO','1607','DATEM DEL MARAÑON','160706','ANDOAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1501,'16','LORETO','1608','PUTUMAYO','160801','PUTUMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1502,'16','LORETO','1608','PUTUMAYO','160802','ROSA PANDURO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1503,'16','LORETO','1608','PUTUMAYO','160803','TENIENTE MANUEL CLAVERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1504,'16','LORETO','1608','PUTUMAYO','160804','YAGUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1505,'17','MADRE DE DIOS','1701','TAMBOPATA','170101','TAMBOPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1506,'17','MADRE DE DIOS','1701','TAMBOPATA','170102','INAMBARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1507,'17','MADRE DE DIOS','1701','TAMBOPATA','170103','LAS PIEDRAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1508,'17','MADRE DE DIOS','1701','TAMBOPATA','170104','LABERINTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1509,'17','MADRE DE DIOS','1702','MANU','170201','MANU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1510,'17','MADRE DE DIOS','1702','MANU','170202','FITZCARRALD')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1511,'17','MADRE DE DIOS','1702','MANU','170203','MADRE DE DIOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1512,'17','MADRE DE DIOS','1702','MANU','170204','HUEPETUHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1513,'17','MADRE DE DIOS','1703','TAHUAMANU','170301','IÑAPARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1514,'17','MADRE DE DIOS','1703','TAHUAMANU','170302','IBERIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1515,'17','MADRE DE DIOS','1703','TAHUAMANU','170303','TAHUAMANU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1516,'18','MOQUEGUA','1801','MARISCAL NIETO','180101','MOQUEGUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1517,'18','MOQUEGUA','1801','MARISCAL NIETO','180102','CARUMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1518,'18','MOQUEGUA','1801','MARISCAL NIETO','180103','CUCHUMBAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1519,'18','MOQUEGUA','1801','MARISCAL NIETO','180104','SAMEGUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1520,'18','MOQUEGUA','1801','MARISCAL NIETO','180105','SAN CRISTOBAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1521,'18','MOQUEGUA','1801','MARISCAL NIETO','180106','TORATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1522,'18','MOQUEGUA','1802','GENERAL SANCHEZ CERRO','180201','OMATE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1523,'18','MOQUEGUA','1802','GENERAL SANCHEZ CERRO','180202','CHOJATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1524,'18','MOQUEGUA','1802','GENERAL SANCHEZ CERRO','180203','COALAQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1525,'18','MOQUEGUA','1802','GENERAL SANCHEZ CERRO','180204','ICHUÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1526,'18','MOQUEGUA','1802','GENERAL SANCHEZ CERRO','180205','LA CAPILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1527,'18','MOQUEGUA','1802','GENERAL SANCHEZ CERRO','180206','LLOQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1528,'18','MOQUEGUA','1802','GENERAL SANCHEZ CERRO','180207','MATALAQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1529,'18','MOQUEGUA','1802','GENERAL SANCHEZ CERRO','180208','PUQUINA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1530,'18','MOQUEGUA','1802','GENERAL SANCHEZ CERRO','180209','QUINISTAQUILLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1531,'18','MOQUEGUA','1802','GENERAL SANCHEZ CERRO','180210','UBINAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1532,'18','MOQUEGUA','1802','GENERAL SANCHEZ CERRO','180211','YUNGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1533,'18','MOQUEGUA','1803','ILO','180301','ILO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1534,'18','MOQUEGUA','1803','ILO','180302','EL ALGARROBAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1535,'18','MOQUEGUA','1803','ILO','180303','PACOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1536,'19','PASCO','1901','PASCO','190101','CHAUPIMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1537,'19','PASCO','1901','PASCO','190102','HUACHON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1538,'19','PASCO','1901','PASCO','190103','HUARIACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1539,'19','PASCO','1901','PASCO','190104','HUAYLLAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1540,'19','PASCO','1901','PASCO','190105','NINACACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1541,'19','PASCO','1901','PASCO','190106','PALLANCHACRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1542,'19','PASCO','1901','PASCO','190107','PAUCARTAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1543,'19','PASCO','1901','PASCO','190108','SAN FRANCISCO DE ASIS DE YARUSYACAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1544,'19','PASCO','1901','PASCO','190109','SIMON BOLIVAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1545,'19','PASCO','1901','PASCO','190110','TICLACAYAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1546,'19','PASCO','1901','PASCO','190111','TINYAHUARCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1547,'19','PASCO','1901','PASCO','190112','VICCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1548,'19','PASCO','1901','PASCO','190113','YANACANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1549,'19','PASCO','1902','DANIEL ALCIDES CARRION','190201','YANAHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1550,'19','PASCO','1902','DANIEL ALCIDES CARRION','190202','CHACAYAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1551,'19','PASCO','1902','DANIEL ALCIDES CARRION','190203','GOYLLARISQUIZGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1552,'19','PASCO','1902','DANIEL ALCIDES CARRION','190204','PAUCAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1553,'19','PASCO','1902','DANIEL ALCIDES CARRION','190205','SAN PEDRO DE PILLAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1554,'19','PASCO','1902','DANIEL ALCIDES CARRION','190206','SANTA ANA DE TUSI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1555,'19','PASCO','1902','DANIEL ALCIDES CARRION','190207','TAPUC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1556,'19','PASCO','1902','DANIEL ALCIDES CARRION','190208','VILCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1557,'19','PASCO','1903','OXAPAMPA','190301','OXAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1558,'19','PASCO','1903','OXAPAMPA','190302','CHONTABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1559,'19','PASCO','1903','OXAPAMPA','190303','HUANCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1560,'19','PASCO','1903','OXAPAMPA','190304','PALCAZU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1561,'19','PASCO','1903','OXAPAMPA','190305','POZUZO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1562,'19','PASCO','1903','OXAPAMPA','190306','PUERTO BERMUDEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1563,'19','PASCO','1903','OXAPAMPA','190307','VILLA RICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1564,'19','PASCO','1903','OXAPAMPA','190308','CONSTITUCION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1565,'20','PIURA','2001','PIURA','200101','PIURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1566,'20','PIURA','2001','PIURA','200104','CASTILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1567,'20','PIURA','2001','PIURA','200105','CATACAOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1568,'20','PIURA','2001','PIURA','200107','CURA MORI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1569,'20','PIURA','2001','PIURA','200108','EL TALLAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1570,'20','PIURA','2001','PIURA','200109','LA ARENA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1571,'20','PIURA','2001','PIURA','200110','LA UNION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1572,'20','PIURA','2001','PIURA','200111','LAS LOMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1573,'20','PIURA','2001','PIURA','200114','TAMBO GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1574,'20','PIURA','2001','PIURA','200115','VEINTISEIS DE OCTUBRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1575,'20','PIURA','2002','AYABACA','200201','AYABACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1576,'20','PIURA','2002','AYABACA','200202','FRIAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1577,'20','PIURA','2002','AYABACA','200203','JILILI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1578,'20','PIURA','2002','AYABACA','200204','LAGUNAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1579,'20','PIURA','2002','AYABACA','200205','MONTERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1580,'20','PIURA','2002','AYABACA','200206','PACAIPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1581,'20','PIURA','2002','AYABACA','200207','PAIMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1582,'20','PIURA','2002','AYABACA','200208','SAPILLICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1583,'20','PIURA','2002','AYABACA','200209','SICCHEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1584,'20','PIURA','2002','AYABACA','200210','SUYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1585,'20','PIURA','2003','HUANCABAMBA','200301','HUANCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1586,'20','PIURA','2003','HUANCABAMBA','200302','CANCHAQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1587,'20','PIURA','2003','HUANCABAMBA','200303','EL CARMEN DE LA FRONTERA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1588,'20','PIURA','2003','HUANCABAMBA','200304','HUARMACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1589,'20','PIURA','2003','HUANCABAMBA','200305','LALAQUIZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1590,'20','PIURA','2003','HUANCABAMBA','200306','SAN MIGUEL DE EL FAIQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1591,'20','PIURA','2003','HUANCABAMBA','200307','SONDOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1592,'20','PIURA','2003','HUANCABAMBA','200308','SONDORILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1593,'20','PIURA','2004','MORROPON','200401','CHULUCANAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1594,'20','PIURA','2004','MORROPON','200402','BUENOS AIRES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1595,'20','PIURA','2004','MORROPON','200403','CHALACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1596,'20','PIURA','2004','MORROPON','200404','LA MATANZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1597,'20','PIURA','2004','MORROPON','200405','MORROPON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1598,'20','PIURA','2004','MORROPON','200406','SALITRAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1599,'20','PIURA','2004','MORROPON','200407','SAN JUAN DE BIGOTE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1600,'20','PIURA','2004','MORROPON','200408','SANTA CATALINA DE MOSSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1601,'20','PIURA','2004','MORROPON','200409','SANTO DOMINGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1602,'20','PIURA','2004','MORROPON','200410','YAMANGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1603,'20','PIURA','2005','PAITA','200501','PAITA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1604,'20','PIURA','2005','PAITA','200502','AMOTAPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1605,'20','PIURA','2005','PAITA','200503','ARENAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1606,'20','PIURA','2005','PAITA','200504','COLAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1607,'20','PIURA','2005','PAITA','200505','LA HUACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1608,'20','PIURA','2005','PAITA','200506','TAMARINDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1609,'20','PIURA','2005','PAITA','200507','VICHAYAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1610,'20','PIURA','2006','SULLANA','200601','SULLANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1611,'20','PIURA','2006','SULLANA','200602','BELLAVISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1612,'20','PIURA','2006','SULLANA','200603','IGNACIO ESCUDERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1613,'20','PIURA','2006','SULLANA','200604','LANCONES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1614,'20','PIURA','2006','SULLANA','200605','MARCAVELICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1615,'20','PIURA','2006','SULLANA','200606','MIGUEL CHECA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1616,'20','PIURA','2006','SULLANA','200607','QUERECOTILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1617,'20','PIURA','2006','SULLANA','200608','SALITRAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1618,'20','PIURA','2007','TALARA','200701','PARIÑAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1619,'20','PIURA','2007','TALARA','200702','EL ALTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1620,'20','PIURA','2007','TALARA','200703','LA BREA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1621,'20','PIURA','2007','TALARA','200704','LOBITOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1622,'20','PIURA','2007','TALARA','200705','LOS ORGANOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1623,'20','PIURA','2007','TALARA','200706','MANCORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1624,'20','PIURA','2008','SECHURA','200801','SECHURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1625,'20','PIURA','2008','SECHURA','200802','BELLAVISTA DE LA UNION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1626,'20','PIURA','2008','SECHURA','200803','BERNAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1627,'20','PIURA','2008','SECHURA','200804','CRISTO NOS VALGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1628,'20','PIURA','2008','SECHURA','200805','VICE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1629,'20','PIURA','2008','SECHURA','200806','RINCONADA LLICUAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1630,'21','PUNO','2101','PUNO','210101','PUNO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1631,'21','PUNO','2101','PUNO','210102','ACORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1632,'21','PUNO','2101','PUNO','210103','AMANTANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1633,'21','PUNO','2101','PUNO','210104','ATUNCOLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1634,'21','PUNO','2101','PUNO','210105','CAPACHICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1635,'21','PUNO','2101','PUNO','210106','CHUCUITO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1636,'21','PUNO','2101','PUNO','210107','COATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1637,'21','PUNO','2101','PUNO','210108','HUATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1638,'21','PUNO','2101','PUNO','210109','MAÑAZO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1639,'21','PUNO','2101','PUNO','210110','PAUCARCOLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1640,'21','PUNO','2101','PUNO','210111','PICHACANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1641,'21','PUNO','2101','PUNO','210112','PLATERIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1642,'21','PUNO','2101','PUNO','210113','SAN ANTONIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1643,'21','PUNO','2101','PUNO','210114','TIQUILLACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1644,'21','PUNO','2101','PUNO','210115','VILQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1645,'21','PUNO','2102','AZANGARO','210201','AZANGARO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1646,'21','PUNO','2102','AZANGARO','210202','ACHAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1647,'21','PUNO','2102','AZANGARO','210203','ARAPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1648,'21','PUNO','2102','AZANGARO','210204','ASILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1649,'21','PUNO','2102','AZANGARO','210205','CAMINACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1650,'21','PUNO','2102','AZANGARO','210206','CHUPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1651,'21','PUNO','2102','AZANGARO','210207','JOSE DOMINGO CHOQUEHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1652,'21','PUNO','2102','AZANGARO','210208','MUÑANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1653,'21','PUNO','2102','AZANGARO','210209','POTONI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1654,'21','PUNO','2102','AZANGARO','210210','SAMAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1655,'21','PUNO','2102','AZANGARO','210211','SAN ANTON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1656,'21','PUNO','2102','AZANGARO','210212','SAN JOSE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1657,'21','PUNO','2102','AZANGARO','210213','SAN JUAN DE SALINAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1658,'21','PUNO','2102','AZANGARO','210214','SANTIAGO DE PUPUJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1659,'21','PUNO','2102','AZANGARO','210215','TIRAPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1660,'21','PUNO','2103','CARABAYA','210301','MACUSANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1661,'21','PUNO','2103','CARABAYA','210302','AJOYANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1662,'21','PUNO','2103','CARABAYA','210303','AYAPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1663,'21','PUNO','2103','CARABAYA','210304','COASA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1664,'21','PUNO','2103','CARABAYA','210305','CORANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1665,'21','PUNO','2103','CARABAYA','210306','CRUCERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1666,'21','PUNO','2103','CARABAYA','210307','ITUATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1667,'21','PUNO','2103','CARABAYA','210308','OLLACHEA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1668,'21','PUNO','2103','CARABAYA','210309','SAN GABAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1669,'21','PUNO','2103','CARABAYA','210310','USICAYOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1670,'21','PUNO','2104','CHUCUITO','210401','JULI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1671,'21','PUNO','2104','CHUCUITO','210402','DESAGUADERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1672,'21','PUNO','2104','CHUCUITO','210403','HUACULLANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1673,'21','PUNO','2104','CHUCUITO','210404','KELLUYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1674,'21','PUNO','2104','CHUCUITO','210405','PISACOMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1675,'21','PUNO','2104','CHUCUITO','210406','POMATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1676,'21','PUNO','2104','CHUCUITO','210407','ZEPITA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1677,'21','PUNO','2105','EL COLLAO','210501','ILAVE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1678,'21','PUNO','2105','EL COLLAO','210502','CAPAZO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1679,'21','PUNO','2105','EL COLLAO','210503','PILCUYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1680,'21','PUNO','2105','EL COLLAO','210504','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1681,'21','PUNO','2105','EL COLLAO','210505','CONDURIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1682,'21','PUNO','2106','HUANCANE','210601','HUANCANE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1683,'21','PUNO','2106','HUANCANE','210602','COJATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1684,'21','PUNO','2106','HUANCANE','210603','HUATASANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1685,'21','PUNO','2106','HUANCANE','210604','INCHUPALLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1686,'21','PUNO','2106','HUANCANE','210605','PUSI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1687,'21','PUNO','2106','HUANCANE','210606','ROSASPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1688,'21','PUNO','2106','HUANCANE','210607','TARACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1689,'21','PUNO','2106','HUANCANE','210608','VILQUE CHICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1690,'21','PUNO','2107','LAMPA','210701','LAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1691,'21','PUNO','2107','LAMPA','210702','CABANILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1692,'21','PUNO','2107','LAMPA','210703','CALAPUJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1693,'21','PUNO','2107','LAMPA','210704','NICASIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1694,'21','PUNO','2107','LAMPA','210705','OCUVIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1695,'21','PUNO','2107','LAMPA','210706','PALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1696,'21','PUNO','2107','LAMPA','210707','PARATIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1697,'21','PUNO','2107','LAMPA','210708','PUCARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1698,'21','PUNO','2107','LAMPA','210709','SANTA LUCIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1699,'21','PUNO','2107','LAMPA','210710','VILAVILA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1700,'21','PUNO','2108','MELGAR','210801','AYAVIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1701,'21','PUNO','2108','MELGAR','210802','ANTAUTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1702,'21','PUNO','2108','MELGAR','210803','CUPI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1703,'21','PUNO','2108','MELGAR','210804','LLALLI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1704,'21','PUNO','2108','MELGAR','210805','MACARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1705,'21','PUNO','2108','MELGAR','210806','NUÑOA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1706,'21','PUNO','2108','MELGAR','210807','ORURILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1707,'21','PUNO','2108','MELGAR','210808','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1708,'21','PUNO','2108','MELGAR','210809','UMACHIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1709,'21','PUNO','2109','MOHO','210901','MOHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1710,'21','PUNO','2109','MOHO','210902','CONIMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1711,'21','PUNO','2109','MOHO','210903','HUAYRAPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1712,'21','PUNO','2109','MOHO','210904','TILALI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1713,'21','PUNO','2110','SAN ANTONIO DE PUTINA','211001','PUTINA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1714,'21','PUNO','2110','SAN ANTONIO DE PUTINA','211002','ANANEA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1715,'21','PUNO','2110','SAN ANTONIO DE PUTINA','211003','PEDRO VILCA APAZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1716,'21','PUNO','2110','SAN ANTONIO DE PUTINA','211004','QUILCAPUNCU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1717,'21','PUNO','2110','SAN ANTONIO DE PUTINA','211005','SINA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1718,'21','PUNO','2111','SAN ROMAN','211101','JULIACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1719,'21','PUNO','2111','SAN ROMAN','211102','CABANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1720,'21','PUNO','2111','SAN ROMAN','211103','CABANILLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1721,'21','PUNO','2111','SAN ROMAN','211104','CARACOTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1722,'21','PUNO','2111','SAN ROMAN','211105','SAN MIGUEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1723,'21','PUNO','2112','SANDIA','211201','SANDIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1724,'21','PUNO','2112','SANDIA','211202','CUYOCUYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1725,'21','PUNO','2112','SANDIA','211203','LIMBANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1726,'21','PUNO','2112','SANDIA','211204','PATAMBUCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1727,'21','PUNO','2112','SANDIA','211205','PHARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1728,'21','PUNO','2112','SANDIA','211206','QUIACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1729,'21','PUNO','2112','SANDIA','211207','SAN JUAN DEL ORO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1730,'21','PUNO','2112','SANDIA','211208','YANAHUAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1731,'21','PUNO','2112','SANDIA','211209','ALTO INAMBARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1732,'21','PUNO','2112','SANDIA','211210','SAN PEDRO DE PUTINA PUNCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1733,'21','PUNO','2113','YUNGUYO','211301','YUNGUYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1734,'21','PUNO','2113','YUNGUYO','211302','ANAPIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1735,'21','PUNO','2113','YUNGUYO','211303','COPANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1736,'21','PUNO','2113','YUNGUYO','211304','CUTURAPI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1737,'21','PUNO','2113','YUNGUYO','211305','OLLARAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1738,'21','PUNO','2113','YUNGUYO','211306','TINICACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1739,'21','PUNO','2113','YUNGUYO','211307','UNICACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1740,'22','SAN MARTIN','2201','MOYOBAMBA','220101','MOYOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1741,'22','SAN MARTIN','2201','MOYOBAMBA','220102','CALZADA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1742,'22','SAN MARTIN','2201','MOYOBAMBA','220103','HABANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1743,'22','SAN MARTIN','2201','MOYOBAMBA','220104','JEPELACIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1744,'22','SAN MARTIN','2201','MOYOBAMBA','220105','SORITOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1745,'22','SAN MARTIN','2201','MOYOBAMBA','220106','YANTALO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1746,'22','SAN MARTIN','2202','BELLAVISTA','220201','BELLAVISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1747,'22','SAN MARTIN','2202','BELLAVISTA','220202','ALTO BIAVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1748,'22','SAN MARTIN','2202','BELLAVISTA','220203','BAJO BIAVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1749,'22','SAN MARTIN','2202','BELLAVISTA','220204','HUALLAGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1750,'22','SAN MARTIN','2202','BELLAVISTA','220205','SAN PABLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1751,'22','SAN MARTIN','2202','BELLAVISTA','220206','SAN RAFAEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1752,'22','SAN MARTIN','2203','EL DORADO','220301','SAN JOSE DE SISA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1753,'22','SAN MARTIN','2203','EL DORADO','220302','AGUA BLANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1754,'22','SAN MARTIN','2203','EL DORADO','220303','SAN MARTIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1755,'22','SAN MARTIN','2203','EL DORADO','220304','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1756,'22','SAN MARTIN','2203','EL DORADO','220305','SHATOJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1757,'22','SAN MARTIN','2204','HUALLAGA','220401','SAPOSOA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1758,'22','SAN MARTIN','2204','HUALLAGA','220402','ALTO SAPOSOA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1759,'22','SAN MARTIN','2204','HUALLAGA','220403','EL ESLABON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1760,'22','SAN MARTIN','2204','HUALLAGA','220404','PISCOYACU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1761,'22','SAN MARTIN','2204','HUALLAGA','220405','SACANCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1762,'22','SAN MARTIN','2204','HUALLAGA','220406','TINGO DE SAPOSOA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1763,'22','SAN MARTIN','2205','LAMAS','220501','LAMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1764,'22','SAN MARTIN','2205','LAMAS','220502','ALONSO DE ALVARADO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1765,'22','SAN MARTIN','2205','LAMAS','220503','BARRANQUITA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1766,'22','SAN MARTIN','2205','LAMAS','220504','CAYNARACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1767,'22','SAN MARTIN','2205','LAMAS','220505','CUÑUMBUQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1768,'22','SAN MARTIN','2205','LAMAS','220506','PINTO RECODO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1769,'22','SAN MARTIN','2205','LAMAS','220507','RUMISAPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1770,'22','SAN MARTIN','2205','LAMAS','220508','SAN ROQUE DE CUMBAZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1771,'22','SAN MARTIN','2205','LAMAS','220509','SHANAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1772,'22','SAN MARTIN','2205','LAMAS','220510','TABALOSOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1773,'22','SAN MARTIN','2205','LAMAS','220511','ZAPATERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1774,'22','SAN MARTIN','2206','MARISCAL CACERES','220601','JUANJUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1775,'22','SAN MARTIN','2206','MARISCAL CACERES','220602','CAMPANILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1776,'22','SAN MARTIN','2206','MARISCAL CACERES','220603','HUICUNGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1777,'22','SAN MARTIN','2206','MARISCAL CACERES','220604','PACHIZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1778,'22','SAN MARTIN','2206','MARISCAL CACERES','220605','PAJARILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1779,'22','SAN MARTIN','2207','PICOTA','220701','PICOTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1780,'22','SAN MARTIN','2207','PICOTA','220702','BUENOS AIRES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1781,'22','SAN MARTIN','2207','PICOTA','220703','CASPISAPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1782,'22','SAN MARTIN','2207','PICOTA','220704','PILLUANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1783,'22','SAN MARTIN','2207','PICOTA','220705','PUCACACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1784,'22','SAN MARTIN','2207','PICOTA','220706','SAN CRISTOBAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1785,'22','SAN MARTIN','2207','PICOTA','220707','SAN HILARION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1786,'22','SAN MARTIN','2207','PICOTA','220708','SHAMBOYACU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1787,'22','SAN MARTIN','2207','PICOTA','220709','TINGO DE PONASA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1788,'22','SAN MARTIN','2207','PICOTA','220710','TRES UNIDOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1789,'22','SAN MARTIN','2208','RIOJA','220801','RIOJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1790,'22','SAN MARTIN','2208','RIOJA','220802','AWAJUN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1791,'22','SAN MARTIN','2208','RIOJA','220803','ELIAS SOPLIN VARGAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1792,'22','SAN MARTIN','2208','RIOJA','220804','NUEVA CAJAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1793,'22','SAN MARTIN','2208','RIOJA','220805','PARDO MIGUEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1794,'22','SAN MARTIN','2208','RIOJA','220806','POSIC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1795,'22','SAN MARTIN','2208','RIOJA','220807','SAN FERNANDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1796,'22','SAN MARTIN','2208','RIOJA','220808','YORONGOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1797,'22','SAN MARTIN','2208','RIOJA','220809','YURACYACU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1798,'22','SAN MARTIN','2209','SAN MARTIN','220901','TARAPOTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1799,'22','SAN MARTIN','2209','SAN MARTIN','220902','ALBERTO LEVEAU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1800,'22','SAN MARTIN','2209','SAN MARTIN','220903','CACATACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1801,'22','SAN MARTIN','2209','SAN MARTIN','220904','CHAZUTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1802,'22','SAN MARTIN','2209','SAN MARTIN','220905','CHIPURANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1803,'22','SAN MARTIN','2209','SAN MARTIN','220906','EL PORVENIR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1804,'22','SAN MARTIN','2209','SAN MARTIN','220907','HUIMBAYOC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1805,'22','SAN MARTIN','2209','SAN MARTIN','220908','JUAN GUERRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1806,'22','SAN MARTIN','2209','SAN MARTIN','220909','LA BANDA DE SHILCAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1807,'22','SAN MARTIN','2209','SAN MARTIN','220910','MORALES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1808,'22','SAN MARTIN','2209','SAN MARTIN','220911','PAPAPLAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1809,'22','SAN MARTIN','2209','SAN MARTIN','220912','SAN ANTONIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1810,'22','SAN MARTIN','2209','SAN MARTIN','220913','SAUCE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1811,'22','SAN MARTIN','2209','SAN MARTIN','220914','SHAPAJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1812,'22','SAN MARTIN','2210','TOCACHE','221001','TOCACHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1813,'22','SAN MARTIN','2210','TOCACHE','221002','NUEVO PROGRESO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1814,'22','SAN MARTIN','2210','TOCACHE','221003','POLVORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1815,'22','SAN MARTIN','2210','TOCACHE','221004','SHUNTE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1816,'22','SAN MARTIN','2210','TOCACHE','221005','UCHIZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1817,'23','TACNA','2301','TACNA','230101','TACNA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1818,'23','TACNA','2301','TACNA','230102','ALTO DE LA ALIANZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1819,'23','TACNA','2301','TACNA','230103','CALANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1820,'23','TACNA','2301','TACNA','230104','CIUDAD NUEVA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1821,'23','TACNA','2301','TACNA','230105','INCLAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1822,'23','TACNA','2301','TACNA','230106','PACHIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1823,'23','TACNA','2301','TACNA','230107','PALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1824,'23','TACNA','2301','TACNA','230108','POCOLLAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1825,'23','TACNA','2301','TACNA','230109','SAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1826,'23','TACNA','2301','TACNA','230110','CORONEL GREGORIO ALBARRACIN LANCHIPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1827,'23','TACNA','2301','TACNA','230111','LA YARADA LOS PALOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1828,'23','TACNA','2302','CANDARAVE','230201','CANDARAVE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1829,'23','TACNA','2302','CANDARAVE','230202','CAIRANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1830,'23','TACNA','2302','CANDARAVE','230203','CAMILACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1831,'23','TACNA','2302','CANDARAVE','230204','CURIBAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1832,'23','TACNA','2302','CANDARAVE','230205','HUANUARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1833,'23','TACNA','2302','CANDARAVE','230206','QUILAHUANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1834,'23','TACNA','2303','JORGE BASADRE','230301','LOCUMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1835,'23','TACNA','2303','JORGE BASADRE','230302','ILABAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1836,'23','TACNA','2303','JORGE BASADRE','230303','ITE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1837,'23','TACNA','2304','TARATA','230401','TARATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1838,'23','TACNA','2304','TARATA','230402','HEROES ALBARRACIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1839,'23','TACNA','2304','TARATA','230403','ESTIQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1840,'23','TACNA','2304','TARATA','230404','ESTIQUE-PAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1841,'23','TACNA','2304','TARATA','230405','SITAJARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1842,'23','TACNA','2304','TARATA','230406','SUSAPAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1843,'23','TACNA','2304','TARATA','230407','TARUCACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1844,'23','TACNA','2304','TARATA','230408','TICACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1845,'24','TUMBES','2401','TUMBES','240101','TUMBES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1846,'24','TUMBES','2401','TUMBES','240102','CORRALES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1847,'24','TUMBES','2401','TUMBES','240103','LA CRUZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1848,'24','TUMBES','2401','TUMBES','240104','PAMPAS DE HOSPITAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1849,'24','TUMBES','2401','TUMBES','240105','SAN JACINTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1850,'24','TUMBES','2401','TUMBES','240106','SAN JUAN DE LA VIRGEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1851,'24','TUMBES','2402','CONTRALMIRANTE VILLAR','240201','ZORRITOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1852,'24','TUMBES','2402','CONTRALMIRANTE VILLAR','240202','CASITAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1853,'24','TUMBES','2402','CONTRALMIRANTE VILLAR','240203','CANOAS DE PUNTA SAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1854,'24','TUMBES','2403','ZARUMILLA','240301','ZARUMILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1855,'24','TUMBES','2403','ZARUMILLA','240302','AGUAS VERDES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1856,'24','TUMBES','2403','ZARUMILLA','240303','MATAPALO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1857,'24','TUMBES','2403','ZARUMILLA','240304','PAPAYAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1858,'25','UCAYALI','2501','CORONEL PORTILLO','250101','CALLERIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1859,'25','UCAYALI','2501','CORONEL PORTILLO','250102','CAMPOVERDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1860,'25','UCAYALI','2501','CORONEL PORTILLO','250103','IPARIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1861,'25','UCAYALI','2501','CORONEL PORTILLO','250104','MASISEA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1862,'25','UCAYALI','2501','CORONEL PORTILLO','250105','YARINACOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1863,'25','UCAYALI','2501','CORONEL PORTILLO','250106','NUEVA REQUENA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1864,'25','UCAYALI','2501','CORONEL PORTILLO','250107','MANANTAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1865,'25','UCAYALI','2502','ATALAYA','250201','RAYMONDI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1866,'25','UCAYALI','2502','ATALAYA','250202','SEPAHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1867,'25','UCAYALI','2502','ATALAYA','250203','TAHUANIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1868,'25','UCAYALI','2502','ATALAYA','250204','YURUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1869,'25','UCAYALI','2503','PADRE ABAD','250301','PADRE ABAD')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1870,'25','UCAYALI','2503','PADRE ABAD','250302','IRAZOLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1871,'25','UCAYALI','2503','PADRE ABAD','250303','CURIMANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1872,'25','UCAYALI','2503','PADRE ABAD','250304','NESHUYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1873,'25','UCAYALI','2503','PADRE ABAD','250305','ALEXANDER VON HUMBOLDT')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1874,'25','UCAYALI','2504','PURUS','250401','PURUS')"];
    foreach ($arr as $key => $value) {
        $x->executeQuery($value);
    }
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
$x->executeQuery("insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo,nombre_tabla, estado,fecha_creacion,usuario_creacion,usuario_edicion) 
values(1,1,1,1,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','ACOGIDA',1,1,SYSDATE,1,1)");*/
/*$x->insertData('modulos', array("id"=>1,"centro_id"=>1,"encargado_id"=>1,"parent_id"=>1,"url_template"=>'ppd-datos-actividades',"icon"=>'fa fa-laptop',"nombre"=>'ACOGIDA',"estado_completo,nombre_tabla"=>0,"estado"=>1,"fecha_creacion"=>'18-DEC-28',"usuario_creacion"=>1,"usuario_edicion"=>1));*/
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
    estado_completo,nombre_tabla INT NULL,
    estado INT DEFAULT 1,
    fecha_creacion date NOT NULL,
    fecha_edicion TIMESTAMP DEFAULT SYSDATE,
    usuario_creacion INT NOT NULL,
    usuario_edicion INT NOT NULL
    )");
$x->executeQuery("DESCRIBE modulos"); 
$x->executeQuery("insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo,nombre_tabla, estado,fecha_creacion,usuario_creacion,usuario_edicion) values(1,1,1,1,'ppd-datos-actividades','fa fa-laptop','ACOGIDA',1,1,SYSDATE,1,1);");
print_r($x->executeQuery("select * from modulos"));
/*
print_r($x->executeQuery("insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo,nombre_tabla, estado,fecha_creacion,usuario_creacion,usuario_edicion)values(1,1,1,0,'ppd-datos-actividades','fa fa-laptop','ACOGIDA',0,1,SYSDATE,1,1);"));
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
