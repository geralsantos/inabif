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
    $arr = ["insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1,'01','AMAZONAS','01','CHACHAPOYAS','01','CHACHAPOYAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (2,'01','AMAZONAS','01','CHACHAPOYAS','02','ASUNCION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (3,'01','AMAZONAS','01','CHACHAPOYAS','03','BALSAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (4,'01','AMAZONAS','01','CHACHAPOYAS','04','CHETO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (5,'01','AMAZONAS','01','CHACHAPOYAS','05','CHILIQUIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (6,'01','AMAZONAS','01','CHACHAPOYAS','06','CHUQUIBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (7,'01','AMAZONAS','01','CHACHAPOYAS','07','GRANADA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (8,'01','AMAZONAS','01','CHACHAPOYAS','08','HUANCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (9,'01','AMAZONAS','01','CHACHAPOYAS','09','LA JALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (10,'01','AMAZONAS','01','CHACHAPOYAS','10','LEIMEBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (11,'01','AMAZONAS','01','CHACHAPOYAS','11','LEVANTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (12,'01','AMAZONAS','01','CHACHAPOYAS','12','MAGDALENA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (13,'01','AMAZONAS','01','CHACHAPOYAS','13','MARISCAL CASTILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (14,'01','AMAZONAS','01','CHACHAPOYAS','14','MOLINOPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (15,'01','AMAZONAS','01','CHACHAPOYAS','15','MONTEVIDEO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (16,'01','AMAZONAS','01','CHACHAPOYAS','16','OLLEROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (17,'01','AMAZONAS','01','CHACHAPOYAS','17','QUINJALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (18,'01','AMAZONAS','01','CHACHAPOYAS','18','SAN FRANCISCO DE DAGUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (19,'01','AMAZONAS','01','CHACHAPOYAS','19','SAN ISIDRO DE MAINO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (20,'01','AMAZONAS','01','CHACHAPOYAS','20','SOLOCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (21,'01','AMAZONAS','01','CHACHAPOYAS','21','SONCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (22,'01','AMAZONAS','02','BAGUA','01','BAGUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (23,'01','AMAZONAS','02','BAGUA','02','ARAMANGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (24,'01','AMAZONAS','02','BAGUA','03','COPALLIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (25,'01','AMAZONAS','02','BAGUA','04','EL PARCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (26,'01','AMAZONAS','02','BAGUA','05','IMAZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (27,'01','AMAZONAS','02','BAGUA','06','LA PECA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (28,'01','AMAZONAS','03','BONGARA','01','JUMBILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (29,'01','AMAZONAS','03','BONGARA','02','CHISQUILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (30,'01','AMAZONAS','03','BONGARA','03','CHURUJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (31,'01','AMAZONAS','03','BONGARA','04','COROSHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (32,'01','AMAZONAS','03','BONGARA','05','CUISPES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (33,'01','AMAZONAS','03','BONGARA','06','FLORIDA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (34,'01','AMAZONAS','03','BONGARA','07','JAZAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (35,'01','AMAZONAS','03','BONGARA','08','RECTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (36,'01','AMAZONAS','03','BONGARA','09','SAN CARLOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (37,'01','AMAZONAS','03','BONGARA','10','SHIPASBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (38,'01','AMAZONAS','03','BONGARA','11','VALERA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (39,'01','AMAZONAS','03','BONGARA','12','YAMBRASBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (40,'01','AMAZONAS','04','CONDORCANQUI','01','NIEVA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (41,'01','AMAZONAS','04','CONDORCANQUI','02','EL CENEPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (42,'01','AMAZONAS','04','CONDORCANQUI','03','RIO SANTIAGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (43,'01','AMAZONAS','05','LUYA','01','LAMUD')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (44,'01','AMAZONAS','05','LUYA','02','CAMPORREDONDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (45,'01','AMAZONAS','05','LUYA','03','COCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (46,'01','AMAZONAS','05','LUYA','04','COLCAMAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (47,'01','AMAZONAS','05','LUYA','05','CONILA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (48,'01','AMAZONAS','05','LUYA','06','INGUILPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (49,'01','AMAZONAS','05','LUYA','07','LONGUITA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (50,'01','AMAZONAS','05','LUYA','08','LONYA CHICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (51,'01','AMAZONAS','05','LUYA','09','LUYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (52,'01','AMAZONAS','05','LUYA','10','LUYA VIEJO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (53,'01','AMAZONAS','05','LUYA','11','MARIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (54,'01','AMAZONAS','05','LUYA','12','OCALLI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (55,'01','AMAZONAS','05','LUYA','13','OCUMAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (56,'01','AMAZONAS','05','LUYA','14','PISUQUIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (57,'01','AMAZONAS','05','LUYA','15','PROVIDENCIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (58,'01','AMAZONAS','05','LUYA','16','SAN CRISTOBAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (59,'01','AMAZONAS','05','LUYA','17','SAN FRANCISCO DEL YESO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (60,'01','AMAZONAS','05','LUYA','18','SAN JERONIMO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (61,'01','AMAZONAS','05','LUYA','19','SAN JUAN DE LOPECANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (62,'01','AMAZONAS','05','LUYA','20','SANTA CATALINA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (63,'01','AMAZONAS','05','LUYA','21','SANTO TOMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (64,'01','AMAZONAS','05','LUYA','22','TINGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (65,'01','AMAZONAS','05','LUYA','23','TRITA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (66,'01','AMAZONAS','06','RODRIGUEZ DE MENDOZA','01','SAN NICOLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (67,'01','AMAZONAS','06','RODRIGUEZ DE MENDOZA','02','CHIRIMOTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (68,'01','AMAZONAS','06','RODRIGUEZ DE MENDOZA','03','COCHAMAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (69,'01','AMAZONAS','06','RODRIGUEZ DE MENDOZA','04','HUAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (70,'01','AMAZONAS','06','RODRIGUEZ DE MENDOZA','05','LIMABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (71,'01','AMAZONAS','06','RODRIGUEZ DE MENDOZA','06','LONGAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (72,'01','AMAZONAS','06','RODRIGUEZ DE MENDOZA','07','MARISCAL BENAVIDES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (73,'01','AMAZONAS','06','RODRIGUEZ DE MENDOZA','08','MILPUC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (74,'01','AMAZONAS','06','RODRIGUEZ DE MENDOZA','09','OMIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (75,'01','AMAZONAS','06','RODRIGUEZ DE MENDOZA','10','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (76,'01','AMAZONAS','06','RODRIGUEZ DE MENDOZA','11','TOTORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (77,'01','AMAZONAS','06','RODRIGUEZ DE MENDOZA','12','VISTA ALEGRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (78,'01','AMAZONAS','07','UTCUBAMBA','01','BAGUA GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (79,'01','AMAZONAS','07','UTCUBAMBA','02','CAJARURO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (80,'01','AMAZONAS','07','UTCUBAMBA','03','CUMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (81,'01','AMAZONAS','07','UTCUBAMBA','04','EL MILAGRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (82,'01','AMAZONAS','07','UTCUBAMBA','05','JAMALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (83,'01','AMAZONAS','07','UTCUBAMBA','06','LONYA GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (84,'01','AMAZONAS','07','UTCUBAMBA','07','YAMON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (85,'02','ANCASH','01','HUARAZ','01','HUARAZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (86,'02','ANCASH','01','HUARAZ','02','COCHABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (87,'02','ANCASH','01','HUARAZ','03','COLCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (88,'02','ANCASH','01','HUARAZ','04','HUANCHAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (89,'02','ANCASH','01','HUARAZ','05','INDEPENDENCIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (90,'02','ANCASH','01','HUARAZ','06','JANGAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (91,'02','ANCASH','01','HUARAZ','07','LA LIBERTAD')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (92,'02','ANCASH','01','HUARAZ','08','OLLEROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (93,'02','ANCASH','01','HUARAZ','09','PAMPAS GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (94,'02','ANCASH','01','HUARAZ','10','PARIACOTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (95,'02','ANCASH','01','HUARAZ','11','PIRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (96,'02','ANCASH','01','HUARAZ','12','TARICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (97,'02','ANCASH','02','AIJA','01','AIJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (98,'02','ANCASH','02','AIJA','02','CORIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (99,'02','ANCASH','02','AIJA','03','HUACLLAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (100,'02','ANCASH','02','AIJA','04','LA MERCED')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (101,'02','ANCASH','02','AIJA','05','SUCCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (102,'02','ANCASH','03','ANTONIO RAYMONDI','01','LLAMELLIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (103,'02','ANCASH','03','ANTONIO RAYMONDI','02','ACZO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (104,'02','ANCASH','03','ANTONIO RAYMONDI','03','CHACCHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (105,'02','ANCASH','03','ANTONIO RAYMONDI','04','CHINGAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (106,'02','ANCASH','03','ANTONIO RAYMONDI','05','MIRGAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (107,'02','ANCASH','03','ANTONIO RAYMONDI','06','SAN JUAN DE RONTOY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (108,'02','ANCASH','04','ASUNCION','01','CHACAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (109,'02','ANCASH','04','ASUNCION','02','ACOCHACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (110,'02','ANCASH','05','BOLOGNESI','01','CHIQUIAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (111,'02','ANCASH','05','BOLOGNESI','02','ABELARDO PARDO LEZAMETA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (112,'02','ANCASH','05','BOLOGNESI','03','ANTONIO RAYMONDI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (113,'02','ANCASH','05','BOLOGNESI','04','AQUIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (114,'02','ANCASH','05','BOLOGNESI','05','CAJACAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (115,'02','ANCASH','05','BOLOGNESI','06','CANIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (116,'02','ANCASH','05','BOLOGNESI','07','COLQUIOC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (117,'02','ANCASH','05','BOLOGNESI','08','HUALLANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (118,'02','ANCASH','05','BOLOGNESI','09','HUASTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (119,'02','ANCASH','05','BOLOGNESI','10','HUAYLLACAYAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (120,'02','ANCASH','05','BOLOGNESI','11','LA PRIMAVERA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (121,'02','ANCASH','05','BOLOGNESI','12','MANGAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (122,'02','ANCASH','05','BOLOGNESI','13','PACLLON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (123,'02','ANCASH','05','BOLOGNESI','14','SAN MIGUEL DE CORPANQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (124,'02','ANCASH','05','BOLOGNESI','15','TICLLOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (125,'02','ANCASH','06','CARHUAZ','01','CARHUAZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (126,'02','ANCASH','06','CARHUAZ','02','ACOPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (127,'02','ANCASH','06','CARHUAZ','03','AMASHCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (128,'02','ANCASH','06','CARHUAZ','04','ANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (129,'02','ANCASH','06','CARHUAZ','05','ATAQUERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (130,'02','ANCASH','06','CARHUAZ','06','MARCARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (131,'02','ANCASH','06','CARHUAZ','07','PARIAHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (132,'02','ANCASH','06','CARHUAZ','08','SAN MIGUEL DE ACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (133,'02','ANCASH','06','CARHUAZ','09','SHILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (134,'02','ANCASH','06','CARHUAZ','10','TINCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (135,'02','ANCASH','06','CARHUAZ','11','YUNGAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (136,'02','ANCASH','07','CARLOS FERMIN FITZCARRALD','01','SAN LUIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (137,'02','ANCASH','07','CARLOS FERMIN FITZCARRALD','02','SAN NICOLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (138,'02','ANCASH','07','CARLOS FERMIN FITZCARRALD','03','YAUYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (139,'02','ANCASH','08','CASMA','01','CASMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (140,'02','ANCASH','08','CASMA','02','BUENA VISTA ALTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (141,'02','ANCASH','08','CASMA','03','COMANDANTE NOEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (142,'02','ANCASH','08','CASMA','04','YAUTAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (143,'02','ANCASH','09','CORONGO','01','CORONGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (144,'02','ANCASH','09','CORONGO','02','ACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (145,'02','ANCASH','09','CORONGO','03','BAMBAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (146,'02','ANCASH','09','CORONGO','04','CUSCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (147,'02','ANCASH','09','CORONGO','05','LA PAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (148,'02','ANCASH','09','CORONGO','06','YANAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (149,'02','ANCASH','09','CORONGO','07','YUPAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (150,'02','ANCASH','10','HUARI','01','HUARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (151,'02','ANCASH','10','HUARI','02','ANRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (152,'02','ANCASH','10','HUARI','03','CAJAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (153,'02','ANCASH','10','HUARI','04','CHAVIN DE HUANTAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (154,'02','ANCASH','10','HUARI','05','HUACACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (155,'02','ANCASH','10','HUARI','06','HUACCHIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (156,'02','ANCASH','10','HUARI','07','HUACHIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (157,'02','ANCASH','10','HUARI','08','HUANTAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (158,'02','ANCASH','10','HUARI','09','MASIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (159,'02','ANCASH','10','HUARI','10','PAUCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (160,'02','ANCASH','10','HUARI','11','PONTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (161,'02','ANCASH','10','HUARI','12','RAHUAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (162,'02','ANCASH','10','HUARI','13','RAPAYAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (163,'02','ANCASH','10','HUARI','14','SAN MARCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (164,'02','ANCASH','10','HUARI','15','SAN PEDRO DE CHANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (165,'02','ANCASH','10','HUARI','16','UCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (166,'02','ANCASH','11','HUARMEY','01','HUARMEY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (167,'02','ANCASH','11','HUARMEY','02','COCHAPETI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (168,'02','ANCASH','11','HUARMEY','03','CULEBRAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (169,'02','ANCASH','11','HUARMEY','04','HUAYAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (170,'02','ANCASH','11','HUARMEY','05','MALVAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (171,'02','ANCASH','12','HUAYLAS','01','CARAZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (172,'02','ANCASH','12','HUAYLAS','02','HUALLANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (173,'02','ANCASH','12','HUAYLAS','03','HUATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (174,'02','ANCASH','12','HUAYLAS','04','HUAYLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (175,'02','ANCASH','12','HUAYLAS','05','MATO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (176,'02','ANCASH','12','HUAYLAS','06','PAMPAROMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (177,'02','ANCASH','12','HUAYLAS','07','PUEBLO LIBRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (178,'02','ANCASH','12','HUAYLAS','08','SANTA CRUZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (179,'02','ANCASH','12','HUAYLAS','09','SANTO TORIBIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (180,'02','ANCASH','12','HUAYLAS','10','YURACMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (181,'02','ANCASH','13','MARISCAL LUZURIAGA','01','PISCOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (182,'02','ANCASH','13','MARISCAL LUZURIAGA','02','CASCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (183,'02','ANCASH','13','MARISCAL LUZURIAGA','03','ELEAZAR GUZMAN BARRON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (184,'02','ANCASH','13','MARISCAL LUZURIAGA','04','FIDEL OLIVAS ESCUDERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (185,'02','ANCASH','13','MARISCAL LUZURIAGA','05','LLAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (186,'02','ANCASH','13','MARISCAL LUZURIAGA','06','LLUMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (187,'02','ANCASH','13','MARISCAL LUZURIAGA','07','LUCMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (188,'02','ANCASH','13','MARISCAL LUZURIAGA','08','MUSGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (189,'02','ANCASH','14','OCROS','01','OCROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (190,'02','ANCASH','14','OCROS','02','ACAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (191,'02','ANCASH','14','OCROS','03','CAJAMARQUILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (192,'02','ANCASH','14','OCROS','04','CARHUAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (193,'02','ANCASH','14','OCROS','05','COCHAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (194,'02','ANCASH','14','OCROS','06','CONGAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (195,'02','ANCASH','14','OCROS','07','LLIPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (196,'02','ANCASH','14','OCROS','08','SAN CRISTOBAL DE RAJAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (197,'02','ANCASH','14','OCROS','09','SAN PEDRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (198,'02','ANCASH','14','OCROS','10','SANTIAGO DE CHILCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (199,'02','ANCASH','15','PALLASCA','01','CABANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (200,'02','ANCASH','15','PALLASCA','02','BOLOGNESI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (201,'02','ANCASH','15','PALLASCA','03','CONCHUCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (202,'02','ANCASH','15','PALLASCA','04','HUACASCHUQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (203,'02','ANCASH','15','PALLASCA','05','HUANDOVAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (204,'02','ANCASH','15','PALLASCA','06','LACABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (205,'02','ANCASH','15','PALLASCA','07','LLAPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (206,'02','ANCASH','15','PALLASCA','08','PALLASCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (207,'02','ANCASH','15','PALLASCA','09','PAMPAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (208,'02','ANCASH','15','PALLASCA','10','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (209,'02','ANCASH','15','PALLASCA','11','TAUCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (210,'02','ANCASH','16','POMABAMBA','01','POMABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (211,'02','ANCASH','16','POMABAMBA','02','HUAYLLAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (212,'02','ANCASH','16','POMABAMBA','03','PAROBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (213,'02','ANCASH','16','POMABAMBA','04','QUINUABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (214,'02','ANCASH','17','RECUAY','01','RECUAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (215,'02','ANCASH','17','RECUAY','02','CATAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (216,'02','ANCASH','17','RECUAY','03','COTAPARACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (217,'02','ANCASH','17','RECUAY','04','HUAYLLAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (218,'02','ANCASH','17','RECUAY','05','LLACLLIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (219,'02','ANCASH','17','RECUAY','06','MARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (220,'02','ANCASH','17','RECUAY','07','PAMPAS CHICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (221,'02','ANCASH','17','RECUAY','08','PARARIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (222,'02','ANCASH','17','RECUAY','09','TAPACOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (223,'02','ANCASH','17','RECUAY','10','TICAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (224,'02','ANCASH','18','SANTA','01','CHIMBOTE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (225,'02','ANCASH','18','SANTA','02','CACERES DEL PERU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (226,'02','ANCASH','18','SANTA','03','COISHCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (227,'02','ANCASH','18','SANTA','04','MACATE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (228,'02','ANCASH','18','SANTA','05','MORO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (229,'02','ANCASH','18','SANTA','06','NEPEÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (230,'02','ANCASH','18','SANTA','07','SAMANCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (231,'02','ANCASH','18','SANTA','08','SANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (232,'02','ANCASH','18','SANTA','09','NUEVO CHIMBOTE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (233,'02','ANCASH','19','SIHUAS','01','SIHUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (234,'02','ANCASH','19','SIHUAS','02','ACOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (235,'02','ANCASH','19','SIHUAS','03','ALFONSO UGARTE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (236,'02','ANCASH','19','SIHUAS','04','CASHAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (237,'02','ANCASH','19','SIHUAS','05','CHINGALPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (238,'02','ANCASH','19','SIHUAS','06','HUAYLLABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (239,'02','ANCASH','19','SIHUAS','07','QUICHES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (240,'02','ANCASH','19','SIHUAS','08','RAGASH')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (241,'02','ANCASH','19','SIHUAS','09','SAN JUAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (242,'02','ANCASH','19','SIHUAS','10','SICSIBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (243,'02','ANCASH','20','YUNGAY','01','YUNGAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (244,'02','ANCASH','20','YUNGAY','02','CASCAPARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (245,'02','ANCASH','20','YUNGAY','03','MANCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (246,'02','ANCASH','20','YUNGAY','04','MATACOTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (247,'02','ANCASH','20','YUNGAY','05','QUILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (248,'02','ANCASH','20','YUNGAY','06','RANRAHIRCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (249,'02','ANCASH','20','YUNGAY','07','SHUPLUY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (250,'02','ANCASH','20','YUNGAY','08','YANAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (251,'03','APURIMAC','01','ABANCAY','01','ABANCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (252,'03','APURIMAC','01','ABANCAY','02','CHACOCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (253,'03','APURIMAC','01','ABANCAY','03','CIRCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (254,'03','APURIMAC','01','ABANCAY','04','CURAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (255,'03','APURIMAC','01','ABANCAY','05','HUANIPACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (256,'03','APURIMAC','01','ABANCAY','06','LAMBRAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (257,'03','APURIMAC','01','ABANCAY','07','PICHIRHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (258,'03','APURIMAC','01','ABANCAY','08','SAN PEDRO DE CACHORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (259,'03','APURIMAC','01','ABANCAY','09','TAMBURCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (260,'03','APURIMAC','02','ANDAHUAYLAS','01','ANDAHUAYLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (261,'03','APURIMAC','02','ANDAHUAYLAS','02','ANDARAPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (262,'03','APURIMAC','02','ANDAHUAYLAS','03','CHIARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (263,'03','APURIMAC','02','ANDAHUAYLAS','04','HUANCARAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (264,'03','APURIMAC','02','ANDAHUAYLAS','05','HUANCARAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (265,'03','APURIMAC','02','ANDAHUAYLAS','06','HUAYANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (266,'03','APURIMAC','02','ANDAHUAYLAS','07','KISHUARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (267,'03','APURIMAC','02','ANDAHUAYLAS','08','PACOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (268,'03','APURIMAC','02','ANDAHUAYLAS','09','PACUCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (269,'03','APURIMAC','02','ANDAHUAYLAS','10','PAMPACHIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (270,'03','APURIMAC','02','ANDAHUAYLAS','11','POMACOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (271,'03','APURIMAC','02','ANDAHUAYLAS','12','SAN ANTONIO DE CACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (272,'03','APURIMAC','02','ANDAHUAYLAS','13','SAN JERONIMO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (273,'03','APURIMAC','02','ANDAHUAYLAS','14','SAN MIGUEL DE CHACCRAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (274,'03','APURIMAC','02','ANDAHUAYLAS','15','SANTA MARIA DE CHICMO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (275,'03','APURIMAC','02','ANDAHUAYLAS','16','TALAVERA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (276,'03','APURIMAC','02','ANDAHUAYLAS','17','TUMAY HUARACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (277,'03','APURIMAC','02','ANDAHUAYLAS','18','TURPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (278,'03','APURIMAC','02','ANDAHUAYLAS','19','KAQUIABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (279,'03','APURIMAC','02','ANDAHUAYLAS','20','JOSE MARIA ARGUEDAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (280,'03','APURIMAC','03','ANTABAMBA','01','ANTABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (281,'03','APURIMAC','03','ANTABAMBA','02','EL ORO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (282,'03','APURIMAC','03','ANTABAMBA','03','HUAQUIRCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (283,'03','APURIMAC','03','ANTABAMBA','04','JUAN ESPINOZA MEDRANO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (284,'03','APURIMAC','03','ANTABAMBA','05','OROPESA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (285,'03','APURIMAC','03','ANTABAMBA','06','PACHACONAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (286,'03','APURIMAC','03','ANTABAMBA','07','SABAINO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (287,'03','APURIMAC','04','AYMARAES','01','CHALHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (288,'03','APURIMAC','04','AYMARAES','02','CAPAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (289,'03','APURIMAC','04','AYMARAES','03','CARAYBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (290,'03','APURIMAC','04','AYMARAES','04','CHAPIMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (291,'03','APURIMAC','04','AYMARAES','05','COLCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (292,'03','APURIMAC','04','AYMARAES','06','COTARUSE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (293,'03','APURIMAC','04','AYMARAES','07','IHUAYLLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (294,'03','APURIMAC','04','AYMARAES','08','JUSTO APU SAHUARAURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (295,'03','APURIMAC','04','AYMARAES','09','LUCRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (296,'03','APURIMAC','04','AYMARAES','10','POCOHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (297,'03','APURIMAC','04','AYMARAES','11','SAN JUAN DE CHACÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (298,'03','APURIMAC','04','AYMARAES','12','SAÑAYCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (299,'03','APURIMAC','04','AYMARAES','13','SORAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (300,'03','APURIMAC','04','AYMARAES','14','TAPAIRIHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (301,'03','APURIMAC','04','AYMARAES','15','TINTAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (302,'03','APURIMAC','04','AYMARAES','16','TORAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (303,'03','APURIMAC','04','AYMARAES','17','YANACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (304,'03','APURIMAC','05','COTABAMBAS','01','TAMBOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (305,'03','APURIMAC','05','COTABAMBAS','02','COTABAMBAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (306,'03','APURIMAC','05','COTABAMBAS','03','COYLLURQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (307,'03','APURIMAC','05','COTABAMBAS','04','HAQUIRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (308,'03','APURIMAC','05','COTABAMBAS','05','MARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (309,'03','APURIMAC','05','COTABAMBAS','06','CHALLHUAHUACHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (310,'03','APURIMAC','06','CHINCHEROS','01','CHINCHEROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (311,'03','APURIMAC','06','CHINCHEROS','02','ANCO_HUALLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (312,'03','APURIMAC','06','CHINCHEROS','03','COCHARCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (313,'03','APURIMAC','06','CHINCHEROS','04','HUACCANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (314,'03','APURIMAC','06','CHINCHEROS','05','OCOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (315,'03','APURIMAC','06','CHINCHEROS','06','ONGOY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (316,'03','APURIMAC','06','CHINCHEROS','07','URANMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (317,'03','APURIMAC','06','CHINCHEROS','08','RANRACANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (318,'03','APURIMAC','06','CHINCHEROS','09','ROCCHACC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (319,'03','APURIMAC','06','CHINCHEROS','10','EL PORVENIR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (320,'03','APURIMAC','06','CHINCHEROS','11','LOS CHANKAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (321,'03','APURIMAC','07','GRAU','01','CHUQUIBAMBILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (322,'03','APURIMAC','07','GRAU','02','CURPAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (323,'03','APURIMAC','07','GRAU','03','GAMARRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (324,'03','APURIMAC','07','GRAU','04','HUAYLLATI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (325,'03','APURIMAC','07','GRAU','05','MAMARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (326,'03','APURIMAC','07','GRAU','06','MICAELA BASTIDAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (327,'03','APURIMAC','07','GRAU','07','PATAYPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (328,'03','APURIMAC','07','GRAU','08','PROGRESO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (329,'03','APURIMAC','07','GRAU','09','SAN ANTONIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (330,'03','APURIMAC','07','GRAU','10','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (331,'03','APURIMAC','07','GRAU','11','TURPAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (332,'03','APURIMAC','07','GRAU','12','VILCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (333,'03','APURIMAC','07','GRAU','13','VIRUNDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (334,'03','APURIMAC','07','GRAU','14','CURASCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (335,'04','AREQUIPA','01','AREQUIPA','01','AREQUIPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (336,'04','AREQUIPA','01','AREQUIPA','02','ALTO SELVA ALEGRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (337,'04','AREQUIPA','01','AREQUIPA','03','CAYMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (338,'04','AREQUIPA','01','AREQUIPA','04','CERRO COLORADO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (339,'04','AREQUIPA','01','AREQUIPA','05','CHARACATO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (340,'04','AREQUIPA','01','AREQUIPA','06','CHIGUATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (341,'04','AREQUIPA','01','AREQUIPA','07','JACOBO HUNTER')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (342,'04','AREQUIPA','01','AREQUIPA','08','LA JOYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (343,'04','AREQUIPA','01','AREQUIPA','09','MARIANO MELGAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (344,'04','AREQUIPA','01','AREQUIPA','10','MIRAFLORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (345,'04','AREQUIPA','01','AREQUIPA','11','MOLLEBAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (346,'04','AREQUIPA','01','AREQUIPA','12','PAUCARPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (347,'04','AREQUIPA','01','AREQUIPA','13','POCSI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (348,'04','AREQUIPA','01','AREQUIPA','14','POLOBAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (349,'04','AREQUIPA','01','AREQUIPA','15','QUEQUEÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (350,'04','AREQUIPA','01','AREQUIPA','16','SABANDIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (351,'04','AREQUIPA','01','AREQUIPA','17','SACHACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (352,'04','AREQUIPA','01','AREQUIPA','18','SAN JUAN DE SIGUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (353,'04','AREQUIPA','01','AREQUIPA','19','SAN JUAN DE TARUCANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (354,'04','AREQUIPA','01','AREQUIPA','20','SANTA ISABEL DE SIGUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (355,'04','AREQUIPA','01','AREQUIPA','21','SANTA RITA DE SIGUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (356,'04','AREQUIPA','01','AREQUIPA','22','SOCABAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (357,'04','AREQUIPA','01','AREQUIPA','23','TIABAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (358,'04','AREQUIPA','01','AREQUIPA','24','UCHUMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (359,'04','AREQUIPA','01','AREQUIPA','25','VITOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (360,'04','AREQUIPA','01','AREQUIPA','26','YANAHUARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (361,'04','AREQUIPA','01','AREQUIPA','27','YARABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (362,'04','AREQUIPA','01','AREQUIPA','28','YURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (363,'04','AREQUIPA','01','AREQUIPA','29','JOSE LUIS BUSTAMANTE Y RIVERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (364,'04','AREQUIPA','02','CAMANA','01','CAMANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (365,'04','AREQUIPA','02','CAMANA','02','JOSE MARIA QUIMPER')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (366,'04','AREQUIPA','02','CAMANA','03','MARIANO NICOLAS VALCARCEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (367,'04','AREQUIPA','02','CAMANA','04','MARISCAL CACERES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (368,'04','AREQUIPA','02','CAMANA','05','NICOLAS DE PIEROLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (369,'04','AREQUIPA','02','CAMANA','06','OCOÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (370,'04','AREQUIPA','02','CAMANA','07','QUILCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (371,'04','AREQUIPA','02','CAMANA','08','SAMUEL PASTOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (372,'04','AREQUIPA','03','CARAVELI','01','CARAVELI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (373,'04','AREQUIPA','03','CARAVELI','02','ACARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (374,'04','AREQUIPA','03','CARAVELI','03','ATICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (375,'04','AREQUIPA','03','CARAVELI','04','ATIQUIPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (376,'04','AREQUIPA','03','CARAVELI','05','BELLA UNION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (377,'04','AREQUIPA','03','CARAVELI','06','CAHUACHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (378,'04','AREQUIPA','03','CARAVELI','07','CHALA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (379,'04','AREQUIPA','03','CARAVELI','08','CHAPARRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (380,'04','AREQUIPA','03','CARAVELI','09','HUANUHUANU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (381,'04','AREQUIPA','03','CARAVELI','10','JAQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (382,'04','AREQUIPA','03','CARAVELI','11','LOMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (383,'04','AREQUIPA','03','CARAVELI','12','QUICACHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (384,'04','AREQUIPA','03','CARAVELI','13','YAUCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (385,'04','AREQUIPA','04','CASTILLA','01','APLAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (386,'04','AREQUIPA','04','CASTILLA','02','ANDAGUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (387,'04','AREQUIPA','04','CASTILLA','03','AYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (388,'04','AREQUIPA','04','CASTILLA','04','CHACHAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (389,'04','AREQUIPA','04','CASTILLA','05','CHILCAYMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (390,'04','AREQUIPA','04','CASTILLA','06','CHOCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (391,'04','AREQUIPA','04','CASTILLA','07','HUANCARQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (392,'04','AREQUIPA','04','CASTILLA','08','MACHAGUAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (393,'04','AREQUIPA','04','CASTILLA','09','ORCOPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (394,'04','AREQUIPA','04','CASTILLA','10','PAMPACOLCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (395,'04','AREQUIPA','04','CASTILLA','11','TIPAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (396,'04','AREQUIPA','04','CASTILLA','12','UÑON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (397,'04','AREQUIPA','04','CASTILLA','13','URACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (398,'04','AREQUIPA','04','CASTILLA','14','VIRACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (399,'04','AREQUIPA','05','CAYLLOMA','01','CHIVAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (400,'04','AREQUIPA','05','CAYLLOMA','02','ACHOMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (401,'04','AREQUIPA','05','CAYLLOMA','03','CABANACONDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (402,'04','AREQUIPA','05','CAYLLOMA','04','CALLALLI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (403,'04','AREQUIPA','05','CAYLLOMA','05','CAYLLOMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (404,'04','AREQUIPA','05','CAYLLOMA','06','COPORAQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (405,'04','AREQUIPA','05','CAYLLOMA','07','HUAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (406,'04','AREQUIPA','05','CAYLLOMA','08','HUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (407,'04','AREQUIPA','05','CAYLLOMA','09','ICHUPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (408,'04','AREQUIPA','05','CAYLLOMA','10','LARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (409,'04','AREQUIPA','05','CAYLLOMA','11','LLUTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (410,'04','AREQUIPA','05','CAYLLOMA','12','MACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (411,'04','AREQUIPA','05','CAYLLOMA','13','MADRIGAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (412,'04','AREQUIPA','05','CAYLLOMA','14','SAN ANTONIO DE CHUCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (413,'04','AREQUIPA','05','CAYLLOMA','15','SIBAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (414,'04','AREQUIPA','05','CAYLLOMA','16','TAPAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (415,'04','AREQUIPA','05','CAYLLOMA','17','TISCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (416,'04','AREQUIPA','05','CAYLLOMA','18','TUTI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (417,'04','AREQUIPA','05','CAYLLOMA','19','YANQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (418,'04','AREQUIPA','05','CAYLLOMA','20','MAJES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (419,'04','AREQUIPA','06','CONDESUYOS','01','CHUQUIBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (420,'04','AREQUIPA','06','CONDESUYOS','02','ANDARAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (421,'04','AREQUIPA','06','CONDESUYOS','03','CAYARANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (422,'04','AREQUIPA','06','CONDESUYOS','04','CHICHAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (423,'04','AREQUIPA','06','CONDESUYOS','05','IRAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (424,'04','AREQUIPA','06','CONDESUYOS','06','RIO GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (425,'04','AREQUIPA','06','CONDESUYOS','07','SALAMANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (426,'04','AREQUIPA','06','CONDESUYOS','08','YANAQUIHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (427,'04','AREQUIPA','07','ISLAY','01','MOLLENDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (428,'04','AREQUIPA','07','ISLAY','02','COCACHACRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (429,'04','AREQUIPA','07','ISLAY','03','DEAN VALDIVIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (430,'04','AREQUIPA','07','ISLAY','04','ISLAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (431,'04','AREQUIPA','07','ISLAY','05','MEJIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (432,'04','AREQUIPA','07','ISLAY','06','PUNTA DE BOMBON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (433,'04','AREQUIPA','08','LA UNION','01','COTAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (434,'04','AREQUIPA','08','LA UNION','02','ALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (435,'04','AREQUIPA','08','LA UNION','03','CHARCANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (436,'04','AREQUIPA','08','LA UNION','04','HUAYNACOTAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (437,'04','AREQUIPA','08','LA UNION','05','PAMPAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (438,'04','AREQUIPA','08','LA UNION','06','PUYCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (439,'04','AREQUIPA','08','LA UNION','07','QUECHUALLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (440,'04','AREQUIPA','08','LA UNION','08','SAYLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (441,'04','AREQUIPA','08','LA UNION','09','TAURIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (442,'04','AREQUIPA','08','LA UNION','10','TOMEPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (443,'04','AREQUIPA','08','LA UNION','11','TORO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (444,'05','AYACUCHO','01','HUAMANGA','01','AYACUCHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (445,'05','AYACUCHO','01','HUAMANGA','02','ACOCRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (446,'05','AYACUCHO','01','HUAMANGA','03','ACOS VINCHOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (447,'05','AYACUCHO','01','HUAMANGA','04','CARMEN ALTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (448,'05','AYACUCHO','01','HUAMANGA','05','CHIARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (449,'05','AYACUCHO','01','HUAMANGA','06','OCROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (450,'05','AYACUCHO','01','HUAMANGA','07','PACAYCASA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (451,'05','AYACUCHO','01','HUAMANGA','08','QUINUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (452,'05','AYACUCHO','01','HUAMANGA','09','SAN JOSE DE TICLLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (453,'05','AYACUCHO','01','HUAMANGA','10','SAN JUAN BAUTISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (454,'05','AYACUCHO','01','HUAMANGA','11','SANTIAGO DE PISCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (455,'05','AYACUCHO','01','HUAMANGA','12','SOCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (456,'05','AYACUCHO','01','HUAMANGA','13','TAMBILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (457,'05','AYACUCHO','01','HUAMANGA','14','VINCHOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (458,'05','AYACUCHO','01','HUAMANGA','15','JESUS NAZARENO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (459,'05','AYACUCHO','01','HUAMANGA','16','ANDRES AVELINO CACERES DORREGARAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (460,'05','AYACUCHO','02','CANGALLO','01','CANGALLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (461,'05','AYACUCHO','02','CANGALLO','02','CHUSCHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (462,'05','AYACUCHO','02','CANGALLO','03','LOS MOROCHUCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (463,'05','AYACUCHO','02','CANGALLO','04','MARIA PARADO DE BELLIDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (464,'05','AYACUCHO','02','CANGALLO','05','PARAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (465,'05','AYACUCHO','02','CANGALLO','06','TOTOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (466,'05','AYACUCHO','03','HUANCA SANCOS','01','SANCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (467,'05','AYACUCHO','03','HUANCA SANCOS','02','CARAPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (468,'05','AYACUCHO','03','HUANCA SANCOS','03','SACSAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (469,'05','AYACUCHO','03','HUANCA SANCOS','04','SANTIAGO DE LUCANAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (470,'05','AYACUCHO','04','HUANTA','01','HUANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (471,'05','AYACUCHO','04','HUANTA','02','AYAHUANCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (472,'05','AYACUCHO','04','HUANTA','03','HUAMANGUILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (473,'05','AYACUCHO','04','HUANTA','04','IGUAIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (474,'05','AYACUCHO','04','HUANTA','05','LURICOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (475,'05','AYACUCHO','04','HUANTA','06','SANTILLANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (476,'05','AYACUCHO','04','HUANTA','07','SIVIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (477,'05','AYACUCHO','04','HUANTA','08','LLOCHEGUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (478,'05','AYACUCHO','04','HUANTA','09','CANAYRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (479,'05','AYACUCHO','04','HUANTA','10','UCHURACCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (480,'05','AYACUCHO','04','HUANTA','11','PUCACOLPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (481,'05','AYACUCHO','04','HUANTA','12','CHACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (482,'05','AYACUCHO','05','LA MAR','01','SAN MIGUEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (483,'05','AYACUCHO','05','LA MAR','02','ANCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (484,'05','AYACUCHO','05','LA MAR','03','AYNA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (485,'05','AYACUCHO','05','LA MAR','04','CHILCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (486,'05','AYACUCHO','05','LA MAR','05','CHUNGUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (487,'05','AYACUCHO','05','LA MAR','06','LUIS CARRANZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (488,'05','AYACUCHO','05','LA MAR','07','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (489,'05','AYACUCHO','05','LA MAR','08','TAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (490,'05','AYACUCHO','05','LA MAR','09','SAMUGARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (491,'05','AYACUCHO','05','LA MAR','10','ANCHIHUAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (492,'05','AYACUCHO','05','LA MAR','11','ORONCCOY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (493,'05','AYACUCHO','06','LUCANAS','01','PUQUIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (494,'05','AYACUCHO','06','LUCANAS','02','AUCARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (495,'05','AYACUCHO','06','LUCANAS','03','CABANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (496,'05','AYACUCHO','06','LUCANAS','04','CARMEN SALCEDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (497,'05','AYACUCHO','06','LUCANAS','05','CHAVIÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (498,'05','AYACUCHO','06','LUCANAS','06','CHIPAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (499,'05','AYACUCHO','06','LUCANAS','07','HUAC-HUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (500,'05','AYACUCHO','06','LUCANAS','08','LARAMATE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (501,'05','AYACUCHO','06','LUCANAS','09','LEONCIO PRADO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (502,'05','AYACUCHO','06','LUCANAS','10','LLAUTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (503,'05','AYACUCHO','06','LUCANAS','11','LUCANAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (504,'05','AYACUCHO','06','LUCANAS','12','OCAÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (505,'05','AYACUCHO','06','LUCANAS','13','OTOCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (506,'05','AYACUCHO','06','LUCANAS','14','SAISA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (507,'05','AYACUCHO','06','LUCANAS','15','SAN CRISTOBAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (508,'05','AYACUCHO','06','LUCANAS','16','SAN JUAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (509,'05','AYACUCHO','06','LUCANAS','17','SAN PEDRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (510,'05','AYACUCHO','06','LUCANAS','18','SAN PEDRO DE PALCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (511,'05','AYACUCHO','06','LUCANAS','19','SANCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (512,'05','AYACUCHO','06','LUCANAS','20','SANTA ANA DE HUAYCAHUACHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (513,'05','AYACUCHO','06','LUCANAS','21','SANTA LUCIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (514,'05','AYACUCHO','07','PARINACOCHAS','01','CORACORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (515,'05','AYACUCHO','07','PARINACOCHAS','02','CHUMPI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (516,'05','AYACUCHO','07','PARINACOCHAS','03','CORONEL CASTAÑEDA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (517,'05','AYACUCHO','07','PARINACOCHAS','04','PACAPAUSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (518,'05','AYACUCHO','07','PARINACOCHAS','05','PULLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (519,'05','AYACUCHO','07','PARINACOCHAS','06','PUYUSCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (520,'05','AYACUCHO','07','PARINACOCHAS','07','SAN FRANCISCO DE RAVACAYCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (521,'05','AYACUCHO','07','PARINACOCHAS','08','UPAHUACHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (522,'05','AYACUCHO','08','PAUCAR DEL SARA SARA','01','PAUSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (523,'05','AYACUCHO','08','PAUCAR DEL SARA SARA','02','COLTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (524,'05','AYACUCHO','08','PAUCAR DEL SARA SARA','03','CORCULLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (525,'05','AYACUCHO','08','PAUCAR DEL SARA SARA','04','LAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (526,'05','AYACUCHO','08','PAUCAR DEL SARA SARA','05','MARCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (527,'05','AYACUCHO','08','PAUCAR DEL SARA SARA','06','OYOLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (528,'05','AYACUCHO','08','PAUCAR DEL SARA SARA','07','PARARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (529,'05','AYACUCHO','08','PAUCAR DEL SARA SARA','08','SAN JAVIER DE ALPABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (530,'05','AYACUCHO','08','PAUCAR DEL SARA SARA','09','SAN JOSE DE USHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (531,'05','AYACUCHO','08','PAUCAR DEL SARA SARA','10','SARA SARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (532,'05','AYACUCHO','09','SUCRE','01','QUEROBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (533,'05','AYACUCHO','09','SUCRE','02','BELEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (534,'05','AYACUCHO','09','SUCRE','03','CHALCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (535,'05','AYACUCHO','09','SUCRE','04','CHILCAYOC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (536,'05','AYACUCHO','09','SUCRE','05','HUACAÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (537,'05','AYACUCHO','09','SUCRE','06','MORCOLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (538,'05','AYACUCHO','09','SUCRE','07','PAICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (539,'05','AYACUCHO','09','SUCRE','08','SAN PEDRO DE LARCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (540,'05','AYACUCHO','09','SUCRE','09','SAN SALVADOR DE QUIJE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (541,'05','AYACUCHO','09','SUCRE','10','SANTIAGO DE PAUCARAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (542,'05','AYACUCHO','09','SUCRE','11','SORAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (543,'05','AYACUCHO','10','VICTOR FAJARDO','01','HUANCAPI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (544,'05','AYACUCHO','10','VICTOR FAJARDO','02','ALCAMENCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (545,'05','AYACUCHO','10','VICTOR FAJARDO','03','APONGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (546,'05','AYACUCHO','10','VICTOR FAJARDO','04','ASQUIPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (547,'05','AYACUCHO','10','VICTOR FAJARDO','05','CANARIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (548,'05','AYACUCHO','10','VICTOR FAJARDO','06','CAYARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (549,'05','AYACUCHO','10','VICTOR FAJARDO','07','COLCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (550,'05','AYACUCHO','10','VICTOR FAJARDO','08','HUAMANQUIQUIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (551,'05','AYACUCHO','10','VICTOR FAJARDO','09','HUANCARAYLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (552,'05','AYACUCHO','10','VICTOR FAJARDO','10','HUAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (553,'05','AYACUCHO','10','VICTOR FAJARDO','11','SARHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (554,'05','AYACUCHO','10','VICTOR FAJARDO','12','VILCANCHOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (555,'05','AYACUCHO','11','VILCAS HUAMAN','01','VILCAS HUAMAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (556,'05','AYACUCHO','11','VILCAS HUAMAN','02','ACCOMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (557,'05','AYACUCHO','11','VILCAS HUAMAN','03','CARHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (558,'05','AYACUCHO','11','VILCAS HUAMAN','04','CONCEPCION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (559,'05','AYACUCHO','11','VILCAS HUAMAN','05','HUAMBALPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (560,'05','AYACUCHO','11','VILCAS HUAMAN','06','INDEPENDENCIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (561,'05','AYACUCHO','11','VILCAS HUAMAN','07','SAURAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (562,'05','AYACUCHO','11','VILCAS HUAMAN','08','VISCHONGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (563,'06','CAJAMARCA','01','CAJAMARCA','01','CAJAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (564,'06','CAJAMARCA','01','CAJAMARCA','02','ASUNCION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (565,'06','CAJAMARCA','01','CAJAMARCA','03','CHETILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (566,'06','CAJAMARCA','01','CAJAMARCA','04','COSPAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (567,'06','CAJAMARCA','01','CAJAMARCA','05','ENCAÑADA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (568,'06','CAJAMARCA','01','CAJAMARCA','06','JESUS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (569,'06','CAJAMARCA','01','CAJAMARCA','07','LLACANORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (570,'06','CAJAMARCA','01','CAJAMARCA','08','LOS BAÑOS DEL INCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (571,'06','CAJAMARCA','01','CAJAMARCA','09','MAGDALENA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (572,'06','CAJAMARCA','01','CAJAMARCA','10','MATARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (573,'06','CAJAMARCA','01','CAJAMARCA','11','NAMORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (574,'06','CAJAMARCA','01','CAJAMARCA','12','SAN JUAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (575,'06','CAJAMARCA','02','CAJABAMBA','01','CAJABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (576,'06','CAJAMARCA','02','CAJABAMBA','02','CACHACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (577,'06','CAJAMARCA','02','CAJABAMBA','03','CONDEBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (578,'06','CAJAMARCA','02','CAJABAMBA','04','SITACOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (579,'06','CAJAMARCA','03','CELENDIN','01','CELENDIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (580,'06','CAJAMARCA','03','CELENDIN','02','CHUMUCH')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (581,'06','CAJAMARCA','03','CELENDIN','03','CORTEGANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (582,'06','CAJAMARCA','03','CELENDIN','04','HUASMIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (583,'06','CAJAMARCA','03','CELENDIN','05','JORGE CHAVEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (584,'06','CAJAMARCA','03','CELENDIN','06','JOSE GALVEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (585,'06','CAJAMARCA','03','CELENDIN','07','MIGUEL IGLESIAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (586,'06','CAJAMARCA','03','CELENDIN','08','OXAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (587,'06','CAJAMARCA','03','CELENDIN','09','SOROCHUCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (588,'06','CAJAMARCA','03','CELENDIN','10','SUCRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (589,'06','CAJAMARCA','03','CELENDIN','11','UTCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (590,'06','CAJAMARCA','03','CELENDIN','12','LA LIBERTAD DE PALLAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (591,'06','CAJAMARCA','04','CHOTA','01','CHOTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (592,'06','CAJAMARCA','04','CHOTA','02','ANGUIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (593,'06','CAJAMARCA','04','CHOTA','03','CHADIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (594,'06','CAJAMARCA','04','CHOTA','04','CHIGUIRIP')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (595,'06','CAJAMARCA','04','CHOTA','05','CHIMBAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (596,'06','CAJAMARCA','04','CHOTA','06','CHOROPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (597,'06','CAJAMARCA','04','CHOTA','07','COCHABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (598,'06','CAJAMARCA','04','CHOTA','08','CONCHAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (599,'06','CAJAMARCA','04','CHOTA','09','HUAMBOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (600,'06','CAJAMARCA','04','CHOTA','10','LAJAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (601,'06','CAJAMARCA','04','CHOTA','11','LLAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (602,'06','CAJAMARCA','04','CHOTA','12','MIRACOSTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (603,'06','CAJAMARCA','04','CHOTA','13','PACCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (604,'06','CAJAMARCA','04','CHOTA','14','PION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (605,'06','CAJAMARCA','04','CHOTA','15','QUEROCOTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (606,'06','CAJAMARCA','04','CHOTA','16','SAN JUAN DE LICUPIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (607,'06','CAJAMARCA','04','CHOTA','17','TACABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (608,'06','CAJAMARCA','04','CHOTA','18','TOCMOCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (609,'06','CAJAMARCA','04','CHOTA','19','CHALAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (610,'06','CAJAMARCA','05','CONTUMAZA','01','CONTUMAZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (611,'06','CAJAMARCA','05','CONTUMAZA','02','CHILETE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (612,'06','CAJAMARCA','05','CONTUMAZA','03','CUPISNIQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (613,'06','CAJAMARCA','05','CONTUMAZA','04','GUZMANGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (614,'06','CAJAMARCA','05','CONTUMAZA','05','SAN BENITO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (615,'06','CAJAMARCA','05','CONTUMAZA','06','SANTA CRUZ DE TOLEDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (616,'06','CAJAMARCA','05','CONTUMAZA','07','TANTARICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (617,'06','CAJAMARCA','05','CONTUMAZA','08','YONAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (618,'06','CAJAMARCA','06','CUTERVO','01','CUTERVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (619,'06','CAJAMARCA','06','CUTERVO','02','CALLAYUC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (620,'06','CAJAMARCA','06','CUTERVO','03','CHOROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (621,'06','CAJAMARCA','06','CUTERVO','04','CUJILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (622,'06','CAJAMARCA','06','CUTERVO','05','LA RAMADA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (623,'06','CAJAMARCA','06','CUTERVO','06','PIMPINGOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (624,'06','CAJAMARCA','06','CUTERVO','07','QUEROCOTILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (625,'06','CAJAMARCA','06','CUTERVO','08','SAN ANDRES DE CUTERVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (626,'06','CAJAMARCA','06','CUTERVO','09','SAN JUAN DE CUTERVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (627,'06','CAJAMARCA','06','CUTERVO','10','SAN LUIS DE LUCMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (628,'06','CAJAMARCA','06','CUTERVO','11','SANTA CRUZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (629,'06','CAJAMARCA','06','CUTERVO','12','SANTO DOMINGO DE LA CAPILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (630,'06','CAJAMARCA','06','CUTERVO','13','SANTO TOMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (631,'06','CAJAMARCA','06','CUTERVO','14','SOCOTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (632,'06','CAJAMARCA','06','CUTERVO','15','TORIBIO CASANOVA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (633,'06','CAJAMARCA','07','HUALGAYOC','01','BAMBAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (634,'06','CAJAMARCA','07','HUALGAYOC','02','CHUGUR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (635,'06','CAJAMARCA','07','HUALGAYOC','03','HUALGAYOC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (636,'06','CAJAMARCA','08','JAEN','01','JAEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (637,'06','CAJAMARCA','08','JAEN','02','BELLAVISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (638,'06','CAJAMARCA','08','JAEN','03','CHONTALI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (639,'06','CAJAMARCA','08','JAEN','04','COLASAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (640,'06','CAJAMARCA','08','JAEN','05','HUABAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (641,'06','CAJAMARCA','08','JAEN','06','LAS PIRIAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (642,'06','CAJAMARCA','08','JAEN','07','POMAHUACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (643,'06','CAJAMARCA','08','JAEN','08','PUCARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (644,'06','CAJAMARCA','08','JAEN','09','SALLIQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (645,'06','CAJAMARCA','08','JAEN','10','SAN FELIPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (646,'06','CAJAMARCA','08','JAEN','11','SAN JOSE DEL ALTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (647,'06','CAJAMARCA','08','JAEN','12','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (648,'06','CAJAMARCA','09','SAN IGNACIO','01','SAN IGNACIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (649,'06','CAJAMARCA','09','SAN IGNACIO','02','CHIRINOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (650,'06','CAJAMARCA','09','SAN IGNACIO','03','HUARANGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (651,'06','CAJAMARCA','09','SAN IGNACIO','04','LA COIPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (652,'06','CAJAMARCA','09','SAN IGNACIO','05','NAMBALLE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (653,'06','CAJAMARCA','09','SAN IGNACIO','06','SAN JOSE DE LOURDES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (654,'06','CAJAMARCA','09','SAN IGNACIO','07','TABACONAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (655,'06','CAJAMARCA','10','SAN MARCOS','01','PEDRO GALVEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (656,'06','CAJAMARCA','10','SAN MARCOS','02','CHANCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (657,'06','CAJAMARCA','10','SAN MARCOS','03','EDUARDO VILLANUEVA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (658,'06','CAJAMARCA','10','SAN MARCOS','04','GREGORIO PITA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (659,'06','CAJAMARCA','10','SAN MARCOS','05','ICHOCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (660,'06','CAJAMARCA','10','SAN MARCOS','06','JOSE MANUEL QUIROZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (661,'06','CAJAMARCA','10','SAN MARCOS','07','JOSE SABOGAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (662,'06','CAJAMARCA','11','SAN MIGUEL','01','SAN MIGUEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (663,'06','CAJAMARCA','11','SAN MIGUEL','02','BOLIVAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (664,'06','CAJAMARCA','11','SAN MIGUEL','03','CALQUIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (665,'06','CAJAMARCA','11','SAN MIGUEL','04','CATILLUC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (666,'06','CAJAMARCA','11','SAN MIGUEL','05','EL PRADO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (667,'06','CAJAMARCA','11','SAN MIGUEL','06','LA FLORIDA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (668,'06','CAJAMARCA','11','SAN MIGUEL','07','LLAPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (669,'06','CAJAMARCA','11','SAN MIGUEL','08','NANCHOC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (670,'06','CAJAMARCA','11','SAN MIGUEL','09','NIEPOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (671,'06','CAJAMARCA','11','SAN MIGUEL','10','SAN GREGORIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (672,'06','CAJAMARCA','11','SAN MIGUEL','11','SAN SILVESTRE DE COCHAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (673,'06','CAJAMARCA','11','SAN MIGUEL','12','TONGOD')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (674,'06','CAJAMARCA','11','SAN MIGUEL','13','UNION AGUA BLANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (675,'06','CAJAMARCA','12','SAN PABLO','01','SAN PABLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (676,'06','CAJAMARCA','12','SAN PABLO','02','SAN BERNARDINO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (677,'06','CAJAMARCA','12','SAN PABLO','03','SAN LUIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (678,'06','CAJAMARCA','12','SAN PABLO','04','TUMBADEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (679,'06','CAJAMARCA','13','SANTA CRUZ','01','SANTA CRUZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (680,'06','CAJAMARCA','13','SANTA CRUZ','02','ANDABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (681,'06','CAJAMARCA','13','SANTA CRUZ','03','CATACHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (682,'06','CAJAMARCA','13','SANTA CRUZ','04','CHANCAYBAÑOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (683,'06','CAJAMARCA','13','SANTA CRUZ','05','LA ESPERANZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (684,'06','CAJAMARCA','13','SANTA CRUZ','06','NINABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (685,'06','CAJAMARCA','13','SANTA CRUZ','07','PULAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (686,'06','CAJAMARCA','13','SANTA CRUZ','08','SAUCEPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (687,'06','CAJAMARCA','13','SANTA CRUZ','09','SEXI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (688,'06','CAJAMARCA','13','SANTA CRUZ','10','UTICYACU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (689,'06','CAJAMARCA','13','SANTA CRUZ','11','YAUYUCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (690,'07','CALLAO','01','CALLAO','01','CALLAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (691,'07','CALLAO','01','CALLAO','02','BELLAVISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (692,'07','CALLAO','01','CALLAO','03','CARMEN DE LA LEGUA REYNOSO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (693,'07','CALLAO','01','CALLAO','04','LA PERLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (694,'07','CALLAO','01','CALLAO','05','LA PUNTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (695,'07','CALLAO','01','CALLAO','06','VENTANILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (696,'07','CALLAO','01','CALLAO','07','MI PERU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (697,'08','CUSCO','01','CUSCO','01','CUSCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (698,'08','CUSCO','01','CUSCO','02','CCORCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (699,'08','CUSCO','01','CUSCO','03','POROY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (700,'08','CUSCO','01','CUSCO','04','SAN JERONIMO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (701,'08','CUSCO','01','CUSCO','05','SAN SEBASTIAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (702,'08','CUSCO','01','CUSCO','06','SANTIAGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (703,'08','CUSCO','01','CUSCO','07','SAYLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (704,'08','CUSCO','01','CUSCO','08','WANCHAQ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (705,'08','CUSCO','02','ACOMAYO','01','ACOMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (706,'08','CUSCO','02','ACOMAYO','02','ACOPIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (707,'08','CUSCO','02','ACOMAYO','03','ACOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (708,'08','CUSCO','02','ACOMAYO','04','MOSOC LLACTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (709,'08','CUSCO','02','ACOMAYO','05','POMACANCHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (710,'08','CUSCO','02','ACOMAYO','06','RONDOCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (711,'08','CUSCO','02','ACOMAYO','07','SANGARARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (712,'08','CUSCO','03','ANTA','01','ANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (713,'08','CUSCO','03','ANTA','02','ANCAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (714,'08','CUSCO','03','ANTA','03','CACHIMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (715,'08','CUSCO','03','ANTA','04','CHINCHAYPUJIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (716,'08','CUSCO','03','ANTA','05','HUAROCONDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (717,'08','CUSCO','03','ANTA','06','LIMATAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (718,'08','CUSCO','03','ANTA','07','MOLLEPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (719,'08','CUSCO','03','ANTA','08','PUCYURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (720,'08','CUSCO','03','ANTA','09','ZURITE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (721,'08','CUSCO','04','CALCA','01','CALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (722,'08','CUSCO','04','CALCA','02','COYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (723,'08','CUSCO','04','CALCA','03','LAMAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (724,'08','CUSCO','04','CALCA','04','LARES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (725,'08','CUSCO','04','CALCA','05','PISAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (726,'08','CUSCO','04','CALCA','06','SAN SALVADOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (727,'08','CUSCO','04','CALCA','07','TARAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (728,'08','CUSCO','04','CALCA','08','YANATILE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (729,'08','CUSCO','05','CANAS','01','YANAOCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (730,'08','CUSCO','05','CANAS','02','CHECCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (731,'08','CUSCO','05','CANAS','03','KUNTURKANKI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (732,'08','CUSCO','05','CANAS','04','LANGUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (733,'08','CUSCO','05','CANAS','05','LAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (734,'08','CUSCO','05','CANAS','06','PAMPAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (735,'08','CUSCO','05','CANAS','07','QUEHUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (736,'08','CUSCO','05','CANAS','08','TUPAC AMARU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (737,'08','CUSCO','06','CANCHIS','01','SICUANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (738,'08','CUSCO','06','CANCHIS','02','CHECACUPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (739,'08','CUSCO','06','CANCHIS','03','COMBAPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (740,'08','CUSCO','06','CANCHIS','04','MARANGANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (741,'08','CUSCO','06','CANCHIS','05','PITUMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (742,'08','CUSCO','06','CANCHIS','06','SAN PABLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (743,'08','CUSCO','06','CANCHIS','07','SAN PEDRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (744,'08','CUSCO','06','CANCHIS','08','TINTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (745,'08','CUSCO','07','CHUMBIVILCAS','01','SANTO TOMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (746,'08','CUSCO','07','CHUMBIVILCAS','02','CAPACMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (747,'08','CUSCO','07','CHUMBIVILCAS','03','CHAMACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (748,'08','CUSCO','07','CHUMBIVILCAS','04','COLQUEMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (749,'08','CUSCO','07','CHUMBIVILCAS','05','LIVITACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (750,'08','CUSCO','07','CHUMBIVILCAS','06','LLUSCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (751,'08','CUSCO','07','CHUMBIVILCAS','07','QUIÑOTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (752,'08','CUSCO','07','CHUMBIVILCAS','08','VELILLE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (753,'08','CUSCO','08','ESPINAR','01','ESPINAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (754,'08','CUSCO','08','ESPINAR','02','CONDOROMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (755,'08','CUSCO','08','ESPINAR','03','COPORAQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (756,'08','CUSCO','08','ESPINAR','04','OCORURO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (757,'08','CUSCO','08','ESPINAR','05','PALLPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (758,'08','CUSCO','08','ESPINAR','06','PICHIGUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (759,'08','CUSCO','08','ESPINAR','07','SUYCKUTAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (760,'08','CUSCO','08','ESPINAR','08','ALTO PICHIGUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (761,'08','CUSCO','09','LA CONVENCION','01','SANTA ANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (762,'08','CUSCO','09','LA CONVENCION','02','ECHARATE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (763,'08','CUSCO','09','LA CONVENCION','03','HUAYOPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (764,'08','CUSCO','09','LA CONVENCION','04','MARANURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (765,'08','CUSCO','09','LA CONVENCION','05','OCOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (766,'08','CUSCO','09','LA CONVENCION','06','QUELLOUNO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (767,'08','CUSCO','09','LA CONVENCION','07','KIMBIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (768,'08','CUSCO','09','LA CONVENCION','08','SANTA TERESA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (769,'08','CUSCO','09','LA CONVENCION','09','VILCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (770,'08','CUSCO','09','LA CONVENCION','10','PICHARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (771,'08','CUSCO','09','LA CONVENCION','11','INKAWASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (772,'08','CUSCO','09','LA CONVENCION','12','VILLA VIRGEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (773,'08','CUSCO','09','LA CONVENCION','13','VILLA KINTIARINA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (774,'08','CUSCO','09','LA CONVENCION','14','MEGANTONI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (775,'08','CUSCO','10','PARURO','01','PARURO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (776,'08','CUSCO','10','PARURO','02','ACCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (777,'08','CUSCO','10','PARURO','03','CCAPI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (778,'08','CUSCO','10','PARURO','04','COLCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (779,'08','CUSCO','10','PARURO','05','HUANOQUITE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (780,'08','CUSCO','10','PARURO','06','OMACHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (781,'08','CUSCO','10','PARURO','07','PACCARITAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (782,'08','CUSCO','10','PARURO','08','PILLPINTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (783,'08','CUSCO','10','PARURO','09','YAURISQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (784,'08','CUSCO','11','PAUCARTAMBO','01','PAUCARTAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (785,'08','CUSCO','11','PAUCARTAMBO','02','CAICAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (786,'08','CUSCO','11','PAUCARTAMBO','03','CHALLABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (787,'08','CUSCO','11','PAUCARTAMBO','04','COLQUEPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (788,'08','CUSCO','11','PAUCARTAMBO','05','HUANCARANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (789,'08','CUSCO','11','PAUCARTAMBO','06','KOSÑIPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (790,'08','CUSCO','12','QUISPICANCHI','01','URCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (791,'08','CUSCO','12','QUISPICANCHI','02','ANDAHUAYLILLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (792,'08','CUSCO','12','QUISPICANCHI','03','CAMANTI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (793,'08','CUSCO','12','QUISPICANCHI','04','CCARHUAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (794,'08','CUSCO','12','QUISPICANCHI','05','CCATCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (795,'08','CUSCO','12','QUISPICANCHI','06','CUSIPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (796,'08','CUSCO','12','QUISPICANCHI','07','HUARO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (797,'08','CUSCO','12','QUISPICANCHI','08','LUCRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (798,'08','CUSCO','12','QUISPICANCHI','09','MARCAPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (799,'08','CUSCO','12','QUISPICANCHI','10','OCONGATE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (800,'08','CUSCO','12','QUISPICANCHI','11','OROPESA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (801,'08','CUSCO','12','QUISPICANCHI','12','QUIQUIJANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (802,'08','CUSCO','13','URUBAMBA','01','URUBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (803,'08','CUSCO','13','URUBAMBA','02','CHINCHERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (804,'08','CUSCO','13','URUBAMBA','03','HUAYLLABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (805,'08','CUSCO','13','URUBAMBA','04','MACHUPICCHU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (806,'08','CUSCO','13','URUBAMBA','05','MARAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (807,'08','CUSCO','13','URUBAMBA','06','OLLANTAYTAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (808,'08','CUSCO','13','URUBAMBA','07','YUCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (809,'09','HUANCAVELICA','01','HUANCAVELICA','01','HUANCAVELICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (810,'09','HUANCAVELICA','01','HUANCAVELICA','02','ACOBAMBILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (811,'09','HUANCAVELICA','01','HUANCAVELICA','03','ACORIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (812,'09','HUANCAVELICA','01','HUANCAVELICA','04','CONAYCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (813,'09','HUANCAVELICA','01','HUANCAVELICA','05','CUENCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (814,'09','HUANCAVELICA','01','HUANCAVELICA','06','HUACHOCOLPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (815,'09','HUANCAVELICA','01','HUANCAVELICA','07','HUAYLLAHUARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (816,'09','HUANCAVELICA','01','HUANCAVELICA','08','IZCUCHACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (817,'09','HUANCAVELICA','01','HUANCAVELICA','09','LARIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (818,'09','HUANCAVELICA','01','HUANCAVELICA','10','MANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (819,'09','HUANCAVELICA','01','HUANCAVELICA','11','MARISCAL CACERES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (820,'09','HUANCAVELICA','01','HUANCAVELICA','12','MOYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (821,'09','HUANCAVELICA','01','HUANCAVELICA','13','NUEVO OCCORO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (822,'09','HUANCAVELICA','01','HUANCAVELICA','14','PALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (823,'09','HUANCAVELICA','01','HUANCAVELICA','15','PILCHACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (824,'09','HUANCAVELICA','01','HUANCAVELICA','16','VILCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (825,'09','HUANCAVELICA','01','HUANCAVELICA','17','YAULI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (826,'09','HUANCAVELICA','01','HUANCAVELICA','18','ASCENSION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (827,'09','HUANCAVELICA','01','HUANCAVELICA','19','HUANDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (828,'09','HUANCAVELICA','02','ACOBAMBA','01','ACOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (829,'09','HUANCAVELICA','02','ACOBAMBA','02','ANDABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (830,'09','HUANCAVELICA','02','ACOBAMBA','03','ANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (831,'09','HUANCAVELICA','02','ACOBAMBA','04','CAJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (832,'09','HUANCAVELICA','02','ACOBAMBA','05','MARCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (833,'09','HUANCAVELICA','02','ACOBAMBA','06','PAUCARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (834,'09','HUANCAVELICA','02','ACOBAMBA','07','POMACOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (835,'09','HUANCAVELICA','02','ACOBAMBA','08','ROSARIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (836,'09','HUANCAVELICA','03','ANGARAES','01','LIRCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (837,'09','HUANCAVELICA','03','ANGARAES','02','ANCHONGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (838,'09','HUANCAVELICA','03','ANGARAES','03','CALLANMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (839,'09','HUANCAVELICA','03','ANGARAES','04','CCOCHACCASA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (840,'09','HUANCAVELICA','03','ANGARAES','05','CHINCHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (841,'09','HUANCAVELICA','03','ANGARAES','06','CONGALLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (842,'09','HUANCAVELICA','03','ANGARAES','07','HUANCA-HUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (843,'09','HUANCAVELICA','03','ANGARAES','08','HUAYLLAY GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (844,'09','HUANCAVELICA','03','ANGARAES','09','JULCAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (845,'09','HUANCAVELICA','03','ANGARAES','10','SAN ANTONIO DE ANTAPARCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (846,'09','HUANCAVELICA','03','ANGARAES','11','SANTO TOMAS DE PATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (847,'09','HUANCAVELICA','03','ANGARAES','12','SECCLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (848,'09','HUANCAVELICA','04','CASTROVIRREYNA','01','CASTROVIRREYNA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (849,'09','HUANCAVELICA','04','CASTROVIRREYNA','02','ARMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (850,'09','HUANCAVELICA','04','CASTROVIRREYNA','03','AURAHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (851,'09','HUANCAVELICA','04','CASTROVIRREYNA','04','CAPILLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (852,'09','HUANCAVELICA','04','CASTROVIRREYNA','05','CHUPAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (853,'09','HUANCAVELICA','04','CASTROVIRREYNA','06','COCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (854,'09','HUANCAVELICA','04','CASTROVIRREYNA','07','HUACHOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (855,'09','HUANCAVELICA','04','CASTROVIRREYNA','08','HUAMATAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (856,'09','HUANCAVELICA','04','CASTROVIRREYNA','09','MOLLEPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (857,'09','HUANCAVELICA','04','CASTROVIRREYNA','10','SAN JUAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (858,'09','HUANCAVELICA','04','CASTROVIRREYNA','11','SANTA ANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (859,'09','HUANCAVELICA','04','CASTROVIRREYNA','12','TANTARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (860,'09','HUANCAVELICA','04','CASTROVIRREYNA','13','TICRAPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (861,'09','HUANCAVELICA','05','CHURCAMPA','01','CHURCAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (862,'09','HUANCAVELICA','05','CHURCAMPA','02','ANCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (863,'09','HUANCAVELICA','05','CHURCAMPA','03','CHINCHIHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (864,'09','HUANCAVELICA','05','CHURCAMPA','04','EL CARMEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (865,'09','HUANCAVELICA','05','CHURCAMPA','05','LA MERCED')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (866,'09','HUANCAVELICA','05','CHURCAMPA','06','LOCROJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (867,'09','HUANCAVELICA','05','CHURCAMPA','07','PAUCARBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (868,'09','HUANCAVELICA','05','CHURCAMPA','08','SAN MIGUEL DE MAYOCC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (869,'09','HUANCAVELICA','05','CHURCAMPA','09','SAN PEDRO DE CORIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (870,'09','HUANCAVELICA','05','CHURCAMPA','10','PACHAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (871,'09','HUANCAVELICA','05','CHURCAMPA','11','COSME')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (872,'09','HUANCAVELICA','06','HUAYTARA','01','HUAYTARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (873,'09','HUANCAVELICA','06','HUAYTARA','02','AYAVI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (874,'09','HUANCAVELICA','06','HUAYTARA','03','CORDOVA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (875,'09','HUANCAVELICA','06','HUAYTARA','04','HUAYACUNDO ARMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (876,'09','HUANCAVELICA','06','HUAYTARA','05','LARAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (877,'09','HUANCAVELICA','06','HUAYTARA','06','OCOYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (878,'09','HUANCAVELICA','06','HUAYTARA','07','PILPICHACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (879,'09','HUANCAVELICA','06','HUAYTARA','08','QUERCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (880,'09','HUANCAVELICA','06','HUAYTARA','09','QUITO-ARMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (881,'09','HUANCAVELICA','06','HUAYTARA','10','SAN ANTONIO DE CUSICANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (882,'09','HUANCAVELICA','06','HUAYTARA','11','SAN FRANCISCO DE SANGAYAICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (883,'09','HUANCAVELICA','06','HUAYTARA','12','SAN ISIDRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (884,'09','HUANCAVELICA','06','HUAYTARA','13','SANTIAGO DE CHOCORVOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (885,'09','HUANCAVELICA','06','HUAYTARA','14','SANTIAGO DE QUIRAHUARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (886,'09','HUANCAVELICA','06','HUAYTARA','15','SANTO DOMINGO DE CAPILLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (887,'09','HUANCAVELICA','06','HUAYTARA','16','TAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (888,'09','HUANCAVELICA','07','TAYACAJA','01','PAMPAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (889,'09','HUANCAVELICA','07','TAYACAJA','02','ACOSTAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (890,'09','HUANCAVELICA','07','TAYACAJA','03','ACRAQUIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (891,'09','HUANCAVELICA','07','TAYACAJA','04','AHUAYCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (892,'09','HUANCAVELICA','07','TAYACAJA','05','COLCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (893,'09','HUANCAVELICA','07','TAYACAJA','06','DANIEL HERNANDEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (894,'09','HUANCAVELICA','07','TAYACAJA','07','HUACHOCOLPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (895,'09','HUANCAVELICA','07','TAYACAJA','09','HUARIBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (896,'09','HUANCAVELICA','07','TAYACAJA','10','ÑAHUIMPUQUIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (897,'09','HUANCAVELICA','07','TAYACAJA','11','PAZOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (898,'09','HUANCAVELICA','07','TAYACAJA','13','QUISHUAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (899,'09','HUANCAVELICA','07','TAYACAJA','14','SALCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (900,'09','HUANCAVELICA','07','TAYACAJA','15','SALCAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (901,'09','HUANCAVELICA','07','TAYACAJA','16','SAN MARCOS DE ROCCHAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (902,'09','HUANCAVELICA','07','TAYACAJA','17','SURCUBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (903,'09','HUANCAVELICA','07','TAYACAJA','18','TINTAY PUNCU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (904,'09','HUANCAVELICA','07','TAYACAJA','19','QUICHUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (905,'09','HUANCAVELICA','07','TAYACAJA','20','ANDAYMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (906,'09','HUANCAVELICA','07','TAYACAJA','21','ROBLE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (907,'09','HUANCAVELICA','07','TAYACAJA','22','PICHOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (908,'09','HUANCAVELICA','07','TAYACAJA','23','SANTIAGO DE TUCUMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (909,'10','HUANUCO','01','HUANUCO','01','HUANUCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (910,'10','HUANUCO','01','HUANUCO','02','AMARILIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (911,'10','HUANUCO','01','HUANUCO','03','CHINCHAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (912,'10','HUANUCO','01','HUANUCO','04','CHURUBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (913,'10','HUANUCO','01','HUANUCO','05','MARGOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (914,'10','HUANUCO','01','HUANUCO','06','QUISQUI (KICHKI)')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (915,'10','HUANUCO','01','HUANUCO','07','SAN FRANCISCO DE CAYRAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (916,'10','HUANUCO','01','HUANUCO','08','SAN PEDRO DE CHAULAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (917,'10','HUANUCO','01','HUANUCO','09','SANTA MARIA DEL VALLE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (918,'10','HUANUCO','01','HUANUCO','10','YARUMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (919,'10','HUANUCO','01','HUANUCO','11','PILLCO MARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (920,'10','HUANUCO','01','HUANUCO','12','YACUS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (921,'10','HUANUCO','01','HUANUCO','13','SAN PABLO DE PILLAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (922,'10','HUANUCO','02','AMBO','01','AMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (923,'10','HUANUCO','02','AMBO','02','CAYNA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (924,'10','HUANUCO','02','AMBO','03','COLPAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (925,'10','HUANUCO','02','AMBO','04','CONCHAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (926,'10','HUANUCO','02','AMBO','05','HUACAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (927,'10','HUANUCO','02','AMBO','06','SAN FRANCISCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (928,'10','HUANUCO','02','AMBO','07','SAN RAFAEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (929,'10','HUANUCO','02','AMBO','08','TOMAY KICHWA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (930,'10','HUANUCO','03','DOS DE MAYO','01','LA UNION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (931,'10','HUANUCO','03','DOS DE MAYO','07','CHUQUIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (932,'10','HUANUCO','03','DOS DE MAYO','11','MARIAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (933,'10','HUANUCO','03','DOS DE MAYO','13','PACHAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (934,'10','HUANUCO','03','DOS DE MAYO','16','QUIVILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (935,'10','HUANUCO','03','DOS DE MAYO','17','RIPAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (936,'10','HUANUCO','03','DOS DE MAYO','21','SHUNQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (937,'10','HUANUCO','03','DOS DE MAYO','22','SILLAPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (938,'10','HUANUCO','03','DOS DE MAYO','23','YANAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (939,'10','HUANUCO','04','HUACAYBAMBA','01','HUACAYBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (940,'10','HUANUCO','04','HUACAYBAMBA','02','CANCHABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (941,'10','HUANUCO','04','HUACAYBAMBA','03','COCHABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (942,'10','HUANUCO','04','HUACAYBAMBA','04','PINRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (943,'10','HUANUCO','05','HUAMALIES','01','LLATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (944,'10','HUANUCO','05','HUAMALIES','02','ARANCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (945,'10','HUANUCO','05','HUAMALIES','03','CHAVIN DE PARIARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (946,'10','HUANUCO','05','HUAMALIES','04','JACAS GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (947,'10','HUANUCO','05','HUAMALIES','05','JIRCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (948,'10','HUANUCO','05','HUAMALIES','06','MIRAFLORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (949,'10','HUANUCO','05','HUAMALIES','07','MONZON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (950,'10','HUANUCO','05','HUAMALIES','08','PUNCHAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (951,'10','HUANUCO','05','HUAMALIES','09','PUÑOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (952,'10','HUANUCO','05','HUAMALIES','10','SINGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (953,'10','HUANUCO','05','HUAMALIES','11','TANTAMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (954,'10','HUANUCO','06','LEONCIO PRADO','01','RUPA-RUPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (955,'10','HUANUCO','06','LEONCIO PRADO','02','DANIEL ALOMIA ROBLES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (956,'10','HUANUCO','06','LEONCIO PRADO','03','HERMILIO VALDIZAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (957,'10','HUANUCO','06','LEONCIO PRADO','04','JOSE CRESPO Y CASTILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (958,'10','HUANUCO','06','LEONCIO PRADO','05','LUYANDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (959,'10','HUANUCO','06','LEONCIO PRADO','06','MARIANO DAMASO BERAUN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (960,'10','HUANUCO','06','LEONCIO PRADO','07','PUCAYACU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (961,'10','HUANUCO','06','LEONCIO PRADO','08','CASTILLO GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (962,'10','HUANUCO','06','LEONCIO PRADO','09','PUEBLO NUEVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (963,'10','HUANUCO','06','LEONCIO PRADO','10','SANTO DOMINGO DE ANDA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (964,'10','HUANUCO','07','MARAÑON','01','HUACRACHUCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (965,'10','HUANUCO','07','MARAÑON','02','CHOLON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (966,'10','HUANUCO','07','MARAÑON','03','SAN BUENAVENTURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (967,'10','HUANUCO','07','MARAÑON','04','LA MORADA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (968,'10','HUANUCO','07','MARAÑON','05','SANTA ROSA DE ALTO YANAJANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (969,'10','HUANUCO','08','PACHITEA','01','PANAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (970,'10','HUANUCO','08','PACHITEA','02','CHAGLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (971,'10','HUANUCO','08','PACHITEA','03','MOLINO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (972,'10','HUANUCO','08','PACHITEA','04','UMARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (973,'10','HUANUCO','09','PUERTO INCA','01','PUERTO INCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (974,'10','HUANUCO','09','PUERTO INCA','02','CODO DEL POZUZO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (975,'10','HUANUCO','09','PUERTO INCA','03','HONORIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (976,'10','HUANUCO','09','PUERTO INCA','04','TOURNAVISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (977,'10','HUANUCO','09','PUERTO INCA','05','YUYAPICHIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (978,'10','HUANUCO','10','LAURICOCHA','01','JESUS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (979,'10','HUANUCO','10','LAURICOCHA','02','BAÑOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (980,'10','HUANUCO','10','LAURICOCHA','03','JIVIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (981,'10','HUANUCO','10','LAURICOCHA','04','QUEROPALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (982,'10','HUANUCO','10','LAURICOCHA','05','RONDOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (983,'10','HUANUCO','10','LAURICOCHA','06','SAN FRANCISCO DE ASIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (984,'10','HUANUCO','10','LAURICOCHA','07','SAN MIGUEL DE CAURI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (985,'10','HUANUCO','11','YAROWILCA','01','CHAVINILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (986,'10','HUANUCO','11','YAROWILCA','02','CAHUAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (987,'10','HUANUCO','11','YAROWILCA','03','CHACABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (988,'10','HUANUCO','11','YAROWILCA','04','APARICIO POMARES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (989,'10','HUANUCO','11','YAROWILCA','05','JACAS CHICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (990,'10','HUANUCO','11','YAROWILCA','06','OBAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (991,'10','HUANUCO','11','YAROWILCA','07','PAMPAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (992,'10','HUANUCO','11','YAROWILCA','08','CHORAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (993,'11','ICA','01','ICA','01','ICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (994,'11','ICA','01','ICA','02','LA TINGUIÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (995,'11','ICA','01','ICA','03','LOS AQUIJES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (996,'11','ICA','01','ICA','04','OCUCAJE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (997,'11','ICA','01','ICA','05','PACHACUTEC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (998,'11','ICA','01','ICA','06','PARCONA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (999,'11','ICA','01','ICA','07','PUEBLO NUEVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1000,'11','ICA','01','ICA','08','SALAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1001,'11','ICA','01','ICA','09','SAN JOSE DE LOS MOLINOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1002,'11','ICA','01','ICA','10','SAN JUAN BAUTISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1003,'11','ICA','01','ICA','11','SANTIAGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1004,'11','ICA','01','ICA','12','SUBTANJALLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1005,'11','ICA','01','ICA','13','TATE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1006,'11','ICA','01','ICA','14','YAUCA DEL ROSARIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1007,'11','ICA','02','CHINCHA','01','CHINCHA ALTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1008,'11','ICA','02','CHINCHA','02','ALTO LARAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1009,'11','ICA','02','CHINCHA','03','CHAVIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1010,'11','ICA','02','CHINCHA','04','CHINCHA BAJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1011,'11','ICA','02','CHINCHA','05','EL CARMEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1012,'11','ICA','02','CHINCHA','06','GROCIO PRADO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1013,'11','ICA','02','CHINCHA','07','PUEBLO NUEVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1014,'11','ICA','02','CHINCHA','08','SAN JUAN DE YANAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1015,'11','ICA','02','CHINCHA','09','SAN PEDRO DE HUACARPANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1016,'11','ICA','02','CHINCHA','10','SUNAMPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1017,'11','ICA','02','CHINCHA','11','TAMBO DE MORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1018,'11','ICA','03','NASCA','01','NASCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1019,'11','ICA','03','NASCA','02','CHANGUILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1020,'11','ICA','03','NASCA','03','EL INGENIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1021,'11','ICA','03','NASCA','04','MARCONA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1022,'11','ICA','03','NASCA','05','VISTA ALEGRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1023,'11','ICA','04','PALPA','01','PALPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1024,'11','ICA','04','PALPA','02','LLIPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1025,'11','ICA','04','PALPA','03','RIO GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1026,'11','ICA','04','PALPA','04','SANTA CRUZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1027,'11','ICA','04','PALPA','05','TIBILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1028,'11','ICA','05','PISCO','01','PISCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1029,'11','ICA','05','PISCO','02','HUANCANO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1030,'11','ICA','05','PISCO','03','HUMAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1031,'11','ICA','05','PISCO','04','INDEPENDENCIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1032,'11','ICA','05','PISCO','05','PARACAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1033,'11','ICA','05','PISCO','06','SAN ANDRES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1034,'11','ICA','05','PISCO','07','SAN CLEMENTE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1035,'11','ICA','05','PISCO','08','TUPAC AMARU INCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1036,'12','JUNIN','01','HUANCAYO','01','HUANCAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1037,'12','JUNIN','01','HUANCAYO','04','CARHUACALLANGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1038,'12','JUNIN','01','HUANCAYO','05','CHACAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1039,'12','JUNIN','01','HUANCAYO','06','CHICCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1040,'12','JUNIN','01','HUANCAYO','07','CHILCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1041,'12','JUNIN','01','HUANCAYO','08','CHONGOS ALTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1042,'12','JUNIN','01','HUANCAYO','11','CHUPURO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1043,'12','JUNIN','01','HUANCAYO','12','COLCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1044,'12','JUNIN','01','HUANCAYO','13','CULLHUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1045,'12','JUNIN','01','HUANCAYO','14','EL TAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1046,'12','JUNIN','01','HUANCAYO','16','HUACRAPUQUIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1047,'12','JUNIN','01','HUANCAYO','17','HUALHUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1048,'12','JUNIN','01','HUANCAYO','19','HUANCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1049,'12','JUNIN','01','HUANCAYO','20','HUASICANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1050,'12','JUNIN','01','HUANCAYO','21','HUAYUCACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1051,'12','JUNIN','01','HUANCAYO','22','INGENIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1052,'12','JUNIN','01','HUANCAYO','24','PARIAHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1053,'12','JUNIN','01','HUANCAYO','25','PILCOMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1054,'12','JUNIN','01','HUANCAYO','26','PUCARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1055,'12','JUNIN','01','HUANCAYO','27','QUICHUAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1056,'12','JUNIN','01','HUANCAYO','28','QUILCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1057,'12','JUNIN','01','HUANCAYO','29','SAN AGUSTIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1058,'12','JUNIN','01','HUANCAYO','30','SAN JERONIMO DE TUNAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1059,'12','JUNIN','01','HUANCAYO','32','SAÑO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1060,'12','JUNIN','01','HUANCAYO','33','SAPALLANGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1061,'12','JUNIN','01','HUANCAYO','34','SICAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1062,'12','JUNIN','01','HUANCAYO','35','SANTO DOMINGO DE ACOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1063,'12','JUNIN','01','HUANCAYO','36','VIQUES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1064,'12','JUNIN','02','CONCEPCION','01','CONCEPCION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1065,'12','JUNIN','02','CONCEPCION','02','ACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1066,'12','JUNIN','02','CONCEPCION','03','ANDAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1067,'12','JUNIN','02','CONCEPCION','04','CHAMBARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1068,'12','JUNIN','02','CONCEPCION','05','COCHAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1069,'12','JUNIN','02','CONCEPCION','06','COMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1070,'12','JUNIN','02','CONCEPCION','07','HEROINAS TOLEDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1071,'12','JUNIN','02','CONCEPCION','08','MANZANARES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1072,'12','JUNIN','02','CONCEPCION','09','MARISCAL CASTILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1073,'12','JUNIN','02','CONCEPCION','10','MATAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1074,'12','JUNIN','02','CONCEPCION','11','MITO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1075,'12','JUNIN','02','CONCEPCION','12','NUEVE DE JULIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1076,'12','JUNIN','02','CONCEPCION','13','ORCOTUNA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1077,'12','JUNIN','02','CONCEPCION','14','SAN JOSE DE QUERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1078,'12','JUNIN','02','CONCEPCION','15','SANTA ROSA DE OCOPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1079,'12','JUNIN','03','CHANCHAMAYO','01','CHANCHAMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1080,'12','JUNIN','03','CHANCHAMAYO','02','PERENE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1081,'12','JUNIN','03','CHANCHAMAYO','03','PICHANAQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1082,'12','JUNIN','03','CHANCHAMAYO','04','SAN LUIS DE SHUARO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1083,'12','JUNIN','03','CHANCHAMAYO','05','SAN RAMON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1084,'12','JUNIN','03','CHANCHAMAYO','06','VITOC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1085,'12','JUNIN','04','JAUJA','01','JAUJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1086,'12','JUNIN','04','JAUJA','02','ACOLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1087,'12','JUNIN','04','JAUJA','03','APATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1088,'12','JUNIN','04','JAUJA','04','ATAURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1089,'12','JUNIN','04','JAUJA','05','CANCHAYLLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1090,'12','JUNIN','04','JAUJA','06','CURICACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1091,'12','JUNIN','04','JAUJA','07','EL MANTARO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1092,'12','JUNIN','04','JAUJA','08','HUAMALI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1093,'12','JUNIN','04','JAUJA','09','HUARIPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1094,'12','JUNIN','04','JAUJA','10','HUERTAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1095,'12','JUNIN','04','JAUJA','11','JANJAILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1096,'12','JUNIN','04','JAUJA','12','JULCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1097,'12','JUNIN','04','JAUJA','13','LEONOR ORDOÑEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1098,'12','JUNIN','04','JAUJA','14','LLOCLLAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1099,'12','JUNIN','04','JAUJA','15','MARCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1100,'12','JUNIN','04','JAUJA','16','MASMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1101,'12','JUNIN','04','JAUJA','17','MASMA CHICCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1102,'12','JUNIN','04','JAUJA','18','MOLINOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1103,'12','JUNIN','04','JAUJA','19','MONOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1104,'12','JUNIN','04','JAUJA','20','MUQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1105,'12','JUNIN','04','JAUJA','21','MUQUIYAUYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1106,'12','JUNIN','04','JAUJA','22','PACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1107,'12','JUNIN','04','JAUJA','23','PACCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1108,'12','JUNIN','04','JAUJA','24','PANCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1109,'12','JUNIN','04','JAUJA','25','PARCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1110,'12','JUNIN','04','JAUJA','26','POMACANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1111,'12','JUNIN','04','JAUJA','27','RICRAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1112,'12','JUNIN','04','JAUJA','28','SAN LORENZO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1113,'12','JUNIN','04','JAUJA','29','SAN PEDRO DE CHUNAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1114,'12','JUNIN','04','JAUJA','30','SAUSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1115,'12','JUNIN','04','JAUJA','31','SINCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1116,'12','JUNIN','04','JAUJA','32','TUNAN MARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1117,'12','JUNIN','04','JAUJA','33','YAULI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1118,'12','JUNIN','04','JAUJA','34','YAUYOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1119,'12','JUNIN','05','JUNIN','01','JUNIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1120,'12','JUNIN','05','JUNIN','02','CARHUAMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1121,'12','JUNIN','05','JUNIN','03','ONDORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1122,'12','JUNIN','05','JUNIN','04','ULCUMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1123,'12','JUNIN','06','SATIPO','01','SATIPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1124,'12','JUNIN','06','SATIPO','02','COVIRIALI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1125,'12','JUNIN','06','SATIPO','03','LLAYLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1126,'12','JUNIN','06','SATIPO','04','MAZAMARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1127,'12','JUNIN','06','SATIPO','05','PAMPA HERMOSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1128,'12','JUNIN','06','SATIPO','06','PANGOA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1129,'12','JUNIN','06','SATIPO','07','RIO NEGRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1130,'12','JUNIN','06','SATIPO','08','RIO TAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1131,'12','JUNIN','06','SATIPO','09','VIZCATAN DEL ENE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1132,'12','JUNIN','07','TARMA','01','TARMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1133,'12','JUNIN','07','TARMA','02','ACOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1134,'12','JUNIN','07','TARMA','03','HUARICOLCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1135,'12','JUNIN','07','TARMA','04','HUASAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1136,'12','JUNIN','07','TARMA','05','LA UNION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1137,'12','JUNIN','07','TARMA','06','PALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1138,'12','JUNIN','07','TARMA','07','PALCAMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1139,'12','JUNIN','07','TARMA','08','SAN PEDRO DE CAJAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1140,'12','JUNIN','07','TARMA','09','TAPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1141,'12','JUNIN','08','YAULI','01','LA OROYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1142,'12','JUNIN','08','YAULI','02','CHACAPALPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1143,'12','JUNIN','08','YAULI','03','HUAY-HUAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1144,'12','JUNIN','08','YAULI','04','MARCAPOMACOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1145,'12','JUNIN','08','YAULI','05','MOROCOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1146,'12','JUNIN','08','YAULI','06','PACCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1147,'12','JUNIN','08','YAULI','07','SANTA BARBARA DE CARHUACAYAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1148,'12','JUNIN','08','YAULI','08','SANTA ROSA DE SACCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1149,'12','JUNIN','08','YAULI','09','SUITUCANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1150,'12','JUNIN','08','YAULI','10','YAULI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1151,'12','JUNIN','09','CHUPACA','01','CHUPACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1152,'12','JUNIN','09','CHUPACA','02','AHUAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1153,'12','JUNIN','09','CHUPACA','03','CHONGOS BAJO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1154,'12','JUNIN','09','CHUPACA','04','HUACHAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1155,'12','JUNIN','09','CHUPACA','05','HUAMANCACA CHICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1156,'12','JUNIN','09','CHUPACA','06','SAN JUAN DE ISCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1157,'12','JUNIN','09','CHUPACA','07','SAN JUAN DE JARPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1158,'12','JUNIN','09','CHUPACA','08','TRES DE DICIEMBRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1159,'12','JUNIN','09','CHUPACA','09','YANACANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1160,'13','LA LIBERTAD','01','TRUJILLO','01','TRUJILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1161,'13','LA LIBERTAD','01','TRUJILLO','02','EL PORVENIR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1162,'13','LA LIBERTAD','01','TRUJILLO','03','FLORENCIA DE MORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1163,'13','LA LIBERTAD','01','TRUJILLO','04','HUANCHACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1164,'13','LA LIBERTAD','01','TRUJILLO','05','LA ESPERANZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1165,'13','LA LIBERTAD','01','TRUJILLO','06','LAREDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1166,'13','LA LIBERTAD','01','TRUJILLO','07','MOCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1167,'13','LA LIBERTAD','01','TRUJILLO','08','POROTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1168,'13','LA LIBERTAD','01','TRUJILLO','09','SALAVERRY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1169,'13','LA LIBERTAD','01','TRUJILLO','10','SIMBAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1170,'13','LA LIBERTAD','01','TRUJILLO','11','VICTOR LARCO HERRERA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1171,'13','LA LIBERTAD','02','ASCOPE','01','ASCOPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1172,'13','LA LIBERTAD','02','ASCOPE','02','CHICAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1173,'13','LA LIBERTAD','02','ASCOPE','03','CHOCOPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1174,'13','LA LIBERTAD','02','ASCOPE','04','MAGDALENA DE CAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1175,'13','LA LIBERTAD','02','ASCOPE','05','PAIJAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1176,'13','LA LIBERTAD','02','ASCOPE','06','RAZURI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1177,'13','LA LIBERTAD','02','ASCOPE','07','SANTIAGO DE CAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1178,'13','LA LIBERTAD','02','ASCOPE','08','CASA GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1179,'13','LA LIBERTAD','03','BOLIVAR','01','BOLIVAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1180,'13','LA LIBERTAD','03','BOLIVAR','02','BAMBAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1181,'13','LA LIBERTAD','03','BOLIVAR','03','CONDORMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1182,'13','LA LIBERTAD','03','BOLIVAR','04','LONGOTEA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1183,'13','LA LIBERTAD','03','BOLIVAR','05','UCHUMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1184,'13','LA LIBERTAD','03','BOLIVAR','06','UCUNCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1185,'13','LA LIBERTAD','04','CHEPEN','01','CHEPEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1186,'13','LA LIBERTAD','04','CHEPEN','02','PACANGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1187,'13','LA LIBERTAD','04','CHEPEN','03','PUEBLO NUEVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1188,'13','LA LIBERTAD','05','JULCAN','01','JULCAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1189,'13','LA LIBERTAD','05','JULCAN','02','CALAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1190,'13','LA LIBERTAD','05','JULCAN','03','CARABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1191,'13','LA LIBERTAD','05','JULCAN','04','HUASO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1192,'13','LA LIBERTAD','06','OTUZCO','01','OTUZCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1193,'13','LA LIBERTAD','06','OTUZCO','02','AGALLPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1194,'13','LA LIBERTAD','06','OTUZCO','04','CHARAT')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1195,'13','LA LIBERTAD','06','OTUZCO','05','HUARANCHAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1196,'13','LA LIBERTAD','06','OTUZCO','06','LA CUESTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1197,'13','LA LIBERTAD','06','OTUZCO','08','MACHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1198,'13','LA LIBERTAD','06','OTUZCO','10','PARANDAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1199,'13','LA LIBERTAD','06','OTUZCO','11','SALPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1200,'13','LA LIBERTAD','06','OTUZCO','13','SINSICAP')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1201,'13','LA LIBERTAD','06','OTUZCO','14','USQUIL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1202,'13','LA LIBERTAD','07','PACASMAYO','01','SAN PEDRO DE LLOC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1203,'13','LA LIBERTAD','07','PACASMAYO','02','GUADALUPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1204,'13','LA LIBERTAD','07','PACASMAYO','03','JEQUETEPEQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1205,'13','LA LIBERTAD','07','PACASMAYO','04','PACASMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1206,'13','LA LIBERTAD','07','PACASMAYO','05','SAN JOSE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1207,'13','LA LIBERTAD','08','PATAZ','01','TAYABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1208,'13','LA LIBERTAD','08','PATAZ','02','BULDIBUYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1209,'13','LA LIBERTAD','08','PATAZ','03','CHILLIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1210,'13','LA LIBERTAD','08','PATAZ','04','HUANCASPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1211,'13','LA LIBERTAD','08','PATAZ','05','HUAYLILLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1212,'13','LA LIBERTAD','08','PATAZ','06','HUAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1213,'13','LA LIBERTAD','08','PATAZ','07','ONGON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1214,'13','LA LIBERTAD','08','PATAZ','08','PARCOY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1215,'13','LA LIBERTAD','08','PATAZ','09','PATAZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1216,'13','LA LIBERTAD','08','PATAZ','10','PIAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1217,'13','LA LIBERTAD','08','PATAZ','11','SANTIAGO DE CHALLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1218,'13','LA LIBERTAD','08','PATAZ','12','TAURIJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1219,'13','LA LIBERTAD','08','PATAZ','13','URPAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1220,'13','LA LIBERTAD','09','SANCHEZ CARRION','01','HUAMACHUCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1221,'13','LA LIBERTAD','09','SANCHEZ CARRION','02','CHUGAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1222,'13','LA LIBERTAD','09','SANCHEZ CARRION','03','COCHORCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1223,'13','LA LIBERTAD','09','SANCHEZ CARRION','04','CURGOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1224,'13','LA LIBERTAD','09','SANCHEZ CARRION','05','MARCABAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1225,'13','LA LIBERTAD','09','SANCHEZ CARRION','06','SANAGORAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1226,'13','LA LIBERTAD','09','SANCHEZ CARRION','07','SARIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1227,'13','LA LIBERTAD','09','SANCHEZ CARRION','08','SARTIMBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1228,'13','LA LIBERTAD','10','SANTIAGO DE CHUCO','01','SANTIAGO DE CHUCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1229,'13','LA LIBERTAD','10','SANTIAGO DE CHUCO','02','ANGASMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1230,'13','LA LIBERTAD','10','SANTIAGO DE CHUCO','03','CACHICADAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1231,'13','LA LIBERTAD','10','SANTIAGO DE CHUCO','04','MOLLEBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1232,'13','LA LIBERTAD','10','SANTIAGO DE CHUCO','05','MOLLEPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1233,'13','LA LIBERTAD','10','SANTIAGO DE CHUCO','06','QUIRUVILCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1234,'13','LA LIBERTAD','10','SANTIAGO DE CHUCO','07','SANTA CRUZ DE CHUCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1235,'13','LA LIBERTAD','10','SANTIAGO DE CHUCO','08','SITABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1236,'13','LA LIBERTAD','11','GRAN CHIMU','01','CASCAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1237,'13','LA LIBERTAD','11','GRAN CHIMU','02','LUCMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1238,'13','LA LIBERTAD','11','GRAN CHIMU','03','MARMOT')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1239,'13','LA LIBERTAD','11','GRAN CHIMU','04','SAYAPULLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1240,'13','LA LIBERTAD','12','VIRU','01','VIRU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1241,'13','LA LIBERTAD','12','VIRU','02','CHAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1242,'13','LA LIBERTAD','12','VIRU','03','GUADALUPITO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1243,'14','LAMBAYEQUE','01','CHICLAYO','01','CHICLAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1244,'14','LAMBAYEQUE','01','CHICLAYO','02','CHONGOYAPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1245,'14','LAMBAYEQUE','01','CHICLAYO','03','ETEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1246,'14','LAMBAYEQUE','01','CHICLAYO','04','ETEN PUERTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1247,'14','LAMBAYEQUE','01','CHICLAYO','05','JOSE LEONARDO ORTIZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1248,'14','LAMBAYEQUE','01','CHICLAYO','06','LA VICTORIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1249,'14','LAMBAYEQUE','01','CHICLAYO','07','LAGUNAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1250,'14','LAMBAYEQUE','01','CHICLAYO','08','MONSEFU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1251,'14','LAMBAYEQUE','01','CHICLAYO','09','NUEVA ARICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1252,'14','LAMBAYEQUE','01','CHICLAYO','10','OYOTUN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1253,'14','LAMBAYEQUE','01','CHICLAYO','11','PICSI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1254,'14','LAMBAYEQUE','01','CHICLAYO','12','PIMENTEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1255,'14','LAMBAYEQUE','01','CHICLAYO','13','REQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1256,'14','LAMBAYEQUE','01','CHICLAYO','14','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1257,'14','LAMBAYEQUE','01','CHICLAYO','15','SAÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1258,'14','LAMBAYEQUE','01','CHICLAYO','16','CAYALTI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1259,'14','LAMBAYEQUE','01','CHICLAYO','17','PATAPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1260,'14','LAMBAYEQUE','01','CHICLAYO','18','POMALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1261,'14','LAMBAYEQUE','01','CHICLAYO','19','PUCALA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1262,'14','LAMBAYEQUE','01','CHICLAYO','20','TUMAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1263,'14','LAMBAYEQUE','02','FERREÑAFE','01','FERREÑAFE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1264,'14','LAMBAYEQUE','02','FERREÑAFE','02','CAÑARIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1265,'14','LAMBAYEQUE','02','FERREÑAFE','03','INCAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1266,'14','LAMBAYEQUE','02','FERREÑAFE','04','MANUEL ANTONIO MESONES MURO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1267,'14','LAMBAYEQUE','02','FERREÑAFE','05','PITIPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1268,'14','LAMBAYEQUE','02','FERREÑAFE','06','PUEBLO NUEVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1269,'14','LAMBAYEQUE','03','LAMBAYEQUE','01','LAMBAYEQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1270,'14','LAMBAYEQUE','03','LAMBAYEQUE','02','CHOCHOPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1271,'14','LAMBAYEQUE','03','LAMBAYEQUE','03','ILLIMO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1272,'14','LAMBAYEQUE','03','LAMBAYEQUE','04','JAYANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1273,'14','LAMBAYEQUE','03','LAMBAYEQUE','05','MOCHUMI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1274,'14','LAMBAYEQUE','03','LAMBAYEQUE','06','MORROPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1275,'14','LAMBAYEQUE','03','LAMBAYEQUE','07','MOTUPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1276,'14','LAMBAYEQUE','03','LAMBAYEQUE','08','OLMOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1277,'14','LAMBAYEQUE','03','LAMBAYEQUE','09','PACORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1278,'14','LAMBAYEQUE','03','LAMBAYEQUE','10','SALAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1279,'14','LAMBAYEQUE','03','LAMBAYEQUE','11','SAN JOSE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1280,'14','LAMBAYEQUE','03','LAMBAYEQUE','12','TUCUME')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1281,'15','LIMA','01','LIMA','01','LIMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1282,'15','LIMA','01','LIMA','02','ANCON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1283,'15','LIMA','01','LIMA','03','ATE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1284,'15','LIMA','01','LIMA','04','BARRANCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1285,'15','LIMA','01','LIMA','05','BREÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1286,'15','LIMA','01','LIMA','06','CARABAYLLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1287,'15','LIMA','01','LIMA','07','CHACLACAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1288,'15','LIMA','01','LIMA','08','CHORRILLOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1289,'15','LIMA','01','LIMA','09','CIENEGUILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1290,'15','LIMA','01','LIMA','10','COMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1291,'15','LIMA','01','LIMA','11','EL AGUSTINO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1292,'15','LIMA','01','LIMA','12','INDEPENDENCIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1293,'15','LIMA','01','LIMA','13','JESUS MARIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1294,'15','LIMA','01','LIMA','14','LA MOLINA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1295,'15','LIMA','01','LIMA','15','LA VICTORIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1296,'15','LIMA','01','LIMA','16','LINCE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1297,'15','LIMA','01','LIMA','17','LOS OLIVOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1298,'15','LIMA','01','LIMA','18','LURIGANCHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1299,'15','LIMA','01','LIMA','19','LURIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1300,'15','LIMA','01','LIMA','20','MAGDALENA DEL MAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1301,'15','LIMA','01','LIMA','21','PUEBLO LIBRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1302,'15','LIMA','01','LIMA','22','MIRAFLORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1303,'15','LIMA','01','LIMA','23','PACHACAMAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1304,'15','LIMA','01','LIMA','24','PUCUSANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1305,'15','LIMA','01','LIMA','25','PUENTE PIEDRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1306,'15','LIMA','01','LIMA','26','PUNTA HERMOSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1307,'15','LIMA','01','LIMA','27','PUNTA NEGRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1308,'15','LIMA','01','LIMA','28','RIMAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1309,'15','LIMA','01','LIMA','29','SAN BARTOLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1310,'15','LIMA','01','LIMA','30','SAN BORJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1311,'15','LIMA','01','LIMA','31','SAN ISIDRO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1312,'15','LIMA','01','LIMA','32','SAN JUAN DE LURIGANCHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1313,'15','LIMA','01','LIMA','33','SAN JUAN DE MIRAFLORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1314,'15','LIMA','01','LIMA','34','SAN LUIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1315,'15','LIMA','01','LIMA','35','SAN MARTIN DE PORRES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1316,'15','LIMA','01','LIMA','36','SAN MIGUEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1317,'15','LIMA','01','LIMA','37','SANTA ANITA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1318,'15','LIMA','01','LIMA','38','SANTA MARIA DEL MAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1319,'15','LIMA','01','LIMA','39','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1320,'15','LIMA','01','LIMA','40','SANTIAGO DE SURCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1321,'15','LIMA','01','LIMA','41','SURQUILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1322,'15','LIMA','01','LIMA','42','VILLA EL SALVADOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1323,'15','LIMA','01','LIMA','43','VILLA MARIA DEL TRIUNFO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1324,'15','LIMA','02','BARRANCA','01','BARRANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1325,'15','LIMA','02','BARRANCA','02','PARAMONGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1326,'15','LIMA','02','BARRANCA','03','PATIVILCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1327,'15','LIMA','02','BARRANCA','04','SUPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1328,'15','LIMA','02','BARRANCA','05','SUPE PUERTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1329,'15','LIMA','03','CAJATAMBO','01','CAJATAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1330,'15','LIMA','03','CAJATAMBO','02','COPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1331,'15','LIMA','03','CAJATAMBO','03','GORGOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1332,'15','LIMA','03','CAJATAMBO','04','HUANCAPON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1333,'15','LIMA','03','CAJATAMBO','05','MANAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1334,'15','LIMA','04','CANTA','01','CANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1335,'15','LIMA','04','CANTA','02','ARAHUAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1336,'15','LIMA','04','CANTA','03','HUAMANTANGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1337,'15','LIMA','04','CANTA','04','HUAROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1338,'15','LIMA','04','CANTA','05','LACHAQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1339,'15','LIMA','04','CANTA','06','SAN BUENAVENTURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1340,'15','LIMA','04','CANTA','07','SANTA ROSA DE QUIVES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1341,'15','LIMA','05','CAÑETE','01','SAN VICENTE DE CAÑETE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1342,'15','LIMA','05','CAÑETE','02','ASIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1343,'15','LIMA','05','CAÑETE','03','CALANGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1344,'15','LIMA','05','CAÑETE','04','CERRO AZUL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1345,'15','LIMA','05','CAÑETE','05','CHILCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1346,'15','LIMA','05','CAÑETE','06','COAYLLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1347,'15','LIMA','05','CAÑETE','07','IMPERIAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1348,'15','LIMA','05','CAÑETE','08','LUNAHUANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1349,'15','LIMA','05','CAÑETE','09','MALA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1350,'15','LIMA','05','CAÑETE','10','NUEVO IMPERIAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1351,'15','LIMA','05','CAÑETE','11','PACARAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1352,'15','LIMA','05','CAÑETE','12','QUILMANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1353,'15','LIMA','05','CAÑETE','13','SAN ANTONIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1354,'15','LIMA','05','CAÑETE','14','SAN LUIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1355,'15','LIMA','05','CAÑETE','15','SANTA CRUZ DE FLORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1356,'15','LIMA','05','CAÑETE','16','ZUÑIGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1357,'15','LIMA','06','HUARAL','01','HUARAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1358,'15','LIMA','06','HUARAL','02','ATAVILLOS ALTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1359,'15','LIMA','06','HUARAL','03','ATAVILLOS BAJO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1360,'15','LIMA','06','HUARAL','04','AUCALLAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1361,'15','LIMA','06','HUARAL','05','CHANCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1362,'15','LIMA','06','HUARAL','06','IHUARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1363,'15','LIMA','06','HUARAL','07','LAMPIAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1364,'15','LIMA','06','HUARAL','08','PACARAOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1365,'15','LIMA','06','HUARAL','09','SAN MIGUEL DE ACOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1366,'15','LIMA','06','HUARAL','10','SANTA CRUZ DE ANDAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1367,'15','LIMA','06','HUARAL','11','SUMBILCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1368,'15','LIMA','06','HUARAL','12','VEINTISIETE DE NOVIEMBRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1369,'15','LIMA','07','HUAROCHIRI','01','MATUCANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1370,'15','LIMA','07','HUAROCHIRI','02','ANTIOQUIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1371,'15','LIMA','07','HUAROCHIRI','03','CALLAHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1372,'15','LIMA','07','HUAROCHIRI','04','CARAMPOMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1373,'15','LIMA','07','HUAROCHIRI','05','CHICLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1374,'15','LIMA','07','HUAROCHIRI','06','CUENCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1375,'15','LIMA','07','HUAROCHIRI','07','HUACHUPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1376,'15','LIMA','07','HUAROCHIRI','08','HUANZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1377,'15','LIMA','07','HUAROCHIRI','09','HUAROCHIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1378,'15','LIMA','07','HUAROCHIRI','10','LAHUAYTAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1379,'15','LIMA','07','HUAROCHIRI','11','LANGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1380,'15','LIMA','07','HUAROCHIRI','12','SAN PEDRO DE LARAOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1381,'15','LIMA','07','HUAROCHIRI','13','MARIATANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1382,'15','LIMA','07','HUAROCHIRI','14','RICARDO PALMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1383,'15','LIMA','07','HUAROCHIRI','15','SAN ANDRES DE TUPICOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1384,'15','LIMA','07','HUAROCHIRI','16','SAN ANTONIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1385,'15','LIMA','07','HUAROCHIRI','17','SAN BARTOLOME')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1386,'15','LIMA','07','HUAROCHIRI','18','SAN DAMIAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1387,'15','LIMA','07','HUAROCHIRI','19','SAN JUAN DE IRIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1388,'15','LIMA','07','HUAROCHIRI','20','SAN JUAN DE TANTARANCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1389,'15','LIMA','07','HUAROCHIRI','21','SAN LORENZO DE QUINTI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1390,'15','LIMA','07','HUAROCHIRI','22','SAN MATEO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1391,'15','LIMA','07','HUAROCHIRI','23','SAN MATEO DE OTAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1392,'15','LIMA','07','HUAROCHIRI','24','SAN PEDRO DE CASTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1393,'15','LIMA','07','HUAROCHIRI','25','SAN PEDRO DE HUANCAYRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1394,'15','LIMA','07','HUAROCHIRI','26','SANGALLAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1395,'15','LIMA','07','HUAROCHIRI','27','SANTA CRUZ DE COCACHACRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1396,'15','LIMA','07','HUAROCHIRI','28','SANTA EULALIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1397,'15','LIMA','07','HUAROCHIRI','29','SANTIAGO DE ANCHUCAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1398,'15','LIMA','07','HUAROCHIRI','30','SANTIAGO DE TUNA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1399,'15','LIMA','07','HUAROCHIRI','31','SANTO DOMINGO DE LOS OLLEROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1400,'15','LIMA','07','HUAROCHIRI','32','SURCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1401,'15','LIMA','08','HUAURA','01','HUACHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1402,'15','LIMA','08','HUAURA','02','AMBAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1403,'15','LIMA','08','HUAURA','03','CALETA DE CARQUIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1404,'15','LIMA','08','HUAURA','04','CHECRAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1405,'15','LIMA','08','HUAURA','05','HUALMAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1406,'15','LIMA','08','HUAURA','06','HUAURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1407,'15','LIMA','08','HUAURA','07','LEONCIO PRADO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1408,'15','LIMA','08','HUAURA','08','PACCHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1409,'15','LIMA','08','HUAURA','09','SANTA LEONOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1410,'15','LIMA','08','HUAURA','10','SANTA MARIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1411,'15','LIMA','08','HUAURA','11','SAYAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1412,'15','LIMA','08','HUAURA','12','VEGUETA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1413,'15','LIMA','09','OYON','01','OYON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1414,'15','LIMA','09','OYON','02','ANDAJES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1415,'15','LIMA','09','OYON','03','CAUJUL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1416,'15','LIMA','09','OYON','04','COCHAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1417,'15','LIMA','09','OYON','05','NAVAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1418,'15','LIMA','09','OYON','06','PACHANGARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1419,'15','LIMA','10','YAUYOS','01','YAUYOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1420,'15','LIMA','10','YAUYOS','02','ALIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1421,'15','LIMA','10','YAUYOS','03','ALLAUCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1422,'15','LIMA','10','YAUYOS','04','AYAVIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1423,'15','LIMA','10','YAUYOS','05','AZANGARO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1424,'15','LIMA','10','YAUYOS','06','CACRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1425,'15','LIMA','10','YAUYOS','07','CARANIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1426,'15','LIMA','10','YAUYOS','08','CATAHUASI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1427,'15','LIMA','10','YAUYOS','09','CHOCOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1428,'15','LIMA','10','YAUYOS','10','COCHAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1429,'15','LIMA','10','YAUYOS','11','COLONIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1430,'15','LIMA','10','YAUYOS','12','HONGOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1431,'15','LIMA','10','YAUYOS','13','HUAMPARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1432,'15','LIMA','10','YAUYOS','14','HUANCAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1433,'15','LIMA','10','YAUYOS','15','HUANGASCAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1434,'15','LIMA','10','YAUYOS','16','HUANTAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1435,'15','LIMA','10','YAUYOS','17','HUAÑEC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1436,'15','LIMA','10','YAUYOS','18','LARAOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1437,'15','LIMA','10','YAUYOS','19','LINCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1438,'15','LIMA','10','YAUYOS','20','MADEAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1439,'15','LIMA','10','YAUYOS','21','MIRAFLORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1440,'15','LIMA','10','YAUYOS','22','OMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1441,'15','LIMA','10','YAUYOS','23','PUTINZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1442,'15','LIMA','10','YAUYOS','24','QUINCHES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1443,'15','LIMA','10','YAUYOS','25','QUINOCAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1444,'15','LIMA','10','YAUYOS','26','SAN JOAQUIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1445,'15','LIMA','10','YAUYOS','27','SAN PEDRO DE PILAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1446,'15','LIMA','10','YAUYOS','28','TANTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1447,'15','LIMA','10','YAUYOS','29','TAURIPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1448,'15','LIMA','10','YAUYOS','30','TOMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1449,'15','LIMA','10','YAUYOS','31','TUPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1450,'15','LIMA','10','YAUYOS','32','VIÑAC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1451,'15','LIMA','10','YAUYOS','33','VITIS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1452,'16','LORETO','01','MAYNAS','01','IQUITOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1453,'16','LORETO','01','MAYNAS','02','ALTO NANAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1454,'16','LORETO','01','MAYNAS','03','FERNANDO LORES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1455,'16','LORETO','01','MAYNAS','04','INDIANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1456,'16','LORETO','01','MAYNAS','05','LAS AMAZONAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1457,'16','LORETO','01','MAYNAS','06','MAZAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1458,'16','LORETO','01','MAYNAS','07','NAPO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1459,'16','LORETO','01','MAYNAS','08','PUNCHANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1460,'16','LORETO','01','MAYNAS','10','TORRES CAUSANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1461,'16','LORETO','01','MAYNAS','12','BELEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1462,'16','LORETO','01','MAYNAS','13','SAN JUAN BAUTISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1463,'16','LORETO','02','ALTO AMAZONAS','01','YURIMAGUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1464,'16','LORETO','02','ALTO AMAZONAS','02','BALSAPUERTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1465,'16','LORETO','02','ALTO AMAZONAS','05','JEBEROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1466,'16','LORETO','02','ALTO AMAZONAS','06','LAGUNAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1467,'16','LORETO','02','ALTO AMAZONAS','10','SANTA CRUZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1468,'16','LORETO','02','ALTO AMAZONAS','11','TENIENTE CESAR LOPEZ ROJAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1469,'16','LORETO','03','LORETO','01','NAUTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1470,'16','LORETO','03','LORETO','02','PARINARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1471,'16','LORETO','03','LORETO','03','TIGRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1472,'16','LORETO','03','LORETO','04','TROMPETEROS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1473,'16','LORETO','03','LORETO','05','URARINAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1474,'16','LORETO','04','MARISCAL RAMON CASTILLA','01','RAMON CASTILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1475,'16','LORETO','04','MARISCAL RAMON CASTILLA','02','PEBAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1476,'16','LORETO','04','MARISCAL RAMON CASTILLA','03','YAVARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1477,'16','LORETO','04','MARISCAL RAMON CASTILLA','04','SAN PABLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1478,'16','LORETO','05','REQUENA','01','REQUENA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1479,'16','LORETO','05','REQUENA','02','ALTO TAPICHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1480,'16','LORETO','05','REQUENA','03','CAPELO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1481,'16','LORETO','05','REQUENA','04','EMILIO SAN MARTIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1482,'16','LORETO','05','REQUENA','05','MAQUIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1483,'16','LORETO','05','REQUENA','06','PUINAHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1484,'16','LORETO','05','REQUENA','07','SAQUENA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1485,'16','LORETO','05','REQUENA','08','SOPLIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1486,'16','LORETO','05','REQUENA','09','TAPICHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1487,'16','LORETO','05','REQUENA','10','JENARO HERRERA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1488,'16','LORETO','05','REQUENA','11','YAQUERANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1489,'16','LORETO','06','UCAYALI','01','CONTAMANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1490,'16','LORETO','06','UCAYALI','02','INAHUAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1491,'16','LORETO','06','UCAYALI','03','PADRE MARQUEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1492,'16','LORETO','06','UCAYALI','04','PAMPA HERMOSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1493,'16','LORETO','06','UCAYALI','05','SARAYACU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1494,'16','LORETO','06','UCAYALI','06','VARGAS GUERRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1495,'16','LORETO','07','DATEM DEL MARAÑON','01','BARRANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1496,'16','LORETO','07','DATEM DEL MARAÑON','02','CAHUAPANAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1497,'16','LORETO','07','DATEM DEL MARAÑON','03','MANSERICHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1498,'16','LORETO','07','DATEM DEL MARAÑON','04','MORONA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1499,'16','LORETO','07','DATEM DEL MARAÑON','05','PASTAZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1500,'16','LORETO','07','DATEM DEL MARAÑON','06','ANDOAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1501,'16','LORETO','08','PUTUMAYO','01','PUTUMAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1502,'16','LORETO','08','PUTUMAYO','02','ROSA PANDURO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1503,'16','LORETO','08','PUTUMAYO','03','TENIENTE MANUEL CLAVERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1504,'16','LORETO','08','PUTUMAYO','04','YAGUAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1505,'17','MADRE DE DIOS','01','TAMBOPATA','01','TAMBOPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1506,'17','MADRE DE DIOS','01','TAMBOPATA','02','INAMBARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1507,'17','MADRE DE DIOS','01','TAMBOPATA','03','LAS PIEDRAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1508,'17','MADRE DE DIOS','01','TAMBOPATA','04','LABERINTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1509,'17','MADRE DE DIOS','02','MANU','01','MANU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1510,'17','MADRE DE DIOS','02','MANU','02','FITZCARRALD')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1511,'17','MADRE DE DIOS','02','MANU','03','MADRE DE DIOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1512,'17','MADRE DE DIOS','02','MANU','04','HUEPETUHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1513,'17','MADRE DE DIOS','03','TAHUAMANU','01','IÑAPARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1514,'17','MADRE DE DIOS','03','TAHUAMANU','02','IBERIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1515,'17','MADRE DE DIOS','03','TAHUAMANU','03','TAHUAMANU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1516,'18','MOQUEGUA','01','MARISCAL NIETO','01','MOQUEGUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1517,'18','MOQUEGUA','01','MARISCAL NIETO','02','CARUMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1518,'18','MOQUEGUA','01','MARISCAL NIETO','03','CUCHUMBAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1519,'18','MOQUEGUA','01','MARISCAL NIETO','04','SAMEGUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1520,'18','MOQUEGUA','01','MARISCAL NIETO','05','SAN CRISTOBAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1521,'18','MOQUEGUA','01','MARISCAL NIETO','06','TORATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1522,'18','MOQUEGUA','02','GENERAL SANCHEZ CERRO','01','OMATE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1523,'18','MOQUEGUA','02','GENERAL SANCHEZ CERRO','02','CHOJATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1524,'18','MOQUEGUA','02','GENERAL SANCHEZ CERRO','03','COALAQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1525,'18','MOQUEGUA','02','GENERAL SANCHEZ CERRO','04','ICHUÑA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1526,'18','MOQUEGUA','02','GENERAL SANCHEZ CERRO','05','LA CAPILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1527,'18','MOQUEGUA','02','GENERAL SANCHEZ CERRO','06','LLOQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1528,'18','MOQUEGUA','02','GENERAL SANCHEZ CERRO','07','MATALAQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1529,'18','MOQUEGUA','02','GENERAL SANCHEZ CERRO','08','PUQUINA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1530,'18','MOQUEGUA','02','GENERAL SANCHEZ CERRO','09','QUINISTAQUILLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1531,'18','MOQUEGUA','02','GENERAL SANCHEZ CERRO','10','UBINAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1532,'18','MOQUEGUA','02','GENERAL SANCHEZ CERRO','11','YUNGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1533,'18','MOQUEGUA','03','ILO','01','ILO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1534,'18','MOQUEGUA','03','ILO','02','EL ALGARROBAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1535,'18','MOQUEGUA','03','ILO','03','PACOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1536,'19','PASCO','01','PASCO','01','CHAUPIMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1537,'19','PASCO','01','PASCO','02','HUACHON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1538,'19','PASCO','01','PASCO','03','HUARIACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1539,'19','PASCO','01','PASCO','04','HUAYLLAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1540,'19','PASCO','01','PASCO','05','NINACACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1541,'19','PASCO','01','PASCO','06','PALLANCHACRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1542,'19','PASCO','01','PASCO','07','PAUCARTAMBO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1543,'19','PASCO','01','PASCO','08','SAN FRANCISCO DE ASIS DE YARUSYACAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1544,'19','PASCO','01','PASCO','09','SIMON BOLIVAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1545,'19','PASCO','01','PASCO','10','TICLACAYAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1546,'19','PASCO','01','PASCO','11','TINYAHUARCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1547,'19','PASCO','01','PASCO','12','VICCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1548,'19','PASCO','01','PASCO','13','YANACANCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1549,'19','PASCO','02','DANIEL ALCIDES CARRION','01','YANAHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1550,'19','PASCO','02','DANIEL ALCIDES CARRION','02','CHACAYAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1551,'19','PASCO','02','DANIEL ALCIDES CARRION','03','GOYLLARISQUIZGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1552,'19','PASCO','02','DANIEL ALCIDES CARRION','04','PAUCAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1553,'19','PASCO','02','DANIEL ALCIDES CARRION','05','SAN PEDRO DE PILLAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1554,'19','PASCO','02','DANIEL ALCIDES CARRION','06','SANTA ANA DE TUSI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1555,'19','PASCO','02','DANIEL ALCIDES CARRION','07','TAPUC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1556,'19','PASCO','02','DANIEL ALCIDES CARRION','08','VILCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1557,'19','PASCO','03','OXAPAMPA','01','OXAPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1558,'19','PASCO','03','OXAPAMPA','02','CHONTABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1559,'19','PASCO','03','OXAPAMPA','03','HUANCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1560,'19','PASCO','03','OXAPAMPA','04','PALCAZU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1561,'19','PASCO','03','OXAPAMPA','05','POZUZO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1562,'19','PASCO','03','OXAPAMPA','06','PUERTO BERMUDEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1563,'19','PASCO','03','OXAPAMPA','07','VILLA RICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1564,'19','PASCO','03','OXAPAMPA','08','CONSTITUCION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1565,'20','PIURA','01','PIURA','01','PIURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1566,'20','PIURA','01','PIURA','04','CASTILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1567,'20','PIURA','01','PIURA','05','CATACAOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1568,'20','PIURA','01','PIURA','07','CURA MORI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1569,'20','PIURA','01','PIURA','08','EL TALLAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1570,'20','PIURA','01','PIURA','09','LA ARENA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1571,'20','PIURA','01','PIURA','10','LA UNION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1572,'20','PIURA','01','PIURA','11','LAS LOMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1573,'20','PIURA','01','PIURA','14','TAMBO GRANDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1574,'20','PIURA','01','PIURA','15','VEINTISEIS DE OCTUBRE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1575,'20','PIURA','02','AYABACA','01','AYABACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1576,'20','PIURA','02','AYABACA','02','FRIAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1577,'20','PIURA','02','AYABACA','03','JILILI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1578,'20','PIURA','02','AYABACA','04','LAGUNAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1579,'20','PIURA','02','AYABACA','05','MONTERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1580,'20','PIURA','02','AYABACA','06','PACAIPAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1581,'20','PIURA','02','AYABACA','07','PAIMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1582,'20','PIURA','02','AYABACA','08','SAPILLICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1583,'20','PIURA','02','AYABACA','09','SICCHEZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1584,'20','PIURA','02','AYABACA','10','SUYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1585,'20','PIURA','03','HUANCABAMBA','01','HUANCABAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1586,'20','PIURA','03','HUANCABAMBA','02','CANCHAQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1587,'20','PIURA','03','HUANCABAMBA','03','EL CARMEN DE LA FRONTERA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1588,'20','PIURA','03','HUANCABAMBA','04','HUARMACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1589,'20','PIURA','03','HUANCABAMBA','05','LALAQUIZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1590,'20','PIURA','03','HUANCABAMBA','06','SAN MIGUEL DE EL FAIQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1591,'20','PIURA','03','HUANCABAMBA','07','SONDOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1592,'20','PIURA','03','HUANCABAMBA','08','SONDORILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1593,'20','PIURA','04','MORROPON','01','CHULUCANAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1594,'20','PIURA','04','MORROPON','02','BUENOS AIRES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1595,'20','PIURA','04','MORROPON','03','CHALACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1596,'20','PIURA','04','MORROPON','04','LA MATANZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1597,'20','PIURA','04','MORROPON','05','MORROPON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1598,'20','PIURA','04','MORROPON','06','SALITRAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1599,'20','PIURA','04','MORROPON','07','SAN JUAN DE BIGOTE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1600,'20','PIURA','04','MORROPON','08','SANTA CATALINA DE MOSSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1601,'20','PIURA','04','MORROPON','09','SANTO DOMINGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1602,'20','PIURA','04','MORROPON','10','YAMANGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1603,'20','PIURA','05','PAITA','01','PAITA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1604,'20','PIURA','05','PAITA','02','AMOTAPE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1605,'20','PIURA','05','PAITA','03','ARENAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1606,'20','PIURA','05','PAITA','04','COLAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1607,'20','PIURA','05','PAITA','05','LA HUACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1608,'20','PIURA','05','PAITA','06','TAMARINDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1609,'20','PIURA','05','PAITA','07','VICHAYAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1610,'20','PIURA','06','SULLANA','01','SULLANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1611,'20','PIURA','06','SULLANA','02','BELLAVISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1612,'20','PIURA','06','SULLANA','03','IGNACIO ESCUDERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1613,'20','PIURA','06','SULLANA','04','LANCONES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1614,'20','PIURA','06','SULLANA','05','MARCAVELICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1615,'20','PIURA','06','SULLANA','06','MIGUEL CHECA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1616,'20','PIURA','06','SULLANA','07','QUERECOTILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1617,'20','PIURA','06','SULLANA','08','SALITRAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1618,'20','PIURA','07','TALARA','01','PARIÑAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1619,'20','PIURA','07','TALARA','02','EL ALTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1620,'20','PIURA','07','TALARA','03','LA BREA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1621,'20','PIURA','07','TALARA','04','LOBITOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1622,'20','PIURA','07','TALARA','05','LOS ORGANOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1623,'20','PIURA','07','TALARA','06','MANCORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1624,'20','PIURA','08','SECHURA','01','SECHURA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1625,'20','PIURA','08','SECHURA','02','BELLAVISTA DE LA UNION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1626,'20','PIURA','08','SECHURA','03','BERNAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1627,'20','PIURA','08','SECHURA','04','CRISTO NOS VALGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1628,'20','PIURA','08','SECHURA','05','VICE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1629,'20','PIURA','08','SECHURA','06','RINCONADA LLICUAR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1630,'21','PUNO','01','PUNO','01','PUNO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1631,'21','PUNO','01','PUNO','02','ACORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1632,'21','PUNO','01','PUNO','03','AMANTANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1633,'21','PUNO','01','PUNO','04','ATUNCOLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1634,'21','PUNO','01','PUNO','05','CAPACHICA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1635,'21','PUNO','01','PUNO','06','CHUCUITO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1636,'21','PUNO','01','PUNO','07','COATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1637,'21','PUNO','01','PUNO','08','HUATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1638,'21','PUNO','01','PUNO','09','MAÑAZO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1639,'21','PUNO','01','PUNO','10','PAUCARCOLLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1640,'21','PUNO','01','PUNO','11','PICHACANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1641,'21','PUNO','01','PUNO','12','PLATERIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1642,'21','PUNO','01','PUNO','13','SAN ANTONIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1643,'21','PUNO','01','PUNO','14','TIQUILLACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1644,'21','PUNO','01','PUNO','15','VILQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1645,'21','PUNO','02','AZANGARO','01','AZANGARO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1646,'21','PUNO','02','AZANGARO','02','ACHAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1647,'21','PUNO','02','AZANGARO','03','ARAPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1648,'21','PUNO','02','AZANGARO','04','ASILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1649,'21','PUNO','02','AZANGARO','05','CAMINACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1650,'21','PUNO','02','AZANGARO','06','CHUPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1651,'21','PUNO','02','AZANGARO','07','JOSE DOMINGO CHOQUEHUANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1652,'21','PUNO','02','AZANGARO','08','MUÑANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1653,'21','PUNO','02','AZANGARO','09','POTONI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1654,'21','PUNO','02','AZANGARO','10','SAMAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1655,'21','PUNO','02','AZANGARO','11','SAN ANTON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1656,'21','PUNO','02','AZANGARO','12','SAN JOSE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1657,'21','PUNO','02','AZANGARO','13','SAN JUAN DE SALINAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1658,'21','PUNO','02','AZANGARO','14','SANTIAGO DE PUPUJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1659,'21','PUNO','02','AZANGARO','15','TIRAPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1660,'21','PUNO','03','CARABAYA','01','MACUSANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1661,'21','PUNO','03','CARABAYA','02','AJOYANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1662,'21','PUNO','03','CARABAYA','03','AYAPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1663,'21','PUNO','03','CARABAYA','04','COASA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1664,'21','PUNO','03','CARABAYA','05','CORANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1665,'21','PUNO','03','CARABAYA','06','CRUCERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1666,'21','PUNO','03','CARABAYA','07','ITUATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1667,'21','PUNO','03','CARABAYA','08','OLLACHEA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1668,'21','PUNO','03','CARABAYA','09','SAN GABAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1669,'21','PUNO','03','CARABAYA','10','USICAYOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1670,'21','PUNO','04','CHUCUITO','01','JULI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1671,'21','PUNO','04','CHUCUITO','02','DESAGUADERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1672,'21','PUNO','04','CHUCUITO','03','HUACULLANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1673,'21','PUNO','04','CHUCUITO','04','KELLUYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1674,'21','PUNO','04','CHUCUITO','05','PISACOMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1675,'21','PUNO','04','CHUCUITO','06','POMATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1676,'21','PUNO','04','CHUCUITO','07','ZEPITA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1677,'21','PUNO','05','EL COLLAO','01','ILAVE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1678,'21','PUNO','05','EL COLLAO','02','CAPAZO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1679,'21','PUNO','05','EL COLLAO','03','PILCUYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1680,'21','PUNO','05','EL COLLAO','04','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1681,'21','PUNO','05','EL COLLAO','05','CONDURIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1682,'21','PUNO','06','HUANCANE','01','HUANCANE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1683,'21','PUNO','06','HUANCANE','02','COJATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1684,'21','PUNO','06','HUANCANE','03','HUATASANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1685,'21','PUNO','06','HUANCANE','04','INCHUPALLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1686,'21','PUNO','06','HUANCANE','05','PUSI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1687,'21','PUNO','06','HUANCANE','06','ROSASPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1688,'21','PUNO','06','HUANCANE','07','TARACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1689,'21','PUNO','06','HUANCANE','08','VILQUE CHICO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1690,'21','PUNO','07','LAMPA','01','LAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1691,'21','PUNO','07','LAMPA','02','CABANILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1692,'21','PUNO','07','LAMPA','03','CALAPUJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1693,'21','PUNO','07','LAMPA','04','NICASIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1694,'21','PUNO','07','LAMPA','05','OCUVIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1695,'21','PUNO','07','LAMPA','06','PALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1696,'21','PUNO','07','LAMPA','07','PARATIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1697,'21','PUNO','07','LAMPA','08','PUCARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1698,'21','PUNO','07','LAMPA','09','SANTA LUCIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1699,'21','PUNO','07','LAMPA','10','VILAVILA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1700,'21','PUNO','08','MELGAR','01','AYAVIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1701,'21','PUNO','08','MELGAR','02','ANTAUTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1702,'21','PUNO','08','MELGAR','03','CUPI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1703,'21','PUNO','08','MELGAR','04','LLALLI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1704,'21','PUNO','08','MELGAR','05','MACARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1705,'21','PUNO','08','MELGAR','06','NUÑOA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1706,'21','PUNO','08','MELGAR','07','ORURILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1707,'21','PUNO','08','MELGAR','08','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1708,'21','PUNO','08','MELGAR','09','UMACHIRI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1709,'21','PUNO','09','MOHO','01','MOHO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1710,'21','PUNO','09','MOHO','02','CONIMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1711,'21','PUNO','09','MOHO','03','HUAYRAPATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1712,'21','PUNO','09','MOHO','04','TILALI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1713,'21','PUNO','10','SAN ANTONIO DE PUTINA','01','PUTINA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1714,'21','PUNO','10','SAN ANTONIO DE PUTINA','02','ANANEA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1715,'21','PUNO','10','SAN ANTONIO DE PUTINA','03','PEDRO VILCA APAZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1716,'21','PUNO','10','SAN ANTONIO DE PUTINA','04','QUILCAPUNCU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1717,'21','PUNO','10','SAN ANTONIO DE PUTINA','05','SINA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1718,'21','PUNO','11','SAN ROMAN','01','JULIACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1719,'21','PUNO','11','SAN ROMAN','02','CABANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1720,'21','PUNO','11','SAN ROMAN','03','CABANILLAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1721,'21','PUNO','11','SAN ROMAN','04','CARACOTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1722,'21','PUNO','11','SAN ROMAN','05','SAN MIGUEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1723,'21','PUNO','12','SANDIA','01','SANDIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1724,'21','PUNO','12','SANDIA','02','CUYOCUYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1725,'21','PUNO','12','SANDIA','03','LIMBANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1726,'21','PUNO','12','SANDIA','04','PATAMBUCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1727,'21','PUNO','12','SANDIA','05','PHARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1728,'21','PUNO','12','SANDIA','06','QUIACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1729,'21','PUNO','12','SANDIA','07','SAN JUAN DEL ORO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1730,'21','PUNO','12','SANDIA','08','YANAHUAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1731,'21','PUNO','12','SANDIA','09','ALTO INAMBARI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1732,'21','PUNO','12','SANDIA','10','SAN PEDRO DE PUTINA PUNCO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1733,'21','PUNO','13','YUNGUYO','01','YUNGUYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1734,'21','PUNO','13','YUNGUYO','02','ANAPIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1735,'21','PUNO','13','YUNGUYO','03','COPANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1736,'21','PUNO','13','YUNGUYO','04','CUTURAPI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1737,'21','PUNO','13','YUNGUYO','05','OLLARAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1738,'21','PUNO','13','YUNGUYO','06','TINICACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1739,'21','PUNO','13','YUNGUYO','07','UNICACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1740,'22','SAN MARTIN','01','MOYOBAMBA','01','MOYOBAMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1741,'22','SAN MARTIN','01','MOYOBAMBA','02','CALZADA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1742,'22','SAN MARTIN','01','MOYOBAMBA','03','HABANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1743,'22','SAN MARTIN','01','MOYOBAMBA','04','JEPELACIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1744,'22','SAN MARTIN','01','MOYOBAMBA','05','SORITOR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1745,'22','SAN MARTIN','01','MOYOBAMBA','06','YANTALO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1746,'22','SAN MARTIN','02','BELLAVISTA','01','BELLAVISTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1747,'22','SAN MARTIN','02','BELLAVISTA','02','ALTO BIAVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1748,'22','SAN MARTIN','02','BELLAVISTA','03','BAJO BIAVO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1749,'22','SAN MARTIN','02','BELLAVISTA','04','HUALLAGA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1750,'22','SAN MARTIN','02','BELLAVISTA','05','SAN PABLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1751,'22','SAN MARTIN','02','BELLAVISTA','06','SAN RAFAEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1752,'22','SAN MARTIN','03','EL DORADO','01','SAN JOSE DE SISA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1753,'22','SAN MARTIN','03','EL DORADO','02','AGUA BLANCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1754,'22','SAN MARTIN','03','EL DORADO','03','SAN MARTIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1755,'22','SAN MARTIN','03','EL DORADO','04','SANTA ROSA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1756,'22','SAN MARTIN','03','EL DORADO','05','SHATOJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1757,'22','SAN MARTIN','04','HUALLAGA','01','SAPOSOA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1758,'22','SAN MARTIN','04','HUALLAGA','02','ALTO SAPOSOA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1759,'22','SAN MARTIN','04','HUALLAGA','03','EL ESLABON')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1760,'22','SAN MARTIN','04','HUALLAGA','04','PISCOYACU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1761,'22','SAN MARTIN','04','HUALLAGA','05','SACANCHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1762,'22','SAN MARTIN','04','HUALLAGA','06','TINGO DE SAPOSOA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1763,'22','SAN MARTIN','05','LAMAS','01','LAMAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1764,'22','SAN MARTIN','05','LAMAS','02','ALONSO DE ALVARADO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1765,'22','SAN MARTIN','05','LAMAS','03','BARRANQUITA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1766,'22','SAN MARTIN','05','LAMAS','04','CAYNARACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1767,'22','SAN MARTIN','05','LAMAS','05','CUÑUMBUQUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1768,'22','SAN MARTIN','05','LAMAS','06','PINTO RECODO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1769,'22','SAN MARTIN','05','LAMAS','07','RUMISAPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1770,'22','SAN MARTIN','05','LAMAS','08','SAN ROQUE DE CUMBAZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1771,'22','SAN MARTIN','05','LAMAS','09','SHANAO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1772,'22','SAN MARTIN','05','LAMAS','10','TABALOSOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1773,'22','SAN MARTIN','05','LAMAS','11','ZAPATERO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1774,'22','SAN MARTIN','06','MARISCAL CACERES','01','JUANJUI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1775,'22','SAN MARTIN','06','MARISCAL CACERES','02','CAMPANILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1776,'22','SAN MARTIN','06','MARISCAL CACERES','03','HUICUNGO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1777,'22','SAN MARTIN','06','MARISCAL CACERES','04','PACHIZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1778,'22','SAN MARTIN','06','MARISCAL CACERES','05','PAJARILLO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1779,'22','SAN MARTIN','07','PICOTA','01','PICOTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1780,'22','SAN MARTIN','07','PICOTA','02','BUENOS AIRES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1781,'22','SAN MARTIN','07','PICOTA','03','CASPISAPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1782,'22','SAN MARTIN','07','PICOTA','04','PILLUANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1783,'22','SAN MARTIN','07','PICOTA','05','PUCACACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1784,'22','SAN MARTIN','07','PICOTA','06','SAN CRISTOBAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1785,'22','SAN MARTIN','07','PICOTA','07','SAN HILARION')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1786,'22','SAN MARTIN','07','PICOTA','08','SHAMBOYACU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1787,'22','SAN MARTIN','07','PICOTA','09','TINGO DE PONASA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1788,'22','SAN MARTIN','07','PICOTA','10','TRES UNIDOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1789,'22','SAN MARTIN','08','RIOJA','01','RIOJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1790,'22','SAN MARTIN','08','RIOJA','02','AWAJUN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1791,'22','SAN MARTIN','08','RIOJA','03','ELIAS SOPLIN VARGAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1792,'22','SAN MARTIN','08','RIOJA','04','NUEVA CAJAMARCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1793,'22','SAN MARTIN','08','RIOJA','05','PARDO MIGUEL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1794,'22','SAN MARTIN','08','RIOJA','06','POSIC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1795,'22','SAN MARTIN','08','RIOJA','07','SAN FERNANDO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1796,'22','SAN MARTIN','08','RIOJA','08','YORONGOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1797,'22','SAN MARTIN','08','RIOJA','09','YURACYACU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1798,'22','SAN MARTIN','09','SAN MARTIN','01','TARAPOTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1799,'22','SAN MARTIN','09','SAN MARTIN','02','ALBERTO LEVEAU')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1800,'22','SAN MARTIN','09','SAN MARTIN','03','CACATACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1801,'22','SAN MARTIN','09','SAN MARTIN','04','CHAZUTA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1802,'22','SAN MARTIN','09','SAN MARTIN','05','CHIPURANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1803,'22','SAN MARTIN','09','SAN MARTIN','06','EL PORVENIR')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1804,'22','SAN MARTIN','09','SAN MARTIN','07','HUIMBAYOC')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1805,'22','SAN MARTIN','09','SAN MARTIN','08','JUAN GUERRA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1806,'22','SAN MARTIN','09','SAN MARTIN','09','LA BANDA DE SHILCAYO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1807,'22','SAN MARTIN','09','SAN MARTIN','10','MORALES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1808,'22','SAN MARTIN','09','SAN MARTIN','11','PAPAPLAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1809,'22','SAN MARTIN','09','SAN MARTIN','12','SAN ANTONIO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1810,'22','SAN MARTIN','09','SAN MARTIN','13','SAUCE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1811,'22','SAN MARTIN','09','SAN MARTIN','14','SHAPAJA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1812,'22','SAN MARTIN','10','TOCACHE','01','TOCACHE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1813,'22','SAN MARTIN','10','TOCACHE','02','NUEVO PROGRESO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1814,'22','SAN MARTIN','10','TOCACHE','03','POLVORA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1815,'22','SAN MARTIN','10','TOCACHE','04','SHUNTE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1816,'22','SAN MARTIN','10','TOCACHE','05','UCHIZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1817,'23','TACNA','01','TACNA','01','TACNA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1818,'23','TACNA','01','TACNA','02','ALTO DE LA ALIANZA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1819,'23','TACNA','01','TACNA','03','CALANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1820,'23','TACNA','01','TACNA','04','CIUDAD NUEVA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1821,'23','TACNA','01','TACNA','05','INCLAN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1822,'23','TACNA','01','TACNA','06','PACHIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1823,'23','TACNA','01','TACNA','07','PALCA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1824,'23','TACNA','01','TACNA','08','POCOLLAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1825,'23','TACNA','01','TACNA','09','SAMA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1826,'23','TACNA','01','TACNA','10','CORONEL GREGORIO ALBARRACIN LANCHIPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1827,'23','TACNA','01','TACNA','11','LA YARADA LOS PALOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1828,'23','TACNA','02','CANDARAVE','01','CANDARAVE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1829,'23','TACNA','02','CANDARAVE','02','CAIRANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1830,'23','TACNA','02','CANDARAVE','03','CAMILACA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1831,'23','TACNA','02','CANDARAVE','04','CURIBAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1832,'23','TACNA','02','CANDARAVE','05','HUANUARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1833,'23','TACNA','02','CANDARAVE','06','QUILAHUANI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1834,'23','TACNA','03','JORGE BASADRE','01','LOCUMBA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1835,'23','TACNA','03','JORGE BASADRE','02','ILABAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1836,'23','TACNA','03','JORGE BASADRE','03','ITE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1837,'23','TACNA','04','TARATA','01','TARATA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1838,'23','TACNA','04','TARATA','02','HEROES ALBARRACIN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1839,'23','TACNA','04','TARATA','03','ESTIQUE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1840,'23','TACNA','04','TARATA','04','ESTIQUE-PAMPA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1841,'23','TACNA','04','TARATA','05','SITAJARA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1842,'23','TACNA','04','TARATA','06','SUSAPAYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1843,'23','TACNA','04','TARATA','07','TARUCACHI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1844,'23','TACNA','04','TARATA','08','TICACO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1845,'24','TUMBES','01','TUMBES','01','TUMBES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1846,'24','TUMBES','01','TUMBES','02','CORRALES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1847,'24','TUMBES','01','TUMBES','03','LA CRUZ')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1848,'24','TUMBES','01','TUMBES','04','PAMPAS DE HOSPITAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1849,'24','TUMBES','01','TUMBES','05','SAN JACINTO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1850,'24','TUMBES','01','TUMBES','06','SAN JUAN DE LA VIRGEN')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1851,'24','TUMBES','02','CONTRALMIRANTE VILLAR','01','ZORRITOS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1852,'24','TUMBES','02','CONTRALMIRANTE VILLAR','02','CASITAS')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1853,'24','TUMBES','02','CONTRALMIRANTE VILLAR','03','CANOAS DE PUNTA SAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1854,'24','TUMBES','03','ZARUMILLA','01','ZARUMILLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1855,'24','TUMBES','03','ZARUMILLA','02','AGUAS VERDES')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1856,'24','TUMBES','03','ZARUMILLA','03','MATAPALO')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1857,'24','TUMBES','03','ZARUMILLA','04','PAPAYAL')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1858,'25','UCAYALI','01','CORONEL PORTILLO','01','CALLERIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1859,'25','UCAYALI','01','CORONEL PORTILLO','02','CAMPOVERDE')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1860,'25','UCAYALI','01','CORONEL PORTILLO','03','IPARIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1861,'25','UCAYALI','01','CORONEL PORTILLO','04','MASISEA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1862,'25','UCAYALI','01','CORONEL PORTILLO','05','YARINACOCHA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1863,'25','UCAYALI','01','CORONEL PORTILLO','06','NUEVA REQUENA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1864,'25','UCAYALI','01','CORONEL PORTILLO','07','MANANTAY')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1865,'25','UCAYALI','02','ATALAYA','01','RAYMONDI')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1866,'25','UCAYALI','02','ATALAYA','02','SEPAHUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1867,'25','UCAYALI','02','ATALAYA','03','TAHUANIA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1868,'25','UCAYALI','02','ATALAYA','04','YURUA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1869,'25','UCAYALI','03','PADRE ABAD','01','PADRE ABAD')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1870,'25','UCAYALI','03','PADRE ABAD','02','IRAZOLA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1871,'25','UCAYALI','03','PADRE ABAD','03','CURIMANA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1872,'25','UCAYALI','03','PADRE ABAD','04','NESHUYA')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1873,'25','UCAYALI','03','PADRE ABAD','05','ALEXANDER VON HUMBOLDT')
    ","insert into ubigeo (id,CodDept,NomDept,CodProv,NomProv,CodDist,NomDist  ) values (1874,'25','UCAYALI','04','PURUS','01','PURUS')"];
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
