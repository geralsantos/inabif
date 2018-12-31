<template id="nna-seguimiento-salud">
  <!--  <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Salud</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Plan de intervención de salud</label>
                                <select name="NNAPlanIntervencion" v-model="NNAPlanIntervencion" class="form-control">
                                <option value="">Si</option>
                                <option value="">No</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Diagnóstico Psiquiátrico 1 (CIE-10)</label>
                                <input type="number" v-model="NNAPsiquiatrico1" name="NNAPsiquiatrico1" value='' placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Diagnóstico Psiquiátrico 2 (CIE-10)</label>
                                <input type="number" v-model="NNAPsiquiatrico2" name="NNAPsiquiatrico2" value='' placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico Psiquiátrico 3 (CIE-10)</label>
                                <input type="number" v-model="NNAPsiquiatrico3" name="NNAPsiquiatrico3" value='' placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico Neurológico 1 (CIE-10)</label>
                                <input type="number" v-model="NNANeurologico1" name="NNANeurologico1" value='' placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico Neurológico 2 (CIE-10)</label>
                                <input type="number" v-model="NNANeurologico2" name="NNANeurologico2" value='' placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico Neurológico 3 (CIE-10)</label>
                                <input type="number" v-model="NNANeurologico3" name="NNANeurologico3" value='' placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico  Crónico 1 (CIE-10)</label>
                                <input type="number" v-model="NNACronico1" name="NNACronico1" value='' placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico  Crónico 2 (CIE-10)</label>
                                <input type="number" v-model="NNACronico2" name="NNACronico2"  value='' placeholder="" class="form-control">

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label"> Diagnóstico  Crónico 3 (CIE-10)</label>
                                <input type="number" v-model="NNACronico3" name="NNACronico3" value='' placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Diagnóstico  Agudo 1 (CIE-10)</label>
                                <input type="number" v-model="NNAAgudo1" name="NNAAgudo1" value='' placeholder="" class="form-control">

                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Diagnóstico  Agudo 2 (CIE-10)</label>
                                <input type="number" v-model="NNAAgudo2" name="NNAAgudo2" value='' placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Diagnóstico  Agudo 3 (CIE-10)</label>
                                <input type="number" v-model="NNAAgudo3" name="NNAAgudo3" value='' placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Residente presenta VIH ?</label>
                                <select name="NNAPresentaVIH" v-model="NNAPresentaVIH" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Residente presenta ETS?</label>
                                    <select name="NNAPresentaETS" v-model="NNAPresentaETS" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Residente presenta HEPATITIS A?</label>
                                <select name="NNAHepatitisA" v-model="NNAHepatitisA" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                            <label for="text-input" class=" form-control-label">Residente presenta HEPATITIS B?</label>
                                <select name="NNAHepatitisB" v-model="NNAHepatitisB" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Residente presenta Caries dental?</label>
                                <select name="NNACariesDental" v-model="NNACariesDental" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">DISCAPACIDAD</label>
                                    <select name="NNADiscapacidad" v-model="NNADiscapacidad" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Presenta discapacidad física?</label>
                                    <select name="NNADiscapacidadFisica" v-model="NNADiscapacidadFisica" class="form-control">
                                    <option value="">No</option>
                                    <option value="">Leve</option>
                                    <option value="">Moderada</option>
                                    <option value="">Severa</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Presenta discapacidad intelectual?</label>
                                <select name="NNADiscapacidadIntelectual" v-model="NNADiscapacidadIntelectual" class="form-control">
                                    <option value="">No</option>
                                    <option value="">Leve</option>
                                    <option value="">Moderada</option>
                                    <option value="">Severa</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Presenta discapacidad sensorial?</label>
                                <select name="NNADiscapacidadSensorial" v-model="NNADiscapacidadSensorial" class="form-control">
                                    <option value="">No</option>
                                    <option value="">Leve</option>
                                    <option value="">Moderada</option>
                                    <option value="">Severa</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Presenta discapacidad mental?</label>
                                <select name="NNADiscapacidadMental" v-model="NNADiscapacidadMental" class="form-control">
                                    <option value="">No</option>
                                    <option value="">Leve</option>
                                    <option value="">Moderada</option>
                                    <option value="">Severa</option>
                                </select>
                            </div>

                        </div>

                        <div class='row'>
                        <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">SIS</label>
                                <select name="NNASIS" v-model="NNASIS" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">ESSALUD</label>
                                <select name="NNAESSALUD" v-model="NNAESSALUD" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Otro tipo de Seguro de Salud?</label>
                                <select name="NNATipoSEguro" v-model="NNATipoSEguro" class="form-control">
                                    <option value="">ESSALUD</option>
                                    <option value="">FFAA_PNP</option>
                                    <option value="">Seguro Privado</option>
                                    <option value="">Seguro Integral de Salud(SIS)</option>
                                    <option value="">Otro</option>
                                    <option value="">No Tiene</option>
                                </select>

                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">CONADIS?</label>
                                <select name="NNAConadis" v-model="NNAConadis" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                        </div>

                        <div class='row'>
                        <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Medicina General</label>
                                <input type="number" v-model="NNAMedicinaGeneral" name="NNAMedicinaGeneral"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Cirugía General</label>
                                <input type="number" v-model="NNACirugiaGeneral" name="NNACirugiaGeneral"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Traumatología</label>
                                <input type="number" v-model="NNATraumatologia" name="NNATraumatologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Odontología</label>
                                <input type="number" v-model="NNAOdontologia" name="NNAOdontologia"  placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Medicina Interna</label>
                                <input type="number" v-model="NNAMedicinaInterna" name="NNAMedicinaInterna"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº  Atención en Cardiovascular</label>
                                <input type="number" v-model="NNACardiovascular" name="NNACardiovascular"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº  Atención en Dermatología</label>
                                <input type="number" v-model="NNADermatologia" name="NNADermatologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Endocrinología</label>
                                <input type="number" v-model="NNAEndrocrinologia" name="NNAEndrocrinologia"  placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Gastroenterología</label>
                                <input type="number" v-model="NNAGastroentrologia" name="NNAGastroentrologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Gíneco-obstetricia</label>
                                <input type="number" v-model="NNAGinecoObstetricia" name="NNAGinecoObstetricia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Hematología</label>
                                <input type="number" v-model="NNAHematologia" name="NNAHematologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Nefrología</label>
                                <input type="number" v-model="NNANefrologia" name="NNANefrologia"  placeholder="" class="form-control">
                            </div>
                        </div>

                            <div class='row'>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Infectología</label>
                                <input type="number" v-model="NNAInfectologia" name="NNAInfectologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Inmunología y Alergias</label>
                                <input type="number" v-model="NNAInmunologia" name="NNAInmunologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Reumatología</label>
                                <input type="number" v-model="NNAReumatologia" name="NNAReumatologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Neumología</label>
                                <input type="number" v-model="NNAneumologia" name="NNAneumologia"  placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class='row'>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Neurología</label>
                                <input type="number" v-model="NNANeurologia" name="NNANeurologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Oftalmología</label>
                                <input type="number" v-model="NNAOftamologia" name="NNAOftamologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Otorrinolaringología</label>
                                <input type="number" v-model="NNAOtorrinolaringologia" name="NNAOtorrinolaringologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Oncología</label>
                                <input type="number" v-model="NNAOncologia" name="NNAOncologia"  placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Psiquiatría</label>
                                <input type="number" v-model="NNAPsiquiatria" name="NNAPsiquiatria"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Cirugía </label>
                                <input type="number" v-model="NNACirujia" name="NNACirujia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Traumatología</label>
                                <input type="number" v-model="NNATraumatologia" name="NNATraumatologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Urología</label>
                                <input type="number" v-model="NNAUrologia" name="NNAUrologia"  placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Odontología</label>
                                <input type="number" v-model="NNAOdontologia" name="NNAOdontologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Nutrición </label>
                                <input type="number" v-model="NNANutricion" name="NNANutricion"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Pedriatría/CRED</label>
                                <input type="number" v-model="NNAPedriatria" name="NNAPedriatria"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Medicina Física y Rehabilitación</label>
                                <input type="number" v-model="NNAMedicinaFisica" name="NNAMedicinaFisica"  placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Ginecología del niño y adolescente</label>
                                <input type="number" v-model="NNAGinecologiaAdolescentes" name="NNAGinecologiaAdolescentes"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Psicología</label>
                                <input type="number" v-model="NNAPsicologia" name="NNAPsicologia" placeholder=""  class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Total de atenciones</label>
                                <input type="number" v-model="NNATotalAtenciones" name="NNATotalAtenciones"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Usuario hospitalizado</label>
                                <select name="NNAHospitalizado" v-model="NNAHospitalizado" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Atendido por Emergencia hospital?</label>
                                <select name="NNAEmergenciaHospital" v-model="NNAEmergenciaHospital" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Inscrito en CRED ?</label>
                                <select name="NNAInscritoCred" v-model="NNAInscritoCred" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Carné de inmunización?</label>
                                <select name="NNACarnetInmunizacion" v-model="NNACarnetInmunizacion" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
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
    </div> 

    -->
</template>