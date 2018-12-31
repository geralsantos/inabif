<template id="registro-locales">
  
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Creación de Locales</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <button class="btn btn-success" @click="verRegistro('')" >Crear Local</button>
</br>
                <table id="bootstrap-data-table" class="table table-striped table-bordered text-center">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Area Residencia</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="centro in centros">
                        <td>{{centro.NOM_CA}}</td>
                        <td>{{centro.COD_CA}}</td>
                        <td>{{centro.AREA_RESIDENCIA}}</td>
                        <td><button  class="btn btn-primary" @click="verRegistro(centro)">Editar</button> 
                        <button  class="btn btn-danger" @click="EliminarLocal(centro)">Eliminar</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                    
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
                    <h5 class="modal-title">Registro - Centros</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" @click="showModal = false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form  class="form-horizontal"  v-on:submit.prevent="guardar">
                        <div class="row">

                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Tipo de Centro</label>
                                <select name="tipo_centro_id" v-model="tipo_centro_id" class="form-control">
                                    <option v-for="tipo_centro in tipo_centros" :value="tipo_centro.ID">{{tipo_centro.NOMBRE}}</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Código de Entidad</label>
                                <input type="text" v-model="Apellido" name="Apellido" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Código de Servicio</label>
                                <input type="text" v-model="Nombre" name="Nombre" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Código de Centro</label>
                                <input type="email" v-model="Correo" name="Correo" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre de Centro</label>
                                <input type="email" v-model="Correo" name="Correo" placeholder="" class="form-control"> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre de Administrador</label>
                                <input type="text" v-model="DNI" name="DNI" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre de Director</label>
                                <input type="number" v-model="DNI" name="DNI" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Teléfono</label>
                                <input type="number" v-model="DNI" name="DNI" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <div class=" "><label for="text-input" class=" form-control-label">Dirección del Centro</label>
                                <input type="text" v-model="DNI" name="DNI" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Código de Linea </label>
                                <input type="text" v-model="DNI" name="DNI" placeholder="" class="form-control"> 

                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Linea Intervención</label>
                                <input type="number" v-model="DNI" name="DNI" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre del Servicio</label>
                                <input type="text" v-model="DNI" name="DNI" placeholder="" class="form-control"> 
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