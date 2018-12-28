<?php 
//  Configure DB Parameters
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
         parent::__construct("oci:dbname=$db1",$dbuser,$userpass);
    try {

 
      parent::setAttribute(parent::ATTR_ERRMODE, parent::ERRMODE_EXCEPTION);

      parent::setAttribute(parent::ATTR_DEFAULT_FETCH_MODE, parent::FETCH_ASSOC);

      //parent::exec("SET CHARACTER SET utf8");

    } catch (PDOException $e) {

        echo 'Error BD: ' . $e->getMessage();

      }

    }
public function executeQuery($query, $params=NULL){

      try{

        $stmt = parent::prepare($query);

        if($stmt->execute($params)){

          return $stmt->fetchAll();

        }else{

          return array();

        }

      } catch (PDOException $e) {

        echo 'Error BD: ' . $e->getMessage();

      }

    }
    }

$x = new PG();
//print_r($x->executeQuery("delete from CarActividades"));
print_r($x->executeQuery("delete from modulos;
create table modulos (
  id INT NOT NULL primary key,
  centro_id INT NOT NULL,
  encargado_id INT NOT NULL,
parent_id int not null,
url_template clob,
icon varchar(100),
  nombre VARCHAR(45) NOT NULL,
  estado_completo INT NULL,
  estado INT DEFAULT 1,
  fecha_creacion date NOT NULL,
  fecha_edicion TIMESTAMP DEFAULT SYSDATE,
  usuario_creacion INT NOT NULL,
  usuario_edicion INT NOT NULL
  );
CREATE SEQUENCE seq_modulos ;

insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(1,1,1,0,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','ACOGIDA',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(2,1,1,1,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DIAGNÓSTICO',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(3,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DEL CENTRO DE SERVICIOS',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(4,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DE IDENTIFICACIÓN DEL USUARIO',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(5,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DE ADMISIÓN DEL USUARIO',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(6,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DE CONDICIONES DE INGRESO DEL USUARIO',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(7,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DE SALUD Y NUTRICIÓN DEL USUARIO',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(8,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','SALUD MENTAL',0,1,'18-DEC-28',1,1);

insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(9,1,1,0,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DESARROLLO O CONVIVENCIA',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(10,1,1,9,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','SEGUIMIENTO (MENSUAL)',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(11,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','TERAPIA',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(12,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Actividades Técnico - Productivas',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(13,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Atención Psicológica',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(14,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','FORTALECIMIENTO DE CAPACIDADES',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(15,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Atención en Trabajo Social ',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(16,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Atenciones en Salud',0,1,'18-DEC-28',1,1);

insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(17,1,1,0,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','SEGUIMIENTO (SEMESTRAL)',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(18,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Psicológico',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(19,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Educación',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(20,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Salud',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(21,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Terapia Física',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(22,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Nutrición',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(23,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Trabajo Social ',0,1,'18-DEC-28',1,1);

insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(24,1,1,0,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','EGRESO',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(25,1,1,24,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','SALIDA',0,1,'18-DEC-28',1,1);
insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(26,1,1,26,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Datos Generales',0,1,'18-DEC-28',1,1);
"));

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
