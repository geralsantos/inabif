<template id="nna-egreso-usuario">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Egreso del Usuario</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form  class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">FECHA DE EGRESO</label>
                                <input type="date" v-model="NNAFEgreso" name="NNAFEgreso" placeholder="" class="form-control">
                                    </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">MOTIVO DEL EGRESO</label>
                                <select name="NNAMotivoEgreso" v-model="NNAMotivoEgreso" class="form-control">
                                <option value="">Acogimiento Familiar</option>
                                <option value="">Adopción</option>
                                <option value="">Defunción</option>
                                <option value="">Egreso por mayoría de edad</option>
                                <option value="">Reinserción familiar</option>
                                <option value="">Salida no autorizada</option>
                                <option value="">Traslado a otra institución</option>
                                <option value="">Traslado a otro CAR del INABIF</option>
                                <option value=""> Otros</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Detalle del motivo del egreso</label>
                                <input type="text" v-model="NNADetalleMotivoEgreso" name="NNADetalleMotivoEgreso" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Aseguramiento Universal de Salud-AUS</label>
                                    <select name="NNASaludAUS" v-model="NNASaludAUS" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Partida de Nacimiento?</label>
                                    <select name="NNAPartidaNacimiento" v-model="NNAPartidaNacimiento" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">DNI?</label>
                                    <select name="NNATieneDNI" v-model="NNATieneDNI" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Educación?</label>
                                <select name="NNAEducacion" v-model="NNAEducacion" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Reinserción Familiar</label>
                                    <select name="NNAReinsercionFamiliar" v-model="NNAReinsercionFamiliar" class="form-control">
                                    <<option value="">Padre</option>
                                    <option value="">Madre</option>
                                    <<option value="">Hermano</option>
                                    <option value="">Tío/a</option>
                                    <option value="">primos/as</option>
                                    <option value=""> Abuelos/as</option>
                                    <option value="">Otros</option>
                                    </select>
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