<template id="ppd-datos-terapia">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Datos de Terapia (física, del lenguaje, ocupacional y tecnológica)</strong>
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
                        <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en terapia para la reeducación motriz</label>
                                <input type="number" min="0" max="31"   v-model="CarNumReeducaion" name="CarNumReeducaion" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">N° de veces que Participa en terapia para la Psicomotricidad</label>
                                <input type="number" min="0" max="31"   v-model="CarParticipaPsicomotricidad" name="CarParticipaPsicomotricidad" placeholder="" class="form-control">
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en terapia para la Fisioterapia respiratoria</label>
                                <input type="number" min="0" max="31"   v-model="CarFisioterapia" name="CarFisioterapia" placeholder="" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en terapia para la Deportes Adaptados</label>
                                <input type="number" min="0" max="31"   v-model="CarDeportesAdaptados" name="CarDeportesAdaptados" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa de terapia para la comunicación</label>
                                <input type="number" min="0" max="31"   v-model="CarComunicacion" name="CarComunicacion" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa de terapia para la reeducación orofacial</label>
                                <input type="number" min="0" max="31"   v-model="CarReeducacionOrofacial" name="CarReeducacionOrofacial" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en terapia del Lenguaje</label>
                                <input type="number" min="0" max="31"   v-model="CarTerapiaLenguaje" name="CarTerapiaLenguaje" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en terapia para el Desarrollo de lenguaje alternativo</label>
                                <input type="number" min="0" max="31"   v-model="CarDesarrolloLenguaje" name="CarDesarrolloLenguaje" placeholder="" class="form-control">

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Tipo de lenguaje alternativo</label>
                                <select name="CarTipoLenguajeAlternativo" v-model="CarTipoLenguajeAlternativo" class="form-control">
                                    <option v-for="lenguaje in lenguajes" :value="lenguaje.ID">{{lenguaje.NOMBRE}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa de terapia para el desarrollo de actividades Básicas de la Vida Diaria - ABVD</label>
                                <input type="number" min="0" max="31"   v-model="CarDesrrolloActividadesBasicas" name="CarDesrrolloActividadesBasicas" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en actividades Instrumentales Básicas</label>
                                <input type="number" min="0" max="31"   v-model="CarInstrumentalesBasicas" name="CarInstrumentalesBasicas" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en actividades Instrumentales Complejas</label>
                                <input type="number" min="0" max="31"   v-model="CarInstrumentalesComplejas" name="CarInstrumentalesComplejas" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en actividades de Intervención sensorial</label>
                                <input type="number" min="0" max="31"   v-model="CarIntervensionSensorial" name="CarIntervensionSensorial" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en actividades Senso receptivas</label>
                                <input type="number" min="0" max="31"   v-model="CarSensoReceptivas" name="CarSensoReceptivas" placeholder="" class="form-control">
                            </div>
                        </div>


                        <div class='row'>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en actividades de elaboración de bachas y ortéticos</label>
                                <input type="number" min="0" max="31"   v-model="CarElavoracionOrteticos" name="CarElavoracionOrteticos" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de veces que Participa en actividades de adaptaciones de sillas de ruedas</label>
                                <input type="number" min="0" max="31"   v-model="CarAdaptacionSilla" name="CarAdaptacionSilla" placeholder="" class="form-control">
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