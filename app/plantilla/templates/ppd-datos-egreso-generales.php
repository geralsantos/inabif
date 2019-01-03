<template id="ppd-datos-egreso-generales">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Egreso - Datos Generales</strong>
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
                            <div class="form-group col-md-7">
                                <label for="text-input" class=" form-control-label">Nombre Residente</label>
                                <div class="autocomplete">
                                    <input type="text"  v-model="nombre_residente" class="form-control" @keyup="buscar_residente()" placeholder="Nombre, Apellido o DNI"/>
                                    <ul  id="autocomplete-results" class="autocomplete-results" v-if="bloque_busqueda">
                                        <li class="loading" v-if="isLoading">
                                            Loading results...
                                        </li>
                                        <li  @click="actualizar(coincidencia)" class="autocomplete-result" v-for="coincidencia in coincidencias">
                                            {{coincidencia.NOMBRE}} {{coincidencia.APELLIDO_P}} - {{coincidencia.DOCUMENTO}}
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
                                <label for="text-input" class=" form-control-label">Fecha Egreso</label>
                                <input type="date" v-model="CarFEgreso" name="CarFEgreso" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Motivo del egreso</label>
                                <select name="CarMotivoEgreso" v-model="CarMotivoEgreso" class="form-control">
                                        <option value="Traslado a otro CAR">Traslado a otro CAR</option>
                                        <option value="Fallecimiento">Fallecimiento</option>
                                        <option value="Reinsercion Familiar">Reinserción Familiar</option>
                                        <option value="Vida Independiente">Vida Independiente</option>
                                        <option value="Otro">Otro</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Traslado</label>
                                <select name="CarTrasladoCar" v-model="CarTrasladoCar" class="form-control">
                                    <option value="ESSALUD">ESSALUD</option>
                                    <option value="MINSA">MINSA</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Reinserción familiar</label>
                                <select name="CarReinsercionFamiliar" v-model="CarReinsercionFamiliar" class="form-control">
                                    <option value="Familiar Directo">Familiar directo</option>
                                    <option value="Familiar Indirecto">Familiar indirecto</option>
                                    <option value="Voluntario">Voluntario</option>

                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                    <div class=" "><label for="text-input" class=" form-control-label">Grado de Parentesco</label>
                                    <input type="text" v-model="GradoParentesco" value="" name="GradoParentesco" placeholder="" class="form-control">
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Retiro Voluntario</label>
                                <select name="CarRetiroVoluntario" v-model="CarRetiroVoluntario" class="form-control">
                                    <option value="Independencia">Independencia</option>
                                    <option value="Maltrato">Maltrato</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                             
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Fallecimiento</label>
                                <select name="CarFallecimiento" v-model="CarFallecimiento" class="form-control">
                                    <option value="Muerte Natural">Muerte Natural</option>
                                    <option value="Muerte Violenta">Muerte Violenta</option>
                                    <option value="Muerte Subita">Muerte Súbita</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">CONSTANCIA DE NACIMIENTO</label>
                                <select name="CarConstanciaNacimiento" v-model="CarConstanciaNacimiento" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Carnet del CONADIS</label>
                                <select name="CarCarnetConadis" v-model="CarCarnetConadis" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label"> DNI</label>
                                <select name="CarTieneDni" v-model="CarTieneDni" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Restitución Familiar</label>
                                <select name="CarRestitucionF" v-model="CarRestitucionF" class="form-control">
                                    <option value="Participación Familiar">Participación Familiar</option>
                                    <option value="Reinserción Familiar">Reinserción Familiar</option>
                                    <option value="Ninguno">Ninguno</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Cumplimiento de restitución de derechos al egreso</label>
                                <select name="CarCumResDerEgreso" v-model="CarCumResDerEgreso" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">AUS</label>
                                <select name="CarAus" v-model="CarAus" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
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
                                                <td>{{residente.DOCUMENTO}}</td>
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