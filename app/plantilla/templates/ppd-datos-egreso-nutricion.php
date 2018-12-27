<template id="ppd-datos-egreso-nutricion">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Egreso - Nutrición</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form  class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                        <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Posee plan de intervención nutricional  individual?</label>
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
                                <input type="text" v-model="CarDesInformEvolutivo" name="CarDesInformEvolutivo" placeholder="" class="form-control">
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
                                <label for="text-input" class=" form-control-label">Estado nutricional (imc)</label>
                                <select name="CarEstadoNutricional" v-model="CarEstadoNutricional" class="form-control">
                                    <option value="Adelgazado">Adelgazado</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Sobrepeso">Sobrepeso</option>
                                    <option value="Obeso">Obeso</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Peso (Kg.)</label>
                                <input type="text" v-model="CarPeso" name="CarPeso" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Talla (m)</label>
                                <input type="text" v-model="CarTalla" name="CarTalla" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Hemoglobina (gr./dl)</label>
                                <input type="text" v-model="CarHemoglobina" name="CarHemoglobina" placeholder="" class="form-control">
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