<template id="ppd-datos-identificacion-residente">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de Identificación del Residente</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form  class="form-horizontal"  v-on:submit.prevent="guardar">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Apellido Paterno</label>
                                <input type="text" v-model="txtaccionprogramada" name="txtaccionprogramada" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Apellido Materno</label>
                                <input type="text" v-model="txtaccionprogramada" name="txtaccionprogramada" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre</label>
                                <input type="text" v-model="txtaccionprogramada" name="txtaccionprogramada" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">País de Procedencia</label>
                                <select name="select" v-model="select" class="form-control">
                                    <option value="">País</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Departamento de Procedencia</label>
                                <select name="select" v-model="select" class="form-control">
                                    <option value="">Departamento</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Departamento de Nacimiento</label>
                                <select name="select" v-model="select" class="form-control">
                                    <option value="">Departamento</option>
                                </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                        <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Provincia de Procedencia</label>
                                <select name="select" v-model="select" class="form-control">
                                    <option value="">Provincia</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Distrito de Procedencia</label>
                                <select name="select" v-model="select" class="form-control">
                                    <option value="">Distrito</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Sexo</label>
                                <select name="select" v-model="select" class="form-control">
                                <option value="Hombre">Hombre</option>
                                <option value="Mujer">Mujer</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" v-model=""  placeholder="DD-MM-YYYY" v-model="fecha_fin_real"  data-language='es'  />
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Edad</label>
                                <input type="text" v-model="txtaccionprogramada" name="txtaccionprogramada" placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Lengua Materna</label>
                                <select name="select" v-model="select" class="form-control">
                                <option value="Quechua">Quechua</option>
                                <option value="Aymará">Aymará</option>
                                <option value="Aymará">Aymará</option>
                                <option value="Otra lengua nativa">Otra lengua nativa</option>
                                <option value="Castellano">Castellano</option>
                                <option value="Portugués">Portugués</option>
                                </select>
                                </div>
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