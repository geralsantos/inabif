<template id="ppd-datos-egreso-terapiaFisica">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Egreso - Terapia fisica</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                        <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Posee plan de intervención médico  individual?</label>
                                <select name="CarPlanIntervension" v-model="CarPlanIntervension" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Descripción de la meta trazada en el PII</label>
                                <input type="text" v-model="CarDesMetaPII" name="CarDesMetaPII" placeholder="" class="form-control">

                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Posee informe técnico evolutivo</label>
                                <select name="CarinformeEvolutivo" v-model="CarinformeEvolutivo" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Descripción del informe evolutivo</label>
                                <input type="text" v-model="CarDesInformeEvolutivo" name="CarDesInformeEvolutivo" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Cumplimiento del plan de intervención</label>
                                <select name="CarCumplePlan" v-model="CarCumplePlan" class="form-control">
                                    <option value="Residente logra el objetivo trazado">Residente logra el objetivo trazado</option>
                                    <option value="En proceso">En proceso</option>
                                    <option value="Residente no logra el objetivo trazado">Residente no logra el objetivo trazado</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Desarrollo de capacidades básicas para el lenguaje</label>
                                <select name="CarDesarrolloCapacidades" v-model="CarDesarrolloCapacidades" class="form-control">
                                    <option value="Respiración">Respiración</option>
                                    <option value="Fortalecimiento de músculos de cabeza, cuello y boca">Fortalecimiento de músculos de cabeza, cuello y boca</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Mejora de la emisión de fonemas?</label>
                                <select name="CarMejoraEmision" v-model="CarMejoraEmision" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Mejora del lenguaje comprensivo?</label>
                                <select name="CarManejoLenguaje" v-model="CarManejoLenguaje" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Construcción o elaboración de oraciones</label>
                                <select name="CarElavoraOraciones" v-model="CarElavoraOraciones" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
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