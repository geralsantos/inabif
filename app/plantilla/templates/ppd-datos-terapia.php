<template id="ppd-datos-terapia">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de Terapia</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <form class="form-horizontal" v-on:submit.prevent="guardar">
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
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en terapia para la reeducación motriz</label>
                                <input type="number" v-model="CarNumReeducaion" name="CarNumReeducaion" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">N° de veces que Participa en terapia para la Psicomotricidad</label>
                                <input type="number" v-model="CarParticipaPsicomotricidad" name="CarParticipaPsicomotricidad" placeholder="" class="form-control">
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en terapia para la Fisioterapia respiratoria</label>
                                <input type="number" v-model="CarFisioterapia" name="CarFisioterapia" placeholder="" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en terapia para la Deportes Adaptados</label>
                                <input type="number" v-model="CarDeportesAdaptados" name="CarDeportesAdaptados" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa de terapia para la comunicación</label>
                                <input type="number" v-model="CarComunicacion" name="CarComunicacion" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Partiicipa de terapia para la reeducación orofacial</label>
                                <input type="number" v-model="CarReeducacionOrofacial" name="CarReeducacionOrofacial" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en terapia del Lenguaje</label>
                                <input type="number" v-model="CarTerapiaLenguaje" name="CarTerapiaLenguaje" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en terapia para el Desarrollo de lenguaje alternativo</label>
                                <input type="number" v-model="CarDesarrolloLenguaje" name="CarDesarrolloLenguaje" placeholder="" class="form-control">

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Tipo de lenguaje alternativo</label>
                                <select name="CarTipoLenguajeAlternativo" v-model="CarTipoLenguajeAlternativo" class="form-control">
                                    <option value="Lenguaje de señas">Lenguaje de señas</option>
                                    <option value="Gestos">Gestos</option>
                                    <option value="Lenguaje corporal">Lenguaje corporal</option>
                                    <option value="Tableros de comunicación">Tableros de comunicación</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa de terapia para el desarrollo de actividades Básicas de la Vida Diaria - ABVD</label>
                                <input type="number" v-model="CarDesrrolloActividadesBasicas" name="CarDesrrolloActividadesBasicas" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en actividades Instrumentales Básicas</label>
                                <input type="number" v-model="CarInstrumentalesBasicas" name="CarInstrumentalesBasicas" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en actividades Instrumentales Complejas</label>
                                <input type="number" v-model="CarInstrumentalesComplejas" name="CarInstrumentalesComplejas" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en actividades de Intervención sensorial</label>
                                <input type="number" v-model="CarIntervensionSensorial" name="CarIntervensionSensorial" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en actividades Senso receptivas</label>
                                <input type="number" v-model="CarSensoReceptivas" name="CarSensoReceptivas" placeholder="" class="form-control">
                            </div>
                        </div>


                        <div class='row'>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en actividades de elaboración de bachas y ortéticos</label>
                                <input type="number" v-model="CarElavoracionOrteticos" name="CarElavoracionOrteticos" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en actividades de adaptaciones de sillas de ruedasl</label>
                                <input type="number" v-model="CarAdaptacionSilla" name="CarAdaptacionSilla" placeholder="" class="form-control">
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