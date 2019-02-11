<template id="pide-consulta">
  
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>PIDE - Consulta</strong>
                    <h6>Formulario de Consulta</h6>
                </div>
                <div class="card-body card-block">
                    <div class="row form-group">
                        <div class="col-12 col-md-1">
                            <label for="text-input" class=" form-control-label"></label>
                            <button @click="mostrar_lista_residentes()" class="btn btn-primary"><i class="fa fa fa-users"></i> Lista de Residentes</button>
                        </div>
                    </div>
<br>
                    <form  class="form-horizontal">
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
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark text-center">
                                    <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">DNI</th>
                                    <th scope="col">Paterno</th>
                                    <th scope="col">Materno</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">PIDE</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr v-for="residente in residente_seleccionado">
                                    <td>{{residente.ID}}</td>
                                    <td>{{residente.DNI_RESIDENTE}}</td>
                                    <td>{{residente.APELLIDO_P}}</td>
                                    <td>{{residente.APELLIDO_M}}</td>
                                    <td>{{residente.NOMBRE}}</td>
                                    <td>{{residente.PIDE}}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-center" >
                                <button type="button" @click="consulta_reniec()" class="btn btn-success btn-sm">
                                    <i class="fa fa-send"></i> Consultar Reniec
                                </button>
                            </div>
                        </div>
                    </form>
                    <br><br>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-dark text-center">
                                        <tr>
                                        <th scope="col">DNI</th>
                                        <th scope="col">Paterno</th>
                                        <th scope="col">Materno</th>
                                        <th scope="col">Nombre</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr>
                                        <td>{{data_reniec.NumDoc}}</td>
                                        <td>{{Apellido_p}}</td>
                                        <td>{{data_reniec.Apellido_m}}</td>
                                        <td>{{data_reniec.Nombres}}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="!isempty(id_residente)">
                        <div class="col-md-4 text-center">
                            <select name="cboopcionreniec" id="cboopcionreniec" v-model="cboopcionreniec" class="form-control">
                                <option value="No se consultó, falta de datos">No se consultó, falta de datos</option>
                                <option value="Consulta: Dato correcto, Actualizar">Consulta: Dato correcto, Actualizar</option>
                                <option value="Consulta: Datos diferentes">Consulta: Datos diferentes</option>
                            </select>
                        </div>
                        <div class="col-md-4 text-center">
                            <button type="button" @click="actualiza_reniec()" class="btn btn-success btn-sm">
                                <i class="fa fa-send"></i> Grabar Datos
                            </button>
                        </div>
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
                                                <th scope="col">Número de Documento</th>
                                                <th scope="col">Opción</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr v-for="residente in pacientes">
                                                <td>{{residente.NOMBRE}} {{residente.APELLIDO_P}} {{residente.APELLIDO_M}}</td>
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