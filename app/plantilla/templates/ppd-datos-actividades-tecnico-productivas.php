<template id="ppd-datos-actividades-tecnico-productivas">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Actividades tecnico productivas</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form  class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                        <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en el taller de Biohuerto</label>
                                <input type="number" v-model="CarNumBiohuerto" name="CarNumBiohuerto" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">N° de veces que Participa en el taller de Manualidades</label>
                                <input type="number" v-model="CarNumManualidades" name="CarNumManualidades" placeholder="" class="form-control">
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en el taller de Panadería- repostería</label>
                                <input type="number" v-model="CarNumReposteria" name="CarNumReposteria" placeholder="" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que participa de paseos o caminatas</label>
                                <input type="number" v-model="CarNumPaseos" name="CarNumPaseos" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que participa de Visitas culturales</label>
                                <input type="number" v-model="CarNumCulturales" name="CarNumVCulturales" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que participa de Actividades cívicas y protocolares</label>
                                <input type="number" v-model="CarNumACivicas" name="CarNumACivicas" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que participa en deporte Fútbol</label>
                                <input type="number" v-model="CarNumFutbol" name="CarNumFutbol" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que participa en deporte Natación</label>
                                <input type="number" v-model="CarNumNatacion" name="CarNumNatacion" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que participa en Otros deportes</label>
                                <input type="number" v-model="CarNumDeportes" name="CarNumDeportes" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que participa en actividades de enseñanza del Manejo de Dinero</label>
                                <input type="number" v-model="CArNumDinero" name="CArNumMDinero" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que participa en activisades para la toma de decisiones con apoyo</label>
                                <input type="number" v-model="CarNumDecisiones" name="CarNumDecisiones" placeholder="" class="form-control">
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