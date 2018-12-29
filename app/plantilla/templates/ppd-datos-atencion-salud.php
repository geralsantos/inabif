<template id="ppd-datos-atencion-salud">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de Salud Mental</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form class="form-horizontal" v-on:submit.prevent="guardar">
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
                                <label for="text-input" class=" form-control-label">Nº Atenciones en Medicina General por profesional del CAR</label>
                                <input type="number" v-model="CarNumAtencionesMG" name="CarNumAtencionesMG" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Residente tuvo salidad a hospitales en el mes</label>
                                <select name="CarSalidaMes" v-model="CarSalidaMes" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Número de salidas a hospitales</label>
                                <input type="number" v-model="CarNunSalidas" name="CarNunSalidas" placeholder="" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en CARDIOVASCULAR</label>
                                <input type="number" v-model="CarNumACardiovascular" name="CarNumACardiovascular" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en NEFROLOGÍA</label>
                                <input type="number" v-model="CarANefrologia" name="CarANefrologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en ONCOLOGÍA</label>
                                <input type="number" v-model="CarAOncologia" name="CarAOncologia" placeholder="" class="form-control">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en NEUROCIRUGÍA</label>
                                <input type="number" v-model="CarANeurocirugia" name="CarANeurocirugia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en DERMATOLOGÍA</label>
                                <input type="number" v-model="CarNumDermatologia" name="CarNumDermatologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en ENDOCRINOLOGÍA</label>
                                <input type="number" v-model="CarAEndocrinologia" name="CarAEndocrinologia" placeholder="" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en GASTROENTEROLOGIA</label>
                                <input type="number" v-model="CarAGastroenterologia" name="CarAGastroenterologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en GINECO-OBSTETRICIA</label>
                                <input type="number" v-model="CarAGinecoObstretica" name="CarAGinecoObstretica" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en INFECTO-CONTAGIOSAS</label>
                                <input type="number" v-model="CarAInfectoContagiosas" name="CarAInfectoContagiosas" placeholder="" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Nº Atenciones en HEMATOLOGIA</label>
                                    <input type="number" v-model="CarAHematologia" name="CarAHematologia" placeholder="" class="form-control">
                                </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en INMUNOLOGIA</label>
                                <input type="number" v-model="CarAInmunologia" name="CarAInmunologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en MEDICINA FISICA Y REHABILITACION</label>
                                <input type="number" v-model="CarAMedicinaFisica" name="CarAMedicinaFisica" placeholder="" class="form-control">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en NEUMOLOGIA</label>
                                <input type="number" v-model="CarANeumologia" name="CarANeumologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en NUTRICION</label>
                                <input type="number" v-model="CarAnutricion" name="CarAnutricion" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en NEUROLOGIA</label>
                                <input type="number" v-model="CarANeurologia" name="CarANeurologia" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en OFTALMOLOGIA</label>
                                <input type="number" v-model="CarAOftamologia" name="CarAOftamologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en OTORRINOLARINGOLOGIA</label>
                                <input type="number" v-model="CarAOtorrinoloringologia" name="CarAOtorrinoloringologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en PEDIATRIA</label>
                                <input type="number" v-model="CarAPedriatria" name="CarAPedriatria" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en PSIQUIATRIA</label>
                                <input type="number" v-model="CarAPsiquiatria" name="CarAPsiquiatria" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en QUIRURGICA</label>
                                <input type="number" v-model="CarAQuirurgica" name="CarAQuirurgica" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en TRAUMATOLOGIA</label>
                                <input type="number" v-model="CarATraumologia" name="CarATraumologia" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en UROLOGIA</label>
                                <input type="number" v-model="CarAUrologia" name="CarAUrologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en ODONTOLOGIA</label>
                                <input type="number" v-model="CarAOdontologia" name="CarAOdontologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en Otros servicios</label>
                                <input type="number" v-model="CarAServicios" name="CarAServicios" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Recibe tratamiento con psicofármacos</label>
                                <select name="CarTratamientoPsicofarmaco" v-model="CarTratamientoPsicofarmaco" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Residente fue hospitalizado en el periodo</label>
                                <select name="CarHopitalizadoP" v-model="CarHopitalizadoP" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Número de hospitalizaciones</label>
                                <input type="number" v-model="CarNumHospitalizaciones" name="CarNumHospitalizaciones" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Motivo de la hospitalización</label>
                                <input type="text" v-model="CarMotivoHospitalizacion" name="CarMotivoHospitalizacion" placeholder="" class="form-control">
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