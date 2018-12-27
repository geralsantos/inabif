<template id="ppd-datos-egreso-generales">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Egreso - Datos Generales</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                        <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Fecha_egreso</label>
                                <input type="date" v-model="CarFEgreso" name="CarFEgreso" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Motivo del egreso</label>
                                <select name="CarMotivoEgreso" v-model="CarMotivoEgreso" class="form-control">
                                    <option value="Traslado a otro CAR">Traslado a otro CAR</option>
                                    <option value="Fallecimiento">Fallecimiento</option>
                                    <option value="Reinserción Familiar">Reinserción Familiar</option>
                                    <option value="Vida Independiente">Vida Independiente</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Traslado</label>
                                <select name="CarTrasladoCar" v-model="CarTrasladoCar" class="form-control">
                                    <option value="ESSALU">ESSALUD</option>
                                    <option value="MINSA">MINSA</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Traslado a un establecimiento de salud por un periodo prolongado</label>
                                <select name="CarTrasladoEstablecimiento" v-model="CarTrasladoEstablecimiento" class="form-control">
                                    <option value="ESSALUD">ESSALUD</option>
                                    <option value="MINSA">MINSA</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Defunción </label>
                                <select name="CarDefuncion" v-model="CarDefuncion" class="form-control">
                                    <option value="Muerte natural">Muerte natural</option>
                                    <option value="Muerte violenta">Muerte violenta</option>
                                    <option value="Muerte súbita">Muerte súbita</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Reinserción familiar</label>
                                <select name="CarReinsercionFamiliar" v-model="CarReinsercionFamiliar" class="form-control">
                                    <option value="Padre">Padre</option>
                                    <option value="Madre">Madre</option>
                                    <option value="Hermano/a">Hermano/a</option>
                                    <option value="Tío/a">Tío/a</option>
                                    <option value="primos/as">primos/as</option>
                                    <option value="Abuelos/as">Abuelos/as</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Retiro Voluntario</label>
                                <select name="CarRetiroVoluntario" v-model="CarRetiroVoluntario" class="form-control">
                                    <option value="Vida Independencia">Vida Independencia</option>
                                    <option value="Maltrato">Maltrato</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">ASEGURAMIENTO A SALUD</label>
                                <select name="CarAseguramiento" v-model="CarAseguramiento" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">CONSTANCIA DE NACIMIENTO</label>
                                <select name="CarConstanciaNacimiento" v-model="CarConstanciaNacimiento" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Carnet del CONADIS</label>
                                <select name="CarCarnetConadis" v-model="CarCarnetConadis" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label"> DNI</label>
                                <select name="CarTieneDni" v-model="CarTieneDni" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Restitución Familiar</label>
                                <select name="CarRestitucionF" v-model="CarRestitucionF" class="form-control">
                                    <option value="Participación Familiar">Participación Familiar</option>
                                    <option value="Reinserción Familiar">Reinserción Familiar</option>
                                    <option value="Ninguno">Ninguno</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Cumplimiento de restitución de derechos al egreso</label>
                                <select name="CarCumResDerEgreso" v-model="CarCumResDerEgreso" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">AUS</label>
                                <select name="CarAus" v-model="CarAus" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
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