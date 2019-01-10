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

    $arr = ["insert into diag_psiquiatrico_cie_10 values(1,'F00* Demencia en la enfermedad de Alzheimer (G30.-+)')
        ","insert into diag_psiquiatrico_cie_10 values(2,'F00.0* Demencia en la enfermedad de Alzheimer, de comienzo temprano (G30.0+)')
        ","insert into diag_psiquiatrico_cie_10 values(3,'F00.1* Demencia en la enfermedad de Alzheimer, de comienzo tardío (G30.1+)')
        ","insert into diag_psiquiatrico_cie_10 values(4,'F00.2* Demencia en la enfermedad de Alzheimer, atípica o de tipo mixto (G30.8+)')
        ","insert into diag_psiquiatrico_cie_10 values(5,'F00.9* Demencia en la enfermedad de Alzheimer, no especificada (G30.9+)')
        ","insert into diag_psiquiatrico_cie_10 values(6,'F01 Demencia vascular')
        ","insert into diag_psiquiatrico_cie_10 values(7,'F01.0 Demencia vascular de comienzo agudo')
        ","insert into diag_psiquiatrico_cie_10 values(8,'F01.1 Demencia vascular por infartos múltiples')
        ","insert into diag_psiquiatrico_cie_10 values(9,'F01.2 Demencia vascular subcortical')
        ","insert into diag_psiquiatrico_cie_10 values(10,'F01.3 Demencia vascular mixta, cortical y subcortical')
        ","insert into diag_psiquiatrico_cie_10 values(11,'F01.8 Otras demencias vasculares')
        ","insert into diag_psiquiatrico_cie_10 values(12,'F01.9 Demencia vascular, no especificada')
        ","insert into diag_psiquiatrico_cie_10 values(13,'F02* Demencia en otras enfermedades clasificadas en otra parte')
        ","insert into diag_psiquiatrico_cie_10 values(14,'F02.0* Demencia en la enfermedad de Pick (G3l.0+)')
        ","insert into diag_psiquiatrico_cie_10 values(15,'F02.1* Demencia en la enfermedad de Creutzfeldt-Jakob (A81.0+)')
        ","insert into diag_psiquiatrico_cie_10 values(16,'F02.2* Demencia en la enfermedad de Huntington (Gl0+)')
        ","insert into diag_psiquiatrico_cie_10 values(17,'F02.3* Demencia en la enfermedad de Parkinson (G20+)')
        ","insert into diag_psiquiatrico_cie_10 values(18,'F02.4* Demencia en la enfermedad por virus de la inmunodeficiencia humana [VIH] (B22.0+)')
        ","insert into diag_psiquiatrico_cie_10 values(19,'F02.8* Demencia en otras enfermedades especificadas clasificadas en otra parte')
        ","insert into diag_psiquiatrico_cie_10 values(20,'F03 Demencia, no especificada')
        ","insert into diag_psiquiatrico_cie_10 values(21,'F04 Síndrome amnésico orgánico, no inducido por alcohol o por otras sustancias psicoactivas')
        ","insert into diag_psiquiatrico_cie_10 values(22,'F05 Delirio, no inducido por alcohol o por otras sustancias psicoactivas')
        ","insert into diag_psiquiatrico_cie_10 values(23,'F05.0 Delirio no superpuesto a un cuadro de demencia, así descrito')
        ","insert into diag_psiquiatrico_cie_10 values(24,'F05.1 Delirio superpuesto a un cuadro de demencia')
        ","insert into diag_psiquiatrico_cie_10 values(25,'F05.8 Otros delirios')
        ","insert into diag_psiquiatrico_cie_10 values(26,'F05.9 Delirio, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(27,'F06 Otros trastornos mentales debidos a lesión y disfunción cerebral, y a enfermedad física')
        ","insert into diag_psiquiatrico_cie_10 values(28,'F06.0 Alucinosis orgánica')
        ","insert into diag_psiquiatrico_cie_10 values(29,'F06.1 Trastorno catatónico, orgánico')
        ","insert into diag_psiquiatrico_cie_10 values(30,'F06.2 Trastorno delirante [esquizofreniforme], orgánico')
        ","insert into diag_psiquiatrico_cie_10 values(31,'F06.3 Trastornos del humor [afectivos], orgánicos')
        ","insert into diag_psiquiatrico_cie_10 values(32,'F06.4 Trastorno de ansiedad, orgánico')
        ","insert into diag_psiquiatrico_cie_10 values(33,'F06.5 Trastorno disociativo, orgánico')
        ","insert into diag_psiquiatrico_cie_10 values(34,'F06.6 Trastorno de labilidad emocional [asténico], orgánico')
        ","insert into diag_psiquiatrico_cie_10 values(35,'F06.7 Trastorno cognoscitivo leve')
        ","insert into diag_psiquiatrico_cie_10 values(36,'F06.8 Otros trastornos mentales especificados debidos a lesión y disfunción cerebral y a enfermedad física')
        ","insert into diag_psiquiatrico_cie_10 values(37,'F06.9 Trastorno mental no especificado debido a lesión y disfunción cerebral y a enfermedad física')
        ","insert into diag_psiquiatrico_cie_10 values(38,'F07 Trastornos de la personalidad y del comportamiento debidos a enfermedad, lesión o disfunción cerebral')
        ","insert into diag_psiquiatrico_cie_10 values(39,'F07.0 Trastorno de la personalidad, orgánico')
        ","insert into diag_psiquiatrico_cie_10 values(40,'F07.1 Síndrome postencefalítico')
        ","insert into diag_psiquiatrico_cie_10 values(41,'F07.2 Síndrome postconcusional')
        ","insert into diag_psiquiatrico_cie_10 values(42,'F07.8 Otros trastornos orgánicos de la personalidad y del comportamiento debidos a enfermedad, lesión y disfunción cerebrales')
        ","insert into diag_psiquiatrico_cie_10 values(43,'F07.9 Trastorno orgánico de la personalidad y del comportamiento, no especificado, debido a enfermedad, lesión y disfunción cerebral')
        ","insert into diag_psiquiatrico_cie_10 values(44,'F09 Trastorno mental orgánico o sintomático, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(45,'F10 Trastornos mentales y del comportamiento debidos al uso de alcohol')
        ","insert into diag_psiquiatrico_cie_10 values(46,'F10.0 Trastornos mentales y del comportamiento debidos al uso de alcohol, intoxicación aguda')
        ","insert into diag_psiquiatrico_cie_10 values(47,'F10.1 Trastornos mentales y del comportamiento debidos al uso de alcohol, uso nocivo')
        ","insert into diag_psiquiatrico_cie_10 values(48,'F10.2 Trastornos mentales y del comportamiento debidos al uso de alcohol, síndrome de dependencia')
        ","insert into diag_psiquiatrico_cie_10 values(49,'F10.3 Trastornos mentales y del comportamiento debidos al uso de alcohol, estado de abstinencia')
        ","insert into diag_psiquiatrico_cie_10 values(50,'F10.4 Trastornos mentales y del comportamiento debidos al uso de alcohol, estado de abstinencia con delirio')
        ","insert into diag_psiquiatrico_cie_10 values(51,'F10.5 Trastornos mentales y del comportamiento debidos al uso de alcohol, trastorno psicótico')
        ","insert into diag_psiquiatrico_cie_10 values(52,'F10.6 Trastornos mentales y del comportamiento debidos al uso de alcohol, síndrome amnésico')
        ","insert into diag_psiquiatrico_cie_10 values(53,'F10.7 Trastornos mentales y del comportamiento debidos al uso de alcohol, trastorno psicótico residual y de comienzo tardío')
        ","insert into diag_psiquiatrico_cie_10 values(54,'F10.8 Trastornos mentales y del comportamiento debidos al uso de alcohol, otros trastornos mentales y del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(55,'F10.9 Trastornos mentales y del comportamiento debidos al uso de alcohol, trastorno mental y del comportamiento, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(56,'F11 Trastornos mentales y del comportamiento debidos al uso de opiáceos')
        ","insert into diag_psiquiatrico_cie_10 values(57,'F11.0 Trastornos mentales y del comportamiento debidos al uso de opiáceos, intoxicación aguda')
        ","insert into diag_psiquiatrico_cie_10 values(58,'F11.1 Trastornos mentales y del comportamiento debidos al uso de opiáceos, uso nocivo')
        ","insert into diag_psiquiatrico_cie_10 values(59,'F11.2 Trastornos mentales y del comportamiento debidos al uso de opiáceos, síndrome de dependencia')
        ","insert into diag_psiquiatrico_cie_10 values(60,'F11.3 Trastornos mentales y del comportamiento debidos al uso de opiáceos, estado de abstinencia')
        ","insert into diag_psiquiatrico_cie_10 values(61,'F11.4 Trastornos mentales y del comportamiento debidos al uso de opiáceos, estado de abstinencia con delirio')
        ","insert into diag_psiquiatrico_cie_10 values(62,'F11.5 Trastornos mentales y del comportamiento debidos al uso de opiáceos, trastorno psicótico')
        ","insert into diag_psiquiatrico_cie_10 values(63,'F11.6 Trastornos mentales y del comportamiento debidos al uso de opiáceos, síndrome amnésico')
        ","insert into diag_psiquiatrico_cie_10 values(64,'F11.7 Trastornos mentales y del comportamiento debidos al uso de opiáceos, trastorno psicótico residual y de comienzo tardío')
        ","insert into diag_psiquiatrico_cie_10 values(65,'F11.8 Trastornos mentales y del comportamiento debidos al uso de opiáceos, otros trastornos mentales y del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(66,'F11.9 Trastornos mentales y del comportamiento debidos al uso de opiáceos, trastorno mental y del comportamiento, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(67,'F12 Trastornos mentales y del comportamiento debidos al uso de cannabinoides')
        ","insert into diag_psiquiatrico_cie_10 values(68,'F12.0 Trastornos mentales y del comportamiento debidos al uso de cannabinoides, intoxicación aguda')
        ","insert into diag_psiquiatrico_cie_10 values(69,'F12.1 Trastornos mentales y del comportamiento debidos al uso de cannabinoides, uso nocivo')
        ","insert into diag_psiquiatrico_cie_10 values(70,'F12.2 Trastornos mentales y del comportamiento debidos al uso de cannabinoides, síndrome de dependencia')
        ","insert into diag_psiquiatrico_cie_10 values(71,'F12.3 Trastornos mentales y del comportamiento debidos al uso de cannabinoides, estado de abstinencia')
        ","insert into diag_psiquiatrico_cie_10 values(72,'F12.4 Trastornos mentales y del comportamiento debidos al uso de cannabinoides, estado de abstinencia con delirio')
        ","insert into diag_psiquiatrico_cie_10 values(73,'F12.5 Trastornos mentales y del comportamiento debidos al uso de cannabinoides, trastorno psicótico')
        ","insert into diag_psiquiatrico_cie_10 values(74,'F12.6 Trastornos mentales y del comportamiento debidos al uso de cannabinoides, síndrome amnésico')
        ","insert into diag_psiquiatrico_cie_10 values(75,'F12.7 Trastornos mentales y del comportamiento debidos al uso de cannabinoides, trastorno psicótico residual y de comienzo tardío')
        ","insert into diag_psiquiatrico_cie_10 values(76,'F12.8 Trastornos mentales y del comportamiento debidos al uso de cannabinoides, otros trastornos mentales y del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(77,'F12.9 Trastornos mentales y del comportamiento debidos al uso de cannabinoides, trastorno mental y del comportamiento, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(78,'F13 Trastornos mentales y del comportamiento debidos al uso de sedantes o hipnóticos')
        ","insert into diag_psiquiatrico_cie_10 values(79,'F13.0 Trastornos mentales y del comportamiento debidos al uso de sedantes o hipnóticos, intoxicación aguda')
        ","insert into diag_psiquiatrico_cie_10 values(80,'F13.1 Trastornos mentales y del comportamiento debidos al uso de sedantes o hipnóticos, uso nocivo')
        ","insert into diag_psiquiatrico_cie_10 values(81,'F13.2 Trastornos mentales y del comportamiento debidos al uso de sedantes o hipnóticos, síndrome de dependencia')
        ","insert into diag_psiquiatrico_cie_10 values(82,'F13.3 Trastornos mentales y del comportamiento debidos al uso de sedantes o hipnóticos, estado de abstinencia')
        ","insert into diag_psiquiatrico_cie_10 values(83,'F13.4 Trastornos mentales y del comportamiento debidos al uso de sedantes o hipnóticos, estado de abstinencia con delirio')
        ","insert into diag_psiquiatrico_cie_10 values(84,'F13.5 Trastornos mentales y del comportamiento debidos al uso de sedantes o hipnóticos, trastorno psicótico')
        ","insert into diag_psiquiatrico_cie_10 values(85,'F13.6 Trastornos mentales y del comportamiento debidos al uso de sedantes o hipnóticos, síndrome amnésico')
        ","insert into diag_psiquiatrico_cie_10 values(86,'F13.7 Trastornos mentales y del comportamiento debidos al uso de sedantes o hipnóticos, trastorno psicótico residual y de comienzo tardío')
        ","insert into diag_psiquiatrico_cie_10 values(87,'F13.8 Trastornos mentales y del comportamiento debidos al uso de sedantes o hipnóticos, otros trastornos mentales y del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(88,'F13.9 Trastornos mentales y del comportamiento debidos al uso de sedantes o hipnóticos, trastorno mental y del comportamiento, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(89,'F14 Trastornos mentales y del comportamiento debidos al uso de cocaína')
        ","insert into diag_psiquiatrico_cie_10 values(90,'F14.0 Trastornos mentales y del comportamiento debidos al uso de cocaína, intoxicación aguda')
        ","insert into diag_psiquiatrico_cie_10 values(91,'F14.1 Trastornos mentales y del comportamiento debidos al uso de cocaína, uso nocivo')
        ","insert into diag_psiquiatrico_cie_10 values(92,'F14.2 Trastornos mentales y del comportamiento debidos al uso de cocaína, síndrome de dependencia')
        ","insert into diag_psiquiatrico_cie_10 values(93,'F14.3 Trastornos mentales y del comportamiento debidos al uso de cocaína, estado de abstinencia')
        ","insert into diag_psiquiatrico_cie_10 values(94,'F14.4 Trastornos mentales y del comportamiento debidos al uso de cocaína, estado de abstinencia con delirio')
        ","insert into diag_psiquiatrico_cie_10 values(95,'F14.5 Trastornos mentales y del comportamiento debidos al uso de cocaína, trastorno psicótico')
        ","insert into diag_psiquiatrico_cie_10 values(96,'F14.6 Trastornos mentales y del comportamiento debidos al uso de cocaína, síndrome amnésico')
        ","insert into diag_psiquiatrico_cie_10 values(97,'F14.7 Trastornos mentales y del comportamiento debidos al uso de cocaína, trastorno psicótico residual y de comienzo tardío')
        ","insert into diag_psiquiatrico_cie_10 values(98,'F14.8 Trastornos mentales y del comportamiento debidos al uso de cocaína, otros trastornos mentales y del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(99,'F14.9 Trastornos mentales y del comportamiento debidos al uso de cocaína, trastorno mental y del comportamiento, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(100,'F15 Trastornos mentales y del comportamiento debidos al uso de otros estimulantes, incluida la cafeína')
        ","insert into diag_psiquiatrico_cie_10 values(101,'F15.0 Trastornos mentales y del comportamiento debidos al uso de otros estimulantes, incluida la cafeína, intoxicación aguda')
        ","insert into diag_psiquiatrico_cie_10 values(102,'F15.1 Trastornos mentales y del comportamiento debidos al uso de otros estimulantes, incluida la cafeína, uso nocivo')
        ","insert into diag_psiquiatrico_cie_10 values(103,'F15.2 Trastornos mentales y del comportamiento debidos al uso de otros estimulantes, incluida la cafeína, síndrome de dependencia')
        ","insert into diag_psiquiatrico_cie_10 values(104,'F15.3 Trastornos mentales y del comportamiento debidos al uso de otros estimulantes, incluida la cafeína, estado de abstinencia')
        ","insert into diag_psiquiatrico_cie_10 values(105,'F15.4 Trastornos mentales y del comportamiento debidos al uso de otros estimulantes, incluida la cafeína, estado de abstinencia con  delirio')
        ","insert into diag_psiquiatrico_cie_10 values(106,'F15.5 Trastornos mentales y del comportamiento debidos al uso de otros estimulantes, incluida la cafeína, trastorno psicótico')
        ","insert into diag_psiquiatrico_cie_10 values(107,'F15.6 Trastornos mentales y del comportamiento debidos al uso de otros estimulantes, incluida la cafeína, síndrome amnésico')
        ","insert into diag_psiquiatrico_cie_10 values(108,'F15.7 Trastornos mentales y del comportamiento debidos al uso de otros estimulantes, incluida la cafeína, trastorno psicótico residual y de comienzo tardío')
        ","insert into diag_psiquiatrico_cie_10 values(109,'F15.8 Trastornos mentales y del comportamiento debidos al uso de otros estimulantes, incluida la cafeína, otros trastornos mentales y del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(110,'F15.9 Trastornos mentales y del comportamiento debidos al uso de otros estimulantes, incluida la cafeína, trastorno mental y del comportamiento, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(111,'F16 Trastornos mentales y del comportamiento debidos al uso de alucinógenos')
        ","insert into diag_psiquiatrico_cie_10 values(112,'F16.0 Trastornos mentales y del comportamiento debidos al uso de alucinógenos, intoxicación aguda')
        ","insert into diag_psiquiatrico_cie_10 values(113,'F16.1 Trastornos mentales y del comportamiento debidos al uso de alucinógenos, uso nocivo')
        ","insert into diag_psiquiatrico_cie_10 values(114,'F16.2 Trastornos mentales y del comportamiento debidos al uso de alucinógenos, síndrome de dependencia')
        ","insert into diag_psiquiatrico_cie_10 values(115,'F16.3 Trastornos mentales y del comportamiento debidos al uso de alucinógenos, estado de abstinencia')
        ","insert into diag_psiquiatrico_cie_10 values(116,'F16.4 Trastornos mentales y del comportamiento debidos al uso de alucinógenos, estado de abstinencia con delirio')
        ","insert into diag_psiquiatrico_cie_10 values(117,'F16.5 Trastornos mentales y del comportamiento debidos al uso de alucinógenos, trastorno psicótico')
        ","insert into diag_psiquiatrico_cie_10 values(118,'F16.6 Trastornos mentales y del comportamiento debidos al uso de alucinógenos, síndrome amnésico')
        ","insert into diag_psiquiatrico_cie_10 values(119,'F16.7 Trastornos mentales y del comportamiento debidos al uso de alucinógenos, trastorno psicótico residual y de comienzo tardío')
        ","insert into diag_psiquiatrico_cie_10 values(120,'F16.8 Trastornos mentales y del comportamiento debidos al uso de alucinógenos, otros trastornos mentales y del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(121,'F16.9 Trastornos mentales y del comportamiento debidos al uso de alucinógenos, trastorno mental y del comportamiento, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(122,'F17 Trastornos mentales y del comportamiento debidos al uso de tabaco')
        ","insert into diag_psiquiatrico_cie_10 values(123,'F17.0 Trastornos mentales y del comportamiento debidos al uso de tabaco, intoxicación aguda')
        ","insert into diag_psiquiatrico_cie_10 values(124,'F17.1 Trastornos mentales y del comportamiento debidos al uso de tabaco, uso nocivo')
        ","insert into diag_psiquiatrico_cie_10 values(125,'F17.2 Trastornos mentales y del comportamiento debidos al uso de tabaco, síndrome de dependencia')
        ","insert into diag_psiquiatrico_cie_10 values(126,'F17.3 Trastornos mentales y del comportamiento debidos al uso de tabaco, estado de abstinencia')
        ","insert into diag_psiquiatrico_cie_10 values(127,'F17.4 Trastornos mentales y del comportamiento debidos al uso de tabaco, estado de abstinencia con delirio')
        ","insert into diag_psiquiatrico_cie_10 values(128,'F17.5 Trastornos mentales y del comportamiento debidos al uso de tabaco, trastorno psicótico')
        ","insert into diag_psiquiatrico_cie_10 values(129,'F17.6 Trastornos mentales y del comportamiento debidos al uso de tabaco, síndrome amnésico')
        ","insert into diag_psiquiatrico_cie_10 values(130,'F17.7 Trastornos mentales y del comportamiento debidos al uso de tabaco, trastorno psicótico residual y de comienzo tardío')
        ","insert into diag_psiquiatrico_cie_10 values(131,'F17.8 Trastornos mentales y del comportamiento debidos al uso de tabaco, otros trastornos mentales y del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(132,'F17.9 Trastornos mentales y del comportamiento debidos al uso de tabaco, trastorno mental y del comportamiento, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(133,'F18 Trastornos mentales y del comportamiento debidos al uso de disolventes volátiles')
        ","insert into diag_psiquiatrico_cie_10 values(134,'F18.0 Trastornos mentales y del comportamiento debidos al uso de disolventes volátiles, intoxicación aguda')
        ","insert into diag_psiquiatrico_cie_10 values(135,'F18.1 Trastornos mentales y del comportamiento debidos al uso de disolventes volátiles, uso nocivo')
        ","insert into diag_psiquiatrico_cie_10 values(136,'F18.2 Trastornos mentales y del comportamiento debidos al uso de disolventes volátiles, síndrome de dependencia')
        ","insert into diag_psiquiatrico_cie_10 values(137,'F18.3 Trastornos mentales y del comportamiento debidos al uso de disolventes volátiles, estado de abstinencia')
        ","insert into diag_psiquiatrico_cie_10 values(138,'F18.4 Trastornos mentales y del comportamiento debidos al uso de disolventes volátiles, estado de abstinencia con delirio')
        ","insert into diag_psiquiatrico_cie_10 values(139,'F18.5 Trastornos mentales y del comportamiento debidos al uso de disolventes volátiles, trastorno psicótico')
        ","insert into diag_psiquiatrico_cie_10 values(140,'F18.6 Trastornos mentales y del comportamiento debidos al uso de disolventes volátiles, síndrome amnésico')
        ","insert into diag_psiquiatrico_cie_10 values(141,'F18.7 Trastornos mentales y del comportamiento debidos al uso de disolventes volátiles, trastorno psicótico residual y de comienzo tardío')
        ","insert into diag_psiquiatrico_cie_10 values(142,'F18.8 Trastornos mentales y del comportamiento debidos al uso de disolventes volátiles, otros trastornos mentales y del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(143,'F18.9 Trastornos mentales y del comportamiento debidos al uso de disolventes volátiles, trastorno mental y del comportamiento, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(144,'F19 Trastornos mentales y del comportamiento debidos al uso de múltiples drogas y al uso de otras sustancias psicoactivas')
        ","insert into diag_psiquiatrico_cie_10 values(145,'F19.0 Trastornos mentales y del comportamiento debidos al uso de múltiples drogas y al uso de otras sustancias psicoactivas, intoxicación aguda')
        ","insert into diag_psiquiatrico_cie_10 values(146,'F19.1 Trastornos mentales y del comportamiento debidos al uso de múltiples drogas y al uso de otras sustancias psicoactivas, uso nocivo')
        ","insert into diag_psiquiatrico_cie_10 values(147,'F19.2 Trastornos mentales y del comportamiento debidos al uso de múltiples drogas y al uso de otras sustancias psicoactivas, síndrome de dependencia')
        ","insert into diag_psiquiatrico_cie_10 values(148,'F19.3 Trastornos mentales y del comportamiento debidos al uso de múltiples drogas y al uso de otras sustancias psicoactivas, estado de abstinencia')
        ","insert into diag_psiquiatrico_cie_10 values(149,'F19.4 Trastornos mentales y del comportamiento debidos al uso de múltiples drogas y al uso de otras sustancias psicoactivas, estado de abstinencia con delirio')
        ","insert into diag_psiquiatrico_cie_10 values(150,'F19.5 Trastornos mentales y del comportamiento debidos al uso de múltiples drogas y al uso de otras sustancias psicoactivas, trastorno psicótico')
        ","insert into diag_psiquiatrico_cie_10 values(151,'F19.6 Trastornos mentales y del comportamiento debidos al uso de múltiples drogas y al uso de otras sustancias psicoactivas, síndrome amnésico')
        ","insert into diag_psiquiatrico_cie_10 values(152,'F19.7 Trastornos mentales y del comportamiento debidos al uso de múltiples drogas y al uso de otras sustancias psicoactivas, trastorno psicótico residual y de comienzo tardío')
        ","insert into diag_psiquiatrico_cie_10 values(153,'F19.8 Trastornos mentales y del comportamiento debidos al uso de múltiples drogas y al uso de otras sustancias psicoactivas, otros trastornos mentales y del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(154,'F19.9 Trastornos mentales y del comportamiento debidos al uso de múltiples drogas y al uso de otras sustancias psicoactivas, trastorno mental y del comportamiento, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(155,'F20 Esquizofrenia')
        ","insert into diag_psiquiatrico_cie_10 values(156,'F20.0 Esquizofrenia paranoide')
        ","insert into diag_psiquiatrico_cie_10 values(157,'F20.1 Esquizofrenia hebefrénica')
        ","insert into diag_psiquiatrico_cie_10 values(158,'F20.2 Esquizofrenia catatónica')
        ","insert into diag_psiquiatrico_cie_10 values(159,'F20.3 Esquizofrenia indiferenciada')
        ","insert into diag_psiquiatrico_cie_10 values(160,'F20.4 Depresión postesquizofrénica')
        ","insert into diag_psiquiatrico_cie_10 values(161,'F20.5 Esquizofrenia residual')
        ","insert into diag_psiquiatrico_cie_10 values(162,'F20.6 Esquizofrenia simple')
        ","insert into diag_psiquiatrico_cie_10 values(163,'F20.8 Otras esquizofrenias')
        ","insert into diag_psiquiatrico_cie_10 values(164,'F20.9 Esquizofrenia, no especificada')
        ","insert into diag_psiquiatrico_cie_10 values(165,'F21 Trastorno esquizotípico')
        ","insert into diag_psiquiatrico_cie_10 values(166,'F22 Trastornos delirantes persistentes')
        ","insert into diag_psiquiatrico_cie_10 values(167,'F22.0 Trastorno delirante')
        ","insert into diag_psiquiatrico_cie_10 values(168,'F22.8 Otros trastornos delirantes persistentes')
        ","insert into diag_psiquiatrico_cie_10 values(169,'F22.9 Trastorno delirante persistente, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(170,'F23 Trastornos psicóticos agudos y transitorios')
        ","insert into diag_psiquiatrico_cie_10 values(171,'F23.0 Trastorno psicótico agudo polimorfo, sin síntomas de esquizofrenia')
        ","insert into diag_psiquiatrico_cie_10 values(172,'F23.1 Trastorno psicótico agudo polimorfo, con síntomas de esquizofrenia')
        ","insert into diag_psiquiatrico_cie_10 values(173,'F23.2 Trastorno psicótico agudo de tipo esquizofrénico')
        ","insert into diag_psiquiatrico_cie_10 values(174,'F23.3 Otro trastorno psicótico agudo, con predominio de ideas delirantes')
        ","insert into diag_psiquiatrico_cie_10 values(175,'F23.8 Otros trastornos psicóticos agudos y transitorios')
        ","insert into diag_psiquiatrico_cie_10 values(176,'F23.9 Trastorno psicótico agudo y transitorio, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(177,'F24 Trastorno delirante inducido')
        ","insert into diag_psiquiatrico_cie_10 values(178,'F25 Trastornos esquizoafectivos')
        ","insert into diag_psiquiatrico_cie_10 values(179,'F25.0 Trastorno esquizoafectivo de tipo maníaco')
        ","insert into diag_psiquiatrico_cie_10 values(180,'F25.1 Trastorno esquizoafectivo de tipo depresivo')
        ","insert into diag_psiquiatrico_cie_10 values(181,'F25.2 Trastorno esquizoafectivo de tipo mixto')
        ","insert into diag_psiquiatrico_cie_10 values(182,'F25.8 Otros trastornos esquizoafectivos')
        ","insert into diag_psiquiatrico_cie_10 values(183,'F25.9 Trastorno esquizoafectivo, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(184,'F28 Otros trastornos psicóticos de origen no orgánico')
        ","insert into diag_psiquiatrico_cie_10 values(185,'F29 Psicosis de origen no orgánico, no especificada')
        ","insert into diag_psiquiatrico_cie_10 values(186,'F30 Episodio maníaco')
        ","insert into diag_psiquiatrico_cie_10 values(187,'F30.0 Hipomanía')
        ","insert into diag_psiquiatrico_cie_10 values(188,'F30.1 Manía sin síntomas psicóticos')
        ","insert into diag_psiquiatrico_cie_10 values(189,'F30.2 Manía con síntomas psicóticos')
        ","insert into diag_psiquiatrico_cie_10 values(190,'F30.8 Otros episodios maníacos')
        ","insert into diag_psiquiatrico_cie_10 values(191,'F30.9 Episodio maníaco, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(192,'F31 Trastorno afectivo bipolar')
        ","insert into diag_psiquiatrico_cie_10 values(193,'F31.0 Trastorno afectivo bipolar, episodio hipomaníaco presente')
        ","insert into diag_psiquiatrico_cie_10 values(194,'F31.1 Trastorno afectivo bipolar, episodio maníaco presente sin síntomas psicóticos')
        ","insert into diag_psiquiatrico_cie_10 values(195,'F31.2 Trastorno afectivo bipolar, episodio maníaco presente con síntomas psicóticos')
        ","insert into diag_psiquiatrico_cie_10 values(196,'F31.3 Trastorno afectivo bipolar, episodio depresivo presente leve o moderado')
        ","insert into diag_psiquiatrico_cie_10 values(197,'F31.4 Trastorno afectivo bipolar, episodio depresivo grave presente sin síntomas psicóticos')
        ","insert into diag_psiquiatrico_cie_10 values(198,'F31.5 Trastorno afectivo bipolar, episodio depresivo grave presente con síntomas psicóticos')
        ","insert into diag_psiquiatrico_cie_10 values(199,'F31.6 Trastorno afectivo bipolar, episodio mixto presente')
        ","insert into diag_psiquiatrico_cie_10 values(200,'F31.7 Trastorno afectivo bipolar, actualmente en remisión')
        ","insert into diag_psiquiatrico_cie_10 values(201,'F31.8 Otros trastornos afectivos bipolares')
        ","insert into diag_psiquiatrico_cie_10 values(202,'F31.9 Trastorno afectivo bipolar, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(203,'F32 Episodio depresivo')
        ","insert into diag_psiquiatrico_cie_10 values(204,'F32.0 Episodio depresivo leve')
        ","insert into diag_psiquiatrico_cie_10 values(205,'F32.1 Episodio depresivo moderado')
        ","insert into diag_psiquiatrico_cie_10 values(206,'F32.2 Episodio depresivo grave sin síntomas psicóticos')
        ","insert into diag_psiquiatrico_cie_10 values(207,'F32.3 Episodio depresivo grave con síntomas psicóticos')
        ","insert into diag_psiquiatrico_cie_10 values(208,'F32.8 Otros episodios depresivos')
        ","insert into diag_psiquiatrico_cie_10 values(209,'F32.9 Episodio depresivo, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(210,'F33 Trastorno depresivo recurrente')
        ","insert into diag_psiquiatrico_cie_10 values(211,'F33.0 Trastorno depresivo recurrente, episodio leve presente')
        ","insert into diag_psiquiatrico_cie_10 values(212,'F33.1 Trastorno depresivo recurrente, episodio moderado presente')
        ","insert into diag_psiquiatrico_cie_10 values(213,'F33.2 Trastorno depresivo recurrente, episodio depresivo grave presente sin síntomas psicóticos')
        ","insert into diag_psiquiatrico_cie_10 values(214,'F33.3 Trastorno depresivo recurrente, episodio depresivo grave presente, con síntomas psicóticos')
        ","insert into diag_psiquiatrico_cie_10 values(215,'F33.4 Trastorno depresivo recurrente actualmente en remisión')
        ","insert into diag_psiquiatrico_cie_10 values(216,'F33.8 Otros trastornos depresivos recurrentes')
        ","insert into diag_psiquiatrico_cie_10 values(217,'F33.9 Trastorno depresivo recurrente, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(218,'F34 Trastornos del humor [afectivos] persistentes')
        ","insert into diag_psiquiatrico_cie_10 values(219,'F34.0 Ciclotimia')
        ","insert into diag_psiquiatrico_cie_10 values(220,'F34.1 Distimia')
        ","insert into diag_psiquiatrico_cie_10 values(221,'F34.8 Otros trastornos del humor [afectivos] persistentes')
        ","insert into diag_psiquiatrico_cie_10 values(222,'F34.9 Trastorno persistente del humor [afectivo], no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(223,'F38 Otros trastornos del humor [afectivos]')
        ","insert into diag_psiquiatrico_cie_10 values(224,'F38.0 Otros trastornos del humor [afectivos], aislados')
        ","insert into diag_psiquiatrico_cie_10 values(225,'F38.1 Otros trastornos del humor [afectivos], recurrentes')
        ","insert into diag_psiquiatrico_cie_10 values(226,'F38.8 Otros trastornos del humor [afectivos], especificados')
        ","insert into diag_psiquiatrico_cie_10 values(227,'F39 Trastorno del humor [afectivo], no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(228,'F40 Trastornos fóbicos de ansiedad')
        ","insert into diag_psiquiatrico_cie_10 values(229,'F40.0 Agorafobia')
        ","insert into diag_psiquiatrico_cie_10 values(230,'F40.1 Fobias sociales')
        ","insert into diag_psiquiatrico_cie_10 values(231,'F40.2 Fobias específicas (aisladas)')
        ","insert into diag_psiquiatrico_cie_10 values(232,'F40.8 Otros trastornos fóbicos de ansiedad')
        ","insert into diag_psiquiatrico_cie_10 values(233,'F40.9 Trastorno fóbico de ansiedad, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(234,'F41 Otros trastornos de ansiedad')
        ","insert into diag_psiquiatrico_cie_10 values(235,'F41.0 Trastorno de pánico [ansiedad paroxística episódica]')
        ","insert into diag_psiquiatrico_cie_10 values(236,'F41.1 Trastorno de ansiedad generalizada')
        ","insert into diag_psiquiatrico_cie_10 values(237,'F41.2 Trastorno mixto de ansiedad y depresión')
        ","insert into diag_psiquiatrico_cie_10 values(238,'F41.3 Otros trastornos de ansiedad mixtos')
        ","insert into diag_psiquiatrico_cie_10 values(239,'F41.8 Otros trastornos de ansiedad especificados')
        ","insert into diag_psiquiatrico_cie_10 values(240,'F41.9 Trastorno de ansiedad, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(241,'F42 Trastorno obsesivo-compulsivo')
        ","insert into diag_psiquiatrico_cie_10 values(242,'F42.0 Predominio de pensamientos o rumiaciones obsesivas')
        ","insert into diag_psiquiatrico_cie_10 values(243,'F42.1 Predominio de actos compulsivos [rituales obsesivos]')
        ","insert into diag_psiquiatrico_cie_10 values(244,'F42.2 Actos e ideas obsesivas mixtos')
        ","insert into diag_psiquiatrico_cie_10 values(245,'F42.8 Otros trastornos obsesivo-compulsivos')
        ","insert into diag_psiquiatrico_cie_10 values(246,'F42.9 Trastorno obsesivo-compulsivo, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(247,'F43 Reacción al estrés grave y trastornos de adaptación')
        ","insert into diag_psiquiatrico_cie_10 values(248,'F43.0 Reacción al estrés agudo')
        ","insert into diag_psiquiatrico_cie_10 values(249,'F43.1 Trastorno de estrés postraumático')
        ","insert into diag_psiquiatrico_cie_10 values(250,'F43.2 Trastornos de adaptación')
        ","insert into diag_psiquiatrico_cie_10 values(251,'F43.8 Otras reacciones al estrés grave')
        ","insert into diag_psiquiatrico_cie_10 values(252,'F43.9 Reacción al estrés grave, no especificada')
        ","insert into diag_psiquiatrico_cie_10 values(253,'F44 Trastornos disociativos [de conversión]')
        ","insert into diag_psiquiatrico_cie_10 values(254,'F44.0 Amnesia disociativa')
        ","insert into diag_psiquiatrico_cie_10 values(255,'F44.1 Fuga disociativa')
        ","insert into diag_psiquiatrico_cie_10 values(256,'F44.2 Estupor disociativo')
        ","insert into diag_psiquiatrico_cie_10 values(257,'F44.3 Trastornos de trance y de posesión')
        ","insert into diag_psiquiatrico_cie_10 values(258,'F44.4 Trastornos disociativos del movimiento')
        ","insert into diag_psiquiatrico_cie_10 values(259,'F44.5 Convulsiones disociativas')
        ","insert into diag_psiquiatrico_cie_10 values(260,'F44.6 Anestesia disociativa y pérdida sensorial')
        ","insert into diag_psiquiatrico_cie_10 values(261,'F44.7 Trastornos disociativos mixtos [y de conversión]')
        ","insert into diag_psiquiatrico_cie_10 values(262,'F44.8 Otros trastornos disociativos [de conversión]')
        ","insert into diag_psiquiatrico_cie_10 values(263,'F44.9 Trastorno disociativo [de conversión], no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(264,'F45 Trastornos somatomorfos')
        ","insert into diag_psiquiatrico_cie_10 values(265,'F45.0 Trastorno de somatización')
        ","insert into diag_psiquiatrico_cie_10 values(266,'F45.1 Trastorno somatomorfo indiferenciado')
        ","insert into diag_psiquiatrico_cie_10 values(267,'F45.2 Trastorno hipocondríaco')
        ","insert into diag_psiquiatrico_cie_10 values(268,'F45.3 Disfunción autonómica somatomorfa')
        ","insert into diag_psiquiatrico_cie_10 values(269,'F45.4 Trastorno de dolor persistente somatomorfo')
        ","insert into diag_psiquiatrico_cie_10 values(270,'F45.8 Otros trastornos somatomorfos')
        ","insert into diag_psiquiatrico_cie_10 values(271,'F45.9 Trastorno somatomorfo, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(272,'F48 Otros trastornos neuróticos')
        ","insert into diag_psiquiatrico_cie_10 values(273,'F48.0 Neurastenia')
        ","insert into diag_psiquiatrico_cie_10 values(274,'F48.1 Síndrome de despersonalización y desvinculación de la realidad')
        ","insert into diag_psiquiatrico_cie_10 values(275,'F48.8 Otros trastornos neuróticos especificados')
        ","insert into diag_psiquiatrico_cie_10 values(276,'F48.9 Trastorno neurótico, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(277,'F50 Trastornos de la ingestión de alimentos')
        ","insert into diag_psiquiatrico_cie_10 values(278,'F50.0 Anorexia nerviosa')
        ","insert into diag_psiquiatrico_cie_10 values(279,'F50.1 Anorexia nerviosa atípica')
        ","insert into diag_psiquiatrico_cie_10 values(280,'F50.2 Bulimia nerviosa')
        ","insert into diag_psiquiatrico_cie_10 values(281,'F50.3 Bulimia nerviosa atípica')
        ","insert into diag_psiquiatrico_cie_10 values(282,'F50.4 Hiperfagia asociada con otras alteraciones psicológicas')
        ","insert into diag_psiquiatrico_cie_10 values(283,'F50.5 Vómitos asociados con otras alteraciones psicológicas')
        ","insert into diag_psiquiatrico_cie_10 values(284,'F50.8 Otros trastornos de la ingestión de alimentos')
        ","insert into diag_psiquiatrico_cie_10 values(285,'F50.9 Trastorno de la ingestión de alimentos, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(286,'F51 Trastornos no orgánicos del sueño')
        ","insert into diag_psiquiatrico_cie_10 values(287,'F51.0 Insomnio no orgánico')
        ","insert into diag_psiquiatrico_cie_10 values(288,'F51.1 Hipersomnio no orgánico')
        ","insert into diag_psiquiatrico_cie_10 values(289,'F51.2 Trastorno no orgánico del ciclo sueño-vigilia')
        ","insert into diag_psiquiatrico_cie_10 values(290,'F51.3 Sonambulismo')
        ","insert into diag_psiquiatrico_cie_10 values(291,'F51.4 Terrores del sueño [terrores nocturnos]')
        ","insert into diag_psiquiatrico_cie_10 values(292,'F51.5 Pesadillas')
        ","insert into diag_psiquiatrico_cie_10 values(293,'F51.8 Otros trastornos no orgánicos del sueño')
        ","insert into diag_psiquiatrico_cie_10 values(294,'F51.9 Trastorno no orgánico del sueño, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(295,'F52 Disfunción sexual no ocasionada por trastorno ni enfermedad orgánicos')
        ","insert into diag_psiquiatrico_cie_10 values(296,'F52.0 Falta o pérdida del deseo sexual')
        ","insert into diag_psiquiatrico_cie_10 values(297,'F52.1 Aversión al sexo y falta de goce sexual')
        ","insert into diag_psiquiatrico_cie_10 values(298,'F52.2 Falla de la respuesta genital')
        ","insert into diag_psiquiatrico_cie_10 values(299,'F52.3 Disfunción orgásmica')
        ","insert into diag_psiquiatrico_cie_10 values(300,'F52.4 Eyaculación precoz')
        ","insert into diag_psiquiatrico_cie_10 values(301,'F52.5 Vaginismo no orgánico')
        ","insert into diag_psiquiatrico_cie_10 values(302,'F52.6 Dispareunia no orgánica')
        ","insert into diag_psiquiatrico_cie_10 values(303,'F52.7 Impulso sexual excesivo')
        ","insert into diag_psiquiatrico_cie_10 values(304,'F52.8 Otras disfunciones sexuales, no ocasionadas por trastorno ni por enfermedad orgánicos')
        ","insert into diag_psiquiatrico_cie_10 values(305,'F52.9 Disfunción sexual no ocasionada por trastorno ni por enfermedad orgánicos, no especificada')
        ","insert into diag_psiquiatrico_cie_10 values(306,'F53 Trastornos mentales y del comportamiento asociados con el puerperio, no clasificados en otra parte')
        ","insert into diag_psiquiatrico_cie_10 values(307,'F53.0 Trastornos mentales y del comportamiento leves, asociados con el puerperio, no clasificados en otra parte')
        ","insert into diag_psiquiatrico_cie_10 values(308,'F53.1 Trastornos mentales y del comportamiento graves, asociados con el puerperio, no clasificados en otra parte')
        ","insert into diag_psiquiatrico_cie_10 values(309,'F53.8 Otros trastornos mentales y del comportamiento asociados con el puerperio, no clasificados en otra parte')
        ","insert into diag_psiquiatrico_cie_10 values(310,'F53.9 Trastorno mental puerperal, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(311,'F54 Factores psicológicos y del comportamiento asociados con trastornos o enfermedades clasificados en otra parte')
        ","insert into diag_psiquiatrico_cie_10 values(312,'F55 Abuso de sustancias que no producen dependencia')
        ","insert into diag_psiquiatrico_cie_10 values(313,'F59 Síndromes del comportamiento asociados con alteraciones fisiológicas y factores físicos, no especificados')
        ","insert into diag_psiquiatrico_cie_10 values(314,'F60 Trastornos específicos de la personalidad')
        ","insert into diag_psiquiatrico_cie_10 values(315,'F60.0 Trastorno paranoide de la personalidad')
        ","insert into diag_psiquiatrico_cie_10 values(316,'F60.1 Trastorno esquizoide de la personalidad')
        ","insert into diag_psiquiatrico_cie_10 values(317,'F60.2 Trastorno asocial de la personalidad')
        ","insert into diag_psiquiatrico_cie_10 values(318,'F60.3 Trastorno de la personalidad emocionalmente inestable')
        ","insert into diag_psiquiatrico_cie_10 values(319,'F60.4 Trastorno histriónico de la personalidad')
        ","insert into diag_psiquiatrico_cie_10 values(320,'F60.5 Trastorno anancástico de la personalidad')
        ","insert into diag_psiquiatrico_cie_10 values(321,'F60.6 Trastorno de la personalidad ansiosa (evasiva, elusiva)')
        ","insert into diag_psiquiatrico_cie_10 values(322,'F60.7 Trastorno de la personalidad dependiente')
        ","insert into diag_psiquiatrico_cie_10 values(323,'F60.8 Otros trastornos específicos de la personalidad')
        ","insert into diag_psiquiatrico_cie_10 values(324,'F60.9 Trastorno de la personalidad, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(325,'F61 Trastornos mixtos y otros trastornos de la personalidad')
        ","insert into diag_psiquiatrico_cie_10 values(326,'F62 Cambios perdurables de la personalidad, no atribuibles a lesión o a  enfermedad cerebral')
        ","insert into diag_psiquiatrico_cie_10 values(327,'F62.0 Cambio perdurable de la personalidad después de una experiencia catastrófica')
        ","insert into diag_psiquiatrico_cie_10 values(328,'F62.1 Cambio perdurable de la personalidad consecutivo a una enfermedad psiquiátrica')
        ","insert into diag_psiquiatrico_cie_10 values(329,'F62.8 Otros cambios perdurables de la personalidad')
        ","insert into diag_psiquiatrico_cie_10 values(330,'F62.9 Cambio perdurable de la personalidad, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(331,'F63 Trastornos de los hábitos y de los impulsos')
        ","insert into diag_psiquiatrico_cie_10 values(332,'F63.0 Juego patológico')
        ","insert into diag_psiquiatrico_cie_10 values(333,'F63.1 Piromanía')
        ","insert into diag_psiquiatrico_cie_10 values(334,'F63.2 Hurto patológico [cleptomanía]')
        ","insert into diag_psiquiatrico_cie_10 values(335,'F63.3 Tricotilomanía')
        ","insert into diag_psiquiatrico_cie_10 values(336,'F63.8 Otros trastornos de los hábitos y de los impulsos')
        ","insert into diag_psiquiatrico_cie_10 values(337,'F63.9 Trastorno de los hábitos y de los impulsos, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(338,'F64 Trastornos de la identidad de género')
        ","insert into diag_psiquiatrico_cie_10 values(339,'F64.0 Transexualismo')
        ","insert into diag_psiquiatrico_cie_10 values(340,'F64.1 Transvestismo de rol dual')
        ","insert into diag_psiquiatrico_cie_10 values(341,'F64.2 Trastorno de la identidad de género en la niñez')
        ","insert into diag_psiquiatrico_cie_10 values(342,'F64.8 Otros trastornos de la identidad de género')
        ","insert into diag_psiquiatrico_cie_10 values(343,'F64.9 Trastorno de la identidad de género, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(344,'F65 Trastornos de la preferencia sexual')
        ","insert into diag_psiquiatrico_cie_10 values(345,'F65.0 Fetichismo')
        ","insert into diag_psiquiatrico_cie_10 values(346,'F65.1 Transvestismo fetichista')
        ","insert into diag_psiquiatrico_cie_10 values(347,'F65.2 Exhibicionismo')
        ","insert into diag_psiquiatrico_cie_10 values(348,'F65.3 Voyeurismo')
        ","insert into diag_psiquiatrico_cie_10 values(349,'F65.4 Pedofilia')
        ","insert into diag_psiquiatrico_cie_10 values(350,'F65.5 Sadomasoquismo')
        ","insert into diag_psiquiatrico_cie_10 values(351,'F65.6 Trastornos múltiples de la preferencia sexual')
        ","insert into diag_psiquiatrico_cie_10 values(352,'F65.8 Otros trastornos de la preferencia sexual')
        ","insert into diag_psiquiatrico_cie_10 values(353,'F65.9 Trastorno de la preferencia sexual, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(354,'F66 Trastornos psicológicos y del comportamiento asociados con el desarrollo y con la orientación sexuales')
        ","insert into diag_psiquiatrico_cie_10 values(355,'F66.0 Trastorno de la maduración sexual')
        ","insert into diag_psiquiatrico_cie_10 values(356,'F66.1 Orientación sexual egodistónica')
        ","insert into diag_psiquiatrico_cie_10 values(357,'F66.2 Trastorno de la relación sexual')
        ","insert into diag_psiquiatrico_cie_10 values(358,'F66.8 Otros trastornos del desarrollo psicosexual')
        ","insert into diag_psiquiatrico_cie_10 values(359,'F66.9 Trastorno del desarrollo psicosexual, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(360,'F68 Otros trastornos de la personalidad y del comportamiento en adultos')
        ","insert into diag_psiquiatrico_cie_10 values(361,'F68.0 Elaboración de síntomas físicos por causas psicológicas')
        ","insert into diag_psiquiatrico_cie_10 values(362,'F68.1 Producción intencional o simulación de síntomas o de incapacidades, tanto físicas como  psicológicas [trastorno facticio]')
        ","insert into diag_psiquiatrico_cie_10 values(363,'F68.8 Otros trastornos especificados de la personalidad y del comportamiento en adultos')
        ","insert into diag_psiquiatrico_cie_10 values(364,'F69 Trastorno de la personalidad y del comportamiento en adultos, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(365,'F70 Retraso mental leve')
        ","insert into diag_psiquiatrico_cie_10 values(366,'F70.0 Retraso mental leve, deterioro del comportamiento nulo o mínimo')
        ","insert into diag_psiquiatrico_cie_10 values(367,'F70.1 Retraso mental leve, deterioro del comportamiento significativo, que requiere atención o tratamiento')
        ","insert into diag_psiquiatrico_cie_10 values(368,'F70.8 Retraso mental leve, otros deterioros del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(369,'F70.9 Retraso mental leve, deterioro del comportamiento de grado no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(370,'F71 Retraso mental moderado')
        ","insert into diag_psiquiatrico_cie_10 values(371,'F71.0 Retraso mental moderado, deterioro del comportamiento nulo o mínimo')
        ","insert into diag_psiquiatrico_cie_10 values(372,'F71.1 Retraso mental moderado, deterioro del comportamiento significativo, que requiere atención o tratamiento')
        ","insert into diag_psiquiatrico_cie_10 values(373,'F71.8 Retraso mental moderado, otros deterioros del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(374,'F71.9 Retraso mental moderado, deterioro del comportamiento de grado no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(375,'F72 Retraso mental grave')
        ","insert into diag_psiquiatrico_cie_10 values(376,'F72.0 Retraso mental grave, deterioro del comportamiento nulo o mínimo')
        ","insert into diag_psiquiatrico_cie_10 values(377,'F72.1 Retraso mental grave, deterioro del comportamiento significativo, que requiere atención o tratamiento')
        ","insert into diag_psiquiatrico_cie_10 values(378,'F72.8 Retraso mental grave, otros deterioros del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(379,'F72.9 Retraso mental grave, deterioro del comportamiento de grado no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(380,'F73 Retraso mental profundo')
        ","insert into diag_psiquiatrico_cie_10 values(381,'F73.0 Retraso mental profundo, deterioro del comportamiento nulo o mínimo')
        ","insert into diag_psiquiatrico_cie_10 values(382,'F73.1 Retraso mental profundo, deterioro del comportamiento significativo, que requiere atención o tratamiento')
        ","insert into diag_psiquiatrico_cie_10 values(383,'F73.8 Retraso mental profundo, otros deterioros del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(384,'F73.9 Retraso mental profundo, deterioro del comportamiento de grado no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(385,'F78 Otros tipos de retraso mental')
        ","insert into diag_psiquiatrico_cie_10 values(386,'F78.0 Otros tipos de retraso mental, deterioro del comportamiento nulo o mínimo')
        ","insert into diag_psiquiatrico_cie_10 values(387,'F78.1 Otros tipos de retraso mental, deterioro del comportamiento significativo, que requiere atención o tratamiento')
        ","insert into diag_psiquiatrico_cie_10 values(388,'F78.8 Otros tipos de retraso mental, otros deterioros del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(389,'F78.9 Otros tipos de retraso mental, deterioro del comportamiento de grado no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(390,'F79 Retraso mental, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(391,'F79.0 Retraso mental, no especificado, deterioro del comportamiento nulo o mínimo')
        ","insert into diag_psiquiatrico_cie_10 values(392,'F79.1 Retraso mental, no especificado, deterioro del comportamiento significativo, que requiere atención o tratamiento')
        ","insert into diag_psiquiatrico_cie_10 values(393,'F79.8 Retraso mental, no especificado, otros deterioros del comportamiento')
        ","insert into diag_psiquiatrico_cie_10 values(394,'F79.9 Retraso mental, no especificado, deterioro del comportamiento de grado no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(395,'F80 Trastornos específicos del desarrollo del habla y del lenguaje')
        ","insert into diag_psiquiatrico_cie_10 values(396,'F80.0 Trastorno específico de la pronunciación')
        ","insert into diag_psiquiatrico_cie_10 values(397,'F80.1 Trastorno del lenguaje expresivo')
        ","insert into diag_psiquiatrico_cie_10 values(398,'F80.2 Trastorno de la recepción del lenguaje')
        ","insert into diag_psiquiatrico_cie_10 values(399,'F80.3 Afasia adquirida con epilepsia [Landau-Kleffner]')
        ","insert into diag_psiquiatrico_cie_10 values(400,'F80.8 Otros trastornos del desarrollo del habla y del lenguaje')
        ","insert into diag_psiquiatrico_cie_10 values(401,'F80.9 Trastorno del desarrollo del habla y del lenguaje no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(402,'F81 Trastornos específicos del desarrollo de las habilidades escolares')
        ","insert into diag_psiquiatrico_cie_10 values(403,'F81.0 Trastorno específico de la lectura')
        ","insert into diag_psiquiatrico_cie_10 values(404,'F81.1 Trastorno específico del deletreo [ortografía]')
        ","insert into diag_psiquiatrico_cie_10 values(405,'F81.2 Trastorno específico de las habilidades aritméticas')
        ","insert into diag_psiquiatrico_cie_10 values(406,'F81.3 Trastorno mixto de las habilidades escolares')
        ","insert into diag_psiquiatrico_cie_10 values(407,'F81.8 Otros trastornos del desarrollo de las habilidades escolares')
        ","insert into diag_psiquiatrico_cie_10 values(408,'F81.9 Trastorno del desarrollo de las habilidades escolares, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(409,'F82 Trastorno específico del desarrollo de la función motriz')
        ","insert into diag_psiquiatrico_cie_10 values(410,'F83 Trastornos específicos mixtos del desarrollo')
        ","insert into diag_psiquiatrico_cie_10 values(411,'F84 Trastornos generalizados del desarrollo')
        ","insert into diag_psiquiatrico_cie_10 values(412,'F84.0 Autismo en la niñez')
        ","insert into diag_psiquiatrico_cie_10 values(413,'F84.1 Autismo atípico')
        ","insert into diag_psiquiatrico_cie_10 values(414,'F84.2 Síndrome de Rett')
        ","insert into diag_psiquiatrico_cie_10 values(415,'F84.3 Otro trastorno desintegrativo de la niñez')
        ","insert into diag_psiquiatrico_cie_10 values(416,'F84.4 Trastorno hiperactivo asociado con retraso mental y movimientos estereotipados')
        ","insert into diag_psiquiatrico_cie_10 values(417,'F84.5 Síndrome de Asperger')
        ","insert into diag_psiquiatrico_cie_10 values(418,'F84.8 Otros trastornos generalizados del desarrollo')
        ","insert into diag_psiquiatrico_cie_10 values(419,'F84.9 Trastorno generalizado del desarrollo no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(420,'F88 Otros trastornos del desarrollo psicológico')
        ","insert into diag_psiquiatrico_cie_10 values(421,'F89 Trastorno del desarrollo psicológico, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(422,'F90 Trastornos hipercinéticos')
        ","insert into diag_psiquiatrico_cie_10 values(423,'F90.0 Perturbación de la actividad y de la atención')
        ","insert into diag_psiquiatrico_cie_10 values(424,'F90.1 Trastorno hipercinético de la conducta')
        ","insert into diag_psiquiatrico_cie_10 values(425,'F90.8 Otros trastornos hipercinéticos')
        ","insert into diag_psiquiatrico_cie_10 values(426,'F90.9 Trastorno hipercinético, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(427,'F91 Trastornos de la conducta')
        ","insert into diag_psiquiatrico_cie_10 values(428,'F91.0 Trastorno de la conducta limitado al contexto familiar')
        ","insert into diag_psiquiatrico_cie_10 values(429,'F91.1 Trastorno de la conducta insociable')
        ","insert into diag_psiquiatrico_cie_10 values(430,'F91.2 Trastorno de la conducta sociable')
        ","insert into diag_psiquiatrico_cie_10 values(431,'F91.3 Trastorno opositor desafiante')
        ","insert into diag_psiquiatrico_cie_10 values(432,'F91.8 Otros trastornos de la conducta')
        ","insert into diag_psiquiatrico_cie_10 values(433,'F91.9 Trastorno de la conducta, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(434,'F92 Trastornos mixtos de la conducta y de las emociones')
        ","insert into diag_psiquiatrico_cie_10 values(435,'F92.0 Trastorno depresivo de la conducta')
        ","insert into diag_psiquiatrico_cie_10 values(436,'F92.8 Otros trastornos mixtos de la conducta y de las emociones')
        ","insert into diag_psiquiatrico_cie_10 values(437,'F92.9 Trastorno mixto de la conducta y de las emociones, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(438,'F93 Trastornos emocionales de comienzo específico en la niñez')
        ","insert into diag_psiquiatrico_cie_10 values(439,'F93.0 Trastorno de ansiedad de separación en la niñez')
        ","insert into diag_psiquiatrico_cie_10 values(440,'F93.1 Trastorno de ansiedad fóbica en la niñez')
        ","insert into diag_psiquiatrico_cie_10 values(441,'F93.2 Trastorno de ansiedad social en la niñez')
        ","insert into diag_psiquiatrico_cie_10 values(442,'F93.3 Trastorno de rivalidad entre hermanos')
        ","insert into diag_psiquiatrico_cie_10 values(443,'F93.8 Otros trastornos emocionales en la niñez')
        ","insert into diag_psiquiatrico_cie_10 values(444,'F93.9 Trastorno emocional en la niñez, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(445,'F94 Trastornos del comportamiento social de comienzo específico en la niñez y en la adolescencia')
        ","insert into diag_psiquiatrico_cie_10 values(446,'F94.0 Mutismo electivo')
        ","insert into diag_psiquiatrico_cie_10 values(447,'F94.1 Trastorno de vinculación reactiva en la niñez')
        ","insert into diag_psiquiatrico_cie_10 values(448,'F94.2 Trastorno de vinculación desinhibida en la niñez')
        ","insert into diag_psiquiatrico_cie_10 values(449,'F94.8 Otros trastornos del comportamiento social en la niñez')
        ","insert into diag_psiquiatrico_cie_10 values(450,'F94.9 Trastorno del comportamiento social en la niñez, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(451,'F95 Trastornos por tics')
        ","insert into diag_psiquiatrico_cie_10 values(452,'F95.0 Trastorno por tic transitorio')
        ","insert into diag_psiquiatrico_cie_10 values(453,'F95.1 Trastorno por tic motor o vocal crónico')
        ","insert into diag_psiquiatrico_cie_10 values(454,'F95.2 Trastorno por tics motores y vocales múltiples combinados [de la Tourette]')
        ","insert into diag_psiquiatrico_cie_10 values(455,'F95.8 Otros trastornos por tics')
        ","insert into diag_psiquiatrico_cie_10 values(456,'F95.9 Trastorno por tic, no especificado')
        ","insert into diag_psiquiatrico_cie_10 values(457,'F98 Otros trastornos emocionales y del comportamiento que aparecen habitualmente en la niñez y en la adolescencia')
        ","insert into diag_psiquiatrico_cie_10 values(458,'F98.0 Enuresis no orgánica')
        ","insert into diag_psiquiatrico_cie_10 values(459,'F98.1 Encopresis no orgánica')
        ","insert into diag_psiquiatrico_cie_10 values(460,'F98.2 Trastorno de la ingestión alimentaria en la infancia y la niñez')
        ","insert into diag_psiquiatrico_cie_10 values(461,'F98.3 Pica en la infancia y la niñez')
        ","insert into diag_psiquiatrico_cie_10 values(462,'F98.4 Trastornos de los movimientos estereotipados')
        ","insert into diag_psiquiatrico_cie_10 values(463,'F98.5 Tartamudez [espasmofemia]')
        ","insert into diag_psiquiatrico_cie_10 values(464,'F98.6 Farfulleo')
        ","insert into diag_psiquiatrico_cie_10 values(465,'F98.8 Otros trastornos emocionales y del comportamiento que aparecen habitualmente en la niñez y en la adolescencia')
        ","insert into diag_psiquiatrico_cie_10 values(466,'F98.9 Trastornos no especificados, emocionales y del comportamiento, que aparecen habitualmente en la niñez y en la adolescencia')
        ","insert into diag_psiquiatrico_cie_10 values(467,'F99 Trastorno mental, no especificado')"];
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
