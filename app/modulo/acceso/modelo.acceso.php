<?php
class modeloAcceso extends MySQL{

    public function getSesion($usuario, $clave){
        $usuario = $this->executeQuery("select us.* from kpi_usuarios us where us.username=:clave and us.clave=:clave",array("usuario"=>$usuario,"clave"=>$clave));
        return $usuario;
    }
}
