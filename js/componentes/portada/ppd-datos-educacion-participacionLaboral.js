Vue.component('ppd-datos-educacion-participacionLaboral', {
    template: '#ppd-datos-educacion-participacionLaboral',
    data:()=>({
        CarTipoIIEE:null,
        CarInsertadoLaboralmente:null,
        CarDesParticipacionLa:null,
        CarFortalecimientoHabilidades:null,
        CarFIActividades:null,
        CarFFActividades:null,
        CarNNAConcluyoHP:null,
        CarNNAFortaliceHP:null,
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
        console.log(this.CarFIActividades)
    },
    methods:{
        inicializar(){
            this.CarTipoIIEE = null;
            this.CarInsertadoLaboralmente = null;
            this.CarDesParticipacionLa = null;
            this.CarFortalecimientoHabilidades = null;
            this.CarFIActividades = null;
            this.CarFFActividades = null;
            this.CarNNAConcluyoHP = null;
            this.CarNNAFortaliceHP = null;
            this.id = null;

            this.nombre_residente=null;
            this.isLoading=false;
            this.mes=moment().format("M");
            this.anio=(new Date()).getFullYear();
            this.coincidencias=[];
            this.bloque_busqueda=false;
            this.id_residente=null;
            this.modal_lista=false;
            this.pacientes = [];
        },
        guardar(){
            if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'warning');
                return false;
            }
            let valores = {
                Tipo_Institucion:this.CarTipoIIEE,
                Insertado_labora:this.CarInsertadoLaboralmente,
                Des_labora:this.CarDesParticipacionLa,
                Participa_Actividades:this.CarFortalecimientoHabilidades,
                Fecha_InicionA: (isempty(this.CarFIActividades)?null:moment(this.CarFIActividades,"YYYY-MM-DD").format("YY-MMM-DD")),
                Fecha_FinA: (isempty(this.CarFFActividades)?null:moment(this.CarFFActividades,"YYYY-MM-DD").format("YY-MMM-DD")),
                Culmino_Actividades:this.CarNNAConcluyoHP,
                Logro_Actividades:this.CarNNAFortaliceHP,
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")
                        }
                        console.log(valores);
            this.$http.post('insertar_datos?view',{tabla:'CarEducacionCapacidades', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    this.inicializar();
                    swal('', 'Registro Guardado', 'success');

                }else{
                  swal("", "Un error ha ocurrido", "error");
                }
            });
        },
        buscar_residente(){
            this.id_residente = null;

            var word = this.nombre_residente;
            if( word.length >= 2){
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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarEducacionCapacidades', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){
                    this.CarTipoIIEE = response.body.atributos[0]["TIPO_INSTITUCION"];
                    this.CarInsertadoLaboralmente = response.body.atributos[0]["INSERTADO_LABORA"];
                    this.CarDesParticipacionLa = response.body.atributos[0]["DES_LABORA"];
                    this.CarFortalecimientoHabilidades = response.body.atributos[0]["PARTICIPA_ACTIVIDADES"];
                    this.CarFIActividades = (isempty(response.body.atributos[0]["FECHA_INICIONA"])?null:moment(response.body.atributos[0]["FECHA_INICIONA"], "DD-MMM-YY").format("YYYY-MM-DD"));
                    this.CarFFActividades = (isempty(response.body.atributos[0]["FECHA_FINA"])?null:moment(response.body.atributos[0]["FECHA_FINA"], "DD-MMM-YY").format("YYYY-MM-DD"));
                    this.CarNNAConcluyoHP = response.body.atributos[0]["CULMINO_ACTIVIDADES"];
                    this.CarNNAFortaliceHP = response.body.atributos[0]["LOGRO_ACTIVIDADES"];
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

            this.CarTipoIIEE = null;
            this.CarInsertadoLaboralmente = null;
            this.CarDesParticipacionLa = null;
            this.CarFortalecimientoHabilidades = null;
            this.CarFIActividades = null;
            this.CarFFActividades = null;
            this.CarNNAConcluyoHP = null;
            this.CarNNAFortaliceHP = null;
            this.id = null;

            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarEducacionCapacidades', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarTipoIIEE = response.body.atributos[0]["TIPO_INSTITUCION"];
                    this.CarInsertadoLaboralmente = response.body.atributos[0]["INSERTADO_LABORA"];
                    this.CarDesParticipacionLa = response.body.atributos[0]["DES_LABORA"];
                    this.CarFortalecimientoHabilidades = response.body.atributos[0]["PARTICIPA_ACTIVIDADES"];
                    this.CarFIActividades = (isempty(response.body.atributos[0]["FECHA_INICIONA"])?null:moment(response.body.atributos[0]["FECHA_INICIONA"], "DD-MMM-YY").format("DD-MM-YYYY"));
                    this.CarFFActividades = (isempty(response.body.atributos[0]["FECHA_FINA"])?null:moment(response.body.atributos[0]["FECHA_FINA"], "DD-MMM-YY").format("DD-MM-YYYY"));
                    this.CarNNAConcluyoHP = response.body.atributos[0]["CULMINO_ACTIVIDADES"];
                    this.CarNNAFortaliceHP = response.body.atributos[0]["LOGRO_ACTIVIDADES"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];
                    console.log(response.body.atributos[0]["FECHA_INICIONA"]);
                    console.log(this.CarFIActividades);
                }
             });

        }
    }
  })
