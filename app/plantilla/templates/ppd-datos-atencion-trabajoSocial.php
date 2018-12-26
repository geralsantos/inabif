<template id="ppd-datos-atencion-trabajoSocial">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Atencion en Trabajo Social</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                        <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Residente recibe visitas de Familiares?</label>
                                <select name="CarVisitaF" v-model="CarVisitaF" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">n° de visitas en el mes</label>
                                <input type="number" v-model="CarNumVisitaMes" name="CarNumVisitaMes" placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Existe posibilidad de reinserción familiar?</label>
                                <select name="CarResinsercionF" v-model="CarResinsercionF" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                        <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Familia accede a redes de soporte social?</label>
                                <select name="CarFamiliaRSoporte" v-model="CarFamiliaRSoporte" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Descriptivo de la persona que los visita</label>
                                <input type="text" v-model="CarDesPersonaV" name="CarDesPersonaV" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Residente cuenta con DNI?</label>
                                <select name="CarRDni" v-model="CarRDni" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Residente cuenta con AUS?</label>
                                <select name="CarRAus" v-model="CarRAus" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Residente cuenta con carnet del CONADIS?</label>
                                <select name="CarRConadis" v-model="CarRConadis" class="form-control">
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