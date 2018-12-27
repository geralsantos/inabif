<template id="ppd-datos-admision-usuario">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de Admisión Del Usuario</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form  class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Movimiento Poblacional</label>
                                <select name="CarMPoblacional" v-model="CarMPoblacional" class="form-control">
                                    <option value="nuevo">NUEVO</option>
                                    <option value="continuador">CONTINUADOR</option>
                                    <option value="reingreso">REINGRESO</option>
                                    <option value="transladod de otro car">TRASLADO DE OTRO CAR</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Fecha de Reingreso del usuario</label>
                                <input type="date" v-model="CarFIngreso" name="CarFIngreso" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Fecha de reingreso del usuario (en caso no aplique marcar 99/99/9999)</label>
                                <input type="date" v-model="CarFReingreso" name="CarFReingreso" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Institución que lo derivó</label>
                                <select name="CarIDerivo" v-model="CarIDerivo" class="form-control">
                                <option value="Fiscalia">Fiscalía</option>
                                        <option value="Juzgado">Juzgado</option>
                                        <option value="Unidad de Protección Especial">Unidad de Protección Especial</option>
                                        <option value="Otros"> Otros</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Motivo de ingreso (acorde al expediente)</label>
                                <select name="CarMotivoI" v-model="CarMotivoI" class="form-control">
                                    <option value="Riesgo de desprotección">Riesgo de desprotección</option>
                                    <option value="Situación de desprotección">Situación de desprotección</option>
                                </select>

                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Tipo de documento de ingreso al CAR</label>
                                <select name="CarTipoDoc" v-model="CarTipoDoc" class="form-control">
                                    <option value="Oficio">Oficio</option>
                                    <option value="Acta">Acta</option>
                                    <option value="Resolución">Resolución</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Número del documento de ingreso al car</label>
                                <input type="number" v-model="CarNumDoc" name="CarNumDoc" placeholder="" class="form-control">
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