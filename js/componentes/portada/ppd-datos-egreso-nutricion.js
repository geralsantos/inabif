Vue.component('ppd-datos-egreso-nutricion', {
    template:'#ppd-datos-egreso-nutricion',
    data:()=>({
        CarPlanIntervencion:null,
        CarDesMetaPII:null,
        CarInformeTecnico:null,
        CarDesInformEvolutivo:null,
        CarCumplePlan:null,
        CarEstadoNutricional:null,
        CarPeso:null,
        CarTalla:null,
        CarHemoglobina:null,

        nombre_residente:null,
        isLoading:false,
        mes:moment().format("MM"),
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
                swal('Error', 'Residente no existe', 'warning');
                return false;
            }
            let valores = {
                Plan_Nutricional:this.CarPlanIntervencion,
                Meta_PII :this.CarDesMetaPII,
                Informe_Tecnico :this.CarInformeTecnico,
                Des_Informe :this.CarDesInformEvolutivo,
                Cumple_Plan :this.CarCumplePlan,
                Estado_Nutricional :this.CarEstadoNutricional,
                Peso:this.CarPeso,
                Talla:this.CarTalla,
                Hemoglobina:this.CarHemoglobina,
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

                        }
            this.$http.post('insertar_datos?view',{tabla:'CarEgresoNutricion', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarEgresoNutricion', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){
                    this.CarPlanIntervencion = response.body.atributos[0]["PLAN_NUTRICIONAL"];
                    this.CarDesMetaPII = response.body.atributos[0]["META_PII"];
                    this.CarInformeTecnico = response.body.atributos[0]["INFORME_TECNICO"];
                    this.CarDesInformEvolutivo = response.body.atributos[0]["DES_INFORME"];
                    this.CarCumplePlan = response.body.atributos[0]["CUMPLE_PLAN"];
                    this.CarEstadoNutricional = response.body.atributos[0]["ESTADO_NUTRICIONAL"];
                    this.CarPeso = response.body.atributos[0]["PESO"];
                    this.CarTalla = response.body.atributos[0]["TALLA"];
                    this.CarHemoglobina = response.body.atributos[0]["HEMOGLOBINA"];

                }
             });

        },

    }
  })
