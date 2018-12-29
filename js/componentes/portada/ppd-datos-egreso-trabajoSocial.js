Vue.component('ppd-datos-egreso-trabajoSocial', {
    template:'#ppd-datos-egreso-trabajoSocial',
    data:()=>({
        CarIntervencionNutricional:null,
        CarDesMetaPII:null,
        CarInformeEvolutivo:null,
        CarDesInforme:null,
        CarCumplePlan:null,
        CarUbicacionFamilia:null,
        CarParticipacionfamilia:null,
        CarPosibilidadReinsercion:null,
        CarColocacionLaboral:null,

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
                swal('Error', 'Residente no existe', 'success');
                return false;
            }
            let valores = {
                Plan_Social: this.CarIntervencionNutricional,
                Meta_PII: this.CarDesMetaPII,
                Informe_Tecnico: this.CarInformeEvolutivo,
                Des_Informe: this.CarDesInforme,
                Cumple_Plan: this.CarCumplePlan,
                Ubicacion_Familia: this.CarUbicacionFamilia,
                Participacion_Familia: this.CarParticipacionfamilia,
                Reinsercion: this.CarPosibilidadReinsercion,
                Colocacion_Laboral: this.CarColocacionLaboral,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")



            }

            this.$http.post('insertar_datos?view',{tabla:'CarEgresoTrabajoSocial', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarEgresoTrabajoSocial', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarIntervencionNutricional = response.body.atributos[0]["PLAN_SOCIAL"];
                    this.CarDesMetaPII = response.body.atributos[0]["META_PII"];
                    this.CarInformeEvolutivo = response.body.atributos[0]["INFORME_TECNICO"];
                    this.CarDesInforme = response.body.atributos[0]["DES_INFORME"];
                    this.CarCumplePlan = response.body.atributos[0]["CUMPLE_PLAN"];
                    this.CarUbicacionFamilia = response.body.atributos[0]["UBICACION_FAMILIA"];
                    this.CarParticipacionfamilia = response.body.atributos[0]["PARTICIPACION_FAMILIA"];
                    this.CarPosibilidadReinsercion = response.body.atributos[0]["REINSERCION"];
                    this.CarColocacionLaboral = response.body.atributos[0]["COLOCACION_LABORAL"];

                }
             });

        },

    }
  })
