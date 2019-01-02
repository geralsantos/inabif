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

        nombre_residente:null,
        isLoading:false,
        mes:moment().format("M"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null


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
                swal('Error', 'Residente no existe', 'success');
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
            this.id_residente = coincidencia.ID;
            this.nombre_residente=coincidencia.NOMBRE;
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

                }
             });

        },

    }
  })
