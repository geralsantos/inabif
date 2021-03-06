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
                                <select name="tipo_centro_id" v-model="tipo_centro_id" class="form-control" @change="mostrar_entidad()" >
                                    <option v-for="tipo_centro in tipo_centros" :value="tipo_centro.ID">{{tipo_centro.CODIGO}}</option>
                                </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Código de Entidad</label>
                                <input type="text" v-model="codigo_entidad" name="codigo_entidad" placeholder="" class="form-control"> 
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Nombre de la Entidad</label>
                                <input type="text" v-model="nombre_entidad" name="nombre_entidad" placeholder="" class="form-control"> 
                            </div>
                            
                        </div>
                        <div class="row">
                        
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Código de Centro</label>
                                <input type="text" v-model="cod_ca" name="cod_ca" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre de Centro</label>
                                <input type="text" v-model="nom_ca" name="nom_ca" placeholder="" class="form-control"> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                               <label for="text-input" class=" form-control-label">Código de Servicio</label>
                                <select name="cod_serv" v-model="cod_serv" class="form-control" >
                                    <option value="SER007">SER007</option>
                                    <option value="SER008">SER008</option>
                                    <option value="SER009">SER009</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Nombre del Servicio</label>
                                <select name="nom_serv" v-model="nom_serv" class="form-control" >
                                    <option value="CENTRO DE ACOGIDA RESIDENCIAL - USPNNA ">CENTRO DE ACOGIDA RESIDENCIAL - USPNNA </option>
                                    <option value="CENTRO DE ATENCIÓN RESIDENCIAL - USPPAM">CENTRO DE ATENCIÓN RESIDENCIAL - USPPAM</option>
                                    <option value="CENTRO DE ACOGIDA RESIDENCIAL - USPPD">CENTRO DE ACOGIDA RESIDENCIAL - USPPD</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre de Administrador</label>
                                <input type="text" v-model="administrador_nombre" name="administrador_nombre" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre de Director</label>
                                <input type="text" v-model="nombre_director" name="nombre_director" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                <div class=" "><label for="text-input" class=" form-control-label">Dirección del Centro</label>
                                <input type="text" v-model="direccion_car" name="direccion_car" placeholder="" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Teléfono</label>
                                <input type="number" v-model="telefono" name="telefono" placeholder="" class="form-control"> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Departamento</label>
                                <select name="Depatamento_Procedencia" v-model="Depatamento_Procedencia" @change="buscar_provincias()" class="form-control">
                                    <option v-for="departamento in departamentos" :value="departamento.CODDEPT">{{departamento.NOMDEPT}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Provincia</label>
                                <select name="Provincia_Procedencia" v-model="Provincia_Procedencia" @change="buscar_distritos()" class="form-control">
                                    <option v-for="provincia in provincias" :value="provincia.CODPROV">{{provincia.NOMPROV}}</option>
                                </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Distrito</label>
                                <select name="Distrito_Procedencia" v-model="Distrito_Procedencia" class="form-control">
                                    <option v-for="distrito in distritos" :value="distrito.CODDIST">{{distrito.NOMDIST}}</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Área de Residencia </label>
                                <select name="area_residencia" v-model="area_residencia" class="form-control">
                                <option value="URBANO">URBANO</option>
                                <option value="RURAL">RURAL</option>
                                </select>
                                </div>
                            </div> 
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Código de Linea </label>
                        
                                <select name="codigo_linea" v-model="codigo_linea" class="form-control" >
                                    <option value="LIN001">LIN001</option>
                                    <option value="LIN002">LIN002</option>
                                    <option value="LIN003">LIN003</option>
                                </select>

                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Linea Intervención</label> 
                                <select name="linea_intervencion" v-model="linea_intervencion" class="form-control" >
                                    <option value="PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE CON DISCAPACIDAD EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO">PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE CON DISCAPACIDAD EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO</option>
                                    <option value="PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO">PROTECCIÓN INTEGRAL A LA PERSONA ADULTA MAYOR EN SITUACIÓN DE ABANDONO O ABANDONO</option>
                                    <option value="PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO">PROTECCIÓN INTEGRAL AL NIÑO, NIÑA Y ADOLESCENTE EN SITUACIÓN DE PRESUNTO ESTADO DE ABANDONO O ABANDONO</option>
                                </select>
                            </div>
                             
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="text-input" class=" form-control-label">Centro Poblado del centro de atención </label>
                                <input type="text" v-model="centro_poblado" name="centro_poblado" placeholder="" class="form-control"> 
                             
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