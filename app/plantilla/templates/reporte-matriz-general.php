<template id="reporte-matriz-general">
    <div class="content mt-3">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Reporte matriz general</strong>
                       
                        </div>
                        <div class="card-body">
                            <div class="row form-group">
                                <div class="form-group col-md-6">
                                    <div class="form-group col-md-3">
                                        <label for="text-input" class=" form-control-label">Mes</label>
                                        <select name="periodo_mes" @change="mostrar_matrices()" v-model="periodo_mes" id="periodo_mes" class="form-control">
                                            <option v-for="(row,index) in meses" :value="(index+1)">{{row}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="text-input" class=" form-control-label">Año</label>
                                        <select name="periodo_anio" @change="mostrar_matrices()" v-model="periodo_anio" id="periodo_anio" class="form-control">
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-3 " >
                                <button class="btn btn-primary" @click="mostrar_matrices()">Mostrar</button>
                                </div>
                            </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-dark text-center">
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Descargar</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr v-for="matriz in matrices">
                                            <td>{{matriz.NOMBRE_CENTRO}}</td>
                                            <td>{{matriz.FECHA_MATRIZ}}</td>
                                            <td><button class="btn btn-primary" @click="descargar_reporte_matriz_general(matriz.ID)">Descargar</button></td>
                                        
                                        </tr>
                                    
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

        </div> <!-- .content -->
</template>