<template id="ppd-datos-educacion-participacionLaboral">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Educación,participación Laboral y fortalecimiento de actividades</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form  class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                        <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Tipo de de IIEE a la que asiste</label>
                                <select name="CarTipoIIEE" v-model="CarTipoIIEE" class="form-control">
                                    <option value="">CEBE</option>
                                    <option value="">CEBA</option>
                                    <option value="">CETPRO</option>
                                    <option value="">CBR inclusivo </option>
                                    <option value="">Otro</option>
                                    <option value="">No Estudia</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Residente se encuentra insertado laboralmente</label>
                                <select name="CarInsertadoLaboralmente" v-model="CarInsertadoLaboralmente" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Descriptivo de la participación laboral</label>
                                <input type="text" v-model="CarDesParticipacionLa" name="CarDesParticipacionLa" placeholder="" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">NNA participa en actividades de fortalecimiento de habilidades personales y sociales </label>
                                <select name="CarFortalecimientoHabilidades" v-model="CarFortalecimientoHabilidades" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Fecha de inicio del NNA en actividades de fortalecimiento de habilidades personales y sociales </label>
                                <input type="date" v-model="CarFIActividades" name="CarFIActividades" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Fecha final del NNA en actividades de fortalecimiento de habilidades personales y sociales </label>
                                <input type="date" v-model="CarFFActividades" name="CarFFActividades" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">NNA conluyó actividades de fortalecimiento de habilidades personales y sociales </label>
                                <select name="CarNNAConcluyoHP" v-model="CarNNAConcluyoHP" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">NNA logró fortalecer sus habilidades personales y sociales</label>
                                <select name="CarNNAFortaliceHP" v-model="CarNNAFortaliceHP" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
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