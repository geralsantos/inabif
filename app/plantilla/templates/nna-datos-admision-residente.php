<template id="nna-datos-admision-residente">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de Admisión del Residente</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form  class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Movimiento Poblacional</label>
                                <select name="NNAMovimientoPoblacional" v-model="NNAMovimientoPoblacional" class="form-control">
                                <option value="">Nuevo</option>
                                <option value="">Continuador</option>
                                <option value="">Reingreso</option>
                                <option value="">Traslado</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Apellido Materno</label>
                                <input type="text" v-model="NNAApellidoMaterno" name="NNAApellidoMaterno" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre</label>
                                <input type="text" v-model="NNANombre" name="NNANombre" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">País de Procedencia</label>
                                <select name="NNAPaisProcedencia" v-model="NNAPaisProcedencia" class="form-control">
                                    <option value="">País</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Departamento de Procedencia</label>
                                <select name="NNADepartementoProcedencia" v-model="NNADepartementoProcedencia" class="form-control">
                                    <option value="">Departamento</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Departamento de Nacimiento</label>
                                <select name="NNADepartamentoNacimiento" v-model="NNADepartamentoNacimiento" class="form-control">
                                    <option value="">Departamento</option>
                                </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                        <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Provincia de Nacimiento</label>
                                <select name="NNAProvinciaNacimiento" v-model="NNAProvinciaNacimiento" class="form-control">
                                    <option value="">Provincia</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Distrito de Nacimiento</label>
                                <select name="NNADistritoNacimiento" v-model="NNADistritoNacimiento" class="form-control">
                                    <option value="">Distrito</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Sexo</label>
                                <select name="NNASexo" v-model="NNASexo" class="form-control">
                                <option value="">Hombre</option>
                                <option value="">Mujer</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" v-model="NNAFNacimiento" name="NNAFNacimiento"  placeholder="DD-MM-YYYY" v-model="fecha_fin_real"  data-language='es'  />
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Edad (Años)</label>
                                <input type="number" min="0"  v-model="NNAEdad" name="NNAEdad" placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Lengua Materna</label>
                                <select name="NNALenguaMAterna" v-model="NNALenguaMAterna" class="form-control">
                                <option value="">Quechua</option>
                                <option value="">Castellano</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Número o Código del Documento</label>
                                <input type="text" v-model="NNACodigoDocumento" name="NNACodigoDocumento" placeholder="" class="form-control">
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