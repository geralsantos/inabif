<template id="nna-datos-salud-residente">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de Salud del Residente</strong>
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
                                <div class=" "><label for="text-input" class=" form-control-label">Discapacidad</label>
                                <select name="Discapacidad" v-model="Discapacidad" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Presenta Discapacidad Física</label>
                                <select name="Discapacidad_Fisica" v-model="Discapacidad_Fisica" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Leve">Leve</option>
                                    <option value="Moderada">Moderada</option>
                                    <option value="Severa">Severa</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Presenta Discapacidad Intelectual</label>
                                <select name="Discapaciada_Intelectual" v-model="Discapaciada_Intelectual" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Leve">Leve</option>
                                    <option value="Moderada">Moderada</option>
                                    <option value="Severa">Severa</option>
                                </select>  </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Presenta Discapacidad Sensorial</label>
                                    <select name="Discapacidad_Sensorial" v-model="Discapacidad_Sensorial" class="form-control">
                                        <option value="No">No</option>
                                        <option value="Leve">Leve</option>
                                        <option value="Moderada">Moderada</option>
                                        <option value="Severa">Severa</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Presenta Discapacidad Mental</label>
                                    <select name="Discapacidad_Mental" v-model="Discapacidad_Mental" class="form-control">
                                        <option value="No">No</option>
                                        <option value="Leve">Leve</option>
                                        <option value="Moderada">Moderada</option>
                                        <option value="Severa">Severa</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">El Dx es Certificado</label>
                                    <select name="Certificado" v-model="Certificado" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Tiene Carnet del CONADIS</label>
                                    <select name="Carnet_CANADIS" v-model="Carnet_CANADIS" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                        <option value="Se desconoce">Se desconoce</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Trastorno Neurológico</label>
                                    <select name="Transtornos_Neuro" v-model="Transtornos_Neuro" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Especificar Trastorno Neurológico Principal</label>
                                    <select name="Des_Transtorno_Neuro" v-model="Des_Transtorno_Neuro" class="form-control">
                                        <option value="Epilepsia">Epilepsia</option>
                                        <option value="Alzheimer">Alzheimer</option>
                                        <option value="Accidente cerebrovascular">Accidente cerebrovascular</option>
                                        <option value="Migraña">Migraña</option>
                                        <option value="Esclerosis Múltiple">Esclerosis múltiple</option>
                                        <option value="Parkinson">Parkinson</option>
                                        <option value="Infecciones Neurológica">Infecciones neurológica</option>
                                        <option value="Traumatismo Encefálo Craneano">Traumatismo encefálo craneano</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Solo a menor 36 meses ¿Recibió atenciones de CRED en el último mes? </label>
                                    <select name="CRED" v-model="CRED" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Solo a menor de 5 años ¿Recibió vacunas en el último mes? ¿Recibió vacunas según esquema de vacunación?</label>
                                    <select name="Vacunas" v-model="Vacunas" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Patología Crónica 1</label>
                                    <select name="Patologia_1" v-model="Patologia_1" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Diagnósticos 1 según CIE 10 </label>
                                    <select name="Diagnostico_S1" v-model="Diagnostico_S1" class="form-control">
                                    <option value="VIH">VIH</option>
                                    <option value="TBC">TBC</option>
                                    <option value="Hepatitis">Hepatitis</option>
                                    <option value="Insuficiencia Renal">Insuficiencia Renal</option>
                                    <option value="Hipertensión">Hipertensión</option>
                                    <option value="DCI">DCI</option>
                                    <option value="Diábetes">Diábetes</option>
                                    <option value="Cáncer">Cáncer</option>
                                    <option value="Estreñimiento">Estreñimiento</option>
                                    <option value="Otros">Otros</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Patología Crónica 2</label>
                                    <select name="Patologia_2" v-model="Patologia_2" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Diagnósticos 3 según CIE 10 </label>
                                    <select name="Diagnostico_S3" v-model="Diagnostico_S3" class="form-control">
                                    <option value="VIH">VIH</option>
                                    <option value="TBC">TBC</option>
                                    <option value="Hepatitis">Hepatitis</option>
                                    <option value="Insuficiencia Renal">Insuficiencia Renal</option>
                                    <option value="Hipertensión">Hipertensión</option>
                                    <option value="DCI">DCI</option>
                                    <option value="Diábetes">Diábetes</option>
                                    <option value="Cáncer">Cáncer</option>
                                    <option value="Estreñimiento">Estreñimiento</option>
                                    <option value="Otros">Otros</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Presenta Transtorno de Comportamiento y/o disociales</label>
                                    <select name="Transtornos_Comportamiento" v-model="Transtornos_Comportamiento" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Tipo de Transtorno </label>
                                    <select name="Tipo_Transtorno" v-model="Tipo_Transtorno" class="form-control">
                                    <option value="Ninguna">Ninguna</option>
                                    <option value="Transtorno Depresivo">Transtorno Depresivo</option>
                                    <option value="Transtornos Disociales">Transtornos Disociales</option>
                                    <option value="Transtornos por Déficit de Atención">Transtornos por Déficit de Atención</option>
                                    <option value="Transtornos por Abuso de Sustancias">Transtornos por Abuso de Sustancias</option>
                                    <option value="Transtornos de Conducta Alimentaria">Transtornos de Conducta Alimentaria</option>
                                    <option value="Transtornos de la personalidad">Transtornos de la personalidad</option>
                                    <option value="Demencia">Demencia</option>
                                    <option value="Otros">Otros</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Gestante</label>
                                    <select name="Gestante" v-model="Gestante" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Semanas de Gestación </label>
                                <input type="number" min="0"  v-model="Semanas_Gestacion" name="Semanas_Gestacion" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Ha Acudido a Control Parental</label>
                                    <select name="Control_Prenatal" v-model="Control_Prenatal" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">NNA tiene hijos </label>
                                    <select name="Hijos" v-model="Hijos" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Número de hijos de residentes en los CAR</label>
                                <input type="number" min="0"  v-model="Nro_Hijos" name="Nro_Hijos" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nivel de Hemoglobina (gr./dl.) </label>
                                <input type="number" min="0"  step="0.01" v-model="Nivel_Hemoglobina" name="Nivel_Hemoglobina" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Presenta Anemia</label>
                                    <select name="Anemia" v-model="Anemia" class="form-control">
                                    <option value="">Leve</option>
                                    <option value="">Moderada</option>
                                    <option value="">Severa</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Peso (kg.)</label>
                                <input type="number" min="0" step="0.01" v-model="Peso" name="Peso" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Talla (mt)</label>
                                <input type="number" min="0" step="0.01" v-model="Talla" name="Talla" placeholder="" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Estado Nutricional (Peso para la talla) </label>
                                <select name="Estado_Nutricional1" v-model="Estado_Nutricional1" class="form-control">
                                    <option value="Bajo Peso">Bajo Peso</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Sobrepeso">Sobrepeso</option>
                                    <option value="Obesidad">Obesidad</option>
                                    <option value="Obesidad Mórbida">Obesidad Mórbida</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Estado Nutricional (Talla para la edad) </label>
                                <select name="Estado_Nutricional2" v-model="Estado_Nutricional2" class="form-control">
                                    <option value="Baja Talla">Baja Talla</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Alto">Alto</option>
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