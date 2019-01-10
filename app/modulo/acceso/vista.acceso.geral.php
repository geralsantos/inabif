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

    $arr = ["insert into diag_neurologico_cie_10 (id,nombre) values (1,'G00 Meningitis bacteriana, no clasificada en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (2,'G00.0 Meningitis por hemófilos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (3,'G00.1 Meningitis neumocócica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (4,'G00.2 Meningitis estreptocócica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (5,'G00.3 Meningitis estafilocócica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (6,'G00.8 Otras meningitis bacterianas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (7,'G00.9 Meningitis bacteriana, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (8,'G01* Meningitis en enfermedades bacterianas clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (9,'G02* Meningitis en otras enfermedades infecciosas y parasitarias clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (10,'G02.0* Meningitis en enfermedades virales clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (11,'G02.1* Meningitis en micosis')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (12,'G02.8* Meningitis en otras enfermedades infecciosas y parasitarias especificadas clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (13,'G03 Meningitis debida a otras causas y a las no especificadas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (14,'G03.0 Meningitis apiógena')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (15,'G03.1 Meningitis crónica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (16,'G03.2 Meningitis recurrente benigna [Mollaret]')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (17,'G03.8 Meningitis debidas a otras causas especificadas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (18,'G03.9 Meningitis, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (19,'G04 Encefalitis, mielitis y encefalomielitis')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (20,'G04.0 Encefalitis aguda diseminada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (21,'G04.1 Paraplejía espástica tropical')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (22,'G04.2 Meningoencefalitis y meningomielitis bacterianas, no clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (23,'G04.8 Otras encefalitis, mielitis y encefalomielitis')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (24,'G04.9 Encefalitis, mielitis y encefalomielitis, no especificadas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (25,'G05* Encefalitis, mielitis y encefalomielitis en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (26,'G05.0* Encefalitis, mielitis y encefalomielitis en enfermedades bacterianas clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (27,'G05.1* Encefalitis, mielitis y encefalomielitis en enfermedades virales clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (28,'G05.2* Encefalitis, mielitis y encefalomielitis en otras enfermedades infecciosas y parasitarias clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (29,'G05.8* Encefalitis, mielitis y encefalomielitis en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (30,'G06 Absceso y granuloma intracraneal e intrarraquídeo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (31,'G06.0 Absceso y granuloma intracraneal')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (32,'G06.1 Absceso y granuloma intrarraquídeo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (33,'G06.2 Absceso extradural y subdural, no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (34,'G07* Absceso y granuloma intracraneal e intrarraquídeo en enfermedades  clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (35,'G08 Flebitis y tromboflebitis intracraneal e intrarraquídea')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (36,'G09 Secuelas de enfermedades inflamatorias del sistema nervioso central')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (37,'G10 Enfermedad de Huntington')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (38,'G11 Ataxia hereditaria')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (39,'G11.0 Ataxia congénita no progresiva')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (40,'G11.1 Ataxia cerebelosa de iniciación temprana')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (41,'G11.2 Ataxia cerebelosa de iniciación tardía')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (42,'G11.3 Ataxia cerebelosa con reparación defectuosa del ADN')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (43,'G11.4 Paraplejía espástica hereditaria')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (44,'G11.8 Otras ataxias hereditarias')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (45,'G11.9 Ataxia hereditaria, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (46,'G12 Atrofia muscular espinal y síndromes afines')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (47,'G12.0 Atrofia muscular espinal infantil, tipo I [Werdnig-Hoffman]')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (48,'G12.1 Otras atrofias musculares espinales hereditarias')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (49,'G12.2 Enfermedades de las neuronas motoras')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (50,'G12.8 Otras atrofias musculares espinales y síndromes afines')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (51,'G12.9 Atrofia muscular espinal, sin otra especificación')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (52,'G13* Atrofias sistémicas que afectan primariamente el sistema nervioso central en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (53,'G13.0* Neuromiopatía y neuropatía paraneoplásica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (54,'G13.1* Otras atrofias sistémicas que afectan el sistema nervioso central en enfermedad neoplásica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (55,'G13.2* Atrofia sistémica que afecta primariamente el sistema nervioso central en el mixedema (E00.1+, E03.-+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (56,'G13.8* Atrofia sistémica que afecta primariamente el sistema nervioso central en otras enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (57,'G20 Enfermedad de Parkinson')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (58,'G21 Parkinsonismo secundario')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (59,'G21.0 Síndrome neuroléptico maligno')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (60,'G21.1 Otro parkinsonismo secundario inducido por drogas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (61,'G21.2 Parkinsonismo secundario debido a otros agentes externos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (62,'G21.3 Parkinsonismo postencefalítico')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (63,'G21.8 Otros tipos de parkinsonismo secundario')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (64,'G21.9 Parkinsonismo secundario, no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (65,'G22* Parkinsonismo en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (66,'G23 Otras enfermedades degenerativas de los núcleos de la base')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (67,'G23.0 Enfermedad de Hallervorden-Spatz')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (68,'G23.1 Oftalmoplejía supranuclear progresiva [Steele-Richardson-Olszewski]')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (69,'G23.2 Degeneración nigroestriada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (70,'G23.8 Otras enfermedades degenerativas específicas de los núcleos de la base')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (71,'G23.9 Enfermedad degenerativa de los núcleos de la base, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (72,'G24 Distonía')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (73,'G24.0 Distonía inducida por drogas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (74,'G24.1 Distonía idiopática familiar')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (75,'G24.2 Distonía idiopática no familiar')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (76,'G24.3 Tortícolis espasmódica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (77,'G24.4 Distonía bucofacial idiopática')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (78,'G24.5 Blefarospasmo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (79,'G24.8 Otras distonías')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (80,'G24.9 Distonía, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (81,'G25 Otros trastornos extrapiramidales y del movimiento')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (82,'G25.0 Temblor esencial')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (83,'G25.1 Temblor inducido por drogas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (84,'G25.2 Otras formas especificadas de temblor')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (85,'G25.3 Mioclonía')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (86,'G25.4 Corea inducida por drogas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (87,'G25.5 Otras coreas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (88,'G25.6 Tics inducidos por drogas y otros tics de origen orgánico')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (89,'G25.8 Otros trastornos extrapiramidales y del movimiento')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (90,'G25.9 Trastorno extrapiramidal y del movimiento, no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (91,'G26* Trastornos extrapiramidales y del movimiento en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (92,'G30 Enfermedad de Alzheimer')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (93,'G30.0 Enfermedad de Alzheimer de comienzo temprano')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (94,'G30.1 Enfermedad de Alzheimer de comienzo tardío')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (95,'G30.8 Otros tipos de enfermedad de Alzheimer')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (96,'G30.9 Enfermedad de Alzheimer, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (97,'G31 Otras enfermedades degenerativas del sistema nervioso, no  clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (98,'G31.0 Atrofia cerebral circunscrita')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (99,'G31.1 Degeneración cerebral senil no clasificada en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (100,'G31.2 Degeneración del sistema nervioso debida al alcohol')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (101,'G31.8 Otras enfermedades degenerativas especificadas del sistema nervioso')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (102,'G31.9 Degeneración del sistema nervioso, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (103,'G32 Otros trastornos degenerativos del sistema nervioso en enfermedades  clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (104,'G32.0 Degeneración combinada subaguda de la médula espinal en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (105,'G32.8 Otros trastornos degenerativos especificados del sistema nervioso en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (106,'G35 Esclerosis múltiple')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (107,'G36 Otras desmielinizaciones diseminadas agudas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (108,'G36.0 Neuromielitis óptica [Devic]')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (109,'G36.1 Leucoencefalitis hemorrágica aguda y subaguda [Hurst]')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (110,'G36.8 Otras desmielinizaciones agudas diseminadas especificadas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (111,'G36.9 Desmielinización diseminada aguda, sin otra especificación')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (112,'G37 Otras enfermedades desmielinizantes del sistema nervioso central')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (113,'G37.0 Esclerosis difusa')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (114,'G37.1 Desmielinización central del cuerpo calloso')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (115,'G37.2 Mielinólisis central pontina')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (116,'G37.3 Mielitis transversa aguda en enfermedad desmielinizante del sistema nervioso central')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (117,'G37.4 Mielitis necrotizante subaguda')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (118,'G37.5 Esclerosis concéntrica [Baló]')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (119,'G37.8 Otras enfermedades desmielinizantes del sistema nervioso central, especificadas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (120,'G37.9 Enfermedad desmielinizante del sistema nervioso central, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (121,'G40 Epilepsia')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (122,'G40.0 Epilepsia y síndromes epilépticos idiopáticos relacionados con localizaciones (focales) (parciales) y con ataques de inicio localizado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (123,'G40.1 Epilepsia y síndromes epilépticos sintomáticos relacionados con localizaciones (focales) (parciales) y con ataques parciales simples')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (124,'G40.2 Epilepsia y síndromes epilépticos sintomáticos relacionados con localizaciones (focales) (parciales) y con ataques parciales complejos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (125,'G40.3 Epilepsia y síndromes epilépticos idiopáticos generalizados')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (126,'G40.4 Otras epilepsias y síndromes epilépticos generalizados')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (127,'G40.5 Síndromes epilépticos especiales')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (128,'G40.6 Ataques de gran mal, no especificados (con o sin pequeño mal)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (129,'G40.7 Pequeño mal, no especificado (sin ataque de gran mal)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (130,'G40.8 Otras epilepsias')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (131,'G40.9 Epilepsia, tipo no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (132,'G41 Estado de mal epiléptico')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (133,'G41.0 Estado de gran mal epiléptico')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (134,'G41.1 Estado de pequeño mal epiléptico')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (135,'G41.2 Estado de mal epiléptico parcial complejo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (136,'G41.8 Otros estados epilépticos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (137,'G41.9 Estado de mal epiléptico de tipo no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (138,'G43 Migraña')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (139,'G43.0 Migraña sin aura [migraña común]')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (140,'G43.1 Migraña con aura [migraña clásica]')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (141,'G43.2 Estado migrañoso')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (142,'G43.3 Migraña complicada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (143,'G43.8 Otras migrañas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (144,'G43.9 Migraña, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (145,'G44 Otros síndromes de cefalea')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (146,'G44.0 Síndrome de cefalea en racimos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (147,'G44.1 Cefalea vascular, NCOP')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (148,'G44.2 Cefalea debida a tensión')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (149,'G44.3 Cefalea postraumática crónica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (150,'G44.4 Cefalea inducida por drogas, no clasificada en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (151,'G44.8 Otros síndromes de cefalea especificados')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (152,'G45 Ataques de isquemia cerebral transitoria y síndromes afines')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (153,'G45.0 Síndrome arterial vértebro-basilar')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (154,'G45.1 Síndrome de la arteria carótida (hemisférico)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (155,'G45.2 Síndromes arteriales precerebrales bilaterales y múltiples')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (156,'G45.3 Amaurosis fugaz')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (157,'G45.4 Amnesia global transitoria')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (158,'G45.8 Otras isquemias cerebrales transitorias y síndromes afines')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (159,'G45.9 Isquemia cerebral transitoria, sin otra especificación')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (160,'G46* Síndromes vasculares encefálicos en enfermedades cerebrovasculares (I60- I67+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (161,'G46.0* Síndrome de la arteria cerebral media (I66.0+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (162,'G46.1* Síndrome de la arteria cerebral anterior (I66.1+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (163,'G46.2* Síndrome de la arteria cerebral posterior (I66.2+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (164,'G46.3* Síndromes apopléticos del tallo encefálico (I60-I67+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (165,'G46.4* Síndrome de infarto cerebeloso (I60-I67+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (166,'G46.5* Síndrome lacunar motor puro (I60-I67+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (167,'G46.6* Síndrome lacunar sensorial puro (I60-I67+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (168,'G46.7* Otros síndromes lacunares (I60-I67+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (169,'G46.8* Otros síndromes vasculares encefálicos en enfermedades cerebrovasculares (I60-I67+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (170,'G47 Trastornos del sueño')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (171,'G47.0 Trastornos del inicio y del mantenimiento del sueño [insomnios]')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (172,'G47.1 Trastornos de somnolencia excesiva [hipersomnios]')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (173,'G47.2 Trastornos del ritmo nictameral')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (174,'G47.3 Apnea del sueño')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (175,'G47.4 Narcolepsia y cataplexia')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (176,'G47.8 Otros trastornos del sueño')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (177,'G47.9 Trastorno del sueño, no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (178,'G50 Trastornos del nervio trigémino')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (179,'G50.0 Neuralgia del trigémino')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (180,'G50.1 Dolor facial atípico')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (181,'G50.8 Otros trastornos del trigémino')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (182,'G50.9 Trastorno del trigémino, no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (183,'G51 Trastornos del nervio facial')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (184,'G51.0 Parálisis de Bell')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (185,'G51.1 Ganglionitis geniculada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (186,'G51.2 Síndrome de Melkersson')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (187,'G51.3 Espasmo hemifacial clónico')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (188,'G51.4 Mioquimia facial')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (189,'G51.8 Otros trastornos del nervio facial')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (190,'G51.9 Trastorno del nervio facial, no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (191,'G52 Trastornos de otros nervios craneales')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (192,'G52.0 Trastornos del nervio olfatorio')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (193,'G52.1 Trastornos del nervio glosofaríngeo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (194,'G52.2 Trastornos del nervio vago')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (195,'G52.3 Trastornos del nervio hipogloso')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (196,'G52.7 Trastornos de múltiples nervios craneales')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (197,'G52.8 Trastornos de otros nervios craneales especificados')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (198,'G52.9 Trastorno de nervio craneal, no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (199,'G53* Trastornos de los nervios craneales en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (200,'G53.0* Neuralgia postherpes zoster (B02.2+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (201,'G53.1* Parálisis múltiple de los nervios craneales en enfermedades infecciosas y parasitarias clasificadas en otra parte (A00-B99+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (202,'G53.2* Parálisis múltiple de los nervios craneales, en la sarcoidosis (D86.8+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (203,'G53.3* Parálisis múltiple de los nervios craneales, en enfermedades neoplásicas (C00-D48+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (204,'G53.8* Otros trastornos de los nervios craneales en otras enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (205,'G54 Trastornos de las raíces y de los plexos nerviosos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (206,'G54.0 Trastornos del plexo braquial')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (207,'G54.1 Trastornos del plexo lumbosacro')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (208,'G54.2 Trastornos de la raíz cervical, no clasificados en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (209,'G54.3 Trastornos de la raíz torácica, no clasificados en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (210,'G54.4 Trastornos de la raíz lumbosacra, no clasificados en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (211,'G54.5 Amiotrofia neurálgica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (212,'G54.6 Síndrome del miembro fantasma con dolor')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (213,'G54.7 Síndrome del miembro fantasma sin dolor')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (214,'G54.8 Otros trastornos de las raíces y plexos nerviosos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (215,'G54.9 Trastorno de la raíz y plexos nerviosos, no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (216,'G55* Compresiones de las raíces y de los plexos nerviosos en enfermedades  clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (217,'G55.0* Compresiones de las raíces y plexos nerviosos en enfermedades neoplásicas (C00-D48+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (218,'G55.1* Compresiones de las raíces y plexos nerviosos en trastornos de los discos intervertebrales (M50-M51+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (219,'G55.2* Compresiones de las raíces y plexos nerviosos en la espondilosis (M47.-+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (220,'G55.3* Compresiones de las raíces y plexos nerviosos en otras dorsopatías (M45- M46+, M48.-+, M53-M54+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (221,'G55.8* Compresiones de las raíces y plexos nerviosos en otras enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (222,'G56 Mononeuropatías del miembro superior')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (223,'G56.0 Síndrome del túnel carpiano')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (224,'G56.1 Otras lesiones del nervio mediano')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (225,'G56.2 Lesión del nervio cubital')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (226,'G56.3 Lesión del nervio radial')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (227,'G56.4 Causalgia')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (228,'G56.8 Otras mononeuropatías del miembro superior')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (229,'G56.9 Mononeuropatía del miembro superior, sin otra especificación')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (230,'G57 Mononeuropatías del miembro inferior')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (231,'G57.0 Lesión del nervio ciático')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (232,'G57.1 Meralgia parestésica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (233,'G57.2 Lesión del nervio crural')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (234,'G57.3 Lesión del nervio ciático poplíteo externo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (235,'G57.4 Lesión del nervio ciático poplíteo interno')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (236,'G57.5 Síndrome del túnel calcáneo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (237,'G57.6 Lesión del nervio plantar')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (238,'G57.8 Otras mononeuropatías del miembro inferior')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (239,'G57.9 Mononeuropatía del miembro inferior, sin otra especificación')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (240,'G58 Otras mononeuropatías')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (241,'G58.0 Neuropatía intercostal')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (242,'G58.7 Mononeuritis múltiple')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (243,'G58.8 Otras mononeuropatías especificadas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (244,'G58.9 Mononeuropatía, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (245,'G59* Mononeuropatía en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (246,'G59.0* Mononeuropatía diabética (E10-E14+ con cuarto carácter común .4)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (247,'G59.8* Otras mononeuropatías en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (248,'G60 Neuropatía hereditaria e idiopática')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (249,'G60.0 Neuropatía hereditaria motora y sensorial')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (250,'G60.1 Enfermedad de Refsum')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (251,'G60.2 Neuropatía asociada con ataxia hereditaria')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (252,'G60.3 Neuropatía progresiva idiopática')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (253,'G60.8 Otras neuropatías hereditarias e idiopáticas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (254,'G60.9 Neuropatía hereditaria e idiopática, sin otra especificación')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (255,'G61 Polineuropatía inflamatoria')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (256,'G61.0 Síndrome de Guillain-Barré')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (257,'G61.1 Neuropatía al suero')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (258,'G61.8 Otras polineuropatías inflamatorias')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (259,'G61.9 Polineuropatía inflamatoria, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (260,'G62 Otras polineuropatías')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (261,'G62.0 Polineuropatía inducida por drogas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (262,'G62.1 Polineuropatía alcohólica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (263,'G62.2 Polineuropatía debida a otro agente tóxico')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (264,'G62.8 Otras polineuropatías especificadas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (265,'G62.9 Polineuropatía, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (266,'G63* Polineuropatías en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (267,'G63.0* Polineuropatía en enfermedades infecciosas y parasitarias clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (268,'G63.1* Polineuropatía en enfermedad neoplásica (C00-D48+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (269,'G63.2* Polineuropatía diabética (E10-E14+ con cuarto carácter común .4)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (270,'G63.3* Polineuropatía en otras enfermedades endocrinas y metabólicas (E00-E07+, E15-E16+, E20-E34+, E70-E89+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (271,'G63.4* Polineuropatía en deficiencia nutricional (E40-E64+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (272,'G63.5* Polineuropatía en trastornos del tejido conectivo sistémico (M30-M35+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (273,'G63.6* Polineuropatía en otros trastornos osteomusculares (M00-M25+, M40-M96+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (274,'G63.8* Polineuropatía en otras enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (275,'G64 Otros trastornos del sistema nervioso periférico')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (276,'G70 Miastenia gravis y otros trastornos neuromusculares')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (277,'G70.0 Miastenia gravis')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (278,'G70.1 Trastornos tóxicos neuromusculares')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (279,'G70.2 Miastenia congénita o del desarrollo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (280,'G70.8 Otros trastornos neuromusculares especificados')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (281,'G70.9 Trastorno neuromuscular, no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (282,'G71 Trastornos musculares primarios')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (283,'G71.0 Distrofia muscular')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (284,'G71.1 Trastornos miotónicos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (285,'G71.2 Miopatías congénitas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (286,'G71.3 Miopatía mitocóndrica, no clasificada en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (287,'G71.8 Otros trastornos primarios de los músculos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (288,'G71.9 Trastorno primario del músculo, tipo no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (289,'G72 Otras miopatías')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (290,'G72.0 Miopatía inducida por drogas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (291,'G72.1 Miopatía alcohólica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (292,'G72.2 Miopatía debida a otros agentes tóxicos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (293,'G72.3 Parálisis periódica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (294,'G72.4 Miopatía inflamatoria, no clasificada en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (295,'G72.8 Otras miopatías especificadas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (296,'G72.9 Miopatía, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (297,'G73* Trastornos del músculo y de la unión neuromuscular en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (298,'G73.0* Síndromes miasténicos en enfermedades endocrinas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (299,'G73.1* Síndrome de Eaton-Lambert (C80+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (300,'G73.2* Otros síndromes miasténicos en enfermedad neoplásica (C00-D48+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (301,'G73.3* Síndromes miasténicos en otras enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (302,'G73.4* Miopatía en enfermedades infecciosas y parasitarias clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (303,'G73.5* Miopatía en enfermedades endocrinas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (304,'G73.6* Miopatía en enfermedades metabólicas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (305,'G73.7* Miopatía en otras enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (306,'G80 Parálisis cerebral infantil')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (307,'G80.0 Parálisis cerebral espástica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (308,'G80.1 Diplejía espástica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (309,'G80.2 Hemiplejía infantil')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (310,'G80.3 Parálisis cerebral discinética')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (311,'G80.4 Parálisis cerebral atáxica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (312,'G80.8 Otros tipos de parálisis cerebral infantil')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (313,'G80.9 Parálisis cerebral infantil, sin otra especificación')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (314,'G81 Hemiplejía')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (315,'G81.0 Hemiplejía flácida')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (316,'G81.1 Hemiplejía espástica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (317,'G81.9 Hemiplejía, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (318,'G82 Paraplejía y cuadriplejía')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (319,'G82.0 Paraplejía flácida')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (320,'G82.1 Paraplejía espástica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (321,'G82.2 Paraplejía, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (322,'G82.3 Cuadriplejía flácida')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (323,'G82.4 Cuadriplejía espástica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (324,'G82.5 Cuadriplejía, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (325,'G83 Otros síndromes paralíticos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (326,'G83.0 Diplejía de los miembros superiores')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (327,'G83.1 Monoplejía de miembro inferior')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (328,'G83.2 Monoplejía de miembro superior')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (329,'G83.3 Monoplejía, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (330,'G83.4 Síndrome de la cola de caballo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (331,'G83.8 Otros síndromes paralíticos especificados')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (332,'G83.9 Síndrome paralítico, no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (333,'G90 Trastornos del sistema nervioso autónomo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (334,'G90.0 Neuropatía autónoma periférica idiopática')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (335,'G90.1 Disautonomía familiar [Síndrome de Riley-Day]')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (336,'G90.2 Síndrome de Horner')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (337,'G90.3 Degeneración de sistemas múltiples')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (338,'G90.8 Otros trastornos del sistema nervioso autónomo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (339,'G90.9 Trastorno del sistema nervioso autónomo, no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (340,'G91 Hidrocéfalo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (341,'G91.0 Hidrocéfalo comunicante')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (342,'G91.1 Hidrocéfalo obstructivo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (343,'G91.2 Hidrocéfalo de presión normal')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (344,'G91.3 Hidrocéfalo postraumático, sin otra especificación')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (345,'G91.8 Otros tipos de hidrocéfalo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (346,'G91.9 Hidrocéfalo, no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (347,'G92 Encefalopatía tóxica')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (348,'G93 Otros trastornos del encéfalo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (349,'G93.0 Quiste cerebral')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (350,'G93.1 Lesión cerebral anóxica, no clasificada en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (351,'G93.2 Hipertensión intracraneal benigna')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (352,'G93.3 Síndrome de fatiga postviral')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (353,'G93.4 Encefalopatía no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (354,'G93.5 Compresión del encéfalo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (355,'G93.6 Edema cerebral')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (356,'G93.7 Síndrome de Reye')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (357,'G93.8 Otros trastornos especificados del encéfalo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (358,'G93.9 Trastorno del encéfalo, no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (359,'G94* Otros trastornos del encéfalo en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (360,'G94.0* Hidrocéfalo en enfermedades infecciosas y parasitarias clasificadas en otra parte (A00-B99+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (361,'G94.1* Hidrocéfalo en enfermedad neoplásica (C00-D48+)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (362,'G94.2* Hidrocéfalo en otras enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (363,'G94.8* Otros trastornos encefálicos especificados en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (364,'G95 Otras enfermedades de la médula espinal')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (365,'G95.0 Siringomielia y siringobulbia')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (366,'G95.1 Mielopatías vasculares')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (367,'G95.2 Compresión medular, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (368,'G95.8 Otras enfermedades especificadas de la médula espinal')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (369,'G95.9 Enfermedad de la médula espinal, no especificada')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (370,'G96 Otros trastornos del sistema nervioso central')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (371,'G96.0 Pérdida de líquido cefalorraquídeo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (372,'G96.1 Trastornos de las meninges, no clasificados en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (373,'G96.8 Otros trastornos especificados del sistema nervioso central')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (374,'G96.9 Trastorno del sistema nervioso central, no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (375,'G97 Trastornos del sistema nervioso consecutivos a procedimientos, no clasificados en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (376,'G97.0 Pérdida de líquido cefalorraquídeo por punción espinal')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (377,'G97.1 Otra reacción a la punción espinal y lumbar')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (378,'G97.2 Hipotensión intracraneal posterior a anastomosis ventricular')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (379,'G97.8 Otros trastornos del sistema nervioso consecutivos a procedimientos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (380,'G97.9 Trastornos no especificados del sistema nervioso, consecutivos a procedimientos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (381,'G98 Otros trastornos del sistema nervioso, no clasificados en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (382,'G99* Otros trastornos del sistema nervioso en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (383,'G99.0* Neuropatía autonómica en enfermedades metabólicas y endocrinas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (384,'G99.1* Otros trastornos del sistema nervioso autónomo en otras enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (385,'G99.2* Mielopatía en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (386,'G99.8* Otros trastornos especificados del sistema nervioso en enfermedades clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (387,'Q00 Anencefalia y malformaciones congénitas similares')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (388,'Q01 Encefalocele')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (389,'Q02 Microcefalia')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (390,'Q03 Hidrocéfalo congénito')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (391,'Q04 Otras malformaciones congénitas del encéfalo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (392,'Q05 Espina bífida')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (393,'Q06 Otras malformaciones congénitas de la médula espinal')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (394,'Q07 Otras malformaciones congénitas del sistema nervioso')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (395,'Q10 Malformaciones congénitas de los párpados, del aparato lagrimal y de la órbita')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (396,'Q11 Anoftalmía, microftalmía y macroftalmía')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (397,'Q12 Malformaciones congénitas del cristalino')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (398,'Q13 Malformaciones congénitas del segmento anterior del ojo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (399,'Q14 Malformaciones congénitas del segmento posterior del ojo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (400,'Q15 Otras malformaciones congénitas del ojo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (401,'Q16 Malformaciones congénitas del oído que causan alteración de la audición')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (402,'Q17 Otras malformaciones congénitas del oído')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (403,'Q18 Otras malformaciones congénitas de la cara y del cuello')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (404,'Q20 Malformaciones congénitas de las cámaras cardíacas y sus conexiones')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (405,'Q21 Malformaciones congénitas de los tabiques cardíacos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (406,'Q22 Malformaciones congénitas de las válvulas pulmonar y tricúspide')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (407,'Q23 Malformaciones congénitas de las válvulas aórtica y mitral')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (408,'Q24 Otras malformaciones congénitas del corazón')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (409,'Q25 Malformaciones congénitas de las grandes arterias')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (410,'Q26 Malformaciones congénitas de las grandes venas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (411,'Q27 Otras malformaciones congénitas del sistema vascular periférico')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (412,'Q28 Otras malformaciones congénitas del sistema circulatorio')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (413,'Q30 Malformaciones congénitas de la nariz')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (414,'Q31 Malformaciones congénitas de la laringe')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (415,'Q32 Malformaciones congénitas de la tráquea y de los bronquios')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (416,'Q33 Malformaciones congénitas del pulmón')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (417,'Q34 Otras malformaciones congénitas del sistema respiratorio')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (418,'Q35 Fisura del paladar')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (419,'Q36 Labio leporino')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (420,'Q37 Fisura del paladar con labio leporino')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (421,'Q38 Otras malformaciones congénitas de la lengua, de la boca y de la faringe')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (422,'Q39 Malformaciones congénitas del esófago')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (423,'Q40 Otras malformaciones congénitas de la parte superior del tubo digestivo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (424,'Q41 Ausencia, atresia y estenosis congénita del intestino delgado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (425,'Q42 Ausencia, atresia y estenosis congénita del intestino grueso')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (426,'Q43 Otras malformaciones congénitas del intestino')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (427,'Q44 Malformaciones congénitas de la vesícula biliar, de los conductos biliares y  del hígado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (428,'Q45 Otras malformaciones congénitas del sistema digestivo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (429,'Q50 Malformaciones congénitas de los ovarios, de las trompas de Falopio y de los ligamentos anchos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (430,'Q51 Malformaciones congénitas del útero y del cuello uterino')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (431,'Q52 Otras malformaciones congénitas de los órganos genitales femeninos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (432,'Q53 Testículo no descendido')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (433,'Q54 Hipospadias')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (434,'Q55 Otras malformaciones congénitas de los órganos genitales masculinos')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (435,'Q56 Sexo indeterminado y seudohermafroditismo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (436,'Q60 Agenesia renal y otras malformaciones hipoplásicas del riñón')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (437,'Q61 Enfermedad quística del riñón')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (438,'Q62 Defectos obstructivos congénitos de la pelvis renal y malformaciones  congénitas del uréter')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (439,'Q63 Otras malformaciones congénitas del riñón')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (440,'Q64 Otras malformaciones congénitas del sistema urinario')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (441,'Q65 Deformidades congénitas de la cadera')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (442,'Q66 Deformidades congénitas de los pies')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (443,'Q67 Deformidades osteomusculares congénitas de la cabeza, de la cara, de la  columna vertebral y del tórax')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (444,'Q68 Otras deformidades osteomusculares congénitas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (445,'Q69 Polidactilia')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (446,'Q70 Sindactilia')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (447,'Q71 Defectos por reducción del miembro superior')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (448,'Q72 Defectos por reducción del miembro inferior')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (449,'Q73 Defectos por reducción de miembro no especificado')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (450,'Q74 Otras anomalías congénitas del (de los) miembro(s)')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (451,'Q75 Otras malformaciones congénitas de los huesos del cráneo y de la cara')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (452,'Q76 Malformaciones congénitas de la columna vertebral y tórax óseo')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (453,'Q77 Osteocondrodisplasia con defecto del crecimiento de los huesos largos y de la columna vertebral')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (454,'Q78 Otras osteocondrodisplasias')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (455,'Q79 Malformaciones congénitas del sistema osteomuscular, no clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (456,'Q80 Ictiosis congénita')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (457,'Q81 Epidermólisis bullosa')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (458,'Q82 Otras malformaciones congénitas de la piel')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (459,'Q83 Malformaciones congénitas de la mama')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (460,'Q84 Otras malformaciones congénitas de las faneras')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (461,'Q85 Facomatosis, no clasificada en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (462,'Q86 Síndromes de malformaciones congénitas debidos a causas exógenas conocidas, no  clasificados en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (463,'Q87 Otros síndromes de malformaciones congénitas especificados que afectan múltiples sistemas')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (464,'Q89 Otras malformaciones congénitas, no clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (465,'Q90 Síndrome de Down')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (466,'Q91 Síndrome de Edwards y síndrome de Patau')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (467,'Q92 Otras trisomías y trisomías parciales de los autosomas, no clasificadas en otra  parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (468,'Q93 Monosomías y supresiones de los autosomas, no clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (469,'Q95 Reordenamientos equilibrados y marcadores estructurales, no clasificados en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (470,'Q96 Síndrome de Turner')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (471,'Q97 Otras anomalías de los cromosomas sexuales, con fenotipo femenino, no clasificadas en otra parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (472,'Q98 Otras anomalías de los cromosomas sexuales, con fenotipo masculino, no clasificadas en otra  parte')
    ","insert into diag_neurologico_cie_10 (id,nombre) values (473,'Q99 Otras anomalías cromosómicas, no clasificadas en otra parte')"];
    foreach ($arr as $key => $value) {
        $x->executeQuery($value);
    }
     /*
 
    print_r($x->executeQuery("delete from centro_atencion"));
    $arr = ["insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (1,3 , 'ENT002' , 'INABIF' , 'SER007' , '070101' , 'CNNA101' , 'HOGAR SAN ANTONIO' , 'LOS ROBLES S/N- 4TA. CDRA.URB. JARDINES DE VIRÚ.' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (2,3 , 'ENT002' , 'INABIF' , 'SER007' , '150136' , 'CNNA102' , 'HOGAR ERMELINDA CARRERA' , 'AV. LA PAZ 535 - 539' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (3,3 , 'ENT002' , 'INABIF' , 'SER007' , '150136' , 'CNNA103' , 'HOGAR DIVINO JESÚS' , 'AV. LIMA CDRA. 9 S/N ALT. CDRA. 4 DE LA AV. UNIVERSITARIA' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (4,3 , 'ENT002' , 'INABIF' , 'SER007' , '150121' , 'CNNA104' , 'HOGAR ARCO IRIS' , 'BELISARIO BARRIGA 115' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (5,3 , 'ENT002' , 'INABIF' , 'SER007' , '150136' , 'CNNA105' , 'CASAS HOGAR SAN MIGUEL ARCÁNGEL' , 'AV. LIBERTAD  2091(1,1,1)-  2093(2)- 2099(3)- 2097(4)- 2095(5)' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (6,3 , 'ENT002' , 'INABIF' , 'SER007' , '070101' , 'CNNA106' , 'CASA DE LA MUJER Y PROMOCIÓN COMUNAL SANTA ROSA' , 'JR. IQUITOS S/N 2DA. URB. SANTA ROSA' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (7,3 , 'ENT002' , 'INABIF' , 'SER007' , '150117' , 'CNNA107' , 'CASAS HOGAR SAGRADO CORAZÓN' , 'URB. EL NARANJAL 2DA. ETAPA ' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (8,3 , 'ENT002' , 'INABIF' , 'SER007' , '150103' , 'CNNA108' , 'HOGAR ALDEA INFANTIL SAN RICARDO' , 'AV. PEDRO RUIZ GALLO 1485' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (9,3 , 'ENT002' , 'INABIF' , 'SER007' , '150103' , 'CNNA109' , 'HOGAR CASA ESTANCIA DOMI' , 'AV. EVITAMIENTO 931- SALAMANCA' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (10,3 , 'ENT002' , 'INABIF' , 'SER007' , '150108' , 'CNNA110' , 'HOGAR NIÑO JESUS DE PRAGA - CHORRILLOS' , 'AV. GUARDIA PERUANA MZ15 LOTE 16' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (11,3 , 'ENT002' , 'INABIF' , 'SER007' , '150121' , '' , 'HOGAR LAZOS DE AMOR' , 'AV. SAN MARTÍN 685' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 0)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (12,3 , 'ENT002' , 'INABIF' , 'SER007' , '150135' , 'CNNA111' , 'HOGAR GRACIA' , 'PASAJE LOS LEONES N° 145' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (13,3 , 'ENT002' , 'INABIF' , 'SER007' , '021809' , 'CNNA201' , 'HOGAR SAN PEDRITO' , 'AV. LOS ALCATRACES S/N ZONA DE EQUIPAMIENTO  MZ. C , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (14,3 , 'ENT002' , 'INABIF' , 'SER007' , '040101' , 'CNNA202' , 'HOGAR SAN LUIS GONZAGA' , 'AV. ALFONSO UGARTE S/N CERCADO' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (15,3 , 'ENT002' , 'INABIF' , 'SER007' , '40122' , 'CNNA203' , 'SAN JOSÉ AREQUIPA 2' , 'AV. SALAVERRY S/N LARA (AL COSTADO DEL COLEGIO SANTISIMO SALVADOR)' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (16,3 , 'ENT002' , 'INABIF' , 'SER007' , '050101' , 'CNNA204' , 'HOGAR URPI' , 'AV. INDEPENDENCIA 600  CDRA. 6' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (17,3 , 'ENT002' , 'INABIF' , 'SER007' , '080101' , 'CNNA205' , 'HOGAR BUEN PASTOR' , 'AV. MANZANARES S/N URB.  MANUEL PRADO' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (18,3 , 'ENT002' , 'INABIF' , 'SER007' , '080106' , 'CNNA206' , 'HOGAR JESÚS MI LUZ' , 'AV. FRANCISCO BOLOGNESI S/N EX BOSQUE CCORIPATA ' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (19,3 , 'ENT002' , 'INABIF' , 'SER007' , '080910' , 'CNNA207' , 'HOGAR ESPERANZA DE PICHARI' , 'CALLE SEÑOR DE LOS MILAGROS MZ A LT 1' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (20,3 , 'ENT002' , 'INABIF' , 'SER007' , '100601' , 'CNNA208' , 'HOGAR SANTA TERESITA DEL NIÑO JESÚS' , 'JR. MANCO CAPAC S/N' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (21,3 , 'ENT002' , 'INABIF' , 'SER007' , '100101' , 'CNNA209' , 'HOGAR PILLCO MOZO' , 'JR. DOS DE MAYO Nº 900 ' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (22,3 , 'ENT002' , 'INABIF' , 'SER007' , '110101' , 'CNNA210' , 'HOGAR SEÑOR DE LUREN' , 'CASERIO DE CACHICHE S/N' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (23,3 , 'ENT002' , 'INABIF' , 'SER007' , '110201' , 'CNNA211' , 'HOGAR PAÚL HARRIS' , 'AV. CAMINO REAL Nº 900- SECTOR HIJAYA' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (24,3 , 'ENT002' , 'INABIF' , 'SER007' , '120114' , 'CNNA212' , 'HOGAR ANDRÉS AVELINO CÁCERES' , 'PROLONGACIÓN TRUJILLO 271' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (25,3 , 'ENT002' , 'INABIF' , 'SER007' , '130111' , 'CNNA213' , 'HOGAR LA NIÑA' , 'CALLE R.V. PELLETIER 256' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (26,3 , 'ENT002' , 'INABIF' , 'SER007' , '130101' , 'CNNA214' , 'HOGAR SAN JOSÉ' , 'AV. GONZÁLES PRADO 705 URB. SANTA MARIA I ETAPA' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (27,3 , 'ENT002' , 'INABIF' , 'SER007' , '140101' , 'CNNA215' , 'HOGAR ROSA MARÍA CHECA' , 'AV. SALAVERRY S/N KM. 1' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (28,3 , 'ENT002' , 'INABIF' , 'SER007' , '140101' , 'CNNA216' , 'HOGAR SAN VICENTE DE PAÚL' , 'CALLE FRANCISCO CABRERA 1283' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (29,3 , 'ENT002' , 'INABIF' , 'SER007' , '140112' , 'CNNA217' , 'HOGAR SAN JUAN BOSCO' , 'PIMENTEL KM. 10 CARRETERA A PIMENTEL' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (30,3 , 'ENT002' , 'INABIF' , 'SER007' , '160108' , 'CNNA218' , 'HOGAR PADRE ANGEL RODRÍGUEZ' , 'AV. 28 DE JULIO 500' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (31,3 , 'ENT002' , 'INABIF' , 'SER007' , '160108' , 'CNNA219' , 'HOGAR CASA DE ACOGIDA SANTA LORENA' , 'AV. 28 DE JULIO 500' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (32,3 , 'ENT002' , 'INABIF' , 'SER007' , '210101' , 'CNNA220' , 'HOGAR VÍRGEN DE FÁTIMA' , 'AV. SIDERAL 241 BARRIO CHEJOÑA' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (33,3 , 'ENT002' , 'INABIF' , 'SER007' , '210101' , 'CNNA221' , 'HOGAR SAN MARTÍN DE PORRES' , 'YANAMAYO S/N ALTO PUNO' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (34,3 , 'ENT002' , 'INABIF' , 'SER007' , '211101' , 'CNNA222' , 'HOGAR SAGRADO CORAZÓN DE JESÚS' , 'JR. MANUEL PRADO S/N' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (35,3 , 'ENT002' , 'INABIF' , 'SER007' , '230101' , 'CNNA223' , 'HOGAR SANTO DOMINGO SAVIO' , 'AV. PINTO 2482 - LA NATIVIDAD' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (36,3 , 'ENT002' , 'INABIF' , 'SER007' , '140105' , 'CNNA224' , 'HOGAR MEDALLA MILAGROSA' , 'CALLE TUMBES 939' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (37,3 , 'ENT002' , 'INABIF' , 'SER007' , '180101' , 'CNNA225' , 'CAR SANTA FORTUNATA' , 'AV. SANTA FORTUNATA S/N, CENTRO POBLADO SAN ANTONIO' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (38,3 , 'ENT002' , 'INABIF' , 'SER007' , '120114' , 'CNNA226' , 'CAR VIDAS - JUNÍN' , 'PROLONGACIÓN TRUJILLO 271, EL TAMBO' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (39,3 , 'ENT002' , 'INABIF' , 'SER007' , '160108' , 'CNNA227' , 'CAR VIDAS - LORETO' , 'AV. 28 DE JULIO N° 500, PUNCHANA' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (40,3 , 'ENT002' , 'INABIF' , 'SER007' , '150136' , 'CNNA112' , 'CAR VIDAS - LIMA' , 'JR. CASTILLA N°501' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (41,3 , 'ENT002' , 'INABIF' , 'SER007' , '170102' , 'CNNA228' , 'CAR FLORECER' , 'JR. FRANSCISCO BOLOGNESI S/N' , 'URBANO' , 'LIN001' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (42,1 , 'ENT002' , 'INABIF' , 'SER009' , '150102' , 'CPCD101' , 'HOGAR NIÑO JESÚS DE PRAGA' , 'PLAYA LAS CONCHITAS S/N-ANCÓN' , 'URBANO' , 'LIN003' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE CON DISCAPACIDAD EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPPD' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (43,1 , 'ENT002' , 'INABIF' , 'SER009' , '150101' , 'CPCD102' , 'HOGAR SAN FRANCISCO DE ASÍS' , 'SANTA BERNARDITA CDRA. 3 S/N - PANDO' , 'URBANO' , 'LIN003' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE CON DISCAPACIDAD EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPPD' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (44,1 , 'ENT002' , 'INABIF' , 'SER009' , '150136' , 'CPCD103' , 'HOGAR RENACER' , 'JR. CASTILLA N° 509-SAN MIGUEL' , 'URBANO' , 'LIN003' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE CON DISCAPACIDAD EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPPD' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (45,1 , 'ENT002' , 'INABIF' , 'SER009' , '150136' , 'CPCD104' , 'HOGAR MATÍLDE PÉREZ PALACIOS' , 'CALLE SANTA ANA-CUADRA 8 S/N-SAN MIGUEL' , 'URBANO' , 'LIN003' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE CON DISCAPACIDAD EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPPD' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (46,1 , 'ENT002' , 'INABIF' , 'SER009' , '150136' , 'CPCD105' , 'HOGAR ESPERANZA' , 'JR. CASTILLA N° 509-SAN MIGUEL' , 'URBANO' , 'LIN003' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE CON DISCAPACIDAD EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPPD' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (47,1 , 'ENT002' , 'INABIF' , 'SER009' , '150121' , 'CPCD106' , 'ASOCIACIÓN DE LAS BIENAVENTURANZAS' , 'CALLE SANTA ROSA N° 900 TABLADA DE LURIN' , 'URBANO' , 'LIN003' , 'PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE CON DISCAPACIDAD EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL - USPPD' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (48,2 , 'ENT002' , 'INABIF' , 'SER008' , '150136' , 'CPAM101' , 'HOGAR VIRGEN DEL CARMEN' , 'JR. CASTILLA 501 - 509' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ATENCIÓN RESIDENCIAL - USPPAM' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (49,2 , 'ENT002' , 'INABIF' , 'SER008' , '150109' , 'CPAM102' , 'HOGAR CIENEGUILLA' , 'MALECÓN LURÍN, MZ J-2' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ATENCIÓN RESIDENCIAL - USPPAM' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (50,2 , 'ENT002' , 'INABIF' , 'SER008' , '150101' , 'CPAM103' , 'CAR HOGAR SAN VICENTE DE PAÚL' , 'JR. ANCASH N° 1595' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ATENCIÓN RESIDENCIAL - USPPAM' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (51,2 , 'ENT002' , 'INABIF' , 'SER008' , '150101' , 'CPAM104' , 'CAR HOGAR CANEVARO' , 'JR. MADERA N° 265' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ATENCIÓN RESIDENCIAL - USPPAM' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (52,2 , 'ENT002' , 'INABIF' , 'SER008' , '150130' , '' , 'CAR  PRIVADO NAZARENO' , 'SALVADOR DALI N° 490 -SAN BORJA' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ATENCIÓN RESIDENCIAL - USPPAM' , 0)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (53,3 , 'ENT002' , 'INABIF' , 'SER007' , '070101' , 'UNNA101' , 'CAR SANTA ROSA N° 01' , 'JR. IQUITOS S/N 2DA. URB. SANTA ROSA (ALT. CDRA. 34 AV. ARGENTINA)' , 'URBANO' , 'LIN003' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL DE URGENCIA - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (54,3 , 'ENT002' , 'INABIF' , 'SER007' , '070101' , 'UNNA102' , 'CAR SANTA ROSA N° 02' , 'JR. IQUITOS S/N 2DA. URB. SANTA ROSA (ALT. CDRA. 34 AV. ARGENTINA)' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL DE URGENCIA - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (55,3 , 'ENT002' , 'INABIF' , 'SER007' , '070101' , 'UNNA103' , 'CAR CASA ISABEL I' , 'AV. SALAVERRY S/N LARA (AL COSTADO DEL COLEGIO SANTISIMO SALVADOR)' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL DE URGENCIA - USPNNA' , 1,1,1)",
    "insert into centro_atencion (id,centro_id , codigo_entidad , nombre_entidad , cod_serv , ubigeo , cod_ca , nom_ca , direccion_car , area_residencia , codigo_linea , linea_intervencion , nom_serv , estado,usuario_crea,usuario_edita) values (56,3 , 'ENT002' , 'INABIF' , 'SER007' , '070101' , 'UNNA104' , 'CAR CASA ISABEL II' , 'AV. SALAVERRY S/N LARA (AL COSTADO DEL COLEGIO SANTISIMO SALVADOR)' , 'URBANO' , 'LIN002' , 'PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO' , 'CENTRO DE ACOGIDA RESIDENCIAL DE URGENCIA - USPNNA' , 1,1,1)"];
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
