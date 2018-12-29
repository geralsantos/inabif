<form action="geral" method="POST">
<input type="text" value="" name="nombretabla" placeholder="tabla">
<button type="submit">mostrar resultados</button></form>
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

        $stmt = parent::prepare($query);

        if($stmt->execute($params)){
            echo "executeQuery";
          return $stmt->fetchAll();

        }else{

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
        $stmt->execute($params);
        echo "borrado: ".$tabla;
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
    
    die();
}
if (isset($_POST["nombretabla"]) && $_POST["nombretabla"]!="") {
    echo "SELECT * FROM ".$_POST["nombretabla"]." WHERE ESTADO=1";
    echo "<br>";
    print_r($x->executeQuery("SELECT * FROM ".$_POST["nombretabla"]." "));
    die();
}else{
$x->dropTable('drop table ubigeo ');
$mdl->createTable("create table ubigeo (
    id INT NOT NULL primary key,
    CodDept VARCHAR(10) NOT NULL,
    NomDept VARCHAR(150) NOT NULL,
    CodProv VARCHAR(10) NOT NULL,
    NomProv VARCHAR(150) NOT NULL,
    CodDist VARCHAR(10) NOT NULL,
    NomDist VARCHAR(150) NOT NULL,
    estado INT DEFAULT 1
    )
  "); 

$Ubigeo = ["INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010101', 'CHACHAPOYAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (2, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010102', 'ASUNCION')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (3, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010103', 'BALSAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (4, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010104', 'CHETO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (5, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010105', 'CHILIQUIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (6, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010106', 'CHUQUIBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (7, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010107', 'GRANADA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (8, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010108', 'HUANCAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (9, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010109', 'LA JALCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (10, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010110', 'LEIMEBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (11, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010111', 'LEVANTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (12, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010112', 'MAGDALENA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (13, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010113', 'MARISCAL CASTILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (14, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010114', 'MOLINOPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (15, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010115', 'MONTEVIDEO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (16, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010116', 'OLLEROS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (17, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010117', 'QUINJALCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (18, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010118', 'SAN FCO DE DAGUAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (19, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010119', 'SAN ISIDRO DE MAINO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (20, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010120', 'SOLOCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (21, '01', 'DEPARTAMENTO AMAZONAS', '0101', 'CHACHAPOYAS', '010121', 'SONCHE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (22, '01', 'DEPARTAMENTO AMAZONAS', '0102', 'BAGUA', '010201', 'LA PECA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (23, '01', 'DEPARTAMENTO AMAZONAS', '0102', 'BAGUA', '010202', 'ARAMANGO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (24, '01', 'DEPARTAMENTO AMAZONAS', '0102', 'BAGUA', '010203', 'COPALLIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (25, '01', 'DEPARTAMENTO AMAZONAS', '0102', 'BAGUA', '010204', 'EL PARCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (26, '01', 'DEPARTAMENTO AMAZONAS', '0102', 'BAGUA', '010205', 'BAGUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (27, '01', 'DEPARTAMENTO AMAZONAS', '0102', 'BAGUA', '010206', 'IMAZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (28, '01', 'DEPARTAMENTO AMAZONAS', '0103', 'BONGARA', '010301', 'JUMBILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (29, '01', 'DEPARTAMENTO AMAZONAS', '0103', 'BONGARA', '010302', 'COROSHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (30, '01', 'DEPARTAMENTO AMAZONAS', '0103', 'BONGARA', '010303', 'CUISPES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (31, '01', 'DEPARTAMENTO AMAZONAS', '0103', 'BONGARA', '010304', 'CHISQUILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (32, '01', 'DEPARTAMENTO AMAZONAS', '0103', 'BONGARA', '010305', 'CHURUJA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (33, '01', 'DEPARTAMENTO AMAZONAS', '0103', 'BONGARA', '010306', 'FLORIDA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (34, '01', 'DEPARTAMENTO AMAZONAS', '0103', 'BONGARA', '010307', 'RECTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (35, '01', 'DEPARTAMENTO AMAZONAS', '0103', 'BONGARA', '010308', 'SAN CARLOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (36, '01', 'DEPARTAMENTO AMAZONAS', '0103', 'BONGARA', '010309', 'SHIPASBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (37, '01', 'DEPARTAMENTO AMAZONAS', '0103', 'BONGARA', '010310', 'VALERA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (38, '01', 'DEPARTAMENTO AMAZONAS', '0103', 'BONGARA', '010311', 'YAMBRASBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (39, '01', 'DEPARTAMENTO AMAZONAS', '0103', 'BONGARA', '010312', 'JAZAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (40, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010401', 'LAMUD')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (41, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010402', 'CAMPORREDONDO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (42, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010403', 'COCABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (43, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010404', 'COLCAMAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (44, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010405', 'CONILA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (45, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010406', 'INGUILPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (46, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010407', 'LONGUITA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (47, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010408', 'LONYA CHICO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (48, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010409', 'LUYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (49, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010410', 'LUYA VIEJO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (50, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010411', 'MARIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (51, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010412', 'OCALLI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (52, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010413', 'OCUMAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (53, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010414', 'PISUQUIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (54, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010415', 'SAN CRISTOBAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (55, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010416', 'SAN FRANCISCO DE YESO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (56, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010417', 'SAN JERONIMO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (57, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010418', 'SAN JUAN DE LOPECANCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (58, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010419', 'SANTA CATALINA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (59, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010420', 'SANTO TOMAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (60, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010421', 'TINGO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (61, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010422', 'TRITA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (62, '01', 'DEPARTAMENTO AMAZONAS', '0104', 'LUYA', '010423', 'PROVIDENCIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (63, '01', 'DEPARTAMENTO AMAZONAS', '0105', 'RODRIGUEZ DE MENDOZA', '010501', 'SAN NICOLAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (64, '01', 'DEPARTAMENTO AMAZONAS', '0105', 'RODRIGUEZ DE MENDOZA', '010502', 'COCHAMAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (65, '01', 'DEPARTAMENTO AMAZONAS', '0105', 'RODRIGUEZ DE MENDOZA', '010503', 'CHIRIMOTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (66, '01', 'DEPARTAMENTO AMAZONAS', '0105', 'RODRIGUEZ DE MENDOZA', '010504', 'HUAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (67, '01', 'DEPARTAMENTO AMAZONAS', '0105', 'RODRIGUEZ DE MENDOZA', '010505', 'LIMABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (68, '01', 'DEPARTAMENTO AMAZONAS', '0105', 'RODRIGUEZ DE MENDOZA', '010506', 'LONGAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (69, '01', 'DEPARTAMENTO AMAZONAS', '0105', 'RODRIGUEZ DE MENDOZA', '010507', 'MILPUC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (70, '01', 'DEPARTAMENTO AMAZONAS', '0105', 'RODRIGUEZ DE MENDOZA', '010508', 'MCAL BENAVIDES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (71, '01', 'DEPARTAMENTO AMAZONAS', '0105', 'RODRIGUEZ DE MENDOZA', '010509', 'OMIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (72, '01', 'DEPARTAMENTO AMAZONAS', '0105', 'RODRIGUEZ DE MENDOZA', '010510', 'SANTA ROSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (73, '01', 'DEPARTAMENTO AMAZONAS', '0105', 'RODRIGUEZ DE MENDOZA', '010511', 'TOTORA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (74, '01', 'DEPARTAMENTO AMAZONAS', '0105', 'RODRIGUEZ DE MENDOZA', '010512', 'VISTA ALEGRE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (75, '01', 'DEPARTAMENTO AMAZONAS', '0106', 'CONDORCANQUI', '010601', 'NIEVA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (76, '01', 'DEPARTAMENTO AMAZONAS', '0106', 'CONDORCANQUI', '010602', 'RIO SANTIAGO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (77, '01', 'DEPARTAMENTO AMAZONAS', '0106', 'CONDORCANQUI', '010603', 'EL CENEPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (78, '01', 'DEPARTAMENTO AMAZONAS', '0107', 'UTCUBAMBA', '010701', 'BAGUA GRANDE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (79, '01', 'DEPARTAMENTO AMAZONAS', '0107', 'UTCUBAMBA', '010702', 'CAJARURO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (80, '01', 'DEPARTAMENTO AMAZONAS', '0107', 'UTCUBAMBA', '010703', 'CUMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (81, '01', 'DEPARTAMENTO AMAZONAS', '0107', 'UTCUBAMBA', '010704', 'EL MILAGRO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (82, '01', 'DEPARTAMENTO AMAZONAS', '0107', 'UTCUBAMBA', '010705', 'JAMALCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (83, '01', 'DEPARTAMENTO AMAZONAS', '0107', 'UTCUBAMBA', '010706', 'LONYA GRANDE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (84, '01', 'DEPARTAMENTO AMAZONAS', '0107', 'UTCUBAMBA', '010707', 'YAMON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (85, '02', 'DEPARTAMENTO ANCASH', '0201', 'HUARAZ', '020101', 'HUARAZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (86, '02', 'DEPARTAMENTO ANCASH', '0201', 'HUARAZ', '020102', 'INDEPENDENCIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (87, '02', 'DEPARTAMENTO ANCASH', '0201', 'HUARAZ', '020103', 'COCHABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (88, '02', 'DEPARTAMENTO ANCASH', '0201', 'HUARAZ', '020104', 'COLCABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (89, '02', 'DEPARTAMENTO ANCASH', '0201', 'HUARAZ', '020105', 'HUANCHAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (90, '02', 'DEPARTAMENTO ANCASH', '0201', 'HUARAZ', '020106', 'JANGAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (91, '02', 'DEPARTAMENTO ANCASH', '0201', 'HUARAZ', '020107', 'LA LIBERTAD')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (92, '02', 'DEPARTAMENTO ANCASH', '0201', 'HUARAZ', '020108', 'OLLEROS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (93, '02', 'DEPARTAMENTO ANCASH', '0201', 'HUARAZ', '020109', 'PAMPAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (94, '02', 'DEPARTAMENTO ANCASH', '0201', 'HUARAZ', '020110', 'PARIACOTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (95, '02', 'DEPARTAMENTO ANCASH', '0201', 'HUARAZ', '020111', 'PIRA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (96, '02', 'DEPARTAMENTO ANCASH', '0201', 'HUARAZ', '020112', 'TARICA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (97, '02', 'DEPARTAMENTO ANCASH', '0202', 'AIJA', '020201', 'AIJA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (98, '02', 'DEPARTAMENTO ANCASH', '0202', 'AIJA', '020203', 'CORIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (99, '02', 'DEPARTAMENTO ANCASH', '0202', 'AIJA', '020205', 'HUACLLAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (100, '02', 'DEPARTAMENTO ANCASH', '0202', 'AIJA', '020206', 'LA MERCED')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (101, '02', 'DEPARTAMENTO ANCASH', '0202', 'AIJA', '020208', 'SUCCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (102, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020301', 'CHIQUIAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (103, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020302', 'A PARDO LEZAMETA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (104, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020304', 'AQUIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (105, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020305', 'CAJACAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (106, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020310', 'HUAYLLACAYAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (107, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020311', 'HUASTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (108, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020313', 'MANGAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (109, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020315', 'PACLLON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (110, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020317', 'SAN MIGUEL DE CORPANQUI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (111, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020320', 'TICLLOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (112, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020321', 'ANTONIO RAIMONDI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (113, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020322', 'CANIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (114, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020323', 'COLQUIOC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (115, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020324', 'LA PRIMAVERA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (116, '02', 'DEPARTAMENTO ANCASH', '0203', 'BOLOGNESI', '020325', 'HUALLANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (117, '02', 'DEPARTAMENTO ANCASH', '0204', 'CARHUAZ', '020401', 'CARHUAZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (118, '02', 'DEPARTAMENTO ANCASH', '0204', 'CARHUAZ', '020402', 'ACOPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (119, '02', 'DEPARTAMENTO ANCASH', '0204', 'CARHUAZ', '020403', 'AMASHCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (120, '02', 'DEPARTAMENTO ANCASH', '0204', 'CARHUAZ', '020404', 'ANTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (121, '02', 'DEPARTAMENTO ANCASH', '0204', 'CARHUAZ', '020405', 'ATAQUERO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (122, '02', 'DEPARTAMENTO ANCASH', '0204', 'CARHUAZ', '020406', 'MARCARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (123, '02', 'DEPARTAMENTO ANCASH', '0204', 'CARHUAZ', '020407', 'PARIAHUANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (124, '02', 'DEPARTAMENTO ANCASH', '0204', 'CARHUAZ', '020408', 'SAN MIGUEL DE ACO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (125, '02', 'DEPARTAMENTO ANCASH', '0204', 'CARHUAZ', '020409', 'SHILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (126, '02', 'DEPARTAMENTO ANCASH', '0204', 'CARHUAZ', '020410', 'TINCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (127, '02', 'DEPARTAMENTO ANCASH', '0204', 'CARHUAZ', '020411', 'YUNGAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (128, '02', 'DEPARTAMENTO ANCASH', '0205', 'CASMA', '020501', 'CASMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (129, '02', 'DEPARTAMENTO ANCASH', '0205', 'CASMA', '020502', 'BUENA VISTA ALTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (130, '02', 'DEPARTAMENTO ANCASH', '0205', 'CASMA', '020503', 'COMANDANTE NOEL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (131, '02', 'DEPARTAMENTO ANCASH', '0205', 'CASMA', '020505', 'YAUTAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (132, '02', 'DEPARTAMENTO ANCASH', '0206', 'CORONGO', '020601', 'CORONGO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (133, '02', 'DEPARTAMENTO ANCASH', '0206', 'CORONGO', '020602', 'ACO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (134, '02', 'DEPARTAMENTO ANCASH', '0206', 'CORONGO', '020603', 'BAMBAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (135, '02', 'DEPARTAMENTO ANCASH', '0206', 'CORONGO', '020604', 'CUSCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (136, '02', 'DEPARTAMENTO ANCASH', '0206', 'CORONGO', '020605', 'LA PAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (137, '02', 'DEPARTAMENTO ANCASH', '0206', 'CORONGO', '020606', 'YANAC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (138, '02', 'DEPARTAMENTO ANCASH', '0206', 'CORONGO', '020607', 'YUPAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (139, '02', 'DEPARTAMENTO ANCASH', '0207', 'HUAYLAS', '020701', 'CARAZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (140, '02', 'DEPARTAMENTO ANCASH', '0207', 'HUAYLAS', '020702', 'HUALLANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (141, '02', 'DEPARTAMENTO ANCASH', '0207', 'HUAYLAS', '020703', 'HUATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (142, '02', 'DEPARTAMENTO ANCASH', '0207', 'HUAYLAS', '020704', 'HUAYLAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (143, '02', 'DEPARTAMENTO ANCASH', '0207', 'HUAYLAS', '020705', 'MATO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (144, '02', 'DEPARTAMENTO ANCASH', '0207', 'HUAYLAS', '020706', 'PAMPAROMAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (145, '02', 'DEPARTAMENTO ANCASH', '0207', 'HUAYLAS', '020707', 'PUEBLO LIBRE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (146, '02', 'DEPARTAMENTO ANCASH', '0207', 'HUAYLAS', '020708', 'SANTA CRUZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (147, '02', 'DEPARTAMENTO ANCASH', '0207', 'HUAYLAS', '020709', 'YURACMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (148, '02', 'DEPARTAMENTO ANCASH', '0207', 'HUAYLAS', '020710', 'SANTO TORIBIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (149, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020801', 'HUARI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (150, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020802', 'CAJAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (151, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020803', 'CHAVIN DE HUANTAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (152, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020804', 'HUACACHI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (153, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020805', 'HUACHIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (154, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020806', 'HUACCHIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (155, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020807', 'HUANTAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (156, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020808', 'MASIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (157, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020809', 'PAUCAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (158, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020810', 'PONTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (159, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020811', 'RAHUAPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (160, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020812', 'RAPAYAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (161, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020813', 'SAN MARCOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (162, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020814', 'SAN PEDRO DE CHANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (163, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020815', 'UCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (164, '02', 'DEPARTAMENTO ANCASH', '0208', 'HUARI', '020816', 'ANRA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (165, '02', 'DEPARTAMENTO ANCASH', '0209', 'MARISCAL LUZURIAGA', '020901', 'PISCOBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (166, '02', 'DEPARTAMENTO ANCASH', '0209', 'MARISCAL LUZURIAGA', '020902', 'CASCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (167, '02', 'DEPARTAMENTO ANCASH', '0209', 'MARISCAL LUZURIAGA', '020903', 'LUCMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (168, '02', 'DEPARTAMENTO ANCASH', '0209', 'MARISCAL LUZURIAGA', '020904', 'FIDEL OLIVAS ESCUDERO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (169, '02', 'DEPARTAMENTO ANCASH', '0209', 'MARISCAL LUZURIAGA', '020905', 'LLAMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (170, '02', 'DEPARTAMENTO ANCASH', '0209', 'MARISCAL LUZURIAGA', '020906', 'LLUMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (171, '02', 'DEPARTAMENTO ANCASH', '0209', 'MARISCAL LUZURIAGA', '020907', 'MUSGA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (172, '02', 'DEPARTAMENTO ANCASH', '0209', 'MARISCAL LUZURIAGA', '020908', 'ELEAZAR GUZMAN BARRON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (173, '02', 'DEPARTAMENTO ANCASH', '0210', 'PALLASCA', '021001', 'CABANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (174, '02', 'DEPARTAMENTO ANCASH', '0210', 'PALLASCA', '021002', 'BOLOGNESI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (175, '02', 'DEPARTAMENTO ANCASH', '0210', 'PALLASCA', '021003', 'CONCHUCOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (176, '02', 'DEPARTAMENTO ANCASH', '0210', 'PALLASCA', '021004', 'HUACASCHUQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (177, '02', 'DEPARTAMENTO ANCASH', '0210', 'PALLASCA', '021005', 'HUANDOVAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (178, '02', 'DEPARTAMENTO ANCASH', '0210', 'PALLASCA', '021006', 'LACABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (179, '02', 'DEPARTAMENTO ANCASH', '0210', 'PALLASCA', '021007', 'LLAPO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (180, '02', 'DEPARTAMENTO ANCASH', '0210', 'PALLASCA', '021008', 'PALLASCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (181, '02', 'DEPARTAMENTO ANCASH', '0210', 'PALLASCA', '021009', 'PAMPAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (182, '02', 'DEPARTAMENTO ANCASH', '0210', 'PALLASCA', '021010', 'SANTA ROSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (183, '02', 'DEPARTAMENTO ANCASH', '0210', 'PALLASCA', '021011', 'TAUCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (184, '02', 'DEPARTAMENTO ANCASH', '0211', 'POMABAMBA', '021101', 'POMABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (185, '02', 'DEPARTAMENTO ANCASH', '0211', 'POMABAMBA', '021102', 'HUAYLLAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (186, '02', 'DEPARTAMENTO ANCASH', '0211', 'POMABAMBA', '021103', 'PAROBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (187, '02', 'DEPARTAMENTO ANCASH', '0211', 'POMABAMBA', '021104', 'QUINUABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (188, '02', 'DEPARTAMENTO ANCASH', '0212', 'RECUAY', '021201', 'RECUAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (189, '02', 'DEPARTAMENTO ANCASH', '0212', 'RECUAY', '021202', 'COTAPARACO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (190, '02', 'DEPARTAMENTO ANCASH', '0212', 'RECUAY', '021203', 'HUAYLLAPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (191, '02', 'DEPARTAMENTO ANCASH', '0212', 'RECUAY', '021204', 'MARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (192, '02', 'DEPARTAMENTO ANCASH', '0212', 'RECUAY', '021205', 'PAMPAS CHICO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (193, '02', 'DEPARTAMENTO ANCASH', '0212', 'RECUAY', '021206', 'PARARIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (194, '02', 'DEPARTAMENTO ANCASH', '0212', 'RECUAY', '021207', 'TAPACOCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (195, '02', 'DEPARTAMENTO ANCASH', '0212', 'RECUAY', '021208', 'TICAPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (196, '02', 'DEPARTAMENTO ANCASH', '0212', 'RECUAY', '021209', 'LLACLLIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (197, '02', 'DEPARTAMENTO ANCASH', '0212', 'RECUAY', '021210', 'CATAC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (198, '02', 'DEPARTAMENTO ANCASH', '0213', 'SANTA', '021301', 'CHIMBOTE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (199, '02', 'DEPARTAMENTO ANCASH', '0213', 'SANTA', '021302', 'CACERES DEL PERU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (200, '02', 'DEPARTAMENTO ANCASH', '0213', 'SANTA', '021303', 'MACATE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (201, '02', 'DEPARTAMENTO ANCASH', '0213', 'SANTA', '021304', 'MORO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (202, '02', 'DEPARTAMENTO ANCASH', '0213', 'SANTA', '021305', 'NEPENA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (203, '02', 'DEPARTAMENTO ANCASH', '0213', 'SANTA', '021306', 'SAMANCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (204, '02', 'DEPARTAMENTO ANCASH', '0213', 'SANTA', '021307', 'SANTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (205, '02', 'DEPARTAMENTO ANCASH', '0213', 'SANTA', '021308', 'COISHCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (206, '02', 'DEPARTAMENTO ANCASH', '0213', 'SANTA', '021309', 'NUEVO CHIMBOTE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (207, '02', 'DEPARTAMENTO ANCASH', '0214', 'SIHUAS', '021401', 'SIHUAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (208, '02', 'DEPARTAMENTO ANCASH', '0214', 'SIHUAS', '021402', 'ALFONSO UGARTE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (209, '02', 'DEPARTAMENTO ANCASH', '0214', 'SIHUAS', '021403', 'CHINGALPO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (210, '02', 'DEPARTAMENTO ANCASH', '0214', 'SIHUAS', '021404', 'HUAYLLABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (211, '02', 'DEPARTAMENTO ANCASH', '0214', 'SIHUAS', '021405', 'QUICHES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (212, '02', 'DEPARTAMENTO ANCASH', '0214', 'SIHUAS', '021406', 'SICSIBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (213, '02', 'DEPARTAMENTO ANCASH', '0214', 'SIHUAS', '021407', 'ACOBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (214, '02', 'DEPARTAMENTO ANCASH', '0214', 'SIHUAS', '021408', 'CASHAPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (215, '02', 'DEPARTAMENTO ANCASH', '0214', 'SIHUAS', '021409', 'RAGASH')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (216, '02', 'DEPARTAMENTO ANCASH', '0214', 'SIHUAS', '021410', 'SAN JUAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (217, '02', 'DEPARTAMENTO ANCASH', '0215', 'YUNGAY', '021501', 'YUNGAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (218, '02', 'DEPARTAMENTO ANCASH', '0215', 'YUNGAY', '021502', 'CASCAPARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (219, '02', 'DEPARTAMENTO ANCASH', '0215', 'YUNGAY', '021503', 'MANCOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (220, '02', 'DEPARTAMENTO ANCASH', '0215', 'YUNGAY', '021504', 'MATACOTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (221, '02', 'DEPARTAMENTO ANCASH', '0215', 'YUNGAY', '021505', 'QUILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (222, '02', 'DEPARTAMENTO ANCASH', '0215', 'YUNGAY', '021506', 'RANRAHIRCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (223, '02', 'DEPARTAMENTO ANCASH', '0215', 'YUNGAY', '021507', 'SHUPLUY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (224, '02', 'DEPARTAMENTO ANCASH', '0215', 'YUNGAY', '021508', 'YANAMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (225, '02', 'DEPARTAMENTO ANCASH', '0216', 'ANTONIO RAIMONDI', '021601', 'LLAMELLIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (226, '02', 'DEPARTAMENTO ANCASH', '0216', 'ANTONIO RAIMONDI', '021602', 'ACZO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (227, '02', 'DEPARTAMENTO ANCASH', '0216', 'ANTONIO RAIMONDI', '021603', 'CHACCHO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (228, '02', 'DEPARTAMENTO ANCASH', '0216', 'ANTONIO RAIMONDI', '021604', 'CHINGAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (229, '02', 'DEPARTAMENTO ANCASH', '0216', 'ANTONIO RAIMONDI', '021605', 'MIRGAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (230, '02', 'DEPARTAMENTO ANCASH', '0216', 'ANTONIO RAIMONDI', '021606', 'SAN JUAN DE RONTOY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (231, '02', 'DEPARTAMENTO ANCASH', '0217', 'CARLOS FERMIN FITZCARRALD', '021701', 'SAN LUIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (232, '02', 'DEPARTAMENTO ANCASH', '0217', 'CARLOS FERMIN FITZCARRALD', '021702', 'YAUYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (233, '02', 'DEPARTAMENTO ANCASH', '0217', 'CARLOS FERMIN FITZCARRALD', '021703', 'SAN NICOLAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (234, '02', 'DEPARTAMENTO ANCASH', '0218', 'ASUNCION', '021801', 'CHACAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (235, '02', 'DEPARTAMENTO ANCASH', '0218', 'ASUNCION', '021802', 'ACOCHACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (236, '02', 'DEPARTAMENTO ANCASH', '0219', 'HUARMEY', '021901', 'HUARMEY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (237, '02', 'DEPARTAMENTO ANCASH', '0219', 'HUARMEY', '021902', 'COCHAPETI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (238, '02', 'DEPARTAMENTO ANCASH', '0219', 'HUARMEY', '021903', 'HUAYAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (239, '02', 'DEPARTAMENTO ANCASH', '0219', 'HUARMEY', '021904', 'MALVAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (240, '02', 'DEPARTAMENTO ANCASH', '0219', 'HUARMEY', '021905', 'CULEBRAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (241, '02', 'DEPARTAMENTO ANCASH', '0220', 'OCROS', '022001', 'ACAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (242, '02', 'DEPARTAMENTO ANCASH', '0220', 'OCROS', '022002', 'CAJAMARQUILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (243, '02', 'DEPARTAMENTO ANCASH', '0220', 'OCROS', '022003', 'CARHUAPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (244, '02', 'DEPARTAMENTO ANCASH', '0220', 'OCROS', '022004', 'COCHAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (245, '02', 'DEPARTAMENTO ANCASH', '0220', 'OCROS', '022005', 'CONGAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (246, '02', 'DEPARTAMENTO ANCASH', '0220', 'OCROS', '022006', 'LLIPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (247, '02', 'DEPARTAMENTO ANCASH', '0220', 'OCROS', '022007', 'OCROS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (248, '02', 'DEPARTAMENTO ANCASH', '0220', 'OCROS', '022008', 'SAN CRISTOBAL DE RAJAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (249, '02', 'DEPARTAMENTO ANCASH', '0220', 'OCROS', '022009', 'SAN PEDRO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (250, '02', 'DEPARTAMENTO ANCASH', '0220', 'OCROS', '022010', 'SANTIAGO DE CHILCAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (251, '03', 'DEPARTAMENTO APURIMAC', '0301', 'ABANCAY', '030101', 'ABANCAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (252, '03', 'DEPARTAMENTO APURIMAC', '0301', 'ABANCAY', '030102', 'CIRCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (253, '03', 'DEPARTAMENTO APURIMAC', '0301', 'ABANCAY', '030103', 'CURAHUASI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (254, '03', 'DEPARTAMENTO APURIMAC', '0301', 'ABANCAY', '030104', 'CHACOCHE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (255, '03', 'DEPARTAMENTO APURIMAC', '0301', 'ABANCAY', '030105', 'HUANIPACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (256, '03', 'DEPARTAMENTO APURIMAC', '0301', 'ABANCAY', '030106', 'LAMBRAMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (257, '03', 'DEPARTAMENTO APURIMAC', '0301', 'ABANCAY', '030107', 'PICHIRHUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (258, '03', 'DEPARTAMENTO APURIMAC', '0301', 'ABANCAY', '030108', 'SAN PEDRO DE CACHORA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (259, '03', 'DEPARTAMENTO APURIMAC', '0301', 'ABANCAY', '030109', 'TAMBURCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (260, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030201', 'CHALHUANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (261, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030202', 'CAPAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (262, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030203', 'CARAYBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (263, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030204', 'COLCABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (264, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030205', 'COTARUSE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (265, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030206', 'CHAPIMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (266, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030207', 'IHUAYLLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (267, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030208', 'LUCRE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (268, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030209', 'POCOHUANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (269, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030210', 'SANAICA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (270, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030211', 'SORAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (271, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030212', 'TAPAIRIHUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (272, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030213', 'TINTAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (273, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030214', 'TORAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (274, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030215', 'YANACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (275, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030216', 'SAN JUAN DE CHACNA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (276, '03', 'DEPARTAMENTO APURIMAC', '0302', 'AYMARAES', '030217', 'JUSTO APU SAHUARAURA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (277, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030301', 'ANDAHUAYLAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (278, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030302', 'ANDARAPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (279, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030303', 'CHIARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (280, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030304', 'HUANCARAMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (281, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030305', 'HUANCARAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (282, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030306', 'KISHUARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (283, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030307', 'PACOBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (284, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030308', 'PAMPACHIRI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (285, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030309', 'SAN ANTONIO DE CACHI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (286, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030310', 'SAN JERONIMO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (287, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030311', 'TALAVERA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (288, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030312', 'TURPO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (289, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030313', 'PACUCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (290, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030314', 'POMACOCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (291, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030315', 'STA MARIA DE CHICMO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (292, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030316', 'TUMAY HUARACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (293, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030317', 'HUAYANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (294, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030318', 'SAN MIGUEL DE CHACCRAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (295, '03', 'DEPARTAMENTO APURIMAC', '0303', 'ANDAHUAYLAS', '030319', 'KAQUIABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (296, '03', 'DEPARTAMENTO APURIMAC', '0304', 'ANTABAMBA', '030401', 'ANTABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (297, '03', 'DEPARTAMENTO APURIMAC', '0304', 'ANTABAMBA', '030402', 'EL ORO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (298, '03', 'DEPARTAMENTO APURIMAC', '0304', 'ANTABAMBA', '030403', 'HUAQUIRCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (299, '03', 'DEPARTAMENTO APURIMAC', '0304', 'ANTABAMBA', '030404', 'JUAN ESPINOZA MEDRANO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (300, '03', 'DEPARTAMENTO APURIMAC', '0304', 'ANTABAMBA', '030405', 'OROPESA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (301, '03', 'DEPARTAMENTO APURIMAC', '0304', 'ANTABAMBA', '030406', 'PACHACONAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (302, '03', 'DEPARTAMENTO APURIMAC', '0304', 'ANTABAMBA', '030407', 'SABAINO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (303, '03', 'DEPARTAMENTO APURIMAC', '0305', 'COTABAMBAS', '030501', 'TAMBOBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (304, '03', 'DEPARTAMENTO APURIMAC', '0305', 'COTABAMBAS', '030502', 'COYLLURQUI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (305, '03', 'DEPARTAMENTO APURIMAC', '0305', 'COTABAMBAS', '030503', 'COTABAMBAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (306, '03', 'DEPARTAMENTO APURIMAC', '0305', 'COTABAMBAS', '030504', 'HAQUIRA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (307, '03', 'DEPARTAMENTO APURIMAC', '0305', 'COTABAMBAS', '030505', 'MARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (308, '03', 'DEPARTAMENTO APURIMAC', '0305', 'COTABAMBAS', '030506', 'CHALLHUAHUACHO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (309, '03', 'DEPARTAMENTO APURIMAC', '0306', 'GRAU', '030601', 'CHUQUIBAMBILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (310, '03', 'DEPARTAMENTO APURIMAC', '0306', 'GRAU', '030602', 'CURPAHUASI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (311, '03', 'DEPARTAMENTO APURIMAC', '0306', 'GRAU', '030603', 'HUAILLATI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (312, '03', 'DEPARTAMENTO APURIMAC', '0306', 'GRAU', '030604', 'MAMARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (313, '03', 'DEPARTAMENTO APURIMAC', '0306', 'GRAU', '030605', 'MARISCAL GAMARRA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (314, '03', 'DEPARTAMENTO APURIMAC', '0306', 'GRAU', '030606', 'MICAELA BASTIDAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (315, '03', 'DEPARTAMENTO APURIMAC', '0306', 'GRAU', '030607', 'PROGRESO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (316, '03', 'DEPARTAMENTO APURIMAC', '0306', 'GRAU', '030608', 'PATAYPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (317, '03', 'DEPARTAMENTO APURIMAC', '0306', 'GRAU', '030609', 'SAN ANTONIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (318, '03', 'DEPARTAMENTO APURIMAC', '0306', 'GRAU', '030610', 'TURPAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (319, '03', 'DEPARTAMENTO APURIMAC', '0306', 'GRAU', '030611', 'VILCABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (320, '03', 'DEPARTAMENTO APURIMAC', '0306', 'GRAU', '030612', 'VIRUNDO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (321, '03', 'DEPARTAMENTO APURIMAC', '0306', 'GRAU', '030613', 'SANTA ROSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (322, '03', 'DEPARTAMENTO APURIMAC', '0306', 'GRAU', '030614', 'CURASCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (323, '03', 'DEPARTAMENTO APURIMAC', '0307', 'CHINCHEROS', '030701', 'CHINCHEROS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (324, '03', 'DEPARTAMENTO APURIMAC', '0307', 'CHINCHEROS', '030702', 'ONGOY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (325, '03', 'DEPARTAMENTO APURIMAC', '0307', 'CHINCHEROS', '030703', 'OCOBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (326, '03', 'DEPARTAMENTO APURIMAC', '0307', 'CHINCHEROS', '030704', 'COCHARCAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (327, '03', 'DEPARTAMENTO APURIMAC', '0307', 'CHINCHEROS', '030705', 'ANCO HUALLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (328, '03', 'DEPARTAMENTO APURIMAC', '0307', 'CHINCHEROS', '030706', 'HUACCANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (329, '03', 'DEPARTAMENTO APURIMAC', '0307', 'CHINCHEROS', '030707', 'URANMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (330, '03', 'DEPARTAMENTO APURIMAC', '0307', 'CHINCHEROS', '030708', 'RANRACANCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (331, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040101', 'AREQUIPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (332, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040102', 'CAYMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (333, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040103', 'CERRO COLORADO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (334, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040104', 'CHARACATO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (335, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040105', 'CHIGUATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (336, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040106', 'LA JOYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (337, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040107', 'MIRAFLORES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (338, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040108', 'MOLLEBAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (339, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040109', 'PAUCARPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (340, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040110', 'POCSI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (341, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040111', 'POLOBAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (342, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040112', 'QUEQUENA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (343, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040113', 'SABANDIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (344, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040114', 'SACHACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (345, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040115', 'SAN JUAN DE SIGUAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (346, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040116', 'SAN JUAN DE TARUCANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (347, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040117', 'SANTA ISABEL DE SIGUAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (348, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040118', 'STA RITA DE SIGUAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (349, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040119', 'SOCABAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (350, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040120', 'TIABAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (351, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040121', 'UCHUMAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (352, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040122', 'VITOR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (353, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040123', 'YANAHUARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (354, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040124', 'YARABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (355, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040125', 'YURA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (356, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040126', 'MARIANO MELGAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (357, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040127', 'JACOBO HUNTER')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (358, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040128', 'ALTO SELVA ALEGRE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (359, '04', 'DEPARTAMENTO AREQUIPA', '0401', 'AREQUIPA', '040129', 'JOSE LUIS BUSTAMANTE Y RIVERO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (360, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040201', 'CHIVAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (361, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040202', 'ACHOMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (362, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040203', 'CABANACONDE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (363, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040204', 'CAYLLOMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (364, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040205', 'CALLALLI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (365, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040206', 'COPORAQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (366, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040207', 'HUAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (367, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040208', 'HUANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (368, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040209', 'ICHUPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (369, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040210', 'LARI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (370, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040211', 'LLUTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (371, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040212', 'MACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (372, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040213', 'MADRIGAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (373, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040214', 'SAN ANTONIO DE CHUCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (374, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040215', 'SIBAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (375, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040216', 'TAPAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (376, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040217', 'TISCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (377, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040218', 'TUTI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (378, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040219', 'YANQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (379, '04', 'DEPARTAMENTO AREQUIPA', '0402', 'CAYLLOMA', '040220', 'MAJES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (380, '04', 'DEPARTAMENTO AREQUIPA', '0403', 'CAMANA', '040301', 'CAMANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (381, '04', 'DEPARTAMENTO AREQUIPA', '0403', 'CAMANA', '040302', 'JOSE MARIA QUIMPER')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (382, '04', 'DEPARTAMENTO AREQUIPA', '0403', 'CAMANA', '040303', 'MARIANO N VALCARCEL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (383, '04', 'DEPARTAMENTO AREQUIPA', '0403', 'CAMANA', '040304', 'MARISCAL CACERES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (384, '04', 'DEPARTAMENTO AREQUIPA', '0403', 'CAMANA', '040305', 'NICOLAS DE PIEROLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (385, '04', 'DEPARTAMENTO AREQUIPA', '0403', 'CAMANA', '040306', 'OCONA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (386, '04', 'DEPARTAMENTO AREQUIPA', '0403', 'CAMANA', '040307', 'QUILCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (387, '04', 'DEPARTAMENTO AREQUIPA', '0403', 'CAMANA', '040308', 'SAMUEL PASTOR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (388, '04', 'DEPARTAMENTO AREQUIPA', '0404', 'CARAVELI', '040401', 'CARAVELI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (389, '04', 'DEPARTAMENTO AREQUIPA', '0404', 'CARAVELI', '040402', 'ACARI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (390, '04', 'DEPARTAMENTO AREQUIPA', '0404', 'CARAVELI', '040403', 'ATICO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (391, '04', 'DEPARTAMENTO AREQUIPA', '0404', 'CARAVELI', '040404', 'ATIQUIPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (392, '04', 'DEPARTAMENTO AREQUIPA', '0404', 'CARAVELI', '040405', 'BELLA UNION')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (393, '04', 'DEPARTAMENTO AREQUIPA', '0404', 'CARAVELI', '040406', 'CAHUACHO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (394, '04', 'DEPARTAMENTO AREQUIPA', '0404', 'CARAVELI', '040407', 'CHALA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (395, '04', 'DEPARTAMENTO AREQUIPA', '0404', 'CARAVELI', '040408', 'CHAPARRA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (396, '04', 'DEPARTAMENTO AREQUIPA', '0404', 'CARAVELI', '040409', 'HUANUHUANU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (397, '04', 'DEPARTAMENTO AREQUIPA', '0404', 'CARAVELI', '040410', 'JAQUI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (398, '04', 'DEPARTAMENTO AREQUIPA', '0404', 'CARAVELI', '040411', 'LOMAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (399, '04', 'DEPARTAMENTO AREQUIPA', '0404', 'CARAVELI', '040412', 'QUICACHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (400, '04', 'DEPARTAMENTO AREQUIPA', '0404', 'CARAVELI', '040413', 'YAUCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (401, '04', 'DEPARTAMENTO AREQUIPA', '0405', 'CASTILLA', '040501', 'APLAO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (402, '04', 'DEPARTAMENTO AREQUIPA', '0405', 'CASTILLA', '040502', 'ANDAGUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (403, '04', 'DEPARTAMENTO AREQUIPA', '0405', 'CASTILLA', '040503', 'AYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (404, '04', 'DEPARTAMENTO AREQUIPA', '0405', 'CASTILLA', '040504', 'CHACHAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (405, '04', 'DEPARTAMENTO AREQUIPA', '0405', 'CASTILLA', '040505', 'CHILCAYMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (406, '04', 'DEPARTAMENTO AREQUIPA', '0405', 'CASTILLA', '040506', 'CHOCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (407, '04', 'DEPARTAMENTO AREQUIPA', '0405', 'CASTILLA', '040507', 'HUANCARQUI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (408, '04', 'DEPARTAMENTO AREQUIPA', '0405', 'CASTILLA', '040508', 'MACHAGUAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (409, '04', 'DEPARTAMENTO AREQUIPA', '0405', 'CASTILLA', '040509', 'ORCOPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (410, '04', 'DEPARTAMENTO AREQUIPA', '0405', 'CASTILLA', '040510', 'PAMPACOLCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (411, '04', 'DEPARTAMENTO AREQUIPA', '0405', 'CASTILLA', '040511', 'TIPAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (412, '04', 'DEPARTAMENTO AREQUIPA', '0405', 'CASTILLA', '040512', 'URACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (413, '04', 'DEPARTAMENTO AREQUIPA', '0405', 'CASTILLA', '040513', 'UNON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (414, '04', 'DEPARTAMENTO AREQUIPA', '0405', 'CASTILLA', '040514', 'VIRACO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (415, '04', 'DEPARTAMENTO AREQUIPA', '0406', 'CONDESUYOS', '040601', 'CHUQUIBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (416, '04', 'DEPARTAMENTO AREQUIPA', '0406', 'CONDESUYOS', '040602', 'ANDARAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (417, '04', 'DEPARTAMENTO AREQUIPA', '0406', 'CONDESUYOS', '040603', 'CAYARANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (418, '04', 'DEPARTAMENTO AREQUIPA', '0406', 'CONDESUYOS', '040604', 'CHICHAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (419, '04', 'DEPARTAMENTO AREQUIPA', '0406', 'CONDESUYOS', '040605', 'IRAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (420, '04', 'DEPARTAMENTO AREQUIPA', '0406', 'CONDESUYOS', '040606', 'SALAMANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (421, '04', 'DEPARTAMENTO AREQUIPA', '0406', 'CONDESUYOS', '040607', 'YANAQUIHUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (422, '04', 'DEPARTAMENTO AREQUIPA', '0406', 'CONDESUYOS', '040608', 'RIO GRANDE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (423, '04', 'DEPARTAMENTO AREQUIPA', '0407', 'ISLAY', '040701', 'MOLLENDO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (424, '04', 'DEPARTAMENTO AREQUIPA', '0407', 'ISLAY', '040702', 'COCACHACRA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (425, '04', 'DEPARTAMENTO AREQUIPA', '0407', 'ISLAY', '040703', 'DEAN VALDIVIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (426, '04', 'DEPARTAMENTO AREQUIPA', '0407', 'ISLAY', '040704', 'ISLAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (427, '04', 'DEPARTAMENTO AREQUIPA', '0407', 'ISLAY', '040705', 'MEJIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (428, '04', 'DEPARTAMENTO AREQUIPA', '0407', 'ISLAY', '040706', 'PUNTA DE BOMBON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (429, '04', 'DEPARTAMENTO AREQUIPA', '0408', 'LA UNION', '040801', 'COTAHUASI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (430, '04', 'DEPARTAMENTO AREQUIPA', '0408', 'LA UNION', '040802', 'ALCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (431, '04', 'DEPARTAMENTO AREQUIPA', '0408', 'LA UNION', '040803', 'CHARCANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (432, '04', 'DEPARTAMENTO AREQUIPA', '0408', 'LA UNION', '040804', 'HUAYNACOTAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (433, '04', 'DEPARTAMENTO AREQUIPA', '0408', 'LA UNION', '040805', 'PAMPAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (434, '04', 'DEPARTAMENTO AREQUIPA', '0408', 'LA UNION', '040806', 'PUYCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (435, '04', 'DEPARTAMENTO AREQUIPA', '0408', 'LA UNION', '040807', 'QUECHUALLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (436, '04', 'DEPARTAMENTO AREQUIPA', '0408', 'LA UNION', '040808', 'SAYLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (437, '04', 'DEPARTAMENTO AREQUIPA', '0408', 'LA UNION', '040809', 'TAURIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (438, '04', 'DEPARTAMENTO AREQUIPA', '0408', 'LA UNION', '040810', 'TOMEPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (439, '04', 'DEPARTAMENTO AREQUIPA', '0408', 'LA UNION', '040811', 'TORO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (440, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050101', 'AYACUCHO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (441, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050102', 'ACOS VINCHOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (442, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050103', 'CARMEN ALTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (443, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050104', 'CHIARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (444, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050105', 'QUINUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (445, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050106', 'SAN JOSE DE TICLLAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (446, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050107', 'SAN JUAN BAUTISTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (447, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050108', 'SANTIAGO DE PISCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (448, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050109', 'VINCHOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (449, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050110', 'TAMBILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (450, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050111', 'ACOCRO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (451, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050112', 'SOCOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (452, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050113', 'OCROS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (453, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050114', 'PACAYCASA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (454, '05', 'DEPARTAMENTO AYACUCHO', '0501', 'HUAMANGA', '050115', 'JESUS NAZARENO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (455, '05', 'DEPARTAMENTO AYACUCHO', '0502', 'CANGALLO', '050201', 'CANGALLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (456, '05', 'DEPARTAMENTO AYACUCHO', '0502', 'CANGALLO', '050204', 'CHUSCHI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (457, '05', 'DEPARTAMENTO AYACUCHO', '0502', 'CANGALLO', '050206', 'LOS MOROCHUCOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (458, '05', 'DEPARTAMENTO AYACUCHO', '0502', 'CANGALLO', '050207', 'PARAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (459, '05', 'DEPARTAMENTO AYACUCHO', '0502', 'CANGALLO', '050208', 'TOTOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (460, '05', 'DEPARTAMENTO AYACUCHO', '0502', 'CANGALLO', '050211', 'MARIA PARADO DE BELLIDO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (461, '05', 'DEPARTAMENTO AYACUCHO', '0503', 'HUANTA', '050301', 'HUANTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (462, '05', 'DEPARTAMENTO AYACUCHO', '0503', 'HUANTA', '050302', 'AYAHUANCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (463, '05', 'DEPARTAMENTO AYACUCHO', '0503', 'HUANTA', '050303', 'HUAMANGUILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (464, '05', 'DEPARTAMENTO AYACUCHO', '0503', 'HUANTA', '050304', 'IGUAIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (465, '05', 'DEPARTAMENTO AYACUCHO', '0503', 'HUANTA', '050305', 'LURICOCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (466, '05', 'DEPARTAMENTO AYACUCHO', '0503', 'HUANTA', '050307', 'SANTILLANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (467, '05', 'DEPARTAMENTO AYACUCHO', '0503', 'HUANTA', '050308', 'SIVIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (468, '05', 'DEPARTAMENTO AYACUCHO', '0503', 'HUANTA', '050309', 'LLOCHEGUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (469, '05', 'DEPARTAMENTO AYACUCHO', '0504', 'LA MAR', '050401', 'SAN MIGUEL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (470, '05', 'DEPARTAMENTO AYACUCHO', '0504', 'LA MAR', '050402', 'ANCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (471, '05', 'DEPARTAMENTO AYACUCHO', '0504', 'LA MAR', '050403', 'AYNA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (472, '05', 'DEPARTAMENTO AYACUCHO', '0504', 'LA MAR', '050404', 'CHILCAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (473, '05', 'DEPARTAMENTO AYACUCHO', '0504', 'LA MAR', '050405', 'CHUNGUI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (474, '05', 'DEPARTAMENTO AYACUCHO', '0504', 'LA MAR', '050406', 'TAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (475, '05', 'DEPARTAMENTO AYACUCHO', '0504', 'LA MAR', '050407', 'LUIS CARRANZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (476, '05', 'DEPARTAMENTO AYACUCHO', '0504', 'LA MAR', '050408', 'SANTA ROSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (477, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050501', 'PUQUIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (478, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050502', 'AUCARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (479, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050503', 'CABANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (480, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050504', 'CARMEN SALCEDO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (481, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050506', 'CHAVINA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (482, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050508', 'CHIPAO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (483, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050510', 'HUAC-HUAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (484, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050511', 'LARAMATE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (485, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050512', 'LEONCIO PRADO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (486, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050513', 'LUCANAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (487, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050514', 'LLAUTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (488, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050516', 'OCANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (489, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050517', 'OTOCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (490, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050520', 'SANCOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (491, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050521', 'SAN JUAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (492, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050522', 'SAN PEDRO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (493, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050524', 'STA ANA DE HUAYCAHUACHO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (494, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050525', 'SANTA LUCIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (495, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050529', 'SAISA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (496, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050531', 'SAN PEDRO DE PALCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (497, '05', 'DEPARTAMENTO AYACUCHO', '0505', 'LUCANAS', '050532', 'SAN CRISTOBAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (498, '05', 'DEPARTAMENTO AYACUCHO', '0506', 'PARINACOCHAS', '050601', 'CORACORA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (499, '05', 'DEPARTAMENTO AYACUCHO', '0506', 'PARINACOCHAS', '050604', 'CORONEL CASTANEDA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (500, '05', 'DEPARTAMENTO AYACUCHO', '0506', 'PARINACOCHAS', '050605', 'CHUMPI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (501, '05', 'DEPARTAMENTO AYACUCHO', '0506', 'PARINACOCHAS', '050608', 'PACAPAUSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (502, '05', 'DEPARTAMENTO AYACUCHO', '0506', 'PARINACOCHAS', '050611', 'PULLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (503, '05', 'DEPARTAMENTO AYACUCHO', '0506', 'PARINACOCHAS', '050612', 'PUYUSCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (504, '05', 'DEPARTAMENTO AYACUCHO', '0506', 'PARINACOCHAS', '050615', 'SAN FCO DE RAVACAYCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (505, '05', 'DEPARTAMENTO AYACUCHO', '0506', 'PARINACOCHAS', '050616', 'UPAHUACHO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (506, '05', 'DEPARTAMENTO AYACUCHO', '0507', 'VICTOR FAJARDO', '050701', 'HUANCAPI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (507, '05', 'DEPARTAMENTO AYACUCHO', '0507', 'VICTOR FAJARDO', '050702', 'ALCAMENCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (508, '05', 'DEPARTAMENTO AYACUCHO', '0507', 'VICTOR FAJARDO', '050703', 'APONGO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (509, '05', 'DEPARTAMENTO AYACUCHO', '0507', 'VICTOR FAJARDO', '050704', 'CANARIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (510, '05', 'DEPARTAMENTO AYACUCHO', '0507', 'VICTOR FAJARDO', '050706', 'CAYARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (511, '05', 'DEPARTAMENTO AYACUCHO', '0507', 'VICTOR FAJARDO', '050707', 'COLCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (512, '05', 'DEPARTAMENTO AYACUCHO', '0507', 'VICTOR FAJARDO', '050708', 'HUAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (513, '05', 'DEPARTAMENTO AYACUCHO', '0507', 'VICTOR FAJARDO', '050709', 'HUAMANQUIQUIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (514, '05', 'DEPARTAMENTO AYACUCHO', '0507', 'VICTOR FAJARDO', '050710', 'HUANCARAYLLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (515, '05', 'DEPARTAMENTO AYACUCHO', '0507', 'VICTOR FAJARDO', '050713', 'SARHUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (516, '05', 'DEPARTAMENTO AYACUCHO', '0507', 'VICTOR FAJARDO', '050714', 'VILCANCHOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (517, '05', 'DEPARTAMENTO AYACUCHO', '0507', 'VICTOR FAJARDO', '050715', 'ASQUIPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (518, '05', 'DEPARTAMENTO AYACUCHO', '0508', 'HUANCA SANCOS', '050801', 'SANCOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (519, '05', 'DEPARTAMENTO AYACUCHO', '0508', 'HUANCA SANCOS', '050802', 'SACSAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (520, '05', 'DEPARTAMENTO AYACUCHO', '0508', 'HUANCA SANCOS', '050803', 'SANTIAGO DE LUCANAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (521, '05', 'DEPARTAMENTO AYACUCHO', '0508', 'HUANCA SANCOS', '050804', 'CARAPO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (522, '05', 'DEPARTAMENTO AYACUCHO', '0509', 'VILCAS HUAMAN', '050901', 'VILCAS HUAMAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (523, '05', 'DEPARTAMENTO AYACUCHO', '0509', 'VILCAS HUAMAN', '050902', 'VISCHONGO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (524, '05', 'DEPARTAMENTO AYACUCHO', '0509', 'VILCAS HUAMAN', '050903', 'ACCOMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (525, '05', 'DEPARTAMENTO AYACUCHO', '0509', 'VILCAS HUAMAN', '050904', 'CARHUANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (526, '05', 'DEPARTAMENTO AYACUCHO', '0509', 'VILCAS HUAMAN', '050905', 'CONCEPCION')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (527, '05', 'DEPARTAMENTO AYACUCHO', '0509', 'VILCAS HUAMAN', '050906', 'HUAMBALPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (528, '05', 'DEPARTAMENTO AYACUCHO', '0509', 'VILCAS HUAMAN', '050907', 'SAURAMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (529, '05', 'DEPARTAMENTO AYACUCHO', '0509', 'VILCAS HUAMAN', '050908', 'INDEPENDENCIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (530, '05', 'DEPARTAMENTO AYACUCHO', '0510', 'PAUCAR DEL SARA SARA', '051001', 'PAUSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (531, '05', 'DEPARTAMENTO AYACUCHO', '0510', 'PAUCAR DEL SARA SARA', '051002', 'COLTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (532, '05', 'DEPARTAMENTO AYACUCHO', '0510', 'PAUCAR DEL SARA SARA', '051003', 'CORCULLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (533, '05', 'DEPARTAMENTO AYACUCHO', '0510', 'PAUCAR DEL SARA SARA', '051004', 'LAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (534, '05', 'DEPARTAMENTO AYACUCHO', '0510', 'PAUCAR DEL SARA SARA', '051005', 'MARCABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (535, '05', 'DEPARTAMENTO AYACUCHO', '0510', 'PAUCAR DEL SARA SARA', '051006', 'OYOLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (536, '05', 'DEPARTAMENTO AYACUCHO', '0510', 'PAUCAR DEL SARA SARA', '051007', 'PARARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (537, '05', 'DEPARTAMENTO AYACUCHO', '0510', 'PAUCAR DEL SARA SARA', '051008', 'SAN JAVIER DE ALPABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (538, '05', 'DEPARTAMENTO AYACUCHO', '0510', 'PAUCAR DEL SARA SARA', '051009', 'SAN JOSE DE USHUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (539, '05', 'DEPARTAMENTO AYACUCHO', '0510', 'PAUCAR DEL SARA SARA', '051010', 'SARA SARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (540, '05', 'DEPARTAMENTO AYACUCHO', '0511', 'SUCRE', '051101', 'QUEROBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (541, '05', 'DEPARTAMENTO AYACUCHO', '0511', 'SUCRE', '051102', 'BELEN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (542, '05', 'DEPARTAMENTO AYACUCHO', '0511', 'SUCRE', '051103', 'CHALCOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (543, '05', 'DEPARTAMENTO AYACUCHO', '0511', 'SUCRE', '051104', 'SAN SALVADOR DE QUIJE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (544, '05', 'DEPARTAMENTO AYACUCHO', '0511', 'SUCRE', '051105', 'PAICO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (545, '05', 'DEPARTAMENTO AYACUCHO', '0511', 'SUCRE', '051106', 'SANTIAGO DE PAUCARAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (546, '05', 'DEPARTAMENTO AYACUCHO', '0511', 'SUCRE', '051107', 'SAN PEDRO DE LARCAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (547, '05', 'DEPARTAMENTO AYACUCHO', '0511', 'SUCRE', '051108', 'SORAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (548, '05', 'DEPARTAMENTO AYACUCHO', '0511', 'SUCRE', '051109', 'HUACANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (549, '05', 'DEPARTAMENTO AYACUCHO', '0511', 'SUCRE', '051110', 'CHILCAYOC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (550, '05', 'DEPARTAMENTO AYACUCHO', '0511', 'SUCRE', '051111', 'MORCOLLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (551, '06', 'DEPARTAMENTO CAJAMARCA', '0601', 'CAJAMARCA', '060101', 'CAJAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (552, '06', 'DEPARTAMENTO CAJAMARCA', '0601', 'CAJAMARCA', '060102', 'ASUNCION')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (553, '06', 'DEPARTAMENTO CAJAMARCA', '0601', 'CAJAMARCA', '060103', 'COSPAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (554, '06', 'DEPARTAMENTO CAJAMARCA', '0601', 'CAJAMARCA', '060104', 'CHETILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (555, '06', 'DEPARTAMENTO CAJAMARCA', '0601', 'CAJAMARCA', '060105', 'ENCANADA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (556, '06', 'DEPARTAMENTO CAJAMARCA', '0601', 'CAJAMARCA', '060106', 'JESUS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (557, '06', 'DEPARTAMENTO CAJAMARCA', '0601', 'CAJAMARCA', '060107', 'LOS BANOS DEL INCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (558, '06', 'DEPARTAMENTO CAJAMARCA', '0601', 'CAJAMARCA', '060108', 'LLACANORA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (559, '06', 'DEPARTAMENTO CAJAMARCA', '0601', 'CAJAMARCA', '060109', 'MAGDALENA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (560, '06', 'DEPARTAMENTO CAJAMARCA', '0601', 'CAJAMARCA', '060110', 'MATARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (561, '06', 'DEPARTAMENTO CAJAMARCA', '0601', 'CAJAMARCA', '060111', 'NAMORA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (562, '06', 'DEPARTAMENTO CAJAMARCA', '0601', 'CAJAMARCA', '060112', 'SAN JUAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (563, '06', 'DEPARTAMENTO CAJAMARCA', '0602', 'CAJABAMBA', '060201', 'CAJABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (564, '06', 'DEPARTAMENTO CAJAMARCA', '0602', 'CAJABAMBA', '060202', 'CACHACHI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (565, '06', 'DEPARTAMENTO CAJAMARCA', '0602', 'CAJABAMBA', '060203', 'CONDEBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (566, '06', 'DEPARTAMENTO CAJAMARCA', '0602', 'CAJABAMBA', '060205', 'SITACOCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (567, '06', 'DEPARTAMENTO CAJAMARCA', '0603', 'CELENDIN', '060301', 'CELENDIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (568, '06', 'DEPARTAMENTO CAJAMARCA', '0603', 'CELENDIN', '060302', 'CORTEGANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (569, '06', 'DEPARTAMENTO CAJAMARCA', '0603', 'CELENDIN', '060303', 'CHUMUCH')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (570, '06', 'DEPARTAMENTO CAJAMARCA', '0603', 'CELENDIN', '060304', 'HUASMIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (571, '06', 'DEPARTAMENTO CAJAMARCA', '0603', 'CELENDIN', '060305', 'JORGE CHAVEZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (572, '06', 'DEPARTAMENTO CAJAMARCA', '0603', 'CELENDIN', '060306', 'JOSE GALVEZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (573, '06', 'DEPARTAMENTO CAJAMARCA', '0603', 'CELENDIN', '060307', 'MIGUEL IGLESIAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (574, '06', 'DEPARTAMENTO CAJAMARCA', '0603', 'CELENDIN', '060308', 'OXAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (575, '06', 'DEPARTAMENTO CAJAMARCA', '0603', 'CELENDIN', '060309', 'SOROCHUCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (576, '06', 'DEPARTAMENTO CAJAMARCA', '0603', 'CELENDIN', '060310', 'SUCRE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (577, '06', 'DEPARTAMENTO CAJAMARCA', '0603', 'CELENDIN', '060311', 'UTCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (578, '06', 'DEPARTAMENTO CAJAMARCA', '0603', 'CELENDIN', '060312', 'LA LIBERTAD DE PALLAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (579, '06', 'DEPARTAMENTO CAJAMARCA', '0604', 'CONTUMAZA', '060401', 'CONTUMAZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (580, '06', 'DEPARTAMENTO CAJAMARCA', '0604', 'CONTUMAZA', '060403', 'CHILETE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (581, '06', 'DEPARTAMENTO CAJAMARCA', '0604', 'CONTUMAZA', '060404', 'GUZMANGO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (582, '06', 'DEPARTAMENTO CAJAMARCA', '0604', 'CONTUMAZA', '060405', 'SAN BENITO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (583, '06', 'DEPARTAMENTO CAJAMARCA', '0604', 'CONTUMAZA', '060406', 'CUPISNIQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (584, '06', 'DEPARTAMENTO CAJAMARCA', '0604', 'CONTUMAZA', '060407', 'TANTARICA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (585, '06', 'DEPARTAMENTO CAJAMARCA', '0604', 'CONTUMAZA', '060408', 'YONAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (586, '06', 'DEPARTAMENTO CAJAMARCA', '0604', 'CONTUMAZA', '060409', 'STA CRUZ DE TOLEDO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (587, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060501', 'CUTERVO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (588, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060502', 'CALLAYUC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (589, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060503', 'CUJILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (590, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060504', 'CHOROS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (591, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060505', 'LA RAMADA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (592, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060506', 'PIMPINGOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (593, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060507', 'QUEROCOTILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (594, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060508', 'SAN ANDRES DE CUTERVO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (595, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060509', 'SAN JUAN DE CUTERVO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (596, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060510', 'SAN LUIS DE LUCMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (597, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060511', 'SANTA CRUZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (598, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060512', 'SANTO DOMINGO DE LA CAPILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (599, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060513', 'SANTO TOMAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (600, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060514', 'SOCOTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (601, '06', 'DEPARTAMENTO CAJAMARCA', '0605', 'CUTERVO', '060515', 'TORIBIO CASANOVA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (602, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060601', 'CHOTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (603, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060602', 'ANGUIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (604, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060603', 'COCHABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (605, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060604', 'CONCHAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (606, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060605', 'CHADIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (607, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060606', 'CHIGUIRIP')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (608, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060607', 'CHIMBAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (609, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060608', 'HUAMBOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (610, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060609', 'LAJAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (611, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060610', 'LLAMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (612, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060611', 'MIRACOSTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (613, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060612', 'PACCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (614, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060613', 'PION')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (615, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060614', 'QUEROCOTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (616, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060615', 'TACABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (617, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060616', 'TOCMOCHE');
 ","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values 
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (618, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060617', 'SAN JUAN DE LICUPIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (619, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060618', 'CHOROPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (620, '06', 'DEPARTAMENTO CAJAMARCA', '0606', 'CHOTA', '060619', 'CHALAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (621, '06', 'DEPARTAMENTO CAJAMARCA', '0607', 'HUALGAYOC', '060701', 'BAMBAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (622, '06', 'DEPARTAMENTO CAJAMARCA', '0607', 'HUALGAYOC', '060702', 'CHUGUR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (623, '06', 'DEPARTAMENTO CAJAMARCA', '0607', 'HUALGAYOC', '060703', 'HUALGAYOC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (624, '06', 'DEPARTAMENTO CAJAMARCA', '0608', 'JAEN', '060801', 'JAEN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (625, '06', 'DEPARTAMENTO CAJAMARCA', '0608', 'JAEN', '060802', 'BELLAVISTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (626, '06', 'DEPARTAMENTO CAJAMARCA', '0608', 'JAEN', '060803', 'COLASAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (627, '06', 'DEPARTAMENTO CAJAMARCA', '0608', 'JAEN', '060804', 'CHONTALI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (628, '06', 'DEPARTAMENTO CAJAMARCA', '0608', 'JAEN', '060805', 'POMAHUACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (629, '06', 'DEPARTAMENTO CAJAMARCA', '0608', 'JAEN', '060806', 'PUCARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (630, '06', 'DEPARTAMENTO CAJAMARCA', '0608', 'JAEN', '060807', 'SALLIQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (631, '06', 'DEPARTAMENTO CAJAMARCA', '0608', 'JAEN', '060808', 'SAN FELIPE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (632, '06', 'DEPARTAMENTO CAJAMARCA', '0608', 'JAEN', '060809', 'SAN JOSE DEL ALTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (633, '06', 'DEPARTAMENTO CAJAMARCA', '0608', 'JAEN', '060810', 'SANTA ROSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (634, '06', 'DEPARTAMENTO CAJAMARCA', '0608', 'JAEN', '060811', 'LAS PIRIAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (635, '06', 'DEPARTAMENTO CAJAMARCA', '0608', 'JAEN', '060812', 'HUABAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (636, '06', 'DEPARTAMENTO CAJAMARCA', '0609', 'SANTA CRUZ', '060901', 'SANTA CRUZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (637, '06', 'DEPARTAMENTO CAJAMARCA', '0609', 'SANTA CRUZ', '060902', 'CATACHE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (638, '06', 'DEPARTAMENTO CAJAMARCA', '0609', 'SANTA CRUZ', '060903', 'CHANCAIBANOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (639, '06', 'DEPARTAMENTO CAJAMARCA', '0609', 'SANTA CRUZ', '060904', 'LA ESPERANZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (640, '06', 'DEPARTAMENTO CAJAMARCA', '0609', 'SANTA CRUZ', '060905', 'NINABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (641, '06', 'DEPARTAMENTO CAJAMARCA', '0609', 'SANTA CRUZ', '060906', 'PULAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (642, '06', 'DEPARTAMENTO CAJAMARCA', '0609', 'SANTA CRUZ', '060907', 'SEXI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (643, '06', 'DEPARTAMENTO CAJAMARCA', '0609', 'SANTA CRUZ', '060908', 'UTICYACU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (644, '06', 'DEPARTAMENTO CAJAMARCA', '0609', 'SANTA CRUZ', '060909', 'YAUYUCAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (645, '06', 'DEPARTAMENTO CAJAMARCA', '0609', 'SANTA CRUZ', '060910', 'ANDABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (646, '06', 'DEPARTAMENTO CAJAMARCA', '0609', 'SANTA CRUZ', '060911', 'SAUCEPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (647, '06', 'DEPARTAMENTO CAJAMARCA', '0610', 'SAN MIGUEL', '061001', 'SAN MIGUEL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (648, '06', 'DEPARTAMENTO CAJAMARCA', '0610', 'SAN MIGUEL', '061002', 'CALQUIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (649, '06', 'DEPARTAMENTO CAJAMARCA', '0610', 'SAN MIGUEL', '061003', 'LA FLORIDA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (650, '06', 'DEPARTAMENTO CAJAMARCA', '0610', 'SAN MIGUEL', '061004', 'LLAPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (651, '06', 'DEPARTAMENTO CAJAMARCA', '0610', 'SAN MIGUEL', '061005', 'NANCHOC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (652, '06', 'DEPARTAMENTO CAJAMARCA', '0610', 'SAN MIGUEL', '061006', 'NIEPOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (653, '06', 'DEPARTAMENTO CAJAMARCA', '0610', 'SAN MIGUEL', '061007', 'SAN GREGORIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (654, '06', 'DEPARTAMENTO CAJAMARCA', '0610', 'SAN MIGUEL', '061008', 'SAN SILVESTRE DE COCHAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (655, '06', 'DEPARTAMENTO CAJAMARCA', '0610', 'SAN MIGUEL', '061009', 'EL PRADO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (656, '06', 'DEPARTAMENTO CAJAMARCA', '0610', 'SAN MIGUEL', '061010', 'UNION AGUA BLANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (657, '06', 'DEPARTAMENTO CAJAMARCA', '0610', 'SAN MIGUEL', '061011', 'TONGOD')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (658, '06', 'DEPARTAMENTO CAJAMARCA', '0610', 'SAN MIGUEL', '061012', 'CATILLUC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (659, '06', 'DEPARTAMENTO CAJAMARCA', '0610', 'SAN MIGUEL', '061013', 'BOLIVAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (660, '06', 'DEPARTAMENTO CAJAMARCA', '0611', 'SAN IGNACIO', '061101', 'SAN IGNACIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (661, '06', 'DEPARTAMENTO CAJAMARCA', '0611', 'SAN IGNACIO', '061102', 'CHIRINOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (662, '06', 'DEPARTAMENTO CAJAMARCA', '0611', 'SAN IGNACIO', '061103', 'HUARANGO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (663, '06', 'DEPARTAMENTO CAJAMARCA', '0611', 'SAN IGNACIO', '061104', 'NAMBALLE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (664, '06', 'DEPARTAMENTO CAJAMARCA', '0611', 'SAN IGNACIO', '061105', 'LA COIPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (665, '06', 'DEPARTAMENTO CAJAMARCA', '0611', 'SAN IGNACIO', '061106', 'SAN JOSE DE LOURDES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (666, '06', 'DEPARTAMENTO CAJAMARCA', '0611', 'SAN IGNACIO', '061107', 'TABACONAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (667, '06', 'DEPARTAMENTO CAJAMARCA', '0612', 'SAN MARCOS', '061201', 'PEDRO GALVEZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (668, '06', 'DEPARTAMENTO CAJAMARCA', '0612', 'SAN MARCOS', '061202', 'ICHOCAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (669, '06', 'DEPARTAMENTO CAJAMARCA', '0612', 'SAN MARCOS', '061203', 'GREGORIO PITA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (670, '06', 'DEPARTAMENTO CAJAMARCA', '0612', 'SAN MARCOS', '061204', 'JOSE MANUEL QUIROZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (671, '06', 'DEPARTAMENTO CAJAMARCA', '0612', 'SAN MARCOS', '061205', 'EDUARDO VILLANUEVA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (672, '06', 'DEPARTAMENTO CAJAMARCA', '0612', 'SAN MARCOS', '061206', 'JOSE SABOGAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (673, '06', 'DEPARTAMENTO CAJAMARCA', '0612', 'SAN MARCOS', '061207', 'CHANCAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (674, '06', 'DEPARTAMENTO CAJAMARCA', '0613', 'SAN PABLO', '061301', 'SAN PABLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (675, '06', 'DEPARTAMENTO CAJAMARCA', '0613', 'SAN PABLO', '061302', 'SAN BERNARDINO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (676, '06', 'DEPARTAMENTO CAJAMARCA', '0613', 'SAN PABLO', '061303', 'SAN LUIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (677, '06', 'DEPARTAMENTO CAJAMARCA', '0613', 'SAN PABLO', '061304', 'TUMBADEN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (678, '07', 'DEPARTAMENTO CUSCO', '0701', 'CUSCO', '070101', 'CUSCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (679, '07', 'DEPARTAMENTO CUSCO', '0701', 'CUSCO', '070102', 'CCORCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (680, '07', 'DEPARTAMENTO CUSCO', '0701', 'CUSCO', '070103', 'POROY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (681, '07', 'DEPARTAMENTO CUSCO', '0701', 'CUSCO', '070104', 'SAN JERONIMO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (682, '07', 'DEPARTAMENTO CUSCO', '0701', 'CUSCO', '070105', 'SAN SEBASTIAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (683, '07', 'DEPARTAMENTO CUSCO', '0701', 'CUSCO', '070106', 'SANTIAGO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (684, '07', 'DEPARTAMENTO CUSCO', '0701', 'CUSCO', '070107', 'SAYLLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (685, '07', 'DEPARTAMENTO CUSCO', '0701', 'CUSCO', '070108', 'WANCHAQ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (686, '07', 'DEPARTAMENTO CUSCO', '0702', 'ACOMAYO', '070201', 'ACOMAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (687, '07', 'DEPARTAMENTO CUSCO', '0702', 'ACOMAYO', '070202', 'ACOPIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (688, '07', 'DEPARTAMENTO CUSCO', '0702', 'ACOMAYO', '070203', 'ACOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (689, '07', 'DEPARTAMENTO CUSCO', '0702', 'ACOMAYO', '070204', 'POMACANCHI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (690, '07', 'DEPARTAMENTO CUSCO', '0702', 'ACOMAYO', '070205', 'RONDOCAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (691, '07', 'DEPARTAMENTO CUSCO', '0702', 'ACOMAYO', '070206', 'SANGARARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (692, '07', 'DEPARTAMENTO CUSCO', '0702', 'ACOMAYO', '070207', 'MOSOC LLACTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (693, '07', 'DEPARTAMENTO CUSCO', '0703', 'ANTA', '070301', 'ANTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (694, '07', 'DEPARTAMENTO CUSCO', '0703', 'ANTA', '070302', 'CHINCHAYPUJIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (695, '07', 'DEPARTAMENTO CUSCO', '0703', 'ANTA', '070303', 'HUAROCONDO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (696, '07', 'DEPARTAMENTO CUSCO', '0703', 'ANTA', '070304', 'LIMATAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (697, '07', 'DEPARTAMENTO CUSCO', '0703', 'ANTA', '070305', 'MOLLEPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (698, '07', 'DEPARTAMENTO CUSCO', '0703', 'ANTA', '070306', 'PUCYURA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (699, '07', 'DEPARTAMENTO CUSCO', '0703', 'ANTA', '070307', 'ZURITE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (700, '07', 'DEPARTAMENTO CUSCO', '0703', 'ANTA', '070308', 'CACHIMAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (701, '07', 'DEPARTAMENTO CUSCO', '0703', 'ANTA', '070309', 'ANCAHUASI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (702, '07', 'DEPARTAMENTO CUSCO', '0704', 'CALCA', '070401', 'CALCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (703, '07', 'DEPARTAMENTO CUSCO', '0704', 'CALCA', '070402', 'COYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (704, '07', 'DEPARTAMENTO CUSCO', '0704', 'CALCA', '070403', 'LAMAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (705, '07', 'DEPARTAMENTO CUSCO', '0704', 'CALCA', '070404', 'LARES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (706, '07', 'DEPARTAMENTO CUSCO', '0704', 'CALCA', '070405', 'PISAC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (707, '07', 'DEPARTAMENTO CUSCO', '0704', 'CALCA', '070406', 'SAN SALVADOR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (708, '07', 'DEPARTAMENTO CUSCO', '0704', 'CALCA', '070407', 'TARAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (709, '07', 'DEPARTAMENTO CUSCO', '0704', 'CALCA', '070408', 'YANATILE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (710, '07', 'DEPARTAMENTO CUSCO', '0705', 'CANAS', '070501', 'YANAOCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (711, '07', 'DEPARTAMENTO CUSCO', '0705', 'CANAS', '070502', 'CHECCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (712, '07', 'DEPARTAMENTO CUSCO', '0705', 'CANAS', '070503', 'KUNTURKANKI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (713, '07', 'DEPARTAMENTO CUSCO', '0705', 'CANAS', '070504', 'LANGUI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (714, '07', 'DEPARTAMENTO CUSCO', '0705', 'CANAS', '070505', 'LAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (715, '07', 'DEPARTAMENTO CUSCO', '0705', 'CANAS', '070506', 'PAMPAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (716, '07', 'DEPARTAMENTO CUSCO', '0705', 'CANAS', '070507', 'QUEHUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (717, '07', 'DEPARTAMENTO CUSCO', '0705', 'CANAS', '070508', 'TUPAC AMARU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (718, '07', 'DEPARTAMENTO CUSCO', '0706', 'CANCHIS', '070601', 'SICUANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (719, '07', 'DEPARTAMENTO CUSCO', '0706', 'CANCHIS', '070602', 'COMBAPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (720, '07', 'DEPARTAMENTO CUSCO', '0706', 'CANCHIS', '070603', 'CHECACUPE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (721, '07', 'DEPARTAMENTO CUSCO', '0706', 'CANCHIS', '070604', 'MARANGANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (722, '07', 'DEPARTAMENTO CUSCO', '0706', 'CANCHIS', '070605', 'PITUMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (723, '07', 'DEPARTAMENTO CUSCO', '0706', 'CANCHIS', '070606', 'SAN PABLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (724, '07', 'DEPARTAMENTO CUSCO', '0706', 'CANCHIS', '070607', 'SAN PEDRO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (725, '07', 'DEPARTAMENTO CUSCO', '0706', 'CANCHIS', '070608', 'TINTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (726, '07', 'DEPARTAMENTO CUSCO', '0707', 'CHUMBIVILCAS', '070701', 'SANTO TOMAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (727, '07', 'DEPARTAMENTO CUSCO', '0707', 'CHUMBIVILCAS', '070702', 'CAPACMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (728, '07', 'DEPARTAMENTO CUSCO', '0707', 'CHUMBIVILCAS', '070703', 'COLQUEMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (729, '07', 'DEPARTAMENTO CUSCO', '0707', 'CHUMBIVILCAS', '070704', 'CHAMACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (730, '07', 'DEPARTAMENTO CUSCO', '0707', 'CHUMBIVILCAS', '070705', 'LIVITACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (731, '07', 'DEPARTAMENTO CUSCO', '0707', 'CHUMBIVILCAS', '070706', 'LLUSCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (732, '07', 'DEPARTAMENTO CUSCO', '0707', 'CHUMBIVILCAS', '070707', 'QUINOTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (733, '07', 'DEPARTAMENTO CUSCO', '0707', 'CHUMBIVILCAS', '070708', 'VELILLE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (734, '07', 'DEPARTAMENTO CUSCO', '0708', 'ESPINAR', '070801', 'ESPINAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (735, '07', 'DEPARTAMENTO CUSCO', '0708', 'ESPINAR', '070802', 'CONDOROMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (736, '07', 'DEPARTAMENTO CUSCO', '0708', 'ESPINAR', '070803', 'COPORAQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (737, '07', 'DEPARTAMENTO CUSCO', '0708', 'ESPINAR', '070804', 'OCORURO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (738, '07', 'DEPARTAMENTO CUSCO', '0708', 'ESPINAR', '070805', 'PALLPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (739, '07', 'DEPARTAMENTO CUSCO', '0708', 'ESPINAR', '070806', 'PICHIGUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (740, '07', 'DEPARTAMENTO CUSCO', '0708', 'ESPINAR', '070807', 'SUYKUTAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (741, '07', 'DEPARTAMENTO CUSCO', '0708', 'ESPINAR', '070808', 'ALTO PICHIGUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (742, '07', 'DEPARTAMENTO CUSCO', '0709', 'LA CONVENCION', '070901', 'SANTA ANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (743, '07', 'DEPARTAMENTO CUSCO', '0709', 'LA CONVENCION', '070902', 'ECHARATE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (744, '07', 'DEPARTAMENTO CUSCO', '0709', 'LA CONVENCION', '070903', 'HUAYOPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (745, '07', 'DEPARTAMENTO CUSCO', '0709', 'LA CONVENCION', '070904', 'MARANURA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (746, '07', 'DEPARTAMENTO CUSCO', '0709', 'LA CONVENCION', '070905', 'OCOBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (747, '07', 'DEPARTAMENTO CUSCO', '0709', 'LA CONVENCION', '070906', 'SANTA TERESA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (748, '07', 'DEPARTAMENTO CUSCO', '0709', 'LA CONVENCION', '070907', 'VILCABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (749, '07', 'DEPARTAMENTO CUSCO', '0709', 'LA CONVENCION', '070908', 'QUELLOUNO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (750, '07', 'DEPARTAMENTO CUSCO', '0709', 'LA CONVENCION', '070909', 'KIMBIRI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (751, '07', 'DEPARTAMENTO CUSCO', '0709', 'LA CONVENCION', '070910', 'PICHARI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (752, '07', 'DEPARTAMENTO CUSCO', '0710', 'PARURO', '071001', 'PARURO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (753, '07', 'DEPARTAMENTO CUSCO', '0710', 'PARURO', '071002', 'ACCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (754, '07', 'DEPARTAMENTO CUSCO', '0710', 'PARURO', '071003', 'CCAPI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (755, '07', 'DEPARTAMENTO CUSCO', '0710', 'PARURO', '071004', 'COLCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (756, '07', 'DEPARTAMENTO CUSCO', '0710', 'PARURO', '071005', 'HUANOQUITE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (757, '07', 'DEPARTAMENTO CUSCO', '0710', 'PARURO', '071006', 'OMACHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (758, '07', 'DEPARTAMENTO CUSCO', '0710', 'PARURO', '071007', 'YAURISQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (759, '07', 'DEPARTAMENTO CUSCO', '0710', 'PARURO', '071008', 'PACCARITAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (760, '07', 'DEPARTAMENTO CUSCO', '0710', 'PARURO', '071009', 'PILLPINTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (761, '07', 'DEPARTAMENTO CUSCO', '0711', 'PAUCARTAMBO', '071101', 'PAUCARTAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (762, '07', 'DEPARTAMENTO CUSCO', '0711', 'PAUCARTAMBO', '071102', 'CAICAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (763, '07', 'DEPARTAMENTO CUSCO', '0711', 'PAUCARTAMBO', '071103', 'COLQUEPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (764, '07', 'DEPARTAMENTO CUSCO', '0711', 'PAUCARTAMBO', '071104', 'CHALLABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (765, '07', 'DEPARTAMENTO CUSCO', '0711', 'PAUCARTAMBO', '071105', 'COSNIPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (766, '07', 'DEPARTAMENTO CUSCO', '0711', 'PAUCARTAMBO', '071106', 'HUANCARANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (767, '07', 'DEPARTAMENTO CUSCO', '0712', 'QUISPICANCHIS', '071201', 'URCOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (768, '07', 'DEPARTAMENTO CUSCO', '0712', 'QUISPICANCHIS', '071202', 'ANDAHUAYLILLAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (769, '07', 'DEPARTAMENTO CUSCO', '0712', 'QUISPICANCHIS', '071203', 'CAMANTI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (770, '07', 'DEPARTAMENTO CUSCO', '0712', 'QUISPICANCHIS', '071204', 'CCARHUAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (771, '07', 'DEPARTAMENTO CUSCO', '0712', 'QUISPICANCHIS', '071205', 'CCATCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (772, '07', 'DEPARTAMENTO CUSCO', '0712', 'QUISPICANCHIS', '071206', 'CUSIPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (773, '07', 'DEPARTAMENTO CUSCO', '0712', 'QUISPICANCHIS', '071207', 'HUARO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (774, '07', 'DEPARTAMENTO CUSCO', '0712', 'QUISPICANCHIS', '071208', 'LUCRE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (775, '07', 'DEPARTAMENTO CUSCO', '0712', 'QUISPICANCHIS', '071209', 'MARCAPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (776, '07', 'DEPARTAMENTO CUSCO', '0712', 'QUISPICANCHIS', '071210', 'OCONGATE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (777, '07', 'DEPARTAMENTO CUSCO', '0712', 'QUISPICANCHIS', '071211', 'OROPESA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (778, '07', 'DEPARTAMENTO CUSCO', '0712', 'QUISPICANCHIS', '071212', 'QUIQUIJANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (779, '07', 'DEPARTAMENTO CUSCO', '0713', 'URUBAMBA', '071301', 'URUBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (780, '07', 'DEPARTAMENTO CUSCO', '0713', 'URUBAMBA', '071302', 'CHINCHERO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (781, '07', 'DEPARTAMENTO CUSCO', '0713', 'URUBAMBA', '071303', 'HUAYLLABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (782, '07', 'DEPARTAMENTO CUSCO', '0713', 'URUBAMBA', '071304', 'MACHUPICCHU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (783, '07', 'DEPARTAMENTO CUSCO', '0713', 'URUBAMBA', '071305', 'MARAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (784, '07', 'DEPARTAMENTO CUSCO', '0713', 'URUBAMBA', '071306', 'OLLANTAYTAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (785, '07', 'DEPARTAMENTO CUSCO', '0713', 'URUBAMBA', '071307', 'YUCAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (786, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080101', 'HUANCAVELICA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (787, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080102', 'ACOBAMBILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (788, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080103', 'ACORIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (789, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080104', 'CONAYCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (790, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080105', 'CUENCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (791, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080106', 'HUACHOCOLPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (792, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080108', 'HUAYLLAHUARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (793, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080109', 'IZCUCHACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (794, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080110', 'LARIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (795, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080111', 'MANTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (796, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080112', 'MARISCAL CACERES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (797, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080113', 'MOYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (798, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080114', 'NUEVO OCCORO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (799, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080115', 'PALCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (800, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080116', 'PILCHACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (801, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080117', 'VILCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (802, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080118', 'YAULI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (803, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080119', 'ASCENCION')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (804, '08', 'DEPARTAMENTO HUANCAVELICA', '0801', 'HUANCAVELICA', '080120', 'HUANDO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (805, '08', 'DEPARTAMENTO HUANCAVELICA', '0802', 'ACOBAMBA', '080201', 'ACOBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (806, '08', 'DEPARTAMENTO HUANCAVELICA', '0802', 'ACOBAMBA', '080202', 'ANTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (807, '08', 'DEPARTAMENTO HUANCAVELICA', '0802', 'ACOBAMBA', '080203', 'ANDABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (808, '08', 'DEPARTAMENTO HUANCAVELICA', '0802', 'ACOBAMBA', '080204', 'CAJA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (809, '08', 'DEPARTAMENTO HUANCAVELICA', '0802', 'ACOBAMBA', '080205', 'MARCAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (810, '08', 'DEPARTAMENTO HUANCAVELICA', '0802', 'ACOBAMBA', '080206', 'PAUCARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (811, '08', 'DEPARTAMENTO HUANCAVELICA', '0802', 'ACOBAMBA', '080207', 'POMACOCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (812, '08', 'DEPARTAMENTO HUANCAVELICA', '0802', 'ACOBAMBA', '080208', 'ROSARIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (813, '08', 'DEPARTAMENTO HUANCAVELICA', '0803', 'ANGARAES', '080301', 'LIRCAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (814, '08', 'DEPARTAMENTO HUANCAVELICA', '0803', 'ANGARAES', '080302', 'ANCHONGA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (815, '08', 'DEPARTAMENTO HUANCAVELICA', '0803', 'ANGARAES', '080303', 'CALLANMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (816, '08', 'DEPARTAMENTO HUANCAVELICA', '0803', 'ANGARAES', '080304', 'CONGALLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (817, '08', 'DEPARTAMENTO HUANCAVELICA', '0803', 'ANGARAES', '080305', 'CHINCHO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (818, '08', 'DEPARTAMENTO HUANCAVELICA', '0803', 'ANGARAES', '080306', 'HUAYLLAY GRANDE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (819, '08', 'DEPARTAMENTO HUANCAVELICA', '0803', 'ANGARAES', '080307', 'HUANCA HUANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (820, '08', 'DEPARTAMENTO HUANCAVELICA', '0803', 'ANGARAES', '080308', 'JULCAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (821, '08', 'DEPARTAMENTO HUANCAVELICA', '0803', 'ANGARAES', '080309', 'SAN ANTONIO DE ANTAPARCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (822, '08', 'DEPARTAMENTO HUANCAVELICA', '0803', 'ANGARAES', '080310', 'STO TOMAS DE PATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (823, '08', 'DEPARTAMENTO HUANCAVELICA', '0803', 'ANGARAES', '080311', 'SECCLLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (824, '08', 'DEPARTAMENTO HUANCAVELICA', '0803', 'ANGARAES', '080312', 'CCOCHACCASA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (825, '08', 'DEPARTAMENTO HUANCAVELICA', '0804', 'CASTROVIRREYNA', '080401', 'CASTROVIRREYNA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (826, '08', 'DEPARTAMENTO HUANCAVELICA', '0804', 'CASTROVIRREYNA', '080402', 'ARMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (827, '08', 'DEPARTAMENTO HUANCAVELICA', '0804', 'CASTROVIRREYNA', '080403', 'AURAHUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (828, '08', 'DEPARTAMENTO HUANCAVELICA', '0804', 'CASTROVIRREYNA', '080405', 'CAPILLAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (829, '08', 'DEPARTAMENTO HUANCAVELICA', '0804', 'CASTROVIRREYNA', '080406', 'COCAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (830, '08', 'DEPARTAMENTO HUANCAVELICA', '0804', 'CASTROVIRREYNA', '080408', 'CHUPAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (831, '08', 'DEPARTAMENTO HUANCAVELICA', '0804', 'CASTROVIRREYNA', '080409', 'HUACHOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (832, '08', 'DEPARTAMENTO HUANCAVELICA', '0804', 'CASTROVIRREYNA', '080410', 'HUAMATAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (833, '08', 'DEPARTAMENTO HUANCAVELICA', '0804', 'CASTROVIRREYNA', '080414', 'MOLLEPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (834, '08', 'DEPARTAMENTO HUANCAVELICA', '0804', 'CASTROVIRREYNA', '080422', 'SAN JUAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (835, '08', 'DEPARTAMENTO HUANCAVELICA', '0804', 'CASTROVIRREYNA', '080427', 'TANTARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (836, '08', 'DEPARTAMENTO HUANCAVELICA', '0804', 'CASTROVIRREYNA', '080428', 'TICRAPO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (837, '08', 'DEPARTAMENTO HUANCAVELICA', '0804', 'CASTROVIRREYNA', '080429', 'SANTA ANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (838, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080501', 'PAMPAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (839, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080502', 'ACOSTAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (840, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080503', 'ACRAQUIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (841, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080504', 'AHUAYCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (842, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080506', 'COLCABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (843, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080509', 'DANIEL HERNANDEZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (844, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080511', 'HUACHOCOLPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (845, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080512', 'HUARIBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (846, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080515', 'NAHUIMPUQUIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (847, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080517', 'PAZOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (848, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080518', 'QUISHUAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (849, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080519', 'SALCABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (850, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080520', 'SAN MARCOS DE ROCCHAC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (851, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080523', 'SURCUBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (852, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080525', 'TINTAY PUNCU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (853, '08', 'DEPARTAMENTO HUANCAVELICA', '0805', 'TAYACAJA', '080526', 'SALCAHUASI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (854, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080601', 'AYAVI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (855, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080602', 'CORDOVA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (856, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080603', 'HUAYACUNDO ARMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (857, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080604', 'HUAYTARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (858, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080605', 'LARAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (859, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080606', 'OCOYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (860, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080607', 'PILPICHACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (861, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080608', 'QUERCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (862, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080609', 'QUITO ARMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (863, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080610', 'SAN ANTONIO DE CUSICANCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (864, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080611', 'SAN FRANCISCO DE SANGAYAICO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (865, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080612', 'SAN ISIDRO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (866, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080613', 'SANTIAGO DE CHOCORVOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (867, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080614', 'SANTIAGO DE QUIRAHUARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (868, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080615', 'SANTO DOMINGO DE CAPILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (869, '08', 'DEPARTAMENTO HUANCAVELICA', '0806', 'HUAYTARA', '080616', 'TAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (870, '08', 'DEPARTAMENTO HUANCAVELICA', '0807', 'CHURCAMPA', '080701', 'CHURCAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (871, '08', 'DEPARTAMENTO HUANCAVELICA', '0807', 'CHURCAMPA', '080702', 'ANCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (872, '08', 'DEPARTAMENTO HUANCAVELICA', '0807', 'CHURCAMPA', '080703', 'CHINCHIHUASI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (873, '08', 'DEPARTAMENTO HUANCAVELICA', '0807', 'CHURCAMPA', '080704', 'EL CARMEN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (874, '08', 'DEPARTAMENTO HUANCAVELICA', '0807', 'CHURCAMPA', '080705', 'LA MERCED')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (875, '08', 'DEPARTAMENTO HUANCAVELICA', '0807', 'CHURCAMPA', '080706', 'LOCROJA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (876, '08', 'DEPARTAMENTO HUANCAVELICA', '0807', 'CHURCAMPA', '080707', 'PAUCARBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (877, '08', 'DEPARTAMENTO HUANCAVELICA', '0807', 'CHURCAMPA', '080708', 'SAN MIGUEL DE MAYOC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (878, '08', 'DEPARTAMENTO HUANCAVELICA', '0807', 'CHURCAMPA', '080709', 'SAN PEDRO DE CORIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (879, '08', 'DEPARTAMENTO HUANCAVELICA', '0807', 'CHURCAMPA', '080710', 'PACHAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (880, '09', 'DEPARTAMENTO HUANUCO', '0901', 'HUANUCO', '090101', 'HUANUCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (881, '09', 'DEPARTAMENTO HUANUCO', '0901', 'HUANUCO', '090102', 'CHINCHAO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (882, '09', 'DEPARTAMENTO HUANUCO', '0901', 'HUANUCO', '090103', 'CHURUBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (883, '09', 'DEPARTAMENTO HUANUCO', '0901', 'HUANUCO', '090104', 'MARGOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (884, '09', 'DEPARTAMENTO HUANUCO', '0901', 'HUANUCO', '090105', 'QUISQUI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (885, '09', 'DEPARTAMENTO HUANUCO', '0901', 'HUANUCO', '090106', 'SAN FCO DE CAYRAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (886, '09', 'DEPARTAMENTO HUANUCO', '0901', 'HUANUCO', '090107', 'SAN PEDRO DE CHAULAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (887, '09', 'DEPARTAMENTO HUANUCO', '0901', 'HUANUCO', '090108', 'STA MARIA DEL VALLE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (888, '09', 'DEPARTAMENTO HUANUCO', '0901', 'HUANUCO', '090109', 'YARUMAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (889, '09', 'DEPARTAMENTO HUANUCO', '0901', 'HUANUCO', '090110', 'AMARILIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (890, '09', 'DEPARTAMENTO HUANUCO', '0901', 'HUANUCO', '090111', 'PILLCO MARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (891, '09', 'DEPARTAMENTO HUANUCO', '0902', 'AMBO', '090201', 'AMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (892, '09', 'DEPARTAMENTO HUANUCO', '0902', 'AMBO', '090202', 'CAYNA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (893, '09', 'DEPARTAMENTO HUANUCO', '0902', 'AMBO', '090203', 'COLPAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (894, '09', 'DEPARTAMENTO HUANUCO', '0902', 'AMBO', '090204', 'CONCHAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (895, '09', 'DEPARTAMENTO HUANUCO', '0902', 'AMBO', '090205', 'HUACAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (896, '09', 'DEPARTAMENTO HUANUCO', '0902', 'AMBO', '090206', 'SAN FRANCISCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (897, '09', 'DEPARTAMENTO HUANUCO', '0902', 'AMBO', '090207', 'SAN RAFAEL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (898, '09', 'DEPARTAMENTO HUANUCO', '0902', 'AMBO', '090208', 'TOMAY KICHWA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (899, '09', 'DEPARTAMENTO HUANUCO', '0903', 'DOS DE MAYO', '090301', 'LA UNION')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (900, '09', 'DEPARTAMENTO HUANUCO', '0903', 'DOS DE MAYO', '090307', 'CHUQUIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (901, '09', 'DEPARTAMENTO HUANUCO', '0903', 'DOS DE MAYO', '090312', 'MARIAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (902, '09', 'DEPARTAMENTO HUANUCO', '0903', 'DOS DE MAYO', '090314', 'PACHAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (903, '09', 'DEPARTAMENTO HUANUCO', '0903', 'DOS DE MAYO', '090316', 'QUIVILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (904, '09', 'DEPARTAMENTO HUANUCO', '0903', 'DOS DE MAYO', '090317', 'RIPAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (905, '09', 'DEPARTAMENTO HUANUCO', '0903', 'DOS DE MAYO', '090321', 'SHUNQUI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (906, '09', 'DEPARTAMENTO HUANUCO', '0903', 'DOS DE MAYO', '090322', 'SILLAPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (907, '09', 'DEPARTAMENTO HUANUCO', '0903', 'DOS DE MAYO', '090323', 'YANAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (908, '09', 'DEPARTAMENTO HUANUCO', '0904', 'HUAMALIES', '090401', 'LLATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (909, '09', 'DEPARTAMENTO HUANUCO', '0904', 'HUAMALIES', '090402', 'ARANCAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (910, '09', 'DEPARTAMENTO HUANUCO', '0904', 'HUAMALIES', '090403', 'CHAVIN DE PARIARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (911, '09', 'DEPARTAMENTO HUANUCO', '0904', 'HUAMALIES', '090404', 'JACAS GRANDE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (912, '09', 'DEPARTAMENTO HUANUCO', '0904', 'HUAMALIES', '090405', 'JIRCAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (913, '09', 'DEPARTAMENTO HUANUCO', '0904', 'HUAMALIES', '090406', 'MIRAFLORES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (914, '09', 'DEPARTAMENTO HUANUCO', '0904', 'HUAMALIES', '090407', 'MONZON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (915, '09', 'DEPARTAMENTO HUANUCO', '0904', 'HUAMALIES', '090408', 'PUNCHAO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (916, '09', 'DEPARTAMENTO HUANUCO', '0904', 'HUAMALIES', '090409', 'PUNOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (917, '09', 'DEPARTAMENTO HUANUCO', '0904', 'HUAMALIES', '090410', 'SINGA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (918, '09', 'DEPARTAMENTO HUANUCO', '0904', 'HUAMALIES', '090411', 'TANTAMAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (919, '09', 'DEPARTAMENTO HUANUCO', '0905', 'MARANON', '090501', 'HUACRACHUCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (920, '09', 'DEPARTAMENTO HUANUCO', '0905', 'MARANON', '090502', 'CHOLON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (921, '09', 'DEPARTAMENTO HUANUCO', '0905', 'MARANON', '090505', 'SAN BUENAVENTURA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (922, '09', 'DEPARTAMENTO HUANUCO', '0906', 'LEONCIO PRADO', '090601', 'RUPA RUPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (923, '09', 'DEPARTAMENTO HUANUCO', '0906', 'LEONCIO PRADO', '090602', 'DANIEL ALOMIA ROBLES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (924, '09', 'DEPARTAMENTO HUANUCO', '0906', 'LEONCIO PRADO', '090603', 'HERMILIO VALDIZAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (925, '09', 'DEPARTAMENTO HUANUCO', '0906', 'LEONCIO PRADO', '090604', 'LUYANDO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (926, '09', 'DEPARTAMENTO HUANUCO', '0906', 'LEONCIO PRADO', '090605', 'MARIANO DAMASO BERAUN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (927, '09', 'DEPARTAMENTO HUANUCO', '0906', 'LEONCIO PRADO', '090606', 'JOSE CRESPO Y CASTILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (928, '09', 'DEPARTAMENTO HUANUCO', '0907', 'PACHITEA', '090701', 'PANAO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (929, '09', 'DEPARTAMENTO HUANUCO', '0907', 'PACHITEA', '090702', 'CHAGLLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (930, '09', 'DEPARTAMENTO HUANUCO', '0907', 'PACHITEA', '090704', 'MOLINO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (931, '09', 'DEPARTAMENTO HUANUCO', '0907', 'PACHITEA', '090706', 'UMARI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (932, '09', 'DEPARTAMENTO HUANUCO', '0908', 'PUERTO INCA', '090801', 'HONORIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (933, '09', 'DEPARTAMENTO HUANUCO', '0908', 'PUERTO INCA', '090802', 'PUERTO INCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (934, '09', 'DEPARTAMENTO HUANUCO', '0908', 'PUERTO INCA', '090803', 'CODO DEL POZUZO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (935, '09', 'DEPARTAMENTO HUANUCO', '0908', 'PUERTO INCA', '090804', 'TOURNAVISTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (936, '09', 'DEPARTAMENTO HUANUCO', '0908', 'PUERTO INCA', '090805', 'YUYAPICHIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (937, '09', 'DEPARTAMENTO HUANUCO', '0909', 'HUACAYBAMBA', '090901', 'HUACAYBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (938, '09', 'DEPARTAMENTO HUANUCO', '0909', 'HUACAYBAMBA', '090902', 'PINRA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (939, '09', 'DEPARTAMENTO HUANUCO', '0909', 'HUACAYBAMBA', '090903', 'CANCHABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (940, '09', 'DEPARTAMENTO HUANUCO', '0909', 'HUACAYBAMBA', '090904', 'COCHABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (941, '09', 'DEPARTAMENTO HUANUCO', '0910', 'LAURICOCHA', '091001', 'JESUS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (942, '09', 'DEPARTAMENTO HUANUCO', '0910', 'LAURICOCHA', '091002', 'BANOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (943, '09', 'DEPARTAMENTO HUANUCO', '0910', 'LAURICOCHA', '091003', 'SAN FRANCISCO DE ASIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (944, '09', 'DEPARTAMENTO HUANUCO', '0910', 'LAURICOCHA', '091004', 'QUEROPALCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (945, '09', 'DEPARTAMENTO HUANUCO', '0910', 'LAURICOCHA', '091005', 'SAN MIGUEL DE CAURI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (946, '09', 'DEPARTAMENTO HUANUCO', '0910', 'LAURICOCHA', '091006', 'RONDOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (947, '09', 'DEPARTAMENTO HUANUCO', '0910', 'LAURICOCHA', '091007', 'JIVIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (948, '09', 'DEPARTAMENTO HUANUCO', '0911', 'YAROWILCA', '091101', 'CHAVINILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (949, '09', 'DEPARTAMENTO HUANUCO', '0911', 'YAROWILCA', '091102', 'APARICIO POMARES ","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (CHUPAN)')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (950, '09', 'DEPARTAMENTO HUANUCO', '0911', 'YAROWILCA', '091103', 'CAHUAC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (951, '09', 'DEPARTAMENTO HUANUCO', '0911', 'YAROWILCA', '091104', 'CHACABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (952, '09', 'DEPARTAMENTO HUANUCO', '0911', 'YAROWILCA', '091105', 'JACAS CHICO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (953, '09', 'DEPARTAMENTO HUANUCO', '0911', 'YAROWILCA', '091106', 'OBAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (954, '09', 'DEPARTAMENTO HUANUCO', '0911', 'YAROWILCA', '091107', 'PAMPAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (955, '09', 'DEPARTAMENTO HUANUCO', '0911', 'YAROWILCA', '091108', 'CHORAS                   ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (956, '10', 'DEPARTAMENTO ICA', '1001', 'ICA', '100101', 'ICA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (957, '10', 'DEPARTAMENTO ICA', '1001', 'ICA', '100102', 'LA TINGUINA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (958, '10', 'DEPARTAMENTO ICA', '1001', 'ICA', '100103', 'LOS AQUIJES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (959, '10', 'DEPARTAMENTO ICA', '1001', 'ICA', '100104', 'PARCONA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (960, '10', 'DEPARTAMENTO ICA', '1001', 'ICA', '100105', 'PUEBLO NUEVO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (961, '10', 'DEPARTAMENTO ICA', '1001', 'ICA', '100106', 'SALAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (962, '10', 'DEPARTAMENTO ICA', '1001', 'ICA', '100107', 'SAN JOSE DE LOS MOLINOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (963, '10', 'DEPARTAMENTO ICA', '1001', 'ICA', '100108', 'SAN JUAN BAUTISTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (964, '10', 'DEPARTAMENTO ICA', '1001', 'ICA', '100109', 'SANTIAGO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (965, '10', 'DEPARTAMENTO ICA', '1001', 'ICA', '100110', 'SUBTANJALLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (966, '10', 'DEPARTAMENTO ICA', '1001', 'ICA', '100111', 'YAUCA DEL ROSARIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (967, '10', 'DEPARTAMENTO ICA', '1001', 'ICA', '100112', 'TATE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (968, '10', 'DEPARTAMENTO ICA', '1001', 'ICA', '100113', 'PACHACUTEC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (969, '10', 'DEPARTAMENTO ICA', '1001', 'ICA', '100114', 'OCUCAJE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (970, '10', 'DEPARTAMENTO ICA', '1002', 'CHINCHA', '100201', 'CHINCHA ALTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (971, '10', 'DEPARTAMENTO ICA', '1002', 'CHINCHA', '100202', 'CHAVIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (972, '10', 'DEPARTAMENTO ICA', '1002', 'CHINCHA', '100203', 'CHINCHA BAJA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (973, '10', 'DEPARTAMENTO ICA', '1002', 'CHINCHA', '100204', 'EL CARMEN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (974, '10', 'DEPARTAMENTO ICA', '1002', 'CHINCHA', '100205', 'GROCIO PRADO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (975, '10', 'DEPARTAMENTO ICA', '1002', 'CHINCHA', '100206', 'SAN PEDRO DE HUACARPANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (976, '10', 'DEPARTAMENTO ICA', '1002', 'CHINCHA', '100207', 'SUNAMPE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (977, '10', 'DEPARTAMENTO ICA', '1002', 'CHINCHA', '100208', 'TAMBO DE MORA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (978, '10', 'DEPARTAMENTO ICA', '1002', 'CHINCHA', '100209', 'ALTO LARAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (979, '10', 'DEPARTAMENTO ICA', '1002', 'CHINCHA', '100210', 'PUEBLO NUEVO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (980, '10', 'DEPARTAMENTO ICA', '1002', 'CHINCHA', '100211', 'SAN JUAN DE YANAC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (981, '10', 'DEPARTAMENTO ICA', '1003', 'NAZCA', '100301', 'NAZCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (982, '10', 'DEPARTAMENTO ICA', '1003', 'NAZCA', '100302', 'CHANGUILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (983, '10', 'DEPARTAMENTO ICA', '1003', 'NAZCA', '100303', 'EL INGENIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (984, '10', 'DEPARTAMENTO ICA', '1003', 'NAZCA', '100304', 'MARCONA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (985, '10', 'DEPARTAMENTO ICA', '1003', 'NAZCA', '100305', 'VISTA ALEGRE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (986, '10', 'DEPARTAMENTO ICA', '1004', 'PISCO', '100401', 'PISCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (987, '10', 'DEPARTAMENTO ICA', '1004', 'PISCO', '100402', 'HUANCANO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (988, '10', 'DEPARTAMENTO ICA', '1004', 'PISCO', '100403', 'HUMAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (989, '10', 'DEPARTAMENTO ICA', '1004', 'PISCO', '100404', 'INDEPENDENCIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (990, '10', 'DEPARTAMENTO ICA', '1004', 'PISCO', '100405', 'PARACAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (991, '10', 'DEPARTAMENTO ICA', '1004', 'PISCO', '100406', 'SAN ANDRES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (992, '10', 'DEPARTAMENTO ICA', '1004', 'PISCO', '100407', 'SAN CLEMENTE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (993, '10', 'DEPARTAMENTO ICA', '1004', 'PISCO', '100408', 'TUPAC AMARU INCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (994, '10', 'DEPARTAMENTO ICA', '1005', 'PALPA', '100501', 'PALPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (995, '10', 'DEPARTAMENTO ICA', '1005', 'PALPA', '100502', 'LLIPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (996, '10', 'DEPARTAMENTO ICA', '1005', 'PALPA', '100503', 'RIO GRANDE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (997, '10', 'DEPARTAMENTO ICA', '1005', 'PALPA', '100504', 'SANTA CRUZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (998, '10', 'DEPARTAMENTO ICA', '1005', 'PALPA', '100505', 'TIBILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (999, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110101', 'HUANCAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1000, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110103', 'CARHUACALLANGA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1001, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110104', 'COLCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1002, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110105', '')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1003, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110106', 'CHACAPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1004, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110107', 'CHICCHE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1005, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110108', 'CHILCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1006, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110109', 'CHONGOS ALTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1007, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110112', 'CHUPURO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1008, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110113', 'EL TAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1009, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110114', 'HUACRAPUQUIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1010, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110116', 'HUALHUAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1011, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110118', 'HUANCAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1012, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110119', 'HUASICANCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1013, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110120', 'HUAYUCACHI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1014, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110121', 'INGENIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1015, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110122', 'PARIAHUANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1016, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110123', 'PILCOMAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1017, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110124', 'PUCARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1018, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110125', 'QUICHUAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1019, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110126', 'QUILCAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1020, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110127', 'SAN AGUSTIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1021, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110128', 'SAN JERONIMO DE TUNAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1022, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110131', 'STO DOMINGO DE ACOBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1023, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110132', 'SANO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1024, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110133', 'SAPALLANGA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1025, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110134', 'SICAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1026, '11', 'DEPARTAMENTO JUNIN', '1101', 'HUANCAYO', '110136', 'VIQUES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1027, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110201', 'CONCEPCION')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1028, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110202', 'ACO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1029, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110203', 'ANDAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1030, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110204', 'COMAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1031, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110205', 'COCHAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1032, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110206', 'CHAMBARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1033, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110207', 'HEROINAS TOLEDO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1034, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110208', 'MANZANARES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1035, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110209', 'MCAL CASTILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1036, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110210', 'MATAHUASI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1037, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110211', 'MITO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1038, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110212', 'NUEVE DE JULIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1039, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110213', 'ORCOTUNA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1040, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110214', 'STA ROSA DE OCOPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1041, '11', 'DEPARTAMENTO JUNIN', '1102', 'CONCEPCION', '110215', 'SAN JOSE DE QUERO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1042, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110301', 'JAUJA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1043, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110302', 'ACOLLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1044, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110303', 'APATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1045, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110304', 'ATAURA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1046, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110305', 'CANCHAILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1047, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110306', 'EL MANTARO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1048, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110307', 'HUAMALI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1049, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110308', 'HUARIPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1050, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110309', 'HUERTAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1051, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110310', 'JANJAILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1052, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110311', 'JULCAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1053, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110312', 'LEONOR ORDONEZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1054, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110313', 'LLOCLLAPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1055, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110314', 'MARCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1056, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110315', 'MASMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1057, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110316', 'MOLINOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1058, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110317', 'MONOBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1059, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110318', 'MUQUI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1060, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110319', 'MUQUIYAUYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1061, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110320', 'PACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1062, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110321', 'PACCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1063, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110322', 'PANCAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1064, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110323', 'PARCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1065, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110324', 'POMACANCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1066, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110325', 'RICRAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1067, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110326', 'SAN LORENZO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1068, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110327', 'SAN PEDRO DE CHUNAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1069, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110328', 'SINCOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1070, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110329', 'TUNAN MARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1071, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110330', 'YAULI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1072, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110331', 'CURICACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1073, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110332', 'MASMA CHICCHE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1074, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110333', 'SAUSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1075, '11', 'DEPARTAMENTO JUNIN', '1103', 'JAUJA', '110334', 'YAUYOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1076, '11', 'DEPARTAMENTO JUNIN', '1104', 'JUNIN', '110401', 'JUNIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1077, '11', 'DEPARTAMENTO JUNIN', '1104', 'JUNIN', '110402', 'CARHUAMAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1078, '11', 'DEPARTAMENTO JUNIN', '1104', 'JUNIN', '110403', 'ONDORES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1079, '11', 'DEPARTAMENTO JUNIN', '1104', 'JUNIN', '110404', 'ULCUMAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1080, '11', 'DEPARTAMENTO JUNIN', '1105', 'TARMA', '110501', 'TARMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1081, '11', 'DEPARTAMENTO JUNIN', '1105', 'TARMA', '110502', 'ACOBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1082, '11', 'DEPARTAMENTO JUNIN', '1105', 'TARMA', '110503', 'HUARICOLCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1083, '11', 'DEPARTAMENTO JUNIN', '1105', 'TARMA', '110504', 'HUASAHUASI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1084, '11', 'DEPARTAMENTO JUNIN', '1105', 'TARMA', '110505', 'LA UNION')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1085, '11', 'DEPARTAMENTO JUNIN', '1105', 'TARMA', '110506', 'PALCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1086, '11', 'DEPARTAMENTO JUNIN', '1105', 'TARMA', '110507', 'PALCAMAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1087, '11', 'DEPARTAMENTO JUNIN', '1105', 'TARMA', '110508', 'SAN PEDRO DE CAJAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1088, '11', 'DEPARTAMENTO JUNIN', '1105', 'TARMA', '110509', 'TAPO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1089, '11', 'DEPARTAMENTO JUNIN', '1106', 'YAULI', '110601', 'LA OROYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1090, '11', 'DEPARTAMENTO JUNIN', '1106', 'YAULI', '110602', 'CHACAPALPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1091, '11', 'DEPARTAMENTO JUNIN', '1106', 'YAULI', '110603', 'HUAY HUAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1092, '11', 'DEPARTAMENTO JUNIN', '1106', 'YAULI', '110604', 'MARCAPOMACOCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1093, '11', 'DEPARTAMENTO JUNIN', '1106', 'YAULI', '110605', 'MOROCOCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1094, '11', 'DEPARTAMENTO JUNIN', '1106', 'YAULI', '110606', 'PACCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1095, '11', 'DEPARTAMENTO JUNIN', '1106', 'YAULI', '110607', 'STA BARBARA DE CARHUACAYAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1096, '11', 'DEPARTAMENTO JUNIN', '1106', 'YAULI', '110608', 'SUITUCANCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1097, '11', 'DEPARTAMENTO JUNIN', '1106', 'YAULI', '110609', 'YAULI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1098, '11', 'DEPARTAMENTO JUNIN', '1106', 'YAULI', '110610', 'STA ROSA DE SACCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1099, '11', 'DEPARTAMENTO JUNIN', '1107', 'SATIPO', '110701', 'SATIPO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1100, '11', 'DEPARTAMENTO JUNIN', '1107', 'SATIPO', '110702', 'COVIRIALI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1101, '11', 'DEPARTAMENTO JUNIN', '1107', 'SATIPO', '110703', 'LLAYLLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1102, '11', 'DEPARTAMENTO JUNIN', '1107', 'SATIPO', '110704', 'MAZAMARI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1103, '11', 'DEPARTAMENTO JUNIN', '1107', 'SATIPO', '110705', 'PAMPA HERMOSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1104, '11', 'DEPARTAMENTO JUNIN', '1107', 'SATIPO', '110706', 'PANGOA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1105, '11', 'DEPARTAMENTO JUNIN', '1107', 'SATIPO', '110707', 'RIO NEGRO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1106, '11', 'DEPARTAMENTO JUNIN', '1107', 'SATIPO', '110708', 'RIO TAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1107, '11', 'DEPARTAMENTO JUNIN', '1108', 'CHANCHAMAYO', '110801', 'CHANCHAMAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1108, '11', 'DEPARTAMENTO JUNIN', '1108', 'CHANCHAMAYO', '110802', 'SAN RAMON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1109, '11', 'DEPARTAMENTO JUNIN', '1108', 'CHANCHAMAYO', '110803', 'VITOC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1110, '11', 'DEPARTAMENTO JUNIN', '1108', 'CHANCHAMAYO', '110804', 'SAN LUIS DE SHUARO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1111, '11', 'DEPARTAMENTO JUNIN', '1108', 'CHANCHAMAYO', '110805', 'PICHANAQUI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1112, '11', 'DEPARTAMENTO JUNIN', '1108', 'CHANCHAMAYO', '110806', 'PERENE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1113, '11', 'DEPARTAMENTO JUNIN', '1109', 'CHUPACA', '110901', 'CHUPACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1114, '11', 'DEPARTAMENTO JUNIN', '1109', 'CHUPACA', '110902', 'AHUAC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1115, '11', 'DEPARTAMENTO JUNIN', '1109', 'CHUPACA', '110903', 'CHONGOS BAJO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1116, '11', 'DEPARTAMENTO JUNIN', '1109', 'CHUPACA', '110904', 'HUACHAC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1117, '11', 'DEPARTAMENTO JUNIN', '1109', 'CHUPACA', '110905', 'HUAMANCACA CHICO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1118, '11', 'DEPARTAMENTO JUNIN', '1109', 'CHUPACA', '110906', 'SAN JUAN DE ISCOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1119, '11', 'DEPARTAMENTO JUNIN', '1109', 'CHUPACA', '110907', 'SAN JUAN DE JARPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1120, '11', 'DEPARTAMENTO JUNIN', '1109', 'CHUPACA', '110908', 'TRES DE DICIEMBRE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1121, '11', 'DEPARTAMENTO JUNIN', '1109', 'CHUPACA', '110909', 'YANACANCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1122, '12', 'DEPARTAMENTO LA LIBERTAD', '1201', 'TRUJILLO', '120101', 'TRUJILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1123, '12', 'DEPARTAMENTO LA LIBERTAD', '1201', 'TRUJILLO', '120102', 'HUANCHACO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1124, '12', 'DEPARTAMENTO LA LIBERTAD', '1201', 'TRUJILLO', '120103', 'LAREDO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1125, '12', 'DEPARTAMENTO LA LIBERTAD', '1201', 'TRUJILLO', '120104', 'MOCHE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1126, '12', 'DEPARTAMENTO LA LIBERTAD', '1201', 'TRUJILLO', '120105', 'SALAVERRY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1127, '12', 'DEPARTAMENTO LA LIBERTAD', '1201', 'TRUJILLO', '120106', 'SIMBAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1128, '12', 'DEPARTAMENTO LA LIBERTAD', '1201', 'TRUJILLO', '120107', 'VICTOR LARCO HERRERA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1129, '12', 'DEPARTAMENTO LA LIBERTAD', '1201', 'TRUJILLO', '120109', 'POROTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1130, '12', 'DEPARTAMENTO LA LIBERTAD', '1201', 'TRUJILLO', '120110', 'EL PORVENIR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1131, '12', 'DEPARTAMENTO LA LIBERTAD', '1201', 'TRUJILLO', '120111', 'LA ESPERANZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1132, '12', 'DEPARTAMENTO LA LIBERTAD', '1201', 'TRUJILLO', '120112', 'FLORENCIA DE MORA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1133, '12', 'DEPARTAMENTO LA LIBERTAD', '1202', 'BOLIVAR', '120201', 'BOLIVAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1134, '12', 'DEPARTAMENTO LA LIBERTAD', '1202', 'BOLIVAR', '120202', 'BAMBAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1135, '12', 'DEPARTAMENTO LA LIBERTAD', '1202', 'BOLIVAR', '120203', 'CONDORMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1136, '12', 'DEPARTAMENTO LA LIBERTAD', '1202', 'BOLIVAR', '120204', 'LONGOTEA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1137, '12', 'DEPARTAMENTO LA LIBERTAD', '1202', 'BOLIVAR', '120205', 'UCUNCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1138, '12', 'DEPARTAMENTO LA LIBERTAD', '1202', 'BOLIVAR', '120206', 'UCHUMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1139, '12', 'DEPARTAMENTO LA LIBERTAD', '1203', 'SANCHEZ CARRION', '120301', 'HUAMACHUCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1140, '12', 'DEPARTAMENTO LA LIBERTAD', '1203', 'SANCHEZ CARRION', '120302', 'COCHORCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1141, '12', 'DEPARTAMENTO LA LIBERTAD', '1203', 'SANCHEZ CARRION', '120303', 'CURGOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1142, '12', 'DEPARTAMENTO LA LIBERTAD', '1203', 'SANCHEZ CARRION', '120304', 'CHUGAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1143, '12', 'DEPARTAMENTO LA LIBERTAD', '1203', 'SANCHEZ CARRION', '120305', 'MARCABAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1144, '12', 'DEPARTAMENTO LA LIBERTAD', '1203', 'SANCHEZ CARRION', '120306', 'SANAGORAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1145, '12', 'DEPARTAMENTO LA LIBERTAD', '1203', 'SANCHEZ CARRION', '120307', 'SARIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1146, '12', 'DEPARTAMENTO LA LIBERTAD', '1203', 'SANCHEZ CARRION', '120308', 'SARTIMBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1147, '12', 'DEPARTAMENTO LA LIBERTAD', '1204', 'OTUZCO', '120401', 'OTUZCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1148, '12', 'DEPARTAMENTO LA LIBERTAD', '1204', 'OTUZCO', '120402', 'AGALLPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1149, '12', 'DEPARTAMENTO LA LIBERTAD', '1204', 'OTUZCO', '120403', 'CHARAT')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1150, '12', 'DEPARTAMENTO LA LIBERTAD', '1204', 'OTUZCO', '120404', 'HUARANCHAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1151, '12', 'DEPARTAMENTO LA LIBERTAD', '1204', 'OTUZCO', '120405', 'LA CUESTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1152, '12', 'DEPARTAMENTO LA LIBERTAD', '1204', 'OTUZCO', '120408', 'PARANDAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1153, '12', 'DEPARTAMENTO LA LIBERTAD', '1204', 'OTUZCO', '120409', 'SALPO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1154, '12', 'DEPARTAMENTO LA LIBERTAD', '1204', 'OTUZCO', '120410', 'SINSICAP')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1155, '12', 'DEPARTAMENTO LA LIBERTAD', '1204', 'OTUZCO', '120411', 'USQUIL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1156, '12', 'DEPARTAMENTO LA LIBERTAD', '1204', 'OTUZCO', '120413', 'MACHE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1157, '12', 'DEPARTAMENTO LA LIBERTAD', '1205', 'PACASMAYO', '120501', 'SAN PEDRO DE LLOC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1158, '12', 'DEPARTAMENTO LA LIBERTAD', '1205', 'PACASMAYO', '120503', 'GUADALUPE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1159, '12', 'DEPARTAMENTO LA LIBERTAD', '1205', 'PACASMAYO', '120504', 'JEQUETEPEQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1160, '12', 'DEPARTAMENTO LA LIBERTAD', '1205', 'PACASMAYO', '120506', 'PACASMAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1161, '12', 'DEPARTAMENTO LA LIBERTAD', '1205', 'PACASMAYO', '120508', 'SAN JOSE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1162, '12', 'DEPARTAMENTO LA LIBERTAD', '1206', 'PATAZ', '120601', 'TAYABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1163, '12', 'DEPARTAMENTO LA LIBERTAD', '1206', 'PATAZ', '120602', 'BULDIBUYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1164, '12', 'DEPARTAMENTO LA LIBERTAD', '1206', 'PATAZ', '120603', 'CHILLIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1165, '12', 'DEPARTAMENTO LA LIBERTAD', '1206', 'PATAZ', '120604', 'HUAYLILLAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1166, '12', 'DEPARTAMENTO LA LIBERTAD', '1206', 'PATAZ', '120605', 'HUANCASPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1167, '12', 'DEPARTAMENTO LA LIBERTAD', '1206', 'PATAZ', '120606', 'HUAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1168, '12', 'DEPARTAMENTO LA LIBERTAD', '1206', 'PATAZ', '120607', 'ONGON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1169, '12', 'DEPARTAMENTO LA LIBERTAD', '1206', 'PATAZ', '120608', 'PARCOY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1170, '12', 'DEPARTAMENTO LA LIBERTAD', '1206', 'PATAZ', '120609', 'PATAZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1171, '12', 'DEPARTAMENTO LA LIBERTAD', '1206', 'PATAZ', '120610', 'PIAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1172, '12', 'DEPARTAMENTO LA LIBERTAD', '1206', 'PATAZ', '120611', 'TAURIJA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1173, '12', 'DEPARTAMENTO LA LIBERTAD', '1206', 'PATAZ', '120612', 'URPAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1174, '12', 'DEPARTAMENTO LA LIBERTAD', '1206', 'PATAZ', '120613', 'SANTIAGO DE CHALLAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1175, '12', 'DEPARTAMENTO LA LIBERTAD', '1207', 'SANTIAGO DE CHUCO', '120701', 'SANTIAGO DE CHUCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1176, '12', 'DEPARTAMENTO LA LIBERTAD', '1207', 'SANTIAGO DE CHUCO', '120702', 'CACHICADAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1177, '12', 'DEPARTAMENTO LA LIBERTAD', '1207', 'SANTIAGO DE CHUCO', '120703', 'MOLLEBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1178, '12', 'DEPARTAMENTO LA LIBERTAD', '1207', 'SANTIAGO DE CHUCO', '120704', 'MOLLEPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1179, '12', 'DEPARTAMENTO LA LIBERTAD', '1207', 'SANTIAGO DE CHUCO', '120705', 'QUIRUVILCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1180, '12', 'DEPARTAMENTO LA LIBERTAD', '1207', 'SANTIAGO DE CHUCO', '120706', 'SANTA CRUZ DE CHUCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1181, '12', 'DEPARTAMENTO LA LIBERTAD', '1207', 'SANTIAGO DE CHUCO', '120707', 'SITABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1182, '12', 'DEPARTAMENTO LA LIBERTAD', '1207', 'SANTIAGO DE CHUCO', '120708', 'ANGASMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1183, '12', 'DEPARTAMENTO LA LIBERTAD', '1208', 'ASCOPE', '120801', 'ASCOPE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1184, '12', 'DEPARTAMENTO LA LIBERTAD', '1208', 'ASCOPE', '120802', 'CHICAMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1185, '12', 'DEPARTAMENTO LA LIBERTAD', '1208', 'ASCOPE', '120803', 'CHOCOPE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1186, '12', 'DEPARTAMENTO LA LIBERTAD', '1208', 'ASCOPE', '120804', 'SANTIAGO DE CAO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1187, '12', 'DEPARTAMENTO LA LIBERTAD', '1208', 'ASCOPE', '120805', 'MAGDALENA DE CAO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1188, '12', 'DEPARTAMENTO LA LIBERTAD', '1208', 'ASCOPE', '120806', 'PAIJAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1189, '12', 'DEPARTAMENTO LA LIBERTAD', '1208', 'ASCOPE', '120807', 'RAZURI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1190, '12', 'DEPARTAMENTO LA LIBERTAD', '1208', 'ASCOPE', '120808', 'CASA GRANDE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1191, '12', 'DEPARTAMENTO LA LIBERTAD', '1209', 'CHEPEN', '120901', 'CHEPEN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1192, '12', 'DEPARTAMENTO LA LIBERTAD', '1209', 'CHEPEN', '120902', 'PACANGA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1193, '12', 'DEPARTAMENTO LA LIBERTAD', '1209', 'CHEPEN', '120903', 'PUEBLO NUEVO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1194, '12', 'DEPARTAMENTO LA LIBERTAD', '1210', 'JULCAN', '121001', 'JULCAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1195, '12', 'DEPARTAMENTO LA LIBERTAD', '1210', 'JULCAN', '121002', 'CARABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1196, '12', 'DEPARTAMENTO LA LIBERTAD', '1210', 'JULCAN', '121003', 'CALAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1197, '12', 'DEPARTAMENTO LA LIBERTAD', '1210', 'JULCAN', '121004', 'HUASO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1198, '12', 'DEPARTAMENTO LA LIBERTAD', '1211', 'GRAN CHIMU', '121101', 'CASCAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1199, '12', 'DEPARTAMENTO LA LIBERTAD', '1211', 'GRAN CHIMU', '121102', 'LUCMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1200, '12', 'DEPARTAMENTO LA LIBERTAD', '1211', 'GRAN CHIMU', '121103', 'MARMOT')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1201, '12', 'DEPARTAMENTO LA LIBERTAD', '1211', 'GRAN CHIMU', '121104', 'SAYAPULLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1202, '12', 'DEPARTAMENTO LA LIBERTAD', '1212', 'VIRU', '121201', 'VIRU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1203, '12', 'DEPARTAMENTO LA LIBERTAD', '1212', 'VIRU', '121202', 'CHAO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1204, '12', 'DEPARTAMENTO LA LIBERTAD', '1212', 'VIRU', '121203', 'GUADALUPITO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1205, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130101', 'CHICLAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1206, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130102', 'CHONGOYAPE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1207, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130103', 'ETEN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1208, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130104', 'ETEN PUERTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1209, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130105', 'LAGUNAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1210, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130106', 'MONSEFU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1211, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130107', 'NUEVA ARICA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1212, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130108', 'OYOTUN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1213, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130109', 'PICSI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1214, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130110', 'PIMENTEL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1215, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130111', 'REQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1216, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130112', 'JOSE LEONARDO ORTIZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1217, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130113', 'SANTA ROSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1218, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130114', 'SANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1219, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130115', 'LA VICTORIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1220, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130116', 'CAYALTI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1221, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130117', 'PATAPO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1222, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130118', 'POMALCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1223, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130119', 'PUCALA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1224, '13', 'DEPARTAMENTO LAMBAYEQUE', '1301', 'CHICLAYO', '130120', 'TUMAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1225, '13', 'DEPARTAMENTO LAMBAYEQUE', '1302', 'FERRENAFE', '130201', 'FERRENAFE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1226, '13', 'DEPARTAMENTO LAMBAYEQUE', '1302', 'FERRENAFE', '130202', 'INCAHUASI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1227, '13', 'DEPARTAMENTO LAMBAYEQUE', '1302', 'FERRENAFE', '130203', 'CANARIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1228, '13', 'DEPARTAMENTO LAMBAYEQUE', '1302', 'FERRENAFE', '130204', 'PITIPO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1229, '13', 'DEPARTAMENTO LAMBAYEQUE', '1302', 'FERRENAFE', '130205', 'PUEBLO NUEVO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1230, '13', 'DEPARTAMENTO LAMBAYEQUE', '1302', 'FERRENAFE', '130206', 'MANUEL ANTONIO MESONES MURO');
 ","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values 
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1231, '13', 'DEPARTAMENTO LAMBAYEQUE', '1303', 'LAMBAYEQUE', '130301', 'LAMBAYEQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1232, '13', 'DEPARTAMENTO LAMBAYEQUE', '1303', 'LAMBAYEQUE', '130302', 'CHOCHOPE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1233, '13', 'DEPARTAMENTO LAMBAYEQUE', '1303', 'LAMBAYEQUE', '130303', 'ILLIMO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1234, '13', 'DEPARTAMENTO LAMBAYEQUE', '1303', 'LAMBAYEQUE', '130304', 'JAYANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1235, '13', 'DEPARTAMENTO LAMBAYEQUE', '1303', 'LAMBAYEQUE', '130305', 'MOCHUMI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1236, '13', 'DEPARTAMENTO LAMBAYEQUE', '1303', 'LAMBAYEQUE', '130306', 'MORROPE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1237, '13', 'DEPARTAMENTO LAMBAYEQUE', '1303', 'LAMBAYEQUE', '130307', 'MOTUPE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1238, '13', 'DEPARTAMENTO LAMBAYEQUE', '1303', 'LAMBAYEQUE', '130308', 'OLMOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1239, '13', 'DEPARTAMENTO LAMBAYEQUE', '1303', 'LAMBAYEQUE', '130309', 'PACORA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1240, '13', 'DEPARTAMENTO LAMBAYEQUE', '1303', 'LAMBAYEQUE', '130310', 'SALAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1241, '13', 'DEPARTAMENTO LAMBAYEQUE', '1303', 'LAMBAYEQUE', '130311', 'SAN JOSE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1242, '13', 'DEPARTAMENTO LAMBAYEQUE', '1303', 'LAMBAYEQUE', '130312', 'TUCUME')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1243, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140101', 'LIMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1244, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140102', 'ANCON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1245, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140103', 'ATE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1246, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140104', 'BRENA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1247, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140105', 'CARABAYLLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1248, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140106', 'COMAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1249, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140107', 'CHACLACAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1250, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140108', 'CHORRILLOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1251, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140109', 'LA VICTORIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1252, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140110', 'LA MOLINA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1253, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140111', 'LINCE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1254, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140112', 'LURIGANCHO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1255, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140113', 'LURIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1256, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140114', 'MAGDALENA DEL MAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1257, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140115', 'MIRAFLORES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1258, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140116', 'PACHACAMAC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1259, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140117', 'PUEBLO LIBRE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1260, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140118', 'PUCUSANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1261, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140119', 'PUENTE PIEDRA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1262, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140120', 'PUNTA HERMOSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1263, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140121', 'PUNTA NEGRA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1264, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140122', 'RIMAC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1265, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140123', 'SAN BARTOLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1266, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140124', 'SAN ISIDRO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1267, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140125', 'BARRANCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1268, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140126', 'SAN MARTIN DE PORRES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1269, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140127', 'SAN MIGUEL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1270, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140128', 'STA MARIA DEL MAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1271, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140129', 'SANTA ROSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1272, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140130', 'SANTIAGO DE SURCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1273, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140131', 'SURQUILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1274, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140132', 'VILLA MARIA DEL TRIUNFO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1275, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140133', 'JESUS MARIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1276, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140134', 'INDEPENDENCIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1277, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140135', 'EL AGUSTINO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1278, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140136', 'SAN JUAN DE MIRAFLORES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1279, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140137', 'SAN JUAN DE LURIGANCHO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1280, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140138', 'SAN LUIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1281, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140139', 'CIENEGUILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1282, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140140', 'SAN BORJA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1283, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140141', 'VILLA EL SALVADOR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1284, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140142', 'LOS OLIVOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1285, '14', 'DEPARTAMENTO LIMA', '1401', 'LIMA', '140143', 'SANTA ANITA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1286, '14', 'DEPARTAMENTO LIMA', '1402', 'CAJATAMBO', '140201', 'CAJATAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1287, '14', 'DEPARTAMENTO LIMA', '1402', 'CAJATAMBO', '140205', 'COPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1288, '14', 'DEPARTAMENTO LIMA', '1402', 'CAJATAMBO', '140206', 'GORGOR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1289, '14', 'DEPARTAMENTO LIMA', '1402', 'CAJATAMBO', '140207', 'HUANCAPON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1290, '14', 'DEPARTAMENTO LIMA', '1402', 'CAJATAMBO', '140208', 'MANAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1291, '14', 'DEPARTAMENTO LIMA', '1403', 'CANTA', '140301', 'CANTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1292, '14', 'DEPARTAMENTO LIMA', '1403', 'CANTA', '140302', 'ARAHUAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1293, '14', 'DEPARTAMENTO LIMA', '1403', 'CANTA', '140303', 'HUAMANTANGA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1294, '14', 'DEPARTAMENTO LIMA', '1403', 'CANTA', '140304', 'HUAROS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1295, '14', 'DEPARTAMENTO LIMA', '1403', 'CANTA', '140305', 'LACHAQUI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1296, '14', 'DEPARTAMENTO LIMA', '1403', 'CANTA', '140306', 'SAN BUENAVENTURA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1297, '14', 'DEPARTAMENTO LIMA', '1403', 'CANTA', '140307', 'SANTA ROSA DE QUIVES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1298, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140401', 'SAN VICENTE DE CANETE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1299, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140402', 'CALANGO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1300, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140403', 'CERRO AZUL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1301, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140404', 'COAYLLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1302, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140405', 'CHILCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1303, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140406', 'IMPERIAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1304, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140407', 'LUNAHUANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1305, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140408', 'MALA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1306, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140409', 'NUEVO IMPERIAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1307, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140410', 'PACARAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1308, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140411', 'QUILMANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1309, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140412', 'SAN ANTONIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1310, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140413', 'SAN LUIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1311, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140414', 'SANTA CRUZ DE FLORES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1312, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140415', 'ZUNIGA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1313, '14', 'DEPARTAMENTO LIMA', '1404', 'CANETE', '140416', 'ASIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1314, '14', 'DEPARTAMENTO LIMA', '1405', 'HUAURA', '140501', 'HUACHO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1315, '14', 'DEPARTAMENTO LIMA', '1405', 'HUAURA', '140502', 'AMBAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1316, '14', 'DEPARTAMENTO LIMA', '1405', 'HUAURA', '140504', 'CALETA DE CARQUIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1317, '14', 'DEPARTAMENTO LIMA', '1405', 'HUAURA', '140505', 'CHECRAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1318, '14', 'DEPARTAMENTO LIMA', '1405', 'HUAURA', '140506', 'HUALMAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1319, '14', 'DEPARTAMENTO LIMA', '1405', 'HUAURA', '140507', 'HUAURA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1320, '14', 'DEPARTAMENTO LIMA', '1405', 'HUAURA', '140508', 'LEONCIO PRADO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1321, '14', 'DEPARTAMENTO LIMA', '1405', 'HUAURA', '140509', 'PACCHO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1322, '14', 'DEPARTAMENTO LIMA', '1405', 'HUAURA', '140511', 'SANTA LEONOR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1323, '14', 'DEPARTAMENTO LIMA', '1405', 'HUAURA', '140512', 'SANTA MARIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1324, '14', 'DEPARTAMENTO LIMA', '1405', 'HUAURA', '140513', 'SAYAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1325, '14', 'DEPARTAMENTO LIMA', '1405', 'HUAURA', '140516', 'VEGUETA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1326, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140601', 'MATUCANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1327, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140602', 'ANTIOQUIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1328, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140603', 'CALLAHUANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1329, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140604', 'CARAMPOMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1330, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140605', 'CASTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1331, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140606', 'CUENCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1332, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140607', 'CHICLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1333, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140608', 'HUANZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1334, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140609', 'HUAROCHIRI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1335, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140610', 'LAHUAYTAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1336, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140611', 'LANGA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1337, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140612', 'MARIATANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1338, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140613', 'RICARDO PALMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1339, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140614', 'SAN ANDRES DE TUPICOCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1340, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140615', 'SAN ANTONIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1341, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140616', 'SAN BARTOLOME')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1342, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140617', 'SAN DAMIAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1343, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140618', 'SANGALLAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1344, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140619', 'SAN JUAN DE TANTARANCHE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1345, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140620', 'SAN LORENZO DE QUINTI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1346, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140621', 'SAN MATEO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1347, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140622', 'SAN MATEO DE OTAO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1348, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140623', 'SAN PEDRO DE HUANCAYRE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1349, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140624', 'SANTA CRUZ DE COCACHACRA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1350, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140625', 'SANTA EULALIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1351, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140626', 'SANTIAGO DE ANCHUCAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1352, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140627', 'SANTIAGO DE TUNA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1353, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140628', 'SANTO DOMINGO DE LOS OLLEROS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1354, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140629', 'SURCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1355, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140630', 'HUACHUPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1356, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140631', 'LARAOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1357, '14', 'DEPARTAMENTO LIMA', '1406', 'HUAROCHIRI', '140632', 'SAN JUAN DE IRIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1358, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140701', 'YAUYOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1359, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140702', 'ALIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1360, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140703', 'AYAUCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1361, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140704', 'AYAVIRI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1362, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140705', 'AZANGARO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1363, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140706', 'CACRA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1364, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140707', 'CARANIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1365, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140708', 'COCHAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1366, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140709', 'COLONIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1367, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140710', 'CHOCOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1368, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140711', 'HUAMPARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1369, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140712', 'HUANCAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1370, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140713', 'HUANGASCAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1371, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140714', 'HUANTAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1372, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140715', 'HUANEC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1373, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140716', 'LARAOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1374, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140717', 'LINCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1375, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140718', 'MIRAFLORES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1376, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140719', 'OMAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1377, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140720', 'QUINCHES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1378, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140721', 'QUINOCAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1379, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140722', 'SAN JOAQUIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1380, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140723', 'SAN PEDRO DE PILAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1381, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140724', 'TANTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1382, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140725', 'TAURIPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1383, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140726', 'TUPE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1384, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140727', 'TOMAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1385, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140728', 'VINAC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1386, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140729', 'VITIS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1387, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140730', 'HONGOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1388, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140731', 'MADEAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1389, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140732', 'PUTINZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1390, '14', 'DEPARTAMENTO LIMA', '1407', 'YAUYOS', '140733', 'CATAHUASI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1391, '14', 'DEPARTAMENTO LIMA', '1408', 'HUARAL', '140801', 'HUARAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1392, '14', 'DEPARTAMENTO LIMA', '1408', 'HUARAL', '140802', 'ATAVILLOS ALTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1393, '14', 'DEPARTAMENTO LIMA', '1408', 'HUARAL', '140803', 'ATAVILLOS BAJO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1394, '14', 'DEPARTAMENTO LIMA', '1408', 'HUARAL', '140804', 'AUCALLAMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1395, '14', 'DEPARTAMENTO LIMA', '1408', 'HUARAL', '140805', 'CHANCAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1396, '14', 'DEPARTAMENTO LIMA', '1408', 'HUARAL', '140806', 'IHUARI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1397, '14', 'DEPARTAMENTO LIMA', '1408', 'HUARAL', '140807', 'LAMPIAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1398, '14', 'DEPARTAMENTO LIMA', '1408', 'HUARAL', '140808', 'PACARAOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1399, '14', 'DEPARTAMENTO LIMA', '1408', 'HUARAL', '140809', 'SAN MIGUEL DE ACOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1400, '14', 'DEPARTAMENTO LIMA', '1408', 'HUARAL', '140810', 'VEINTISIETE DE NOVIEMBRE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1401, '14', 'DEPARTAMENTO LIMA', '1408', 'HUARAL', '140811', 'STA CRUZ DE ANDAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1402, '14', 'DEPARTAMENTO LIMA', '1408', 'HUARAL', '140812', 'SUMBILCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1403, '14', 'DEPARTAMENTO LIMA', '1409', 'BARRANCA', '140901', 'BARRANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1404, '14', 'DEPARTAMENTO LIMA', '1409', 'BARRANCA', '140902', 'PARAMONGA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1405, '14', 'DEPARTAMENTO LIMA', '1409', 'BARRANCA', '140903', 'PATIVILCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1406, '14', 'DEPARTAMENTO LIMA', '1409', 'BARRANCA', '140904', 'SUPE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1407, '14', 'DEPARTAMENTO LIMA', '1409', 'BARRANCA', '140905', 'SUPE PUERTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1408, '14', 'DEPARTAMENTO LIMA', '1410', 'OYON', '141001', 'OYON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1409, '14', 'DEPARTAMENTO LIMA', '1410', 'OYON', '141002', 'NAVAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1410, '14', 'DEPARTAMENTO LIMA', '1410', 'OYON', '141003', 'CAUJUL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1411, '14', 'DEPARTAMENTO LIMA', '1410', 'OYON', '141004', 'ANDAJES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1412, '14', 'DEPARTAMENTO LIMA', '1410', 'OYON', '141005', 'PACHANGARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1413, '14', 'DEPARTAMENTO LIMA', '1410', 'OYON', '141006', 'COCHAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1414, '15', 'DEPARTAMENTO LORETO', '1501', 'MAYNAS', '150101', 'IQUITOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1415, '15', 'DEPARTAMENTO LORETO', '1501', 'MAYNAS', '150102', 'ALTO NANAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1416, '15', 'DEPARTAMENTO LORETO', '1501', 'MAYNAS', '150103', 'FERNANDO LORES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1417, '15', 'DEPARTAMENTO LORETO', '1501', 'MAYNAS', '150104', 'LAS AMAZONAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1418, '15', 'DEPARTAMENTO LORETO', '1501', 'MAYNAS', '150105', 'MAZAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1419, '15', 'DEPARTAMENTO LORETO', '1501', 'MAYNAS', '150106', 'NAPO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1420, '15', 'DEPARTAMENTO LORETO', '1501', 'MAYNAS', '150107', 'PUTUMAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1421, '15', 'DEPARTAMENTO LORETO', '1501', 'MAYNAS', '150108', 'TORRES CAUSANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1422, '15', 'DEPARTAMENTO LORETO', '1501', 'MAYNAS', '150110', 'INDIANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1423, '15', 'DEPARTAMENTO LORETO', '1501', 'MAYNAS', '150111', 'PUNCHANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1424, '15', 'DEPARTAMENTO LORETO', '1501', 'MAYNAS', '150112', 'BELEN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1425, '15', 'DEPARTAMENTO LORETO', '1501', 'MAYNAS', '150113', 'SAN JUAN BAUTISTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1426, '15', 'DEPARTAMENTO LORETO', '1501', 'MAYNAS', '150114', 'TNTE MANUEL CLAVERO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1427, '15', 'DEPARTAMENTO LORETO', '1502', 'ALTO AMAZONAS', '150201', 'YURIMAGUAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1428, '15', 'DEPARTAMENTO LORETO', '1502', 'ALTO AMAZONAS', '150202', 'BALSAPUERTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1429, '15', 'DEPARTAMENTO LORETO', '1502', 'ALTO AMAZONAS', '150205', 'JEBEROS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1430, '15', 'DEPARTAMENTO LORETO', '1502', 'ALTO AMAZONAS', '150206', 'LAGUNAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1431, '15', 'DEPARTAMENTO LORETO', '1502', 'ALTO AMAZONAS', '150210', 'SANTA CRUZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1432, '15', 'DEPARTAMENTO LORETO', '1502', 'ALTO AMAZONAS', '150211', 'TNTE CESAR LOPEZ ROJAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1433, '15', 'DEPARTAMENTO LORETO', '1503', 'LORETO', '150301', 'NAUTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1434, '15', 'DEPARTAMENTO LORETO', '1503', 'LORETO', '150302', 'PARINARI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1435, '15', 'DEPARTAMENTO LORETO', '1503', 'LORETO', '150303', 'TIGRE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1436, '15', 'DEPARTAMENTO LORETO', '1503', 'LORETO', '150304', 'URARINAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1437, '15', 'DEPARTAMENTO LORETO', '1503', 'LORETO', '150305', 'TROMPETEROS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1438, '15', 'DEPARTAMENTO LORETO', '1504', 'REQUENA', '150401', 'REQUENA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1439, '15', 'DEPARTAMENTO LORETO', '1504', 'REQUENA', '150402', 'ALTO TAPICHE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1440, '15', 'DEPARTAMENTO LORETO', '1504', 'REQUENA', '150403', 'CAPELO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1441, '15', 'DEPARTAMENTO LORETO', '1504', 'REQUENA', '150404', 'EMILIO SAN MARTIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1442, '15', 'DEPARTAMENTO LORETO', '1504', 'REQUENA', '150405', 'MAQUIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1443, '15', 'DEPARTAMENTO LORETO', '1504', 'REQUENA', '150406', 'PUINAHUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1444, '15', 'DEPARTAMENTO LORETO', '1504', 'REQUENA', '150407', 'SAQUENA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1445, '15', 'DEPARTAMENTO LORETO', '1504', 'REQUENA', '150408', 'SOPLIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1446, '15', 'DEPARTAMENTO LORETO', '1504', 'REQUENA', '150409', 'TAPICHE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1447, '15', 'DEPARTAMENTO LORETO', '1504', 'REQUENA', '150410', 'JENARO HERRERA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1448, '15', 'DEPARTAMENTO LORETO', '1504', 'REQUENA', '150411', 'YAQUERANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1449, '15', 'DEPARTAMENTO LORETO', '1505', 'UCAYALI', '150501', 'CONTAMANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1450, '15', 'DEPARTAMENTO LORETO', '1505', 'UCAYALI', '150502', 'VARGAS GUERRA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1451, '15', 'DEPARTAMENTO LORETO', '1505', 'UCAYALI', '150503', 'PADRE MARQUEZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1452, '15', 'DEPARTAMENTO LORETO', '1505', 'UCAYALI', '150504', 'PAMPA HERMOZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1453, '15', 'DEPARTAMENTO LORETO', '1505', 'UCAYALI', '150505', 'SARAYACU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1454, '15', 'DEPARTAMENTO LORETO', '1505', 'UCAYALI', '150506', 'INAHUAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1455, '15', 'DEPARTAMENTO LORETO', '1506', 'MARISCAL RAMON CASTILLA', '150601', 'MARISCAL RAMON CASTILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1456, '15', 'DEPARTAMENTO LORETO', '1506', 'MARISCAL RAMON CASTILLA', '150602', 'PEBAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1457, '15', 'DEPARTAMENTO LORETO', '1506', 'MARISCAL RAMON CASTILLA', '150603', 'YAVARI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1458, '15', 'DEPARTAMENTO LORETO', '1506', 'MARISCAL RAMON CASTILLA', '150604', 'SAN PABLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1459, '15', 'DEPARTAMENTO LORETO', '1507', 'DATEM DEL MARA', '150701', 'BARRANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1460, '15', 'DEPARTAMENTO LORETO', '1507', 'DATEM DEL MARA', '150702', 'ANDOAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1461, '15', 'DEPARTAMENTO LORETO', '1507', 'DATEM DEL MARA', '150703', 'CAHUAPANAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1462, '15', 'DEPARTAMENTO LORETO', '1507', 'DATEM DEL MARA', '150704', 'MANSERICHE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1463, '15', 'DEPARTAMENTO LORETO', '1507', 'DATEM DEL MARA', '150705', 'MORONA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1464, '15', 'DEPARTAMENTO LORETO', '1507', 'DATEM DEL MARA', '150706', 'PASTAZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1465, '16', 'DEPARTAMENTO MADRE DE DIOS', '1601', 'TAMBOPATA', '160101', 'TAMBOPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1466, '16', 'DEPARTAMENTO MADRE DE DIOS', '1601', 'TAMBOPATA', '160102', 'INAMBARI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1467, '16', 'DEPARTAMENTO MADRE DE DIOS', '1601', 'TAMBOPATA', '160103', 'LAS PIEDRAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1468, '16', 'DEPARTAMENTO MADRE DE DIOS', '1601', 'TAMBOPATA', '160104', 'LABERINTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1469, '16', 'DEPARTAMENTO MADRE DE DIOS', '1602', 'MANU', '160201', 'MANU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1470, '16', 'DEPARTAMENTO MADRE DE DIOS', '1602', 'MANU', '160202', 'FITZCARRALD')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1471, '16', 'DEPARTAMENTO MADRE DE DIOS', '1602', 'MANU', '160203', 'MADRE DE DIOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1472, '16', 'DEPARTAMENTO MADRE DE DIOS', '1602', 'MANU', '160204', 'HUEPETUHE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1473, '16', 'DEPARTAMENTO MADRE DE DIOS', '1603', 'TAHUAMANU', '160301', 'INAPARI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1474, '16', 'DEPARTAMENTO MADRE DE DIOS', '1603', 'TAHUAMANU', '160302', 'IBERIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1475, '16', 'DEPARTAMENTO MADRE DE DIOS', '1603', 'TAHUAMANU', '160303', 'TAHUAMANU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1476, '17', 'DEPARTAMENTO MOQUEGUA', '1701', 'MARISCAL NIETO', '170101', 'MOQUEGUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1477, '17', 'DEPARTAMENTO MOQUEGUA', '1701', 'MARISCAL NIETO', '170102', 'CARUMAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1478, '17', 'DEPARTAMENTO MOQUEGUA', '1701', 'MARISCAL NIETO', '170103', 'CUCHUMBAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1479, '17', 'DEPARTAMENTO MOQUEGUA', '1701', 'MARISCAL NIETO', '170104', 'SAN CRISTOBAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1480, '17', 'DEPARTAMENTO MOQUEGUA', '1701', 'MARISCAL NIETO', '170105', 'TORATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1481, '17', 'DEPARTAMENTO MOQUEGUA', '1701', 'MARISCAL NIETO', '170106', 'SAMEGUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1482, '17', 'DEPARTAMENTO MOQUEGUA', '1702', 'GENERAL SANCHEZ CERRO', '170201', 'OMATE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1483, '17', 'DEPARTAMENTO MOQUEGUA', '1702', 'GENERAL SANCHEZ CERRO', '170202', 'COALAQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1484, '17', 'DEPARTAMENTO MOQUEGUA', '1702', 'GENERAL SANCHEZ CERRO', '170203', 'CHOJATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1485, '17', 'DEPARTAMENTO MOQUEGUA', '1702', 'GENERAL SANCHEZ CERRO', '170204', 'ICHUNA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1486, '17', 'DEPARTAMENTO MOQUEGUA', '1702', 'GENERAL SANCHEZ CERRO', '170205', 'LA CAPILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1487, '17', 'DEPARTAMENTO MOQUEGUA', '1702', 'GENERAL SANCHEZ CERRO', '170206', 'LLOQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1488, '17', 'DEPARTAMENTO MOQUEGUA', '1702', 'GENERAL SANCHEZ CERRO', '170207', 'MATALAQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1489, '17', 'DEPARTAMENTO MOQUEGUA', '1702', 'GENERAL SANCHEZ CERRO', '170208', 'PUQUINA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1490, '17', 'DEPARTAMENTO MOQUEGUA', '1702', 'GENERAL SANCHEZ CERRO', '170209', 'QUINISTAQUILLAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1491, '17', 'DEPARTAMENTO MOQUEGUA', '1702', 'GENERAL SANCHEZ CERRO', '170210', 'UBINAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1492, '17', 'DEPARTAMENTO MOQUEGUA', '1702', 'GENERAL SANCHEZ CERRO', '170211', 'YUNGA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1493, '17', 'DEPARTAMENTO MOQUEGUA', '1703', 'ILO', '170301', 'ILO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1494, '17', 'DEPARTAMENTO MOQUEGUA', '1703', 'ILO', '170302', 'EL ALGARROBAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1495, '17', 'DEPARTAMENTO MOQUEGUA', '1703', 'ILO', '170303', 'PACOCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1496, '18', 'DEPARTAMENTO PASCO', '1801', 'PASCO', '180101', 'CHAUPIMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1497, '18', 'DEPARTAMENTO PASCO', '1801', 'PASCO', '180103', 'HUACHON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1498, '18', 'DEPARTAMENTO PASCO', '1801', 'PASCO', '180104', 'HUARIACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1499, '18', 'DEPARTAMENTO PASCO', '1801', 'PASCO', '180105', 'HUAYLLAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1500, '18', 'DEPARTAMENTO PASCO', '1801', 'PASCO', '180106', 'NINACACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1501, '18', 'DEPARTAMENTO PASCO', '1801', 'PASCO', '180107', 'PALLANCHACRA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1502, '18', 'DEPARTAMENTO PASCO', '1801', 'PASCO', '180108', 'PAUCARTAMBO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1503, '18', 'DEPARTAMENTO PASCO', '1801', 'PASCO', '180109', 'SAN FCO DE ASIS DE YARUSYACAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1504, '18', 'DEPARTAMENTO PASCO', '1801', 'PASCO', '180110', 'SIMON BOLIVAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1505, '18', 'DEPARTAMENTO PASCO', '1801', 'PASCO', '180111', 'TICLACAYAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1506, '18', 'DEPARTAMENTO PASCO', '1801', 'PASCO', '180112', 'TINYAHUARCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1507, '18', 'DEPARTAMENTO PASCO', '1801', 'PASCO', '180113', 'VICCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1508, '18', 'DEPARTAMENTO PASCO', '1801', 'PASCO', '180114', 'YANACANCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1509, '18', 'DEPARTAMENTO PASCO', '1802', 'DANIEL ALCIDES CARRION', '180201', 'YANAHUANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1510, '18', 'DEPARTAMENTO PASCO', '1802', 'DANIEL ALCIDES CARRION', '180202', 'CHACAYAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1511, '18', 'DEPARTAMENTO PASCO', '1802', 'DANIEL ALCIDES CARRION', '180203', 'GOYLLARISQUIZGA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1512, '18', 'DEPARTAMENTO PASCO', '1802', 'DANIEL ALCIDES CARRION', '180204', 'PAUCAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1513, '18', 'DEPARTAMENTO PASCO', '1802', 'DANIEL ALCIDES CARRION', '180205', 'SAN PEDRO DE PILLAO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1514, '18', 'DEPARTAMENTO PASCO', '1802', 'DANIEL ALCIDES CARRION', '180206', 'SANTA ANA DE TUSI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1515, '18', 'DEPARTAMENTO PASCO', '1802', 'DANIEL ALCIDES CARRION', '180207', 'TAPUC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1516, '18', 'DEPARTAMENTO PASCO', '1802', 'DANIEL ALCIDES CARRION', '180208', 'VILCABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1517, '18', 'DEPARTAMENTO PASCO', '1803', 'OXAPAMPA', '180301', 'OXAPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1518, '18', 'DEPARTAMENTO PASCO', '1803', 'OXAPAMPA', '180302', 'CHONTABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1519, '18', 'DEPARTAMENTO PASCO', '1803', 'OXAPAMPA', '180303', 'HUANCABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1520, '18', 'DEPARTAMENTO PASCO', '1803', 'OXAPAMPA', '180304', 'PUERTO BERMUDEZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1521, '18', 'DEPARTAMENTO PASCO', '1803', 'OXAPAMPA', '180305', 'VILLA RICA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1522, '18', 'DEPARTAMENTO PASCO', '1803', 'OXAPAMPA', '180306', 'POZUZO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1523, '18', 'DEPARTAMENTO PASCO', '1803', 'OXAPAMPA', '180307', 'PALCAZU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1524, '19', 'DEPARTAMENTO PIURA', '1901', 'PIURA', '190101', 'PIURA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1525, '19', 'DEPARTAMENTO PIURA', '1901', 'PIURA', '190103', 'CASTILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1526, '19', 'DEPARTAMENTO PIURA', '1901', 'PIURA', '190104', 'CATACAOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1527, '19', 'DEPARTAMENTO PIURA', '1901', 'PIURA', '190105', 'LA ARENA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1528, '19', 'DEPARTAMENTO PIURA', '1901', 'PIURA', '190106', 'LA UNION')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1529, '19', 'DEPARTAMENTO PIURA', '1901', 'PIURA', '190107', 'LAS LOMAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1530, '19', 'DEPARTAMENTO PIURA', '1901', 'PIURA', '190109', 'TAMBO GRANDE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1531, '19', 'DEPARTAMENTO PIURA', '1901', 'PIURA', '190113', 'CURA MORI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1532, '19', 'DEPARTAMENTO PIURA', '1901', 'PIURA', '190114', 'EL TALLAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1533, '19', 'DEPARTAMENTO PIURA', '1902', 'AYABACA', '190201', 'AYABACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1534, '19', 'DEPARTAMENTO PIURA', '1902', 'AYABACA', '190202', 'FRIAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1535, '19', 'DEPARTAMENTO PIURA', '1902', 'AYABACA', '190203', 'LAGUNAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1536, '19', 'DEPARTAMENTO PIURA', '1902', 'AYABACA', '190204', 'MONTERO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1537, '19', 'DEPARTAMENTO PIURA', '1902', 'AYABACA', '190205', 'PACAIPAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1538, '19', 'DEPARTAMENTO PIURA', '1902', 'AYABACA', '190206', 'SAPILLICA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1539, '19', 'DEPARTAMENTO PIURA', '1902', 'AYABACA', '190207', 'SICCHEZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1540, '19', 'DEPARTAMENTO PIURA', '1902', 'AYABACA', '190208', 'SUYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1541, '19', 'DEPARTAMENTO PIURA', '1902', 'AYABACA', '190209', 'JILILI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1542, '19', 'DEPARTAMENTO PIURA', '1902', 'AYABACA', '190210', 'PAIMAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1543, '19', 'DEPARTAMENTO PIURA', '1903', 'HUANCABAMBA', '190301', 'HUANCABAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1544, '19', 'DEPARTAMENTO PIURA', '1903', 'HUANCABAMBA', '190302', 'CANCHAQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1545, '19', 'DEPARTAMENTO PIURA', '1903', 'HUANCABAMBA', '190303', 'HUARMACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1546, '19', 'DEPARTAMENTO PIURA', '1903', 'HUANCABAMBA', '190304', 'SONDOR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1547, '19', 'DEPARTAMENTO PIURA', '1903', 'HUANCABAMBA', '190305', 'SONDORILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1548, '19', 'DEPARTAMENTO PIURA', '1903', 'HUANCABAMBA', '190306', 'EL CARMEN DE LA FRONTERA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1549, '19', 'DEPARTAMENTO PIURA', '1903', 'HUANCABAMBA', '190307', 'SAN MIGUEL DE EL FAIQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1550, '19', 'DEPARTAMENTO PIURA', '1903', 'HUANCABAMBA', '190308', 'LALAQUIZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1551, '19', 'DEPARTAMENTO PIURA', '1904', 'MORROPON', '190401', 'CHULUCANAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1552, '19', 'DEPARTAMENTO PIURA', '1904', 'MORROPON', '190402', 'BUENOS AIRES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1553, '19', 'DEPARTAMENTO PIURA', '1904', 'MORROPON', '190403', 'CHALACO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1554, '19', 'DEPARTAMENTO PIURA', '1904', 'MORROPON', '190404', 'MORROPON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1555, '19', 'DEPARTAMENTO PIURA', '1904', 'MORROPON', '190405', 'SALITRAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1556, '19', 'DEPARTAMENTO PIURA', '1904', 'MORROPON', '190406', 'SANTA CATALINA DE MOSSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1557, '19', 'DEPARTAMENTO PIURA', '1904', 'MORROPON', '190407', 'SANTO DOMINGO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1558, '19', 'DEPARTAMENTO PIURA', '1904', 'MORROPON', '190408', 'LA MATANZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1559, '19', 'DEPARTAMENTO PIURA', '1904', 'MORROPON', '190409', 'YAMANGO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1560, '19', 'DEPARTAMENTO PIURA', '1904', 'MORROPON', '190410', 'SAN JUAN DE BIGOTE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1561, '19', 'DEPARTAMENTO PIURA', '1905', 'PAITA', '190501', 'PAITA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1562, '19', 'DEPARTAMENTO PIURA', '1905', 'PAITA', '190502', 'AMOTAPE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1563, '19', 'DEPARTAMENTO PIURA', '1905', 'PAITA', '190503', 'ARENAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1564, '19', 'DEPARTAMENTO PIURA', '1905', 'PAITA', '190504', 'LA HUACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1565, '19', 'DEPARTAMENTO PIURA', '1905', 'PAITA', '190505', 'PUEBLO NUEVO DE COLAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1566, '19', 'DEPARTAMENTO PIURA', '1905', 'PAITA', '190506', 'TAMARINDO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1567, '19', 'DEPARTAMENTO PIURA', '1905', 'PAITA', '190507', 'VICHAYAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1568, '19', 'DEPARTAMENTO PIURA', '1906', 'SULLANA', '190601', 'SULLANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1569, '19', 'DEPARTAMENTO PIURA', '1906', 'SULLANA', '190602', 'BELLAVISTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1570, '19', 'DEPARTAMENTO PIURA', '1906', 'SULLANA', '190603', 'LANCONES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1571, '19', 'DEPARTAMENTO PIURA', '1906', 'SULLANA', '190604', 'MARCAVELICA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1572, '19', 'DEPARTAMENTO PIURA', '1906', 'SULLANA', '190605', 'MIGUEL CHECA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1573, '19', 'DEPARTAMENTO PIURA', '1906', 'SULLANA', '190606', 'QUERECOTILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1574, '19', 'DEPARTAMENTO PIURA', '1906', 'SULLANA', '190607', 'SALITRAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1575, '19', 'DEPARTAMENTO PIURA', '1906', 'SULLANA', '190608', 'IGNACIO ESCUDERO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1576, '19', 'DEPARTAMENTO PIURA', '1907', 'TALARA', '190701', 'PARINAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1577, '19', 'DEPARTAMENTO PIURA', '1907', 'TALARA', '190702', 'EL ALTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1578, '19', 'DEPARTAMENTO PIURA', '1907', 'TALARA', '190703', 'LA BREA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1579, '19', 'DEPARTAMENTO PIURA', '1907', 'TALARA', '190704', 'LOBITOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1580, '19', 'DEPARTAMENTO PIURA', '1907', 'TALARA', '190705', 'MANCORA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1581, '19', 'DEPARTAMENTO PIURA', '1907', 'TALARA', '190706', 'LOS ORGANOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1582, '19', 'DEPARTAMENTO PIURA', '1908', 'SECHURA', '190801', 'SECHURA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1583, '19', 'DEPARTAMENTO PIURA', '1908', 'SECHURA', '190802', 'VICE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1584, '19', 'DEPARTAMENTO PIURA', '1908', 'SECHURA', '190803', 'BERNAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1585, '19', 'DEPARTAMENTO PIURA', '1908', 'SECHURA', '190804', 'BELLAVISTA DE LA UNION')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1586, '19', 'DEPARTAMENTO PIURA', '1908', 'SECHURA', '190805', 'CRISTO NOS VALGA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1587, '19', 'DEPARTAMENTO PIURA', '1908', 'SECHURA', '190806', 'RINCONADA LLICUAR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1588, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200101', 'PUNO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1589, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200102', 'ACORA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1590, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200103', 'ATUNCOLLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1591, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200104', 'CAPACHICA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1592, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200105', 'COATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1593, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200106', 'CHUCUITO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1594, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200107', 'HUATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1595, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200108', 'MANAZO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1596, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200109', 'PAUCARCOLLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1597, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200110', 'PICHACANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1598, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200111', 'SAN ANTONIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1599, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200112', 'TIQUILLACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1600, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200113', 'VILQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1601, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200114', 'PLATERIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1602, '20', 'DEPARTAMENTO PUNO', '2001', 'PUNO', '200115', 'AMANTANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1603, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200201', 'AZANGARO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1604, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200202', 'ACHAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1605, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200203', 'ARAPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1606, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200204', 'ASILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1607, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200205', 'CAMINACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1608, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200206', 'CHUPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1609, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200207', 'JOSE DOMINGO CHOQUEHUANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1610, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200208', 'MUNANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1611, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200210', 'POTONI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1612, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200212', 'SAMAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1613, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200213', 'SAN ANTON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1614, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200214', 'SAN JOSE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1615, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200215', 'SAN JUAN DE SALINAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1616, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200216', 'STGO DE PUPUJA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1617, '20', 'DEPARTAMENTO PUNO', '2002', 'AZANGARO', '200217', 'TIRAPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1618, '20', 'DEPARTAMENTO PUNO', '2003', 'CARABAYA', '200301', 'MACUSANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1619, '20', 'DEPARTAMENTO PUNO', '2003', 'CARABAYA', '200302', 'AJOYANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1620, '20', 'DEPARTAMENTO PUNO', '2003', 'CARABAYA', '200303', 'AYAPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1621, '20', 'DEPARTAMENTO PUNO', '2003', 'CARABAYA', '200304', 'COASA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1622, '20', 'DEPARTAMENTO PUNO', '2003', 'CARABAYA', '200305', 'CORANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1623, '20', 'DEPARTAMENTO PUNO', '2003', 'CARABAYA', '200306', 'CRUCERO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1624, '20', 'DEPARTAMENTO PUNO', '2003', 'CARABAYA', '200307', 'ITUATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1625, '20', 'DEPARTAMENTO PUNO', '2003', 'CARABAYA', '200308', 'OLLACHEA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1626, '20', 'DEPARTAMENTO PUNO', '2003', 'CARABAYA', '200309', 'SAN GABAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1627, '20', 'DEPARTAMENTO PUNO', '2003', 'CARABAYA', '200310', 'USICAYOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1628, '20', 'DEPARTAMENTO PUNO', '2004', 'CHUCUITO', '200401', 'JULI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1629, '20', 'DEPARTAMENTO PUNO', '2004', 'CHUCUITO', '200402', 'DESAGUADERO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1630, '20', 'DEPARTAMENTO PUNO', '2004', 'CHUCUITO', '200403', 'HUACULLANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1631, '20', 'DEPARTAMENTO PUNO', '2004', 'CHUCUITO', '200406', 'PISACOMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1632, '20', 'DEPARTAMENTO PUNO', '2004', 'CHUCUITO', '200407', 'POMATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1633, '20', 'DEPARTAMENTO PUNO', '2004', 'CHUCUITO', '200410', 'ZEPITA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1634, '20', 'DEPARTAMENTO PUNO', '2004', 'CHUCUITO', '200412', 'KELLUYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1635, '20', 'DEPARTAMENTO PUNO', '2005', 'HUANCANE', '200501', 'HUANCANE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1636, '20', 'DEPARTAMENTO PUNO', '2005', 'HUANCANE', '200502', 'COJATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1637, '20', 'DEPARTAMENTO PUNO', '2005', 'HUANCANE', '200504', 'INCHUPALLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1638, '20', 'DEPARTAMENTO PUNO', '2005', 'HUANCANE', '200506', 'PUSI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1639, '20', 'DEPARTAMENTO PUNO', '2005', 'HUANCANE', '200507', 'ROSASPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1640, '20', 'DEPARTAMENTO PUNO', '2005', 'HUANCANE', '200508', 'TARACO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1641, '20', 'DEPARTAMENTO PUNO', '2005', 'HUANCANE', '200509', 'VILQUE CHICO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1642, '20', 'DEPARTAMENTO PUNO', '2005', 'HUANCANE', '200511', 'HUATASANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1643, '20', 'DEPARTAMENTO PUNO', '2006', 'LAMPA', '200601', 'LAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1644, '20', 'DEPARTAMENTO PUNO', '2006', 'LAMPA', '200602', 'CABANILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1645, '20', 'DEPARTAMENTO PUNO', '2006', 'LAMPA', '200603', 'CALAPUJA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1646, '20', 'DEPARTAMENTO PUNO', '2006', 'LAMPA', '200604', 'NICASIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1647, '20', 'DEPARTAMENTO PUNO', '2006', 'LAMPA', '200605', 'OCUVIRI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1648, '20', 'DEPARTAMENTO PUNO', '2006', 'LAMPA', '200606', 'PALCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1649, '20', 'DEPARTAMENTO PUNO', '2006', 'LAMPA', '200607', 'PARATIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1650, '20', 'DEPARTAMENTO PUNO', '2006', 'LAMPA', '200608', 'PUCARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1651, '20', 'DEPARTAMENTO PUNO', '2006', 'LAMPA', '200609', 'SANTA LUCIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1652, '20', 'DEPARTAMENTO PUNO', '2006', 'LAMPA', '200610', 'VILAVILA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1653, '20', 'DEPARTAMENTO PUNO', '2007', 'MELGAR', '200701', 'AYAVIRI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1654, '20', 'DEPARTAMENTO PUNO', '2007', 'MELGAR', '200702', 'ANTAUTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1655, '20', 'DEPARTAMENTO PUNO', '2007', 'MELGAR', '200703', 'CUPI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1656, '20', 'DEPARTAMENTO PUNO', '2007', 'MELGAR', '200704', 'LLALLI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1657, '20', 'DEPARTAMENTO PUNO', '2007', 'MELGAR', '200705', 'MACARI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1658, '20', 'DEPARTAMENTO PUNO', '2007', 'MELGAR', '200706', 'NUNOA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1659, '20', 'DEPARTAMENTO PUNO', '2007', 'MELGAR', '200707', 'ORURILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1660, '20', 'DEPARTAMENTO PUNO', '2007', 'MELGAR', '200708', 'SANTA ROSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1661, '20', 'DEPARTAMENTO PUNO', '2007', 'MELGAR', '200709', 'UMACHIRI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1662, '20', 'DEPARTAMENTO PUNO', '2008', 'SANDIA', '200801', 'SANDIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1663, '20', 'DEPARTAMENTO PUNO', '2008', 'SANDIA', '200803', 'CUYOCUYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1664, '20', 'DEPARTAMENTO PUNO', '2008', 'SANDIA', '200804', 'LIMBANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1665, '20', 'DEPARTAMENTO PUNO', '2008', 'SANDIA', '200805', 'PHARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1666, '20', 'DEPARTAMENTO PUNO', '2008', 'SANDIA', '200806', 'PATAMBUCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1667, '20', 'DEPARTAMENTO PUNO', '2008', 'SANDIA', '200807', 'QUIACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1668, '20', 'DEPARTAMENTO PUNO', '2008', 'SANDIA', '200808', 'SAN JUAN DEL ORO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1669, '20', 'DEPARTAMENTO PUNO', '2008', 'SANDIA', '200810', 'YANAHUAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1670, '20', 'DEPARTAMENTO PUNO', '2008', 'SANDIA', '200811', 'ALTO INAMBARI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1671, '20', 'DEPARTAMENTO PUNO', '2008', 'SANDIA', '200812', 'SAN PEDRO DE PUTINA PUNCO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1672, '20', 'DEPARTAMENTO PUNO', '2009', 'SAN ROMAN', '200901', 'JULIACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1673, '20', 'DEPARTAMENTO PUNO', '2009', 'SAN ROMAN', '200902', 'CABANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1674, '20', 'DEPARTAMENTO PUNO', '2009', 'SAN ROMAN', '200903', 'CABANILLAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1675, '20', 'DEPARTAMENTO PUNO', '2009', 'SAN ROMAN', '200904', 'CARACOTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1676, '20', 'DEPARTAMENTO PUNO', '2010', 'YUNGUYO', '201001', 'YUNGUYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1677, '20', 'DEPARTAMENTO PUNO', '2010', 'YUNGUYO', '201002', 'UNICACHI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1678, '20', 'DEPARTAMENTO PUNO', '2010', 'YUNGUYO', '201003', 'ANAPIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1679, '20', 'DEPARTAMENTO PUNO', '2010', 'YUNGUYO', '201004', 'COPANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1680, '20', 'DEPARTAMENTO PUNO', '2010', 'YUNGUYO', '201005', 'CUTURAPI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1681, '20', 'DEPARTAMENTO PUNO', '2010', 'YUNGUYO', '201006', 'OLLARAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1682, '20', 'DEPARTAMENTO PUNO', '2010', 'YUNGUYO', '201007', 'TINICACHI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1683, '20', 'DEPARTAMENTO PUNO', '2011', 'SAN ANTONIO DE PUTINA', '201101', 'PUTINA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1684, '20', 'DEPARTAMENTO PUNO', '2011', 'SAN ANTONIO DE PUTINA', '201102', 'PEDRO VILCA APAZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1685, '20', 'DEPARTAMENTO PUNO', '2011', 'SAN ANTONIO DE PUTINA', '201103', 'QUILCA PUNCU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1686, '20', 'DEPARTAMENTO PUNO', '2011', 'SAN ANTONIO DE PUTINA', '201104', 'ANANEA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1687, '20', 'DEPARTAMENTO PUNO', '2011', 'SAN ANTONIO DE PUTINA', '201105', 'SINA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1688, '20', 'DEPARTAMENTO PUNO', '2012', 'EL COLLAO', '201201', 'ILAVE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1689, '20', 'DEPARTAMENTO PUNO', '2012', 'EL COLLAO', '201202', 'PILCUYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1690, '20', 'DEPARTAMENTO PUNO', '2012', 'EL COLLAO', '201203', 'SANTA ROSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1691, '20', 'DEPARTAMENTO PUNO', '2012', 'EL COLLAO', '201204', 'CAPASO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1692, '20', 'DEPARTAMENTO PUNO', '2012', 'EL COLLAO', '201205', 'CONDURIRI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1693, '20', 'DEPARTAMENTO PUNO', '2013', 'MOHO', '201301', 'MOHO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1694, '20', 'DEPARTAMENTO PUNO', '2013', 'MOHO', '201302', 'CONIMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1695, '20', 'DEPARTAMENTO PUNO', '2013', 'MOHO', '201303', 'TILALI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1696, '20', 'DEPARTAMENTO PUNO', '2013', 'MOHO', '201304', 'HUAYRAPATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1697, '21', 'DEPARTAMENTO SAN MARTIN', '2101', 'MOYOBAMBA', '210101', 'MOYOBAMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1698, '21', 'DEPARTAMENTO SAN MARTIN', '2101', 'MOYOBAMBA', '210102', 'CALZADA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1699, '21', 'DEPARTAMENTO SAN MARTIN', '2101', 'MOYOBAMBA', '210103', 'HABANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1700, '21', 'DEPARTAMENTO SAN MARTIN', '2101', 'MOYOBAMBA', '210104', 'JEPELACIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1701, '21', 'DEPARTAMENTO SAN MARTIN', '2101', 'MOYOBAMBA', '210105', 'SORITOR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1702, '21', 'DEPARTAMENTO SAN MARTIN', '2101', 'MOYOBAMBA', '210106', 'YANTALO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1703, '21', 'DEPARTAMENTO SAN MARTIN', '2102', 'HUALLAGA', '210201', 'SAPOSOA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1704, '21', 'DEPARTAMENTO SAN MARTIN', '2102', 'HUALLAGA', '210202', 'PISCOYACU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1705, '21', 'DEPARTAMENTO SAN MARTIN', '2102', 'HUALLAGA', '210203', 'SACANCHE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1706, '21', 'DEPARTAMENTO SAN MARTIN', '2102', 'HUALLAGA', '210204', 'TINGO DE SAPOSOA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1707, '21', 'DEPARTAMENTO SAN MARTIN', '2102', 'HUALLAGA', '210205', 'ALTO SAPOSOA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1708, '21', 'DEPARTAMENTO SAN MARTIN', '2102', 'HUALLAGA', '210206', 'EL ESLABON')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1709, '21', 'DEPARTAMENTO SAN MARTIN', '2103', 'LAMAS', '210301', 'LAMAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1710, '21', 'DEPARTAMENTO SAN MARTIN', '2103', 'LAMAS', '210303', 'BARRANQUITA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1711, '21', 'DEPARTAMENTO SAN MARTIN', '2103', 'LAMAS', '210304', 'CAYNARACHI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1712, '21', 'DEPARTAMENTO SAN MARTIN', '2103', 'LAMAS', '210305', 'CUNUMBUQUI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1713, '21', 'DEPARTAMENTO SAN MARTIN', '2103', 'LAMAS', '210306', 'PINTO RECODO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1714, '21', 'DEPARTAMENTO SAN MARTIN', '2103', 'LAMAS', '210307', 'RUMISAPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1715, '21', 'DEPARTAMENTO SAN MARTIN', '2103', 'LAMAS', '210311', 'SHANAO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1716, '21', 'DEPARTAMENTO SAN MARTIN', '2103', 'LAMAS', '210313', 'TABALOSOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1717, '21', 'DEPARTAMENTO SAN MARTIN', '2103', 'LAMAS', '210314', 'ZAPATERO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1718, '21', 'DEPARTAMENTO SAN MARTIN', '2103', 'LAMAS', '210315', 'ALONSO DE ALVARADO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1719, '21', 'DEPARTAMENTO SAN MARTIN', '2103', 'LAMAS', '210316', 'SAN ROQUE DE CUMBAZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1720, '21', 'DEPARTAMENTO SAN MARTIN', '2104', 'MARISCAL CACERES', '210401', 'JUANJUI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1721, '21', 'DEPARTAMENTO SAN MARTIN', '2104', 'MARISCAL CACERES', '210402', 'CAMPANILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1722, '21', 'DEPARTAMENTO SAN MARTIN', '2104', 'MARISCAL CACERES', '210403', 'HUICUNGO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1723, '21', 'DEPARTAMENTO SAN MARTIN', '2104', 'MARISCAL CACERES', '210404', 'PACHIZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1724, '21', 'DEPARTAMENTO SAN MARTIN', '2104', 'MARISCAL CACERES', '210405', 'PAJARILLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1725, '21', 'DEPARTAMENTO SAN MARTIN', '2105', 'RIOJA', '210501', 'RIOJA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1726, '21', 'DEPARTAMENTO SAN MARTIN', '2105', 'RIOJA', '210502', 'POSIC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1727, '21', 'DEPARTAMENTO SAN MARTIN', '2105', 'RIOJA', '210503', 'YORONGOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1728, '21', 'DEPARTAMENTO SAN MARTIN', '2105', 'RIOJA', '210504', 'YURACYACU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1729, '21', 'DEPARTAMENTO SAN MARTIN', '2105', 'RIOJA', '210505', 'NUEVA CAJAMARCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1730, '21', 'DEPARTAMENTO SAN MARTIN', '2105', 'RIOJA', '210506', 'ELIAS SOPLIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1731, '21', 'DEPARTAMENTO SAN MARTIN', '2105', 'RIOJA', '210507', 'SAN FERNANDO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1732, '21', 'DEPARTAMENTO SAN MARTIN', '2105', 'RIOJA', '210508', 'PARDO MIGUEL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1733, '21', 'DEPARTAMENTO SAN MARTIN', '2105', 'RIOJA', '210509', 'AWAJUN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1734, '21', 'DEPARTAMENTO SAN MARTIN', '2106', 'SAN MARTIN', '210601', 'TARAPOTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1735, '21', 'DEPARTAMENTO SAN MARTIN', '2106', 'SAN MARTIN', '210602', 'ALBERTO LEVEAU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1736, '21', 'DEPARTAMENTO SAN MARTIN', '2106', 'SAN MARTIN', '210604', 'CACATACHI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1737, '21', 'DEPARTAMENTO SAN MARTIN', '2106', 'SAN MARTIN', '210606', 'CHAZUTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1738, '21', 'DEPARTAMENTO SAN MARTIN', '2106', 'SAN MARTIN', '210607', 'CHIPURANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1739, '21', 'DEPARTAMENTO SAN MARTIN', '2106', 'SAN MARTIN', '210608', 'EL PORVENIR')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1740, '21', 'DEPARTAMENTO SAN MARTIN', '2106', 'SAN MARTIN', '210609', 'HUIMBAYOC')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1741, '21', 'DEPARTAMENTO SAN MARTIN', '2106', 'SAN MARTIN', '210610', 'JUAN GUERRA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1742, '21', 'DEPARTAMENTO SAN MARTIN', '2106', 'SAN MARTIN', '210611', 'MORALES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1743, '21', 'DEPARTAMENTO SAN MARTIN', '2106', 'SAN MARTIN', '210612', 'PAPAPLAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1744, '21', 'DEPARTAMENTO SAN MARTIN', '2106', 'SAN MARTIN', '210616', 'SAN ANTONIO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1745, '21', 'DEPARTAMENTO SAN MARTIN', '2106', 'SAN MARTIN', '210619', 'SAUCE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1746, '21', 'DEPARTAMENTO SAN MARTIN', '2106', 'SAN MARTIN', '210620', 'SHAPAJA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1747, '21', 'DEPARTAMENTO SAN MARTIN', '2106', 'SAN MARTIN', '210621', 'LA BANDA DE SHILCAYO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1748, '21', 'DEPARTAMENTO SAN MARTIN', '2107', 'BELLAVISTA', '210701', 'BELLAVISTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1749, '21', 'DEPARTAMENTO SAN MARTIN', '2107', 'BELLAVISTA', '210702', 'SAN RAFAEL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1750, '21', 'DEPARTAMENTO SAN MARTIN', '2107', 'BELLAVISTA', '210703', 'SAN PABLO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1751, '21', 'DEPARTAMENTO SAN MARTIN', '2107', 'BELLAVISTA', '210704', 'ALTO BIAVO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1752, '21', 'DEPARTAMENTO SAN MARTIN', '2107', 'BELLAVISTA', '210705', 'HUALLAGA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1753, '21', 'DEPARTAMENTO SAN MARTIN', '2107', 'BELLAVISTA', '210706', 'BAJO BIAVO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1754, '21', 'DEPARTAMENTO SAN MARTIN', '2108', 'TOCACHE', '210801', 'TOCACHE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1755, '21', 'DEPARTAMENTO SAN MARTIN', '2108', 'TOCACHE', '210802', 'NUEVO PROGRESO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1756, '21', 'DEPARTAMENTO SAN MARTIN', '2108', 'TOCACHE', '210803', 'POLVORA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1757, '21', 'DEPARTAMENTO SAN MARTIN', '2108', 'TOCACHE', '210804', 'SHUNTE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1758, '21', 'DEPARTAMENTO SAN MARTIN', '2108', 'TOCACHE', '210805', 'UCHIZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1759, '21', 'DEPARTAMENTO SAN MARTIN', '2109', 'PICOTA', '210901', 'PICOTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1760, '21', 'DEPARTAMENTO SAN MARTIN', '2109', 'PICOTA', '210902', 'BUENOS AIRES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1761, '21', 'DEPARTAMENTO SAN MARTIN', '2109', 'PICOTA', '210903', 'CASPIZAPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1762, '21', 'DEPARTAMENTO SAN MARTIN', '2109', 'PICOTA', '210904', 'PILLUANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1763, '21', 'DEPARTAMENTO SAN MARTIN', '2109', 'PICOTA', '210905', 'PUCACACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1764, '21', 'DEPARTAMENTO SAN MARTIN', '2109', 'PICOTA', '210906', 'SAN CRISTOBAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1765, '21', 'DEPARTAMENTO SAN MARTIN', '2109', 'PICOTA', '210907', 'SAN HILARION')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1766, '21', 'DEPARTAMENTO SAN MARTIN', '2109', 'PICOTA', '210908', 'TINGO DE PONASA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1767, '21', 'DEPARTAMENTO SAN MARTIN', '2109', 'PICOTA', '210909', 'TRES UNIDOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1768, '21', 'DEPARTAMENTO SAN MARTIN', '2109', 'PICOTA', '210910', 'SHAMBOYACU')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1769, '21', 'DEPARTAMENTO SAN MARTIN', '2110', 'EL DORADO', '211001', 'SAN JOSE DE SISA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1770, '21', 'DEPARTAMENTO SAN MARTIN', '2110', 'EL DORADO', '211002', 'AGUA BLANCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1771, '21', 'DEPARTAMENTO SAN MARTIN', '2110', 'EL DORADO', '211003', 'SHATOJA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1772, '21', 'DEPARTAMENTO SAN MARTIN', '2110', 'EL DORADO', '211004', 'SAN MARTIN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1773, '21', 'DEPARTAMENTO SAN MARTIN', '2110', 'EL DORADO', '211005', 'SANTA ROSA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1774, '22', 'DEPARTAMENTO TACNA', '2201', 'TACNA', '220101', 'TACNA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1775, '22', 'DEPARTAMENTO TACNA', '2201', 'TACNA', '220102', 'CALANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1776, '22', 'DEPARTAMENTO TACNA', '2201', 'TACNA', '220104', 'INCLAN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1777, '22', 'DEPARTAMENTO TACNA', '2201', 'TACNA', '220107', 'PACHIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1778, '22', 'DEPARTAMENTO TACNA', '2201', 'TACNA', '220108', 'PALCA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1779, '22', 'DEPARTAMENTO TACNA', '2201', 'TACNA', '220109', 'POCOLLAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1780, '22', 'DEPARTAMENTO TACNA', '2201', 'TACNA', '220110', 'SAMA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1781, '22', 'DEPARTAMENTO TACNA', '2201', 'TACNA', '220111', 'ALTO DE LA ALIANZA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1782, '22', 'DEPARTAMENTO TACNA', '2201', 'TACNA', '220112', 'CIUDAD NUEVA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1783, '22', 'DEPARTAMENTO TACNA', '2201', 'TACNA', '220113', 'CORONEL GREGORIO ALBARRACIN L.ALFONSO UGARTE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1784, '22', 'DEPARTAMENTO TACNA', '2202', 'TARATA', '220201', 'TARATA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1785, '22', 'DEPARTAMENTO TACNA', '2202', 'TARATA', '220205', 'CHUCATAMANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1786, '22', 'DEPARTAMENTO TACNA', '2202', 'TARATA', '220206', 'ESTIQUE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1787, '22', 'DEPARTAMENTO TACNA', '2202', 'TARATA', '220207', 'ESTIQUE PAMPA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1788, '22', 'DEPARTAMENTO TACNA', '2202', 'TARATA', '220210', 'SITAJARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1789, '22', 'DEPARTAMENTO TACNA', '2202', 'TARATA', '220211', 'SUSAPAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1790, '22', 'DEPARTAMENTO TACNA', '2202', 'TARATA', '220212', 'TARUCACHI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1791, '22', 'DEPARTAMENTO TACNA', '2202', 'TARATA', '220213', 'TICACO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1792, '22', 'DEPARTAMENTO TACNA', '2203', 'JORGE BASADRE', '220301', 'LOCUMBA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1793, '22', 'DEPARTAMENTO TACNA', '2203', 'JORGE BASADRE', '220302', 'ITE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1794, '22', 'DEPARTAMENTO TACNA', '2203', 'JORGE BASADRE', '220303', 'ILABAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1795, '22', 'DEPARTAMENTO TACNA', '2204', 'CANDARAVE', '220401', 'CANDARAVE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1796, '22', 'DEPARTAMENTO TACNA', '2204', 'CANDARAVE', '220402', 'CAIRANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1797, '22', 'DEPARTAMENTO TACNA', '2204', 'CANDARAVE', '220403', 'CURIBAYA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1798, '22', 'DEPARTAMENTO TACNA', '2204', 'CANDARAVE', '220404', 'HUANUARA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1799, '22', 'DEPARTAMENTO TACNA', '2204', 'CANDARAVE', '220405', 'QUILAHUANI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1800, '22', 'DEPARTAMENTO TACNA', '2204', 'CANDARAVE', '220406', 'CAMILACA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1801, '23', 'DEPARTAMENTO TUMBES', '2301', 'TUMBES', '230101', 'TUMBES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1802, '23', 'DEPARTAMENTO TUMBES', '2301', 'TUMBES', '230102', 'CORRALES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1803, '23', 'DEPARTAMENTO TUMBES', '2301', 'TUMBES', '230103', 'LA CRUZ')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1804, '23', 'DEPARTAMENTO TUMBES', '2301', 'TUMBES', '230104', 'PAMPAS DE HOSPITAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1805, '23', 'DEPARTAMENTO TUMBES', '2301', 'TUMBES', '230105', 'SAN JACINTO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1806, '23', 'DEPARTAMENTO TUMBES', '2301', 'TUMBES', '230106', 'SAN JUAN DE LA VIRGEN')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1807, '23', 'DEPARTAMENTO TUMBES', '2302', 'CONTRALMIRANTE VILLAR', '230201', 'ZORRITOS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1808, '23', 'DEPARTAMENTO TUMBES', '2302', 'CONTRALMIRANTE VILLAR', '230202', 'CASITAS')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1809, '23', 'DEPARTAMENTO TUMBES', '2302', 'CONTRALMIRANTE VILLAR', '230203', 'CANOAS DE PUNTA SAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1810, '23', 'DEPARTAMENTO TUMBES', '2303', 'ZARUMILLA', '230301', 'ZARUMILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1811, '23', 'DEPARTAMENTO TUMBES', '2303', 'ZARUMILLA', '230302', 'MATAPALO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1812, '23', 'DEPARTAMENTO TUMBES', '2303', 'ZARUMILLA', '230303', 'PAPAYAL')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1813, '23', 'DEPARTAMENTO TUMBES', '2303', 'ZARUMILLA', '230304', 'AGUAS VERDES')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1814, '24', 'PROV. CONST. DEL CALLAO', '2401', 'CALLAO', '240101', 'CALLAO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1815, '24', 'PROV. CONST. DEL CALLAO', '2401', 'CALLAO', '240102', 'BELLAVISTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1816, '24', 'PROV. CONST. DEL CALLAO', '2401', 'CALLAO', '240103', 'LA PUNTA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1817, '24', 'PROV. CONST. DEL CALLAO', '2401', 'CALLAO', '240104', 'CARMEN DE LA LEGUA-REYNOSO')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1818, '24', 'PROV. CONST. DEL CALLAO', '2401', 'CALLAO', '240105', 'LA PERLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1819, '24', 'PROV. CONST. DEL CALLAO', '2401', 'CALLAO', '240106', 'VENTANILLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1820, '25', 'DEPARTAMENTO UCAYALI', '2501', 'CORONEL PORTILLO', '250101', 'CALLERIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1821, '25', 'DEPARTAMENTO UCAYALI', '2501', 'CORONEL PORTILLO', '250102', 'YARINACOCHA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1822, '25', 'DEPARTAMENTO UCAYALI', '2501', 'CORONEL PORTILLO', '250103', 'MASISEA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1823, '25', 'DEPARTAMENTO UCAYALI', '2501', 'CORONEL PORTILLO', '250104', 'CAMPOVERDE')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1824, '25', 'DEPARTAMENTO UCAYALI', '2501', 'CORONEL PORTILLO', '250105', 'IPARIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1825, '25', 'DEPARTAMENTO UCAYALI', '2501', 'CORONEL PORTILLO', '250106', 'NUEVA REQUENA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1826, '25', 'DEPARTAMENTO UCAYALI', '2501', 'CORONEL PORTILLO', '250107', 'MANANTAY')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1827, '25', 'DEPARTAMENTO UCAYALI', '2502', 'PADRE ABAD', '250201', 'PADRE ABAD')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1828, '25', 'DEPARTAMENTO UCAYALI', '2502', 'PADRE ABAD', '250202', 'YRAZOLA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1829, '25', 'DEPARTAMENTO UCAYALI', '2502', 'PADRE ABAD', '250203', 'CURIMANA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1830, '25', 'DEPARTAMENTO UCAYALI', '2503', 'ATALAYA', '250301', 'RAIMONDI')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1831, '25', 'DEPARTAMENTO UCAYALI', '2503', 'ATALAYA', '250302', 'TAHUANIA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1832, '25', 'DEPARTAMENTO UCAYALI', '2503', 'ATALAYA', '250303', 'YURUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1833, '25', 'DEPARTAMENTO UCAYALI', '2503', 'ATALAYA', '250304', 'SEPAHUA')","
","INSERT INTO Ubigeo (Id, CodDept, NomDept, CodProv, NomProv, CodDist, NomDist) values  (1834, '25', 'DEPARTAMENTO UCAYALI', '2504', 'PURUS', '250401', 'PURUS')"];
foreach ($Ubigeo as $key => $value) {
    $x->executeQuery($value);
}
/*
$tabla="CarEgresoSalud";
$x->dropTable("drop table ".$tabla);
$mdl->createTable("create table CarEgresoSalud
(
Salud_Egreso_Id int not null primary key,
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
Especificar  	varchar(200),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
");*/
 //$mdl->createTable ("Create sequence CarEgresoSaludS");
   /* $mdl->createTable ("drop sequence seq_Carproblematica_familiar");
    */
    //$x->deleteDataNoWhere("pam_nivel_educativo");
    /*
print_r($x->executeQuery("insert into Cardesempeno_academico (id,nombre,fecha_creacion,Usuario_Crea,Usuario_Edita) values(1,'SI, sobresaliente',sysdate,1,1)"));
print_r($x->executeQuery("insert into Cardesempeno_academico (id,nombre,fecha_creacion,Usuario_Crea,Usuario_Edita) values(2,'Si, satisfactorio',sysdate,1,1)"));
print_r($x->executeQuery("insert into Cardesempeno_academico (id,nombre,fecha_creacion,Usuario_Crea,Usuario_Edita) values(3,'NO',sysdate,1,1)"));
print_r($x->executeQuery("insert into Cardesempeno_academico (id,nombre,fecha_creacion,Usuario_Crea,Usuario_Edita) values(4,'No, insatisfactorio',sysdate,1,1)"))
print_r($x->executeQuery("SELECT * FROM CarEgresoPsicologico WHERE RESIDENTE_ID = 1 AND ESTADO=1"));
die();*/
/*
$arr = ['create table CarCentroServicio
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Cod_Entidad char(6),
Nom_Entidad varchar(50),
Cod_Linea  char(6),
Linea_Intervencion varchar(250),
Cod_Servicio 	char(6),
Nom_Servicio 	varchar(200),
Ubigeo_Ine int,
Departamento_CAtencion int,
Provincia_CAtencion int,
Distrito_CAtencion 	int,
Centro_Poblado     	int,
Centro_Residencia  	varchar(10),
Cod_CentroAtencion 	char(6),
Nom_CentroAtencion 	varchar(200),
Fecha_Registro     	date,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)','
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
print_r($x->executeQuery("delete from modulos"));
$arr = ["insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(1,1,1,0,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','ACOGIDA',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(2,1,1,1,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DIAGNÓSTICO',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(3,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DEL CENTRO DE SERVICIOS',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(4,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DE IDENTIFICACIÓN DEL USUARIO',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(5,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DE ADMISIÓN DEL USUARIO',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(6,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DE CONDICIONES DE INGRESO DEL USUARIO',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(7,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DE SALUD Y NUTRICIÓN DEL USUARIO',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(8,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','SALUD MENTAL',0,1,'18-DEC-28',1,1)",

"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(9,1,1,0,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DESARROLLO O CONVIVENCIA',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(10,1,1,9,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','SEGUIMIENTO (MENSUAL)',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(11,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','TERAPIA',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(12,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Actividades Técnico - Productivas',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(13,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Atención Psicológica',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(14,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','FORTALECIMIENTO DE CAPACIDADES',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(15,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Atención en Trabajo Social ',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(16,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Atenciones en Salud',0,1,'18-DEC-28',1,1)",

"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(17,1,1,9,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','SEGUIMIENTO (SEMESTRAL)',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(18,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Psicológico',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(19,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Educación',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(20,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Salud',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(21,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Terapia Física',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(22,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Nutrición',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(23,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Trabajo Social ',0,1,'18-DEC-28',1,1)",

"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(24,1,1,0,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','EGRESO',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(25,1,1,24,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','SALIDA',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(26,1,1,25,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Datos Generales',0,1,'18-DEC-28',1,1)"];
foreach ($arr as $key => $value) {
    $x->executeQuery($value);
}*/
/*
$x->executeQuery("insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion) 
values(1,1,1,1,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','ACOGIDA',1,1,SYSDATE,1,1)");*/
/*$x->insertData('modulos', array("id"=>1,"centro_id"=>1,"encargado_id"=>1,"parent_id"=>1,"url_template"=>'ppd-datos-actividades',"icon"=>'fa fa-laptop',"nombre"=>'ACOGIDA',"estado_completo"=>0,"estado"=>1,"fecha_creacion"=>'18-DEC-28',"usuario_creacion"=>1,"usuario_edicion"=>1));*/
print_r($x->executeQuery("select * from modulos"));
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
