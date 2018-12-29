<template id="pam-atenciones-salud">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Atenciones Salud</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="row">
                            <div class="form-group col-md-7">
                                <label for="text-input" class=" form-control-label">Nombre Residente</label>
                                <div class="autocomplete">
                                    <input type="text"  v-model="nombre_residente" class="form-control" @keyup="buscar_residente()" placeholder="Nombre, Apellido o DNI"/>
                                    <ul  id="autocomplete-results" class="autocomplete-results" v-if="bloque_busqueda">
                                        <li class="loading" v-if="isLoading">
                                            Loading results...
                                        </li>
                                        <li  @click="actualizar(coincidencia)" class="autocomplete-result" v-for="coincidencia in coincidencias">
                                            {{coincidencia.NOMBRE}} {{coincidencia.APELLIDO}} - {{coincidencia.DOCUMENTO}}
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="text-input" class=" form-control-label">Año</label>
                                <select name="select" disabled="disabled" id="anio"  v-model="anio" class="form-control">
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <div class=""><label for="text-input" class=" form-control-label">Mes</label>
                                <select id="mes" v-model="mes" disabled="disabled" class="form-control" >
                                        <option value="1">Enero</option>
                                        <option value="2">Febrero</option>
                                        <option value="3">Marzo</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Mayo</option>
                                        <option value="6">Junio</option>
                                        <option value="7">Julio</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select> </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Residente tuvo salida a hospitales en el mes</label>
                                <select name="NNAPlanIntervencion" v-model="NNAPlanIntervencion" class="form-control">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Número de salidas a hospitales</label>
                                <input type="number" min="0"  v-model="NNAPsiquiatrico1" name="NNAPsiquiatrico1" placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">N° de atenciones en CARDIOVASCULAR</label>
                                <input type="number" min="0"  v-model="NNAPsiquiatrico2" name="NNAPsiquiatrico2" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de atenciones en NEFROLOGÍA</label>
                                <input type="number" min="0"  v-model="NNAPsiquiatrico3" name="NNAPsiquiatrico3" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de atenciones en ONCOLOGÍA</label>
                                <input type="number" min="0"  v-model="NNANeurologico1" name="NNANeurologico1" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en NEUROCIRUGÍA</label>
                                <input type="number" min="0"  v-model="NNANeurologico2" name="NNANeurologico2" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en DERMATOLOGÍA</label>
                                <input type="number" min="0"  v-model="NNANeurologico3" name="NNANeurologico3" placeholder="" class="form-control"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en ENDOCRINOLOGÍA</label>
                                <input type="number" min="0"  v-model="NNACronico1" name="NNACronico1" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en GASTROENTEROLOGIA</label>
                                <input type="number" min="0"  v-model="NNACronico2" name="NNACronico2" placeholder="" class="form-control">
                                    
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label"> Nº atenciones en HEMATOLOGIA</label>
                                <input type="number" min="0"  v-model="NNACronico3" name="NNACronico3" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Nº atenciones en INMUNOLOGIA</label>
                                <input type="number" min="0"  v-model="NNAAgudo1" name="NNAAgudo1" placeholder="" class="form-control">
                                    
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Nº atenciones en MEDICINA FISICA Y REHABILITACION</label>
                                <input type="number" min="0"  v-model="NNAAgudo2" name="NNAAgudo2" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Nº atenciones en NEUMOLOGIA</label>
                                <input type="number" min="0"  v-model="NNAAgudo3" name="NNAAgudo3" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Nº atenciones en NUTRICION</label>
                                <input type="number" min="0"  v-model="NNAAgudo3" name="NNAAgudo3" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Nº atenciones en NEUROLOGIA</label>
                                <input type="number" min="0"  v-model="NNAAgudo3" name="NNAAgudo3" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº atenciones en OFTALMOLIGIA</label>
                                <input type="number" min="0"  v-model="NNAAgudo3" name="NNAAgudo3" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº atenciones en OTORRINOLARINGOLOGIA</label>
                                <input type="number" min="0"  v-model="NNAAgudo3" name="NNAAgudo3" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en PSIQUIATRIA</label>
                                    <input type="number" min="0"  v-model="NNAAgudo3" name="NNAAgudo3" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en TRAUMATOLOGIA</label>
                                <input type="number" min="0"  v-model="NNAAgudo3" name="NNAAgudo3" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en UROLOGIA</label>
                                <input type="number" min="0"  v-model="NNAAgudo3" name="NNAAgudo3" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en ODONTOLOGIA</label>
                                <input type="number" min="0"  v-model="NNAAgudo3" name="NNAAgudo3" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Medicina general y/o Geriatrica</label>
                                <input type="number" min="0"  v-model="NNAAgudo3" name="NNAAgudo3" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en Otros servicios</label>
                                <input type="number" min="0"  v-model="NNAAgudo3" name="NNAAgudo3" placeholder="" class="form-control">
                            </div>
                            
                        </div>

                        <div class='row'>
                        <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Residente fue hospitalizado en el periodo</label>
                                <select name="NNASIS" v-model="NNASIS" class="form-control">
                                    <option value="">Si</option>
                                    <option value="">No</option>
                                </select> 
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Motivo de la hospitalización</label>
                                <input type="text" v-model="NNAAgudo3" name="NNAAgudo3" placeholder="" class="form-control">
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