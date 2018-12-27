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

        nombre_residente:null,
        isLoading:false,
        mes:moment().format("MM"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false
    }),
    created:function(){
    },
    mounted:function(){
    },
    updated:function(){
    },
    methods:{
        guardar(){
            let valores = {

                Plan_Educacion: this.CarIntervencion,
                Meta_PII: this.CarDesMeta,
                Informe_Tecnico: this.CarInformeEvolutivo,
                Des_Informe: this.CarDesInfome,
                Cumple_Plan: this.CarCumplimientoPlan,
                Asistencia_Escolar: this.CarAsistenciaEscolar,
                Desenpeno: this.CarDesempeAcademico,


                id_residente: this.id_residente,
                Periodo_Mes: this.mes,
                Periodo_Anio:this.anio

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

            let word = this.nombre_residente;
            if( word.length >= 4){
                this.coincidencias = [];
                this.bloque_busqueda = true;
                this.isLoading = true;
                this.$http.post('ejecutar_consulta?view',{tabla:'', campo:'coincidencia', like:word }).then(function(response){

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
        actualizar(id){
            this.id_editado = id;
            this.coincidencias = [];
            this.bloque_busqueda = false;
            let where = {"id_residente": this.id_residente, "estado": 1}
            this.$http.post('cargar_datos_residente?view',{tabla:'CarEgresoEducacion', where:where }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarIntervencion = response.body.atributos[0]["Plan_Educacion"];
                    this.CarDesMeta = response.body.atributos[0]["Meta_PII"];
                    this.CarInformeEvolutivo = response.body.atributos[0]["Informe_Tecnico"];
                    this.CarDesInfome = response.body.atributos[0]["Des_Informe"];
                    this.CarCumplimientoPlan = response.body.atributos[0]["Cumple_Plan"];
                    this.CarAsistenciaEscolar = response.body.atributos[0]["Asistencia_Escolar"];
                    this.CarDesempeAcademico = response.body.atributos[0]["Desenpeno"];

                }
             });

        },
    }
  })
