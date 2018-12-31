<template id="nna-seguimiento-salud">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Salud</strong>
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
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Plan de intervención de salud</label>
                                <select name="Intervencion" v-model="Intervencion" class="form-control">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Diagnóstico Psiquiátrico 1 (CIE-10)</label>
                                <input type="number" min="0" v-model="Diagnostico_Psiquiatrico_1" name="Diagnostico_Psiquiatrico_1"  placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Diagnóstico Psiquiátrico 2 (CIE-10)</label>
                                <input type="number" min="0" v-model="Diagnostico_Psiquiatrico_2" name="Diagnostico_Psiquiatrico_2"  placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico Psiquiátrico 3 (CIE-10)</label>
                                <input type="number" min="0" v-model="Diagnostico_Psiquiatrico_2" name="Diagnostico_Psiquiatrico_2"  placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico Neurológico 1 (CIE-10)</label>
                                <input type="number" min="0" v-model="Diagnostico_Neurologico_1" name="Diagnostico_Neurologico_1"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico Neurológico 2 (CIE-10)</label>
                                <input type="number" min="0" v-model="Diagnostico_Neurologico_2" name="Diagnostico_Neurologico_2"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico Neurológico 3 (CIE-10)</label>
                                <input type="number" min="0" v-model="Diagnostico_Neurologico_3" name="Diagnostico_Neurologico_3"  placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico  Crónico 1 (CIE-10)</label>
                                <input type="number" min="0" v-model="Diagnostico_Cronico_1" name="Diagnostico_Cronico_1"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico  Crónico 2 (CIE-10)</label>
                                <input type="number" min="0" v-model="Diagnostico_Cronico_2" name="Diagnostico_Cronico_2"   placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label"> Diagnóstico  Crónico 3 (CIE-10)</label>
                                <input type="number" min="0" v-model="Diagnostico_Cronico_3" name="Diagnostico_Cronico_3"  placeholder="" class="form-control">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico  Agudo 1 (CIE-10)</label>
                                <input type="number" min="0" v-model="Diagnostico_Agudo_1" name="Diagnostico_Agudo_1"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico  Agudo 2 (CIE-10)</label>
                                <input type="number" min="0" v-model="Diagnostico_Agudo_1" name="Diagnostico_Agudo_1"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Diagnóstico  Agudo 3 (CIE-10)</label>
                                <input type="number" min="0" v-model="Diagnostico_Agudo_1" name="Diagnostico_Agudo_1"  placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">¿Residente presenta VIH?</label>
                                <select name="VIH" v-model="VIH" class="form-control">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">¿Residente presenta ETS?</label>
                                    <select name="ETS" v-model="ETS" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">¿Residente presenta TBC?</label>
                                    <select name="TBC" v-model="TBC" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">¿Residente presenta HEPATITIS A?</label>
                                <select name="HepatitisA" v-model="HepatitisA" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                            <label for="text-input" class=" form-control-label">¿Residente presenta HEPATITIS B?</label>
                                <select name="HepatitisB" v-model="HepatitisB" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">¿Residente presenta Caries dental?</label>
                                <select name="Caries" v-model="Caries" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Discapacidad</label>
                                    <select name="Discapacidad" v-model="Discapacidad" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">¿Presenta discapacidad física?</label>
                                    <select name="Discapacidad_Fisica" v-model="Discapacidad_Fisica" class="form-control">
                                        <option value="No">No</option>
                                        <option value="Leve">Leve</option>
                                        <option value="Moderada">Moderada</option>
                                        <option value="Severa">Severa</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">¿Presenta discapacidad intelectual?</label>
                                <select name="Discapacidad_Intelectual" v-model="Discapacidad_Intelectual" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Leve">Leve</option>
                                    <option value="Moderada">Moderada</option>
                                    <option value="Severa">Severa</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">¿Presenta discapacidad sensorial?</label>
                                <select name="Discapacidad_Sensorial" v-model="Discapacidad_Sensorial" class="form-control">
                                <option value="No">No</option>
                                    <option value="Leve">Leve</option>
                                    <option value="Moderada">Moderada</option>
                                    <option value="Severa">Severa</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">¿Presenta discapacidad mental?</label>
                                <select name="Discapacidad_Mental" v-model="Discapacidad_Mental" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Leve">Leve</option>
                                    <option value="Moderada">Moderada</option>
                                    <option value="Severa">Severa</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">SIS</label>
                                <select name="SIS" v-model="SIS" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">ESSALUD</label>
                                <select name="ESSALUD" v-model="ESSALUD" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">¿Otro tipo de Seguro de Salud?</label>
                                <select name="Tipo_Seguro" v-model="Tipo_Seguro" class="form-control">
                                    <option value="ESSALUD">ESSALUD</option>
                                    <option value="FFAA_PNP">FFAA_PNP</option>
                                    <option value="Seguro Privado">Seguro Privado</option>
                                    <option value="Seguro Integral de Salud(SIS)">Seguro Integral de Salud(SIS)</option>
                                    <option value="Otro">Otro</option>
                                    <option value="No Tiene">No Tiene</option>
                                </select>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">¿CONADIS?</label>
                                <select name="CONADIS" v-model="CONADIS" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <div class='row'>
                        <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Medicina General</label>
                                <input type="number" min="0" v-model="A_Medicina_General" name="A_Medicina_General"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Cirugía General</label>
                                <input type="number" min="0" v-model="A_Cirujia_General" name="A_Cirujia_General"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Traumatología</label>
                                <input type="number" min="0" v-model="A_Traumatologia" name="A_Traumatologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Odontología</label>
                                <input type="number" min="0" v-model="A_Odontologia" name="A_Odontologia"  placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Medicina Interna</label>
                                <input type="number" min="0" v-model="A_Medicina_Interna" name="A_Medicina_Interna"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº  Atención en Cardiovascular</label>
                                <input type="number" min="0" v-model="A_Cardiovascular" name="A_Cardiovascular"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº  Atención en Dermatología</label>
                                <input type="number" min="0" v-model="A_Dermatologia" name="A_Dermatologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Endocrinología</label>
                                <input type="number" min="0" v-model="A_Endrocrinologia" name="A_Endrocrinologia"  placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Gastroenterología</label>
                                <input type="number" min="0" v-model="A_Gastroentrologia" name="A_Gastroentrologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Gíneco-obstetricia</label>
                                <input type="number" min="0" v-model="A_Gineco_Obstetricia" name="A_Gineco_Obstetricia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Hematología</label>
                                <input type="number" min="0" v-model="A_Hermatologia" name="A_Hermatologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Nefrología</label>
                                <input type="number" min="0" v-model="A_Nefrologia" name="A_Nefrologia"  placeholder="" class="form-control">
                            </div>
                        </div>

                            <div class='row'>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Infectología</label>
                                <input type="number" min="0" v-model="A_Infectologia" name="A_Infectologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Inmunología y Alergias</label>
                                <input type="number" min="0" v-model="A_Inmunologia" name="A_Inmunologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Reumatología</label>
                                <input type="number" min="0" v-model="A_Reumatologia" name="A_Reumatologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Neumología</label>
                                <input type="number" min="0" v-model="A_Neumologia" name="A_Neumologia"  placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class='row'>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Neurología</label>
                                <input type="number" min="0" v-model="A_Neurologia" name="A_Neurologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Oftalmología</label>
                                <input type="number" min="0" v-model="A_Oftalmologia" name="A_Oftalmologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Otorrinolaringología</label>
                                <input type="number" min="0" v-model="A_Otorrinolaringologia" name="A_Otorrinolaringologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Oncología</label>
                                <input type="number" min="0" v-model="A_Oncologia" name="A_Oncologia"  placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Psiquiatría</label>
                                <input type="number" min="0" v-model="A_Psicriatica" name="A_Psicriatica"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Cirugía </label>
                                <input type="number" min="0" v-model="A_Cirujia" name="A_Cirujia"  placeholder="" class="form-control">
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Urología</label>
                                <input type="number" min="0" v-model="A_Urologia" name="A_Urologia"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Nutrición </label>
                                <input type="number" min="0" v-model="A_Nutricion" name="A_Nutricion"  placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            
                            
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Pedriatría/CRED</label>
                                <input type="number" min="0" v-model="A_Pedriatria" name="A_Pedriatria"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Medicina Física y Rehabilitación</label>
                                <input type="number" min="0" v-model="A_Rehabilitacion" name="A_Rehabilitacion"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Ginecología del niño y adolescente</label>
                                <input type="number" min="0" v-model="A_Gineco_Menores" name="A_Gineco_Menores"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atención en Psicología</label>
                                <input type="number" min="0" v-model="A_Psicologia" name="A_Psicologia" placeholder=""  class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Total de atenciones</label>
                                <input type="number" min="0" v-model="Atencion_Total" name="Atencion_Total"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">¿Usuario hospitalizado'</label>
                                <select name="Hospitalizado" v-model="Hospitalizado" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">¿Atendido por Emergencia hospital?</label>
                                <select name="Emergencia" v-model="Emergencia" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">¿Inscrito en CRED?</label>
                                <select name="CRED" v-model="CRED" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <div class='row'>
                            
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">¿Carnet de inmunización?</label>
                                <select name="Inmunizacion" v-model="Inmunizacion" class="form-control">
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
    </div> 


</template>