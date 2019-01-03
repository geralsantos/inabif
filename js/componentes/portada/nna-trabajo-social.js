Vue.component('nna-trabajo-social', {
    template: '#nna-trabajo-social',
    data:()=>({
     
        Fase_Intervencion:null,
        Estado_Usuario:null,
        Plan_Intervencion :null,
        SituacionL_NNA:null,
        Familia_NNA :null,
        SoporteF_NNA:null,
        Des_SoporteF :null,
        Tipo_Familia :null,
        Problematica_Fami :null,
        NNA_Soporte_Fami:null,
        Familia_SISFOH :null,
        Resultado_Clasificacion :null,
        Nro_VisitasNNA :null,
        Participacion_EscuelaP :null,
        NNAOrientacionFamilia:null,
        Consegeria_Familiar:null,
        Soporte_Social:null,
        Consejeria_residente:null,
        Charlas  :null,
        Visitas_Domicilarias:null,
        Reinsercion_Familiar:null,
        DNI :null,
        AUS_SIS :null,
        CONADIS :null,
                        
        nombre_residente:null,
        isLoading:false,
        mes:moment().format("M"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null,
        modal_lista:false,
        pacientes:[]

    }),
    created:function(){
    },
    mounted:function(){
    },
    updated:function(){
    },
    methods:{
        guardar(){
            if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'warning');
                return false;
            }
            let valores = {
               
                Fase_Intervencion:this.Fase_Intervencion,
                Estado_Usuario:this.Estado_Usuario,
                Plan_Intervencion :this.Plan_Intervencion,
                SituacionL_NNA:this.SituacionL_NNA,
                Familia_NNA :this.Familia_NNA,
                SoporteF_NNA:this.SoporteF_NNA,
                Des_SoporteF :this.Des_SoporteF,
                Tipo_Familia :this.Tipo_Familia,
                Problematica_Fami :this.Problematica_Fami,
                NNA_Soporte_Fami:this.NNA_Soporte_Fami,
                Familia_SISFOH :this.Familia_SISFOH,
                Resultado_Clasificacion :this.Resultado_Clasificacion,
                Nro_VisitasNNA :this.Nro_VisitasNNA,
                Participacion_EscuelaP :this.Participacion_EscuelaP,
                Consegeria_Familiar :this.Consegeria_Familiar,
                Soporte_Social:this.Soporte_Social,
                Consejeria_Residentes:this.Consejeria_residente,
                Charlas  :this.Charlas,
                Visitas_Domicilarias:this.Visitas_Domicilarias,
                Reinsercion_Familiar:this.Reinsercion_Familiar,
                DNI :this.DNI,
                AUS_SIS :this.AUS_SIS,
                CONADIS :this.CONADIS,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                
            this.$http.post('insertar_datos?view',{tabla:'NNATrabajoSocial', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    swal('', 'Registro Guardado', 'success');

                }else{
                  swal("", "Un error ha ocurrido", "error");
                }
            });
        },
        buscar_residente(){
            this.id_residente = null;

            var word = this.nombre_residente;
            if( word.length >= 4){
                this.coincidencias = [];
                this.bloque_busqueda = true;
                this.isLoading = true;

                this.$http.post('ejecutar_consulta?view',{like:word }).then(function(response){

                    if( response.body.data != undefined){
                        this.isLoading = false;
                        this.coincidencias = response.body.data;
                    }else{
                        this.bloque_busqueda = false;
                        this.isLoading = false;
                        this.coincidencias = [];
                    }
                 });
            }else{
                this.bloque_busqueda = false;
                this.isLoading = false;
                this.coincidencias = [];
            }
        },
        actualizar(coincidencia){
            this.id_residente = coincidencia.ID;
            this.nombre_residente=coincidencia.NOMBRE;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'NNATrabajoSocial', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Fase_Intervencion = response.body.atributos[0]["FASE_INTERVENCION"];
                    this.Estado_Usuario = response.body.atributos[0]["ESTADO_USUARIO"];
                    this.Plan_Intervencion = response.body.atributos[0]["PLAN_INTERVENCION"];
                    this.SituacionL_NNA = response.body.atributos[0]["SITUACIONL_NNA"];
                    this.Familia_NNA = response.body.atributos[0]["FAMILIA_NNA"];
                    this.SoporteF_NNA = response.body.atributos[0]["SOPORTEF_NNA"];
                    this.Des_SoporteF = response.body.atributos[0]["DES_SOPORTEF"];  
                    this.Tipo_Familia = response.body.atributos[0]["TIPO_FAMILIA"];
                    this.Problematica_Fami = response.body.atributos[0]["PROBLEMATICA_FAMI"];
                    this.NNA_Soporte_Fami = response.body.atributos[0]["NNA_SOPORTE_FAMI"];
                    this.Familia_SISFOH = response.body.atributos[0]["FAMILIA_SISFOH"];
                    this.Resultado_Clasificacion = response.body.atributos[0]["RESULTADO_CLASIFICACION"];
                    this.Nro_VisitasNNA = response.body.atributos[0]["NRO_VISITASNNA"];
                    this.Participacion_EscuelaP = response.body.atributos[0]["PARTICIPACION_ESCUELAP"]; 
                    this.Consegeria_Familiar = response.body.atributos[0]["CONSEGERIA_FAMILIAR"];
                    this.Soporte_Social = response.body.atributos[0]["SOPORTE_SOCIAL"];
                    this.Consejeria_residente = response.body.atributos[0]["CONSEJERIA_RESIDENTES"];
                    this.Charlas = response.body.atributos[0]["CHARLAS"];
                    this.Visitas_Domicilarias = response.body.atributos[0]["VISITAS_DOMICILARIAS"];
                    this.Reinsercion_Familiar = response.body.atributos[0]["REINSERCION_FAMILIAR"];
                    this.DNI = response.body.atributos[0]["DNI"]; 
                    this.AUS_SIS = response.body.atributos[0]["AUS_SIS"];
                    this.CONADIS = response.body.atributos[0]["CONADIS"]; 
   
            
              

                }
             })

        },
        
    }
  })
