Vue.component('ppd-datos-egreso-terapiaFisica', {
    template:'#ppd-datos-egreso-terapiaFisica',
    data:()=>({
        CarPlanIntervension:null,
        CarDesMetaPII:null,
        CarinformeEvolutivo:null,
        CarDesInformeEvolutivo:null,
        CarCumplePlan:null,
        CarDesarrolloCapacidades:null,
        CarMejoraEmision:null,
        CarManejoLenguaje:null,
        CarElavoraOraciones:null,
        id:null,


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
                Plan_Medico: this.CarPlanIntervension,
                Meta_PII: this.CarDesMetaPII,
                Informe_Tecnico: this.CarinformeEvolutivo,
                Des_Informe: this.CarDesInformeEvolutivo,
                Cumple_Plan: this.CarCumplePlan,
                Desarrollo_Lenguaje: this.CarDesarrolloCapacidades,
                Mejora_Fonema: this.CarMejoraEmision,
                Mejora_Comprensivo: this.CarManejoLenguaje,
                Elabora_Oraciones: this.CarElavoraOraciones,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

                }

            this.$http.post('insertar_datos?view',{tabla:'CarTerapiaFisica', valores:valores}).then(function(response){

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
            this.id_residente = coincidencia.ID;               this.id=coincidencia.ID;
            let nombre=(coincidencia.NOMBRE==undefined)?'':coincidencia.NOMBRE;
            let apellido_p = (coincidencia.APELLIDO_P==undefined)?'':coincidencia.APELLIDO_P;
            let apellido_m = (coincidencia.APELLIDO_M==undefined)?'':coincidencia.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarTerapiaFisica', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarPlanIntervension = response.body.atributos[0]["PLAN_MEDICO"];
                    this.CarDesMetaPII = response.body.atributos[0]["META_PII"];
                    this.CarinformeEvolutivo = response.body.atributos[0]["INFORME_TECNICO"];
                    this.CarDesInformeEvolutivo = response.body.atributos[0]["DES_INFORME"];
                    this.CarCumplePlan = response.body.atributos[0]["CUMPLE_PLAN"];
                    this.CarDesarrolloCapacidades = response.body.atributos[0]["DESARROLLO_LENGUAJE"];
                    this.CarMejoraEmision = response.body.atributos[0]["MEJORA_FONEMA"];
                    this.CarManejoLenguaje = response.body.atributos[0]["MEJORA_COMPRENSIVO"];
                    this.CarElavoraOraciones = response.body.atributos[0]["ELABORA_ORACIONES"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             });

        },mostrar_lista_residentes(){

            this.id_residente = null;
            this.isLoading = true;
                this.$http.post('ejecutar_consulta_lista?view',{}).then(function(response){

                    if( response.body.data != undefined){
                        this.modal_lista = true;
                        this.isLoading = false;
                        this.pacientes = response.body.data;
                    }else{
                        swal("", "No existe ningún residente", "error")
                    }
                 });

        },
        elegir_residente(residente){

            this.CarPlanIntervension = null;
            this.CarDesMetaPII = null;
            this.CarinformeEvolutivo = null;
            this.CarDesInformeEvolutivo = null;
            this.CarCumplePlan = null;
            this.CarDesarrolloCapacidades = null;
            this.CarMejoraEmision = null;
            this.CarManejoLenguaje = null;
            this.CarElavoraOraciones = null;
            this.id = null;


            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarTerapiaFisica', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarPlanIntervension = response.body.atributos[0]["PLAN_MEDICO"];
                    this.CarDesMetaPII = response.body.atributos[0]["META_PII"];
                    this.CarinformeEvolutivo = response.body.atributos[0]["INFORME_TECNICO"];
                    this.CarDesInformeEvolutivo = response.body.atributos[0]["DES_INFORME"];
                    this.CarCumplePlan = response.body.atributos[0]["CUMPLE_PLAN"];
                    this.CarDesarrolloCapacidades = response.body.atributos[0]["DESARROLLO_LENGUAJE"];
                    this.CarMejoraEmision = response.body.atributos[0]["MEJORA_FONEMA"];
                    this.CarManejoLenguaje = response.body.atributos[0]["MEJORA_COMPRENSIVO"];
                    this.CarElavoraOraciones = response.body.atributos[0]["ELABORA_ORACIONES"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             });

        }

    }
  })
