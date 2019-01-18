<template id="reniec-consulta">
  
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>RENIEC - Consulta</strong>
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
                    <form  class="form-horizontal"  v-on:submit.prevent="guardar">
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
                </div>
            </div>
        </div>
        
    </div> <!-- .content -->
    
</template>