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
                    
                </div>
            </div>
        </div>
        <div v-if="showModal">
    
  </div>
    </div> <!-- .content -->
    
</template>