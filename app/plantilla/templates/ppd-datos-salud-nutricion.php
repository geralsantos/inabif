<template id="ppd-datos-salud-nutricion">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de salud y nutricion del Usuario</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form  class="form-horizontal" v-on:submit.prevent="guardar">
                    <div class="row">
                            <div class="form-group col-md-7">
                                <label for="text-input" class=" form-control-label">Nombre Residente</label>
                                <div class="autocomplete">
                                    <input type="text"  v-model="nombre_residente" class="form-control" @keyup="buscar_residente()"/>
                                    <ul  id="autocomplete-results" class="autocomplete-results" v-if="bloque_busqueda">
                                        <li class="loading" v-if="isLoading">
                                            Loading results...
                                        </li>
                                        <li  @click="actualizar(coincidencia.id)" class="autocomplete-result" v-for="coincidencia in coincidencias">
                                            {{coincidencia.nombre}}
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="text-input" class=" form-control-label">Año</label>
                                <select name="select" id="anio"  v-model="anio" class="form-control">
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                </select>

                            </div>
                            <div class="form-group col-md-3">
                                <div class=""><label for="text-input" class=" form-control-label">Mes</label>
                                <select id="mes" v-model="mes" class="form-control" >
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
                                <label for="text-input" class=" form-control-label">DISCAPACIDAD</label>
                                <select name="CarDiscapacidad" v-model="CarDiscapacidad" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Presenta discapacidad física</label>
                                <select name="CarDiscapacidadFisica" v-model="CarDiscapacidadFisica" class="form-control">
                                    <option value="No">NO</option>
                                    <option value="Leve">LEVE</option>
                                    <option value="Moderada">MODERADA</option>
                                    <option value="Severa">SEVERA</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Presenta discapacidad intelectual</label>
                                <select name="CarDiscapacidadIntelectual" v-model="CarDiscapacidadIntelectual" class="form-control">
                                <option value="No">NO</option>
                                    <option value="Leve">LEVE</option>
                                    <option value="Moderada">MODERADA</option>
                                    <option value="Severa">SEVERA</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Presenta discapacidad sensorial</label>
                                <select name="CarDiscapacidadSensorial" v-model="CarDiscapacidadSensorial" class="form-control">
                                <option value="No">NO</option>
                                    <option value="Leve">LEVE</option>
                                    <option value="Moderada">MODERADA</option>
                                    <option value="Severa">SEVERA</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Presenta discapacidad mental</label>
                                <select name="CarDiscapacidadMental" v-model="CarDiscapacidadMental" class="form-control">
                                <option value="No">NO</option>
                                    <option value="Leve">LEVE</option>
                                    <option value="Moderada">MODERADA</option>
                                    <option value="Severa">SEVERA</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">El Dx es certtificado?</label>
                                <select name="CarDxCertificado" v-model="CarDxCertificado" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Tiene carnet del CONADIS?</label>
                                <select name="CarCarnetConadis" v-model="CarCarnetConadis" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    <option value="Se desconoce">Se desconoce</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Movilidad</label>
                                <select name="CarMovilidad" v-model="CarMovilidad" class="form-control">
                                    <option value="Camina">Camina</option>
                                    <option value="Camina con torpeza">Camina con torpeza</option>
                                    <option value="Camina con apoyo">Camina con apoyo</option>
                                    <option value="Se moviliza con silla de ruedas">Se moviliza con silla de ruedas</option>
                                    <option value="Lo trasladan en silla de ruedas">Lo trasladan en silla de ruedas</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Motivo de dificultad con el desplazamiento</label>
                                <select name="CarDificultadDesplazamiento" v-model="CarDificultadDesplazamiento" class="form-control">
                                    <option value="Músculo esqueléticas">Músculo esqueléticas</option>
                                    <option value="Neurológicas">Neurológicas</option>
                                    <option value="Cardiovasculares">Cardiovasculares</option>
                                    <option value="Pulmonares">Pulmonares</option>
                                    <option value="Factores psicológicos">Factores psicológicos</option>
                                    <option value="Otros">Otros</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Dificultad que presenta para movimiento de brazos y cuerpo</label>
                                <select name="CarDificultadBrazoCuerpo" v-model="CarDificultadBrazoCuerpo" class="form-control">
                                    <option value="Monoplejia(afecta un solo miembro del cuerpo)">Monoplejia(afecta un solo miembro del cuerpo)</option>
                                    <option value="Diplejia  (Afecta las extremidades inferiores-Piernas)">Diplejia  (Afecta las extremidades inferiores-Piernas)</option>
                                    <option value="Hermano/a">Hermano/a</option>
                                    <option value="Triplejia(Afecta un miembro superior-brazo, y las extremidades inferiores-piernas)">Triplejia(Afecta un miembro superior-brazo, y las extremidades inferiores-piernas)</option>
                                    <option value="Hemiplejia (afecta el lado izquierdo o derecho del cuerpo)">Hemiplejia (afecta el lado izquierdo o derecho del cuerpo)</option>
                                    <option value="Cuadriplejia (afecta las cuatro extremidades del cuerpo)">Cuadriplejia (afecta las cuatro extremidades del cuerpo)</option>
                                    <option value="Ninguna">Ninguna</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Patología 1</label>
                                <select name="CarPatologica1" v-model="CarPatologica1" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    <option value="No se sabe">No se sabe</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Tipo de patología</label>
                                <select name="CarTipoPatologia1" v-model="CarTipoPatologia1" class="form-control">
                                <option value="Enfermedad pulmonar crónica tal como asma, bronquitis o enfisema">Enfermedad pulmonar crónica tal como asma, bronquitis o enfisema</option>
                                <option value="Hipertensión">Hipertensión</option>
                                <option value="Diabetes">Diabetes</option>
                                <option value="Depresión">Depresión </option>
                                <option value="Cáncer o un tumor maligno">Cáncer o un tumor maligno</option>
                                <option value="Enfermedad cardiaca congestiva u otros problemas del corazón">Enfermedad cardiaca congestiva u otros problemas del corazón</option>
                                <option value="Derrame o hemorragia cerebral">Derrame o hemorragia cerebral</option>
                                <option value="Artritis, reumatismo o artrosis">Artritis, reumatismo o artrosis</option>
                                <option value="Osteoporosis (perdida de calcio en los huesos)">Osteoporosis (perdida de calcio en los huesos)</option>
                                <option value="Insuficiencia renal crónica (problemas de riñón)">Insuficiencia renal crónica (problemas de riñón)</option>
                                <option value="Enfermedades del sistema nervioso, Alzheimer o pérdida de memoria">Enfermedades del sistema nervioso, Alzheimer o pérdida de memoria</option>
                                <option value="TBC">TBC</option>
                                <option value="Otro (Especifique)">Otro (Especifique)</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Especifique</label>
                                <input type="text" v-model="CarEspecifiquePato1" name="CarEspecifiquePato1" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Patología 2</label>
                                <select name="CarPatologia2" v-model="CarPatologia2" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    <option value="No se sabe">No se sabe</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Tipo de patología</label>
                                <select name="CarTipoPatologia2" v-model="CarTipoPatologia2" class="form-control">
                                <option value="Enfermedad pulmonar crónica tal como asma, bronquitis o enfisema">Enfermedad pulmonar crónica tal como asma, bronquitis o enfisema</option>
                                <option value="Hipertensión">Hipertensión</option>
                                <option value="Diabetes">Diabetes</option>
                                <option value="Depresión">Depresión </option>
                                <option value="Cáncer o un tumor maligno">Cáncer o un tumor maligno</option>
                                <option value="Enfermedad cardiaca congestiva u otros problemas del corazón">Enfermedad cardiaca congestiva u otros problemas del corazón</option>
                                <option value="Derrame o hemorragia cerebral">Derrame o hemorragia cerebral</option>
                                <option value="Artritis, reumatismo o artrosis"></option>
                                <option value="Osteoporosis (perdida de calcio en los huesos)">Osteoporosis (perdida de calcio en los huesos)</option>
                                <option value="Insuficiencia renal crónica (problemas de riñón)">Insuficiencia renal crónica (problemas de riñón)</option>
                                <option value="Enfermedades del sistema nervioso, Alzheimer o pérdida de memoria">Enfermedades del sistema nervioso, Alzheimer o pérdida de memoria</option>
                                <option value="TBC">TBC</option>
                                <option value="Otro (Especifique)">Otro (Especifique)</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Especifique</label>
                                <input type="text" v-model="CarEspecifiquePato2" name="CarEspecifiquePato2" placeholder="" class="form-control">
                            </div>
                        </div>

                            <div class="row">
                            <div class="form-group col-md-3">
                                <div class=" "><label for="text-input" class=" form-control-label">Nivel de Hemoglobina</label>
                                <input type="text" v-model="CarNivelHemoglobina" name="CarNivelHemoglobina" placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">PRESENTA ANEMIA?</label>
                                <select name="CarAnemia" v-model="CarAnemia" class="form-control">
                                <option value="Leve">Leve</option>
                                <option value="Moderada">Moderada</option>
                                <option value="Severa">Severa</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Peso (Kg.)</label>
                                <input type="text" v-model="CarPeso" name="CarPeso" placeholder="" class="form-control">
                            </div>

                                <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Talla (m)</label>
                                <input type="text" v-model="CarTalla" name="CarTalla" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Estado nutricional (imc) </label>
                                <select name="CarEstadoNutricional" v-model="CarEstadoNutricional" class="form-control">
                                <option value="Bajo peso">Bajo peso</option>
                                <option value="Normal">Normal</option>
                                <option value="Sobre peso">Sobre peso</option>
                                <option value="Obesidad">Obesidad</option>
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