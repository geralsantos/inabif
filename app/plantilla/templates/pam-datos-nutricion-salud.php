<template id="pam-datos-nutricion-salud">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de Salud y Nutrición del Residente</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
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
                                <select name="select" v-model="select" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Presenta Discapacidad Física</label>
                                <select name="discapacidad_fisica" v-model="discapacidad_fisica" class="form-control">
                                <option value="No">No</option>
                                <option value="Leve">Leve</option>
                                <option value="Moderada">Moderada</option>
                                <option value="Severa">Severa</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Presenta Discapacidad Intelectual</label>
                                <select name="discapacidad_intelectual" v-model="discapacidad_intelectual" class="form-control">
                                <option value="Nuclear">Nuclear</option>
                                <option value="Extensa">Extensa</option>
                                <option value="Mononuclear">Mononuclear</option>
                                </select>  </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Presenta Discapacidad Sensorial</label>
                                    <select name="discapacidad_sensorial" v-model="discapacidad_sensorial" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Leve">Leve</option>
                                    <option value="Moderada">Moderada</option>
                                    <option value="Severa">Severa</option>
                                    </select> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Presenta Discapacidad Mental</label>
                                    <select name="presenta_discapacidad_mental" v-model="presenta_discapacidad_mental" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Leve">Leve</option>
                                    <option value="Moderada">Moderada</option>
                                    <option value="Severa">Severa</option>
                                    </select> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">El Dx es Certificado</label>
                                    <select name="dx_certificado" v-model="dx_certificado" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select> 
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Tiene Carnet del CONADIS</label>
                                    <select name="selcarnet_conadisect" v-model="carnet_conadis" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    <option value="Se desconoce">Se desconoce</option>
                                    </select> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Grado Dependencia de la PAM</label>
                                    <select name="selecgrado_dependencia_pamt" v-model="grado_dependencia_pam" class="form-control">
                                        <option value="Autovalente">Autovalente</option>
                                        <option value="Frágil/Postrada">Frágil/Postrada</option>
                                        <option value="Geríatrica compleja">Geríatrica compleja</option>
                                    </select> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Motivo de Dificultad con el Desplazamiento</label>
                                    <select name="motivo_dif_desplazamiento" v-model="motivo_dif_desplazamiento" class="form-control">
                                    <option value="Musculoesqueléticas">Musculoesqueléticas,</option>
                                    <option value="Neurológicas">Neurológicas</option>
                                    <option value="Cardiovasculares">Cardiovasculares</option>
                                    <option value="Pulmonares">Pulmonares</option>
                                    <option value="Factores psicológicos">Factores psicológicos</option>
                                    <option value="Otras">Otras</option>
                                    <option value="No tiene">No tiene</option>
                                    </select> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Enfermedad de Ingreso 1</label>
                                    <select name="enfermedad_ingreso_1" v-model="enfermedad_ingreso_1" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Tipo de Patología </label>
                                    <select name="tipo_patologia" v-model="tipo_patologia" class="form-control">
                                    <option v-for="patologia in patologias" :value="patologia.ID">{{patologia.NOMBRE}}</option>
                                    </select> 
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Enfermedad de Ingreso 2</label>
                                    <select name="enfermedad_ingreso_2" v-model="enfermedad_ingreso_2" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select> 
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Tipo de Patología 2</label>
                                    <select name="tipo_patologia_2" v-model="tipo_patologia_2" class="form-control">
                                    <option v-for="patologia in patologias" :value="patologia.ID">{{patologia.NOMBRE}}</option>
                                    </select> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Nivel de Hemoglobina</label>
                                <input type="number" v-model="nivel_hemoglobina" name="nivel_hemoglobina" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Presenta Anemia</label>
                                    <select name="presenta_anema" v-model="presenta_anema" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Leve">Leve</option>
                                    <option value="Moderada">Moderada</option>
                                    <option value="Severa">Severa</option>
                                    </select> 
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Peso (kg.)</label>
                                <input type="number" v-model="peso" name="peso" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Talla (mt)</label>
                                <input type="number" v-model="talla" name="talla" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Estado Nutricional (IMC) </label>
                                <select name="estado_nutricional" v-model="estado_nutricional" class="form-control">
                                    <option value="Normal">Normal</option>
                                    <option value="Desnutrición">Desnutrición</option>
                                    </select> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center" >
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-send"></i> Grabar Datos
                                </button>
                            </div>
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div> <!-- .content -->
</template>