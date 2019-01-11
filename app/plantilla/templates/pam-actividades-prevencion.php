<template id="pam-actividades-prevencion">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Actividades de Prevención (Psicólogo)</strong>
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
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Buscar Residente <i class="fa fa-search" aria-hidden="true"></i></label>
                                <div class="autocomplete">
                                    <input type="text"  v-model="nombre_residente" class="form-control campo_busqueda_residente" @keyup="buscar_residente()" placeholder="Nombre, Apellido o DNI"/>
                                    <ul  id="autocomplete-results" class="autocomplete-results" v-if="bloque_busqueda">
                                        <li class="loading" v-if="isLoading">
                                            Loading results...
                                        </li>
                                        <li  @click="actualizar(coincidencia)" class="autocomplete-result" v-for="coincidencia in coincidencias">
                                            {{coincidencia.NOMBRE}} {{coincidencia.APELLIDO_P}} - {{coincidencia.DNI_RESIDENTE}} - {{coincidencia.DOCUMENTO}}
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
                            <div class="form-group col-md-2">
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
                            <div class="form-group col-md-2">
                                <label for="text-input" class=" form-control-label">Código</label>
                                <input type="text" v-model="id" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Atención Psicológica  </label>
                                    <select name="Atencion_Psicologica" v-model="Atencion_Psicologica" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Taller de Habilidades Sociales</label>
                                <select name="Habilidades_Sociales" v-model="Habilidades_Sociales" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select> </div>
                            </div>

                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">N° de Veces que Participa</label>
                                <select name="Nro_Participa" v-model="Nro_Participa" class="form-control">
                                    <option v-for="(i-1) in 30" :value="i">{{i}}</option>
                                </select> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Taller de Autoestima</label>
                                <select name="Taller_Autoestima" v-model="Taller_Autoestima" class="form-control">
                                <option value="Si">Si</option>
                                        <option value="No">No</option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">N° de Veces que Participa</label>
                                    <select name="Nro_Participa_Autoestima" v-model="Nro_Participa_Autoestima" class="form-control">
                                        <option v-for="i in 30" :value="i">{{i}}</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Taller de Manejo  de Situaciones Divergentes</label>
                                <select name="ManejoSituacionesDivergentes" v-model="ManejoSituacionesDivergentes" class="form-control">
                                <option value="Si">Si</option>
                                        <option value="No">No</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">N° de Veces que Participa</label>
                                    <select name="Nro_Participa_Divergentes" v-model="Nro_Participa_Divergentes" class="form-control">
                                        <option v-for="i in 30" :value="i">{{i}}</option>
                                    </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Taller de Control de Emociones</label>
                                <select name="Taller_Control_Emociones" v-model="Taller_Control_Emociones" class="form-control">
                                <option value="Si">Si</option>
                                        <option value="No">No</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">N° de Veces que Participa</label>
                                    <select name="Nro_Participa_Emociones" v-model="Nro_Participa_Emociones" class="form-control">
                                        <option v-for="i in 30" :value="i">{{i}}</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Taller de Conservación de Habilidades Cognitiva</label>
                                <select name="ConservacionHabilidadCognitiva" v-model="ConservacionHabilidadCognitiva" class="form-control">
                                <option value="Si">Si</option>
                                        <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">N° de Veces que Participa</label>
                                    <select name="Nro_Participa_Cognitivas" v-model="Nro_Participa_Cognitivas" class="form-control">
                                        <option v-for="i in 30" :value="i">{{i}}</option>
                                    </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Otros </label>
                                <select name="Otros" v-model="Otros" class="form-control">
                                <option value="Si">Si</option>
                                        <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">N° de Veces que Participa</label>
                                    <select name="Nro_Participa_Otros" v-model="Nro_Participa_Otros" class="form-control">
                                        <option v-for="i in 30" :value="i">{{i}}</option>
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
                                                <td>{{residente.DNI_RESIDENTE}}</td>
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