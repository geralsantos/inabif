<template id="pam-actividades-sociales">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Actividades Sociales</strong>
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
                                <select name="anio" disabled="disabled" id="anio"  v-model="anio" class="form-control">
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
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class="form-control-label">Atención Social  </label>
                                    <select name="Atencion_Social" v-model="Atencion_Social" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class="form-control-label">Visitas de Familiares</label>
                                <select name="Visita_Familiares" v-model="Visita_Familiares" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">N°  de visitas al mes</label>
                                <select name="Nro_Visitas" v-model="Nro_Visitas" class="form-control">
                                <option v-for="i in (1 to 30)" :value="i">{{i}}</option>
                                    </select> </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Visitas de Amigos</label>
                                <select name="Visitas_Amigos" v-model="Visitas_Amigos" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">N°  de visitas al mes</label>
                                <select name="Nro_Visitas_Amigos" v-model="Nro_Visitas_Amigos" class="form-control">
                             
                                    </select> </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Descriptivo de la persona que los visita</label>
                                <input type="text" v-model="Descriptivo_Persona_Visita" name="Descriptivo_Persona_Visita" placeholder="" class="form-control"> 
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Aseguramiento de la Universidad</label>
                                <select name="Aseguramiento_Universal_Salud" v-model="Aseguramiento_Universal_Salud" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Fecha de Emisión de la Obtención del Seguro</label>
                                <input type="date" v-model="Fecha_Emision_Obtencion_Seguro" name="Fecha_Emision_Obtencion_Seguro" placeholder="" class="form-control"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class=""><label for="text-input" class="form-control-label">Documento Nacional de Identidad - DNI</label>
                                <select name="DNI" v-model="DNI" class="form-control">
                                <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Fecha de Emisión DNI</label>
                                <input type="date" v-model="Fecha_Emision_DNI" name="Fecha_Emision_DNI" placeholder="" class="form-control"> 
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