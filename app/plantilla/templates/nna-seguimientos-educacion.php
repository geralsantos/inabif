<template id="nna-seguimientos-educacion">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Sguimiento Educacion</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form class="form-horizontal" v-on:submit.prevent="guardar">
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
                                <div class=" "><label for="text-input" class=" form-control-label">Plan de Intervención</label>
                                <select name="Plan_Intervencion" v-model="Plan_Intervencion" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Meta trazada en el PAI</label>
                        <textarea v-model="Meta_PAI" name="Meta_PAI"  class="form-control" id="" cols="30" rows="2"></textarea>
                                </div>


                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Posee informe técnico evolutivo</label>
                                <select name="Informe_Tecnico" v-model="Informe_Tecnico" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>  </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Cumplimiento del Plan de intervención</label>
                                    <!--  <select name="Cumple_Intervencion" v-model="Cumple_Intervencion" class="form-control">
                                    <option value="">CUMPLIDA</option>
                                    <option value="">EN PROCESO</option>
                                    <option value="">NO SE EVIDENCIA PROGRESO</option>
                                    </select>  -->
                                    <textarea rows="2" cols="30" v-model="Cumple_Intervencion" name="Cumple_Intervencion" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Residente promovido de año ?</label>
                                    <select name="Provino_Ano" v-model="Provino_Ano" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Desempeño Académico favorable?</label>
                                    <select name="Desempeno" v-model="Desempeno" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center" >
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-send"></i> Grabar Datos
                                </button>
                            </div>
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div> <!-- .content -->
</template>