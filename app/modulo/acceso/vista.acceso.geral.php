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
    $arr = ["insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G00 Meningitis bacteriana, no clasificada en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G00.0 Meningitis por hemófilos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G00.1 Meningitis neumocócica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G00.2 Meningitis estreptocócica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G00.3 Meningitis estafilocócica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G00.8 Otras meningitis bacterianas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G00.9 Meningitis bacteriana, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G01* Meningitis en enfermedades bacterianas clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G02* Meningitis en otras enfermedades infecciosas y parasitarias clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G02.0* Meningitis en enfermedades virales clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G02.1* Meningitis en micosis')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G02.8* Meningitis en otras enfermedades infecciosas y parasitarias especificadas clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G03 Meningitis debida a otras causas y a las no especificadas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G03.0 Meningitis apiógena')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G03.1 Meningitis crónica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G03.2 Meningitis recurrente benigna [Mollaret]')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G03.8 Meningitis debidas a otras causas especificadas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G03.9 Meningitis, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G04 Encefalitis, mielitis y encefalomielitis')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G04.0 Encefalitis aguda diseminada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G04.1 Paraplejía espástica tropical')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G04.2 Meningoencefalitis y meningomielitis bacterianas, no clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G04.8 Otras encefalitis, mielitis y encefalomielitis')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G04.9 Encefalitis, mielitis y encefalomielitis, no especificadas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G05* Encefalitis, mielitis y encefalomielitis en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G05.0* Encefalitis, mielitis y encefalomielitis en enfermedades bacterianas clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G05.1* Encefalitis, mielitis y encefalomielitis en enfermedades virales clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G05.2* Encefalitis, mielitis y encefalomielitis en otras enfermedades infecciosas y parasitarias clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G05.8* Encefalitis, mielitis y encefalomielitis en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G06 Absceso y granuloma intracraneal e intrarraquídeo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G06.0 Absceso y granuloma intracraneal')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G06.1 Absceso y granuloma intrarraquídeo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G06.2 Absceso extradural y subdural, no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G07* Absceso y granuloma intracraneal e intrarraquídeo en enfermedades  clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G08 Flebitis y tromboflebitis intracraneal e intrarraquídea')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G09 Secuelas de enfermedades inflamatorias del sistema nervioso central')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G10 Enfermedad de Huntington')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G11 Ataxia hereditaria')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G11.0 Ataxia congénita no progresiva')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G11.1 Ataxia cerebelosa de iniciación temprana')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G11.2 Ataxia cerebelosa de iniciación tardía')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G11.3 Ataxia cerebelosa con reparación defectuosa del ADN')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G11.4 Paraplejía espástica hereditaria')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G11.8 Otras ataxias hereditarias')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G11.9 Ataxia hereditaria, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G12 Atrofia muscular espinal y síndromes afines')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G12.0 Atrofia muscular espinal infantil, tipo I [Werdnig-Hoffman]')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G12.1 Otras atrofias musculares espinales hereditarias')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G12.2 Enfermedades de las neuronas motoras')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G12.8 Otras atrofias musculares espinales y síndromes afines')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G12.9 Atrofia muscular espinal, sin otra especificación')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G13* Atrofias sistémicas que afectan primariamente el sistema nervioso central en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G13.0* Neuromiopatía y neuropatía paraneoplásica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G13.1* Otras atrofias sistémicas que afectan el sistema nervioso central en enfermedad neoplásica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G13.2* Atrofia sistémica que afecta primariamente el sistema nervioso central en el mixedema (E00.1+, E03.-+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G13.8* Atrofia sistémica que afecta primariamente el sistema nervioso central en otras enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G20 Enfermedad de Parkinson')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G21 Parkinsonismo secundario')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G21.0 Síndrome neuroléptico maligno')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G21.1 Otro parkinsonismo secundario inducido por drogas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G21.2 Parkinsonismo secundario debido a otros agentes externos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G21.3 Parkinsonismo postencefalítico')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G21.8 Otros tipos de parkinsonismo secundario')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G21.9 Parkinsonismo secundario, no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G22* Parkinsonismo en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G23 Otras enfermedades degenerativas de los núcleos de la base')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G23.0 Enfermedad de Hallervorden-Spatz')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G23.1 Oftalmoplejía supranuclear progresiva [Steele-Richardson-Olszewski]')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G23.2 Degeneración nigroestriada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G23.8 Otras enfermedades degenerativas específicas de los núcleos de la base')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G23.9 Enfermedad degenerativa de los núcleos de la base, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G24 Distonía')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G24.0 Distonía inducida por drogas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G24.1 Distonía idiopática familiar')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G24.2 Distonía idiopática no familiar')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G24.3 Tortícolis espasmódica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G24.4 Distonía bucofacial idiopática')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G24.5 Blefarospasmo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G24.8 Otras distonías')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G24.9 Distonía, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G25 Otros trastornos extrapiramidales y del movimiento')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G25.0 Temblor esencial')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G25.1 Temblor inducido por drogas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G25.2 Otras formas especificadas de temblor')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G25.3 Mioclonía')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G25.4 Corea inducida por drogas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G25.5 Otras coreas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G25.6 Tics inducidos por drogas y otros tics de origen orgánico')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G25.8 Otros trastornos extrapiramidales y del movimiento')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G25.9 Trastorno extrapiramidal y del movimiento, no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G26* Trastornos extrapiramidales y del movimiento en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G30 Enfermedad de Alzheimer')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G30.0 Enfermedad de Alzheimer de comienzo temprano')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G30.1 Enfermedad de Alzheimer de comienzo tardío')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G30.8 Otros tipos de enfermedad de Alzheimer')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G30.9 Enfermedad de Alzheimer, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G31 Otras enfermedades degenerativas del sistema nervioso, no  clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G31.0 Atrofia cerebral circunscrita')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G31.1 Degeneración cerebral senil no clasificada en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G31.2 Degeneración del sistema nervioso debida al alcohol')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G31.8 Otras enfermedades degenerativas especificadas del sistema nervioso')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G31.9 Degeneración del sistema nervioso, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G32 Otros trastornos degenerativos del sistema nervioso en enfermedades  clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G32.0 Degeneración combinada subaguda de la médula espinal en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G32.8 Otros trastornos degenerativos especificados del sistema nervioso en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G35 Esclerosis múltiple')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G36 Otras desmielinizaciones diseminadas agudas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G36.0 Neuromielitis óptica [Devic]')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G36.1 Leucoencefalitis hemorrágica aguda y subaguda [Hurst]')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G36.8 Otras desmielinizaciones agudas diseminadas especificadas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G36.9 Desmielinización diseminada aguda, sin otra especificación')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G37 Otras enfermedades desmielinizantes del sistema nervioso central')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G37.0 Esclerosis difusa')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G37.1 Desmielinización central del cuerpo calloso')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G37.2 Mielinólisis central pontina')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G37.3 Mielitis transversa aguda en enfermedad desmielinizante del sistema nervioso central')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G37.4 Mielitis necrotizante subaguda')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G37.5 Esclerosis concéntrica [Baló]')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G37.8 Otras enfermedades desmielinizantes del sistema nervioso central, especificadas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G37.9 Enfermedad desmielinizante del sistema nervioso central, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G40 Epilepsia')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G40.0 Epilepsia y síndromes epilépticos idiopáticos relacionados con localizaciones (focales) (parciales) y con ataques de inicio localizado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G40.1 Epilepsia y síndromes epilépticos sintomáticos relacionados con localizaciones (focales) (parciales) y con ataques parciales simples')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G40.2 Epilepsia y síndromes epilépticos sintomáticos relacionados con localizaciones (focales) (parciales) y con ataques parciales complejos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G40.3 Epilepsia y síndromes epilépticos idiopáticos generalizados')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G40.4 Otras epilepsias y síndromes epilépticos generalizados')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G40.5 Síndromes epilépticos especiales')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G40.6 Ataques de gran mal, no especificados (con o sin pequeño mal)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G40.7 Pequeño mal, no especificado (sin ataque de gran mal)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G40.8 Otras epilepsias')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G40.9 Epilepsia, tipo no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G41 Estado de mal epiléptico')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G41.0 Estado de gran mal epiléptico')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G41.1 Estado de pequeño mal epiléptico')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G41.2 Estado de mal epiléptico parcial complejo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G41.8 Otros estados epilépticos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G41.9 Estado de mal epiléptico de tipo no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G43 Migraña')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G43.0 Migraña sin aura [migraña común]')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G43.1 Migraña con aura [migraña clásica]')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G43.2 Estado migrañoso')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G43.3 Migraña complicada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G43.8 Otras migrañas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G43.9 Migraña, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G44 Otros síndromes de cefalea')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G44.0 Síndrome de cefalea en racimos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G44.1 Cefalea vascular, NCOP')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G44.2 Cefalea debida a tensión')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G44.3 Cefalea postraumática crónica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G44.4 Cefalea inducida por drogas, no clasificada en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G44.8 Otros síndromes de cefalea especificados')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G45 Ataques de isquemia cerebral transitoria y síndromes afines')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G45.0 Síndrome arterial vértebro-basilar')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G45.1 Síndrome de la arteria carótida (hemisférico)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G45.2 Síndromes arteriales precerebrales bilaterales y múltiples')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G45.3 Amaurosis fugaz')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G45.4 Amnesia global transitoria')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G45.8 Otras isquemias cerebrales transitorias y síndromes afines')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G45.9 Isquemia cerebral transitoria, sin otra especificación')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G46* Síndromes vasculares encefálicos en enfermedades cerebrovasculares (I60- I67+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G46.0* Síndrome de la arteria cerebral media (I66.0+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G46.1* Síndrome de la arteria cerebral anterior (I66.1+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G46.2* Síndrome de la arteria cerebral posterior (I66.2+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G46.3* Síndromes apopléticos del tallo encefálico (I60-I67+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G46.4* Síndrome de infarto cerebeloso (I60-I67+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G46.5* Síndrome lacunar motor puro (I60-I67+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G46.6* Síndrome lacunar sensorial puro (I60-I67+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G46.7* Otros síndromes lacunares (I60-I67+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G46.8* Otros síndromes vasculares encefálicos en enfermedades cerebrovasculares (I60-I67+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G47 Trastornos del sueño')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G47.0 Trastornos del inicio y del mantenimiento del sueño [insomnios]')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G47.1 Trastornos de somnolencia excesiva [hipersomnios]')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G47.2 Trastornos del ritmo nictameral')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G47.3 Apnea del sueño')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G47.4 Narcolepsia y cataplexia')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G47.8 Otros trastornos del sueño')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G47.9 Trastorno del sueño, no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G50 Trastornos del nervio trigémino')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G50.0 Neuralgia del trigémino')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G50.1 Dolor facial atípico')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G50.8 Otros trastornos del trigémino')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G50.9 Trastorno del trigémino, no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G51 Trastornos del nervio facial')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G51.0 Parálisis de Bell')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G51.1 Ganglionitis geniculada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G51.2 Síndrome de Melkersson')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G51.3 Espasmo hemifacial clónico')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G51.4 Mioquimia facial')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G51.8 Otros trastornos del nervio facial')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G51.9 Trastorno del nervio facial, no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G52 Trastornos de otros nervios craneales')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G52.0 Trastornos del nervio olfatorio')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G52.1 Trastornos del nervio glosofaríngeo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G52.2 Trastornos del nervio vago')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G52.3 Trastornos del nervio hipogloso')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G52.7 Trastornos de múltiples nervios craneales')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G52.8 Trastornos de otros nervios craneales especificados')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G52.9 Trastorno de nervio craneal, no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G53* Trastornos de los nervios craneales en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G53.0* Neuralgia postherpes zoster (B02.2+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G53.1* Parálisis múltiple de los nervios craneales en enfermedades infecciosas y parasitarias clasificadas en otra parte (A00-B99+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G53.2* Parálisis múltiple de los nervios craneales, en la sarcoidosis (D86.8+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G53.3* Parálisis múltiple de los nervios craneales, en enfermedades neoplásicas (C00-D48+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G53.8* Otros trastornos de los nervios craneales en otras enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G54 Trastornos de las raíces y de los plexos nerviosos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G54.0 Trastornos del plexo braquial')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G54.1 Trastornos del plexo lumbosacro')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G54.2 Trastornos de la raíz cervical, no clasificados en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G54.3 Trastornos de la raíz torácica, no clasificados en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G54.4 Trastornos de la raíz lumbosacra, no clasificados en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G54.5 Amiotrofia neurálgica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G54.6 Síndrome del miembro fantasma con dolor')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G54.7 Síndrome del miembro fantasma sin dolor')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G54.8 Otros trastornos de las raíces y plexos nerviosos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G54.9 Trastorno de la raíz y plexos nerviosos, no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G55* Compresiones de las raíces y de los plexos nerviosos en enfermedades  clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G55.0* Compresiones de las raíces y plexos nerviosos en enfermedades neoplásicas (C00-D48+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G55.1* Compresiones de las raíces y plexos nerviosos en trastornos de los discos intervertebrales (M50-M51+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G55.2* Compresiones de las raíces y plexos nerviosos en la espondilosis (M47.-+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G55.3* Compresiones de las raíces y plexos nerviosos en otras dorsopatías (M45- M46+, M48.-+, M53-M54+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G55.8* Compresiones de las raíces y plexos nerviosos en otras enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G56 Mononeuropatías del miembro superior')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G56.0 Síndrome del túnel carpiano')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G56.1 Otras lesiones del nervio mediano')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G56.2 Lesión del nervio cubital')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G56.3 Lesión del nervio radial')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G56.4 Causalgia')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G56.8 Otras mononeuropatías del miembro superior')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G56.9 Mononeuropatía del miembro superior, sin otra especificación')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G57 Mononeuropatías del miembro inferior')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G57.0 Lesión del nervio ciático')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G57.1 Meralgia parestésica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G57.2 Lesión del nervio crural')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G57.3 Lesión del nervio ciático poplíteo externo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G57.4 Lesión del nervio ciático poplíteo interno')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G57.5 Síndrome del túnel calcáneo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G57.6 Lesión del nervio plantar')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G57.8 Otras mononeuropatías del miembro inferior')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G57.9 Mononeuropatía del miembro inferior, sin otra especificación')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G58 Otras mononeuropatías')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G58.0 Neuropatía intercostal')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G58.7 Mononeuritis múltiple')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G58.8 Otras mononeuropatías especificadas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G58.9 Mononeuropatía, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G59* Mononeuropatía en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G59.0* Mononeuropatía diabética (E10-E14+ con cuarto carácter común .4)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G59.8* Otras mononeuropatías en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G60 Neuropatía hereditaria e idiopática')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G60.0 Neuropatía hereditaria motora y sensorial')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G60.1 Enfermedad de Refsum')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G60.2 Neuropatía asociada con ataxia hereditaria')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G60.3 Neuropatía progresiva idiopática')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G60.8 Otras neuropatías hereditarias e idiopáticas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G60.9 Neuropatía hereditaria e idiopática, sin otra especificación')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G61 Polineuropatía inflamatoria')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G61.0 Síndrome de Guillain-Barré')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G61.1 Neuropatía al suero')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G61.8 Otras polineuropatías inflamatorias')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G61.9 Polineuropatía inflamatoria, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G62 Otras polineuropatías')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G62.0 Polineuropatía inducida por drogas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G62.1 Polineuropatía alcohólica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G62.2 Polineuropatía debida a otro agente tóxico')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G62.8 Otras polineuropatías especificadas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G62.9 Polineuropatía, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G63* Polineuropatías en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G63.0* Polineuropatía en enfermedades infecciosas y parasitarias clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G63.1* Polineuropatía en enfermedad neoplásica (C00-D48+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G63.2* Polineuropatía diabética (E10-E14+ con cuarto carácter común .4)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G63.3* Polineuropatía en otras enfermedades endocrinas y metabólicas (E00-E07+, E15-E16+, E20-E34+, E70-E89+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G63.4* Polineuropatía en deficiencia nutricional (E40-E64+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G63.5* Polineuropatía en trastornos del tejido conectivo sistémico (M30-M35+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G63.6* Polineuropatía en otros trastornos osteomusculares (M00-M25+, M40-M96+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G63.8* Polineuropatía en otras enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G64 Otros trastornos del sistema nervioso periférico')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G70 Miastenia gravis y otros trastornos neuromusculares')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G70.0 Miastenia gravis')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G70.1 Trastornos tóxicos neuromusculares')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G70.2 Miastenia congénita o del desarrollo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G70.8 Otros trastornos neuromusculares especificados')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G70.9 Trastorno neuromuscular, no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G71 Trastornos musculares primarios')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G71.0 Distrofia muscular')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G71.1 Trastornos miotónicos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G71.2 Miopatías congénitas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G71.3 Miopatía mitocóndrica, no clasificada en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G71.8 Otros trastornos primarios de los músculos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G71.9 Trastorno primario del músculo, tipo no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G72 Otras miopatías')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G72.0 Miopatía inducida por drogas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G72.1 Miopatía alcohólica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G72.2 Miopatía debida a otros agentes tóxicos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G72.3 Parálisis periódica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G72.4 Miopatía inflamatoria, no clasificada en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G72.8 Otras miopatías especificadas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G72.9 Miopatía, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G73* Trastornos del músculo y de la unión neuromuscular en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G73.0* Síndromes miasténicos en enfermedades endocrinas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G73.1* Síndrome de Eaton-Lambert (C80+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G73.2* Otros síndromes miasténicos en enfermedad neoplásica (C00-D48+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G73.3* Síndromes miasténicos en otras enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G73.4* Miopatía en enfermedades infecciosas y parasitarias clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G73.5* Miopatía en enfermedades endocrinas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G73.6* Miopatía en enfermedades metabólicas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G73.7* Miopatía en otras enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G80 Parálisis cerebral infantil')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G80.0 Parálisis cerebral espástica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G80.1 Diplejía espástica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G80.2 Hemiplejía infantil')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G80.3 Parálisis cerebral discinética')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G80.4 Parálisis cerebral atáxica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G80.8 Otros tipos de parálisis cerebral infantil')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G80.9 Parálisis cerebral infantil, sin otra especificación')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G81 Hemiplejía')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G81.0 Hemiplejía flácida')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G81.1 Hemiplejía espástica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G81.9 Hemiplejía, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G82 Paraplejía y cuadriplejía')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G82.0 Paraplejía flácida')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G82.1 Paraplejía espástica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G82.2 Paraplejía, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G82.3 Cuadriplejía flácida')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G82.4 Cuadriplejía espástica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G82.5 Cuadriplejía, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G83 Otros síndromes paralíticos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G83.0 Diplejía de los miembros superiores')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G83.1 Monoplejía de miembro inferior')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G83.2 Monoplejía de miembro superior')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G83.3 Monoplejía, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G83.4 Síndrome de la cola de caballo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G83.8 Otros síndromes paralíticos especificados')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G83.9 Síndrome paralítico, no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G90 Trastornos del sistema nervioso autónomo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G90.0 Neuropatía autónoma periférica idiopática')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G90.1 Disautonomía familiar [Síndrome de Riley-Day]')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G90.2 Síndrome de Horner')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G90.3 Degeneración de sistemas múltiples')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G90.8 Otros trastornos del sistema nervioso autónomo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G90.9 Trastorno del sistema nervioso autónomo, no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G91 Hidrocéfalo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G91.0 Hidrocéfalo comunicante')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G91.1 Hidrocéfalo obstructivo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G91.2 Hidrocéfalo de presión normal')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G91.3 Hidrocéfalo postraumático, sin otra especificación')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G91.8 Otros tipos de hidrocéfalo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G91.9 Hidrocéfalo, no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G92 Encefalopatía tóxica')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G93 Otros trastornos del encéfalo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G93.0 Quiste cerebral')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G93.1 Lesión cerebral anóxica, no clasificada en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G93.2 Hipertensión intracraneal benigna')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G93.3 Síndrome de fatiga postviral')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G93.4 Encefalopatía no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G93.5 Compresión del encéfalo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G93.6 Edema cerebral')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G93.7 Síndrome de Reye')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G93.8 Otros trastornos especificados del encéfalo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G93.9 Trastorno del encéfalo, no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G94* Otros trastornos del encéfalo en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G94.0* Hidrocéfalo en enfermedades infecciosas y parasitarias clasificadas en otra parte (A00-B99+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G94.1* Hidrocéfalo en enfermedad neoplásica (C00-D48+)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G94.2* Hidrocéfalo en otras enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G94.8* Otros trastornos encefálicos especificados en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G95 Otras enfermedades de la médula espinal')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G95.0 Siringomielia y siringobulbia')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G95.1 Mielopatías vasculares')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G95.2 Compresión medular, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G95.8 Otras enfermedades especificadas de la médula espinal')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G95.9 Enfermedad de la médula espinal, no especificada')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G96 Otros trastornos del sistema nervioso central')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G96.0 Pérdida de líquido cefalorraquídeo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G96.1 Trastornos de las meninges, no clasificados en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G96.8 Otros trastornos especificados del sistema nervioso central')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G96.9 Trastorno del sistema nervioso central, no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G97 Trastornos del sistema nervioso consecutivos a procedimientos, no clasificados en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G97.0 Pérdida de líquido cefalorraquídeo por punción espinal')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G97.1 Otra reacción a la punción espinal y lumbar')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G97.2 Hipotensión intracraneal posterior a anastomosis ventricular')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G97.8 Otros trastornos del sistema nervioso consecutivos a procedimientos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G97.9 Trastornos no especificados del sistema nervioso, consecutivos a procedimientos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G98 Otros trastornos del sistema nervioso, no clasificados en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G99* Otros trastornos del sistema nervioso en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G99.0* Neuropatía autonómica en enfermedades metabólicas y endocrinas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G99.1* Otros trastornos del sistema nervioso autónomo en otras enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G99.2* Mielopatía en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'G99.8* Otros trastornos especificados del sistema nervioso en enfermedades clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q00 Anencefalia y malformaciones congénitas similares')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q01 Encefalocele')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q02 Microcefalia')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q03 Hidrocéfalo congénito')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q04 Otras malformaciones congénitas del encéfalo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q05 Espina bífida')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q06 Otras malformaciones congénitas de la médula espinal')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q07 Otras malformaciones congénitas del sistema nervioso')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q10 Malformaciones congénitas de los párpados, del aparato lagrimal y de la órbita')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q11 Anoftalmía, microftalmía y macroftalmía')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q12 Malformaciones congénitas del cristalino')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q13 Malformaciones congénitas del segmento anterior del ojo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q14 Malformaciones congénitas del segmento posterior del ojo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q15 Otras malformaciones congénitas del ojo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q16 Malformaciones congénitas del oído que causan alteración de la audición')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q17 Otras malformaciones congénitas del oído')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q18 Otras malformaciones congénitas de la cara y del cuello')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q20 Malformaciones congénitas de las cámaras cardíacas y sus conexiones')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q21 Malformaciones congénitas de los tabiques cardíacos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q22 Malformaciones congénitas de las válvulas pulmonar y tricúspide')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q23 Malformaciones congénitas de las válvulas aórtica y mitral')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q24 Otras malformaciones congénitas del corazón')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q25 Malformaciones congénitas de las grandes arterias')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q26 Malformaciones congénitas de las grandes venas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q27 Otras malformaciones congénitas del sistema vascular periférico')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q28 Otras malformaciones congénitas del sistema circulatorio')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q30 Malformaciones congénitas de la nariz')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q31 Malformaciones congénitas de la laringe')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q32 Malformaciones congénitas de la tráquea y de los bronquios')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q33 Malformaciones congénitas del pulmón')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q34 Otras malformaciones congénitas del sistema respiratorio')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q35 Fisura del paladar')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q36 Labio leporino')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q37 Fisura del paladar con labio leporino')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q38 Otras malformaciones congénitas de la lengua, de la boca y de la faringe')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q39 Malformaciones congénitas del esófago')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q40 Otras malformaciones congénitas de la parte superior del tubo digestivo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q41 Ausencia, atresia y estenosis congénita del intestino delgado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q42 Ausencia, atresia y estenosis congénita del intestino grueso')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q43 Otras malformaciones congénitas del intestino')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q44 Malformaciones congénitas de la vesícula biliar, de los conductos biliares y  del hígado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q45 Otras malformaciones congénitas del sistema digestivo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q50 Malformaciones congénitas de los ovarios, de las trompas de Falopio y de los ligamentos anchos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q51 Malformaciones congénitas del útero y del cuello uterino')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q52 Otras malformaciones congénitas de los órganos genitales femeninos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q53 Testículo no descendido')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q54 Hipospadias')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q55 Otras malformaciones congénitas de los órganos genitales masculinos')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q56 Sexo indeterminado y seudohermafroditismo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q60 Agenesia renal y otras malformaciones hipoplásicas del riñón')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q61 Enfermedad quística del riñón')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q62 Defectos obstructivos congénitos de la pelvis renal y malformaciones  congénitas del uréter')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q63 Otras malformaciones congénitas del riñón')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q64 Otras malformaciones congénitas del sistema urinario')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q65 Deformidades congénitas de la cadera')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q66 Deformidades congénitas de los pies')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q67 Deformidades osteomusculares congénitas de la cabeza, de la cara, de la  columna vertebral y del tórax')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q68 Otras deformidades osteomusculares congénitas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q69 Polidactilia')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q70 Sindactilia')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q71 Defectos por reducción del miembro superior')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q72 Defectos por reducción del miembro inferior')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q73 Defectos por reducción de miembro no especificado')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q74 Otras anomalías congénitas del (de los) miembro(s)')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q75 Otras malformaciones congénitas de los huesos del cráneo y de la cara')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q76 Malformaciones congénitas de la columna vertebral y tórax óseo')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q77 Osteocondrodisplasia con defecto del crecimiento de los huesos largos y de la columna vertebral')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q78 Otras osteocondrodisplasias')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q79 Malformaciones congénitas del sistema osteomuscular, no clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q80 Ictiosis congénita')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q81 Epidermólisis bullosa')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q82 Otras malformaciones congénitas de la piel')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q83 Malformaciones congénitas de la mama')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q84 Otras malformaciones congénitas de las faneras')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q85 Facomatosis, no clasificada en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q86 Síndromes de malformaciones congénitas debidos a causas exógenas conocidas, no  clasificados en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q87 Otros síndromes de malformaciones congénitas especificados que afectan múltiples sistemas')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q89 Otras malformaciones congénitas, no clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q90 Síndrome de Down')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q91 Síndrome de Edwards y síndrome de Patau')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q92 Otras trisomías y trisomías parciales de los autosomas, no clasificadas en otra  parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q93 Monosomías y supresiones de los autosomas, no clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q95 Reordenamientos equilibrados y marcadores estructurales, no clasificados en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q96 Síndrome de Turner')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q97 Otras anomalías de los cromosomas sexuales, con fenotipo femenino, no clasificadas en otra parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q98 Otras anomalías de los cromosomas sexuales, con fenotipo masculino, no clasificadas en otra  parte')
    ","insert into cie_10 (id, nombre ) values(seq_cie_10.NEXTVAL,'Q99 Otras anomalías cromosómicas, no clasificadas en otra parte')"];
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
