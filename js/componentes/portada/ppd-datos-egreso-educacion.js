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
        this.buscar_desempeno_academico();
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
                Plan_Educacion: this.CarIntervencion,
                Meta_PII: this.CarDesMeta,
                Informe_Tecnico: this.CarInformeEvolutivo,
                Des_Informe: this.CarDesInfome,
                Cumple_Plan: this.CarCumplimientoPlan,
                Asistencia_Escolar: this.CarAsistenciaEscolar,
                Desempeno: this.CarDesempeAcademico,
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
            let nombre=(coincidencia.NOMBRE==undefined)?'':coincidencia.NOMBRE;
let apellido = (coincidencia.APELLIDO==undefined)?'':coincidencia.APELLIDO;
 this.nombre_residente=nombre + ' ' + apellido;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarEgresoEducacion', residente_id:this.id_residente }).then(function(response){
                console.log(response.body);
                if( response.body.atributos != undefined){

                    this.CarIntervencion = response.body.atributos[0]["PLAN_EDUCACION"];
                    this.CarDesMeta = response.body.atributos[0]["META_PII"];
                    this.CarInformeEvolutivo = response.body.atributos[0]["INFORME_TECNICO"];
                    this.CarDesInfome = response.body.atributos[0]["DES_INFORME"];
                    this.CarCumplimientoPlan = response.body.atributos[0]["CUMPLE_PLAN"];
                    this.CarAsistenciaEscolar = response.body.atributos[0]["ASISTENCIA_ESCOLAR"];
                    this.CarDesempeAcademico = response.body.atributos[0]["DESEMPENO"];

                }
             });

        },
        buscar_desempeno_academico(){
            this.$http.post('buscar?view',{tabla:'Cardesempeno_academico'}).then(function(response){
                if( response.body.data ){
                    this.academicos= response.body.data;
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

            this.CarTipoIIEE = null;
            this.CarInsertadoLaboralmente = null;
            this.CarDesParticipacionLa = null;
            this.CarFortalecimientoHabilidades = null;
            this.CarFIActividades = null;
            this.CarFFActividades = null;
            this.CarNNAConcluyoHP = null;
            this.CarNNAFortaliceHP = null;

            this.id_residente = residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido = (residente.APELLIDO==undefined)?'':residente.APELLIDO;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarEducacionCapacidades', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarTipoIIEE = response.body.atributos[0]["TIPO_INSTITUCION"];
                    this.CarInsertadoLaboralmente = response.body.atributos[0]["INSERTADO_LABORA"];
                    this.CarDesParticipacionLa = response.body.atributos[0]["DES_LABORA"];
                    this.CarFortalecimientoHabilidades = response.body.atributos[0]["PARTICIPA_ACTIVIDADES"];
                    this.CarFIActividades = response.body.atributos[0]["FECHA_INICIONA"];
                    this.CarFFActividades = response.body.atributos[0]["FECHA_FINA"];
                    this.CarNNAConcluyoHP = response.body.atributos[0]["CULMINO_ACTIVIDADES"];
                    this.CarNNAFortaliceHP = response.body.atributos[0]["LOGRO_ACTIVIDADES"];

                }
             });

        }

    }
  })
