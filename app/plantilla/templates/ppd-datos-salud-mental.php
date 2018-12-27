<template id="ppd-datos-salud-mental">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de Salud Mental</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form class="form-horizontal"  v-on:submit.prevent="guardar">
                    <div class="row">
                            <div class="form-group col-md-7">
                                <label for="text-input" class=" form-control-label">Nombre Residente</label>
                                <div class="autocomplete">
                                    <input type="text"  v-model="nombre_residente" class="form-control" @keyup="buscar_residente()"/>
                                    <ul  id="autocomplete-results" class="autocomplete-results" v-if="bloque_busqueda">
                                        <li class="loading" v-if="isLoading">
                                            Loading results...
                                        </li>
                                        <li  @click="actualizar(coincidencia.id)" class="autocomplete-result" v-for="coincidencia in coincidencias">
                                            {{coincidencia.nombre}}
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="text-input" class=" form-control-label">Año</label>
                                <select name="select" id="anio"  v-model="anio" class="form-control">
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                </select>

                            </div>
                            <div class="form-group col-md-3">
                                <div class=""><label for="text-input" class=" form-control-label">Mes</label>
                                <select id="mes" v-model="mes" class="form-control" >
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
                                <label for="text-input" class=" form-control-label">Trastornos neurologicos?</label>
                                <select name="CarTrastornosNeurologico" v-model="CarTrastornosNeurologico" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    <option value="No sabe">No Sabe</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">ESPECIFICAR TRASTORNO NEUROLÓGICO PRINCIPAL</label>
                                <select name="CarNeurologicoPrincipal" v-model="CarNeurologicoPrincipal" class="form-control">
                                    <option value="CIE 10">CIE 10</option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Tipo de trastorno de conducta </label>
                                <select name="CarTrastornoConduta" v-model="CarTrastornoConduta" class="form-control">
                                    <option value="Agresivo">Agresivo</option>
                                    <option value="Se autolesiona">Se autolesiona</option>
                                    <option value="Agitación motora">Agitación motora</option>
                                    <option value="Disocial">Disocial</option>
                                    <option value="Negativismo">Negativismo</option>
                                    <option value="Desafiante">Desafiante</option>
                                    <option value="No se sabe">No se sabe</option>
                                    <option value="No presenta transtorno">No presenta transtorno</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Presenta dificultades para el habla?</label>
                                <select name="CarDificultadHabla" v-model="CarDificultadHabla" class="form-control">
                                    <option value="No habla">No habla</option>
                                    <option value="Pide las necesidades básicas">Pide las necesidades básicas</option>
                                    <option value="Pide mas que las necesidades basicas">Pide mas que las necesidades basicas</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Si no habla, que método utiliza para comunicarse?</label>
                                <select name="CarMetodoHabla" v-model="CarMetodoHabla" class="form-control">
                                    <option value="Gestos">Gestos</option>
                                    <option value="Sonidos">Sonidos</option>
                                    <option value="Escritura">Escritura</option>
                                    <option value="No se hace entender">No se hace entender</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Presenta dificultades para comprender lo que se le dice?</label>
                                <select name="CarComprension" v-model="CarComprension" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Tipo de dificultad que presenta</label>
                                <select name="CarDificultadPresenta" v-model="CarDificultadPresenta" class="form-control">
                                    <option value="">Disfacia de tipo receptivo</option>
                                    <option value=""> Afasia</option>
                                    <option value="">Otro</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Realiza actividades de la vida diaria?</label>
                                <select name="CarRealizaActividades" v-model="CarRealizaActividades" class="form-control">
                                    <option value="Come solo">Come solo </option>
                                    <option value="Se viste solo">Se viste solo</option>
                                    <option value="Acude al baño solo">Acude al baño solo</option>
                                    <option value="Se baña solo">Se baña solo</option>
                                    <option value="Todas las anteriores">Todas las anteriores</option>
                                    <option value="Ninguno">Ninguno</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Especificar (como, en qué forma, otros).</label>
                                <input type="text" v-model="CarEspeficicarActividades" name="CarEspeficicarActividades" placeholder="" class="form-control">
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