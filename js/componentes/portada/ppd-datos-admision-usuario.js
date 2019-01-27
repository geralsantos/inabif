Vue.component('ppd-datos-admision-usuario', {
    template:'#ppd-datos-admision-usuario',
    data:()=>({
        CarMPoblacional:null,
        CarFIngreso:null,
        CarFReingreso:null,
        CarIDerivo:null,
        CarMotivoI:null,
        CarTipoDoc:null,
        CarNumDoc:null,
        id:null,

        instituciones:[],
        documentos:[],

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
        this.buscar_instituciones();
        this.buscar_tipo_documento_ingreso();
    },
    updated:function(){
    },
    methods:{
        inicializar(){
            this.CarMPoblacional = null;
            this.CarFIngreso = null;
            this.CarFReingreso = null;
            this.CarIDerivo = null;
            this.CarMotivoI = null;
            this.CarTipoDoc = null;
            this.CarNumDoc = null;
            this.id = null;

            this.instituciones=[];
            this.documentos=[];

            this.nombre_residente=null;
            this.isLoading=false;
            this.mes=moment().format("M");
            this.anio=(new Date()).getFullYear();
            this.coincidencias=[];
            this.bloque_busqueda=false;
            this.id_residente=null;
            this.modal_lista=false;
            this.pacientes = [];

            this.buscar_instituciones();
            this.buscar_tipo_documento_ingreso();
        },
        guardar(){
            if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'warning');
                return false;
            }
            let valores = {
                Mov_Poblacional: this.CarMPoblacional,
                Fecha_Ingreso:  moment(this.CarFIngreso, "YYYY-MM-DD").format("YY-MMM-DD"),
                Fecha_Reingreso:isempty(this.CarFReingreso) ? null : moment(this.CarFReingreso, "YYYY-MM-DD").format("YY-MMM-DD"),
                Institucion_derivado: this.CarIDerivo,
                Motivo_Ingreso: this.CarMotivoI,
                Tipo_Documento: this.CarTipoDoc,
                Numero_Documento: this.CarNumDoc,
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

                        }
            this.$http.post('insertar_datos?view',{tabla:'CarDatosAdmision', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarDatosAdmision', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarMPoblacional = response.body.atributos[0]["MOV_POBLACIONAL"];
                    this.CarFIngreso = moment(response.body.atributos[0]["FECHA_INGRESO"],"YY-MMM-DD").format("YYYY-MM-DD");
                    this.CarFReingreso = moment(response.body.atributos[0]["FECHA_REINGRESO"],"YY-MMM-DD").format("YYYY-MM-DD");
                    this.CarIDerivo = response.body.atributos[0]["INSTITUCION_DERIVADO"];
                    this.CarMotivoI = response.body.atributos[0]["MOTIVO_INGRESO"];
                    this.CarTipoDoc = response.body.atributos[0]["TIPO_DOCUMENTO"];
                    this.CarNumDoc = response.body.atributos[0]["NUMERO_DOCUMENTO"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             });

        },
        buscar_instituciones(){
            this.$http.post('buscar?view',{tabla:'pam_instituciones'}).then(function(response){
                if( response.body.data ){
                    this.instituciones= response.body.data;
                }

            });
        },

        buscar_tipo_documento_ingreso(){
            this.$http.post('buscar?view',{tabla:'pam_tipo_documento_ingreso '}).then(function(response){
                if( response.body.data ){
                    this.documentos= response.body.data;
                }

            });
        }, mostrar_lista_residentes(){

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

            this.CarMPoblacional = null;
            this.CarFIngreso = null;
            this.CarFReingreso = null;
            this.CarIDerivo = null;
            this.CarMotivoI = null;
            this.CarTipoDoc = null;
            this.CarNumDoc = null;
            this.id = null;

            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarDatosAdmision', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarMPoblacional = response.body.atributos[0]["MOV_POBLACIONAL"];
                    this.CarFIngreso = moment(response.body.atributos[0]["FECHA_INGRESO"],"YY-MMM-DD").format("YYYY-MM-DD");
                    this.CarFReingreso = moment(response.body.atributos[0]["FECHA_REINGRESO"],"YY-MMM-DD").format("YYYY-MM-DD");
                    this.CarIDerivo = response.body.atributos[0]["INSTITUCION_DERIVADO"];
                    this.CarMotivoI = response.body.atributos[0]["MOTIVO_INGRESO"];
                    this.CarTipoDoc = response.body.atributos[0]["TIPO_DOCUMENTO"];
                    this.CarNumDoc = response.body.atributos[0]["NUMERO_DOCUMENTO"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             });

        }
    }
  })
