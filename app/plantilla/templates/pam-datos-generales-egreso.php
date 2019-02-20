<template id="pam-datos-generales-egreso">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos Generales del Egreso</strong>
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
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Fecha_egreso</label>
                                <input type="date" v-model="Fecha_Egreso" name="Fecha_Egreso" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Motivo del egreso</label>
                                <select name="MotivoEgreso" v-model="MotivoEgreso" class="form-control">
                                <option value="">Ninguno</option>
                                    <option value="Retiro voluntario">Retiro voluntario</option>
                                    <option value="Reinserción en entorno familiar">Reinserción en entorno familiar</option>
                                    <option value="Traslado a una entidad de salud">Traslado a una entidad de salud</option>
                                    <option value="Traslado a otra Entidad">Traslado a otra Entidad</option>
                                    <option value="Fallecimiento">Fallecimiento</option>

                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Retiro voluntario</label>
                                <select name="Retiro_Voluntario" v-model="Retiro_Voluntario" class="form-control">
                                    <option value="Independencia">Independencia</option>
                                    <option value="Maltrato">Maltrato</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Reinserción familiar</label>
                                    <select name="Reinsercion_Familiar" v-model="Reinsercion_Familiar" class="form-control">
                                        <option value="Hijo(a)">Hijo(a)</option>
                                        <option value="Hermano(a)">Hermano(a)</option>
                                        <option value="Primos(a)">Primos(a)</option>
                                        <option value="Nieto(a)">Nieto(a)</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Traslado a una entidad de salud  </label>
                                    <select name="Traslado_Entidad_Salud" v-model="Traslado_Entidad_Salud" class="form-control">
                                        <option value="">Ninguno</option>
                                        <option value="ESSALUD">ESSALUD</option>
                                        <option value="MINSA">MINSA</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="text-input" class=" form-control-label">Traslado a otra Entidad </label>
                                    <select name="Traslado_Otra_Entidad" v-model="Traslado_Otra_Entidad" class="form-control">
                                        <option value="">Ninguno</option>
                                        <option value="Otro CAR del INABIF">Otro CAR del INABIF</option>
                                        <option value="Otro CAR público">Otro CAR público </option>
                                        <option value="Otro CAR privado">Otro CAR privado</option>
                                    </select>
                                </div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Fallecimiento</label>
                                <select name="Fallecimiento" v-model="Fallecimiento" class="form-control">
                                    <option value="">Ninguno</option>
                                    <option value="Muerte natural">Muerte natural</option>
                                    <option value="Muerte violenta">Muerte violenta</option>
                                    <option value="Muerte súbita">Muerte súbita</option>
                                </select>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="text-input" class=" form-control-label">Cumplimiento de restitución de derechos Aseguramiento a Salud</label>
                                <select name="RestitucionAseguramientoSaludo" v-model="RestitucionAseguramientoSaludo" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Cumplimiento de restitución de derechos Documento Nacional de Identidad - DNI</label>
                                <select name="Restitucion_Derechos_DNI" v-model="Restitucion_Derechos_DNI" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Cumplimiento de restitución de derechos Reinserción Familiar</label>
                                <select name="RestitucionReinsercionFamiliar" v-model="RestitucionReinsercionFamiliar" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
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