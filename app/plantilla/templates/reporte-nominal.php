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
                                <div class="col-12 col-md-1">
                                    <label for="text-input" class=" form-control-label"></label>
                                    <button @click="mostrar_reporte_nominal()" class="btn btn-default"><i class="fa fa-send"></i> Buscar</button>
                                </div>
                                <div class="col-12 col-md-1">
                                    <a @click="mostrar_lista_residentes()" class="menutoggle"><i class="fa fa fa-tasks"></i></a>
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
                                            <td>{{residente.NOMBRE_RESIDENTE}}</td>
                                     
                                            <td><button class="btn btn-primary" @click="descargar_reporte_matriz_nominal(residente)">Descargar</button></td>
                                        
                                        </tr>
                                    
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

        </div> <!-- .content -->
</template>