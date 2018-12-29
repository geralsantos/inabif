<template id="ppd-datos-centro-servicios">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos del Centro de Servicios</strong>
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
                                <div class=" "><label for="text-input" class=" form-control-label">Código de la Entidad</label>
                                <input type="text" v-model="CarCodEntidad" name="CarCodEntidad" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre de la Entidad</label>
                                <input type="text" v-model="CarNomEntidad" name="CarNomEntidad" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Código de la Línea</label>
                                <input type="text" v-model="CarCodLinea" name="CarCodLinea" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Línea de Intervención</label>
                                <input type="text" v-model="CarLineaI" name="CarLineaI" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Código del Servicio</label>
                                <input type="text" v-model="CarCodServicio" name="CarCodServicio" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre del Servicio</label>
                                <input type="text" v-model="CarNomServicio" name="CarNomServicio" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Departamento del Centro de Atención</label>
                                <select name="CarDepart" v-model="CarDepart" class="form-control"  @change="cargar_provincias()">
                                    <option v-for="departamento in departamentos" :value="departamento.CODDEPT">{{departamento.NOMDEPT}}</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Provincia del Centro de Atención</label>
                                <select name="CarProv" v-model="CarProv" class="form-control"  @change="cargar_distritos()">
                                    <option v-for="provincia in provincias" :value="provincia.CODPROV">{{provincia.NOMPROV}}</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Distrito del Centro de Atención</label>
                                <select name="CarDistrito" v-model="CarDistrito" class="form-control">
                                    <option v-for="distrito in distritos" :value="distrito.CODDIST">{{distrito.CODDIST}}</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class=""><label for="text-input" class=" form-control-label">Área de residencia del centro de atención</label>
                                    <select name="areaResidencia" v-model="areaResidencia" class="form-control">
                                    <option value="Urbano">Urbano</option>
                                    <option value="Rural">Rural</option>
                                </select></div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=""><label for="text-input" class=" form-control-label">Centro Poblado del Centro de Atención</label>
                                <input type="text" v-model="centroPoblado" name="centroPoblado" placeholder="" class="form-control"></div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="form-group col-md-6">
                                <div class=""><label for="text-input" class=" form-control-label">Código del Centro de Atención</label>
                                <input type="text" v-model="codigoCentroAtencion" name="codigoCentroAtencion" placeholder="" class="form-control"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=""><label for="text-input" class=" form-control-label">Nombre del Centro de Atención</label>
                                <input type="text" v-model="nombreCentroAtencion" name="nombreCentroAtencion" placeholder="" class="form-control"></div>
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