<template id="ppd-datos-egreso-educacion">
<div class="content mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Egreso Educación</strong>
                        <h6>Formulario de Carga de Datos</h6>
                    </div>
                    <div class="card-body card-block">
                        <form class="form-horizontal"  v-on:submit.prevent="guardar">
                            <div class="row">
                            <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Posee plan de intervención Educación  individual?</label>
                                    <select name="CarIntervencion" v-model="CarIntervencion" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Descripción de la meta trazada en el PII</label>
                                    <input type="text" v-model="CarDesMeta" name="CarDesMeta" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Posee informe técnico evolutivo?</label>
                                    <select name="CarInformeEvolutivo" v-model="CarInformeEvolutivo" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Descripción del informe evolutivo</label>
                                    <input type="text" v-model="CarDesInfome" name="CarDesInfome" placeholder="" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Cumplimiento del plan de intervención</label>
                                    <select name="CarCumplimientoPlan" v-model="CarCumplimientoPlan" class="form-control">
                                        <option value="Residente logra el objetivo trazado">Residente logra el objetivo trazado</option>
                                        <option value="En proceso">En proceso</option>
                                        <option value="Residente no logra el objetivo trazado">Residente no logra el objetivo trazado</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Asistencia escolar continua en el periodo?</label>
                                    <select name="CarAsistenciaEscolar" v-model="CarAsistenciaEscolar" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Desempeño academico favorable en el periodo</label>
                                    <select name="CarDesempeAcademico" v-model="CarDesempeAcademico" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="Sobresaliente">Sobresaliente</option>
                                        <option value="Si, satisfactorio"> Si, satisfactorio</option>
                                        <option value="No">No</option>
                                        <option value="No, insatisfactorio"> No, insatisfactorio</option>
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