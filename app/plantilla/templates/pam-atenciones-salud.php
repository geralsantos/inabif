<template id="pam-atenciones-salud">
    <div class="content mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Atenciones Salud</strong>
                    <h6>Formulario de Carga de Datos</h6>
                </div>
                <div class="card-body card-block">
                    <div class="row form-group">
                        <div class="col-12 col-md-1">
                            <label for="text-input" class=" form-control-label"></label>
                            <button @click="mostrar_lista_residentes()" class="btn btn-primary"><i class="fa fa fa-users"></i> Lista de Residentes</button>
                        </div>
                    </div>
                    <form v-on:submit.prevent="guardar"  class="form-horizontal">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="text-input" class=" form-control-label">Buscar Residente <i class="fa fa-search" aria-hidden="true"></i></label>
                                <div class="autocomplete">
                                    <input type="text"  v-model="nombre_residente" class="form-control campo_busqueda_residente" @keyup="buscar_residente()" placeholder="Nombre, Apellido o DNI"/>
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
                                <div class=" "><label for="text-input" class=" form-control-label">Residente tuvo salida a hospitales en el mes</label>
                                <select name="Residente_Salida" v-model="Residente_Salida" class="form-control">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                                </select> </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">Número de salidas a hospitales</label>
                                <input type="number" min="0"  v-model="Salidas" name="Salidas" placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" "><label for="text-input" class=" form-control-label">N° de atenciones en CARDIOVASCULAR</label>
                                <input type="number" min="0"  v-model="Atenciones_Cardiovascular" name="Atenciones_Cardiovascular" placeholder="" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de atenciones en NEFROLOGÍA</label>
                                <input type="number" min="0"  v-model="Atenciones_Nefrologia" name="Atenciones_Nefrologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">N° de atenciones en ONCOLOGÍA</label>
                                <input type="number" min="0"  v-model="Atenciones_Oncologia" name="Atenciones_Oncologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en NEUROCIRUGÍA</label>
                                <input type="number" min="0"  v-model="Atenciones_Neurocirugia" name="Atenciones_Neurocirugia" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en DERMATOLOGÍA</label>
                                <input type="number" min="0"  v-model="Atenciones_Dermatologia" name="Atenciones_Dermatologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en ENDOCRINOLOGÍA</label>
                                <input type="number" min="0"  v-model="Atenciones_Endocrinologo" name="Atenciones_Endocrinologo" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en GASTROENTEROLOGÍA</label>
                                <input type="number" min="0"  v-model="Atenciones_Gastroenterologia" name="Atenciones_Gastroenterologia" placeholder="" class="form-control">

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label"> Nº atenciones en HEMATOLOGÍA</label>
                                <input type="number" min="0"  v-model="Atenciones_Hematologia" name="Atenciones_Hematologia" placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en INMUNOLOGÍA</label>
                                <input type="number" min="0"  v-model="Atenciones_Inmunologia" name="Atenciones_Inmunologia" placeholder="" class="form-control">

                            </div>


                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en MEDICINA FÍSICA Y REHABILITACION</label>
                                <input type="number" min="0"  v-model="AtencionesMedicFisiRehabilita" name="AtencionesMedicFisiRehabilita" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en NEUMOLOGÍA</label>
                                <input type="number" min="0"  v-model="Atenciones_Neumologia" name="Atenciones_Neumologia" placeholder="" class="form-control">
                            </div>

                        <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en NUTRICION</label>
                                <input type="number" min="0"  v-model="Atenciones_Nutricion" name="Atenciones_Nutricion" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en NEUROLOGÍA</label>
                                <input type="number" min="0"  v-model="Atenciones_Neurologia" name="Atenciones_Neurologia" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en OFTALMOLIGÍA</label>
                                <input type="number" min="0"  v-model="Atenciones_Oftalmologia" name="Atenciones_Oftalmologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº atenciones en OTORRINOLARINGOLOGÍA</label>
                                <input type="number" min="0"  v-model="AtencionOtorrinolaringologia" name="AtencionOtorrinolaringologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en PSIQUÍATRÍA</label>
                                    <input type="number" min="0"  v-model="Atenciones_Psiquiatria" name="Atenciones_Psiquiatria" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en TRAUMATOLOGÍA</label>
                                <input type="number" min="0"  v-model="Atenciones_Traumatologia" name="Atenciones_Traumatologia" placeholder="" class="form-control">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en UROLOGÍA</label>
                                <input type="number" min="0"  v-model="Atenciones_Urologia" name="Atenciones_Urologia" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en ODONTOLOGÍA</label>
                                <input type="number" min="0"  v-model="Atenciones_Odontologia" name="Atenciones_Odontologia" placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Medicina general y/o Geriatrica</label>
                                <input type="number" min="0"  v-model="MedicinaGeneral_Geriatrica" name="MedicinaGeneral_Geriatrica" placeholder="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Nº Atenciones en Otros servicios</label>
                                <input type="number" min="0"  v-model="Nro_Atenciones_OtrosServicios" name="Nro_Atenciones_OtrosServicios" placeholder="" class="form-control">
                            </div>


                            <div class="form-group col-md-4">
                                <label for="text-input" class=" form-control-label">Residente fue hospitalizado en el periodo</label>
                                <select name="ResidenteHospitalizadoPeriodo" v-model="ResidenteHospitalizadoPeriodo" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <div class='row'>
                            <div class="form-group col-md-12">
                                <label for="text-input" class=" form-control-label">Motivo de la hospitalización</label>
                                <input type="text" v-model="Motivo_Hospitalizacion" name="Motivo_Hospitalizacion" placeholder="" class="form-control">
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