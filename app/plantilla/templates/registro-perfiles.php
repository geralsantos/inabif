<template id="registro-perfiles">
    <style>
    .modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 300px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}</style>
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Creación de Perfiles</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <button class="btn btn-success" @click="showModal = false" >Crear Usuario</button><br>
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
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" @click="showModal = false">&times;</span>
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
                    <button type="button" class="btn btn-secondary" @click="showModal = false">Cerrar</button>
                </div>
            </div>
        </div>

        </div>
      </div>
    </transition>
  </div>
</template>