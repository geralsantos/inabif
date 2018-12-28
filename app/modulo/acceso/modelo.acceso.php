<?php
class modeloAcceso extends MySQL{

    public function getSesion($usuario, $clave){
        $usuario = $this->executeQuery("select us.* from usuarios us where us.usuario=:usuario and us.clave=:clave",array("usuario"=>$usuario,"clave"=>$clave));
        return $usuario;
    }
}
