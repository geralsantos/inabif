<template id="ppd-datos-condicion-ingreso">
<div class="content mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Datos de condicion de ingreso Del Residente</strong>
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
                                <div class="form-group col-md-7">
                                    <label for="text-input" class=" form-control-label">Nombre Residente</label>
                                    <div class="autocomplete">
                                        <input type="text"  v-model="nombre_residente" class="form-control" @keyup="buscar_residente()" placeholder="Nombre, Apellido o DNI"/>
                                        <ul  id="autocomplete-results" class="autocomplete-results" v-if="bloque_busqueda">
                                            <li class="loading" v-if="isLoading">
                                                Loading results...
                                            </li>
                                            <li  @click="actualizar(coincidencia)" class="autocomplete-result" v-for="coincidencia in coincidencias">
                                                {{coincidencia.NOMBRE}} {{coincidencia.APELLIDO_P}} - {{coincidencia.DOCUMENTO}}
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
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
                                    <label for="text-input" class=" form-control-label">Documento de Identidad al ingreso</label>
                                    <select name="CarDocIngreso" v-model="CarDocIngreso" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Tipo de documento identidad AL INGRESO</label>
                                    <select name="CarTipoDoc" v-model="CarTipoDoc" class="form-control">
                                        <option v-for="tipoDocumento in tipoDocumentos" :value="tipoDocumento.ID" >{{tipoDocumento.NOMBRE}}</option>

                                    </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Número del documento </label>
                                    <input type="number" min="0"  v-model="CarNumDoc" name="CarNumDoc" placeholder="" class="form-control">
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="text-input" class=" form-control-label">Posee algún tipo de Pensión</label>
                                    <select name="CarPoseePension" id="CarPoseePension" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class=" "><label for="text-input" class=" form-control-label">Tipo de pensión que percibe</label>
                                    <select name="CarTipoPension" v-model="CarTipoPension" class="form-control">
                                        <option v-for="pension in pensiones" :value="pension.ID">{{pension.NOMBRE}}</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Usuarios sabe leer y escribir?</label>
                                    <select name="CarULeeEscribe" v-model="CarULeeEscribe" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Nivel Educativo</label>
                                    <select name="CarNivelEducativo" v-model="CarNivelEducativo" class="form-control">
                                        <option v-for="educativo in educativos" :value="educativo.ID">{{educativo.NOMBRE}}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Intitución Educativa de Procedencia</label>
                                    <select name="CarInstitucionEducativa" v-model="CarInstitucionEducativa" class="form-control">
                                        <option v-for="institucion in instituciones" :value="institucion.ID">{{institucion.NOMBRE}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Tipo de seguro de salud</label>
                                    <select name="CarTipoSeguro" v-model="CarTipoSeguro" class="form-control">
                                        <option v-for="seguro in seguros" :value="seguro.ID">{{seguro.NOMBRE}}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="text-input" class=" form-control-label">Clasificación Socioeconómica</label>
                                    <select name="CarCSocioeconomica" v-model="CarCSocioeconomica" class="form-control">
                                        <option v-for="socioeconomico in socioeconomicos" :value="socioeconomico.ID">{{socioeconomico.NOMBRE}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Cuenta con familiares ubicados?</label>
                                    <select name="CarFamiliaresUbicados" v-model="CarFamiliaresUbicados" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Tipo de parentesco</label>
                                    <select name="CarTipoParentesco" v-model="CarTipoParentesco" class="form-control">
                                        <option v-for="parentesco in parentescos" :value="parentesco.ID">{{parentesco.NOMBRE}}</option>
                                    </select>

                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Problemática familiar</label>
                                    <select name="CarProblematicaFam" v-model="CarProblematicaFam" class="form-control">
                                        <option v-for="familiar in familiares" :value="familiar.ID">{{familiar.NOMBRE}}</option>
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