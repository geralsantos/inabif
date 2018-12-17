<?php 
//  Configure DB Parameters
class PG extends PDO
{
public function __construct() {
    try {
        $host = "172.16.40.102";
        $dbname = "citas";
        $dbuser = "user_readonly";
        $userpass = "c1i3nT32018";

       // $con = pg_connect("host=$host port=5432 dbname=$dbname user=$dbuser password=$userpass");
       $con = "pgsql:host=$host;port=5432;dbname=$dbname;user=$dbuser;password=$userpass";


          parent::__construct($con);
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
print_r($x->executeQuery("SELECT * FROM citas limit 10;"));

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
