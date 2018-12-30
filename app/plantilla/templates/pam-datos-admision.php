<template id="pam-datos-admision">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de Admisión del Residente</strong>
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
                                <div class=" "><label for="text-input" class=" form-control-label">Movimiento Poblacional</label>
                                <select name="movimiento_poblacional" v-model="movimiento_poblacional" class="form-control">
                                <option value="Nuevo">Nuevo</option>
                                <option value="Continuador">Continuador</option>
                                <option value="Reingreso">Reingreso</option>
                                <option value="Traslado">Traslado</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Fecha de Ingreso del Residente</label>
                                <input type="date" v-model="fecha_ingreso_usuario" name="fecha_ingreso_usuario" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Institución que lo deriva</label>
                                <select name="institucion_deriva" v-model="institucion_deriva" class="form-control">
                                <option v-for="institucion in instituciones" :value="institucion.ID">{{institucion.NOMBRE}}</option>
                                
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Motivo de Ingreso PRINCIPAL</label>
                                <select name="motivo_ingreso_principal" v-model="motivo_ingreso_principal" class="form-control">
                                <option v-for="motivo in motivos" :value="motivo.ID">{{motivo.NOMBRE}}</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                            <div class=" "><label for="text-input" class=" form-control-label">Motivo de Ingreso SECUNDARIO</label>
                                <select name="motivo_ingreso_secundario" v-model="motivo_ingreso_secundario" class="form-control">
                                <option v-for="motivo2 in motivos2" :value="motivo2.ID">{{motivo2.NOMBRE}}</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Perfil de Ingreso</label>
                                <select name="perfil_ingreso" v-model="perfil_ingreso" class="form-control" multiple>
                                    <option value="Pobreza o pobreza extrema"> Pobreza o pobreza extrema</option>
                                    <option value="Dependencia o fragilidad">Dependencia o fragilidad</option>
                                    <option value="Victimas de cualquier tipo de violencia">Víctimas de cualquier tipo de violencia</option>
                                </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                        <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Tipo de Documento de Ingreso CAR</label>
                                <select name="tipo_documento_ingreo_car" v-model="tipo_documento_ingreo_car" class="form-control">
                                    <option value="Oficio">Oficio</option>
                                    <option value="Acta">Acta</option>
                                    <option value="Resolucion">Resolución</option>
                                    <option value="Otros">Otros</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <div class=" "><label for="text-input" class="form-control-label">Número de documento Ingreso CAR</label>
                                <input type="text" v-model="numero_documento_ingreo_car" class="form-control" name="numero_documento_ingreo_car">
                                </div>
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