<template id="reporte-rub">
    <div class="content mt-3">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Reporte Rub</strong>
                       
                        </div>
                        <div class="card-body">
                            <div class="row form-group">
                                <div class="col col-md-2"><label for="select" class=" form-control-label">Fecha Inicial</label></div>
                                <div class="col-12 col-md-3">
                                    <input type="date" class="form-control" v-model="fecha_inicial" >
                                </div>
                                <div class="col col-md-2"><label for="select" class=" form-control-label">Fecha Final</label></div>
                                <div class="col-12 col-md-3">
                                    <input type="date" class="form-control" v-model="fecha_final">
                                </div>
                                <div class="col-12 col-md-1">
                                   <button @click="mostrar_reporte_rub()" class="btn btn-default"><i class="fa fa-send"></i> Buscar</button>
                                </div>
                            </div>
                            <div class="row" v-if="!isempty(residentes)">
                                <div class="col-12 col-md-1">
                                    <button @click="descargar_reporte_matriz_rub()" class="btn btn-success"><i class="fa fa-send"></i> Descargar Reporte</button>
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
                                        
                                        </tr>
                                    
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

        </div> <!-- .content -->
</template>