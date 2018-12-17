<?php
class modeloAcceso extends MySQL{

    public function getSesion($usuario, $clave){
        $usuario = $this->executeQuery("select co.nombre as nombre_sede,us.*,kr.nombre as nombre_nivel from kpi_usuarios us left join kpi_sedes co on (us.kpi_sedes_id=co.id) left join kpi_roles kr on (us.kpi_roles_id=kr.id) where us.username=:username and us.password=:password",array("username"=>$usuario,"password"=>$clave));
        return $usuario;
    }
}
