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
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Discapacidad</label>
                                <select name="NNADiscapacidad" v-model="NNADiscapacidad" class="form-control">
                                <option value="">Si</option>
                                <option value="">No</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Presenta Discapacidad Física</label>
                                <select name="NNADiscapacidadFisica" v-model="NNADiscapacidadFisica" class="form-control">
                                <option value="">No</option>
                                <option value="">Leve</option>
                                <option value="">Moderada</option>
                                <option value="">Severa</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Presenta Discapacidad Intelectual</label>
                                <select name="NNADiscapacidadIntelectual" v-model="NNADiscapacidadIntelectual" class="form-control">
                                <option value="">Nuclear</option>
                                <option value="">Extensa</option>
                                <option value="">Mononuclear</option>
                                </select>  </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Presenta Discapacidad Sensorial</label>
                                    <select name="NNADiscapacidadSensorial" v-model="NNADiscapacidadSensorial" class="form-control">
                                    <option value="">No</option>
                                    <option value="">Leve</option>
                                    <option value="">Moderada</option>
                                    <option value="">Severa</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Presenta Discapacidad Mental</label>
                                    <select name="NNADiscapacidadMental" v-model="NNADiscapacidadMental" class="form-control">
                                    <option value="">No</option>
                                    <option value="">Leve</option>
                                    <option value="">Moderada</option>
                                    <option value="">Severa</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">El Dx es Certificado</label>
                                    <select name="NNADxCertificado" v-model="NNADxCertificado" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Tiene Carnet del CONADIS</label>
                                    <select name="NNACarnetConadis" v-model="NNACarnetConadis" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    <option value="">Se desconoce</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Trastorno Neurológico</label>
                                    <select name="NNATranstornoNeurologico" v-model="NNATranstornoNeurologico" class="form-control">
                                    <<option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Especificar Trastorno Neurológico Principal</label>
                                    <select name="NNAEspecificaTranstornoNeurologico" v-model="NNAEspecificaTranstornoNeurologico" class="form-control">
                                    <option value="">Epilepsia</option>
                                    <option value="">Alzheimer</option>
                                    <option value="">Accidente cerebrovascular</option>
                                    <option value="">Migraña</option>
                                    <option value="">Esclerosis Múltiple</option>
                                    <option value="">Parkinson</option>
                                    <option value="">Infecciones Neurológica</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Solo a menor 36 meses ¿Recibió atenciones de CRED en el último mes? </label>
                                    <select name="NNACRED" v-model="NNACRED" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Solo a menor de 5 años ¿Recibió vacunas en el último mes? ¿Recibió vacunas según esquema de vacunación?</label>
                                    <select name="NNAVacunas" v-model="NNAVacunas" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Patología Crónica 1</label>
                                    <select name="NNAPatologia1" v-model="NNAPatologia1" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Diagnósticos 1 según CIE 10 </label>
                                    <select name="NNADesPatologia1" v-model="NNADesPatologia1" class="form-control">
                                    <option value="">VIH</option>
                                    <option value="">TBC</option>
                                    <option value="">Hepatitis</option>
                                    <option value="">Insuficiencia Renal</option>
                                    <option value="">Hipertensión</option>
                                    <option value="">DCI</option>
                                    <option value="">Diabetes</option>
                                    <option value="">Cancer</option>
                                    <option value="">Estreñimiento</option>
                                    <option value="">Otros</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Patología Crónica 2</label>
                                    <select name="NNAPatologia2" v-model="NNAPatologia2" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Diagnósticos 3 según CIE 10 </label>
                                    <select name="NNADiagnostico3" v-model="NNADiagnostico3" class="form-control">
                                    <option value="">VIH</option>
                                    <option value="">TBC</option>
                                    <option value="">Hepatitis</option>
                                    <option value="">Insuficiencia Renal</option>
                                    <option value="">Hipertensión</option>
                                    <option value="">DCI</option>
                                    <option value="">Diabetes</option>
                                    <option value="">Cancer</option>
                                    <option value="">Estreñimiento</option>
                                    <option value="">Otros</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Presenta Transtorno de Comportamiento y/o disociales</label>
                                    <select name="NNATrastornoComportamiento" v-model="NNATrastornoComportamiento" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Tipo de Transtorno </label>
                                    <select name="NNaTipoTranstorno" v-model="NNaTipoTranstorno" class="form-control">
                                    <option value="">Ninguna</option>
                                    <option value="">Transtorno Depresivo</option>
                                    <option value="">Transtornos Disociales</option>
                                    <option value="">Transtornos por Deficit de Atención</option>
                                    <option value="">Transtornos por Abuso de Sustancias</option>
                                    <option value="">Transtornos de Conducta Alimentaria</option>
                                    <option value="">Transtornos de la personalidad</option>
                                    <option value="">Demencia</option>
                                    <option value="">Otros</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Gestante</label>
                                    <select name="NNAGestante" v-model="NNAGestante" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Semanas de Gestación </label>
                                <input type="number" min="0"  v-model="NNASemanaGestacion" name="NNASemanaGestacion" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Ha Acudido a Control Parental</label>
                                    <select name="NNAControlParental" v-model="NNAControlParental" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">NNA tiene hijos </label>
                                    <select name="NNATieneHijos" v-model="NNATieneHijos" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Número de hijos de residentes en los CAR</label>
                                <input type="number" min="0"  v-model="NNANumHijos" name="NNANumHijos" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nivel de Hemoglobina (gr./dl.) </label>
                                <input type="text" v-model="NNANivelHemoglobina" name="NNANivelHemoglobina" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Presenta Anemia</label>
                                    <select name="NNAAnemia" v-model="NNAAnemia" class="form-control">
                                    <option value="">Leve</option>
                                    <option value="">Moderada</option>
                                    <option value="">Severa</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Peso (kg.)</label>
                                <input type="number" min="0"  v-model="NNAPeso" name="NNAPeso" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Talla (mt)</label>
                                <input type="number" min="0"  v-model="NNATalla" name="NNATalla" placeholder="" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Estado Nutricional (Peso para la talla) </label>
                                <select name="NNAEstadoNutricionalPeso" v-model="NNAEstadoNutricionalPeso" class="form-control">
                                    <option value="">Bajo Peso</option>
                                    <option value="">Normal</option>
                                    <option value="">Sobrepeso</option>
                                    <option value="">Obesidad</option>
                                    <option value="">Obesidad Mórbida</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Estado Nutricional (Talla para la edad) </label>
                                <select name="NNAEstadoNutricionalTalla" v-model="NNAEstadoNutricionalTalla" class="form-control">
                                    <option value="">Baja Talla</option>
                                    <option value="">Normal</option>
                                    <option value="">Alto</option>
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