<template id="pam-datos-nutricion">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Seguimiento - Nutricion</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form class="form-horizontal" v-on:submit.prevent="guardar">
                       
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Posee plan de intervención en Nutrición</label>
                                <select name="Plan_Intervencion" v-model="Plan_Intervencion" class="form-control">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Meta trazada en el PAI</label>
                                <input type="text" v-model="Meta_PAI" name="Meta_PAI" placeholder="" class="form-control">
                                    </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Posee informe técnico evolutivo?</label>
                                <select name="Informe_Tecnico" v-model="Informe_Tecnico" class="form-control">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select>  </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class=" "><label for="text-input" class=" form-control-label">Informe evolutivo</label>
                                <input type="text" v-model="Des_Informe_Tecnico" name="Des_Informe_Tecnico" placeholder="" class="form-control">
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="text-input" class=" form-control-label">Cumplimiento del plan de intervención</label>
                                <select name="Cumple_Intervencion" v-model="Cumple_Intervencion" class="form-control">
                                <option value="Residente logra el objetivo trazado">Residente logra el objetivo trazado</option>
                                <option value="En proceso">En proceso</option>
                                <option value="Residente no logra el objetivo trazado">Residente no logra el objetivo trazado</option>
                                </select> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Estado nutricional</label>
                                    <select name="Estado_Nutricional_IMC" v-model="Estado_Nutricional_IMC" class="form-control">
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
                                <input type="number" v-model="Peso" name="Peso" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Talla (m)</label>
                                <input type="number" v-model="Talla" name="Talla" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Hemoglobina (gr./dl)</label>
                                <input type="number" v-model="Hemoglobina" name="Hemoglobina" placeholder="" class="form-control">
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center" >
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-send"></i>Grabar Datos
                                </button>
                            </div>
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div> <!-- .content -->
</template>