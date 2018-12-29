<template id="pam-datos-generales-egreso">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Egreso - Datos Generales</strong>
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
                                <label for="text-input" class=" form-control-label">Fecha_egreso</label>
                                <input type="date" v-model="Fecha_Egreso" name="Fecha_Egreso" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Motivo del egreso</label>
                                <select name="MotivoEgreso" v-model="MotivoEgreso" class="form-control">
                                    <option v-for="motivo in motivos" :value="motivo.ID">{{motivo.NOMBRE}}</option>
                                    
                                </select>
                            </div>

                            <div class="form-group col-md-4">
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
                                    <option value="Hiijo(a)">Hiijo(a)</option>
                                    <option value="Hermano(a)">Hermano(a)</option>
                                    <option value="Nieto (a)">Nieto (a)</option>
                                    <option value="Otros(as)">Otros(as)</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Traslado a una entidad de salud  </label>
                                <select name="Traslado_Entidad_Salud" v-model="Traslado_Entidad_Salud" class="form-control">
                                    <option value="ESSALUD">ESSALUD</option>
                                    <option value="MINSA">MINSA</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Traslado a otra Entidad </label>
                                <select name="Traslado_Otra_Entidad" v-model="Traslado_Otra_Entidad" class="form-control">
                                    <option value="">Otro CAR del INABIF</option>
                                    <option value="">Otro CAR público </option>
                                    <option value="">Otro CAR privado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Fallecimiento</label>
                                <select name="Fallecimiento" v-model="Fallecimiento" class="form-control">
                                    <option value="Muerte natural">Muerte natural</option>
                                    <option value="Muerte violenta">Muerte violenta</option>
                                    <option value="Muerte súbita">Muerte súbita</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Cumplimiento de restitución de derechos Aseguramiento a Salud</label>
                                <select name="RestitucionAseguramientoSaludo" v-model="RestitucionAseguramientoSaludo" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Cumplimiento de restitución de derechos Documento Nacional de Identidad - DNI</label>
                                <select name="Restitucion_Derechos_DNI" v-model="Restitucion_Derechos_DNI" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
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
    </div> <!-- .content -->
<template>