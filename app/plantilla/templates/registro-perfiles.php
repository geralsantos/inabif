<template id="registro-perfiles">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Creación de Perfiles</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Crear Usuario</button><br>
                <table id="bootstrap-data-table" class="table table-striped table-bordered text-center">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="usuario in usuarios">
                        <td>{{usuario.NOMBRE}}</td>
                        <td>{{usuario.APELLIDO}}</td>
                        <td>{{usuario.DNI}}</td>
                        <td><button  class="btn btn-primary" @click="verRegistro(usuario)">Editar</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                    
                </div>
            </div>
        </div>
    </div> <!-- .content -->
    <div v-if="showModal">
    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form  class="form-horizontal"  v-on:submit.prevent="guardar">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Apellidos</label>
                                <input type="text" v-model="Apellido" name="Apellido" placeholder="" class="form-control"> 
                                </div>
                            </div>
                           
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombres</label>
                                <input type="text" v-model="Nombre" name="Nombre" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Correo</label>
                                <input type="email" v-model="Correo" name="Correo" placeholder="" class="form-control"> 
                                </div>
                            </div>
                           
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">DNI</label>
                                <input type="number" v-model="DNI" name="DNI" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Númer Celular</label>
                                <input type="number" v-model="NumCel" name="NumCel" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            <!--<div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Centro</label>
                                <select name="centroID" v-model="centroID" class="form-control">
                                    <option v-for="centro in centros" :value="centro.ID">{{centro.NOM_CA}}</option>
                                </select>
                                </div>
                            </div>-->
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-secondary" @click="showModal = false">Cerrar</button>
      </div>
    </div>
  </div>
</div>    
    
  </div>
</template>