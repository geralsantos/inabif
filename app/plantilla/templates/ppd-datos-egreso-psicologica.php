<template id="ppd-datos-egreso-psicologica">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Egreso Psicológico</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                        <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Posee plan de intervención Psicológico individual?</label>
                                <select name="CarPlanIntervencion" v-model="CarPlanIntervencion" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Descripción de la meta trazada en el PII</label>
                                <input type="text" v-model="CarDesMetaPII" name="CarDesMetaPII" placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Posee informe técnico evolutivo?</label>
                                <select name="CarInformeTecnico" v-model="CarInformeTecnico" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Descripción del informe evolutivo</label>
                                <input type="text" v-model="CarDesInforme" name="CarDesInforme" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Cumplimiento del plan de intervención</label>
                                <select name="CarCumplePlan" v-model="CarCumplePlan" class="form-control">
                                    <option value="Residente logra el objetivo trazado">Residente logra el objetivo trazado</option>
                                    <option value="En proceso">En proceso</option>
                                    <option value="Residente no logra el objetivo trazado">Residente no logra el objetivo trazado</option>
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