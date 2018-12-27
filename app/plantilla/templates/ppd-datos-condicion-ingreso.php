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
                                <div class="form-group col-md-6">
                                    <label for="text-input" class=" form-control-label">Posee algún tipo de Pensión</label>
                                    <select name="CarPoseePension" id="CarPoseePension" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class=" "><label for="text-input" class=" form-control-label">Tipo de pensión que percibe</label>
                                    <select name="CarTipoPension" id="CarTipoPension" class="form-control">
                                        <option value="ONP">ONP</option>
                                        <option value="AFP">AFP</option>
                                        <option value="Otros">Otros</option>
                                        <option value="No se sabe">No se sabe</option>
                                        <option value="Ninguna">Ninguna</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Usuarios sabe leer y escribir?</label>
                                    <select name="CarULeeEscribe" v-model="CarULeeEscribe" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Nivel Educativo</label>
                                    <select name="CarNivelEducativo" v-model="CarNivelEducativo" class="form-control">
                                        <option value="Sin nivel">Sin nivel</option>
                                        <option value="Inicial">Inicial</option>
                                        <option value="Primaria incompleta">Primaria incompleta</option>
                                        <option value="Primaria completa">Primaria completa</option>
                                        <option value="Secundaria incompleta">Secundaria incompleta</option>
                                        <option value="Secundaria completa">Secundaria completa</option>
                                        <option value="Se desconoce">Se desconoce </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Intitución Educativa de Procedencia</label>
                                    <select name="CarInstitucionEducativa" v-model="CarInstitucionEducativa" class="form-control">
                                        <option value="Centro de Educación Básica Regular">Centro de Educación Básica Regular</option>
                                        <option value="Centro de Educación Basica Regular Inclusiva">Centro de Educación Basica Regular Inclusiva</option>
                                        <option value="Centros de Educación Básica Alternativa- CEBA">Centros de Educación Básica Alternativa- CEBA</option>
                                        <option value="Centros de Educación Básica Especial- CEBE">Centros de Educación Básica Especial- CEBE</option>
                                        <option value="Centros de Educación Técnico Productivo- CETPRO">Centros de Educación Técnico Productivo- CETPRO</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Tipo de seguro de salud</label>
                                    <select name="CarTipoSeguro" v-model="CarTipoSeguro" class="form-control">
                                        <option value="ESSALUD">ESSALUD</option>
                                        <option value="FFAA_PNP">FFAA_PNP</option>
                                        <option value="Seguro Privado">Seguro Privado</option>
                                        <option value="Seguro Integral de Salud(SIS)">Seguro Integral de Salud(SIS)</option>
                                        <option value="Otro">Otro</option>
                                        <option value="No tiene">No tiene</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="text-input" class=" form-control-label">Clasificación Socioeconómica</label>
                                    <select name="CarCSocioeconomica" v-model="CarCSocioeconomica" class="form-control">
                                        <option value="Sin clasificación socioeconomica">Sin clasificación socioeconomica</option>
                                        <option value="Pobre extremo">Pobre extremo</option>
                                        <option value="Pobre no extremo">Pobre no extremo</option>
                                        <option value="No pobre">No pobre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Cuenta con familiares ubicados?</label>
                                    <select name="CarFamiliaresUbicados" v-model="CarFamiliaresUbicados" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Tipo de parentesco</label>
                                    <select name="CarTipoParentesco" v-model="CarTipoParentesco" class="form-control">
                                        <option value="Padre">Padre</option>
                                        <option value="Madre">Madre</option>
                                        <option value="Hermano/a">Hermano/a</option>
                                        <option value="Tio/a">Tío/a</option>
                                        <option value="Primos/as">primos/as</option>
                                        <option value="Abuelos/as">Abuelos/as</option>
                                        <option value="Otros/as">Otro</option>
                                    </select>

                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Problemática familiar</label>
                                    <select name="CarProblematicaFam" id="CarProblematicaFam" class="form-control">
                                        <option value="Ausentismo de madre por trabajo">Ausentismo de madre por trabajo</option>
                                        <option value="Conductual/experiencia en calle">Conductual/experiencia en calle</option>
                                        <option value="Violencia sexual">Violencia sexual</option>
                                        <option value="Desintegrada e incompleta">Desintegrada e incompleta</option>
                                        <option value="Desinterés rol parental/ disfuncional / Disgregada">Desinterés rol parental/ disfuncional / Disgregada</option>
                                        <option value="Drogadicción">Drogadicción</option>
                                        <option value="Escasa preocupación">Escasa preocupación</option>
                                        <option value="Inadecuada forma de crianza">Inadecuada forma de crianza</option>
                                        <option value="Maltrato físico">Maltrato físico</option>
                                        <option value="Experiencia en calle Multi problemática">Experiencia en calle Multi problemática</option>
                                        <option value="Negligencia">Negligencia</option>
                                        <option value="Orfandad">Orfandad</option>
                                        <option value="Privado de su libertad">Privado de su libertad</option>
                                        <option value="Prostitución">Prostitución</option>
                                        <option value="Salud mental">Salud mental </option>
                                        <option value="Otros">Otros</option>
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