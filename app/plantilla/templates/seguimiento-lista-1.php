<template id="seguimiento-lista-1">
    <div class="content mt-3">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Lista de Seguimiento</strong>
                            <h6>Período: {{periodo}}</h6>
                        </div>
                        <div class="card-body">
                           
                            <div class="table-responsive">
                                <table class="table">
                                <thead class="thead-dark text-center">
                                    <tr>
                                    
                                        <th scope="col">Centro</th>
                                        <th scope="col">Completo</th>
                                        <th scope="col">Fecha Cierre</th>
                                        <th scope="col">Cerrado</th>
                                        <th scope="col">Opción</th>
                                        <th scope="col"></th>

                                       
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr v-for="centro in centros">
                                        <td>{{centro.NOMBRE_CENTRO}}</td>
                                        <td>{{centro.ESTADO_COMPLETO}}</td>
                                        <td>{{centro.FECHA_CIERRE}}</td>
                                        <td>{{centro.FECHA_CIERRE}}</td>
                                        <td v-if="completado"><input type="checkbox" ></td>
                                        <td v-if="matriz"><button>Generar Matriz</button></td>
                                    </tr>
                                   
                                </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

        </div> <!-- .content -->
</template>