<template id="seguimiento-lista-2">
    <div class="content mt-3">
        <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Lista de Seguimiento</strong>
                        <h6>Período {{periodo}}</h6>
                    </div>
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="table">
                            <thead class="thead-dark text-center">
                                <tr>
                                
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Encargado</th>
                                    <th scope="col">Completo</th>
                                    <th scope="col">Última actualización</th>
                                    <th scope="col">Opción</th>
                                    <th scope="col"></th>
                                    
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="grupo in grupos">
                                    <td>grupo.MODULO_NOMBRE</td>
                                    <td>grupo.ENCARGADO_NOMBRE</td>
                                    <td>{{(isempty(grupo.ESTADO_COMPLETO))?'NO':'SI'}}</td> <!-- SI O NO -->
                                    <td>grupo.FECHA_EDICION</td>
                                    <td class="btn btn-primary" @click="mostrar_modulo(grupo.ID_MODULO)">Ver</td>
                                    <td v-if="completado"><input type="checkbox" v-model=""></td>
                                    <td v-if="!isempty(grupo.ESTADO_COMPLETO)"><label class="form-control-label">Completado</label><input type="checkbox" class="form-control" @change="completar_grupo(grupo.ID_MODULO)" :checked="!isempty(grupo.ESTADO_COMPLETO)" class="form-control" ></td>
                                </tr>
                                
                            </tbody>
                            </table>
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
                            <h5 class="modal-title">Módulo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" @click="showModal = false">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <ul>
                            <li v-for="reg, index in grupos">{{index}} : {{reg}} </li>
                        </ul>
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