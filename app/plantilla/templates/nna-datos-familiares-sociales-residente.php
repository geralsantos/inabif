<template id="nna-datos-familiares-sociales-residente">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos Familiares y Sociales del Residente</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Cuenta con Familiares Ubicados</label>
                                <select name="NNACuentaFamilia" v-model="NNACuentaFamilia" class="form-control">
                                <option value="">Si</option>
                                <option value="">No</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Tipo de Parentesco</label>
                                <select name="NNATipoParentesco" v-model="NNATipoParentesco" class="form-control">
                                <option value="">Padre</option>
                                <option value="">Madre</option>
                                <option value="">Hermano/a</option>
                                <option value="">Tio/a</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Tipo de Familia del Usuario</label>
                                <select name="NNATipoFamilia" v-model="NNATipoFamilia" class="form-control">
                                <option value="">Nuclear</option>
                                <option value="">Extensa</option>
                                <option value="">Mononuclear</option>
                                </select>  </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Problemática Familiar</label>
                                <select name="NNAProblematicaFamiliar" v-model="NNAProblematicaFamiliar" class="form-control">
                                <option value="">Ausentismo de madre por trabajo</option>
                                <option value="">Conductual</option>
                                <option value="">Experiencia en Calle</option>
                                <option value="">Conductual</option>
                                <option value="">Violencia Sexual</option>
                                </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-center" >
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-send"></i> Grabar datos
                                </button>
                            </div>
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div> <!-- .content -->
</template>