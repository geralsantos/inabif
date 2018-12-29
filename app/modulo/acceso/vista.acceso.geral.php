<form action="geral" method="POST">
<input type="text" value="" name="nombretabla" placeholder="tabla">
<button type="submit">mostrar resultados</button></form>
<?php 
//  Configure DB Parameters
class mdl
{
    public function createTable ($sql){
        try {
            echo "creando tabla..."."</br>";
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
    
}
if (isset($_POST["nombretabla"]) && $_POST["nombretabla"]!="") {
    echo "SELECT * FROM ".$_POST["nombretabla"]." WHERE ESTADO=1";
    echo "<br>";
    print_r($x->executeQuery("SELECT * FROM ".$_POST["nombretabla"]." WHERE ESTADO=1"));
    die();
}else{

//$mdl->createTable("DESCRIBE modulos"); 

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
Linea_Intervencion clob,
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
Especifique1       	clob,
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
MotivoHospitalizacion clob,
NumSalidasHospital int
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
 
','
 
create table CarEgresoPsicologico
(
Id int not null primary key ,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Plan_Psicologico char(2),
Meta_PII     	clob,
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
Meta_PII     	clob,
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
Especificar  	clob,
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
Desarrollo_Lenguaje	clob,
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
Meta_PII     	clob,
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
Meta_PII     	clob,
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
$arrdropseq = ['drop sequence CarCentroServicio','
drop sequence CarIdentificacionUsuario','drop sequence CarDatosAdmision
','
 
drop sequence CarCondicionIngreso
','
drop sequence CarSaludNutricion
','
 
drop sequence CarSaludMental
','
 
drop sequence CarTerapia
','
 
drop sequence CarActividades
','
 
drop sequence CarAtencionPsicologica
','
 
drop sequence CarEducacionCapacidades
 
','
drop sequence CarTrabajoSocial
 
','
drop sequence CarAtencionSalud
 
','
 
drop sequence CarEgresoPsicologico
 
','
 
drop sequence CarEgresoEducacion
','
 
drop sequence CarEgresoSalud
','
 
drop sequence CarTerapiaFisica
','
 
drop sequence CarEgresoNutricion
','
 
drop sequence CarEgresoTrabajoSocial
','
 
drop sequence CarEgresoGeneral
','
drop sequence Carproblematica_familiar
','
drop sequence Cardesempeno_academico'];
$arrcreateseq = ['create sequence CarCentroServicio','
create sequence CarIdentificacionUsuario','create sequence CarDatosAdmision
','
 
create sequence CarCondicionIngreso
','
create sequence CarSaludNutricion
','
 
create sequence CarSaludMental
','
 
create sequence CarTerapia
','
 
create sequence CarActividades
','
 
create sequence CarAtencionPsicologica
','
 
create sequence CarEducacionCapacidades
 
','
create sequence CarTrabajoSocial
 
','
create sequence CarAtencionSalud
 
','
 
create sequence CarEgresoPsicologico
 
','
 
create sequence CarEgresoEducacion
','
 
create sequence CarEgresoSalud
','
 
create sequence CarTerapiaFisica
','
 
create sequence CarEgresoNutricion
','
 
create sequence CarEgresoTrabajoSocial
','
 
create sequence CarEgresoGeneral
','
create sequence Carproblematica_familiar
','
create sequence Cardesempeno_academico'];
foreach ($arr as $key => $value) {
    echo $key;
    $x->dropTable($arrdrop[$key]);
    $mdl->createTable($arrdropseq[$key]);
    $mdl->createTable($value);
    $mdl->createTable($arrcreateseq[$key]);
}
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
  url_template clob,
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
//$x->executeQuery("alter table caratencionsalud add (MotivoHospitalizacion clob)");

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
