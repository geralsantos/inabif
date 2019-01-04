<template id="nna-datos-centro-servicios">
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

                            <div class="form-group col-md-1">
                                <label for="text-input" class=" form-control-label">Año</label>
                                <select name="select" disabled="disabled" id="anio"  v-model="anio" class="form-control" >
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                </select>

                            </div>
                            <div class="form-group col-md-2">
                                <div class=""><label for="text-input" class=" form-control-label">Mes</label>
                                <select id="mes" v-model="mes" disabled="disabled" class="form-control"  >
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
                            <div class="form-group col-md-3">
                                <div class=" "><label for="text-input" class=" form-control-label">Código de la Entidad</label>
                                <input type="text" v-model="Cod_Entidad" name="Cod_Entidad" placeholder="" class="form-control" readonly> </div>
                            </div>
                            <div class="form-group col-md-9">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre de la Entidad</label>
                                <input type="text" v-model="Nom_Entidad" name="Nom_Entidad" placeholder="" class="form-control" readonly> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <div class=" "><label for="text-input" class=" form-control-label">Código de la Línea</label>
                                <input type="text" v-model="Cod_Linea" name="Cod_Linea" placeholder="" class="form-control" readonly> </div>
                            </div>
                            <div class="form-group col-md-9">
                                <div class=" "><label for="text-input" class=" form-control-label">Línea de Intervención</label>
                                <input type="text" v-model="Linea_Intervencion" name="Linea_Intervencion" placeholder="" class="form-control" readonly> </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="form-group col-md-3">
                                <div class=" "><label for="text-input" class=" form-control-label">Código del Servicio</label>
                                <input type="text" v-model="Cod_Servicio" name="Cod_Servicio" placeholder="" class="form-control" readonly> </div>
                            </div>
                            <div class="form-group col-md-9">
                                <div class=" "><label for="text-input" class=" form-control-label">Nombre del Servicio</label>
                                <input type="text" v-model="NomC_Servicio" name="NomC_Servicio" placeholder="" class="form-control" readonly> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Departamento del Centro de Atención</label>
                                <select name="Departamento_Centro" v-model="Departamento_Centro" @change="buscar_provincias()" class="form-control" disabled="disabled">
                                    <option v-for="departamento in departamentos" :value="departamento.CODDEPT">{{departamento.NOMDEPT}}</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Provincia del Centro de Atención</label>
                                <select name="Provincia_centro" v-model="Provincia_centro" @change="buscar_distritos()" class="form-control" disabled="disabled">
                                    <option v-for="provincia in provincias" :value="provincia.CODPROV">{{provincia.NOMPROV}}</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Distrito del Centro de Atención</label>
                                <select name="Distrito_centro" v-model="Distrito_centro" class="form-control" disabled="disabled">
                                    <option v-for="distrito in distritos" :value="distrito.CODDIST">{{distrito.NOMDIST}}</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=""><label for="text-input" class=" form-control-label">Área de residencia del centro de atención</label>
                                    <select name="Area_Residencia" v-model="Area_Residencia" class="form-control" disabled="disabled">
                                        <option value="URBANO">URBANO</option>
                                        <option value="RURAL">RURAL</option>
                                </select></div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class=""><label for="text-input" class=" form-control-label">Código del Centro de Atención</label>
                                <input type="text" v-model="CodigoC_Atencion" name="CodigoC_Atencion" placeholder="" class="form-control" readonly></div>
                            </div>
                            <div class="form-group col-md-5">
                                <div class=""><label for="text-input" class=" form-control-label">Nombre del Centro de Atención</label>
                                <input type="text" v-model="NomC_Atencion" name="NomC_Atencion" placeholder="" class="form-control" readonly></div>
                            </div>
                        </div>

                        </form>
                </div>
            </div>
        </div>
    </div> <!-- .content -->
</template>