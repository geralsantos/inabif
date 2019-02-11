<template id="cargar-archivos">

    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Formulario de Carga de Documentos</strong>
                </div>

                <div class="card-body card-block">
                <div class="row form-group">
                        <div class="col-12 col-md-1">
                            <label for="text-input" class=" form-control-label"></label>
                            <button @click="mostrar_lista_residentes()" class="btn btn-primary"><i class="fa fa fa-users"></i> Lista de Residentes</button>
                        </div>
                    </div>
                <div class="row">
                <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Buscar Residente <i class="fa fa-search" aria-hidden="true"></i></label>
                                <div class="autocomplete">
                                    <input type="text"  v-model="nombre_residente" class="form-control campo_busqueda_residente" @keyup="buscar_residente()" placeholder="Código, Código, Nombre, Apellido o DNI"/>
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
                    <button class="btn btn-success" v-show="!isempty(id_residente)" @click="mostrar_formulario" >Adjuntar Nuevo</button>
</br>
                <table id="bootstrap-data-table" class="table table-striped table-bordered text-center">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo Documento</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="archivo in archivos">
                        <td>{{archivo.NOMBRE}}</td>
                        <td>{{archivo.TIPO_DOCUMENTO}}</td>
                        <td>{{archivo.FECHA_CREACION}}</td>
                        <td><a :href="'/inabif/app/cargas/'+archivo.NOMBRE" :download="archivo.NOMBRE" class="btn btn-primary" >Descargar</a>
                        <button  class="btn btn-danger" @click="eliminar(archivo)">Eliminar</button> </td>
                    </tr>
                    </tbody>
                </table>

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
                                                <td>{{residente.NOMBRE}} {{residente.APELLIDO_P}} {{residente.APELLIDO_M}}</td>
                                                <td>{{residente.DNI_RESIDENTE}}</td>
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
        <div v-if="showModal">
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Formulario de carga</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" @click="closeModal()">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form  class="form-horizontal" enctype="multipart/form-data" id="formuploadajax" v-on:submit.prevent="guardar">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">Tipo Documento</label>
                                <select class="form-control" name="tipo_documento" v-model="tipo_documento" id="tipo_documento">
                                <option value="Acta de Egreso">Acta de Egreso</option>
                                <option value="Acta de externamiento">Acta de externamiento</option>
                                <option value="Acta del fiscal">Acta del fiscal</option>
                                <option value="Certificado médico legal">Certificado médico legal</option>
                                <option value="Documento de identificación">Documento de identificación</option>
                                <option value="Examen de integridad sexual">Examen de integridad sexual</option>
                                <option value="Examen pelmatoscópico">Examen pelmatoscópico</option>
                                <option value="Examen psicosomático">Examen psicosomático</option>
                                <option value="Examen VIH">Examen VIH</option>
                                <option value="Formato de Egreso">Formato de Egreso</option>
                                <option value="Informe de egreso del residente a la familia">Informe de egreso del residente a la familia</option>
                                <option value="Informe de salud">Informe de salud</option>
                                <option value="Informe del PAI">Informe del PAI</option>
                                <option value="Informe educativo">Informe educativo</option>
                                <option value="Informe evolutivo">Informe evolutivo</option>
                                <option value="Informe psicológico">Informe psicológico</option>
                                <option value="Informe social">Informe social</option>
                                <option value="Partida de nacimiento">Partida de nacimiento</option>
                                <option value="Plan de intervención Individualizado">Plan de intervención Individualizado</option>
                                <option value="Referente familiar / afectivo">Referente familiar / afectivo</option>
                                <option value="Tarjeta de vacunación">Tarjeta de vacunación</option>
                                <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-12">

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
                    <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
                </div>
            </div>
        </div>

        </div>
      </div>
    </transition>
  </div>
    </div> <!-- .content -->

</template>