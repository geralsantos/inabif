<?php
class modeloAcceso extends MySQL{

    public function getSesion($usuario, $clave){
        try {
            $usuario = $this->executeQuery("select us.*,us.id as id_usuario,ca.centro_id as id_centro from usuarios us left join centro_atencion ca on(ca.ID=us.centro_id) where us.usuario=:usuario and us.clave=:clave",array("usuario"=>$usuario,"clave"=>$clave));
            return $usuario;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
