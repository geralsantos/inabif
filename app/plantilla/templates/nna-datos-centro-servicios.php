<template id="nna-datos-centro-servicios">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos del Centro de Servicios</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Código de la Entidad</label>
                                <input type="text" v-model="NNACodEntidad" name="NNACodEntidad" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre de la Entidad</label>
                                <input type="text" v-model="NNANomEntidad" name="NNANomEntidad" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Código de la Línea</label>
                                <input type="text" v-model="NNACodLinea" name="NNACodLinea" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre de la Línea</label>
                                <input type="text" v-model="NNANomLinea" name="NNANomLinea" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Línea de Intervención</label>
                                <input type="text" v-model="NNACodLineaIntervencion" name="NNACodLineaIntervencion" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Código del Servicio</label>
                                <input type="text" v-model="NNACodServicio" name="NNACodServicio" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre del Servicio</label>
                                <input type="text" v-model="NNANombreServicio" name="NNANombreServicio" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Departamento del Centro de Atención</label>
                                <select name="NNADepartamentoA" v-model="NNADepartamentoA" class="form-control">
                                    <option value="">Departamento</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Provincia del Centro de Atención</label>
                                <select name="NNAProvinciaAtencion" v-model="NNAProvinciaAtencion" class="form-control">
                                    <option value="">Provincia</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Distrito del Centro de Atención</label>
                                <select name="NNADistritoAtencion" v-model="NNADistritoAtencion" class="form-control">
                                    <option value="">Distrito</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=""><label for="text-input" class=" form-control-label">Área de residencia del centro de atención</label>
                                    <select name="NNAAreaResidencia" v-model="NNAAreaResidencia" class="form-control">
                                    <option value="">URBANO</option>
                                    <option value="">RURAL</option>
                                </select></div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class=""><label for="text-input" class=" form-control-label">Código del Centro de Atención</label>
                                <input type="text" v-model="NNACodCentroA" name="NNACodCentroA" placeholder="" class="form-control"></div>
                            </div>
                            <div class="form-group col-md-5">
                                <div class=""><label for="text-input" class=" form-control-label">Nombre del Centro de Atención</label>
                                <input type="text" v-model="NNANomCentroA" name="NNANomCentroA" placeholder="" class="form-control"></div>
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