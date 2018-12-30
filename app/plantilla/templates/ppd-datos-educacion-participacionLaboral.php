<template id="ppd-datos-educacion-participacionLaboral">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Atención en educación, participación laboral y fortalecimiento de habilidades</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form  class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="text-input" class=" form-control-label">Nombre Residente</label>
                                <div class="autocomplete">
                                    <input type="text"  v-model="nombre_residente" class="form-control" @keyup="buscar_residente()" placeholder="Nombre, Apellido o DNI"/>
                                    <ul  id="autocomplete-results" class="autocomplete-results" v-if="bloque_busqueda">
                                        <li class="loading" v-if="isLoading">
                                            Loading results...
                                        </li>
                                        <li  @click="actualizar(coincidencia)" class="autocomplete-result" v-for="coincidencia in coincidencias">
                                            {{coincidencia.NOMBRE}} {{coincidencia.APELLIDO}} - {{coincidencia.DOCUMENTO}}
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="text-input" class=" form-control-label">Año</label>
                                <select name="select" disabled="disabled" id="anio"  v-model="anio" class="form-control">
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                </select>

                            </div>
                            <div class="form-group col-md-3">
                                <div class=""><label for="text-input" class=" form-control-label">Mes</label>
                                <select id="mes" v-model="mes" disabled="disabled" class="form-control" >
                                        <option value="1">Enero</option>
                                        <option value="2">Febrero</option>
                                        <option value="3">Marzo</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Mayo</option>
                                        <option value="6">Junio</option>
                                        <option value="7">Julio</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select> </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Tipo de de IIEE a la que asiste</label>
                                <select name="CarTipoIIEE" v-model="CarTipoIIEE" class="form-control">
                                <option value="CEBE">CEBE</option>
                                <option value="CEBA">CEBA</option>
                                <option value="CETPRO">CETPRO</option>
                                <option value="CBR inclusivo">CBR inclusivo</option>
                                <option value="Otro">Otro</option>
                                <option value="No estudia">No estudia</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Residente se encuentra insertado laboralmente</label>
                                <select name="CarInsertadoLaboralmente" v-model="CarInsertadoLaboralmente" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Descriptivo de la participación laboral</label>
                                <input type="text" v-model="CarDesParticipacionLa" name="CarDesParticipacionLa" placeholder="" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">NNA participa en actividades de fortalecimiento de habilidades personales y sociales </label>
                                <select name="CarFortalecimientoHabilidades" v-model="CarFortalecimientoHabilidades" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Fecha de inicio del NNA en actividades de fortalecimiento de habilidades personales y sociales </label>
                                <input type="date" v-model="CarFIActividades" name="CarFIActividades" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Fecha final del NNA en actividades de fortalecimiento de habilidades personales y sociales </label>
                                <input type="date" v-model="CarFFActividades" name="CarFFActividades" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">NNA conluyó actividades de fortalecimiento de habilidades personales y sociales </label>
                                <select name="CarNNAConcluyoHP" v-model="CarNNAConcluyoHP" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">NNA logró fortalecer sus habilidades personales y sociales</label>
                                <select name="CarNNAFortaliceHP" v-model="CarNNAFortaliceHP" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
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