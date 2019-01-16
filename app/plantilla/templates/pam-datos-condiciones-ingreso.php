<template id="pam-datos-condiciones-ingreso">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de Condiciones de Ingreso del Residente (Derechos)</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <div class="row form-group">
                        <div class="col-12 col-md-1">
                            <label for="text-input" class=" form-control-label"></label>
                            <button @click="mostrar_lista_residentes()" class="btn btn-primary"><i class="fa fa fa-users"></i> Lista de Residentes</button>
                        </div>
                    </div>
                    <form class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Buscar Residente <i class="fa fa-search" aria-hidden="true"></i></label>
                                <div class="autocomplete">
                                    <input type="text"  v-model="nombre_residente" class="form-control campo_busqueda_residente" @keyup="buscar_residente()" placeholder="Nombre, Apellido o DNI"/>
                                    <ul  id="autocomplete-results" class="autocomplete-results" v-if="bloque_busqueda">
                                        <li class="loading" v-if="isLoading">
                                            Loading results...
                                        </li>
                                        <li  @click="actualizar(coincidencia)" class="autocomplete-result" v-for="coincidencia in coincidencias">
                                            {{coincidencia.ID}} - {{coincidencia.NOMBRE}} {{coincidencia.APELLIDO_P}} - {{coincidencia.DNI_RESIDENTE}} - {{coincidencia.DOCUMENTO}}
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
                            <div class="form-group col-md-2">
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
                            <div class="form-group col-md-2">
                                <label for="text-input" class=" form-control-label">Código</label>
                                <input type="text" v-model="id" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
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
                                <option value="DNI">DNI</option>
                                <option value="Carnet de extranjería">Carnet de extranjería</option>
                                <option value="Pasaporte">Pasaporte</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Número de Documento de Identidad</label>
                                <input type="text" v-model="numero_documento_ingreso" maxlength="8" min="0" name="numero_documento_ingreso" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class=" "><label for="text-input" class=" form-control-label">Sabe Leer y Escribir</label>
                                <select name="leer_escribir" v-model="leer_escribir" class="form-control">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Nivel Educativo</label>
                                <select name="nivel_educativo" v-model="nivel_educativo" class="form-control">
                                    <option v-for="nivel in niveles_educativos" :value="nivel.ID">{{nivel.NOMBRE}}</option>
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
                                <option value="ONP">ONP</option>
                                <option value="AFP">AFP</option>
                                <option value="Otros">Otros</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Clasificación Socioeconómica (SISFOH)</label>
                                <select name="SISFOH" v-model="SISFOH" class="form-control">
                                    <option v-for="socioeconomica in clasif_socioeconomica" :value="socioeconomica.ID">{{socioeconomica.NOMBRE}}</option>
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
                                    <option value="Ninguno">Ninguno</option>
                                    <option value="Padre/Madre">Padre/Madre</option>
                                    <option value="Hermano(a)">Hermano(a)</option>
                                    <option value="Primos(a)">Primos(a)</option>
                                    <option value="Hijo(a)">Hijo(a)</option>
                                    <option value="Nieto">Nieto</option>
                                <option value="Otros(as)">Otros(as)</option>
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
        <div v-if="modal_lista">
             <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">

                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Lista Residentes</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" @click="modal_lista = false">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark text-center">
                                            <tr>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Número de Documento</th>
                                                <th scope="col">Opción</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr v-for="residente in pacientes">
                                                <td>{{residente.NOMBRE}} {{residente.APELLIDO}}</td>
                                                <td>{{residente.DNI_RESIDENTE}}</td>
                                                <td><button class="btn btn-primary" @click="elegir_residente(residente)">Seleccionar</button></td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="modal_lista = false">Cerrar</button>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </transition>
        </div>
    </div> <!-- .content -->
</template>