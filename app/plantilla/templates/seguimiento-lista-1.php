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
                                        <th scope="col"></th>
                                       
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td>Centro 1</td>
                                        <td>SI</td>
                                        <td>03-08-2018</td>
                                        <td>NO</td>
                                        <td v-if="matriz"><button>Generar Matriz</button></td>
                                    </tr>
                                    <tr>
                                        <td>Centro 2</td>
                                        <td>SI</td>
                                        <td>03-08-2018</td>
                                        <td>NO</td>
                                    </tr>
                                    <tr>
                                        <td>Centro 3</td>
                                        <td>SI</td>
                                        <td>03-08-2018</td>
                                        <td>NO</td>
                                    </tr>
                                    <tr>
                                        <td>Centro 4</td>
                                        <td>SI</td>
                                        <td>03-08-2018</td>
                                        <td>NO</td>
                                    </tr>
                                    <tr>
                                        <td>Centro 5</td>
                                        <td>SI</td>
                                        <td>03-08-2018</td>
                                        <td>NO</td>
                                    </tr>
                                    <tr>
                                        <td>Centro 6</td>
                                        <td>SI</td>
                                        <td>03-08-2018</td>
                                        <td>NO</td>
                                    </tr>
                                    <tr>
                                        <td>Centro 7</td>
                                        <td>SI</td>
                                        <td>03-08-2018</td>
                                        <td>NO</td>
                                    </tr>
                                    <tr>
                                        <td>Centro 8</td>
                                        <td>SI</td>
                                        <td>03-08-2018</td>
                                        <td>NO</td>
                                    </tr>
                                    <tr>
                                        <td>Centro 9</td>
                                        <td>SI</td>
                                        <td>03-08-2018</td>
                                        <td>NO</td>
                                    </tr>
                                    <tr>
                                        <td>Centro 10</td>
                                        <td>SI</td>
                                        <td>03-08-2018</td>
                                        <td>NO</td>
                                    </tr>
                                    <tr>
                                        <td>Centro 11</td>
                                        <td>SI</td>
                                        <td>03-08-2018</td>
                                        <td>NO</td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

        </div> <!-- .content -->
</template>