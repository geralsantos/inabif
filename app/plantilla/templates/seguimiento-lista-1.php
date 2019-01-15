<template id="seguimiento-lista-1">
    <div class="content mt-3">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Lista de Seguimiento</strong>
                            <h6>Período: {{periodo}}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row" v-if="usuario.NIVEL == 2">
                                <div class="col-md-3"><label class="form-control-label">Tipo de Centro Listo: </label></div>
                                <div class="col-md-1"><input type="checkbox" class="form-control" @change="completar_tipo_centro()" :checked="tipo_centro"></div>
                            </div>
                            <div class="row" v-if="usuario.NIVEL == 3">
                                <div class="col-md-6">
                                <label class="form-control-label">Tipo de centros completados - autodeclarados (Supervisor)</label>
                                <ul style="list-style-type: none;">
                                    <li v-for="item in tipo_centro_completado">{{(item.TIPO_CENTRO_ID==1)?'PPD':''}}{{(item.TIPO_CENTRO_ID==2)?'PAM':''}}{{(item.TIPO_CENTRO_ID==3)?'NNA':''}}: {{(item.ESTADO==1)?'SI':'NO'}}</li>
                                </ul>
                                </div>
                            </div>
                            <div class="row" v-if="usuario.NIVEL == 3">
                                <div class="col-md-2">
                                    <button class="btn btn-success" @click="generar_matriz_general()">Generar Matriz General</button>
                                </div>
                            </div>

                            <br>
                            <div class="table-responsive">
                                <table class="table">
                                <thead class="thead-dark text-center">
                                    <tr>

                                        <th scope="col">Centro</th>
                                        <th scope="col">Completo Autodeclarado (Registrador)</th>
                                        <th scope="col">Matriz Generada <br>(Responsable de información)</th>
                                        <th scope="col">Fecha Generación <br>Matriz Centro</th>
                                       <!--  <th scope="col">Fecha Cierre</th>
                                        <th scope="col">Cerrado</th> -->
                                        <th scope="col">Ver</th>
                                        <th scope="col" v-if="mostrar_completado">Opción</th>

                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr v-for="centro in centros" style="text-align:justify;">
                                        <td>{{centro.NOMBRE_CENTRO}}</td>
                                        <td>{{(isempty(centro.ESTADO_COMPLETO))?'NO':'SI'}}</td>
                                        <td>{{(isempty(centro.FECHA_MATRIZ))?'NO':'SI'}}</td>
                                        <td>{{(isempty(centro.FECHA_MATRIZ))?'':centro.FECHA_MATRIZ}}</td>
                                        <!-- <td>{{centro.FECHA_CIERRE}}</td>
                                        <td>{{(isempty(centro.FECHA_CIERRE))?'NO':'SI'}}</td> -->
                                        <td><button class="btn btn-primary" @click="ver_grupos(centro.ID_CENTRO)">Ver</button></td>
                                        <td v-if="isempty(centro.ESTADO_COMPLETO) && mostrar_completado"><label class="form-control-label">Completado</label><input type="checkbox" class="form-control" @change="completar_matriz(centro.ID_CENTRO)" :checked="!isempty(centro.ESTADO_COMPLETO)"  class="form-control" ></td>
                                        <td v-if="!isempty(centro.ESTADO_COMPLETO) && mostrar_completado"> <button class="btn btn-success" @click="generar_matriz(centro.ID_CENTRO)">Generar Matriz</button></td>

                                    </tr>

                                </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

        </div> <!-- .content -->
</template>