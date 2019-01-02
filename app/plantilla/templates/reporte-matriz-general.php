<template id="reporte-matriz-general">
    <div class="content mt-3">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Reporte matriz general</strong>
                       
                        </div>
                        <div class="card-body">
                            <div class="row form-group">
                                <div class="form-group col-md-3">
                                    <label for="text-input" class=" form-control-label">Período</label>
                                    <select name="periodo" @change="mostrar_matrices()" v-model="periodo" id="periodo" class="form-control">
                                        <option value="mensual">Mensual</option>
                                        <option value="semestral">Semestral</option>
                                    </select>
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