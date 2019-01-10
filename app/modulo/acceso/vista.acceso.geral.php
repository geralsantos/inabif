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

    $arr = ["insert into diag_agudo_cie_10   (id,nombre) values (1,'A00 Cólera')
        ","insert into diag_agudo_cie_10   (id,nombre) values (2,'A01 Fiebres tifoidea y paratifoidea')
        ","insert into diag_agudo_cie_10   (id,nombre) values (3,'A02 Otras infecciones debidas a Salmonella')
        ","insert into diag_agudo_cie_10   (id,nombre) values (4,'A03 Shigelosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (5,'A04 Otras infecciones intestinales bacterianas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (6,'A05 Otras intoxicaciones alimentarias bacterianas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (7,'A06 Amebiasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (8,'A07 Otras enfermedades intestinales debidas a protozoarios')
        ","insert into diag_agudo_cie_10   (id,nombre) values (9,'A08 Infecciones intestinales debidas a virus y otros organismos especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (10,'A09 Diarrea y gastroenteritis de presunto origen infeccioso')
        ","insert into diag_agudo_cie_10   (id,nombre) values (11,'A15 Tuberculosis respiratoria, confirmada bacteriológica e histológicamente')
        ","insert into diag_agudo_cie_10   (id,nombre) values (12,'A16 Tuberculosis respiratoria, no confirmada bacteriológica o histológicamente')
        ","insert into diag_agudo_cie_10   (id,nombre) values (13,'A17.+ Tuberculosis del sistema nervioso')
        ","insert into diag_agudo_cie_10   (id,nombre) values (14,'A18 Tuberculosis de otros órganos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (15,'A19 Tuberculosis miliar')
        ","insert into diag_agudo_cie_10   (id,nombre) values (16,'A20 Peste')
        ","insert into diag_agudo_cie_10   (id,nombre) values (17,'A21 Tularemia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (18,'A22 Carbunco [ántrax]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (19,'A23 Brucelosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (20,'A24 Muermo y melioidosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (21,'A25 Fiebres por mordedura de rata')
        ","insert into diag_agudo_cie_10   (id,nombre) values (22,'A26 Erisipeloide')
        ","insert into diag_agudo_cie_10   (id,nombre) values (23,'A27 Leptospirosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (24,'A28 Otras enfermedades zoonóticas bacterianas, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (25,'A30 Lepra [enfermedad de Hansen]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (26,'A31 Infecciones debidas a otras micobacterias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (27,'A32 Listeriosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (28,'A33 Tétanos neonatal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (29,'A34 Tétanos obstétrico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (30,'A35 Otros tétanos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (31,'A36 Difteria')
        ","insert into diag_agudo_cie_10   (id,nombre) values (32,'A37 Tos ferina [tos convulsiva]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (33,'A38 Escarlatina')
        ","insert into diag_agudo_cie_10   (id,nombre) values (34,'A39 Infección meningocócica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (35,'A40 Septicemia estreptocócica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (36,'A41 Otras septicemias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (37,'A42 Actinomicosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (38,'A43 Nocardiosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (39,'A44 Bartonelosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (40,'A46 Erisipela')
        ","insert into diag_agudo_cie_10   (id,nombre) values (41,'A48 Otras enfermedades bacterianas, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (42,'A49 Infección bacteriana de sitio no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (43,'A50 Sífilis congénita')
        ","insert into diag_agudo_cie_10   (id,nombre) values (44,'A51 Sífilis precoz')
        ","insert into diag_agudo_cie_10   (id,nombre) values (45,'A52 Sífilis tardía')
        ","insert into diag_agudo_cie_10   (id,nombre) values (46,'A53 Otras sífilis y las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (47,'A54 Infección gonocócica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (48,'A55 Linfogranuloma (venéreo) por clamidias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (49,'A56 Otras enfermedades de transmisión sexual debidas a clamidias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (50,'A57 Chancro blando')
        ","insert into diag_agudo_cie_10   (id,nombre) values (51,'A58 Granuloma inguinal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (52,'A59 Tricomoniasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (53,'A60 Infección anogenital debida a virus del herpes [herpes simple]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (54,'A63 Otras enfermedades de transmisión predominantemente sexual, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (55,'A64 Enfermedad de transmisión sexual no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (56,'A65 Sífilis no venérea')
        ","insert into diag_agudo_cie_10   (id,nombre) values (57,'A66 Frambesia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (58,'A67 Pinta [carate]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (59,'A68 Fiebres recurrentes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (60,'A69 Otras infecciones causadas por espiroquetas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (61,'A70 Infección debida a Chlamydia psittaci')
        ","insert into diag_agudo_cie_10   (id,nombre) values (62,'A71 Tracoma')
        ","insert into diag_agudo_cie_10   (id,nombre) values (63,'A74 Otras enfermedades causadas por clamidias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (64,'A75 Tifus')
        ","insert into diag_agudo_cie_10   (id,nombre) values (65,'A77 Fiebre maculosa [rickettsiosis transmitida por garrapatas]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (66,'A78 Fiebre Q')
        ","insert into diag_agudo_cie_10   (id,nombre) values (67,'A79 Otras rickettsiosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (68,'A80 Poliomielitis aguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (69,'A81 Infecciones del sistema nervioso central por virus atípico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (70,'A82 Rabia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (71,'A83 Encefalitis viral transmitida por mosquitos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (72,'A84 Encefalitis viral transmitida por garrapatas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (73,'A85 Otras encefalitis virales, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (74,'A86 Encefalitis viral, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (75,'A87 Meningitis viral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (76,'A88 Otras infecciones virales del sistema nervioso central, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (77,'A89 Infección viral del sistema nervioso central, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (78,'A90 Fiebre del dengue [dengue clásico]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (79,'A91 Fiebre del dengue hemorrágico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (80,'A92 Otras fiebres virales transmitidas por mosquitos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (81,'A93 Otras fiebres virales transmitidas por artrópodos, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (82,'A94 Fiebre viral transmitida por artrópodos, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (83,'A95 Fiebre amarilla')
        ","insert into diag_agudo_cie_10   (id,nombre) values (84,'A96 Fiebre hemorrágica por arenavirus')
        ","insert into diag_agudo_cie_10   (id,nombre) values (85,'A98 Otras fiebres virales hemorrágicas, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (86,'A99 Fiebre viral hemorrágica, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (87,'B00 Infecciones herpéticas [herpes simple]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (88,'B01 Varicela')
        ","insert into diag_agudo_cie_10   (id,nombre) values (89,'B02 Herpes zoster')
        ","insert into diag_agudo_cie_10   (id,nombre) values (90,'B03 Viruela')
        ","insert into diag_agudo_cie_10   (id,nombre) values (91,'B04 Viruela de los monos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (92,'B05 Sarampión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (93,'B06 Rubéola [sarampión alemán]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (94,'B07 Verrugas víricas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (95,'B08 Otras infecciones víricas caracterizadas por lesiones de la piel y de las membranas mucosas, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (96,'B09 Infección viral no especificada, caracterizada por lesiones de la piel y de las membranas mucosas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (97,'B15 Hepatitis aguda tipo A')
        ","insert into diag_agudo_cie_10   (id,nombre) values (98,'B16 Hepatitis aguda tipo B')
        ","insert into diag_agudo_cie_10   (id,nombre) values (99,'B17 Otras hepatitis virales agudas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (100,'B18 Hepatitis viral crónica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (101,'B19 Hepatitis viral, sin otra especificación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (102,'B20 Enfermedad por virus de la inmunodeficiencia humana [VIH], resultante en enfermedades infecciosas y parasitarias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (103,'B21 Enfermedad por virus de la inmunodeficiencia humana [VIH], resultante en tumores malignos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (104,'B22 Enfermedad por virus de la inmunodeficiencia humana [VIH], resultante en otras enfermedades especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (105,'B23 Enfermedad por virus de la inmunodeficiencia humana [VIH], resultante en otras afecciones')
        ","insert into diag_agudo_cie_10   (id,nombre) values (106,'B24 Enfermedad por virus de la inmunodeficiencia humana [VIH], sin otra especificación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (107,'B25 Enfermedad debida a virus citomegálico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (108,'B26 Parotiditis infecciosa')
        ","insert into diag_agudo_cie_10   (id,nombre) values (109,'B27 Mononucleosis infecciosa')
        ","insert into diag_agudo_cie_10   (id,nombre) values (110,'B30 Conjuntivitis viral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (111,'B33 Otras enfermedades virales, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (112,'B34 Infección viral de sitio no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (113,'B35 Dermatofitosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (114,'B36 Otras micosis superficiales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (115,'B37 Candidiasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (116,'B38 Coccidioidomicosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (117,'B39 Histoplasmosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (118,'B40 Blastomicosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (119,'B41 Paracoccidioidomicosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (120,'B42 Esporotricosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (121,'B43 Cromomicosis y absceso feomicótico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (122,'B44 Aspergilosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (123,'B45 Criptococosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (124,'B46 Cigomicosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (125,'B47 Micetoma')
        ","insert into diag_agudo_cie_10   (id,nombre) values (126,'B48 Otras micosis, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (127,'B49 Micosis, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (128,'B50 Paludismo [malaria] debido a Plasmodium falciparum')
        ","insert into diag_agudo_cie_10   (id,nombre) values (129,'B51 Paludismo [malaria] debido a Plasmodium vivax')
        ","insert into diag_agudo_cie_10   (id,nombre) values (130,'B52 Paludismo [malaria] debido a Plasmodium malariae')
        ","insert into diag_agudo_cie_10   (id,nombre) values (131,'B53 Otro paludismo [malaria] confirmado parasitológicamente')
        ","insert into diag_agudo_cie_10   (id,nombre) values (132,'B54 Paludismo [malaria] no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (133,'B55 Leishmaniasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (134,'B56 Tripanosomiasis africana')
        ","insert into diag_agudo_cie_10   (id,nombre) values (135,'B57 Enfermedad de Chagas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (136,'B58 Toxoplasmosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (137,'B59+ Neumocistosis (J17.3*)')
        ","insert into diag_agudo_cie_10   (id,nombre) values (138,'B60 Otras enfermedades debidas a protozoarios, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (139,'B64 Enfermedad debida a protozoarios, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (140,'B65 Esquistosomiasis [bilharziasis]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (141,'B66 Otras infecciones debidas a trematodos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (142,'B67 Equinococosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (143,'B68 Teniasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (144,'B69 Cisticercosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (145,'B70 Difilobotriasis y esparganosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (146,'B71 Otras infecciones debidas a cestodos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (147,'B72 Dracontiasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (148,'B73 Oncocercosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (149,'B74 Filariasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (150,'B75 Triquinosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (151,'B76 Anquilostomiasis y necatoriasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (152,'B77 Ascariasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (153,'B78 Estrongiloidiasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (154,'B79 Tricuriasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (155,'B80 Enterobiasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (156,'B81 Otras helmintiasis intestinales, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (157,'B82 Parasitosis intestinales, sin otra especificación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (158,'B83 Otras helmintiasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (159,'B85 Pediculosis y phthiriasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (160,'B86 Escabiosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (161,'B87 Miasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (162,'B88 Otras infestaciones')
        ","insert into diag_agudo_cie_10   (id,nombre) values (163,'B89 Enfermedad parasitaria, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (164,'B90 Secuelas de tuberculosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (165,'B91 Secuelas de poliomielitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (166,'B92 Secuelas de lepra')
        ","insert into diag_agudo_cie_10   (id,nombre) values (167,'B94 Secuelas de otras enfermedades infecciosas y parasitarias y de las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (168,'B95 Estreptococos y estafilococos como causa de enfermedades clasificadas en otros capítulos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (169,'B96 Otros agentes bacterianos como causa de enfermedades clasificadas en otros capítulos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (170,'B97 Agentes virales como causa de enfermedades clasificadas en otros capítulos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (171,'B99 Otras enfermedades infecciosas y las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (172,'C00 Tumor maligno del labio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (173,'C01 Tumor maligno de la base de la lengua')
        ","insert into diag_agudo_cie_10   (id,nombre) values (174,'C02 Tumor maligno de otras partes y de las no especificadas de la lengua')
        ","insert into diag_agudo_cie_10   (id,nombre) values (175,'C03 Tumor maligno de la encía')
        ","insert into diag_agudo_cie_10   (id,nombre) values (176,'C04 Tumor maligno del piso de la boca')
        ","insert into diag_agudo_cie_10   (id,nombre) values (177,'C05 Tumor maligno del paladar')
        ","insert into diag_agudo_cie_10   (id,nombre) values (178,'C06 Tumor maligno de otras partes y de las no especificadas de la boca')
        ","insert into diag_agudo_cie_10   (id,nombre) values (179,'C07 Tumor maligno de la glándula parótida')
        ","insert into diag_agudo_cie_10   (id,nombre) values (180,'C08 Tumor maligno de otras glándulas salivales mayores y de las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (181,'C09 Tumor maligno de la amígdala')
        ","insert into diag_agudo_cie_10   (id,nombre) values (182,'C10 Tumor maligno de la orofaringe')
        ","insert into diag_agudo_cie_10   (id,nombre) values (183,'C11 Tumor maligno de la nasofaringe')
        ","insert into diag_agudo_cie_10   (id,nombre) values (184,'C12 Tumor maligno del seno piriforme')
        ","insert into diag_agudo_cie_10   (id,nombre) values (185,'C13 Tumor maligno de la hipofaringe')
        ","insert into diag_agudo_cie_10   (id,nombre) values (186,'C14 Tumor maligno de otros sitios y de los mal definidos del labio, de la cavidad bucal y de la faringe')
        ","insert into diag_agudo_cie_10   (id,nombre) values (187,'C15 Tumor maligno del esófago')
        ","insert into diag_agudo_cie_10   (id,nombre) values (188,'C16 Tumor maligno del estómago')
        ","insert into diag_agudo_cie_10   (id,nombre) values (189,'C17 Tumor maligno del intestino delgado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (190,'C18 Tumor maligno del colon')
        ","insert into diag_agudo_cie_10   (id,nombre) values (191,'C19 Tumor maligno de la unión rectosigmoidea')
        ","insert into diag_agudo_cie_10   (id,nombre) values (192,'C20 Tumor maligno del recto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (193,'C21 Tumor maligno del ano y del conducto anal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (194,'C22 Tumor maligno del hígado y de las vías biliares intrahepáticas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (195,'C23 Tumor maligno de la vesícula biliar')
        ","insert into diag_agudo_cie_10   (id,nombre) values (196,'C24 Tumor maligno de otras partes y de las no especificadas de las vías biliares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (197,'C25 Tumor maligno del páncreas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (198,'C26 Tumor maligno de otros sitios y de los mal definidos de los órganos digestivos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (199,'C30 Tumor maligno de las fosas nasales y del oído medio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (200,'C31 Tumor maligno de los senos paranasales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (201,'C32 Tumor maligno de la laringe')
        ","insert into diag_agudo_cie_10   (id,nombre) values (202,'C33 Tumor maligno de la tráquea')
        ","insert into diag_agudo_cie_10   (id,nombre) values (203,'C34 Tumor maligno de los bronquios y del pulmón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (204,'C37 Tumor maligno del timo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (205,'C38 Tumor maligno del corazón, del mediastino y de la pleura')
        ","insert into diag_agudo_cie_10   (id,nombre) values (206,'C39 Tumor maligno de otros sitios y de los mal definidos del sistema respiratorio y de los órganos intratorácicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (207,'C40 Tumor maligno de los huesos y de los cartílagos articulares de los miembros')
        ","insert into diag_agudo_cie_10   (id,nombre) values (208,'C41 Tumor maligno de los huesos y de los cartílagos articulares, de otros sitios y de sitios no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (209,'C43 Melanoma maligno de la piel')
        ","insert into diag_agudo_cie_10   (id,nombre) values (210,'C44 Otros tumores malignos de la piel')
        ","insert into diag_agudo_cie_10   (id,nombre) values (211,'C45 Mesotelioma')
        ","insert into diag_agudo_cie_10   (id,nombre) values (212,'C46 Sarcoma de Kaposi')
        ","insert into diag_agudo_cie_10   (id,nombre) values (213,'C47 Tumor maligno de los nervios periféricos y del sistema nervioso autónomo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (214,'C48 Tumor maligno del peritoneo y del retroperitoneo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (215,'C49 Tumor maligno de otros tejidos conjuntivos y de tejidos blandos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (216,'C50 Tumor maligno de la mama')
        ","insert into diag_agudo_cie_10   (id,nombre) values (217,'C51 Tumor maligno de la vulva')
        ","insert into diag_agudo_cie_10   (id,nombre) values (218,'C52 Tumor maligno de la vagina')
        ","insert into diag_agudo_cie_10   (id,nombre) values (219,'C53 Tumor maligno del cuello del útero')
        ","insert into diag_agudo_cie_10   (id,nombre) values (220,'C54 Tumor maligno del cuerpo del útero')
        ","insert into diag_agudo_cie_10   (id,nombre) values (221,'C55 Tumor maligno del útero, parte no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (222,'C56 Tumor maligno del ovario')
        ","insert into diag_agudo_cie_10   (id,nombre) values (223,'C57 Tumor maligno de otros órganos genitales femeninos y de los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (224,'C58 Tumor maligno de la placenta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (225,'C60 Tumor maligno del pene')
        ","insert into diag_agudo_cie_10   (id,nombre) values (226,'C61 Tumor maligno de la próstata')
        ","insert into diag_agudo_cie_10   (id,nombre) values (227,'C62 Tumor maligno del testículo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (228,'C63 Tumor maligno de otros órganos genitales masculinos y de los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (229,'C64 Tumor maligno del riñón, excepto de la pelvis renal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (230,'C65 Tumor maligno de la pelvis renal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (231,'C66 Tumor maligno del uréter')
        ","insert into diag_agudo_cie_10   (id,nombre) values (232,'C67 Tumor maligno de la vejiga urinaria')
        ","insert into diag_agudo_cie_10   (id,nombre) values (233,'C68 Tumor maligno de otros órganos urinarios y de los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (234,'C69 Tumor maligno del ojo y sus anexos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (235,'C70 Tumor maligno de las meninges')
        ","insert into diag_agudo_cie_10   (id,nombre) values (236,'C71 Tumor maligno del encéfalo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (237,'C72 Tumor maligno de la médula espinal, de los nervios craneales y de otras partes del sistema nervioso central')
        ","insert into diag_agudo_cie_10   (id,nombre) values (238,'C73 Tumor maligno de la glándula tiroides')
        ","insert into diag_agudo_cie_10   (id,nombre) values (239,'C74 Tumor maligno de la glándula suprarrenal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (240,'C75 Tumor maligno de otras glándulas endocrinas y de estructuras afines')
        ","insert into diag_agudo_cie_10   (id,nombre) values (241,'C76 Tumor maligno de otros sitios y de sitios mal definidos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (242,'C77 Tumor maligno secundario y el no especificado de los ganglios linfáticos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (243,'C78 Tumor maligno secundario de los órganos respiratorios y digestivos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (244,'C79 Tumor maligno secundario de otros sitios')
        ","insert into diag_agudo_cie_10   (id,nombre) values (245,'C80 Tumor maligno de sitios no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (246,'C81 Enfermedad de Hodgkin')
        ","insert into diag_agudo_cie_10   (id,nombre) values (247,'C82 Linfoma no Hodgkin folicular [nodular]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (248,'C83 Linfoma no Hodgkin difuso')
        ","insert into diag_agudo_cie_10   (id,nombre) values (249,'C84 Linfoma de células T, periférico y cutáneo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (250,'C85 Linfoma no Hodgkin de otro tipo y el no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (251,'C88 Enfermedades inmunoproliferativas malignas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (252,'C90 Mieloma múltiple y tumores malignos de células plasmáticas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (253,'C91 Leucemia linfoide')
        ","insert into diag_agudo_cie_10   (id,nombre) values (254,'C92 Leucemia mieloide')
        ","insert into diag_agudo_cie_10   (id,nombre) values (255,'C93 Leucemia monocítica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (256,'C94 Otras leucemias de tipo celular especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (257,'C95 Leucemia de células de tipo no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (258,'C96 Otros tumores malignos y los no especificados del tejido linfático, de los órganos hematopoyéticos y de tejidos afines')
        ","insert into diag_agudo_cie_10   (id,nombre) values (259,'C97 Tumores malignos (primarios) de sitios múltiples independientes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (260,'D00 Carcinoma in situ de la cavidad bucal, del esófago y del estómago')
        ","insert into diag_agudo_cie_10   (id,nombre) values (261,'D01 Carcinoma in situ de otros órganos digestivos y de los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (262,'D02 Carcinoma in situ del sistema respiratorio y del oído medio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (263,'D03 Melanoma in situ')
        ","insert into diag_agudo_cie_10   (id,nombre) values (264,'D04 Carcinoma in situ de la piel')
        ","insert into diag_agudo_cie_10   (id,nombre) values (265,'D05 Carcinoma in situ de la mama')
        ","insert into diag_agudo_cie_10   (id,nombre) values (266,'D06 Carcinoma in situ del cuello del útero')
        ","insert into diag_agudo_cie_10   (id,nombre) values (267,'D07 Carcinoma in situ de otros órganos genitales y de los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (268,'D09 Carcinoma in situ de otros sitios y de los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (269,'D10 Tumor benigno de la boca y de la faringe')
        ","insert into diag_agudo_cie_10   (id,nombre) values (270,'D11 Tumor benigno de las glándulas salivales mayores')
        ","insert into diag_agudo_cie_10   (id,nombre) values (271,'D12 Tumor benigno del colon, del recto, del conducto anal y del ano')
        ","insert into diag_agudo_cie_10   (id,nombre) values (272,'D13 Tumor benigno de otras partes y de las mal definidas del sistema digestivo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (273,'D14 Tumor benigno del oído medio y del sistema respiratorio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (274,'D15 Tumor benigno de otros órganos intratorácicos y de los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (275,'D16 Tumor benigno del hueso y del cartílago articular')
        ","insert into diag_agudo_cie_10   (id,nombre) values (276,'D17 Tumores benignos lipomatosos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (277,'D18 Hemangioma y linfangioma de cualquier sitio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (278,'D19 Tumores benignos del tejido mesotelial')
        ","insert into diag_agudo_cie_10   (id,nombre) values (279,'D20 Tumor benigno del tejido blando del peritoneo y del retroperitoneo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (280,'D21 Otros tumores benignos del tejido conjuntivo y de los tejidos blandos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (281,'D22 Nevo melanocítico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (282,'D23 Otros tumores benignos de la piel')
        ","insert into diag_agudo_cie_10   (id,nombre) values (283,'D24 Tumor benigno de la mama')
        ","insert into diag_agudo_cie_10   (id,nombre) values (284,'D25 Leiomioma del útero')
        ","insert into diag_agudo_cie_10   (id,nombre) values (285,'D26 Otros tumores benignos del útero')
        ","insert into diag_agudo_cie_10   (id,nombre) values (286,'D27 Tumor benigno del ovario')
        ","insert into diag_agudo_cie_10   (id,nombre) values (287,'D28 Tumor benigno de otros órganos genitales femeninos y de los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (288,'D29 Tumor benigno de los órganos genitales masculinos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (289,'D30 Tumor benigno de los órganos urinarios')
        ","insert into diag_agudo_cie_10   (id,nombre) values (290,'D31 Tumor benigno del ojo y sus anexos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (291,'D32 Tumores benignos de las meninges')
        ","insert into diag_agudo_cie_10   (id,nombre) values (292,'D33 Tumor benigno del encéfalo y de otras partes del sistema nervioso central')
        ","insert into diag_agudo_cie_10   (id,nombre) values (293,'D34 Tumor benigno de la glándula tiroides')
        ","insert into diag_agudo_cie_10   (id,nombre) values (294,'D35 Tumor benigno de otras glándulas endocrinas y de las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (295,'D36 Tumor benigno de otros sitios y de los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (296,'D37 Tumor de comportamiento incierto o desconocido de la cavidad bucal y de los órganos digestivos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (297,'D38 Tumor de comportamiento incierto o desconocido del oído medio y de los órganos respiratorios e intratorácicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (298,'D39 Tumor de comportamiento incierto o desconocido de los órganos genitales femeninos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (299,'D40 Tumor de comportamiento incierto o desconocido de los órganos genitales masculinos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (300,'D41 Tumor de comportamiento incierto o desconocido de los órganos urinarios')
        ","insert into diag_agudo_cie_10   (id,nombre) values (301,'D42 Tumor de comportamiento incierto o desconocido de las meninges')
        ","insert into diag_agudo_cie_10   (id,nombre) values (302,'D43 Tumor de comportamiento incierto o desconocido del encéfalo y del sistema nervioso central')
        ","insert into diag_agudo_cie_10   (id,nombre) values (303,'D44 Tumor de comportamiento incierto o desconocido de las glándulas endocrinas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (304,'D45 Policitemia vera')
        ","insert into diag_agudo_cie_10   (id,nombre) values (305,'D46 Síndromes mielodisplásicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (306,'D47 Otros tumores de comportamiento incierto o desconocido del tejido linfático, de los órganos hematopoyéticos y de tejidos afines')
        ","insert into diag_agudo_cie_10   (id,nombre) values (307,'D48 Tumor de comportamiento incierto o desconocido de otros sitios y de los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (308,'D50 Anemias por deficiencia de hierro')
        ","insert into diag_agudo_cie_10   (id,nombre) values (309,'D51 Anemia por deficiencia de vitamina B12')
        ","insert into diag_agudo_cie_10   (id,nombre) values (310,'D52 Anemia por deficiencia de folatos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (311,'D53 Otras anemias nutricionales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (312,'D55 Anemia debida a trastornos enzimáticos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (313,'D56 Talasemia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (314,'D57 Trastornos falciformes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (315,'D58 Otras anemias hemolíticas hereditarias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (316,'D59 Anemia hemolítica adquirida')
        ","insert into diag_agudo_cie_10   (id,nombre) values (317,'D60 Aplasia adquirida, exclusiva de la serie roja [eritroblastopenia]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (318,'D61 Otras anemias aplásticas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (319,'D62 Anemia posthemorrágica aguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (320,'D63* Anemia en enfermedades crónicas clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (321,'D64 Otras anemias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (322,'D65 Coagulación intravascular diseminada [síndrome de desfibrinación]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (323,'D66 Deficiencia hereditaria del factor VIII')
        ","insert into diag_agudo_cie_10   (id,nombre) values (324,'D67 Deficiencia hereditaria del factor IX')
        ","insert into diag_agudo_cie_10   (id,nombre) values (325,'D68 Otros defectos de la coagulación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (326,'D69 Púrpura y otras afecciones hemorrágicas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (327,'D70 Agranulocitosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (328,'D71 Trastornos funcionales de los polimorfonucleares neutrófilos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (329,'D72 Otros trastornos de los leucocitos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (330,'D73 Enfermedades del bazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (331,'D74 Metahemoglobinemia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (332,'D75 Otras enfermedades de la sangre y de los órganos hematopoyéticos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (333,'D76 Ciertas enfermedades que afectan al tejido linforreticular y al sistema reticuloendotelial')
        ","insert into diag_agudo_cie_10   (id,nombre) values (334,'D77* Otros trastornos de la sangre y de los órganos hematopoyéticos en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (335,'D80 Inmunodeficiencia con predominio de defectos de los anticuerpos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (336,'D81 Inmunodeficiencias combinadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (337,'D82 Inmunodeficiencia asociada con otros defectos mayores')
        ","insert into diag_agudo_cie_10   (id,nombre) values (338,'D83 Inmunodeficiencia variable común')
        ","insert into diag_agudo_cie_10   (id,nombre) values (339,'D84 Otras inmunodeficiencias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (340,'D86 Sarcoidosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (341,'D89 Otros trastornos que afectan el mecanismo de la inmunidad, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (342,'E00 Síndrome congénito de deficiencia de yodo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (343,'E01 Trastornos tiroideos vinculados a deficiencia de yodo y afecciones relacionadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (344,'E02 Hipotiroidismo subclínico por deficiencia de yodo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (345,'E03 Otros hipotiroidismos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (346,'E04 Otros bocios no tóxicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (347,'E05 Tirotoxicosis [hipertiroidismo]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (348,'E06 Tiroiditis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (349,'E07 Otros trastornos tiroideos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (350,'E10 Diabetes mellitus insulinodependiente')
        ","insert into diag_agudo_cie_10   (id,nombre) values (351,'E11 Diabetes mellitus no insulinodependiente')
        ","insert into diag_agudo_cie_10   (id,nombre) values (352,'E12 Diabetes mellitus asociada con desnutrición')
        ","insert into diag_agudo_cie_10   (id,nombre) values (353,'E13 Otras diabetes mellitus especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (354,'E14 Diabetes mellitus, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (355,'E15 Coma hipoglicémico no diabético')
        ","insert into diag_agudo_cie_10   (id,nombre) values (356,'E16 Otros trastornos de la secreción interna del páncreas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (357,'E20 Hipoparatiroidismo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (358,'E21 Hiperparatiroidismo y otros trastornos de la glándula paratiroides')
        ","insert into diag_agudo_cie_10   (id,nombre) values (359,'E22 Hiperfunción de la glándula hipófisis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (360,'E23 Hipofunción y otros trastornos de la glándula hipófisis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (361,'E24 Síndrome de Cushing')
        ","insert into diag_agudo_cie_10   (id,nombre) values (362,'E25 Trastornos adrenogenitales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (363,'E26 Hiperaldosteronismo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (364,'E27 Otros trastornos de la glándula suprarrenal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (365,'E28 Disfunción ovárica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (366,'E29 Disfunción testicular')
        ","insert into diag_agudo_cie_10   (id,nombre) values (367,'E30 Trastornos de la pubertad, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (368,'E31 Disfunción poliglandular')
        ","insert into diag_agudo_cie_10   (id,nombre) values (369,'E32 Enfermedades del timo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (370,'E34 Otros trastornos endocrinos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (371,'E35* Trastornos endocrinos en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (372,'E40 Kwashiorkor')
        ","insert into diag_agudo_cie_10   (id,nombre) values (373,'E41 Marasmo nutricional')
        ","insert into diag_agudo_cie_10   (id,nombre) values (374,'E42 Kwashiorkor marasmático')
        ","insert into diag_agudo_cie_10   (id,nombre) values (375,'E43 Desnutrición proteicocalórica severa, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (376,'E44 Desnutrición proteicocalórica de grado moderado y leve')
        ","insert into diag_agudo_cie_10   (id,nombre) values (377,'E45 Retardo del desarrollo debido a desnutrición proteicocalórica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (378,'E46 Desnutrición proteicocalórica, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (379,'E50 Deficiencia de vitamina A')
        ","insert into diag_agudo_cie_10   (id,nombre) values (380,'E51 Deficiencia de tiamina')
        ","insert into diag_agudo_cie_10   (id,nombre) values (381,'E52 Deficiencia de niacina [pelagra]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (382,'E53 Deficiencias de otras vitaminas del grupo B')
        ","insert into diag_agudo_cie_10   (id,nombre) values (383,'E54 Deficiencia de ácido ascórbico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (384,'E55 Deficiencia de vitamina D')
        ","insert into diag_agudo_cie_10   (id,nombre) values (385,'E56 Otras deficiencias de vitaminas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (386,'E58 Deficiencia dietética de calcio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (387,'E59 Deficiencia dietética de selenio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (388,'E60 Deficiencia dietética de zinc')
        ","insert into diag_agudo_cie_10   (id,nombre) values (389,'E61 Deficiencias de otros elementos nutricionales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (390,'E63 Otras deficiencias nutricionales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (391,'E64 Secuelas de la desnutrición y de otras deficiencias nutricionales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (392,'E65 Adiposidad localizada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (393,'E66 Obesidad')
        ","insert into diag_agudo_cie_10   (id,nombre) values (394,'E67 Otros tipos de hiperalimentación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (395,'E68 Secuelas de hiperalimentación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (396,'E70 Trastornos del metabolismo de los aminoácidos aromáticos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (397,'E71 Trastornos del metabolismo de los aminoácidos de cadena ramificada y de los ácidos grasos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (398,'E72 Otros trastornos del metabolismo de los aminoácidos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (399,'E73 Intolerancia a la lactosa')
        ","insert into diag_agudo_cie_10   (id,nombre) values (400,'E74 Otros trastornos del metabolismo de los carbohidratos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (401,'E75 Trastornos del metabolismo de los esfingolípidos y otros trastornos por almacenamiento de lípidos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (402,'E76 Trastornos del metabolismo de los glucosaminoglicanos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (403,'E77 Trastornos del metabolismo de las glucoproteínas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (404,'E78 Trastornos del metabolismo de las lipoproteínas y otras lipidemias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (405,'E79 Trastornos del metabolismo de las purinas y de las pirimidinas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (406,'E80 Trastornos del metabolismo de las porfirinas y de la bilirrubina')
        ","insert into diag_agudo_cie_10   (id,nombre) values (407,'E83 Trastornos del metabolismo de los minerales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (408,'E84 Fibrosis quística')
        ","insert into diag_agudo_cie_10   (id,nombre) values (409,'E85 Amiloidosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (410,'E86 Depleción del volumen')
        ","insert into diag_agudo_cie_10   (id,nombre) values (411,'E87 Otros trastornos de los líquidos, de los electrólitos y del equilibrio ácido-básico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (412,'E88 Otros trastornos metabólicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (413,'E89 Trastornos endocrinos y metabólicos consecutivos a procedimientos, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (414,'E90* Trastornos nutricionales y metabólicos en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (415,'H00 Orzuelo y calacio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (416,'H01 Otras inflamaciones del párpado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (417,'H02 Otros trastornos de los párpados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (418,'H03* Trastornos del párpado en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (419,'H04 Trastornos del aparato lagrimal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (420,'H05 Trastornos de la órbita')
        ","insert into diag_agudo_cie_10   (id,nombre) values (421,'H06* Trastornos del aparato lagrimal y de la órbita en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (422,'H10 Conjuntivitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (423,'H11 Otros trastornos de la conjuntiva')
        ","insert into diag_agudo_cie_10   (id,nombre) values (424,'H13* Trastornos de la conjuntiva en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (425,'H15 Trastornos de la esclerótica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (426,'H16 Queratitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (427,'H17 Opacidades y cicatrices corneales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (428,'H18 Otros trastornos de la córnea')
        ","insert into diag_agudo_cie_10   (id,nombre) values (429,'H19* Trastornos de la esclerótica y de la córnea en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (430,'H20 Iridociclitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (431,'H21 Otros trastornos del iris y del cuerpo ciliar')
        ","insert into diag_agudo_cie_10   (id,nombre) values (432,'H22* Trastornos del iris y del cuerpo ciliar en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (433,'H25 Catarata senil')
        ","insert into diag_agudo_cie_10   (id,nombre) values (434,'H26 Otras cataratas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (435,'H27 Otros trastornos del cristalino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (436,'H28* Catarata y otros trastornos del cristalino en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (437,'H30 Inflamación coriorretiniana')
        ","insert into diag_agudo_cie_10   (id,nombre) values (438,'H31 Otros trastornos de la coroides')
        ","insert into diag_agudo_cie_10   (id,nombre) values (439,'H32* Trastornos coriorretinianos en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (440,'H33 Desprendimiento y desgarro de la retina')
        ","insert into diag_agudo_cie_10   (id,nombre) values (441,'H34 Oclusión vascular de la retina')
        ","insert into diag_agudo_cie_10   (id,nombre) values (442,'H35 Otros trastornos de la retina')
        ","insert into diag_agudo_cie_10   (id,nombre) values (443,'H36* Trastornos de la retina en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (444,'H40 Glaucoma')
        ","insert into diag_agudo_cie_10   (id,nombre) values (445,'H42* Glaucoma en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (446,'H43 Trastornos del cuerpo vítreo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (447,'H44 Trastornos del globo ocular')
        ","insert into diag_agudo_cie_10   (id,nombre) values (448,'H45* Trastornos del cuerpo vítreo y del globo ocular en enfermedades clasificadas  en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (449,'H46 Neuritis óptica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (450,'H47 Otros trastornos del nervio óptico [II par] y de las vías opticas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (451,'H48* Trastornos del nervio óptico [II par] y de las vías ópticas en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (452,'H49 Estrabismo paralítico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (453,'H50 Otros estrabismos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (454,'H51 Otros trastornos de los movimientos binoculares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (455,'H52 Trastornos de la acomodación y de la refracción')
        ","insert into diag_agudo_cie_10   (id,nombre) values (456,'H53 Alteraciones de la visión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (457,'H54 Ceguera y disminución de la agudeza visual')
        ","insert into diag_agudo_cie_10   (id,nombre) values (458,'H55 Nistagmo y otros movimientos oculares irregulares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (459,'H57 Otros trastornos del ojo y sus anexos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (460,'H58* Otros trastornos del ojo y sus anexos en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (461,'H59 Trastornos del ojo y sus anexos consecutivos a procedimientos, no  clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (462,'H60 Otitis externa')
        ","insert into diag_agudo_cie_10   (id,nombre) values (463,'H61 Otros trastornos del oído externo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (464,'H62* Trastornos del oído externo en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (465,'H65 Otitis media no supurativa')
        ","insert into diag_agudo_cie_10   (id,nombre) values (466,'H66 Otitis media supurativa y la no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (467,'H67* Otitis media en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (468,'H68 Inflamación y obstrucción de la trompa de Eustaquio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (469,'H69 Otros trastornos de la trompa de Eustaquio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (470,'H70 Mastoiditis y afecciones relacionadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (471,'H71 Colesteatoma del oído medio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (472,'H72 Perforación de la membrana timpánica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (473,'H73 Otros trastornos de la membrana timpánica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (474,'H74 Otros trastornos del oído medio y de la apófisis mastoides')
        ","insert into diag_agudo_cie_10   (id,nombre) values (475,'H75* Otros trastornos del oído medio y de la apófisis mastoides en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (476,'H80 Otosclerosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (477,'H81 Trastornos de la función vestibular')
        ","insert into diag_agudo_cie_10   (id,nombre) values (478,'H82* Síndromes vertiginosos en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (479,'H83 Otros trastornos del oído interno')
        ","insert into diag_agudo_cie_10   (id,nombre) values (480,'H90 Hipoacusia conductiva y neurosensorial')
        ","insert into diag_agudo_cie_10   (id,nombre) values (481,'H91 Otras hipoacusias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (482,'H92 Otalgia y secreción del oído')
        ","insert into diag_agudo_cie_10   (id,nombre) values (483,'H93 Otros trastornos del oído, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (484,'H94* Otros trastornos del oído en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (485,'H95 Trastornos del oído y de la apófisis mastoides consecutivos a procedimientos, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (486,'I00 Fiebre reumática sin mención de complicación cardíaca')
        ","insert into diag_agudo_cie_10   (id,nombre) values (487,'I01 Fiebre reumática con complicación cardíaca')
        ","insert into diag_agudo_cie_10   (id,nombre) values (488,'I02 Corea reumática')
        ","insert into diag_agudo_cie_10   (id,nombre) values (489,'I05 Enfermedades reumáticas de la válvula mitral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (490,'I06 Enfermedades reumáticas de la válvula aórtica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (491,'I07 Enfermedades reumáticas de la válvula tricúspide')
        ","insert into diag_agudo_cie_10   (id,nombre) values (492,'I08 Enfermedades valvulares múltiples')
        ","insert into diag_agudo_cie_10   (id,nombre) values (493,'I09 Otras enfermedades reumáticas del corazón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (494,'I10 Hipertensión esencial (primaria)')
        ","insert into diag_agudo_cie_10   (id,nombre) values (495,'I11 Enfermedad cardíaca hipertensiva')
        ","insert into diag_agudo_cie_10   (id,nombre) values (496,'I12 Enfermedad renal hipertensiva')
        ","insert into diag_agudo_cie_10   (id,nombre) values (497,'I13 Enfermedad cardiorrenal hipertensiva')
        ","insert into diag_agudo_cie_10   (id,nombre) values (498,'I15 Hipertensión secundaria')
        ","insert into diag_agudo_cie_10   (id,nombre) values (499,'I20 Angina de pecho')
        ","insert into diag_agudo_cie_10   (id,nombre) values (500,'I21 Infarto agudo del miocardio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (501,'I22 Infarto subsecuente del miocardio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (502,'I23 Ciertas complicaciones presentes posteriores al infarto agudo del miocardio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (503,'I24 Otras enfermedades isquémicas agudas del corazón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (504,'I25 Enfermedad isquémica crónica del corazón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (505,'I26 Embolia pulmonar')
        ","insert into diag_agudo_cie_10   (id,nombre) values (506,'I27 Otras enfermedades cardiopulmonares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (507,'I28 Otras enfermedades de los vasos pulmonares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (508,'I30 Pericarditis aguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (509,'I31 Otras enfermedades del pericardio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (510,'I32* Pericarditis en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (511,'I33 Endocarditis aguda y subaguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (512,'I34 Trastornos no reumáticos de la válvula mitral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (513,'I35 Trastornos no reumáticos de la válvula aórtica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (514,'I36 Trastornos no reumáticos de la válvula tricúspide')
        ","insert into diag_agudo_cie_10   (id,nombre) values (515,'I37 Trastornos de la válvula pulmonar')
        ","insert into diag_agudo_cie_10   (id,nombre) values (516,'I38 Endocarditis, válvula no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (517,'I39* Endocarditis y trastornos valvulares en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (518,'I40 Miocarditis aguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (519,'I41* Miocarditis en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (520,'I42 Cardiomiopatía')
        ","insert into diag_agudo_cie_10   (id,nombre) values (521,'I43* Cardiomiopatía en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (522,'I44 Bloqueo auriculoventricular y de rama izquierda del haz')
        ","insert into diag_agudo_cie_10   (id,nombre) values (523,'I45 Otros trastornos de la conducción')
        ","insert into diag_agudo_cie_10   (id,nombre) values (524,'I46 Paro cardíaco')
        ","insert into diag_agudo_cie_10   (id,nombre) values (525,'I47 Taquicardia paroxística')
        ","insert into diag_agudo_cie_10   (id,nombre) values (526,'I48 Fibrilación y aleteo auricular')
        ","insert into diag_agudo_cie_10   (id,nombre) values (527,'I49 Otras arritmias cardíacas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (528,'I50 Insuficiencia cardíaca')
        ","insert into diag_agudo_cie_10   (id,nombre) values (529,'I51 Complicaciones y descripciones mal definidas de enfermedad cardíaca')
        ","insert into diag_agudo_cie_10   (id,nombre) values (530,'I52* Otros trastornos cardíacos en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (531,'I60 Hemorragia subaracnoidea')
        ","insert into diag_agudo_cie_10   (id,nombre) values (532,'I61 Hemorragia intraencefálica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (533,'I62 Otras hemorragias intracraneales no traumáticas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (534,'I63 Infarto cerebral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (535,'I64 Accidente vascular encefálico agudo, no especificado como hemorrágico o  isquémico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (536,'I65 Oclusión y estenosis de las arterias precerebrales sin ocasionar infarto cerebral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (537,'I66 Oclusión y estenosis de las arterias cerebrales sin ocasionar infarto cerebral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (538,'I67 Otras enfermedades cerebrovasculares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (539,'I68* Trastornos cerebrovasculares en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (540,'I69 Secuelas de enfermedad cerebrovascular')
        ","insert into diag_agudo_cie_10   (id,nombre) values (541,'I70 Aterosclerosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (542,'I71 Aneurisma y disección aórticos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (543,'I72 Otros aneurismas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (544,'I73 Otras enfermedades vasculares periféricas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (545,'I74 Embolia y trombosis arteriales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (546,'I77 Otros trastornos arteriales o arteriolares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (547,'I78 Enfermedades de los vasos capilares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (548,'I79* Trastornos de las arterias, de las arteriolas y de los vasos capilares en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (549,'I80 Flebitis y tromboflebitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (550,'I81 Trombosis de la vena porta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (551,'I82 Otras embolias y trombosis venosas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (552,'I83 Venas varicosas de los miembros inferiores')
        ","insert into diag_agudo_cie_10   (id,nombre) values (553,'I84 Hemorroides')
        ","insert into diag_agudo_cie_10   (id,nombre) values (554,'I85 Várices esofágicas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (555,'I86 Várices de otros sitios')
        ","insert into diag_agudo_cie_10   (id,nombre) values (556,'I87 Otros trastornos de las venas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (557,'I88 Linfadenitis inespecífica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (558,'I89 Otros trastornos no infecciosos de los vasos y ganglios linfáticos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (559,'I95 Hipotensión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (560,'I97 Trastornos del sistema circulatorio consecutivos a procedimientos, no  clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (561,'I98* Otros trastornos del sistema circulatorio en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (562,'I99 Otros trastornos y los no especificados del sistema circulatorio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (563,'J00 Rinofaringitis aguda [resfriado común]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (564,'J01 Sinusitis aguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (565,'J02 Faringitis aguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (566,'J03 Amigdalitis aguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (567,'J04 Laringitis y traqueítis agudas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (568,'J05 Laringitis obstructiva aguda [crup] y epiglotitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (569,'J06 Infecciones agudas de las vías respiratorias superiores, de sitios múltiples o no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (570,'J10 Influenza debida a virus de la influenza identificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (571,'J11 Influenza debida a virus no identificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (572,'J12 Neumonía viral, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (573,'J13 Neumonía debida a Streptococcus pneumoniae')
        ","insert into diag_agudo_cie_10   (id,nombre) values (574,'J14 Neumonía debida a Haemophilus influenzae')
        ","insert into diag_agudo_cie_10   (id,nombre) values (575,'J15 Neumonía bacteriana, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (576,'J16 Neumonía debida a otros microorganismos infecciosos, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (577,'J17* Neumonía en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (578,'J18 Neumonía, organismo no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (579,'J20 Bronquitis aguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (580,'J21 Bronquiolitis aguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (581,'J22 Infección aguda no especificada de las vías respiratorias inferiores')
        ","insert into diag_agudo_cie_10   (id,nombre) values (582,'J30 Rinitis alérgica y vasomotora')
        ","insert into diag_agudo_cie_10   (id,nombre) values (583,'J31 Rinitis, rinofaringitis y faringitis crónicas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (584,'J32 Sinusitis crónica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (585,'J33 Pólipo nasal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (586,'J34 Otros trastornos de la nariz y de los senos paranasales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (587,'J35 Enfermedades crónicas de las amígdalas y de las adenoides')
        ","insert into diag_agudo_cie_10   (id,nombre) values (588,'J36 Absceso periamigdalino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (589,'J37 Laringitis y laringotraqueítis crónicas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (590,'J38 Enfermedades de las cuerdas vocales y de la laringe, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (591,'J39 Otras enfermedades de las vías respiratorias superiores')
        ","insert into diag_agudo_cie_10   (id,nombre) values (592,'J40 Bronquitis, no especificada como aguda o crónica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (593,'J41 Bronquitis crónica simple y mucopurulenta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (594,'J42 Bronquitis crónica no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (595,'J43 Enfisema')
        ","insert into diag_agudo_cie_10   (id,nombre) values (596,'J44 Otras enfermedades pulmonares obstructivas crónicas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (597,'J45 Asma')
        ","insert into diag_agudo_cie_10   (id,nombre) values (598,'J46 Estado asmático')
        ","insert into diag_agudo_cie_10   (id,nombre) values (599,'J47 Bronquiectasia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (600,'J60 Neumoconiosis de los mineros del carbón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (601,'J61 Neumoconiosis debida al asbesto y a otras fibras minerales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (602,'J62 Neumoconiosis debida a polvo de sílice')
        ","insert into diag_agudo_cie_10   (id,nombre) values (603,'J63 Neumoconiosis debida a otros polvos inorgánicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (604,'J64 Neumoconiosis, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (605,'J65 Neumoconiosis asociada con tuberculosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (606,'J66 Enfermedades de las vías aéreas debidas a polvos orgánicos específicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (607,'J67 Neumonitis debida a hipersensibilidad al polvo orgánico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (608,'J68 Afecciones respiratorias debidas a inhalación de gases, humos, vapores y sustancias químicas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (609,'J69 Neumonitis debida a sólidos y líquidos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (610,'J70 Afecciones respiratorias debidas a otros agentes externos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (611,'J80 Síndrome de dificultad respiratoria del adulto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (612,'J81 Edema pulmonar')
        ","insert into diag_agudo_cie_10   (id,nombre) values (613,'J82 Eosinofilia pulmonar, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (614,'J84 Otras enfermedades pulmonares intersticiales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (615,'J85 Absceso del pulmón y del mediastino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (616,'J86 Piotórax')
        ","insert into diag_agudo_cie_10   (id,nombre) values (617,'J90 Derrame pleural no clasificado en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (618,'J91* Derrame pleural en afecciones clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (619,'J92 Paquipleuritis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (620,'J93 Neumotórax')
        ","insert into diag_agudo_cie_10   (id,nombre) values (621,'J94 Otras afecciones de la pleura')
        ","insert into diag_agudo_cie_10   (id,nombre) values (622,'J95 Trastornos del sistema respiratorio consecutivos a procedimientos, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (623,'J96 Insuficiencia respiratoria, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (624,'J98 Otros trastornos respiratorios')
        ","insert into diag_agudo_cie_10   (id,nombre) values (625,'J99* Trastornos respiratorios en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (626,'K00 Trastornos del desarrollo y de la erupción de los dientes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (627,'K01 Dientes incluidos e impactados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (628,'K02 Caries dental')
        ","insert into diag_agudo_cie_10   (id,nombre) values (629,'K03 Otras enfermedades de los tejidos duros de los dientes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (630,'K04 Enfermedades de la pulpa y de los tejidos periapicales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (631,'K05 Gingivitis y enfermedades periodontales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (632,'K06 Otros trastornos de la encía y de la zona edéntula')
        ","insert into diag_agudo_cie_10   (id,nombre) values (633,'K07 Anomalías dentofaciales [incluso la maloclusión]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (634,'K08 Otros trastornos de los dientes y de sus estructuras de sostén')
        ","insert into diag_agudo_cie_10   (id,nombre) values (635,'K09 Quistes de la región bucal, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (636,'K10 Otras enfermedades de los maxilares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (637,'K11 Enfermedades de las glándulas salivales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (638,'K12 Estomatitis y lesiones afines')
        ","insert into diag_agudo_cie_10   (id,nombre) values (639,'K13 Otras enfermedades de los labios y de la mucosa bucal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (640,'K14 Enfermedades de la lengua')
        ","insert into diag_agudo_cie_10   (id,nombre) values (641,'K20 Esofagitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (642,'K21 Enfermedad del reflujo gastroesofágico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (643,'K22 Otras enfermedades del esófago')
        ","insert into diag_agudo_cie_10   (id,nombre) values (644,'K23* Trastornos del esófago en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (645,'K25 Ulcera gástrica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (646,'K26 Ulcera duodenal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (647,'K27 Ulcera péptica, de sitio no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (648,'K28 Ulcera gastroyeyunal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (649,'K29 Gastritis y duodenitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (650,'K30 Dispepsia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (651,'K31 Otras enfermedades del estómago y del duodeno')
        ","insert into diag_agudo_cie_10   (id,nombre) values (652,'K35 Apendicitis aguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (653,'K36 Otros tipos de apendicitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (654,'K37 Apendicitis, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (655,'K38 Otras enfermedades del apéndice')
        ","insert into diag_agudo_cie_10   (id,nombre) values (656,'K40 Hernia inguinal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (657,'K41 Hernia femoral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (658,'K42 Hernia umbilical')
        ","insert into diag_agudo_cie_10   (id,nombre) values (659,'K43 Hernia ventral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (660,'K44 Hernia diafragmática')
        ","insert into diag_agudo_cie_10   (id,nombre) values (661,'K45 Otras hernias de la cavidad abdominal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (662,'K46 Hernia no especificada de la cavidad abdominal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (663,'K50 Enfermedad de Crohn [enteritis regional]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (664,'K51 Colitis ulcerativa')
        ","insert into diag_agudo_cie_10   (id,nombre) values (665,'K52 Otras colitis y gastroenteritis no infecciosas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (666,'K55 Trastornos vasculares de los intestinos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (667,'K56 Ileo paralítico y obstrucción intestinal sin hernia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (668,'K57 Enfermedad diverticular del intestino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (669,'K58 Síndrome del colon irritable')
        ","insert into diag_agudo_cie_10   (id,nombre) values (670,'K59 Otros trastornos funcionales del intestino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (671,'K60 Fisura y fístula de las regiones anal y rectal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (672,'K61 Absceso de las regiones anal y rectal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (673,'K62 Otras enfermedades del ano y del recto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (674,'K63 Otras enfermedades de los intestinos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (675,'K65 Peritonitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (676,'K66 Otros trastornos del peritoneo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (677,'K67* Trastornos del peritoneo en enfermedades infecciosas clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (678,'K70 Enfermedad alcohólica del hígado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (679,'K71 Enfermedad tóxica del hígado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (680,'K72 Insuficiencia hepática, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (681,'K73 Hepatitis crónica, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (682,'K74 Fibrosis y cirrosis del hígado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (683,'K75 Otras enfermedades inflamatorias del hígado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (684,'K76 Otras enfermedades del hígado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (685,'K77* Trastornos del hígado en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (686,'K80 Colelitiasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (687,'K81 Colecistitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (688,'K82 Otras enfermedades de la vesícula biliar')
        ","insert into diag_agudo_cie_10   (id,nombre) values (689,'K83 Otras enfermedades de las vías biliares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (690,'K85 Pancreatitis aguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (691,'K86 Otras enfermedades del páncreas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (692,'K87* Trastornos de la vesícula biliar, de las vías biliares y del páncreas en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (693,'K90 Malabsorción intestinal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (694,'K91 Trastornos del sistema digestivo consecutivos a procedimientos, no  clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (695,'K92 Otras enfermedades del sistema digestivo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (696,'K93* Trastornos de otros órganos digestivos en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (697,'L00 Síndrome estafilocócico de la piel escaldada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (698,'L01 Impétigo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (699,'L02 Absceso cutáneo, furúnculo y ántrax')
        ","insert into diag_agudo_cie_10   (id,nombre) values (700,'L03 Celulitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (701,'L04 Linfadenitis aguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (702,'L05 Quiste pilonidal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (703,'L08 Otras infecciones locales de la piel y del tejido subcutáneo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (704,'L10 Pénfigo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (705,'L11 Otros trastornos acantolíticos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (706,'L12 Penfigoide')
        ","insert into diag_agudo_cie_10   (id,nombre) values (707,'L13 Otros trastornos flictenulares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (708,'L14* Trastornos flictenulares en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (709,'L20 Dermatitis atópica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (710,'L21 Dermatitis seborreica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (711,'L22 Dermatitis del pañal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (712,'L23 Dermatitis alérgica de contacto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (713,'L24 Dermatitis de contacto por irritantes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (714,'L25 Dermatitis de contacto, forma no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (715,'L26 Dermatitis exfoliativa')
        ","insert into diag_agudo_cie_10   (id,nombre) values (716,'L27 Dermatitis debida a sustancias ingeridas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (717,'L28 Liquen simple crónico y prurigo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (718,'L29 Prurito')
        ","insert into diag_agudo_cie_10   (id,nombre) values (719,'L30 Otras dermatitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (720,'L40 Psoriasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (721,'L41 Parapsoriasis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (722,'L42 Pitiriasis rosada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (723,'L43 Liquen plano')
        ","insert into diag_agudo_cie_10   (id,nombre) values (724,'L44 Otros trastornos papuloescamosos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (725,'L45* Trastornos papuloescamosos en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (726,'L50 Urticaria')
        ","insert into diag_agudo_cie_10   (id,nombre) values (727,'L51 Eritema multiforme')
        ","insert into diag_agudo_cie_10   (id,nombre) values (728,'L52 Eritema nudoso')
        ","insert into diag_agudo_cie_10   (id,nombre) values (729,'L53 Otras afecciones eritematosas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (730,'L54* Eritema en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (731,'L55 Quemadura solar')
        ","insert into diag_agudo_cie_10   (id,nombre) values (732,'L56 Otros cambios agudos de la piel debidos a radiación ultravioleta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (733,'L57 Cambios de la piel debidos a exposición crónica a radiación no ionizante')
        ","insert into diag_agudo_cie_10   (id,nombre) values (734,'L58 Radiodermatitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (735,'L59 Otros trastornos de la piel y del tejido subcutáneo relacionados con radiación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (736,'L60 Trastornos de las uñas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (737,'L62* Trastornos de las uñas en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (738,'L63 Alopecia areata')
        ","insert into diag_agudo_cie_10   (id,nombre) values (739,'L64 Alopecia andrógena')
        ","insert into diag_agudo_cie_10   (id,nombre) values (740,'L65 Otra pérdida no cicatricial del pelo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (741,'L66 Alopecia cicatricial [pérdida cicatricial del pelo]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (742,'L67 Anormalidades del tallo y del color del pelo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (743,'L68 Hipertricosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (744,'L70 Acné')
        ","insert into diag_agudo_cie_10   (id,nombre) values (745,'L71 Rosácea')
        ","insert into diag_agudo_cie_10   (id,nombre) values (746,'L72 Quiste folicular de la piel y del tejido subcutáneo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (747,'L73 Otros trastornos foliculares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (748,'L74 Trastornos sudoríparos ecrinos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (749,'L75 Trastornos sudoríparos apocrinos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (750,'L80 Vitíligo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (751,'L81 Otros trastornos de la pigmentación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (752,'L82 Queratosis seborreica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (753,'L83 Acantosis nigricans')
        ","insert into diag_agudo_cie_10   (id,nombre) values (754,'L84 Callos y callosidades')
        ","insert into diag_agudo_cie_10   (id,nombre) values (755,'L85 Otros tipos de engrosamiento epidérmico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (756,'L86* Queratoderma en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (757,'L87 Trastornos de la eliminación transepidérmica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (758,'L88 Pioderma gangrenoso')
        ","insert into diag_agudo_cie_10   (id,nombre) values (759,'L89 Ulcera de decúbito')
        ","insert into diag_agudo_cie_10   (id,nombre) values (760,'L90 Trastornos atróficos de la piel')
        ","insert into diag_agudo_cie_10   (id,nombre) values (761,'L91 Trastornos hipertróficos de la piel')
        ","insert into diag_agudo_cie_10   (id,nombre) values (762,'L92 Trastornos granulomatosos de la piel y del tejido subcutáneo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (763,'L93 Lupus eritematoso')
        ","insert into diag_agudo_cie_10   (id,nombre) values (764,'L94 Otros trastornos localizados del tejido conjuntivo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (765,'L95 Vasculitis limitada a la piel, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (766,'L97 Ulcera de miembro inferior, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (767,'L98 Otros trastornos de la piel y del tejido subcutáneo, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (768,'L99* Otros trastornos de la piel y del tejido subcutáneo en enfermedades  clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (769,'M00 Artritis piógena')
        ","insert into diag_agudo_cie_10   (id,nombre) values (770,'M01* Infecciones directas de la articulación en enfermedades infecciosas y parasitarias clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (771,'M02 Artropatías reactivas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (772,'M03* Artropatías postinfecciosas y reactivas en enfermedades clasificadas en  otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (773,'M05 Artritis reumatoide seropositiva')
        ","insert into diag_agudo_cie_10   (id,nombre) values (774,'M06 Otras artritis reumatoides')
        ","insert into diag_agudo_cie_10   (id,nombre) values (775,'M07* Artropatías psoriásicas y enteropáticas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (776,'M08 Artritis juvenil')
        ","insert into diag_agudo_cie_10   (id,nombre) values (777,'M09* Artritis juvenil en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (778,'M10 Gota')
        ","insert into diag_agudo_cie_10   (id,nombre) values (779,'M11 Otras artropatías por cristales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (780,'M12 Otras artropatías específicas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (781,'M13 Otras artritis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (782,'M14* Artropatía en otras enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (783,'M15 Poliartrosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (784,'M16 Coxartrosis [artrosis de la cadera]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (785,'M17 Gonartrosis [artrosis de la rodilla]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (786,'M18 Artrosis de la primera articulación carpometacarpiana')
        ","insert into diag_agudo_cie_10   (id,nombre) values (787,'M19 Otras artrosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (788,'M20 Deformidades adquiridas de los dedos de la mano y del pie')
        ","insert into diag_agudo_cie_10   (id,nombre) values (789,'M21 Otras deformidades adquiridas de los miembros')
        ","insert into diag_agudo_cie_10   (id,nombre) values (790,'M22 Trastornos de la rótula')
        ","insert into diag_agudo_cie_10   (id,nombre) values (791,'M23 Trastorno interno de la rodilla')
        ","insert into diag_agudo_cie_10   (id,nombre) values (792,'M24 Otros trastornos articulares específicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (793,'M25 Otros trastornos articulares, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (794,'M30 Poliarteritis nudosa y afecciones relacionadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (795,'M31 Otras vasculopatías necrotizantes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (796,'M32 Lupus eritematoso sistémico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (797,'M33 Dermatopolimiositis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (798,'M34 Esclerosis sistémica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (799,'M35 Otro compromiso sistémico del tejido conjuntivo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (800,'M36* Trastornos sistémicos del tejido conjuntivo en enfermedades clasificadas en  otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (801,'M40 Cifosis y lordosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (802,'M41 Escoliosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (803,'M42 Osteocondrosis de la columna vertebral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (804,'M43 Otras dorsopatías deformantes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (805,'M45 Espondilitis anquilosante')
        ","insert into diag_agudo_cie_10   (id,nombre) values (806,'M46 Otras espondilopatías inflamatorias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (807,'M47 Espondilosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (808,'M48 Otras espondilopatías')
        ","insert into diag_agudo_cie_10   (id,nombre) values (809,'M49* Espondilopatías en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (810,'M50 Trastornos de disco cervical')
        ","insert into diag_agudo_cie_10   (id,nombre) values (811,'M51 Otros trastornos de los discos intervertebrales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (812,'M53 Otras dorsopatías, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (813,'M54 Dorsalgia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (814,'M60 Miositis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (815,'M61 Calcificación y osificación del músculo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (816,'M62 Otros trastornos de los músculos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (817,'M63* Trastornos de los músculos en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (818,'M65 Sinovitis y tenosinovitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (819,'M66 Ruptura espontánea de la sinovia y del tendón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (820,'M67 Otros trastornos de la sinovia y del tendón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (821,'M68* Trastornos de los tendones y de la sinovia en enfermedades clasificadas en  otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (822,'M70 Trastornos de los tejidos blandos relacionados con el uso, el uso excesivo y la presión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (823,'M71 Otras bursopatías')
        ","insert into diag_agudo_cie_10   (id,nombre) values (824,'M72 Trastornos fibroblásticos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (825,'M73* Trastornos de los tejidos blandos en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (826,'M75 Lesiones del hombro')
        ","insert into diag_agudo_cie_10   (id,nombre) values (827,'M76 Entesopatías del miembro inferior, excluido el pie')
        ","insert into diag_agudo_cie_10   (id,nombre) values (828,'M77 Otras entesopatías')
        ","insert into diag_agudo_cie_10   (id,nombre) values (829,'M79 Otros trastornos de los tejidos blandos, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (830,'M80 Osteoporosis con fractura patológica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (831,'M81 Osteoporosis sin fractura patológica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (832,'M82* Osteoporosis en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (833,'M83 Osteomalacia del adulto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (834,'M84 Trastornos de la continuidad del hueso')
        ","insert into diag_agudo_cie_10   (id,nombre) values (835,'M85 Otros trastornos de la densidad y de la estructura óseas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (836,'M86 Osteomielitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (837,'M87 Osteonecrosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (838,'M88 Enfermedad de Paget de los huesos [osteítis deformante]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (839,'M89 Otros trastornos del hueso')
        ","insert into diag_agudo_cie_10   (id,nombre) values (840,'M90* Osteopatías en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (841,'M91 Osteocondrosis juvenil de la cadera y de la pelvis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (842,'M92 Otras osteocondrosis juveniles')
        ","insert into diag_agudo_cie_10   (id,nombre) values (843,'M93 Otras osteocondropatías')
        ","insert into diag_agudo_cie_10   (id,nombre) values (844,'M94 Otros trastornos del cartílago')
        ","insert into diag_agudo_cie_10   (id,nombre) values (845,'M95 Otras deformidades adquiridas del sistema osteomuscular y del tejido  conjuntivo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (846,'M96 Trastornos osteomusculares consecutivos a procedimientos, no clasificados  en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (847,'M99 Lesiones biomecánicas, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (848,'N00 Síndrome nefrítico agudo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (849,'N01 Síndrome nefrítico rápidamente progresivo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (850,'N02 Hematuria recurrente y persistente')
        ","insert into diag_agudo_cie_10   (id,nombre) values (851,'N03 Síndrome nefrítico crónico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (852,'N04 Síndrome nefrótico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (853,'N05 Síndrome nefrítico no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (854,'N06 Proteinuria aislada con lesión morfológica especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (855,'N07 Nefropatía hereditaria, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (856,'N08* Trastornos glomerulares en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (857,'N10 Nefritis tubulointersticial aguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (858,'N11 Nefritis tubulointersticial crónica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (859,'N12 Nefritis tubulointersticial, no especificada como aguda o crónica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (860,'N13 Uropatía obstructiva y por reflujo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (861,'N14 Afecciones tubulares y tubulointersticiales inducidas por drogas y por metales pesados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (862,'N15 Otras enfermedades renales tubulointersticiales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (863,'N16* Trastornos renales tubulointersticiales en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (864,'N17 Insuficiencia renal aguda')
        ","insert into diag_agudo_cie_10   (id,nombre) values (865,'N18 Insuficiencia renal crónica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (866,'N19 Insuficiencia renal no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (867,'N20 Cálculo del riñón y del uréter')
        ","insert into diag_agudo_cie_10   (id,nombre) values (868,'N21 Cálculo de las vías urinarias inferiores')
        ","insert into diag_agudo_cie_10   (id,nombre) values (869,'N22* Cálculo de las vías urinarias en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (870,'N23 Cólico renal, no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (871,'N25 Trastornos resultantes de la función tubular renal alterada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (872,'N26 Riñón contraído, no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (873,'N27 Riñón pequeño de causa desconocida')
        ","insert into diag_agudo_cie_10   (id,nombre) values (874,'N28 Otros trastornos del riñón y del uréter, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (875,'N29* Otros trastornos del riñón y del uréter en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (876,'N30 Cistitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (877,'N31 Disfunción neuromuscular de la vejiga, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (878,'N32 Otros trastornos de la vejiga')
        ","insert into diag_agudo_cie_10   (id,nombre) values (879,'N33* Trastornos de la vejiga en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (880,'N34 Uretritis y síndrome uretral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (881,'N35 Estrechez uretral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (882,'N36 Otros trastornos de la uretra')
        ","insert into diag_agudo_cie_10   (id,nombre) values (883,'N37* Trastornos de la uretra en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (884,'N39 Otros trastornos del sistema urinario')
        ","insert into diag_agudo_cie_10   (id,nombre) values (885,'N40 Hiperplasia de la próstata')
        ","insert into diag_agudo_cie_10   (id,nombre) values (886,'N41 Enfermedades inflamatorias de la próstata')
        ","insert into diag_agudo_cie_10   (id,nombre) values (887,'N42 Otros trastornos de la próstata')
        ","insert into diag_agudo_cie_10   (id,nombre) values (888,'N43 Hidrocele y espermatocele')
        ","insert into diag_agudo_cie_10   (id,nombre) values (889,'N44 Torsión del testículo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (890,'N45 Orquitis y epididimitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (891,'N46 Esterilidad en el varón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (892,'N47 Prepucio redundante, fimosis y parafimosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (893,'N48 Otros trastornos del pene')
        ","insert into diag_agudo_cie_10   (id,nombre) values (894,'N49 Trastornos inflamatorios de órganos genitales masculinos, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (895,'N50 Otros trastornos de los órganos genitales masculinos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (896,'N51* Trastornos de los órganos genitales masculinos en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (897,'N60 Displasia mamaria benigna')
        ","insert into diag_agudo_cie_10   (id,nombre) values (898,'N61 Trastornos inflamatorios de la mama')
        ","insert into diag_agudo_cie_10   (id,nombre) values (899,'N62 Hipertrofia de la mama')
        ","insert into diag_agudo_cie_10   (id,nombre) values (900,'N63 Masa no especificada en la mama')
        ","insert into diag_agudo_cie_10   (id,nombre) values (901,'N64 Otros trastornos de la mama')
        ","insert into diag_agudo_cie_10   (id,nombre) values (902,'N70 Salpingitis y ooforitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (903,'N71 Enfermedad inflamatoria del útero, excepto del cuello uterino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (904,'N72 Enfermedad inflamatoria del cuello uterino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (905,'N73 Otras enfermedades pélvicas inflamatorias femeninas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (906,'N74* Trastornos inflamatorios de la pelvis femenina en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (907,'N75 Enfermedades de la glándula de Bartholin')
        ","insert into diag_agudo_cie_10   (id,nombre) values (908,'N76 Otras afecciones inflamatorias de la vagina y de la vulva')
        ","insert into diag_agudo_cie_10   (id,nombre) values (909,'N77* Ulceración e inflamación vulvovaginal en enfermedades clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (910,'N80 Endometriosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (911,'N81 Prolapso genital femenino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (912,'N82 Fístulas que afectan el tracto genital femenino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (913,'N83 Trastornos no inflamatorios del ovario, de la trompa de Falopio y del ligamento  ancho')
        ","insert into diag_agudo_cie_10   (id,nombre) values (914,'N84 Pólipo del tracto genital femenino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (915,'N85 Otros trastornos no inflamatorios del útero, excepto del cuello')
        ","insert into diag_agudo_cie_10   (id,nombre) values (916,'N86 Erosión y ectropión del cuello del útero')
        ","insert into diag_agudo_cie_10   (id,nombre) values (917,'N87 Displasia del cuello uterino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (918,'N88 Otros trastornos no inflamatorios del cuello del útero')
        ","insert into diag_agudo_cie_10   (id,nombre) values (919,'N89 Otros trastornos no inflamatorios de la vagina')
        ","insert into diag_agudo_cie_10   (id,nombre) values (920,'N90 Otros trastornos no inflamatorios de la vulva y del perineo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (921,'N91 Menstruación ausente, escasa o rara')
        ","insert into diag_agudo_cie_10   (id,nombre) values (922,'N92 Menstruación excesiva, frecuente e irregular')
        ","insert into diag_agudo_cie_10   (id,nombre) values (923,'N93 Otras hemorragias uterinas o vaginales anormales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (924,'N94 Dolor y otras afecciones relacionadas con los órganos genitales femeninos y con el ciclo menstrual')
        ","insert into diag_agudo_cie_10   (id,nombre) values (925,'N95 Otros trastornos menopáusicos y perimenopáusicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (926,'N96 Abortadora habitual')
        ","insert into diag_agudo_cie_10   (id,nombre) values (927,'N97 Infertilidad femenina')
        ","insert into diag_agudo_cie_10   (id,nombre) values (928,'N98 Complicaciones asociadas con la fecundación artificial')
        ","insert into diag_agudo_cie_10   (id,nombre) values (929,'N99 Trastornos del sistema genitourinario consecutivos a procedimientos, no  clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (930,'O00 Embarazo ectópico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (931,'O01 Mola hidatiforme')
        ","insert into diag_agudo_cie_10   (id,nombre) values (932,'O02 Otros productos anormales de la concepción')
        ","insert into diag_agudo_cie_10   (id,nombre) values (933,'O03 Aborto espontáneo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (934,'O04 Aborto médico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (935,'O05 Otro aborto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (936,'O06 Aborto no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (937,'O07 Intento fallido de aborto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (938,'O08 Complicaciones consecutivas al aborto, al embarazo ectópico y al embarazo  molar')
        ","insert into diag_agudo_cie_10   (id,nombre) values (939,'O10 Hipertensión preexistente que complica el embarazo, el parto y el puerperio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (940,'O11 Trastornos hipertensivos preexistentes, con proteinuria agregada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (941,'O12 Edema y proteinuria gestacionales [inducidos por el embarazo] sin hipertensión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (942,'O13 Hipertensión gestacional [inducida por el embarazo] sin proteinuria  significativa')
        ","insert into diag_agudo_cie_10   (id,nombre) values (943,'O14 Hipertensión gestacional [inducida por el embarazo] con proteinuria  significativa')
        ","insert into diag_agudo_cie_10   (id,nombre) values (944,'O15 Eclampsia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (945,'O16 Hipertensión materna, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (946,'O20 Hemorragia precoz del embarazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (947,'O21 Vómitos excesivos en el embarazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (948,'O22 Complicaciones venosas en el embarazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (949,'O23 Infección de las vías genitourinarias en el embarazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (950,'O24 Diabetes mellitus en el embarazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (951,'O25 Desnutrición en el embarazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (952,'O26 Atención a la madre por otras complicaciones principalmente relacionadas con el embarazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (953,'O28 Hallazgos anormales en el examen prenatal de la madre')
        ","insert into diag_agudo_cie_10   (id,nombre) values (954,'O29 Complicaciones de la anestesia administrada durante el embarazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (955,'O30 Embarazo múltiple')
        ","insert into diag_agudo_cie_10   (id,nombre) values (956,'O31 Complicaciones específicas del embarazo múltiple')
        ","insert into diag_agudo_cie_10   (id,nombre) values (957,'O32 Atención materna por presentación anormal del feto, conocida o presunta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (958,'O33 Atención materna por desproporción conocida o presunta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (959,'O34 Atención materna por anormalidades conocidas o presuntas de los órganos pelvianos de la madre')
        ","insert into diag_agudo_cie_10   (id,nombre) values (960,'O35 Atención materna por anormalidad o lesión fetal, conocida o presunta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (961,'O36 Atención materna por otros problemas fetales conocidos o presuntos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (962,'O40 Polihidramnios')
        ","insert into diag_agudo_cie_10   (id,nombre) values (963,'O41 Otros trastornos del líquido amniótico y de las membranas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (964,'O42 Ruptura prematura de las membranas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (965,'O43 Trastornos placentarios')
        ","insert into diag_agudo_cie_10   (id,nombre) values (966,'O44 Placenta previa')
        ","insert into diag_agudo_cie_10   (id,nombre) values (967,'O45 Desprendimiento prematuro de la placenta [abruptio placentae]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (968,'O46 Hemorragia anteparto, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (969,'O47 Falso trabajo de parto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (970,'O48 Embarazo prolongado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (971,'O60 Parto prematuro')
        ","insert into diag_agudo_cie_10   (id,nombre) values (972,'O61 Fracaso de la inducción del trabajo de parto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (973,'O62 Anormalidades de la dinámica del trabajo de parto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (974,'O63 Trabajo de parto prolongado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (975,'O64 Trabajo de parto obstruido debido a mala posición y presentación anormal del feto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (976,'O65 Trabajo de parto obstruido debido a anormalidad de la pelvis materna')
        ","insert into diag_agudo_cie_10   (id,nombre) values (977,'O66 Otras obstrucciones del trabajo de parto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (978,'O67 Trabajo de parto y parto complicados por hemorragia intraparto, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (979,'O68 Trabajo de parto y parto complicados por sufrimiento fetal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (980,'O69 Trabajo de parto y parto complicados por problemas del cordón umbilical')
        ","insert into diag_agudo_cie_10   (id,nombre) values (981,'O70 Desgarro perineal durante el parto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (982,'O71 Otro trauma obstétrico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (983,'O72 Hemorragia postparto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (984,'O73 Retención de la placenta o de las membranas, sin hemorragia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (985,'O74 Complicaciones de la anestesia administrada durante el trabajo de parto y el parto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (986,'O75 Otras complicaciones del trabajo de parto y del parto, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (987,'O80 Parto único espontáneo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (988,'O81 Parto único con fórceps y ventosa extractora')
        ","insert into diag_agudo_cie_10   (id,nombre) values (989,'O82 Parto único por cesárea')
        ","insert into diag_agudo_cie_10   (id,nombre) values (990,'O83 Otros partos únicos asistidos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (991,'O84 Parto múltiple')
        ","insert into diag_agudo_cie_10   (id,nombre) values (992,'O85 Sepsis puerperal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (993,'O86 Otras infecciones puerperales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (994,'O87 Complicaciones venosas en el puerperio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (995,'O88 Embolia obstétrica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (996,'O89 Complicaciones de la anestesia administrada durante el puerperio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (997,'O90 Complicaciones del puerperio, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (998,'O91 Infecciones de la mama asociadas con el parto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (999,'O92 Otros trastornos de la mama y de la lactancia asociados con el parto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1000,'O95 Muerte obstétrica de causa no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1001,'O96 Muerte materna debida a cualquier causa obstétrica que ocurre después de 42 días pero antes de un año del parto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1002,'O97 Muerte por secuelas de causas obstétricas directas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1003,'O98 Enfermedades maternas infecciosas y parasitarias clasificables en otra parte, pero que complican el embarazo, el parto y el puerperio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1004,'O99 Otras enfermedades maternas clasificables en otra parte, pero que complican el embarazo, el parto y el puerperio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1005,'P00 Feto y recién nacido afectados por condiciones de la madre no necesariamente relacionadas con el embarazo presente')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1006,'P01 Feto y recién nacido afectados por complicaciones maternas del embarazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1007,'P02 Feto y recién nacido afectados por complicaciones de la placenta, del cordón umbilical y de las membranas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1008,'P03 Feto y recién nacido afectados por otras complicaciones del trabajo de parto y del parto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1009,'P04 Feto y recién nacido afectados por influencias nocivas transmitidas a través de la placenta o de la leche materna')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1010,'P05 Retardo del crecimiento fetal y desnutrición fetal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1011,'P07 Trastornos relacionados con duración corta de la gestación y con bajo peso al nacer, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1012,'P08 Trastornos relacionados con el embarazo prolongado y con sobrepeso al nacer')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1013,'P10 Hemorragia y laceración intracraneal debidas a traumatismo del nacimiento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1014,'P11 Otros traumatismos del nacimiento en el sistema nervioso central')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1015,'P12 Traumatismo del nacimiento en el cuero cabelludo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1016,'P13 Traumatismo del esqueleto durante el nacimiento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1017,'P14 Traumatismo del sistema nervioso periférico durante el nacimiento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1018,'P15 Otros traumatismos del nacimiento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1019,'P20 Hipoxia intrauterina')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1020,'P21 Asfixia del nacimiento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1021,'P22 Dificultad respiratoria del recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1022,'P23 Neumonía congénita')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1023,'P24 Síndromes de aspiración neonatal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1024,'P25 Enfisema intersticial y afecciones relacionadas, originadas en el período perinatal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1025,'P26 Hemorragia pulmonar originada en el período perinatal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1026,'P27 Enfermedad respiratoria crónica originada en el período perinatal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1027,'P28 Otros problemas respiratorios del recién nacido, originados en el período perinatal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1028,'P29 Trastornos cardiovasculares originados en el período perinatal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1029,'P35 Enfermedades virales congénitas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1030,'P36 Sepsis bacteriana del recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1031,'P37 Otras enfermedades infecciosas y parasitarias congénitas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1032,'P38 Onfalitis del recién nacido con o sin hemorragia leve')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1033,'P39 Otras infecciones específicas del período perinatal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1034,'P50 Pérdida de sangre fetal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1035,'P51 Hemorragia umbilical del recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1036,'P52 Hemorragia intracraneal no traumática del feto y del recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1037,'P53 Enfermedad hemorrágica del feto y del recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1038,'P54 Otras hemorragias neonatales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1039,'P55 Enfermedad hemolítica del feto y del recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1040,'P56 Hidropesía fetal debida a enfermedad hemolítica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1041,'P57 Kernicterus')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1042,'P58 Ictericia neonatal debida a otras hemólisis excesivas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1043,'P59 Ictericia neonatal por otras causas y por las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1044,'P60 Coagulación intravascular diseminada en el feto y el recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1045,'P61 Otros trastornos hematológicos perinatales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1046,'P70 Trastornos transitorios del metabolismo de los carbohidratos específicos del feto y del recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1047,'P71 Trastornos neonatales transitorios del metabolismo del calcio y del magnesio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1048,'P72 Otros trastornos endocrinos neonatales transitorios')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1049,'P74 Otras alteraciones metabólicas y electrolíticas neonatales transitorias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1050,'P75* Ileo meconial (E84.1+)')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1051,'P76 Otras obstrucciones intestinales del recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1052,'P77 Enterocolitis necrotizante del feto y del recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1053,'P78 Otros trastornos perinatales del sistema digestivo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1054,'P80 Hipotermia del recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1055,'P81 Otras alteraciones de la regulación de la temperatura en el recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1056,'P83 Otras afecciones de la piel específicas del feto y del recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1057,'P90 Convulsiones del recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1058,'P91 Otras alteraciones cerebrales del recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1059,'P92 Problemas de la ingestión de alimentos del recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1060,'P93 Reacciones e intoxicaciones debidas a drogas administradas al feto y al recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1061,'P94 Trastornos del tono muscular en el recién nacido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1062,'P95 Muerte fetal de causa no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1063,'P96 Otras afecciones originadas en el período perinatal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1064,'Q00 Anencefalia y malformaciones congénitas similares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1065,'Q01 Encefalocele')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1066,'Q02 Microcefalia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1067,'Q03 Hidrocéfalo congénito')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1068,'Q04 Otras malformaciones congénitas del encéfalo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1069,'Q05 Espina bífida')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1070,'Q06 Otras malformaciones congénitas de la médula espinal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1071,'Q07 Otras malformaciones congénitas del sistema nervioso')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1072,'Q10 Malformaciones congénitas de los párpados, del aparato lagrimal y de la órbita')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1073,'Q11 Anoftalmía, microftalmía y macroftalmía')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1074,'Q12 Malformaciones congénitas del cristalino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1075,'Q13 Malformaciones congénitas del segmento anterior del ojo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1076,'Q14 Malformaciones congénitas del segmento posterior del ojo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1077,'Q15 Otras malformaciones congénitas del ojo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1078,'Q16 Malformaciones congénitas del oído que causan alteración de la audición')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1079,'Q17 Otras malformaciones congénitas del oído')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1080,'Q18 Otras malformaciones congénitas de la cara y del cuello')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1081,'Q20 Malformaciones congénitas de las cámaras cardíacas y sus conexiones')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1082,'Q21 Malformaciones congénitas de los tabiques cardíacos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1083,'Q22 Malformaciones congénitas de las válvulas pulmonar y tricúspide')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1084,'Q23 Malformaciones congénitas de las válvulas aórtica y mitral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1085,'Q24 Otras malformaciones congénitas del corazón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1086,'Q25 Malformaciones congénitas de las grandes arterias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1087,'Q26 Malformaciones congénitas de las grandes venas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1088,'Q27 Otras malformaciones congénitas del sistema vascular periférico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1089,'Q28 Otras malformaciones congénitas del sistema circulatorio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1090,'Q30 Malformaciones congénitas de la nariz')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1091,'Q31 Malformaciones congénitas de la laringe')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1092,'Q32 Malformaciones congénitas de la tráquea y de los bronquios')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1093,'Q33 Malformaciones congénitas del pulmón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1094,'Q34 Otras malformaciones congénitas del sistema respiratorio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1095,'Q35 Fisura del paladar')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1096,'Q36 Labio leporino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1097,'Q37 Fisura del paladar con labio leporino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1098,'Q38 Otras malformaciones congénitas de la lengua, de la boca y de la faringe')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1099,'Q39 Malformaciones congénitas del esófago')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1100,'Q40 Otras malformaciones congénitas de la parte superior del tubo digestivo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1101,'Q41 Ausencia, atresia y estenosis congénita del intestino delgado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1102,'Q42 Ausencia, atresia y estenosis congénita del intestino grueso')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1103,'Q43 Otras malformaciones congénitas del intestino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1104,'Q44 Malformaciones congénitas de la vesícula biliar, de los conductos biliares y  del hígado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1105,'Q45 Otras malformaciones congénitas del sistema digestivo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1106,'Q50 Malformaciones congénitas de los ovarios, de las trompas de Falopio y de los ligamentos anchos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1107,'Q51 Malformaciones congénitas del útero y del cuello uterino')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1108,'Q52 Otras malformaciones congénitas de los órganos genitales femeninos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1109,'Q53 Testículo no descendido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1110,'Q54 Hipospadias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1111,'Q55 Otras malformaciones congénitas de los órganos genitales masculinos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1112,'Q56 Sexo indeterminado y seudohermafroditismo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1113,'Q60 Agenesia renal y otras malformaciones hipoplásicas del riñón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1114,'Q61 Enfermedad quística del riñón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1115,'Q62 Defectos obstructivos congénitos de la pelvis renal y malformaciones  congénitas del uréter')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1116,'Q63 Otras malformaciones congénitas del riñón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1117,'Q64 Otras malformaciones congénitas del sistema urinario')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1118,'Q65 Deformidades congénitas de la cadera')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1119,'Q66 Deformidades congénitas de los pies')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1120,'Q67 Deformidades osteomusculares congénitas de la cabeza, de la cara, de la  columna vertebral y del tórax')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1121,'Q68 Otras deformidades osteomusculares congénitas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1122,'Q69 Polidactilia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1123,'Q70 Sindactilia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1124,'Q71 Defectos por reducción del miembro superior')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1125,'Q72 Defectos por reducción del miembro inferior')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1126,'Q73 Defectos por reducción de miembro no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1127,'Q74 Otras anomalías congénitas del (de los) miembro(s)')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1128,'Q75 Otras malformaciones congénitas de los huesos del cráneo y de la cara')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1129,'Q76 Malformaciones congénitas de la columna vertebral y tórax óseo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1130,'Q77 Osteocondrodisplasia con defecto del crecimiento de los huesos largos y de la columna vertebral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1131,'Q78 Otras osteocondrodisplasias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1132,'Q79 Malformaciones congénitas del sistema osteomuscular, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1133,'Q80 Ictiosis congénita')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1134,'Q81 Epidermólisis bullosa')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1135,'Q82 Otras malformaciones congénitas de la piel')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1136,'Q83 Malformaciones congénitas de la mama')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1137,'Q84 Otras malformaciones congénitas de las faneras')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1138,'Q85 Facomatosis, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1139,'Q86 Síndromes de malformaciones congénitas debidos a causas exógenas conocidas, no  clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1140,'Q87 Otros síndromes de malformaciones congénitas especificados que afectan múltiples sistemas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1141,'Q89 Otras malformaciones congénitas, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1142,'Q90 Síndrome de Down')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1143,'Q91 Síndrome de Edwards y síndrome de Patau')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1144,'Q92 Otras trisomías y trisomías parciales de los autosomas, no clasificadas en otra  parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1145,'Q93 Monosomías y supresiones de los autosomas, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1146,'Q95 Reordenamientos equilibrados y marcadores estructurales, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1147,'Q96 Síndrome de Turner')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1148,'Q97 Otras anomalías de los cromosomas sexuales, con fenotipo femenino, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1149,'Q98 Otras anomalías de los cromosomas sexuales, con fenotipo masculino, no clasificadas en otra  parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1150,'Q99 Otras anomalías cromosómicas, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1151,'R00 Anormalidades del latido cardíaco')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1152,'R01 Soplos y otros sonidos cardíacos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1153,'R02 Gangrena, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1154,'R03 Lectura de presión sanguínea anormal, sin diagnóstico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1155,'R04 Hemorragias de las vías respiratorias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1156,'R05 Tos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1157,'R06 Anormalidades de la respiración')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1158,'R07 Dolor de garganta y en el pecho')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1159,'R09 Otros síntomas y signos que involucran los sistemas circulatorio y respiratorio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1160,'R10 Dolor abdominal y pélvico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1161,'R11 Náusea y vómito')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1162,'R12 Acidez')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1163,'R13 Disfagia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1164,'R14 Flatulencia y afecciones afines')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1165,'R15 Incontinencia fecal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1166,'R16 Hepatomegalia y esplenomegalia, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1167,'R17 Ictericia no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1168,'R18 Ascitis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1169,'R19 Otros síntomas y signos que involucran el sistema digestivo y el abdomen')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1170,'R20 Alteraciones de la sensibilidad cutánea')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1171,'R21 Salpullido y otras erupciones cutáneas no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1172,'R22 Tumefacción, masa o prominencia de la piel y del tejido subcutáneo localizadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1173,'R23 Otros cambios en la piel')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1174,'R25 Movimientos involuntarios anormales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1175,'R26 Anormalidades de la marcha y de la movilidad')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1176,'R27 Otras fallas de coordinación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1177,'R29 Otros síntomas y signos que involucran los sistemas nervioso y  osteomuscular')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1178,'R30 Dolor asociado con la micción')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1179,'R31 Hematuria, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1180,'R32 Incontinencia urinaria, no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1181,'R33 Retención de orina')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1182,'R34 Anuria y oliguria')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1183,'R35 Poliuria')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1184,'R36 Descarga uretral')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1185,'R39 Otros síntomas y signos que involucran el sistema urinario')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1186,'R40 Somnolencia, estupor y coma')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1187,'R41 Otros síntomas y signos que involucran la función cognoscitiva y la  conciencia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1188,'R42 Mareo y desvanecimiento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1189,'R43 Trastornos del olfato y del gusto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1190,'R44 Otros síntomas y signos que involucran las sensaciones y percepciones  generales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1191,'R45 Síntomas y signos que involucran el estado emocional')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1192,'R46 Síntomas y signos que involucran la apariencia y el comportamiento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1193,'R47 Alteraciones del habla, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1194,'R48 Dislexia y otras disfunciones simbólicas, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1195,'R49 Alteraciones de la voz')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1196,'R50 Fiebre de origen desconocido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1197,'R51 Cefalea')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1198,'R52 Dolor, no clasificado en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1199,'R53 Malestar y fatiga')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1200,'R54 Senilidad')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1201,'R55 Síncope y colapso')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1202,'R56 Convulsiones, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1203,'R57 Choque, no clasificado en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1204,'R58 Hemorragia, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1205,'R59 Adenomegalia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1206,'R60 Edema, no clasificado en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1207,'R61 Hiperhidrosis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1208,'R62 Falta del desarrollo fisiológico normal esperado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1209,'R63 Síntomas y signos concernientes a la alimentación y a la ingestión de líquidos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1210,'R64 Caquexia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1211,'R68 Otros síntomas y signos generales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1212,'R69 Causas de morbilidad desconocidas y no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1213,'R70 Velocidad de eritrosedimentación elevada y otras anormalidades de la viscosidad del plasma')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1214,'R71 Anormalidad de los eritrocitos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1215,'R72 Anormalidades de los leucocitos, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1216,'R73 Nivel elevado de glucosa en sangre')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1217,'R74 Nivel anormal de enzimas en suero')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1218,'R75 Evidencias de laboratorio del virus de la inmunodeficiencia humana [VIH]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1219,'R76 Otros hallazgos inmunológicos anormales en suero')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1220,'R77 Otras anormalidades de las proteínas plasmáticas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1221,'R78 Hallazgo de drogas y otras sustancias que normalmente no se encuentran en  la sangre')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1222,'R79 Otros hallazgos anormales en la química sanguínea')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1223,'R80 Proteinuria aislada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1224,'R81 Glucosuria')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1225,'R82 Otros hallazgos anormales en la orina')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1226,'R83 Hallazgos anormales en el líquido cefalorraquídeo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1227,'R84 Hallazgos anormales en muestras tomadas de órganos respiratorios y  torácicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1228,'R85 Hallazgos anormales en muestras tomadas de órganos digestivos y de la cavidad abdominal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1229,'R86 Hallazgos anormales en muestras tomadas de órganos genitales masculinos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1230,'R87 Hallazgos anormales en muestras tomadas de órganos genitales femeninos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1231,'R89 Hallazgos anormales en muestras tomadas de otros órganos, sistemas y tejidos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1232,'R90 Hallazgos anormales en diagnóstico por imagen del sistema nervioso central')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1233,'R91 Hallazgos anormales en diagnóstico por imagen del pulmón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1234,'R92 Hallazgos anormales en diagnóstico por imagen de la mama')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1235,'R93 Hallazgos anormales en diagnóstico por imagen de otras estructuras del  cuerpo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1236,'R94 Resultados anormales en estudios funcionales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1237,'R95 Síndrome de la muerte súbita infantil')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1238,'R96 Otras muertes súbitas de causa desconocida')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1239,'R98 Muerte sin asistencia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1240,'R99 Otras causas mal definidas y las no especificadas de mortalidad')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1241,'S00 Traumatismo superficial de la cabeza')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1242,'S01 Herida de la cabeza')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1243,'S02 Fractura de huesos del cráneo y de la cara')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1244,'S03 Luxación, esguince y torcedura de articulaciones y de ligamentos de la cabeza')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1245,'S04 Traumatismo de nervios craneales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1246,'S05 Traumatismo del ojo y de la órbita')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1247,'S06 Traumatismo intracraneal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1248,'S07 Traumatismo por aplastamiento de la cabeza')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1249,'S08 Amputación traumática de parte de la cabeza')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1250,'S09 Otros traumatismos y los no especificados de la cabeza')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1251,'S10 Traumatismo superficial del cuello')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1252,'S11 Herida del cuello')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1253,'S12 Fractura del cuello')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1254,'S13 Luxación, esguince y torcedura de articulaciones y ligamentos del cuello')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1255,'S14 Traumatismo de la médula espinal y de nervios a nivel del cuello')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1256,'S15 Traumatismo de vasos sanguíneos a nivel del cuello')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1257,'S16 Traumatismo de tendón y músculos a nivel del cuello')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1258,'S17 Traumatismo por aplastamiento del cuello')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1259,'S18 Amputación traumática a nivel del cuello')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1260,'S19 Otros traumatismos y los no especificados del cuello')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1261,'S20 Traumatismo superficial del tórax')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1262,'S21 Herida del tórax')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1263,'S22 Fractura de las costillas, del esternón y de la columna torácica [dorsal]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1264,'S23 Luxación, esguince y torcedura de articulaciones y ligamentos del tórax')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1265,'S24 Traumatismo de nervios y de la médula espinal a nivel del tórax')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1266,'S25 Traumatismo de vasos sanguíneos del tórax')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1267,'S26 Traumatismo del corazón')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1268,'S27 Traumatismo de otros órganos intratorácicos y de los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1269,'S28 Traumatismo por aplastamiento del tórax y amputación traumática de parte del tórax')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1270,'S29 Otros traumatismos y los no especificados del tórax')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1271,'S30 Traumatismo superficial del abdomen, de la región lumbosacra y de la pelvis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1272,'S31 Herida del abdomen, de la región lumbosacra y de la pelvis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1273,'S32 Fractura de la columna lumbar y de la pelvis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1274,'S33 Luxación, esguince y torcedura de articulaciones y ligamentos de la columna lumbar y de la pelvis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1275,'S34 Traumatismo de los nervios y de la médula espinal lumbar, a nivel del abdomen, de la región lumbosacra y de la pelvis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1276,'S35 Traumatismo de vasos sanguíneos a nivel del abdomen, de la región  lumbosacra y de la pelvis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1277,'S36 Traumatismo de órganos intraabdominales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1278,'S37 Traumatismo del aparato urinario y de los órganos pélvicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1279,'S38 Traumatismo por aplastamiento y amputación traumática de parte del abdomen, de la región lumbosacra y de la pelvis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1280,'S39 Otros traumatismos y los no especificados del abdomen, de la región lumbosacra y de la pelvis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1281,'S40 Traumatismo superficial del hombro y del brazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1282,'S41 Herida del hombro y del brazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1283,'S42 Fractura del hombro y del brazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1284,'S43 Luxación, esguince y torcedura de articulaciones y ligamentos de la cintura escapular')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1285,'S44 Traumatismo de nervios a nivel del hombro y del brazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1286,'S45 Traumatismo de vasos sanguíneos a nivel del hombro y del brazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1287,'S46 Traumatismo de tendón y músculo a nivel del hombro y del brazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1288,'S47 Traumatismo por aplastamiento del hombro y del brazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1289,'S48 Amputación traumática del hombro y del brazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1290,'S49 Otros traumatismos y los no especificados del hombro y del brazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1291,'S50 Traumatismo superficial del antebrazo y del codo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1292,'S51 Herida del antebrazo y del codo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1293,'S52 Fractura del antebrazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1294,'S53 Luxación, esguince y torcedura de articulaciones y ligamentos del codo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1295,'S54 Traumatismo de nervios a nivel del antebrazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1296,'S55 Traumatismo de los vasos sanguíneos a nivel del antebrazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1297,'S56 Traumatismo de tendón y músculo a nivel del antebrazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1298,'S57 Traumatismo por aplastamiento del antebrazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1299,'S58 Amputación traumática del antebrazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1300,'S59 Otros traumatismos y los no especificados del antebrazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1301,'S60 Traumatismo superficial de la muñeca y de la mano')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1302,'S61 Herida de la muñeca y de la mano')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1303,'S62 Fractura a nivel de la muñeca y de la mano')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1304,'S63 Luxación, esguince y torcedura de articulaciones y ligamentos a nivel de la muñeca y de la mano')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1305,'S64 Traumatismo de nervios a nivel de la muñeca y de la mano')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1306,'S65 Traumatismo de vasos sanguíneos a nivel de la muñeca y de la mano')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1307,'S66 Traumatismo de tendón y músculo a nivel de la muñeca y de la mano')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1308,'S67 Traumatismo por aplastamiento de la muñeca y de la mano')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1309,'S68 Amputación traumática de la muñeca y de la mano')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1310,'S69 Otros traumatismos y los no especificados de la muñeca y de la mano')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1311,'S70 Traumatismo superficial de la cadera y del muslo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1312,'S71 Herida de la cadera y del muslo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1313,'S72 Fractura del fémur')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1314,'S73 Luxación, esguince y torcedura de la articulación y de los ligamentos de la cadera')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1315,'S74 Traumatismo de nervios a nivel de la cadera y del muslo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1316,'S75 Traumatismo de vasos sanguíneos a nivel de la cadera y del muslo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1317,'S76 Traumatismo de tendón y músculo a nivel de la cadera y del muslo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1318,'S77 Traumatismo por aplastamiento de la cadera y del muslo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1319,'S78 Amputación traumática de la cadera y del muslo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1320,'S79 Otros traumatismos y los no especificados de la cadera y del muslo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1321,'S80 Traumatismo superficial de la pierna')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1322,'S81 Herida de la pierna')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1323,'S82 Fractura de la pierna, inclusive el tobillo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1324,'S83 Luxación, esguince y torcedura de articulaciones y ligamentos de la rodilla')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1325,'S84 Traumatismo de nervios a nivel de la pierna')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1326,'S85 Traumatismo de vasos sanguíneos a nivel de la pierna')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1327,'S86 Traumatismo de tendón y músculo a nivel de la pierna')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1328,'S87 Traumatismo por aplastamiento de la pierna')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1329,'S88 Amputación traumática de la pierna')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1330,'S89 Otros traumatismos y los no especificados de la pierna')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1331,'S90 Traumatismo superficial del tobillo y del pie')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1332,'S91 Herida del tobillo y del pie')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1333,'S92 Fractura del pie, excepto del tobillo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1334,'S93 Luxación, esguince y torcedura de articulaciones y ligamentos del tobillo y del pie')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1335,'S94 Traumatismo de nervios a nivel del pie y del tobillo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1336,'S95 Traumatismo de vasos sanguíneos a nivel del pie y del tobillo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1337,'S96 Traumatismo de tendón y músculo a nivel del pie y del tobillo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1338,'S97 Traumatismo por aplastamiento del pie y del tobillo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1339,'S98 Amputación traumática del pie y del tobillo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1340,'S99 Otros traumatismos y los no especificados del pie y del tobillo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1341,'T00 Traumatismos superficiales que afectan múltiples regiones del cuerpo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1342,'T01 Heridas que afectan múltiples regiones del cuerpo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1343,'T02 Fracturas que afectan múltiples regiones del cuerpo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1344,'T03 Luxaciones, torceduras y esguinces que afectan múltiples regiones del cuerpo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1345,'T04 Traumatismos por aplastamiento que afectan múltiples regiones del cuerpo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1346,'T05 Amputaciones traumáticas que afectan múltiples regiones del cuerpo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1347,'T06 Otros traumatismos que afectan múltiples regiones del cuerpo, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1348,'T07 Traumatismos múltiples, no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1349,'T08 Fractura de la columna vertebral, nivel no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1350,'T09 Otros traumatismos de la columna vertebral y del tronco, nivel no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1351,'T10 Fractura de miembro superior, nivel no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1352,'T11 Otros traumatismos de miembro superior, nivel no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1353,'T12 Fractura de miembro inferior, nivel no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1354,'T13 Otros traumatismos de miembro inferior, nivel no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1355,'T14 Traumatismo de regiones no especificadas del cuerpo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1356,'T15 Cuerpo extraño en parte externa del ojo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1357,'T16 Cuerpo extraño en el oído')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1358,'T17 Cuerpo extraño en las vías respiratorias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1359,'T18 Cuerpo extraño en el tubo digestivo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1360,'T19 Cuerpo extraño en las vías genitourinarias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1361,'T20 Quemadura y corrosión de la cabeza y del cuello')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1362,'T21 Quemadura y corrosión del tronco')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1363,'T22 Quemadura y corrosión del hombro y miembro superior, excepto de la muñeca y de la mano')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1364,'T23 Quemadura y corrosión de la muñeca y de la mano')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1365,'T24 Quemadura y corrosión de la cadera y miembro inferior, excepto tobillo y pie')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1366,'T25 Quemadura y corrosión del tobillo y del pie')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1367,'T26 Quemadura y corrosión limitada al ojo y sus anexos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1368,'T27 Quemadura y corrosión de las vías respiratorias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1369,'T28 Quemadura y corrosión de otros órganos internos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1370,'T29 Quemaduras y corrosiones de múltiples regiones del cuerpo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1371,'T30 Quemadura y corrosión, región del cuerpo no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1372,'T31 Quemaduras clasificadas según la extensión de la superficie del cuerpo afectada T31.0Quemaduras que afectan menos del 10% de la superficie del cuerpo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1373,'T32 Corrosiones clasificadas según la extensión de la superficie del cuerpo afectada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1374,'T33 Congelamiento superficial')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1375,'T34 Congelamiento con necrosis tisular')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1376,'T35 Congelamiento que afecta múltiples regiones del cuerpo y congelamiento no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1377,'T36 Envenenamiento por antibióticos sistémicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1378,'T37 Envenenamiento por otros antiinfecciosos y antiparasitarios sistémicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1379,'T38 Envenenamiento por hormonas y sus sustitutos y antagonistas sintéticos, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1380,'T39 Envenenamiento por analgésicos no narcóticos, antipiréticos y antirreumáticos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1381,'T40 Envenenamiento por narcóticos y psicodislépticos [alucinógenos]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1382,'T41 Envenenamiento por anestésicos y gases terapéuticos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1383,'T42 Envenenamiento por antiepilépticos, hipnóticos-sedantes y drogas antiparkinsonianas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1384,'T43 Envenenamiento por Envenenamiento por psicotrópicos, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1385,'T44 Envenenamiento por drogas que afectan principalmente el sistema nervioso  autónomo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1386,'T45 Envenenamiento por Envenenamiento por agentes principalmente sistémicos y hematológicos, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1387,'T46 Envenenamiento por agentes que afectan principalmente el sistema  cardiovascular')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1388,'T47 Envenenamiento por agentes que afectan principalmente el sistema  gastrointestinal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1389,'T48 Envenenamiento por agentes con acción principal sobre los músculos lisos y esqueléticos y sobre el sistema respiratorio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1390,'T49 Envenenamiento por agentes tópicos que afectan principalmente la piel y las membranas mucosas y por drogas oftalmológicas, otorrinolaringológicas y dentales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1391,'T50 Envenenamiento por diuréticos y otras drogas, medicamentos y sustancias biológicas no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1392,'T51 Envenenamiento por Efecto tóxico del alcohol')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1393,'T52 Envenenamiento por Efecto tóxico de disolventes orgánicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1394,'T53 Envenenamiento por Efecto tóxico de los derivados halogenados de los hidrocarburos alifáticos y aromáticos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1395,'T54 Envenenamiento por Efecto tóxico de sustancias corrosivas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1396,'T55 Envenenamiento por Efecto tóxico de detergentes y jabones')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1397,'T56 Envenenamiento por Efecto tóxico de metales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1398,'T57 Envenenamiento por Efecto tóxico de otras sustancias inorgánicas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1399,'T58 Envenenamiento por Efecto tóxico del monóxido de carbono')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1400,'T59 Envenenamiento por Efecto tóxico de otros gases, humos y vapores')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1401,'T60 Envenenamiento por Efecto tóxico de plaguicidas [pesticidas]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1402,'T61 Envenenamiento por Efecto tóxico de sustancias nocivas ingeridas como alimentos marinos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1403,'T62 Envenenamiento por Efecto tóxico de otras sustancias nocivas ingeridas como alimento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1404,'T63 Envenenamiento por Efecto tóxico del contacto con animales venenosos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1405,'T64 Envenenamiento por Efecto tóxico de aflatoxina y otras micotoxinas contaminantes de alimentos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1406,'T65 Envenenamiento por Efecto tóxico de otras sustancias y las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1407,'T66 Efectos no especificados de la radiación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1408,'T67 Efectos del calor y de la luz')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1409,'T68 Hipotermia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1410,'T69 Otros efectos de la reducción de la temperatura')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1411,'T70 Efectos de la presión del aire y de la presión del agua')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1412,'T71 Asfixia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1413,'T73 Efectos de otras privaciones')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1414,'T74 Síndromes del maltrato')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1415,'T75 Efectos de otras causas externas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1416,'T78 Efectos adversos, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1417,'T79 Algunas complicaciones precoces de traumatismos, no clasificadas en otra  parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1418,'T80 Complicaciones consecutivas a infusión, transfusión e inyección terapéutica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1419,'T81 Complicaciones de procedimientos, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1420,'T82 Complicaciones de dispositivos protésicos, implantes e injertos  cardiovasculares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1421,'T83 Complicaciones de dispositivos, implantes e injertos genitourinarios')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1422,'T84 Complicaciones de dispositivos protésicos, implantes e injertos ortopédicos internos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1423,'T85 Complicaciones de otros dispositivos protésicos, implantes e injertos internos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1424,'T86 Falla y rechazo del trasplante de órganos y tejidos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1425,'T87 Complicaciones peculiares de la reinserción y amputación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1426,'T88 Otras complicaciones de la atención médica y quirúrgica, no clasificadas en  otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1427,'T90 Secuelas de traumatismos de la cabeza')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1428,'T91 Secuelas de traumatismos del cuello y del tronco')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1429,'T92 Secuelas de traumatismos de miembro superior')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1430,'T93 Secuelas de traumatismos de miembro inferior')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1431,'T94 Secuelas de traumatismos que afectan múltiples regiones del cuerpo y las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1432,'T95 Secuelas de quemaduras, corrosiones y congelamientos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1433,'T96 Secuelas de envenenamientos por drogas, medicamentos y sustancias  biológicas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1434,'T97 Secuelas de efectos tóxicos de sustancias de procedencia principalmente no medicinal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1435,'T98 Secuelas de otros efectos y los no especificados de causas externas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1436,'V01 Peatón lesionado por colisión con vehículo de pedal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1437,'V02 Peatón lesionado por colisión con vehículo de motor de dos o tres ruedas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1438,'V03 Peatón lesionado por colisión con automóvil, camioneta o furgoneta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1439,'V04 Peatón lesionado por colisión con vehículo de transporte pesado o autobús')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1440,'V05 Peatón lesionado por colisión con tren o vehículo de rieles')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1441,'V06 Peatón lesionado por colisión con otros vehículos sin motor')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1442,'V09 Peatón lesionado en otros accidentes de transporte, y en los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1443,'V10 Ciclista lesionado por colisión con peatón o animal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1444,'V11 Ciclista lesionado por colisión con otro ciclista')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1445,'V12 Ciclista lesionado por colisión con vehículo de motor de dos o tres ruedas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1446,'V13 Ciclista lesionado por colisión con automóvil, camioneta o furgoneta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1447,'V14 Ciclista lesionado por colisión con vehículo de transporte pesado o autobús')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1448,'V15 Ciclista lesionado por colisión con tren o vehículo de rieles')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1449,'V16 Ciclista lesionado por colisión con otros vehículos sin motor')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1450,'V17 Ciclista lesionado por colisión con objeto estacionado o fijo,')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1451,'V18 Ciclista lesionado en accidente de transporte sin colisión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1452,'V19 Ciclista lesionado en otros accidentes de transporte, y en los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1453,'V20 Motociclista lesionado por colisión con peatón o animal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1454,'V21 Motociclista lesionado por colisión con vehículo de pedal,')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1455,'V22 Motociclista lesionado por colisión con vehículo de motor de dos o tres ruedas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1456,'V23 Motociclista lesionado por colisión con automóvil, camioneta o furgoneta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1457,'V24 Motociclista lesionado por colisión con vehículo de transporte pesado o autobús')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1458,'V25 Motociclista lesionado por colisión con tren o vehículo de rieles')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1459,'V26 Motociclista lesionado por colisión con otros vehículos sin motor')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1460,'V27 Motociclista lesionado por colisión con objeto fijo o estacionado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1461,'V28 Motociclista lesionado en accidente de transporte sin colisión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1462,'V29 Motociclista lesionado en otros accidentes de transporte, y en los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1463,'V30 Ocupante de vehículo de motor de tres ruedas lesionado por colisión con peatón o animal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1464,'V31 Ocupante de vehículo de motor de tres ruedas lesionado por colisión con vehículo de pedal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1465,'V32 Ocupante de vehículo de motor de tres ruedas lesionado por colisión con otro vehículo de motor de dos o tres ruedas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1466,'V33 Ocupante de vehículo de motor de tres ruedas lesionado por colisión con automóvil, camioneta o furgoneta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1467,'V34 Ocupante de vehículo de motor de tres ruedas lesionado por colisión con vehículo de transporte pesado o autobús')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1468,'V35 Ocupante de vehículo de motor de tres ruedas lesionado por colisión con tren o vehículo de rieles')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1469,'V36 Ocupante de vehículo de motor de tres ruedas lesionado por colisión con otros vehículos sin motor')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1470,'V37 Ocupante de vehículo de motor de tres ruedas lesionado por colisión con objeto fijo o estacionado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1471,'V38 Ocupante de vehículo de motor de tres ruedas lesionado en accidente de transporte sin colisión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1472,'V39 Ocupante de vehículo de motor de tres ruedas lesionado en otros accidentes de transporte, y  en los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1473,'V40 Ocupante de automóvil lesionado por colisión con peatón o animal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1474,'V41 Ocupante de automóvil lesionado por colisión con vehículo de pedal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1475,'V42 Ocupante de automóvil lesionado por colisión con vehículo de motor de dos o tres ruedas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1476,'V43 Ocupante de automóvil lesionado por colisión con otro automóvil, camioneta o furgoneta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1477,'V44 Ocupante de automóvil lesionado por colisión con vehículo de transporte pesado o autobús')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1478,'V45 Ocupante de automóvil lesionado por colisión con tren o vehículo de rieles')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1479,'V46 Ocupante de automóvil lesionado por colisión con otros vehículos sin motor')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1480,'V47 Ocupante de automóvil lesionado por colisión con objeto fijo o estacionado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1481,'V48 Ocupante de automóvil lesionado en accidente de transporte sin colisión,')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1482,'V49 Ocupante de automóvil lesionado en otros accidentes de transporte, y en los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1483,'V50 Ocupante de camioneta o furgoneta lesionado por colisión con peatón o animal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1484,'V51 Ocupante de camioneta o furgoneta lesionado por colisión con vehículo de pedal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1485,'V52 Ocupante de camioneta o furgoneta lesionado por colisión con vehículo de motor de dos o tres ruedas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1486,'V53 Ocupante de camioneta o furgoneta lesionado por colisión con automóvil, camioneta o furgoneta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1487,'V54 Ocupante de camioneta o furgoneta lesionado por colisión con vehículo de transporte pesado o autobús')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1488,'V55 Ocupante de camioneta o furgoneta lesionado por colisión con tren o vehículo de rieles')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1489,'V56 Ocupante de camioneta o furgoneta lesionado por colisión con otros vehículos sin motor')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1490,'V57 Ocupante de camioneta o furgoneta lesionado por colisión con objeto fijo o estacionado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1491,'V58 Ocupante de camioneta o furgoneta lesionado en accidente de transporte sin colisión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1492,'V59 Ocupante de camioneta o furgoneta lesionado en otros accidentes de transporte, y en los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1493,'V60 Ocupante de vehículo de transporte pesado lesionado por colisión con peatón o animal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1494,'V61 Ocupante de vehículo de transporte pesado lesionado por colisión con vehículo de pedal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1495,'V62 Ocupante de vehículo de transporte pesado lesionado por colisión con vehículo de motor de dos o tres ruedas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1496,'V63 Ocupante de vehículo de transporte pesado lesionado por colisión con automóvil, camioneta o furgoneta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1497,'V64 Ocupante de vehículo de transporte pesado lesionado por colisión con otro vehículo de transporte pesado o autobús')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1498,'V65 Ocupante de vehículo de transporte pesado lesionado por colisión con tren o vehículo de rieles')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1499,'V66 Ocupante de vehículo de transporte pesado lesionado por colisión con otros vehículos sin  motor')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1500,'V67 Ocupante de vehículo de transporte pesado lesionado por colisión con objeto fijo o estacionado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1501,'V68 Ocupante de vehículo de transporte pesado lesionado en accidente de transporte sin colisión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1502,'V69 Ocupante de vehículo de transporte pesado lesionado en otros accidentes de transporte, y en los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1503,'V70 Ocupante de autobús lesionado por colisión con peatón o animal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1504,'V71 Ocupante de autobús lesionado por colisión con vehículo de pedal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1505,'V72 Ocupante de autobús lesionado por colisión con vehículo de motor de dos o tres ruedas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1506,'V73 Ocupante de autobús lesionado por colisión con automóvil, camioneta o furgoneta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1507,'V74 Ocupante de autobús lesionado por colisión con vehículo de transporte pesado o autobús')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1508,'V75 Ocupante de autobús lesionado por colisión con tren o vehículo de rieles')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1509,'V76 Ocupante de autobús lesionado por colisión con otros vehículos sin motor')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1510,'V77 Ocupante de autobús lesionado por colisión con objeto fijo o estacionado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1511,'V78 Ocupante de autobús lesionado en accidente de transporte sin colisión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1512,'V79 Ocupante de autobús lesionado en otros accidentes de transporte, y en los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1513,'V80 Jinete u ocupante de vehículo de tracción animal lesionado en accidente de transporte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1514,'V81 Ocupante de tren o vehículo de rieles lesionado en accidente de transporte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1515,'V82 Ocupante de tranvía lesionado en accidente de transporte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1516,'V83 Ocupante de vehículo especial (de motor) para uso principalmente en plantas industriales lesionado en accidente de transporte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1517,'V84 Ocupante de vehículo especial (de motor) para uso principalmente en agricultura lesionado en accidente de transporte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1518,'V85 Ocupante de vehículo especial (de motor) para construcción lesionado en accidente de transporte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1519,'V86 Ocupante de vehículo especial para todo terreno o de otro vehículo de motor para uso fuera de la carretera lesionado en accidente de transporte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1520,'V87 Accidente de tránsito de tipo especificado, pero donde se desconoce el modo de transporte de la víctima')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1521,'V88 Accidente no de tránsito de tipo especificado, pero donde se desconoce el modo de transporte  de la víctima')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1522,'V89 Accidente de vehículo de motor o sin motor, tipo de vehículo no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1523,'V90 Accidente de embarcación que causa ahogamiento y sumersión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1524,'V91 Accidente de embarcación que causa otros tipos de traumatismo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1525,'V92 Ahogamiento y sumersión relacionados con transporte por agua, sin accidente a la embarcación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1526,'V93 Accidente en una embarcación, sin accidente a la embarcación, que no causa ahogamiento o sumersión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1527,'V94 Otros accidentes de transporte por agua, y los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1528,'V95 Accidente de aeronave de motor, con ocupante lesionado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1529,'V96 Accidente de aeronave sin motor, con ocupante lesionado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1530,'V97 Otros accidentes de transporte aéreo especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1531,'V98 Otros accidentes de transporte especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1532,'V99 Accidente de transporte no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1533,'W00 Caída en el mismo nivel por hielo o nieve')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1534,'W01 Caída en el mismo nivel por deslizamiento, tropezón y traspié')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1535,'W02 Caída por patines para hielo, esquís, patines de ruedas o patineta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1536,'W03 Otras caídas en el mismo nivel por colisión con o por empujón de otra persona')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1537,'W04 Caída al ser trasladado o sostenido por otras personas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1538,'W05 Caída que implica silla de ruedas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1539,'W06 Caída que implica cama')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1540,'W07 Caída que implica silla')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1541,'W08 Caída que implica otro mueble')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1542,'W09 Caída que implica equipos para juegos infantiles')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1543,'W10 Caída en o desde escalera y escalones')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1544,'W11 Caída en o desde escaleras manuales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1545,'W12 Caída en o desde andamio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1546,'W13 Caída desde, fuera o a través de un edificio u otra construcción')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1547,'W14 Caída desde un árbol')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1548,'W15 Caída desde peñasco')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1549,'W16 Salto o zambullida dentro del agua que causa otro traumatismo sin sumersión o ahogamiento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1550,'W17 Otras caídas de un nivel a otro')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1551,'W18 Otras caídas en el mismo nivel')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1552,'W19 Caída no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1553,'W20 Golpe por objeto arrojado, proyectado o que cae')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1554,'W21 Golpe contra o golpeado por equipo para deportes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1555,'W22 Golpe contra o golpeado por otros objetos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1556,'W23 Atrapado, aplastado, trabado o apretado en o entre objetos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1557,'W24 Contacto traumático con dispositivos de elevación y transmisión, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1558,'W25 Contacto traumático con vidrio cortante')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1559,'W26 Contacto traumático con cuchillo, espada, daga o puñal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1560,'W27 Contacto traumático con herramientas manuales sin motor')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1561,'W28 Contacto traumático con cortadora de césped, con motor')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1562,'W29 Contacto traumático con otras herramientas manuales y artefactos del hogar, con motor')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1563,'W30 Contacto traumático con maquinaria agrícola')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1564,'W31 Contacto traumático con otras maquinarias, y las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1565,'W32 Disparo de arma corta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1566,'W33 Disparo de rifle, escopeta y arma larga')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1567,'W34 Disparo de otras armas de fuego, y las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1568,'W35 Explosión y rotura de caldera')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1569,'W36 Explosión y rotura de cilindro con gas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1570,'W37 Explosión y rotura de neumático, tubo o manguera de goma presurizada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1571,'W38 Explosión y rotura de otros dispositivos presurizados especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1572,'W39 Explosión de fuegos artificiales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1573,'W40 Explosión de otros materiales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1574,'W41 Exposición a chorro de alta presión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1575,'W42 Exposición al ruido')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1576,'W43 Exposición a vibraciones')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1577,'W44 Cuerpo extraño que penetra por el ojo u orificio natural')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1578,'W45 Cuerpo extraño que penetra a través de la piel')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1579,'W49 Exposición a otras fuerzas mecánicas inanimadas, y las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1580,'W50 Aporreo, golpe, mordedura, patada, rasguño o torcedura infligidos por otra persona')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1581,'W51 Choque o empellón contra otra persona')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1582,'W52 Persona aplastada, empujada o pisoteada por una multitud o estampida humana')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1583,'W53 Mordedura de rata')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1584,'W54 Mordedura o ataque de perro')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1585,'W55 Mordedura o ataque de otros mamíferos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1586,'W56 Contacto traumático con animales marinos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1587,'W57 Mordedura o picadura de insectos y otros artrópodos no venenosos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1588,'W58 Mordedura o ataque de cocodrilo o caimán')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1589,'W59 Mordedura o aplastamiento por otros reptiles')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1590,'W60 Contacto traumático con aguijones, espinas u hojas cortantes de plantas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1591,'W64 Exposición a otras fuerzas mecánicas animadas, y las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1592,'W65 Ahogamiento y sumersión mientras se está en la bañera')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1593,'W66 Ahogamiento y sumersión consecutivos a caída en la bañera')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1594,'W67 Ahogamiento y sumersión mientras se está en una piscina')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1595,'W68 Ahogamiento y sumersión consecutivos a caída en una piscina')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1596,'W69 Ahogamiento y sumersión mientras se está en aguas naturales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1597,'W70 Ahogamiento y sumersión posterior a caída en aguas naturales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1598,'W73 Otros ahogamientos y sumersiones especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1599,'W74 Ahogamiento y sumersión no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1600,'W75 Sofocación y estrangulamiento accidental en la cama')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1601,'W76 Otros estrangulamientos y ahorcamientos accidentales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1602,'W77 Obstrucción de la respiración debida a hundimiento, caída de tierra u otras sustancias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1603,'W78 Inhalación de contenidos gástricos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1604,'W79 Inhalación e ingestión de alimento que causa obstrucción de las vías respiratorias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1605,'W80 Inhalación e ingestión de otros objetos que causan obstrucción de las vías respiratorias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1606,'W81 Confinado o atrapado en un ambiente con bajo contenido de oxígeno')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1607,'W83 Otras obstrucciones especificadas de la respiración')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1608,'W84 Obstrucción no especificada de la respiración')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1609,'W85 Exposición a líneas de transmisión eléctrica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1610,'W86 Exposición a otras corrientes eléctricas especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1611,'W87 Exposición a corriente eléctrica no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1612,'W88 Exposición a radiación ionizante')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1613,'W89 Exposición a fuente de luz visible y ultravioleta, de origen artificial')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1614,'W90 Exposición a otros tipos de radiación no ionizante')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1615,'W91 Exposición a radiación de tipo no especificado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1616,'W92 Exposición a calor excesivo de origen artificial')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1617,'W93 Exposición a frío excesivo de origen artificial')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1618,'W94 Exposición a presión de aire alta y baja y a cambios en la presión del aire')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1619,'W99 Exposición a otros factores ambientales y a los no especificados, de origen artificial')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1620,'X00 Exposición a fuego no controlado en edificio u otra construcción')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1621,'X01 Exposición a fuego no controlado en lugar que no es edificio u otra construcción')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1622,'X02 Exposición a fuego controlado en edificio u otra construcción')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1623,'X03 Exposición a fuego controlado en lugar que no es edificio u otra construcción')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1624,'X04 Exposición a ignición de material altamente inflamable')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1625,'X05 Exposición a ignición o fusión de ropas de dormir')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1626,'X06 Exposición a ignición o fusión de otras ropas y accesorios')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1627,'X08 Exposición a otros humos, fuegos o llamas especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1628,'X09 Exposición a humos, fuegos o llamas no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1629,'X10 Contacto con bebidas, alimentos, grasas y aceites para cocinar, calientes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1630,'X11 Contacto con agua caliente corriente')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1631,'X12 Contacto con otros líquidos calientes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1632,'X13 Contacto con vapor de agua y otros vapores calientes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1633,'X14 Contacto con aire y gases calientes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1634,'X15 Contacto con utensilios domésticos calientes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1635,'X16 Contacto con radiadores, cañerías y artefactos para calefacción, calientes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1636,'X17 Contacto con máquinas, motores y herramientas calientes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1637,'X18 Contacto con otros metales calientes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1638,'X19 Contacto con otras sustancias calientes, y las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1639,'X20 Contacto traumático con serpientes y lagartos venenosos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1640,'X21 Contacto traumático con arañas venenosas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1641,'X22 Contacto traumático con escorpión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1642,'X23 Contacto traumático con avispones, avispas y abejas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1643,'X24 Contacto traumático con centípodos y miriápodos venenosos (tropicales)')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1644,'X25 Contacto traumático con otros artrópodos venenosos especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1645,'X26 Contacto traumático con animales y plantas marinas venenosos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1646,'X27 Contacto traumático con otros animales venenosos especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1647,'X28 Contacto traumático con otras plantas venenosas especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1648,'X29 Contacto traumático con animales y plantas venenosos no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1649,'X30 Exposición al calor natural excesivo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1650,'X31 Exposición al frío natural excesivo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1651,'X32 Exposición a rayos solares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1652,'X33 Víctima de rayo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1653,'X34 Víctima de terremoto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1654,'X35 Víctima de erupción volcánica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1655,'X36 Víctima de avalancha, derrumbe y otros movimientos de tierra')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1656,'X37 Víctima de tormenta cataclísmica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1657,'X38 Víctima de inundación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1658,'X39 Exposición a otras fuerzas de la naturaleza, y las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1659,'X40 Envenenamiento accidental por, y exposición a analgésicos no narcóticos, antipiréticos y antirreumáticos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1660,'X41 Envenenamiento accidental por, y exposición a drogas antiepilépticas, sedantes, hipnóticas, antiparkinsonianas y psicotrópicas, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1661,'X42 Envenenamiento accidental por, y exposición a narcóticos y psicodislépticos [alucinógenos], no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1662,'X43 Envenenamiento accidental por, y exposición a otras drogas que actúan sobre el sistema nervioso autónomo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1663,'X44 Envenenamiento accidental por, y exposición a otras drogas, medicamentos y sustancias biológicas, y los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1664,'X45 Envenenamiento accidental por, y exposición al alcohol')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1665,'X46 Envenenamiento accidental por, y exposición a disolventes orgánicos e hidrocarburos halogenados y sus vapores')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1666,'X47 Envenenamiento accidental por, y exposición a otros gases y vapores')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1667,'X48 Envenenamiento accidental por, y exposición a plaguicidas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1668,'X49 Envenenamiento accidental por, y exposición a otros productos químicos y sustancias nocivas, y los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1669,'X50 Exceso de esfuerzo y movimientos extenuantes y repetitivos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1670,'X51 Viajes y desplazamientos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1671,'X52 Permanencia prolongada en ambiente sin gravedad')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1672,'X53 Privación de alimentos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1673,'X54 Privación de agua')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1674,'X57 Privación no especificada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1675,'X58 Exposición a otros factores especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1676,'X59 Exposición a factores no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1677,'X60 Envenenamiento autoinfligido intencionalmente por, y exposición a analgésicos no narcóticos, antipiréticos y antirreumáticos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1678,'X61 Envenenamiento autoinfligido intencionalmente por, y exposición a drogas antiepilépticas, sedantes, hipnóticas, antiparkinsonianas y psicotrópicas, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1679,'X62 Envenenamiento autoinfligido intencionalmente por, y exposición a narcóticos y psicodislépticos [alucinógenos], no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1680,'X63 Envenenamiento autoinfligido intencionalmente por, y exposición a otras drogas que actúan sobre el sistema nervioso autónomo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1681,'X64 Envenenamiento autoinfligido intencionalmente por, y exposición a otras drogas, medicamentos y sustancias biológicas, y los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1682,'X65 Envenenamiento autoinfligido intencionalmente por, y exposición al alcohol')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1683,'X66 Envenenamiento autoinfligido intencionalmente por, y exposición a disolventes orgánicos e hidrocarburos halogenados y sus vapores')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1684,'X67 Envenenamiento autoinfligido intencionalmente por, y exposición a otros gases y vapores')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1685,'X68 Envenenamiento autoinfligido intencionalmente por, y exposición a plaguicidas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1686,'X69 Envenenamiento autoinfligido intencionalmente por, y exposición a otros productos químicos y sustancias nocivas, y los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1687,'X70 Lesión autoinfligida intencionalmente por ahorcamiento, estrangulamiento o sofocación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1688,'X71 Lesión autoinfligida intencionalmente por ahogamiento y sumersión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1689,'X72 Lesión autoinfligida intencionalmente por disparo de arma corta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1690,'X73 Lesión autoinfligida intencionalmente por disparo de rifle, escopeta y arma larga')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1691,'X74 Lesión autoinfligida intencionalmente por disparo de otras armas de fuego, y las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1692,'X75 Lesión autoinfligida intencionalmente por material explosivo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1693,'X76 Lesión autoinfligida intencionalmente por humo, fuego y llamas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1694,'X77 Lesión autoinfligida intencionalmente por vapor de agua, vapores y objetos calientes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1695,'X78 Lesión autoinfligida intencionalmente por objeto cortante')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1696,'X79 Lesión autoinfligida intencionalmente por objeto romo o sin filo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1697,'X80 Lesión autoinfligida intencionalmente al saltar desde un lugar elevado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1698,'X81 Lesión autoinfligida intencionalmente por arrojarse o colocarse delante de objeto en movimiento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1699,'X82 Lesión autoinfligida intencionalmente por colisión de vehículo de motor')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1700,'X83 Lesión autoinfligida intencionalmente por otros medios especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1701,'X84 Lesión autoinfligida intencionalmente por medios no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1702,'X85 Agresión con drogas, medicamentos y sustancias biológicas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1703,'X86 Agresión con sustancia corrosiva')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1704,'X87 Agresión con plaguicidas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1705,'X88 Agresión con gases y vapores')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1706,'X89 Agresión con otros productos químicos y sustancias nocivas especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1707,'X90 Agresión con productos químicos y sustancias nocivas no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1708,'X91 Agresión por ahorcamiento, estrangulamiento y sofocación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1709,'X92 Agresión por  ahogamiento y sumersión')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1710,'X93 Agresión con disparo de arma corta')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1711,'X94 Agresión con disparo de rifle, escopeta y arma larga')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1712,'X95 Agresión con disparo de otras armas de fuego, y las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1713,'X96 Agresión con material explosivo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1714,'X97 Agresión con humo, fuego y llamas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1715,'X98 Agresión con vapor de agua, vapores y objetos calientes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1716,'X99 Agresión con objeto cortante')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1717,'Y00 Agresión con objeto romo o sin filo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1718,'Y01 Agresión por empujón desde un lugar elevado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1719,'Y02 Agresión por empujar o colocar a la víctima delante de objeto en movimiento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1720,'Y03 Agresión por colisión de vehículo de motor')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1721,'Y04 Agresión con fuerza corporal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1722,'Y05 Agresión sexual con fuerza corporal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1723,'Y06 Negligencia y abandono')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1724,'Y07 Otros síndromes de maltrato')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1725,'Y08 Agresión por otros medios especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1726,'Y09 Agresión por medios no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1727,'Y10 Envenenamiento por, y exposición a analgésicos no narcóticos, antipiréticos y antirreumáticos, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1728,'Y11 Envenenamiento por, y exposición a drogas antiepilépticas, sedantes, hipnóticas, antiparkinsonianas y psicotrópicas, no clasificadas en otra parte, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1729,'Y12 Envenenamiento por, y exposición a narcóticos y psicodislépticos [alucinógenos], no clasificados en otra parte, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1730,'Y13 Envenenamiento por, y exposición a otras drogas que actúan sobre el sistema nervioso autónomo, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1731,'Y14 Envenenamiento por, y exposición a otras drogas, medicamentos y sustancias biológicas, y las no especificadas, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1732,'Y15 Envenenamiento por, y exposición al alcohol, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1733,'Y16 Envenenamiento por, y exposición a disolventes orgánicos e hidrocarburos halogenados y sus vapores, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1734,'Y17 Envenenamiento por, y exposición a otros gases y vapores, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1735,'Y18 Envenenamiento por, y exposición a plaguicidas, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1736,'Y19 Envenenamiento por, y exposición a otros productos químicos y sustancias nocivas, y los no especificados, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1737,'Y20 Ahorcamiento, estrangulamiento y sofocación, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1738,'Y21 Ahogamiento y sumersión, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1739,'Y22 Disparo de arma corta, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1740,'Y23 Disparo de rifle, escopeta y arma larga, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1741,'Y24 Disparo de otras armas de fuego, y las no especificadas, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1742,'Y25 Contacto traumático con material explosivo, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1743,'Y26 Exposición al humo, fuego y llamas, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1744,'Y27 Contacto con vapor de agua, vapores y objetos calientes, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1745,'Y28 Contacto traumático con objeto cortante, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1746,'Y29 Contacto traumático con objeto romo o sin filo, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1747,'Y30 Caída, salto o empujón desde lugar elevado, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1748,'Y31 Caída, permanencia o carrera delante o hacia objeto en movimiento, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1749,'Y32 Colisión de vehículo de motor, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1750,'Y33 Otros eventos especificados, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1751,'Y34 Evento no especificado, de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1752,'Y35 Intervención legal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1753,'Y36 Operaciones de guerra')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1754,'Y40 Efectos adversos de antibióticos sistémicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1755,'Y41 Efectos adversos de otros antiinfecciosos y antiparasitarios sistémicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1756,'Y42 Efectos adversos de hormonas y sus sustitutos sintéticos y antagonistas, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1757,'Y43 Efectos adversos de agentes sistémicos primarios')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1758,'Y44 Efectos adversos de agentes que afectan primariamente los constituyentes de la sangre')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1759,'Y45 Efectos adversos de drogas analgésicas, antipiréticas y antiinflamatorias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1760,'Y46 Efectos adversos de drogas antiepilépticas y antiparkinsonianas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1761,'Y47 Efectos adversos de drogas sedantes, hipnóticas y ansiolíticas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1762,'Y48 Efectos adversos de gases anestésicos y terapéuticos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1763,'Y49 Efectos adversos de drogas psicotrópicas, no clasificadas en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1764,'Y50 Efectos adversos de estimulantes del sistema nervioso central, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1765,'Y51 Efectos adversos de drogas que afectan primariamente el sistema nervioso autónomo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1766,'Y52 Efectos adversos de agentes que afectan primariamente el sistema cardiovascular')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1767,'Y53 Efectos adversos de agentes que afectan primariamente el sistema gastrointestinal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1768,'Y54 Efectos adversos de agentes que afectan primariamente el equilibrio hídrico y el metabolismo mineral y del ácido úrico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1769,'Y55 Efectos adversos de agentes que actúan primariamente sobre los músculos lisos y estriados y sobre el sistema respiratorio')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1770,'Y56 Efectos adversos de agentes tópicos que afectan primariamente la piel y las membranas mucosas, y drogas oftalmológicas, otorrinolaringológicas y dentales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1771,'Y57 Efectos adversos de otras drogas y medicamentos, y los no especificados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1772,'Y58 Efectos adversos de vacunas bacterianas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1773,'Y59 Efectos adversos de otras vacunas y sustancias biológicas, y las no especificadas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1774,'Y60 Corte, punción, perforación o hemorragia no intencional durante la atención médica y quirúrgica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1775,'Y61 Objeto extraño dejado accidentalmente en el cuerpo durante la atención médica y quirúrgica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1776,'Y62 Fallas en la esterilización durante la atención médica y quirúrgica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1777,'Y63 Falla en la dosificación durante la atención médica y quirúrgica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1778,'Y64 Medicamentos o sustancias biológicas contaminados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1779,'Y65 Otros incidentes durante la atención médica y quirúrgica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1780,'Y66 No administración de la atención médica y quirúrgica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1781,'Y69 Incidentes no especificados durante la atención médica y quirúrgica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1782,'Y70 Dispositivos de anestesiología asociados con incidentes adversos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1783,'Y71 Dispositivos cardiovasculares asociados con incidentes adversos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1784,'Y72 Dispositivos otorrinolaringológicos asociados con incidentes adversos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1785,'Y73 Dispositivos de gastroenterología y urología asociados con incidentes adversos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1786,'Y74 Dispositivos para uso hospitalario general y personal asociados con incidentes adversos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1787,'Y75 Dispositivos neurológicos asociados con incidentes adversos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1788,'Y76 Dispositivos ginecológicos y obstétricos asociados con incidentes adversos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1789,'Y77 Dispositivos oftálmicos asociados con incidentes adversos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1790,'Y78 Aparatos radiológicos asociados con incidentes adversos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1791,'Y79 Dispositivos ortopédicos asociados con incidentes adversos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1792,'Y80 Aparatos de medicina física asociados con incidentes adversos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1793,'Y81 Dispositivos de cirugía general y plástica asociados con incidentes adversos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1794,'Y82 Otros dispositivos médicos, y los no especificados, asociados con incidentes adversos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1795,'Y83 Cirugía y otros procedimientos quirúrgicos como la causa de reacción anormal del paciente o de complicación posterior, sin mención de incidente en el momento de efectuar el procedimiento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1796,'Y84 Otros procedimientos médicos como la causa de reacción anormal del paciente o de complicación posterior, sin mención de incidente en el momento de efectuar el procedimiento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1797,'Y85 Secuelas de accidentes de transporte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1798,'Y86 Secuelas de otros accidentes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1799,'Y87 Secuelas de lesiones autoinfligidas intencionalmente, agresiones y eventos de intención no determinada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1800,'Y88 Secuelas con atención médica y quirúrgica como causa externa')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1801,'Y89 Secuelas de otras causas externas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1802,'Y90 Evidencia de alcoholismo determinada por el nivel de alcohol en la sangre')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1803,'Y91 Evidencia de alcoholismo determinada por el nivel de intoxicación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1804,'Y95 Afección nosocomial')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1805,'Y96 Afección relacionada con el trabajo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1806,'Y97 Afección relacionada con la contaminación ambiental')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1807,'Y98 Afección relacionada con el estilo de vida')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1808,'Z00 Examen general e investigación de personas sin quejas o sin diagnóstico informado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1809,'Z01 Otros exámenes especiales e investigaciones en personas sin quejas o sin diagnóstico informado')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1810,'Z02 Exámenes y contactos para fines administrativos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1811,'Z03 Observación y evaluación médicas por sospecha de enfermedades y afecciones')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1812,'Z04 Examen y observación por otras razones')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1813,'Z08 Examen de seguimiento consecutivo al tratamiento por tumor maligno')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1814,'Z09 Examen de seguimiento consecutivo a tratamiento por otras afecciones diferentes a tumores malignos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1815,'Z10 Control general de salud de rutina de subpoblaciones definidas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1816,'Z11 Examen de pesquisa especial para enfermedades infecciosas y parasitarias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1817,'Z12 Examen de pesquisa especial para tumores')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1818,'Z13 Examen de pesquisa especial para otras enfermedades y trastornos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1819,'Z20 Contacto con y exposición a enfermedades transmisibles')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1820,'Z21 Estado de infección asintomática por el virus de la inmunodeficiencia humana [VIH]')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1821,'Z22 Portador de enfermedad infecciosa')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1822,'Z23 Necesidad de inmunización contra enfermedad bacteriana única')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1823,'Z24 Necesidad de inmunización contra ciertas enfermedades virales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1824,'Z25 Necesidad de inmunización contra otras enfermedades virales únicas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1825,'Z26 Necesidad de inmunización contra otras enfermedades infecciosas únicas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1826,'Z27 Necesidad de inmunización contra combinaciones de enfermedades infecciosas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1827,'Z28 Inmunización no realizada')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1828,'Z29 Necesidad de otras medidas profilácticas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1829,'Z30 Atención para la anticoncepción')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1830,'Z31 Atención para la procreación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1831,'Z32 Examen y prueba del embarazo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1832,'Z33 Estado de embarazo, incidental')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1833,'Z34 Supervisión de embarazo normal')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1834,'Z35 Supervisión de embarazo de alto riesgo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1835,'Z36 Pesquisas prenatales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1836,'Z37 Producto del parto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1837,'Z38 Nacidos vivos según lugar de nacimiento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1838,'Z39 Examen y atención del postparto')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1839,'Z40 Cirugía profiláctica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1840,'Z41 Procedimientos para otros propósitos que no sean los de mejorar el estado de salud')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1841,'Z42 Cuidados posteriores a la cirugía plástica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1842,'Z43 Atención de orificios artificiales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1843,'Z44 Prueba y ajuste de dispositivos protésicos externos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1844,'Z45 Asistencia y ajuste de dispositivos implantados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1845,'Z46 Prueba y ajuste de otros dispositivos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1846,'Z47 Otros cuidados posteriores a la ortopedia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1847,'Z48 Otros cuidados posteriores a la cirugía')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1848,'Z49 Cuidados relativos al procedimiento de diálisis')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1849,'Z50 Atención por el uso de procedimientos de rehabilitación')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1850,'Z51 Otra atención médica')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1851,'Z52 Donantes de órganos y tejidos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1852,'Z53 Persona en contacto con los servicios de salud para procedimientos específicos no realizados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1853,'Z54 Convalecencia')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1854,'Z55 Problemas relacionados con la educación y la alfabetización')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1855,'Z56 Problemas relacionados con el empleo y el desempleo')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1856,'Z57 Exposición a factores de riesgo ocupacional')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1857,'Z58 Problemas relacionados con el ambiente físico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1858,'Z59 Problemas relacionados con la vivienda y las circunstancias económicas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1859,'Z60 Problemas relacionados con el ambiente social')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1860,'Z61 Problemas relacionados con hechos negativos en la niñez')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1861,'Z62 Otros problemas relacionados con la crianza del niño')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1862,'Z63 Otros problemas relacionados con el grupo primario de apoyo, inclusive circunstancias familiares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1863,'Z64 Problemas relacionados con ciertas circunstancias psicosociales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1864,'Z65 Problemas relacionados con otras circunstancias psicosociales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1865,'Z70 Consulta relacionada con actitud, conducta u orientación sexual')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1866,'Z71 Personas en contacto con los servicios de salud por otras consultas y consejos médicos, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1867,'Z72 Problemas relacionados con el estilo de vida')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1868,'Z73 Problemas relacionados con dificultades con el modo de vida')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1869,'Z74 Problemas relacionados con dependencia del prestador de servicios')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1870,'Z75 Problemas relacionados con facilidades de atención médica u otros servicios de salud')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1871,'Z76 Personas en contacto con los servicios de salud por otras circunstancias')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1872,'Z80 Historia familiar de tumor maligno')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1873,'Z81 Historia familiar de trastornos mentales y del comportamiento')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1874,'Z82 Historia familiar de ciertas discapacidades y enfermedades crónicas incapacitantes')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1875,'Z83 Historia familiar de otros trastornos específicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1876,'Z84 Historia familiar de otras afecciones')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1877,'Z85 Historia personal de tumor maligno')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1878,'Z86 Historia personal de algunas otras enfermedades')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1879,'Z87 Historia personal de otras enfermedades y afecciones')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1880,'Z88 Historia personal de alergia a drogas, medicamentos y sustancias biológicas')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1881,'Z89 Ausencia adquirida de miembros')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1882,'Z90 Ausencia adquirida de órganos, no clasificada en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1883,'Z91 Historia personal de factores de riesgo, no clasificados en otra parte')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1884,'Z92 Historia personal de tratamiento médico')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1885,'Z93 Aberturas artificiales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1886,'Z94 Organos y tejidos trasplantados')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1887,'Z95 Presencia de implantes e injertos cardiovasculares')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1888,'Z96 Presencia de otros implantes funcionales')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1889,'Z97 Presencia de otros dispositivos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1890,'Z98 Otros estados postquirúrgicos')
        ","insert into diag_agudo_cie_10   (id,nombre) values (1891,'Z99 Dependencia de máquinas y dispositivos capacitantes, no clasificada en otra parte')"];
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
