<template id="pam-actividades-sociorecreativas">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Salud Mental</strong>
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
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Terapia Fisica y de Rehabilitación </label>
                                    <select name="Terapia_Fisica_Rehabilitacion" v-model="Terapia_Fisica_Rehabilitacion" class="form-control">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                           
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Arte (Música, Danza y Teatro)</label>
                                <select name="Arte" v-model="Arte" class="form-control">
                                    <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select> </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">N° de Veces que Participa Arte en el Mes</label>
                                <select name="Nro_Arte" v-model="Nro_Arte" class="form-control">
                                <option v-for="i in (1 to 30)" :value="i">{{i}}</option>
                                    </select> </div>
                            </div>
                            
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Dibujo y Pintura</label>
                                <select name="Dibujo_Pintura" v-model="Dibujo_Pintura" class="form-control">
                                <option value="Si">Si</option>
                                        <option value="No">No</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">N° de Veces que Participa </label>
                                    <select name="Nro_Arte_Dibujo_Pintura" v-model="Nro_Arte_Dibujo_Pintura" class="form-control">
                                    <option v-for="i in (1 to 30)" :value="i">{{i}}</option>
                                    </select>
                            </div>
                           
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Manualidades</label>
                                <select name="Manualidades" v-model="Manualidades" class="form-control">
                                <option value="Si">Si</option>
                                        <option value="No">No</option>
                                </select> 
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">N° de Veces que Participa</label>
                                    <select name="Nro_Arte_Manualidades" v-model="Nro_Arte_Manualidades" class="form-control">
                                    <option v-for="i in (1 to 30)" :value="i">{{i}}</option>
                                    </select>
                            </div>
                            
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                                <div class=" "><label for="text-input" class=" form-control-label">Otros</label>
                                <select name="Otros" v-model="Otros" class="form-control">
                                <option value="Si">Si</option>
                                        <option value="No">No</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">N° de Veces que Participa</label>
                                    <select name="Nro_Arte_Otros" v-model="Nro_Arte_Otros" class="form-control">
                                    <option v-for="i in (1 to 30)" :value="i">{{i}}</option>
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