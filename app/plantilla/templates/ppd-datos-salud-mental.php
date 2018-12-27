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