<template id="ppd-datos-salud-nutricion">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de salud y nutricion del Usuario</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <div class="row form-group">
                        <div class="col-12 col-md-1">
                            <label for="text-input" class=" form-control-label"></label>
                            <button @click="mostrar_lista_residentes()" class="btn btn-primary"><i class="fa fa fa-users"></i> Lista de Residentes</button>
                        </div>
                    </div>
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
                                <label for="text-input" class=" form-control-label">¿El Dx es certtificado?</label>
                                <select name="CarDxCertificado" v-model="CarDxCertificado" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="text-input" class=" form-control-label">Tiene carnet del CONADIS?</label>
                                <select name="CarCarnetConadis" v-model="CarCarnetConadis" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    <option value="Se desconoce">Se desconoce</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Movilidad</label>
                                <select name="CarMovilidad" v-model="CarMovilidad" class="form-control">
                                    <option value="Camina">Camina</option>
                                    <option value="Camina con torpeza">Camina con torpeza</option>
                                    <option value="Camina con apoyo">Camina con apoyo</option>
                                    <option value="Se moviliza con silla de ruedas">Se moviliza con silla de ruedas</option>
                                    <option value="Lo trasladan en silla de ruedas">Lo trasladan en silla de ruedas</option>
                                </select>
                            </div>
                        
                            <div class="form-group col-md-3">
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
                                    <option v-for="dificultad in dificultades" :value="dificultad.ID">{{dificultad.NOMBRE}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                <div class=" "><label for="text-input" class=" form-control-label">Patología crónica 1</label>
                                <select name="CarPatologica1" v-model="CarPatologica1" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    <option value="No se sabe">No se sabe</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Tipo de patología</label>
                                <select name="CarTipoPatologia1" v-model="CarTipoPatologia1" class="form-control">
                                    <option v-for="patologia in patologias" :value="patologia.ID">{{patologia.NOMBRE}}</option>

                                </select>
                            </div>

                            <div class="form-group col-md-7">
                                <label for="text-input" class=" form-control-label">Especifique tipo de patología</label>
                                <input type="text" v-model="CarEspecifiquePato1" name="CarEspecifiquePato1" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                <div class=" "><label for="text-input" class=" form-control-label">Patología crónica 2</label>
                                <select name="CarPatologia2" v-model="CarPatologia2" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    <option value="No se sabe">No se sabe</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Tipo de patología</label>
                                <select name="CarTipoPatologia2" v-model="CarTipoPatologia2" class="form-control">
                                    <option v-for="patologia2 in patologias2" :value="patologia2.ID">{{patologia2.NOMBRE}}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-7">
                                <label for="text-input" class=" form-control-label">Especifique tipo de patología</label>
                                <input type="text" v-model="CarEspecifiquePato2" name="CarEspecifiquePato2" placeholder="" class="form-control">
                            </div>
                        </div>

                            <div class="row">
                            <div class="form-group col-md-3">
                                <div class=" "><label for="text-input" class=" form-control-label">Nivel de Hemoglobina</label>
                                <input type="number" step="0.1" v-model="CarNivelHemoglobina" name="CarNivelHemoglobina" placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="text-input" class=" form-control-label">¿Presenta anemia?</label>
                                <select name="CarAnemia" v-model="CarAnemia" class="form-control">
                                <option value="Leve">Leve</option>
                                <option value="Moderada">Moderada</option>
                                <option value="Severa">Severa</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="text-input" class=" form-control-label">Peso (Kg.)</label>
                                <input type="number" step="0.1" v-model="CarPeso" name="CarPeso" placeholder="" class="form-control">
                            </div>

                                <div class="form-group col-md-2">
                                <label for="text-input" class=" form-control-label">Talla (m)</label>
                                <input type="number" step="0.1" v-model="CarTalla" name="CarTalla" placeholder="" class="form-control">
                            </div>
                      
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Estado nutricional (imc) </label>
                                <select name="CarEstadoNutricional" v-model="CarEstadoNutricional" class="form-control">
                                <option value="Bajo Peso">Bajo Peso</option>
                                <option value="Normal">Normal</option>
                                <option value="Sobre Peso">Sobre Peso</option>
                                <option value="Obesidad">Obesidad</option>
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
        <div v-if="modal_lista">
             <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">

                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Lista Residentes</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" @click="modal_lista = false">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark text-center">
                                            <tr>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Número de Documento</th>
                                                <th scope="col">Opción</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr v-for="residente in pacientes">
                                                <td>{{residente.NOMBRE}} {{residente.APELLIDO}}</td>
                                                <td>{{residente.DOCUMENTO}}</td>
                                                <td><button class="btn btn-primary" @click="elegir_residente(residente)">Seleccionar</button></td>
                                            
                                            </tr>
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="modal_lista = false">Cerrar</button>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </transition>
        </div>
    </div> <!-- .content -->
</template>