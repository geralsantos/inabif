<template id="nna-seguimientos-trabajo-social">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Seguimiento Trabajo Social</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form  class="form-horizontal" v-on:submit.prevent="guardar">
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
                                <div class=" "><label for="text-input" class=" form-control-label">Plan de Intervención </label>
                                <select name="Plan_Intervencion" id="Plan_Intervencion" v-model="Plan_Intervencion" class="form-control">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Meta trazada en el PAI</label>
                         
                                <textarea id="Meta_PAI" name="Meta_PAI" v-model="Meta_PAI" class="form-control" cols="30" rows="2"></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Posee informe técnico evolutivo?</label>
                                <select name="Informe_Tecnico" id="Informe_Tecnico" v-model="Informe_Tecnico" class="form-control">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select>  </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">¿Cumplimiento del Plan de intervención</label>
                                    <select name="Cumple_Intervencion" v-model="Cumple_Intervencion" id="Cumple_Intervencion" class="form-control">
                                    <option value="Cumplida">Cumplida</option>
                                    <option value="En proceso">En proceso</option>
                                    <option value="No se evidencia progreso">No se evidencia progreso</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">¿Participación activa familiar?</label>
                                    <select name="ParticipacionF_Activa" v-model="ParticipacionF_Activa" id="ParticipacionF_Activa" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">¿Plan de Reinserción familiar?</label>
                                    <select name="Reinsercion_Familiar" v-model="Reinsercion_Familiar" id="Reinsercion_Familiar" class="form-control">
                                    <option value="Si">Si</option>
                                <option value="No">No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Familia usa las redes de soporte social?</label>
                                <select name="FamiliaR_Soporte" v-model="FamiliaR_Soporte" id="FamiliaR_Soporte" class="form-control">
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