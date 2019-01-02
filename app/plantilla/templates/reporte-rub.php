<template id="reporte-rub">
    <div class="content mt-3">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Reporte Rub</strong>
                       
                        </div>
                        <div class="card-body">
                            <div class="row form-group">
                                <div class="col-md-3">
                                   
                                    <div class="col col-md-2"><label for="select" class=" form-control-label">Fecha Inicial</label></div>
                                    <div class="col-12 col-md-2">
                                    <input type="date" class="form-control dtp_fecha_indicador_11" placeholder="YYYY-MM-DD" v-model="fecha" id="" @onchange="geral()">
                                    </div>
                                </div>

                                <div class="col-md-3">
         
                                    <div class="col col-md-2 col-sm-2"><label for="select" class=" form-control-label">Fecha Final</label></div>
                                    <div class="col-12 col-md-2">
                                    <input type="date" class="form-control dtp_fecha_indicador_11" placeholder="YYYY-MM-DD" v-model="fecha" id="" @onchange="geral()">
                                    </div>
                                </div>
                                <div class="col-12 col-md-1">
                                   <button @click="mostrar_reporte_rub()" class="btn btn-default"><i class="fa fa-send"></i> Buscar</button>
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