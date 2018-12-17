<template id="portada-index">


<div class="content mt-3">
<div class="row">
<div class="breadcrumbs portada">
                        <div class="col-sm-12">
                            <div class="page-header-2 float-right">
                                <div class="page-title">
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                    </div>
</div>
            <div class="row">
                <div class="area-indicador grupo-indicador-1">

                    <div class="breadcrumbs portada">
                        <div class="col-sm-6">
                            <div class="page-header-2 float-left">
                                <div class="page-title">
                                    <h4>Gestión y Control del Centro</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-indicador">
                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta">

                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_1')" href="#indicador_1"> Nivel de ejecución del plan de acción </a></span>
                                    </h5>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de acciones realizadas / N° de acciones programadas">Trimestre Anterior: <b>{{(isempty(indicador.ref1.trimestre_2*100)?0:(indicador.ref1.trimestre_2*100)).toFixed(2)}}%</b></p>

                                    <p data-toggle="tooltip" data-placement="top" title="N° de acciones realizadas / N° de acciones programadas">Trimestre Actual:<b> {{(isempty(indicador.ref1.trimestre_1*100)?0:(indicador.ref1.trimestre_1*100)).toFixed(2)}}%</b></p>
                                </div>
                            </div>
                        </div>
                        <!--/.col-->

                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_3')" href="#indicador_3">Incumplimiento de condiciones mínimas de funcionamiento</a></span>
                                    </h5>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="N° condiciones no conformes / N° condiciones totales">Día Anterior: <b>{{indicador.ref3.dia_anterior}}%</b></p>
                                    <p data-toggle="tooltip" data-placement="top" title="N° condiciones no conformes / N° condiciones totales">Día Actual: <b>{{indicador.ref3.dia_actual}}%</b></p>

                                </div>
                            </div>
                        </div>
                        <!--/.col-->

                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_5')" href="#indicador_5">Efectividad de las acciones implementadas sobre incidencias</a></span>
                                    </h5>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="N° incidentes resueltos / N° incidentes identificados">Mes Anterior:  <b>{{indicador.ref5.promedio_anterior}}%</b></p>

                                    <p data-toggle="tooltip" data-placement="top" title="N° incidentes resueltos / N° incidentes identificados">Mes Actual:  <b>{{indicador.ref5.promedio}}%</b></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="area-indicador grupo-indicador-2">
                    <div class="breadcrumbs portada">
                        <div class="col-sm-6">
                            <div class="page-header-2 float-left">
                                <div class="page-title">
                                    <h4>Operación del Centro</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-indicador">
                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_8')" href="#indicador_8">Nivel de satisfacción de la información brindada al ciudadano</a></span>
                                    </h5>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de ciudadanos satisfechos con la información / N° total de ciudadanos encuestados">Trimestre anterior:  <b>{{(isempty(indicador.ref8.trimestre_2)?0:(indicador.ref8.trimestre_2)).toFixed(2)}}%</b></p>

                                    <p data-toggle="tooltip" data-placement="top" title="N° de ciudadanos satisfechos con la información / N° total de ciudadanos encuestados">Trimestre Actual:  <b>{{(isempty(indicador.ref8.trimestre_1)?0:(indicador.ref8.trimestre_1)).toFixed(2)}}%</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_9')" href="#indicador_9">Tasa de atención de citas</a></span>
                                    </h5>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de citas atendidas / N° de citas programadas">Semana Anterior:  <b>{{indicador.ref9.semana_anterior}}%</b></p>

                                    <p data-toggle="tooltip" data-placement="top" title="N° de citas atendidas / N° de citas programadas">Semana Actual:  <b>{{indicador.ref9.semana_actual}}%</b></p>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_11')" href="#indicador_11">Ratio de atención por número de tickets emitidos</a></span>
                                    </h4>
                                    <br>

                                    <p data-toggle="tooltip" data-placement="top" title="Frecuencia de  servicios prestados ">Día Anterior:  <b>{{indicador.ref11.dia_anterior}}</p>
                                    <p data-toggle="tooltip" data-placement="top" title="Frecuencia de  servicios prestados ">Día Actual:  <b>{{indicador.ref11.dia_actual}}</p>
                                </div>
                            </div>
                        </div>
                        <!--/.col-->
                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_106')" href="#indicador_106">Ranking de atenciones diarias  por entidad</a></span>
                                    </h4>
                                    <br>

                                    <p data-toggle="tooltip" data-placement="top" title="Frecuencia de  servicios prestados ">Día Anterior:  <b>{{indicador.ref106.dia_anterior}}</p>
                                    <p data-toggle="tooltip" data-placement="top" title="Frecuencia de  servicios prestados ">Día Actual:  <b>{{indicador.ref106.dia_actual}}</p>
                                </div>
                            </div>
                        </div>
                        <!--/.col-->


                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_11_1')" href="#indicador_11_1">Ticket de atencion x hora</a></span>
                                    </h4>
                                    <br>

                                    <p data-toggle="tooltip" data-placement="top" title="N° de tickets generados x hora">Hora Anterior:  <b>{{indicador.ref11_1.dia_anterior}}</b></p>
                                      <p data-toggle="tooltip" data-placement="top" title="N° de tickets generados x hora">Hora Actual:  <b>{{indicador.ref11_1.dia_actual}}</b></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_12')" href="#indicador_12">Tiempo promedio de espera del ciudadano por trámite</a></span>


                                    </h4>
                                    <br>

                                    <p data-toggle="tooltip" data-placement="top" title="Hora de inicio de atención - (Hora de emisión de ticket u Hora de derivación)">Día Anterior:  <b>{{indicador.ref12.dia_anterior}} Minutos</b></p>
                                      <p data-toggle="tooltip" data-placement="top" title="Hora de inicio de atención - (Hora de emisión de ticket u Hora de derivación)">Día Actual:  <b>{{indicador.ref12.dia_actual}} Minutos</b></p>

                                </div>
                            </div>
                        </div>
                            <!--/.col-->

                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_14')" href="#indicador_14">Tasa de tickets en abandono</a></span>
                                    </h4>
                                    <br>

                                    <p data-toggle="tooltip" data-placement="top" title="N° de tickets abandonados / N° de tickets totales">Día Anterior:  <b>{{indicador.ref14.dia_anterior}}%</b></p>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de tickets abandonados / N° de tickets totales">Día Actual:  <b>{{indicador.ref14.dia_actual}}%</b></p>
                                </div>
                            </div>
                        </div>
                            <!--/.col-->

                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_15')" href="#indicador_15">Tasa de reactivación de tickets</a></span>
                                    </h4>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de tickets reactivados / N° de tickets totales">Día Anterior:  <b>{{indicador.ref15.dia_anterior}}%</b></p>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de tickets reactivados / N° de tickets totales">Día Actual:  <b>{{indicador.ref15.dia_actual}}%</b></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_15_1')" href="#indicador_15_1">Atenciones totales diarias</a></span>
                                    </h4>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="">Día Anterior:  <b>{{indicador.ref15_1.dia_anterior}}</b></p>
                                    <p data-toggle="tooltip" data-placement="top" title="">Día Actual:  <b>{{indicador.ref15_1.dia_actual}}</b></p>
                                </div>
                            </div>
                        </div>
                        <!--/.col-->
                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_16')" href="#indicador_16">Porcentaje de sugerencias atendidas oportunamente</a></span>
                                    </h4>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de sugerencias respondidas oportunamente / N° de sugerencias reportadas">Mes Anterior:  <b>{{(isempty(indicador.ref16.mes_2)?0:indicador.ref16.mes_2).toFixed(2)}}%</b></p>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de sugerencias respondidas oportunamente / N° de sugerencias reportadas">Mes Actual:  <b>{{(isempty(indicador.ref16.mes_1)?0:indicador.ref16.mes_1).toFixed(2)}}%</b></p>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_17')" href="#indicador_17">Tasa de reclamos y quejas  </a></span>
                                    </h4>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de quejas y reclamos / N° de tickets totales">Mes Anterior:  <b>{{(isempty(indicador.ref17.mes_2)?0:indicador.ref17.mes_2).toFixed(2)}}%</b></p>

                                    <p data-toggle="tooltip" data-placement="top" title="N° de quejas y reclamos / N° de tickets totales">Mes Actual:  <b>{{(isempty(indicador.ref17.mes_1)?0:indicador.ref17.mes_1).toFixed(2)}}%</b></p>
                                </div>
                            </div>
                        </div>
                        <!--/.col-->

                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_18')" href="#indicador_18">Porcentaje de reclamos y quejas atendidos oportunamente  </a></span>
                                    </h4>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de quejas y reclamos respondidos / N° de quejas y reclamos totales">Mes Anterior:  <b>{{(isempty(indicador.ref18.mes_2)?0:indicador.ref18.mes_2).toFixed(2)}}%</b></p>

                                    <p data-toggle="tooltip" data-placement="top" title="N° de quejas y reclamos respondidos / N° de quejas y reclamos totales">Mes Actual:  <b>{{(isempty(indicador.ref18.mes_1)?0:indicador.ref18.mes_1).toFixed(2)}}%</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_103')" href="#indicador_103">Eficiencia en la atención  </a></span>
                                    </h4>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="area-indicador grupo-indicador-3">

                    <div class="breadcrumbs portada">
                        <div class="col-sm-6">
                            <div class="page-header-2 float-left">
                                <div class="page-title">
                                    <h4>Gestión Personal</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-indicador">
                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_19')" href="#indicador_19">Cobertura de difusión de la estrategia MAC al personal</a></span>
                                    </h5>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de personal al que se le impartió la inducción / N° total de personal">Semestre Anterior:  <b>{{(isempty(indicador.ref19.semestre_2)?0:indicador.ref19.semestre_2).toFixed(2)}}%</b></p>

                                    <p data-toggle="tooltip" data-placement="top" title="N° de personal al que se le impartió la inducción / N° total de personal">Semestre Actual:  <b>{{(isempty(indicador.ref19.semestre_1)?0:indicador.ref19.semestre_1).toFixed(2)}}%</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_20')" href="#indicador_20">Cumplimiento de los programas de capacitación del personal</a></span>
                                    </h5>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de capacitaciones ejecutadas / N° capacitaciones programadas">Trimestre Anterior:  <b>{{(isempty(indicador.ref20.trimestre_2)?0:indicador.ref20.trimestre_2).toFixed(2)}}%</b></p>

                                    <p data-toggle="tooltip" data-placement="top" title="N° de capacitaciones ejecutadas / N° capacitaciones programadas">Trimestre Actual:  <b>{{(isempty(indicador.ref20.trimestre_1)?0:indicador.ref20.trimestre_1).toFixed(2)}}%</b></p>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_25')" href="#indicador_25">Nivel de calificación del personal (promedio)</a></span>
                                    </h5>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="Puntaje de la evaluación de desempeño">Trimestre Anterior:  <b>{{parseFloat(isempty(indicador.ref25.trimestre_2)?0:indicador.ref25.trimestre_2)}}</p>

                                    <p data-toggle="tooltip" data-placement="top" title="Puntaje de la evaluación de desempeño">Trimestre Actual:  <b>{{parseFloat(isempty(indicador.ref25.trimestre_1)?0:indicador.ref25.trimestre_1)}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_102')" href="#indicador_102">Control de asistencia</a></span>
                                    </h5>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de Personas que tienen Hora de asistencia mayor o igual a la hora inicio de turno">Día Anterior:  <b>{{indicador.ref102.dia_anterior}}</p>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de Personas que tienen Hora de asistencia mayor o igual a la hora inicio de turno">Día Actual:  <b>{{indicador.ref102.dia_actual}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="area-indicador grupo-indicador-4">

                    <div class="breadcrumbs portada">
                        <div class="col-sm-6">
                            <div class="page-header-2 float-left">
                                <div class="page-title">
                                    <h4>Gestión de Recursos e Infraestructura</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-indicador">
                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_28')" href="#indicador_28">Cumplimiento del programa de mantenimiento</a></span>
                                    </h5>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de mantenimientos ejecutadas / N° de mantenimientos programados">Trimestre Anterior:  <b>{{(isempty(indicador.ref28.trimestre_2*100)?0:(indicador.ref28.trimestre_2*100)).toFixed(2)}}%</b></p>

                                    <p data-toggle="tooltip" data-placement="top" title="N° de mantenimientos ejecutadas / N° de mantenimientos programados">Trimestre Actual:  <b>{{(isempty(indicador.ref28.trimestre_1*100)?0:(indicador.ref28.trimestre_1*100)).toFixed(2)}}%</b></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="area-indicador grupo-indicador-5">

                    <div class="breadcrumbs portada">
                        <div class="col-sm-12">
                            <div class="page-header-2 float-left">
                                <div class="page-title">
                                    <h4>ALÓ MAC</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-indicador">

                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_104')" href="#indicador_104">Aló MAC: Atenciones totales diarias</a></span>
                                    </h5>
                                    <br>

                                    <p data-toggle="tooltip" data-placement="top" title="Llamadas Recibidas">Día Anterior:  <b>{{isempty(indicador.ref104.dia_anterior)?0:indicador.ref104.dia_anterior}}</p>
                                    <p data-toggle="tooltip" data-placement="top" title="Llamadas Recibidas">Día Actual:  <b>{{isempty(indicador.ref104.dia_actual)?0:indicador.ref104.dia_actual}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="area-indicador grupo-indicador-5">

                    <div class="breadcrumbs portada">
                        <div class="col-sm-6">
                            <div class="page-header-2 float-left">
                                <div class="page-title">
                                    <h4>CANAL DIGITAL</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grupo-indicador">
                        <div class="col-sm-12 col-lg-4">
                            <div class="card text-white tarjeta ">
                                <div class="card-body pb-0">
                                    <h5 class="mb-0">
                                        <span class="link-titulo"><a @click="appVue.changeview('indicador_105')" href="#indicador_105">Canal Digital: Atenciones totales mensuales y acumuladas</a></span>
                                    </h5>
                                    <br>
                                    <p data-toggle="tooltip" data-placement="top" title="N° de atenciones">Mes Anterior:  <b>{{indicador.ref105.mes_anterior}}</b></p>

                                    <p data-toggle="tooltip" data-placement="top" title="N° de atenciones">Mes Actual:  <b>{{indicador.ref105.mes_actual}}</b></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <br>
            <br>




        </div> <!-- .content -->
</template>
