<template id="nna-seguimiento-psicologico">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Seguimiento Psicologico</strong>
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
                                <div class=" "><label for="text-input" class=" form-control-label">Plan de Intervención psicológico</label>
                                <select name="Plan_Intervencion" v-model="Plan_Intervencion" class="form-control">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Durante el periodo ha presentado </label>
                                <select name="Presento" v-model="Presento" class="form-control">
                                <option value="Problemas del aprendizaje">Problemas del aprendizaje</option>
                                <option value="Retraso en el Desarrollo psicomotor">Retraso en el Desarrollo psicomotor</option>
                                <option value="Trastorno de Estrés Post Traumático">Trastorno de Estrés Post Traumático</option>
                                <option value="Problemas de Autoestima">Problemas de Autoestima</option>
                                <option value="Diagnóstico depresivo">Diagnóstico depresivo</option>
                                <option value="Diagnóstico de Ansiedad">Diagnóstico de Ansiedad</option>
                                <option value="Trastorno del comportamiento">Trastorno del comportamiento</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">PRINCIPAL PERFIL ACTUAL</label>
                                <select name="Perfil" v-model="Perfil" class="form-control">
                                <option value="Trastorno de comportamiento">Trastorno de comportamiento</option>
                                <option value="Consumidores de sustancias psicoactivas">Consumidores de sustancias psicoactivas</option>
                                <option value="Experiencia Vida en Calle">Experiencia Vida en Calle</option>
                                <option value="Víctima de Explotación sexual">Víctima de Explotación sexual</option>
                                <option value="Víctima de trata por explotación sexual">Víctima de trata por explotación sexual</option>
                                <option value="Víctima de trata por mendicidad">Víctima de trata por mendicidad</option>
                                <option value="Víctima de trata por explotación laboral">Víctima de trata por explotación laboral</option>
                                <option value="Víctima de trata por comercialización de órganos">Víctima de trata por comercialización de órganos</option>
                                <option value="Víctima de trata por venta de niños/as">Víctima de trata por venta de niños/as</option>
                                <option value="Trastorno disocial">Trastorno disocial</option>
                                <option value="Víctima de violencia sexual">Víctima de violencia sexual</option>
                                <option value="Presunto infractor">Presunto infractor</option>
                                <option value="Víctima de maltrato físico y/o psicológico">Víctima de maltrato físico y/o psicológico</option>
                                <option value="Abandono">Abandono</option>
                                <option value="Victimas de explotación sexual">Victimas de explotación sexual</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Intervenciones terapéutica individual</label>
                                <input type="number" min="0"  v-model="Intervencion_Individual" name="Intervencion_Individual" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Intervenciones terapéutica grupal</label>
                                <input type="number" min="0"  v-model="Intervencion_Grupal" name="Intervencion_Grupal"  placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Consejerías y orientaciones psicológica</label>
                                <input type="number" min="0"  v-model="Nro_OrientacionP"  name="Nro_OrientacionP" placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Consejerías y orientaciones a la familia2</label>
                                <input type="number" min="0"  v-model="Nro_OrientacionF" name="Nro_OrientacionF" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Charlas Preventivo  - Promocionales Psicológicos</label>
                                <input type="number" min="0"  v-model="Nro_Charlas" name="Nro_Charlas"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº participaciones en sesiones  Taller de Liderazgo</label>
                                <input type="number" min="0"  v-model="Nro_TLiderazgo" name="Nro_TLiderazgo"  placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº participaciones en sesiones Taller de Autoestima</label>
                                <input type="number" min="0"  v-model="Nro_TAutoestima" name="Nro_TAutoestima"  placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº participaciones en sesiones  Taller de Sexualidad</label>
                                <input type="number" min="0"  v-model="Nro_TSexualidad" name="Nro_TSexualidad"  placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº participaciones en sesiones   Taller de prevención del embarazo en adolescentes</label>
                                <input type="number" min="0"  v-model="Nro_TPrevencionEmb" name="Nro_TPrevencionEmb"  placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº participaciones en sesiones  Taller de Igualdad de Género</label>
                                <input type="number" min="0"  v-model="Nro_TIgualdadG" name="Nro_TIgualdadG"  placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº participaciones en sesiones  Taller de Violencia Familiar</label>
                                <input type="number" min="0"  v-model="Nro_ViolenciaF" name="Nro_ViolenciaF"  placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº participaciones en sesiones Taller de Salud mental</label>
                                <input type="number" min="0"  v-model="Nro_SaludM" name="Nro_SaludM"  placeholder="" class="form-control">
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