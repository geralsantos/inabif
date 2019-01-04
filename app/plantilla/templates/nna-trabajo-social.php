<template id="nna-trabajo-social">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Trabajo Social</strong>
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
                                <div class=" "><label for="text-input" class=" form-control-label">Fase de Intervención</label>
                                <select name="Fase_Intervencion" v-model="Fase_Intervencion" class="form-control">
                                <option value="Primera Fase">Primera Fase</option>
                                <option value="Segunda Fase">Segunda Fase</option>
                                <option value="Tercera Fase">Tercera Fase</option>
                                <option value="Cuarta Fase">Cuarta Fase</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Estado del Usuario</label>
                                <select name="Estado_Usuario" v-model="Estado_Usuario" class="form-control">
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Plan de Intervención Social</label>
                                <select name="Plan_Intervencion" v-model="Plan_Intervencion" class="form-control">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select>  </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Situación Legal del NNA</label>
                                    <select name="SituacionL_NNA" v-model="SituacionL_NNA" class="form-control">
                                    <option value="En investigación tutelar">En investigación tutelar</option>
                                    <option value="Sin investigación tutelar">Sin investigación tutelar</option>
                                    <option value="Sentencia de estado de abandono">Sentencia de estado de abandono</option>
                                    <option value="Sentencia infundado estado de abandono">Sentencia infundado estado de abandono</option>
                                    <option value="Archivado por mayoría de edad">Archivado por mayoría de edad</option>

                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">El NNA cuenta con familia ubicada?</label>
                                    <select name="Familia_NNA" v-model="Familia_NNA" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">El NNA cuenta con soporte familiar?</label>
                                    <select name="SoporteF_NNA" v-model="SoporteF_NNA" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Persona que brinda soporte familiar</label>
                                    <select name="Des_SoporteF" v-model="Des_SoporteF" class="form-control">
                                        <option value="Abuelo/a">Abuelo/a</option>
                                        <option value="Hermana/o">Hermana/o</option>
                                        <option value="Madre/Padre">Madre/Padre</option>
                                        <option value="Primo/a">Primo/a</option>
                                        <option value="Tío/a">Tío/a</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Tipo de Familia</label>
                                    <select name="Tipo_Familia" v-model="Tipo_Familia" class="form-control">
                                    <option value="Nuclear">Nuclear</option>
                                    <option value="Extensa">Extensa</option>
                                    <option value="MonoNuclear">MonoNuclear</option>
                                    <option value="Homoparental">Homoparental</option>
                                    <option value="Ensamblada">Ensamblada</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Problematica Familiar</label>
                                    <select name="Problematica_Fami" v-model="Problematica_Fami" class="form-control">
                                    <option value="Violencia">Violencia</option>
                                    <option value="Prostitución">Prostitución</option>
                                    <option value="Delincuencia">Delincuencia</option>
                                    <option value="Privado de su libertad">Privado de su libertad</option>
                                    <option value="Salud mental">Salud mental</option>
                                    <option value="Multi problemática">Multi problemática</option>
                                    <option value="Disgregada">Disgregada</option>
                                    <option value="Otros">Otros</option>
                                    </select>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label"> Familia Cuenta con Clasificación SISFOH</label>
                                    <select name="Familia_SISFOH" v-model="Familia_SISFOH" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Resultado de la Clasificación</label>
                                    <select name="Resultado_Clasificacion" v-model="Resultado_Clasificacion" class="form-control">
                                    <option value="Pobre extremo">Pobre extremo</option>
                                    <option value="Pobre">Pobre</option>
                                    <option value="No pobre">No pobre</option>
                                    </select>

                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">N° visitas familiar recibe cada mes</label>
                                <input type="number" min="0"  v-model="Nro_VisitasNNA" name="Nro_VisitasNNA" value='5' placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">N° participaciones en escuela de padres </label>
                                <input type="number" min="0"  v-model="Participacion_EscuelaP" name="Participacion_EscuelaP" value='5' placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">N° consejerias y orientaciones a la familia</label>
                                <input type="number" min="0"  v-model="Consegeria_Familiar" name="Consegeria_Familiar" value='5' placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Familia usa redes de soporte familiar?</label>
                                    <select name="Soporte_Social" v-model="Soporte_Social" class="form-control">
                                    <option value="Si">Si</option>
                                <option value="No">No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº de consejerias y orientaciones al residente </label>
                                <input type="number" min="0"  v-model="Consejeria_residente" name="Consejeria_residente" value='5' placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Charlas Preventivo  - Promocionales </label>
                                <input type="number" min="0"  v-model="Charlas" name="Charlas" value='5' placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Nº Visitas Domiciliarias</label>
                                <input type="number" min="0"  v-model="Visitas_Domicilarias" name="Visitas_Domicilarias" value='5' placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Plan de Reinserción familiar</label>
                                    <select name="Reinsercion_Familiar" v-model="Reinsercion_Familiar" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Residente cuenta con DNI?</label>
                                    <select name="DNI" v-model="DNI" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Residente cuenta con AUS/SIS?</label>
                                    <select name="AUS_SIS" v-model="AUS_SIS" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="text-input" class=" form-control-label">Residente cuenta con carnet del CONADIS?</label>
                                    <select name="CONADIS" v-model="CONADIS" class="form-control">
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