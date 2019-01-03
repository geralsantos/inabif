<template id="nna-datos-centro-servicios">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos del Centro de Servicios</strong>
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
                                <div class=" "><label for="text-input" class=" form-control-label">Código de la Entidad</label>
                                <input type="text" v-model="Cod_Entidad" name="Cod_Entidad" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-8">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre de la Entidad</label>
                                <input type="text" v-model="Nom_Entidad" name="Nom_Entidad" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Código de la Línea</label>
                                <input type="text" v-model="Cod_Linea" name="Cod_Linea" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-8">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre de la Línea</label>
                                <input type="text" v-model="Nom_Linea" name="Nom_Linea" placeholder="" class="form-control"> </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Línea de Intervención</label>
                                <input type="text" v-model="Linea_Intervencion" name="Linea_Intervencion" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class=" "><label for="text-input" class=" form-control-label">Código del Servicio</label>
                                <input type="text" v-model="Cod_Servicio" name="Cod_Servicio" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-5">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre del Servicio</label>
                                <input type="text" v-model="NomC_Servicio" name="NomC_Servicio" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Departamento del Centro de Atención</label>
                                <select name="Departamento_Centro" v-model="Departamento_Centro" @change="buscar_provincias()" class="form-control">
                                    <option v-for="departamento in departamentos" :value="departamento.CODDEPT">{{departamento.NOMDEPT}}</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Provincia del Centro de Atención</label>
                                <select name="Provincia_centro" v-model="Provincia_centro" @change="buscar_distritos()" class="form-control">
                                    <option v-for="provincia in provincias" :value="provincia.CODPROV">{{provincia.NOMPROV}}</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Distrito del Centro de Atención</label>
                                <select name="Distrito_centro" v-model="Distrito_centro" class="form-control">
                                    <option v-for="distrito in distritos" :value="distrito.CODDIST">{{distrito.NOMDIST}}</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=""><label for="text-input" class=" form-control-label">Área de residencia del centro de atención</label>
                                    <select name="Area_Residencia" v-model="Area_Residencia" class="form-control">
                                        <option value="Urbano">Urbano</option>
                                        <option value="Rural">Rural</option>
                                </select></div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class=""><label for="text-input" class=" form-control-label">Código del Centro de Atención</label>
                                <input type="text" v-model="CodigoC_Atencion" name="CodigoC_Atencion" placeholder="" class="form-control"></div>
                            </div>
                            <div class="form-group col-md-5">
                                <div class=""><label for="text-input" class=" form-control-label">Nombre del Centro de Atención</label>
                                <input type="text" v-model="NomC_Atencion" name="NomC_Atencion" placeholder="" class="form-control"></div>
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