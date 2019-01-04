<template id="cargar-archivos">
  
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                   
                    <strong>Formulario de Carga de Documentos</strong>
                </div>
                <div class="card-body card-block">
                    <button class="btn btn-success" @click="mostrar_formulario('')" >Adjuntar Nuevo</button>
</br>
                <table id="bootstrap-data-table" class="table table-striped table-bordered text-center">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="archivo in archivos">
                        <td>{{archivo.NOMBRE}}</td>
                        <td>{{archivo.FECHA_CREACION}}</td>
                        <td><a :href="'/inabif/app/cargas/'+archivo.NOMBRE" download="Acme Documentation (ver. 2.0.1).txt" class="btn btn-primary" >Descargar</a> 
                        <button  class="btn btn-danger" @click="eliminar(archivo)">Eliminar</button> </td>
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
                    <h5 class="modal-title">Formulario de carga</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" @click="showModal = false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form  class="form-horizontal" enctype="multipart/form-data" id="formuploadajax" v-on:submit.prevent="guardar">
                        <div class="row">
                        <div class="form-group col-md-4">

                        <label for="text-input" class=" form-control-label">Adjuntar archivo</label>

                        <input type="file" id="archivo" v-model="archivo" name="archivo" value="archivo" class="form-control-file">
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