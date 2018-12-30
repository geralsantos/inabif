<template id="ppd-datos-admision-usuario">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de Admisión Del Usuario</strong>
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
                                <label for="text-input" class=" form-control-label">Movimiento Poblacional</label>
                                <select name="CarMPoblacional" v-model="CarMPoblacional" class="form-control">
                                    <option value="nuevo">NUEVO</option>
                                    <option value="continuador">CONTINUADOR</option>
                                    <option value="reingreso">REINGRESO</option>
                                    <option value="transladod de otro car">TRASLADO DE OTRO CAR</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Fecha de reingreso</label>
                                <input type="date" v-model="CarFReingreso" name="CarFReingreso"  class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Fecha de ingreso del usuario</label>
                                <input type="date" v-model="CarFIngreso" name="CarFIngreso" placeholder="" class="form-control"> </div>
                            </div>
                        
                            
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Institución que lo derivó</label>
                                <select name="CarIDerivo" v-model="CarIDerivo" class="form-control">
                                <option v-for="institucion in instituciones" :value="institucion.ID">{{institucion.NOMBRE}}</option>

                                </select>
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Motivo de ingreso (acorde al expediente)</label>
                                <select name="CarMotivoI" v-model="CarMotivoI" class="form-control">
                                    <option value="Riesgo de desprotección">Riesgo de desprotección</option>
                                    <option value="Situación de desprotección">Situación de desprotección</option>
                                </select>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Tipo de documento de ingreso al CAR</label>
                                <select name="CarTipoDoc" v-model="CarTipoDoc" class="form-control">
                                <option v-for="documento in documentos" :value="documento.ID">{{documento.NOMBRE}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Número del documento de ingreso al car</label>
                                <input type="number" min="0"  v-model="CarNumDoc" name="CarNumDoc" placeholder="" class="form-control">
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