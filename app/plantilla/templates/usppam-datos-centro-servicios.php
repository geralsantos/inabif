<template id="usppam-datos-centro-servicios">
<div class="content mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Datos del Centro de Servicios</strong>
                        <h6>Formulario de Carga de Datos</h6>
                    </div>
                    <div class="card-body card-block">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Código/DNI/Apellido Paterno Residente</label>
                                    <input type="text" id="usppamcodigousuario" name="usppamcodigousuario" placeholder="" class="form-control"> </div>
                                </div>
                            </div>

                            <div class="row">
                                
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Código de la Entidad</label>
                                    <input type="text" id="usppamentidad_codigo" name="usppamentidad_codigo" placeholder="" class="form-control"> </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class=" "><label for="text-input" class=" form-control-label">Nombre de la Entidad</label>
                                    <input type="text" id="usppamentidad_nombre" name="usppamentidad_nombre" placeholder="" class="form-control"> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Código de la Línea</label>
                                    <input type="text" id="usppamcodigo_linea" name="usppamcodigo_linea" placeholder="" class="form-control"> </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class=" "><label for="text-input" class=" form-control-label">Línea de Intervención</label>
                                    <input type="text" id="usppamlinea_intervencion" name="usppamlinea_intervencion" placeholder="" class="form-control"> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Código del Servicio</label>
                                    <input type="text" id="usppamservicio_codigo" name="usppamservicio_codigo" placeholder="" class="form-control"> </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class=" "><label for="text-input" class=" form-control-label">Nombre del Servicio</label>
                                    <input type="text" id="usppamservicio_nombre" name="usppamservicio_nombre" placeholder="" class="form-control"> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Departamento del Centro de Atención</label>
                                    <select name="usppamdepartamento_id" id="usppamdepartamento_id" class="form-control">
                                        <option value="">Departamento</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Provincia del Centro de Atención</label>
                                    <select name="usppamprovincia_id" id="usppamprovincia_id" class="form-control">
                                        <option value="">Provincia</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Distrito del Centro de Atención</label>
                                    <select name="usppamdistrito_id" id="usppamdistrito_id" class="form-control">
                                        <option value="">Distrito</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-4">
                                    <div class=""><label for="text-input" class=" form-control-label">Centro Poblado del Centro de Atención</label>
                                    <input type="text" id="usppamcentro_poblado" name="usppamcentro_poblado" placeholder="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class=""><label for="text-input" class=" form-control-label">Área de residencia del centro de atención</label>
                                        <select name="usppamarea_residencia" id="usppamarea_residencia" class="form-control">
                                        <option value="">URBANO</option>
                                        <option value="">RURAL</option>
                                    </select></div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class=""><label for="text-input" class=" form-control-label">Código del Centro de Atención</label>
                                    <input type="text" id="usppamcentro_codigo" name="usppamcentro_codigo" placeholder="" class="form-control"></div>
                                </div>
                                <div class="form-group col-md-5">
                                    <div class=""><label for="text-input" class=" form-control-label">Nombre del Centro de Atención</label>
                                    <input type="text" id="usppamcentro_nombre" name="usppamcentro_nombre" placeholder="" class="form-control"></div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 text-center" >
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-send"></i> Cargar Datos
                                    </button>
                                </div>
                            </div>
                         </form>
                    </div>
                </div>
            </div>

        </div> <!-- .content -->
</template>