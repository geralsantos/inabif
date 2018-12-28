Vue.component('ppd-datos-egreso-educacion', {
    template:'#ppd-datos-egreso-educacion',
    data:()=>({
        CarIntervencion:null,
        CarDesMeta:null,
        CarInformeEvolutivo:null,
        CarDesInfome:null,
        CarCumplimientoPlan:null,
        CarAsistenciaEscolar:null,
        CarDesempeAcademico:null,

        academicos: [],

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
        this.buscar_desempeno_academico();
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
                Plan_Educacion: this.CarIntervencion,
                Meta_PII: this.CarDesMeta,
                Informe_Tecnico: this.CarInformeEvolutivo,
                Des_Informe: this.CarDesInfome,
                Cumple_Plan: this.CarCumplimientoPlan,
                Asistencia_Escolar: this.CarAsistenciaEscolar,
                Desenpeno: this.CarDesempeAcademico,
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

                }
            this.$http.post('insertar_datos?view',{tabla:'CarEgresoEducacion', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarEgresoEducacion', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarIntervencion = response.body.atributos[0]["PLAN_EDUCACION"];
                    this.CarDesMeta = response.body.atributos[0]["META_PII"];
                    this.CarInformeEvolutivo = response.body.atributos[0]["INFORME_TECNICO"];
                    this.CarDesInfome = response.body.atributos[0]["DES_INFORME"];
                    this.CarCumplimientoPlan = response.body.atributos[0]["CUMPLE_PLAN"];
                    this.CarAsistenciaEscolar = response.body.atributos[0]["ASISTENCIA_ESCOLAR"];
                    this.CarDesempeAcademico = response.body.atributos[0]["DESENPENO"];

                }
             });

        },
        buscar_desempeno_academico(){
            this.$http.post('buscar?view',{tabla:''}).then(function(response){
                if( response.body.data ){
                    this.academicos= response.body.data;
                }

            });
        },

    }
  })
