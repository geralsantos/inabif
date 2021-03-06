<?php
class modeloAcceso extends MySQL{

    public function getSesion($usuario, $clave){
        try {

            $usuario = $this->executeQuery("select us.*,us.id as id_usuario,ca.id as id_centro,tc.id as tipo_centro_id,tc.nombre as tipo_centro_nombre,ca.nom_ca  from usuarios us 
            left join centro_atencion ca on(ca.ID=us.centro_id) 
            left join tipo_centro tc on (tc.id=us.tipo_centro_id)  
            where us.usuario=:usuario and us.clave=:clave",array("usuario"=>$usuario,"clave"=>$clave));

        } catch (PDOException $e) {
            return false;
        }
        return $usuario;
    }
}
