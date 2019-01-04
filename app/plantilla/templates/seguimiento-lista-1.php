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
                                        <th scope="col">Ver</th>
                                        <th scope="col" v-if="mostrar_completado">Opción</th>

                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr v-for="centro in centros">
                                        <td>{{centro.NOMBRE_CENTRO}}</td>
                                        <td>{{(isempty(centro.ESTADO_COMPLETO))?'NO':'SI'}}</td>
                                        <td></td>
                                        <td></td>
                                        <td><button class="btn btn-primary" @click="ver_grupos(centro.ID_CENTRO)">Ver</button></td>
                                    </tr>

                                </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

        </div> <!-- .content -->
</template>