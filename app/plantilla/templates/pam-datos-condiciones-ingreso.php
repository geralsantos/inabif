<template id="pam-datos-condiciones-ingreso">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de Condiciones de Ingreso del Residente (Derechos)</strong>
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
                            <div class="form-group col-md-2">
                                <div class=" "><label for="text-input" class=" form-control-label">Documento de Identidad</label>
                                <select name="documento_entidad" v-model="documento_entidad" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class=" "><label for="text-input" class=" form-control-label">Tipo de Documento</label>
                                <select name="tipo_documento_entidad" v-model="tipo_documento_entidad" class="form-control">
                                <option value="Dni">Dni</option>
                                <option value="Carnét de extranjería">Carnét de extranjería</option>
                                <option value="Pasaporte">Pasaporte</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Número de Documento de Identidad</label>
                                <input type="text" v-model="numero_documento_ingreso" name="numero_documento_ingreso" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Saber Leer y Escribir</label>
                                <select name="leer_escribir" v-model="leer_escribir" class="form-control">
                                <option value="">Si</option>
                                <option value="">No</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Nivel Educativo</label>
                                <select name="nivel_educativo" v-model="nivel_educativo" class="form-control">
                                <option value="Sin Educación">Sin Educación</option>
                                <option value="Primaria Incompleta">Primaria Incompleta</option>
                                <option value="Primaria Completa">Primaria Completa</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Cuenta con aseguramiento en Salud</label>
                                <select name="aseguramiento_salud" v-model="aseguramiento_salud" class="form-control">
                                <option value="ESSALUD">ESSALUD</option>
                                <option value="FFAA_PNP">FFAA_PNP</option>
                                <option value="Seguro Privado">Seguro Privado</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Tipo de Pensión</label>
                                <select name="tipo_pension" v-model="tipo_pension" class="form-control">
                                <option value="Sin Clasificación Socioeconómica">Sin Clasificación Socioeconómica</option>
                                <option value="Pobre Extremo">Pobre Extremo</option>
                                <option value="Pobre no Extremo">Pobre no Extremo</option>
                                <option value="No Pobre">No Pobre</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Clasificación Socioeconómica (SISFOH)</label>
                                <select name="SISFOH" v-model="SISFOH" class="form-control">
                                <option value="Sin Clasificación Socioeconómica">Sin Clasificación Socioeconómica</option>
                                <option value="Pobre Extremo">Pobre Extremo</option>
                                <option value="Pobre no Extremo">Pobre no Extremo</option>
                                <option value="No Pobre">No Pobre</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Cuenta con familiares ubicados</label>
                                <select name="familiar_ubicados" v-model="familiar_ubicados" class="form-control">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Tipo de Parentesco</label>
                                <select name="tipo_parentesco" v-model="tipo_parentesco" class="form-control">
                                    <option value="Padre/Madre">Padre/Madre</option>
                                    <option value="Hermano(a">Hermano(a)</option>
                                    <option value="Primos(a)">Primos(a)</option>
                                    <option value="Hijo(a)">Hijo(a)</option>
                                    <option value="Nieto">Nieto</option>
                                    <option value="Otros">Otros</option>
                                </select>
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