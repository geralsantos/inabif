<template id="ppd-datos-condicion-ingreso">
<div class="content mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Datos de condicion de ingreso Del Usuario</strong>
                        <h6>Formulario de Carga de Datos</h6>
                    </div>
                    <div class="card-body card-block">
                        <form class="form-horizontal" v-on:submit.prevent="guardar">
                            <div class="row">
                            <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Documento de Identidad al ingreso</label>
                                    <select name="CarDocIngreso" v-model="CarDocIngreso" class="form-control">
                                        <option value="">Si</option>
                                        <option value="">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Tipo de documento identidad AL INGRESO</label>
                                    <select name="CarTipoDoc" v-model="CarTipoDoc" class="form-control">
                                        <option value="">DNI/L.E</option>
                                        <option value="">carné de extranjería</option>
                                        <option value="">Partida Nacimiento</option>
                                        <option value="">No tiene</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Número del documento </label>
                                    <input type="number" v-model="CarNumDoc" name="CarNumDoc" placeholder="" class="form-control">
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Usuarios sabe leer y escribir?</label>
                                    <select name="CarULeeEscribe" v-model="CarULeeEscribe" class="form-control">
                                        <option value="">Si</option>
                                        <option value="">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Nivel Educativo</label>
                                    <select name="CarNivelEducativo" v-model="CarNivelEducativo" class="form-control">
                                        <option value="">Sin nivel</option>
                                        <option value="">Inicial</option>
                                        <option value="">Primaria incompleta</option>
                                        <option value="">primaria completa</option>
                                        <option value="">secundaria incompleta </option>
                                        <option value=""> secundaria completa </option>
                                        <option value="">Se desconoce </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Intitución Educativa de Procedencia</label>
                                    <select name="CarInstitucionEducativa" v-model="CarInstitucionEducativa" class="form-control">
                                        <option value="">Centro de Educación Básica Regular</option>
                                        <option value="">Centro de Educación Basica Regular Inclusiva</option>
                                        <option value="">Centros de Educación Básica Alternativa- CEBA</option>
                                        <option value=""> Centros de Educación Básica Especial- CEBE</option>
                                        <option value="">Centros de Educación Técnico Productivo- CETPRO</option>
                                        <option value="">Otro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Tipo de seguro de salud</label>
                                    <select name="CarTipoSeguro" v-model="CarTipoSeguro" class="form-control">
                                        <option value="">ESSALUD</option>
                                        <option value="">FFAA_PNP</option>
                                        <option value="">Seguro Privado</option>
                                        <option value="">Seguro Integral de Salud(SIS)</option>
                                        <option value="">Otro</option>
                                        <option value="">No tiene</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="text-input" class=" form-control-label">Clasificación Socioeconómica</label>
                                    <select name="CarCSocioeconomica" v-model="CarCSocioeconomica" class="form-control">
                                        <option value="">sin clasificación socioeconomica</option>
                                        <option value="">pobre extremo</option>
                                        <option value="">pobre no extremo</option>
                                        <option value="">no pobre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Cuenta con familiares ubicados?</label>
                                    <select name="CarFamiliaresUbicados" v-model="CarFamiliaresUbicados" class="form-control">
                                        <option value="">Si</option>
                                        <option value="">No</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Tipo de parentesco</label>
                                    <select name="CarTipoParentesco" v-model="CarTipoParentesco" class="form-control">
                                        <option value="">Padre</option>
                                        <option value="">Madre</option>
                                        <option value="">Hermano/a</option>
                                        <option value="">Tío/a</option>
                                        <option value="">primos/as</option>
                                        <option value=""> Abuelos/as</option>
                                        <option value="">Otros/as</option>
                                    </select>

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