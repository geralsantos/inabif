<template id="ppd-datos-atencion-psicologica">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Atencion Psicologicas</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                        <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que participa en Desarrollo de hablidades básicas para el aprendizaje (atención, concentración, imitación, seguimiento de órdenes)</label>
                                <input type="number" v-model="CarNumHabilidadesBasicas" name="CarNumHabilidadesBasicas" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que participa en Desarrollo de hablidades conceptuales</label>
                                <input type="number" v-model="CarNumHabilidadesConceptuales" name="CarNumHabilidadesConceptuales" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que participa en Desarrollo de hablidades sociales básicas (saludar, pedir un favor, contestar preguntas, etc.) </label>
                                <input type="number" v-model="CarNumHabilidadesSociales" name="CarNumHabilidadesSociales" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que participa en Desarrollo de hablidades prácticas básicas (hablar por teléfono, hacer uso de transporte público, uso del dinero, trabajo, etc). </label>
                                <input type="number" v-model="CarNumHablidadesPracticas" name="CarNumHablidadesPracticas" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que participa en Modificación de conducta</label>
                                <input type="number" v-model="CarNumModificacionConducta" name="CarNumModificacionConducta" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-center" >
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-send"></i> Cargar Datos
                                </button>
                            </div>
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div> <!-- .content -->
</template>