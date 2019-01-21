<template id="nna-seguimiento-psicologico">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Seguimiento Psicologico</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <div class="row form-group">
                        <div class="col-12 col-md-1">
                            <label for="text-input" class=" form-control-label"></label>
                            <button @click="mostrar_lista_residentes()" class="btn btn-primary"><i class="fa fa fa-users"></i> Lista de Residentes</button>
                        </div>
                    </div>
                    <form class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Buscar Residente <i class="fa fa-search" aria-hidden="true"></i></label>
                                <div class="autocomplete">
                                    <input type="text"  v-model="nombre_residente" class="form-control campo_busqueda_residente" @keyup="buscar_residente()" placeholder="Código, Nombre, Apellido o DNI"/>
                                    <ul  id="autocomplete-results" class="autocomplete-results" v-if="bloque_busqueda">
                                        <li class="loading" v-if="isLoading">
                                            Loading results...
                                        </li>
                                        <li  @click="actualizar(coincidencia)" class="autocomplete-result" v-for="coincidencia in coincidencias">
                                            {{coincidencia.ID}} - {{coincidencia.NOMBRE}} {{coincidencia.APELLIDO_P}} - {{coincidencia.DNI_RESIDENTE}} - {{coincidencia.DOCUMENTO}}
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
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Plan de Intervención psicológico</label>
                                <select name="Plan_Intervencion" v-model="Plan_Intervencion" class="form-control">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Durante el periodo ha presentado </label>
                                <select name="Presento" v-model="Presento" class="form-control">
                                <option value="Problemas del aprendizaje">Problemas del aprendizaje</option>
                                <option value="Retraso en el Desarrollo psicomotor">Retraso en el Desarrollo psicomotor</option>
                                <option value="Trastorno de Estrés Post Traumático">Trastorno de Estrés Post Traumático</option>
                                <option value="Problemas de Autoestima">Problemas de Autoestima</option>
                                <option value="Diagnóstico depresivo">Diagnóstico depresivo</option>
                                <option value="Diagnóstico de Ansiedad">Diagnóstico de Ansiedad</option>
                                <option value="Trastorno del comportamiento">Trastorno del comportamiento</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">PRINCIPAL PERFIL ACTUAL</label>
                                <select name="Perfil" v-model="Perfil" class="form-control">
                                <option v-for="perfil in perfilesingreso" :value="perfil.ID">{{perfil.NOMBRE}}</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Intervenciones terapéutica individual</label>
                                <input type="number" min="0" max="31"   v-model="Intervencion_Individual" name="Intervencion_Individual" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Intervenciones terapéutica grupal</label>
                                <input type="number" min="0" max="31"   v-model="Intervencion_Grupal" name="Intervencion_Grupal"  placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Consejerías y orientaciones psicológica</label>
                                <input type="number" min="0" max="31"   v-model="Nro_OrientacionP"  name="Nro_OrientacionP" placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Consejerías y orientaciones a la familia2</label>
                                <input type="number" min="0" max="31"   v-model="Nro_OrientacionF" name="Nro_OrientacionF" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Charlas Preventivo  - Promocionales Psicológicos</label>
                                <input type="number" min="0" max="31"   v-model="Nro_Charlas" name="Nro_Charlas"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº participaciones en sesiones  Taller de Liderazgo</label>
                                <input type="number" min="0" max="31"   v-model="Nro_TLiderazgo" name="Nro_TLiderazgo"  placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº participaciones en sesiones Taller de Autoestima</label>
                                <input type="number" min="0" max="31"   v-model="Nro_TAutoestima" name="Nro_TAutoestima"  placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº participaciones en sesiones Taller de Sexualidad</label>
                                <input type="number" min="0" max="31"   v-model="Nro_TSexualidad" name="Nro_TSexualidad"  placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº participaciones en sesiones Taller de prevención del embarazo en adolescentes</label>
                                <input type="number" min="0" max="31"   v-model="Nro_TPrevencionEmb" name="Nro_TPrevencionEmb"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº participaciones en sesiones Taller de Igualdad de Género</label>
                                <input type="number" min="0" max="31"   v-model="Nro_TIgualdadG" name="Nro_TIgualdadG"  placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº participaciones en sesiones  Taller de Violencia Familiar</label>
                                <input type="number" min="0" max="31"   v-model="Nro_ViolenciaF" name="Nro_ViolenciaF"  placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº participaciones en sesiones Taller de Salud mental</label>
                                <input type="number" min="0" max="31"   v-model="Nro_SaludM" name="Nro_SaludM"  placeholder="" class="form-control">
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