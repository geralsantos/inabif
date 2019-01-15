<template id="seguimiento-lista-3">
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
                                    <th scope="col" v-for="cabecera in cabeceras">{{cabecera}}</th>

                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr v-for="campo in campos" style="text-align:left;">
                                    <td v-for="item in campo">{{item}}</td>

                                </tr>

                            </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>


    </div> <!-- .content -->

</template>