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
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registro - Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" @click="showModal = false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form  class="form-horizontal"  v-on:submit.prevent="guardar">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Apellidos</label>
                                <input type="text" v-model="Apellido" name="Apellido" placeholder="" class="form-control"> 
                                </div>
                            </div>
                           
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombres</label>
                                <input type="text" v-model="Nombre" name="Nombre" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Correo</label>
                                <input type="email" v-model="Correo" name="Correo" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group col-md-6"><label for="text-input" class=" form-control-label">Nivel Usuario</label>
                                <select name="nivel_id" v-model="nivel_id" class="form-control" @change="verificar_nivel()">
                                    <option v-for="nivel in niveles_usuarios" :value="nivel.ID">{{nivel.NOMBRE}}</option>
                                </select>
                                </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Usuario</label>
                                <input type="text" v-model="usuario" name="usuario" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group col-md-4"><label for="text-input" class=" form-control-label">Clave</label>
                                <input type="password" v-model="clave" name="clave" placeholder="" class="form-control"> 
                            </div>
                            <div class="form-group col-md-4"><label for="text-input" class=" form-control-label">Confirmar Clave</label>
                                <input type="password" v-model="cclave" name="cclave" placeholder="" class="form-control"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">DNI</label>
                                <input type="number" v-model="DNI" name="DNI" maxlength="8" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Númer Celular</label>
                                <input type="number" v-model="NumCel" maxlength="9" name="NumCel" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group col-md-4" v-if="mostrar">
                                <div class=" "><label for="text-input" class=" form-control-label">Centro</label>
                                <select name="centro_id" v-model="centro_id" class="form-control">
                                    <option v-for="centro in centros" :value="centro.ID">{{centro.NOM_CA}}</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4" v-else>
                                <div class=" "><label for="text-input" class=" form-control-label">Tipo de Centro</label>
                                <select name="tipo_centro" v-model="tipo_centro" class="form-control">
                             
                                   <option value="3">USPNNA</option>
                                   <option value="2">USPAM</option>
                                   <option value="1">USPPD</option>
                                </select>
                                </div>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="showModal = false">Cerrar</button>
                </div>
            </div>
        </div>

        </div>
      </div>
    </transition>
  </div>
    </div> <!-- .content -->
    
</template>