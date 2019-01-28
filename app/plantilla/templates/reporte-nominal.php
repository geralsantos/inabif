<template id="reporte-nominal">
    <div class="content mt-3">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Reporte Nominal</strong>

                        </div>
                        <div class="card-body">
                            <div class="row form-group">
                                <div class="form-group col-md-10">
                                    <label for="text-input" class=" form-control-label">Ingrese el nombre del residente</label>
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
                                <div class="col-12 col-md-1">
                                    <label for="text-input" class=" form-control-label"></label>
                                    <button @click="mostrar_lista_residentes()" class="btn btn-primary"><i class="fa fa fa-users"></i> Lista</button>
                                </div>

                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-md-1">

                                <button class="btn btn-success" @click="descargar_reporte_matriz_nominal()">Descargar</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-dark text-center">
                                        <tr>
                                            <th scope="col">Nombre</th>

                                            <th scope="col">Descargar</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr v-for="residente in residentes">
                                            <td>{{residente.ID}} {{residente.APELLIDO_P}} {{residente.APELLIDO_M}} {{residente.NOMBRE_RESIDENTE}}</td>

                                            <td><button class="btn btn-success" @click="descargar_reporte_matriz_nominal(residente)">Descargar</button></td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>

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
                                                    <th scope="col">Número de documento</th>
                                                    <th scope="col">Opción</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <tr v-for="residente in pacientes">
                                                    <td>{{residente.ID}} {{residente.NOMBRE}} {{residente.APELLIDO_P}} {{residente.APELLIDO_M}}</td>
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