<template id="usppam-datos-identificacion-usuario">
<div class="content mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Datos de Identificación del Residente</strong>
                        <h6>Formulario de Carga de Datos</h6>
                    </div>
                    <div class="card-body card-block">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Apellido Paterno</label>
                                    <input type="text" id="usppamresidente_apellido_paterno" name="usppamresidente_apellido_paterno" placeholder="" class="form-control"> </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Apellido Materno</label>
                                    <input type="text" id="usppamresidente_apellido_materno" name="usppamresidente_apellido_materno" placeholder="" class="form-control"> </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Nombre</label>
                                    <input type="text" id="usppamresidente_nombre" name="usppamresidente_nombre" placeholder="" class="form-control"> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">País de Procedencia</label>
                                    <select name="usppampais_procedente_id" id="usppampais_procedente_id" class="form-control">
                                        <option value="">País</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Departamento de Procedencia</label>
                                    <select name="usppamdepartamento_procedente_id" id="usppamdepartamento_procedente_id" class="form-control">
                                        <option value="">Departamento</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Departamento de Nacimiento</label>
                                    <select name="usppamdepartamento_nacimiento_id" id="usppamdepartamento_nacimiento_id" class="form-control">
                                        <option value="">Departamento</option>
                                    </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                            <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Provincia de Nacimiento</label>
                                    <select name="usppamprovincia_nacimiento_id" id="usppamprovincia_nacimiento_id" class="form-control">
                                        <option value="">Provincia</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Distrito de Nacimiento</label>
                                    <select name="usppamdistrito_nacimiento_id" id="usppamdistrito_nacimiento_id" class="form-control">
                                        <option value="">Distrito</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Sexo</label>
                                    <select name="usppamsexo" id="usppamsexo" class="form-control">
                                    <option value="">Hombre</option>
                                    <option value="">Mujer</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" id=""  placeholder="DD-MM-YYYY" v-model="fecha_fin_real"  data-language='es'  />
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Edad</label>
                                    <input type="text" id="txtaccionprogramada" name="txtaccionprogramada" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Lengua Materna</label>
                                    <select name="select" id="select" class="form-control">
                                    <option value="">Quechua</option>
                                    <option value="">Aymará</option>
                                    <option value="">Ashaninka</option>
                                    <option value="">Otra lengua nativa</option>
                                    <option value="">Castellano</option>
                                    <option value="">Portugués</option>
                                    </select>
                                    </div>
                                </div>
                               
                            </div>
                           
                            
                            <div class="row">
                                <div class="col-md-12 text-center" >
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-send"></i> Grabar datos
                                    </button>
                                </div>
                            </div>
                         </form>
                    </div>
                </div>
            </div>

        </div> <!-- .content -->
</template>