<?php
class modeloAcceso extends MySQL{

    public function getSesion($usuario, $clave){
        $usuario = $this->executeQuery("select us.*,us.id as id_usuario,us.centro_id  as id_centro from usuarios us left join centro_atencion ca on(ca.ID=us.centro_id) where us.usuario=:usuario and us.clave=:clave",array("usuario"=>$usuario,"clave"=>$clave));
        print_r($usuario);die();  
              return $usuario;
    }
}
