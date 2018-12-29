<form action="geral" method="POST">
<input type="text" value="" name="nombretabla" placeholder="tabla">
<button type="submit">mostrar resultados</button></form>
<?php 
//  Configure DB Parameters
class mdl
{
    public function createTable ($sql){
        try {
            $db1 = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.19.0.35)(PORT = 1521)))(CONNECT_DATA=(SID=xe)))" ;
            $host = "172.19.0.35";
            $dbname = "orcl";
            $dbuser = "INABIF_UPP";
            $userpass = "UPP";
            $port= 1521;
    
            $db = new PDO("oci:dbname=$db1",$dbuser,$userpass);
            $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
         
            $db->exec($sql);
            print("ejecutado.\n");
       
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
          $stmt = parent::prepare($query);
          if($stmt->execute()){
            echo "borrado";
          }else{
            echo "no borrado";
          }
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
}
if (isset($_POST["nombretabla"]) && $_POST["nombretabla"]!="") {
    echo "SELECT * FROM ".$_POST["nombretabla"]." WHERE ESTADO=1";
    echo "<br>";
    print_r($x->executeQuery("SELECT * FROM ".$_POST["nombretabla"]." WHERE ESTADO=1"));
    die();
}else{

//$mdl->createTable("DESCRIBE modulos"); 

$x->dropTable("drop table CarEgresoGeneral");
$mdl->createTable("Create table CarEgresoGeneral
(
Egreso_General_Id  	int not null primary key,
Tipo_Centro_Id     	int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Fecha_Egreso       	date,
Motivo_Egreso      	varchar(200) null,
Retiro_Voluntario  	varchar(180) null,
Reinsercion varchar(180) null,
GradoParentesco long,
Traslado	varchar(100) null,
Fallecimiento varchar(100) null,
Restitucion_Derechos char(2) null,
Aus char(2) null,
Constancia_Naci    	char(2),
Carnet_CONADIS     	char(2),
DNI           	char(2),
Restitucion  	varchar(180),
Estado             	int default 1,
Fecha_Creacion     	date,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
");
 //$mdl->createTable ("Create sequence seq_Cardesempeno_academico");
   /* $mdl->createTable ("drop sequence seq_Carproblematica_familiar");
    */
    //$x->deleteDataNoWhere("pam_nivel_educativo");
    /*
print_r($x->executeQuery("insert into Cardesempeno_academico (id,nombre,fecha_creacion,Usuario_Crea,Usuario_Edita) values(1,'SI, sobresaliente',sysdate,1,1)"));
print_r($x->executeQuery("insert into Cardesempeno_academico (id,nombre,fecha_creacion,Usuario_Crea,Usuario_Edita) values(2,'Si, satisfactorio',sysdate,1,1)"));
print_r($x->executeQuery("insert into Cardesempeno_academico (id,nombre,fecha_creacion,Usuario_Crea,Usuario_Edita) values(3,'NO',sysdate,1,1)"));
print_r($x->executeQuery("insert into Cardesempeno_academico (id,nombre,fecha_creacion,Usuario_Crea,Usuario_Edita) values(4,'No, insatisfactorio',sysdate,1,1)"));*/
print_r($x->executeQuery("SELECT * FROM CarEgresoGeneral WHERE RESIDENTE_ID = 1 AND ESTADO=1"));
die();
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
