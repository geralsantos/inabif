<template id="nna-seguimiento-educacion">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Seguimiento - Educación</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <div class="row form-group">
                        <div class="col-12 col-md-1">
                            <label for="text-input" class=" form-control-label"></label>
                            <button @click="mostrar_lista_residentes()" class="btn btn-primary"><i class="fa fa fa-users"></i> Lista de Residentes</button>
                        </div>
                    </div>
                    <form  class="form-horizontal" v-on:submit.prevent="guardar">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Buscar Residente <i class="fa fa-search" aria-hidden="true"></i></label>
                                <div class="autocomplete">
                                    <input type="text"  v-model="nombre_residente" class="form-control campo_busqueda_residente" @keyup="buscar_residente()" placeholder="Código, Nombre, Apellido o DNI"/>
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
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Plan de Intervención Educativo?</label>
                                <select name="Plan_Intervencion" v-model="Plan_Intervencion" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Matriculado en el sistema educativo</label>
                                <select name="Sistema_Educativo" v-model="Sistema_Educativo" class="form-control">
                                    <option value="Regular">Regular</option>
                                    <option value="CEBA">CEBA</option>
                                    <option value="CEBE">CEBE</option>
                                    <option value="CEPTRO">CEPTRO</option>
                                </select> </div>

                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Nivel que cursa?</label>
                                <select name="NEducativo" v-model="NEducativo" class="form-control">
                                <option value="Inicial">Inicial</option>
                                <option value="Primaria">Primaria</option>
                                <option value="Secundaria">Secundaria</option>
                                <option value="Superior Universitario">Superior Universitario</option>
                                <option value="Superior Tecnológica">Superior Tecnológica</option>
                                <option value="Superior Artística">Superior Artística</option>
                                <option value="Superior Pedagógica">Superior Pedagógica</option>
                                </select>  </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Grado </label>
                                    <select name="Grado" v-model="Grado" class="form-control">
                                        <option value="Primaria: 1 a 6 to grado">Primaria: 1 a 6 to grado</option>
                                        <option value="Secundaria: 1 a 5to grado">Secundaria: 1 a 5to grado</option>
                                    </select>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Acude en el mes al centro de estudios?</label>
                                    <select name="Asitencia" v-model="Asitencia" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de días de asistencia</label>
                                <input type="number"  min="0" v-model="Nro_Asistencia" name="Nro_Asistencia" value='5' placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de sesiones de reforzamiento escolar</label>
                                <input type="number"  min="0" v-model="Nro_Reforzamientos" name="Nro_Reforzamientos" value='5' placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Número de Aprestamiento Escolar</label>
                                <input type="number"  min="0" v-model="Nro_Aprestamiento" name="Nro_Aprestamiento" value='5' placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de consejerías y orientaciones - Área educativa</label>
                                <input type="number"  min="0" v-model="Nro_Consejera" name="Nro_Consejera" value='5' placeholder="" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Se encuentran participando de entrenamiento profesional/técnico</label>
                                    <select name="Estado_Participacion" v-model="Estado_Participacion" class="form-control">
                                    <option value="Inserciones Laborales">Inserciones Laborales </option>
                                    <option value="Prácticas profesionales o técnicas">Prácticas profesionales o técnicas</option>
                                    <option value="Programa de entrenamiento no remunerado">Programa de entrenamiento no remunerado</option>
                                    </select>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Especificar la actividad / oficio</label>
                                    <textarea name="ActividadOficio" class="form-control" v-model="ActividadOficio" col="30" ros="2"></textarea>
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
                                                <td>{{residente.NOMBRE}} {{residente.APELLIDO_P}} {{residente.APELLIDO_M}}</td>
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