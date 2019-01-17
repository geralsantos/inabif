<?php
class modeloPortada extends MySQL{
  public function getModulos(){
    echo "getModulos";
      // $modulos = $this->selectAll("modulos");
      // $modulos_det = $this->selectAll("modulos_det");
      // return [$modulos,$modulos_det];
  }
  public function buscar_grupos($id_centro){

   
      $sql = "select distinct m.nombre as modulo_nombre,m.id as id_modulo, m.encargado_id,usu.nombre as encargado_nombre, md.estado_completo,md.fecha_edicion,m.nombre_tabla from modulos m
      left join modulos_detalle md on (md.modulo_id=m.Id)
      left join usuarios usu on (usu.id = m.encargado_id)
      left join centro_atencion ca on (ca.tipo_centro_id=m.centro_id)
      where ca.id = ".$id_centro." order by m.id desc";

    $res = $this->executeQuery($sql );
    if ($res)
    {
      echo json_encode(array("data"=>$res) ) ;
    }else{
      return false;
    }
  }
}
