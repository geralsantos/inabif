<template id="nna-datos-admision-residente">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de Admisión del Residente</strong>
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
                                <div class=" "><label for="text-input" class=" form-control-label">Movimiento Poblacional</label>
                                <select name="Movimiento_Poblacional" v-model="Movimiento_Poblacional" class="form-control">
                                <option value="Nuevo">Nuevo</option>
                                <option value="Continuador">Continuador</option>
                                <option value="Reingreso">Reingreso</option>
                                <option value="Traslado">Traslado</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Fecha de Ingreso</label>
                                <input type="date" v-model="Fecha_Ingreso" name="Fecha_Ingreso" placeholder="" class="form-control"> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Fecha de Reingreso</label>
                                <input type="date" v-model="Fecha_Registro" name="Fecha_Registro" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Institución que lo deriva</label>
                                <select name="Institucion_Derivacion" v-model="Institucion_Derivacion" class="form-control">
                                <option v-for="institucion in instituciones" :value="institucion.ID">{{institucion.NOMBRE}}</option>
                                
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Motivo de ingreso (acorde al expediente)</label>
                                <select name="Motivo_Ingreso" v-model="Motivo_Ingreso" class="form-control">
                                    <option v-for="motivo in motivos" :value="motivo.ID">{{motivo.NOMBRE}}</option>
                                </select>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Principal Perfil de Ingreso (primario)</label>
                                <select name="Perfil_Ingreso_P" v-model="Perfil_Ingreso_P" class="form-control">
                                    <option v-for="perfil in perfiles" :value="perfil.ID">{{perfil.NOMBRE}}</option>
                                </select>

                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Principal Perfil de Ingreso (secundario)</label>
                                <select name="Perfil_Ingreso_S" v-model="Perfil_Ingreso_S" class="form-control">
                                    <option v-for="perfil in perfiles" :value="perfil.ID">{{perfil.NOMBRE}}</option>
                                </select>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Tipo de Documento de ingreso al Car</label>
                                <select name="Tipo_Doc" v-model="Tipo_Doc" class="form-control">
                                    <option value="Oficio">Oficio</option>
                                    <option value="Acta">Acta</option>
                                    <option value="Resolución">Resolución</option>
                                    <option value="Otros">Otros</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Número del Documento</label>
                                <input type="text" v-model="Numero_Doc" name="Numero_Doc" placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Situación Legal</label>
                                <select name="Situacion_Legal" v-model="Situacion_Legal" class="form-control">
                                    <option value="En investigación tutelar">En investigación tutelar</option>
                                    <option value="Sin investigación tutelar">Sin investigación tutelar</option>
                                    <option value="Sentencia de estado de abandono">Sentencia de estado de abandono</option>
                                    <option value="Sentencia infundado estado de abandono">Sentencia infundado estado de abandono</option>
                                    <option value="Archivado por mayoría de edad">Archivado por mayoría de edad</option>
                                </select>
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