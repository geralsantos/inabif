<template id="reporte-rub">
    <div class="content mt-3">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Reporte Rub</strong>
                       
                        </div>
                        <div class="card-body">
                            <div class="row form-group">
                                <div class="form-group col-md-3">
                                    <label for="text-input" class=" form-control-label">Fecha Inicial</label>
                                    <input type="date" class="form-control" v-model="fecha_inicial">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="text-input" class=" form-control-label">Feacha Final</label>
                                    <input type="date" class="form-control" v-model="fecha_final">
                                </div>
                                <div class="form-group col-md-3">
                                   <button @click="mostrar_reporte_rub()" class="btn btn-default">Buscar</button>
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
                                        <tr v-for="residente in residentes">
                                            <td>{{residente.NOMBRE_RESIDENTE}}</td>
                                            <td>{{residente.FECHA}}</td>
                                            <td><button class="btn btn-primary" @click="descargar_reporte_matriz_general(residente.ID)">Descargar</button></td>
                                        
                                        </tr>
                                    
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

        </div> <!-- .content -->
</template>