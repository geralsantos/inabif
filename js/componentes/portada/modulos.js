




Vue.component('portada-index', {
  template: '#portada-index',
  data:()=>({
    atributos : [],
    valores : {},
    indicador:{
      ref1:{
        trimestre_1:0,
        trimestre_2:0
      },
      ref3:{
        dia_actual:0,
        dia_anterior:0
      },
      ref5:{
        promedio:0,
        promedio_anterior:0
      },
      ref8:{
        trimestre_1:0,
        trimestre_2:0
      },
      ref9:{
        semana_actual:0,
        semana_anterior:0,
      },
      ref11_1:{
        dia_anterior:0,
        dia_actual:0,
      },
      ref11:{
        dia_anterior:0,
        dia_actual:0,
      },
      ref12:{
        dia_anterior:0,
        dia_actual:0,
      },
      ref14:{
        dia_actual:0,
        dia_anterior:0,
      },
      ref15:{
        dia_actual:0,
        dia_anterior:0,
      },
      ref15_1:{
        dia_actual:0,
        dia_anterior:0,
      },
      ref16:{
        mes_1:0,
        mes_2:0
      },
      ref17:{
        mes_1:0,
        mes_2:0
      },
      ref18:{
        mes_1:0,
        mes_2:0
      },
      ref19:{
        semestre_1:0,
        semestre_2:0
      },
      ref20:{
        trimestre_1:0,
        trimestre_2:0
      },
      ref25:{
        trimestre_1:0,
        trimestre_2:0
      },
      ref28:{
        trimestre_1:0,
        trimestre_2:0
      },
      ref102:{
        dia_anterior:0,
        dia_actual:0,
      },
      ref104:{
        dia_anterior:0,
        dia_actual:0,
      },
      ref105:{
        mes_actual:0,
        mes_anterior:0,
      },
      ref106:{
        dia_anterior:0,
        dia_actual:0,
      }
    },
  }),
  created:function(){
  },
  mounted:function(){

  this.indicador_1();
 this.indicador_3();
   this.indicador_5();
   this.indicador_8();
   this.indicador_9();
   this.indicador_11();
   this.indicador_106();
   this.indicador_11_1();
    this.indicador_12();
   this.indicador_14();
   this.indicador_15();
   this.indicador_15_1();
    this.indicador_16();
    this.indicador_17();
    this.indicador_18();
    this.indicador_19();
    this.indicador_20();
    this.indicador_25();
    this.indicador_28();
    this.indicador_104();
    this.indicador_105();
    this.indicador_102();


  },
  updated:function(){

  },
  methods:{

    indicador_1(){
      let where = {}, year=moment().format('YYYY');
      where.trimestre = moment().quarter();
      let trimestre_anterior = moment().quarter()-1 > moment().quarter() ? ('(trimestre = '+(moment().quarter()-1)+' and date_format(fecha_inicio_programada,"%Y") = '+moment().subtract(1,"years").format("YYYY")+')') : ' trimestre='+(moment().quarter()-1);
      let programadas = "SELECT *, '1' AS tipo, count(trimestre) AS cantidad FROM kpi_indicador_ref1 WHERE date_format(fecha_inicio_programada,'%Y-%m-%d') between '"+year+"-01-01' AND '"+year+"-12-31' and estado=1 and (trimestre = "+moment().quarter()+" or "+trimestre_anterior+" ) group by trimestre";

      let realizadas = "SELECT *,  '2' AS tipo, count(trimestre) AS cantidad FROM kpi_indicador_ref1 WHERE ( kpi_estado_actividad = 5 OR kpi_estado_actividad=6 )  AND date_format(fecha_fin_real,'%Y-%m-%d') between '"+year+"-01-01' AND '"+year+"-12-31' and estado=1 and ("+trimestre_anterior+" or  trimestre = "+(moment().quarter())+") group by trimestre";

      this.$http.post('cargar_datos_union?view',{consulta:realizadas, consulta_2:programadas}).then(function(response){
         let data = response.body.data;
         let realizadas=0,programadas=0;
         for (var i = 0; i < data.length; i++) {
           if (data[i]["tipo"]=="2") {
             if (data[i]["trimestre"]==moment().quarter()) {
               this.indicador.ref1.trimestre_1 = data[i]["cantidad"];
             }else{
               this.indicador.ref1.trimestre_2 = data[i]["cantidad"];
             }
           }else{
             if (data[i]["trimestre"]==moment().quarter()) {
               this.indicador.ref1.trimestre_1 = this.indicador.ref1.trimestre_1/data[i]["cantidad"];
             }else{
               this.indicador.ref1.trimestre_2 = this.indicador.ref1.trimestre_2/data[i]["cantidad"];
             }
           }
         }
      });
    },
    indicador_3(){
      let where = {},campos=["valores","fecha"], groupby={};
      where.fecha =['fecha','OR',moment().format('YYYY-MM-DD'),(moment().subtract(1,'day').format('YYYY-MM-DD'))];
      groupby.fecha = "fecha";

      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref3',campos:campos, where:where,groupby:groupby}).then(function(response){
         let data = response.body.atributos;

         for (var i = 0; i < data.length; i++) {

              let  valores_arr = JSON.parse(data[i]["valores"]);

                        let incumplimiento_apertura = 0;
                        let incumplimiento_relevo = 0;
                        let incumplimiento_cierre = 0;
                        let total_condiciones = 0;
                        let entidad_incumplimiento_apertura = 0;
                        let entidad_incumplimiento_relevo = 0;
                        let entidad_incumplimiento_cierre = 0;
                        let apertuta_per=0, relevo_per=0, cierre_per=0;

                        for(var u= 0; u <  valores_arr.length; u++) {

                            if(valores_arr[u].name == 'grupos'){
                                let valores = valores_arr[u].valores;
                                for(var e= 0; e <  valores.length; e++) {
                                    total_condiciones++;

                                    if(valores[e].apertura == 1 ){
                                        incumplimiento_apertura++;
                                    }
                                    if(valores[e].relevo == 1 ){
                                        incumplimiento_relevo++;
                                    }
                                    if(valores[e].cierre == 1 ){
                                        incumplimiento_cierre++;
                                    }

                                }
                            }
                            if(valores_arr[u].name == 'entidades'){
                                total_condiciones++;

                                let valores = valores_arr[u].valores;
                                for(var e= 0; e <  valores.length; e++) {
                                    //si alguno de los tres es 1 todo es mal funcionamiento para todo el grupo
                                    if(valores[e].apertura == 1){
                                        entidad_incumplimiento_apertura++
                                    }
                                    if(valores[e].relevo == 1 ){
                                        entidad_incumplimiento_relevo++
                                    }
                                    if( valores[e].cierre == 1){
                                        entidad_incumplimiento_cierre++
                                    }

                                }
                                if(entidad_incumplimiento_apertura!=0){
                                    incumplimiento_apertura++;
                                }
                                if(entidad_incumplimiento_relevo!=0){
                                    incumplimiento_relevo++;
                                }
                                if(entidad_incumplimiento_cierre!=0){
                                    incumplimiento_cierre++;
                                }
                            }

                        }


                        apertuta_per = parseFloat(((incumplimiento_apertura/total_condiciones)*100).toFixed(2));
                        relevo_per = parseFloat(((incumplimiento_relevo/total_condiciones)*100).toFixed(2));
                        cierre_per = parseFloat(((incumplimiento_cierre/total_condiciones)*100).toFixed(2));

                        if (data[i].fecha==moment().format('YYYY-MM-DD 00:00:00')) {
                          let promedio_actual = (apertuta_per + relevo_per + cierre_per)/3;
                          this.indicador.ref3.dia_actual = promedio_actual.toFixed(2);

                        }else{
                          let promedio_anterior = (apertuta_per + relevo_per + cierre_per)/3;
                          this.indicador.ref3.dia_anterior = promedio_anterior.toFixed(2);
                        }
         }
      })
    },

    indicador_5(){
      let where = {};
      where.fecha =['mes',moment().format('MM')];
      where.anio =['anio',moment().format('YYYY')];
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref5',campos:['*'], where:where, groupby:''}).then(function(response){
         let data = response.body.atributos;
         if(data!= undefined){
          let iden = (parseFloat(data[0].incidentes_identificados)+parseFloat(data[0].incidentes_identificados_t2));
          let resl = (parseFloat(data[0].incidentes_resueltos)+parseFloat(data[0].incidentes_resueltos_t2));
         let promedio_actual = (isNaN((resl/iden)*100))?0:(resl/iden)*100;
          this.indicador.ref5.promedio = parseFloat(promedio_actual).toFixed(2);
         }

      });
      let where2 = {};
      where2.mes =['mes',moment().subtract(1,'months').format('MM')];
      where.anio =['anio',moment().subtract(1,'months').format('YYYY')];
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref5',campos:['*'], where:where2, groupby:''}).then(function(response){
        let data = response.body.atributos;
        if(data!=undefined){
          let iden = (parseFloat(data[0].incidentes_identificados)+parseFloat(data[0].incidentes_identificados_t2));
        let resl = (parseFloat(data[0].incidentes_resueltos)+parseFloat(data[0].incidentes_resueltos_t2));
       let promedio_anterior = (isNaN((resl/iden)*100))?0:(resl/iden)*100;
        this.indicador.ref5.promedio_anterior = parseFloat(promedio_anterior).toFixed(2);
        }

        })

    },
    indicador_8(){
      let where = {},campos=["trimestre","encuestados_satisfechos as encuestados_satisfechos","total_encuestados as total_encuestados"], groupby={};
      where.trimestre =['trimestre','OR',moment().quarter(),(moment().quarter()-1)];
      where.anio =['anio',moment().format('YYYY')];
      groupby.trimestre = "trimestre";
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref8',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;

         for (var i = 0; i < data.length; i++) {
             if (data[i]["trimestre"]==moment().quarter()) {
               this.indicador.ref8.trimestre_1 = (data[i]["encuestados_satisfechos"]/ data[i]["total_encuestados"])*100;
             }else{
               this.indicador.ref8.trimestre_2 = (data[i]["encuestados_satisfechos"]/ data[i]["total_encuestados"])*100;
             }
         }
      })
    },
    indicador_9(){
      let dias=["monday","tuesday","wednesday","thursday","friday","saturday","sunday"];

      let where = {},campos=["sum(citas_entregadas) as citas_entregadas","sum(citas_programadas) as citas_programadas","count(*) as cantidad"], groupby='';

      let semana_inicio = moment().weekday(1).format('YYYY-MM-DD');
      let semana_fin = moment().weekday(7).format('YYYY-MM-DD');

      where.fecha =['date_format(fecha,"%Y-%m-%d")','BETWEEN',semana_inicio,semana_fin];
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref9',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;
         if (!isempty(data[0]["cantidad"])) {
           this.indicador.ref9.semana_actual=(data[0]["citas_entregadas"]/data[0]["citas_programadas"])*100;
           this.indicador.ref9.semana_actual = ( isNaN(this.indicador.ref9.semana_actual)) ? '0.00' : parseFloat(this.indicador.ref9.semana_actual).toFixed(2);
         }
      })



   let where2 = {};
   let semana_ini_anterior =  moment(semana_inicio).weekday(-6).format('YYYY-MM-DD');
   let semana_fin_anterior = moment(semana_fin).weekday(-7).format('YYYY-MM-DD');
      where2.fecha =['date_format(fecha,"%Y-%m-%d")','BETWEEN',semana_ini_anterior,semana_fin_anterior];
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref9',campos:campos, where:where2, groupby:groupby}).then(function(response){
         let data = response.body.atributos;
         if (!isempty(data[0]["cantidad"])) {
           let valor = (data[0]["citas_entregadas"]/data[0]["citas_programadas"])*100 ;
           this.indicador.ref9.semana_anterior = ( isNaN(valor)) ? '0.00' : parseFloat(valor).toFixed(2);
         }
      })
    },
    indicador_11(){
      let where = {},campos=["count(*) as cantidad","serviciosjson"], groupby='';

      where.fecha =['date_format(fecha,"%Y-%m-%d")',moment().subtract(1,'days').format('YYYY-MM-DD')];
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref11', campos:campos,where:where,groupby:groupby}).then(function(response){
         let data = response.body.atributos;
         data = JSON.parse(data[0]["serviciosjson"]);

         if (!isempty(data)) {

          let personas_mayor_valor=0,servicios_persona="";
          let total_personas_mayor_valor=0;
         for (var i = 0; i < data.length; i++) {


            if( data[i]["personas"] > personas_mayor_valor){
              personas_mayor_valor = data[i]["personas"];
              servicios_persona = data[i]["servicios"];

            }
            total_personas_mayor_valor = data[i]["personas_total"];
           }

          let porcentaje = (parseFloat(personas_mayor_valor)/parseFloat(total_personas_mayor_valor))*100;
          this.indicador.ref11.dia_anterior = ((isNaN(porcentaje))?0:parseFloat(porcentaje).toFixed(2))+"% "+servicios_persona+ "Servicio(s) ";
         }

      });
      where.fecha =['date_format(fecha,"%Y-%m-%d")',moment().format('YYYY-MM-DD')];
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref11', campos:campos,where:where,groupby:groupby}).then(function(response){
         let data = response.body.atributos;
         data = JSON.parse(data[0]["serviciosjson"]);
         if (!isempty(data)) {
           let personas_mayor_valor=0,servicios_persona="";
           let total_personas_mayor_valor=0;
          for (var i = 0; i < data.length; i++) {
             if( data[i]["personas"] > personas_mayor_valor){
               personas_mayor_valor = data[i]["personas"];
               servicios_persona = data[i]["servicios"];
             }
             total_personas_mayor_valor = data[i]["personas_total"];
            }
           // before_per = data[i]["personas"];
           let porcentaje = (parseFloat(personas_mayor_valor)/parseFloat(total_personas_mayor_valor))*100;
           this.indicador.ref11.dia_actual = ((isNaN(porcentaje))?0:parseFloat(porcentaje).toFixed(2))+"% "+servicios_persona+ "Servicio(s) ";
         }
      })
    },
    indicador_11_1(){

      let hora_actual = moment().format("HH");
      let hora_anterior = (hora_actual-1);
      let where = {},campos=["ticketsjson","fecha"], groupby='';
      //let semana_anterior=moment().subtract(7,'days').format('YYYY-MM-DD');
      where.fecha =['date_format(fecha,"%Y-%m-%d")',moment().format('YYYY-MM-DD')];

      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref11_1',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data_ = response.body.atributos;

         if(data_ != undefined){
          let acum = 0,acum2=0;
          for (var i = 0; i < data_.length; i++) {
            let data = JSON.parse(data_[i]["ticketsjson"]);

              for (var y = 0; y < data.length; y++) {

                if(data[y]["hora"] == hora_actual){

                 acum = data[y]["tickets"];
                }else if(data[y]["hora"] == hora_anterior){
                 acum2 = data[y]["tickets"];
                }

              }

          }
          this.indicador.ref11_1.dia_actual=acum + ' tickets';
          this.indicador.ref11_1.dia_anterior=acum2 + ' tickets';
         }

      })
    },
    indicador_12(){
      let where = {},campos=["count(*) as cantidad","prom_enti_json","date_format(fecha,'%Y-%m-%d') as fecha_mov"], groupby={};

      where.fecha =['date_format(fecha,"%Y-%m-%d")','BETWEEN',moment().subtract(1,'days').format('YYYY-MM-DD'),moment().format('YYYY-MM-DD')];
      groupby.fecha_ = "fecha";
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref12',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data_ = response.body.atributos;

         if(data_ != undefined){
           let acum = 0,acum2=0;

           for (var i = 0; i < data_.length; i++) {
            let data = JSON.parse(data_[i]["prom_enti_json"]);
             if (moment().format("YYYY-MM-DD")==moment(data_[i]["fecha_mov"],"YYYY-MM-DD").format("YYYY-MM-DD")) {
               for (var y = 0; y < data.length; y++) {
                 acum = acum + parseFloat(data[y]["promedio"]);
               }
               this.indicador.ref12.dia_actual=hora_min_seg(acum/data.length);
             }else{
               for (var x = 0; x < data.length; x++) {
                 acum2 = acum2 + parseFloat(data[x]["promedio"]);
               }

               this.indicador.ref12.dia_anterior=hora_min_seg(acum2/data.length);
             }

           }
         }
      })
    },
    indicador_14(){
      let where = {},campos=["count(*) as cantidad","ticks_aband_total"], groupby='';
      //let semana_anterior=moment().subtract(7,'days').format('YYYY-MM-DD');
      where.fecha =['date_format(fecha,"%Y-%m-%d")',moment().subtract(1,'days').format('YYYY-MM-DD')];
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref14',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;
         if(!isempty(data)){
           data = JSON.parse(data[0]["ticks_aband_total"]);
           let valor=(isNaN(data["ticks_aband_total"]))?0:data["ticks_aband_total"];
           this.indicador.ref14.dia_anterior=parseFloat(valor).toFixed(2);
         }
      });
      where.fecha =['date_format(fecha,"%Y-%m-%d")',moment().format('YYYY-MM-DD')];
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref14',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;
         if(JSON.parse(data[0]["ticks_aband_total"])!=null){
           data = JSON.parse(data[0]["ticks_aband_total"]);
           let valor=(isNaN(data["ticks_aband_total"]) )?0:data["ticks_aband_total"];
           this.indicador.ref14.dia_actual=parseFloat(valor).toFixed(2);
         }

      });
    },

    indicador_15(){
      let where = {},campos=["count(*) as cantidad","ticks_react_total"], groupby='';
      //let semana_anterior=moment().subtract(7,'days').format('YYYY-MM-DD');
      where.fecha =['date_format(fecha,"%Y-%m-%d")',moment().subtract(1,'days').format('YYYY-MM-DD')];
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref15',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;
          if(!isempty(data)){
            if(JSON.parse(data[0]["ticks_react_total"])!=null){
              data = JSON.parse(data[0]["ticks_react_total"]);
              let valor=(isNaN(data["ticks_react_total"]))?0:data["ticks_react_total"];
              this.indicador.ref15.dia_anterior=parseFloat(valor).toFixed(2);
            }

          }

      });
      where.fecha =['date_format(fecha,"%Y-%m-%d")',moment().format('YYYY-MM-DD')];
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref15',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;

          if(!isempty(data)){
              if(JSON.parse(data[0]["ticks_react_total"])!=null){
                data = JSON.parse(data[0]["ticks_react_total"]);
                let ticks_react=(isNaN(data["ticks_react"]))?0:data["ticks_react"];

                valor = ( ticks_react / parseFloat(data["ticks_total"]) )*100;

                this.indicador.ref15.dia_actual=parseFloat(valor).toFixed(2);
              }
          }

      })
    },

    indicador_15_1(){
      let where = {},campos=["count(*) as cantidad","ticks_atencion_total"], groupby='';

      where.fecha =['date_format(fecha,"%Y-%m-%d")',moment().subtract(1,'days').format('YYYY-MM-DD')];
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref15_1',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;
         if(data != undefined){
           if(JSON.parse(data[0]["ticks_atencion_total"])!=null){
             data = JSON.parse(data[0]["ticks_atencion_total"]);
             let valor=(isNaN(data["ticks_atencion_total"]))?0:data["ticks_atencion_total"];
             this.indicador.ref15_1.dia_anterior=parseFloat(valor);
           }

         }
      });
      where.fecha =['date_format(fecha,"%Y-%m-%d")',moment().format('YYYY-MM-DD')];
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref15_1',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;
         if(data != undefined){
           if(JSON.parse(data[0]["ticks_atencion_total"])!=null){
             data = JSON.parse(data[0]["ticks_atencion_total"]);
             let valor=(isNaN(data["ticks_atencion_total"]))?0:data["ticks_atencion_total"];
             this.indicador.ref15_1.dia_actual=parseFloat(valor);
           }

         }
      });
    },
    indicador_16(){
      let where = {},campos=["mes","sugerencias_respondidas","sugerencias_reportadas"], groupby={};
      where.trimestre =['mes','OR',moment().format('MM'),(moment().subtract(1,'months').format('MM'))];
      where.anio =['anio',moment().format('YYYY')];
      groupby.trimestre = "mes";
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref16',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;
         for (var i = 0; i < data.length; i++) {
             if (data[i]["mes"]==moment().format('MM')) {
               this.indicador.ref16.mes_1 = (data[i]["sugerencias_respondidas"]/ data[i]["sugerencias_reportadas"])*100;
             }else{
               this.indicador.ref16.mes_2 = (data[i]["sugerencias_respondidas"]/ data[i]["sugerencias_reportadas"])*100;
             }
         }
      })
    },
    indicador_17(){
      let where = {},campos=["mes","cantidad_quejas","cantidad_tickets"], groupby={};
      where.trimestre =['mes','OR',moment().format('MM'),(moment().subtract(1,'months').format('MM'))];
      where.anio =['anio',moment().format('YYYY')];
      groupby.trimestre = "mes";
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref17',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;
         if(data != undefined){
          for (var i = 0; i < data.length; i++) {
            if (data[i]["mes"]==moment().format('MM')) {
              this.indicador.ref17.mes_1 = (data[i]["cantidad_quejas"]/ data[i]["cantidad_tickets"])*100;
            }else{
              this.indicador.ref17.mes_2 = (data[i]["cantidad_quejas"]/ data[i]["cantidad_tickets"])*100;
            }
          }
         }
      })
    },
    indicador_18(){
      let periodo_actual = moment().format('MM') ;
      let periodo_anterior = ( moment().format('MM') == 1 ) ? 12 : (moment().subtract(1,'months').format('MM'));

      let where = {},campos=["anio","mes","nro_quejas_reclamos","nro_quejas_reclamos_respondidos"], groupby={};
      where.mes =['mes','OR',moment().format('MM'),(moment().subtract(1,'months').format('MM'))];
      where.anio =['anio','OR',moment().subtract(1,'years').format('YYYY'), moment().format('YYYY')];
      groupby.mes = "mes";
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref18',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;


         for (var i = 0; i < data.length; i++) {
          if( periodo_actual == 1){
            if (data[i]["mes"]== periodo_actual  && moment().format('YYYY') == data[i]["anio"] ) {
              this.indicador.ref18.mes_1 = (parseFLoat(data[i]["nro_quejas_reclamos_respondidos"])/ (isempty(data[i]["nro_quejas_reclamos"])?1:data[i]["nro_quejas_reclamos"]))*100;
             }else if (data[i]["mes"]== periodo_anterior  &&  moment().subtract(1,'years').format('YYYY') == data[i]["anio"] ){
              this.indicador.ref18.mes_2 = (parseFloat(data[i]["nro_quejas_reclamos_respondidos"])/ (isempty(data[i]["nro_quejas_reclamos"])?1:data[i]["nro_quejas_reclamos"]))*100;
            }

           }else{
            if (data[i]["mes"]== periodo_actual && moment().format('YYYY') == data[i]["anio"] ) {
              this.indicador.ref18.mes_1 = (parseFloat(data[i]["nro_quejas_reclamos_respondidos"])/ (isempty(data[i]["nro_quejas_reclamos"])?1:data[i]["nro_quejas_reclamos"]))*100;
            }else if(data[i]["mes"]== periodo_anterior && moment().format('YYYY') == data[i]["anio"] ){
              this.indicador.ref18.mes_2 = (parseFloat(data[i]["nro_quejas_reclamos_respondidos"])/ (isempty(data[i]["nro_quejas_reclamos"])?1:data[i]["nro_quejas_reclamos"]))*100;

            }

          }
         }
      })
    },
    indicador_19(){
      let periodo_actual = ( moment().quarter() == 1 || moment().quarter() == 2 ) ? 1 : 2;
      let periodo_anterior = ( periodo_actual == 1 ) ? 2 : 1;

      let where = {},campos=["semestre","anio","total_personal","personal_con_induccion"], groupby={};
      where.semestre =['semestre','OR',1,2];
      where.anio =['anio','OR',moment().subtract(1,'years').format('YYYY'), moment().format('YYYY')];
      groupby.semestre = "semestre";
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref19',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;
         for (var i = 0; i < data.length; i++) {
           if( periodo_actual == 1){
            if (data[i]["semestre"]== periodo_actual  && moment().format('YYYY') == data[i]["anio"] ) {
              this.indicador.ref19.semestre_1 = (data[i]["personal_con_induccion"]/ data[i]["total_personal"])*100;
            }else if (data[i]["semestre"]== periodo_anterior  &&  moment().subtract(1,'years').format('YYYY') == data[i]["anio"] ){
              this.indicador.ref19.semestre_2 = (data[i]["personal_con_induccion"]/ data[i]["total_personal"])*100;
            }
           }else{

            if (data[i]["semestre"]== periodo_actual && moment().format('YYYY') == data[i]["anio"] ) {

              this.indicador.ref19.semestre_1 = (data[i]["personal_con_induccion"]/ data[i]["total_personal"])*100;
            }else if(data[i]["semestre"]== periodo_anterior && moment().format('YYYY') == data[i]["anio"] ){
              this.indicador.ref19.semestre_2 = (data[i]["personal_con_induccion"]/ data[i]["total_personal"])*100;

            }
           }

         }

      })
    },
    indicador_20(){
      let periodo_actual = (moment().quarter());
      let periodo_anterior = ( periodo_actual == 1 ) ? 4 : (moment().quarter()-1);

      let where = {},campos=["anio","trimestre","capacitaciones_ejecutadas","capacitaciones_programadas"], groupby={};
      where.trimestre =['trimestre','OR',periodo_actual,periodo_anterior];
      where.anio =['anio','OR',moment().subtract(1,'years').format('YYYY'), moment().format('YYYY')];
      groupby.trimestre = "trimestre";
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref20',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;
         for (var i = 0; i < data.length; i++) {
          if( periodo_actual == 1){
            if (data[i]["trimestre"]== periodo_actual  && moment().format('YYYY') == data[i]["anio"] ) {
              this.indicador.ref20.trimestre_1 = (data[i]["capacitaciones_ejecutadas"]/ (isempty(data[i]["capacitaciones_programadas"])?1:data[i]["capacitaciones_programadas"]))*100;
             }else if (data[i]["trimestre"]== periodo_anterior  &&  moment().subtract(1,'years').format('YYYY') == data[i]["anio"] ){
              this.indicador.ref20.trimestre_2 = (data[i]["capacitaciones_ejecutadas"]/ (isempty(data[i]["capacitaciones_programadas"])?1:data[i]["capacitaciones_programadas"]))*100;
            }
           }else{
            if (data[i]["trimestre"]== periodo_actual && moment().format('YYYY') == data[i]["anio"] ) {
              this.indicador.ref20.trimestre_1 = (data[i]["capacitaciones_ejecutadas"]/ (isempty(data[i]["capacitaciones_programadas"])?1:data[i]["capacitaciones_programadas"]))*100;
            }else if(data[i]["trimestre"]== periodo_anterior && moment().format('YYYY') == data[i]["anio"] ){
              this.indicador.ref20.trimestre_2 = (data[i]["capacitaciones_ejecutadas"]/ (isempty(data[i]["capacitaciones_programadas"])?1:data[i]["capacitaciones_programadas"]))*100;

            }
          }
         }
      })
    },
    indicador_25(){
      let periodo_actual = (moment().quarter());
      let periodo_anterior = ( periodo_actual == 1 ) ? 4 : (moment().quarter()-1);

      let where = {},campos=["anio","trimestre","avg(nota) AS promedio"], groupby={};
      where.trimestre =['trimestre','OR',periodo_actual,periodo_anterior];
      where.anio =['anio','OR',moment().subtract(1,'years').format('YYYY'), moment().format('YYYY')];
      groupby.trimestre = "trimestre";
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref25',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;
         for (var i = 0; i < data.length; i++) {
          if( periodo_actual == 1){
            if (data[i]["trimestre"]== periodo_actual  && moment().format('YYYY') == data[i]["anio"] ) {
              this.indicador.ref25.trimestre_1 = parseFloat((data[i]["promedio"])).toFixed(2);;
             }else if (data[i]["trimestre"]== periodo_anterior  &&  moment().subtract(1,'years').format('YYYY') == data[i]["anio"] ){
              this.indicador.ref25.trimestre_2 = parseFloat((data[i]["promedio"])).toFixed(2);;
            }
           }else{
            if (data[i]["trimestre"]== periodo_actual && moment().format('YYYY') == data[i]["anio"] ) {
              this.indicador.ref25.trimestre_1 =parseFloat((data[i]["promedio"])).toFixed(2);;
            }else if(data[i]["trimestre"]== periodo_anterior && moment().format('YYYY') == data[i]["anio"] ){
              this.indicador.ref25.trimestre_2 = parseFloat((data[i]["promedio"])).toFixed(2);;

            }
          }
         }
      })
    },
    indicador_28(){
      let year = (new Date()).getFullYear();
      let trimestre_actual = moment().quarter();
      let trimestre_anterior = moment().quarter()-1 > moment().quarter() ? ('(trimestre = '+(moment().quarter()-1)+' and date_format(fecha_inicio_programada,"%Y") = '+moment().subtract(1,"years").format("YYYY")+')') : ' trimestre='+(moment().quarter()-1);
      let programadas = "SELECT *, '1' AS tipo, count(trimestre) AS cantidad FROM kpi_indicador_ref28 WHERE estado=1 and date_format(fecha_inicio_programada,'%Y-%m-%d') between '"+year+"-01-01' AND '"+year+"-12-31' and (trimestre = "+moment().quarter()+" or "+trimestre_anterior+" ) group by trimestre";

      let realizadas = "SELECT *,  '2' AS tipo, count(trimestre) AS cantidad FROM kpi_indicador_ref28 WHERE ( kpi_estado_actividad = 5 OR kpi_estado_actividad=6 )  AND  estado=1 and date_format(fecha_fin_real,'%Y-%m-%d') between '"+year+"-01-01' AND '"+year+"-12-31' and ("+trimestre_anterior+" or  trimestre = "+(moment().quarter())+") group by trimestre";
      this.$http.post('cargar_datos_union?view',{consulta:realizadas, consulta_2:programadas}).then(function(response){
         let data = response.body.data;
         let realizadas=0,programadas=0;
         for (var i = 0; i < data.length; i++) {
           if (data[i]["tipo"]=="2") {
             if (data[i]["trimestre"]==moment().quarter()) {
               this.indicador.ref28.trimestre_1 = data[i]["cantidad"];
             }else{
               this.indicador.ref28.trimestre_2 = data[i]["cantidad"];
             }
           }else{
             if (data[i]["trimestre"]==moment().quarter()) {
               this.indicador.ref28.trimestre_1 = this.indicador.ref28.trimestre_1/data[i]["cantidad"];
             }else{
               this.indicador.ref28.trimestre_2 = this.indicador.ref28.trimestre_2/data[i]["cantidad"];
             }
           }
         }
      });
    },
    indicador_102(){
      let where = {},campos=["sum(turno_1) as turno_1","sum(turno_2) as turno_2"], groupby='';
      let fecha_anterior = moment().subtract(1,'days').format('YYYY-MM-DD');
      where.fecha =['date_format(fecha,"%Y-%m-%d")',fecha_anterior];

      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref102',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;

         if(data != undefined){
           let suma1 = (isempty(data[0]["turno_1"]))?0:data[0]["turno_1"];
           let suma2 = (isempty(data[0]["turno_2"]))?0:data[0]["turno_2"];
           let suma = parseFloat(suma1) + parseFloat(suma2);
           this.indicador.ref102.dia_anterior = suma;
         }

      });
      let fecha_actual = moment().format('YYYY-MM-DD');
      where.fecha =['date_format(fecha,"%Y-%m-%d")',fecha_actual];

      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref102',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;

         if(data != undefined){
           let suma1 = (isempty(data[0]["turno_1"]))?0:data[0]["turno_1"];
           let suma2 = (isempty(data[0]["turno_2"]))?0:data[0]["turno_2"];
           let suma = parseFloat(suma1) + parseFloat(suma2);
           this.indicador.ref102.dia_actual = suma;
         }

      })
    },

    indicador_104(){

      let where = {},campos=["llamadas_atendidas"], groupby='';
      let fecha_anterior = moment().subtract(1,'days').format('YYYY-MM-DD');
      where.dia =['dia',((fecha_anterior).split('-')[2])];
      where.mes =['mes',((fecha_anterior).split('-')[1])];
      where.anio =['anio',((fecha_anterior).split('-')[0])];
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref104',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data = response.body.atributos;
         this.indicador.ref104.dia_anterior = data[0]["llamadas_atendidas"];
      });
      let where2 = {},campos2=["llamadas_atendidas"], groupby2='';

      where2.dia =['mes',moment().format('MM')];
      where2.mes =['dia',moment().format('DD')];
      where2.anio =['anio',moment().format('YYYY')];
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref104',campos:campos2, where:where2, groupby:groupby2}).then(function(response){
        let data = response.body.atributos;
        this.indicador.ref104.dia_actual = data[0]["llamadas_atendidas"];
     })
    },
    indicador_105(){


      let where = {},campos=["sum(nro_atenciones) as nro_atenciones","mes", "anio"], groupby={};
      where.mes =['mes','OR',moment().format('MM'),(moment().subtract(1,'months').format('MM'))];
      where.anio =['anio',moment().format('YYYY')];
      groupby.mes = "mes";
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref105',campos:campos, where:where,groupby:groupby}).then(function(response){
        let data = response.body.atributos;

        if (data!= undefined){
          for (var i = 0; i < data.length; i++) {
            if(data[i]["mes"]==moment().format('MM')){

              this.indicador.ref105.mes_actual =  data[i]["nro_atenciones"];


            }else{
              this.indicador.ref105.mes_anterior =  data[i]["nro_atenciones"];
            }

          }
        }

      })


    },
    indicador_106(){
      let where = {},campos=["count(*) as cantidad","asistencia_entidad_json","date_format(fecha,'%Y-%m-%d') as fecha_mov"], groupby={};

      where.fecha =['date_format(fecha,"%Y-%m-%d")','BETWEEN',moment().subtract(1,'days').format('YYYY-MM-DD'),moment().format('YYYY-MM-DD')];
      groupby.fecha_ = "fecha";
      this.$http.post('cargar_datos_all_pantalla_principal?view',{tabla:'kpi_indicador_ref106',campos:campos, where:where, groupby:groupby}).then(function(response){
         let data_ = response.body.atributos;

         if(data_ != undefined){
           let acum = 0,acum2=0, entidad='', cantidad=0;

           for (var i = 0; i < data_.length; i++) {
            let data = JSON.parse(data_[i]["asistencia_entidad_json"]);
             if (moment().format("YYYY-MM-DD")==moment(data_[i]["fecha_mov"],"YYYY-MM-DD").format("YYYY-MM-DD")) {
               for (var y = 0; y < data.length; y++) {

                if(parseFloat(data[y]["cantidad"])>cantidad){
                  cantidad = parseFloat(data[y]["cantidad"]);

                  entidad = data[y]["Entidad"];
                }

               }
               this.indicador.ref106.dia_actual=cantidad + ' asistencias ' + entidad;
             }else{
               for (var x = 0; x < data.length; x++) {
                if(parseFloat(data[x]["cantidad"])>cantidad){

                  cantidad = parseFloat(data[x]["cantidad"]);
                  entidad = data[x]["Entidad"];
                }
               }

               this.indicador.ref106.dia_anterior=cantidad + ' asistencias ' + entidad;
             }

           }
         }
      })
    },
  }
})
