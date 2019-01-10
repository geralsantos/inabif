Vue.component('nna-datos-admision-residente', {
    template:'#nna-datos-admision-residente',
    data:()=>({

        Movimiento_Poblacional:null,
        Fecha_Ingreso:null,
        Fecha_Registro:null,
        Institucion_Derivacion :null,
        Motivo_Ingreso:null,
        Perfil_Ingreso_P:null,
        Perfil_Ingreso_S:null,
        Tipo_Doc  :null,
        Numero_Doc:null,
        Situacion_Legal :null,
        id:null,

        instituciones:[],
        motivosingreso:[],
        perfilesingreso1:[],
        perfilesingreso2:[],
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
        this.buscar_nna_perfiles_ingreso();
        this.buscar_instituciones();
        this.buscar_motivosingreso();
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

                Movimiento_Poblacional:this.Movimiento_Poblacional,
                Fecha_Ingreso:moment(this.Fecha_Ingreso, "YYYY-MM-DD").format("YY-MMM-DD"),
                Fecha_Registro: isempty(this.Fecha_Registro) ? null : moment(this.Fecha_Registro, "YYYY-MM-DD").format("YY-MMM-DD"),
                Institucion_Derivacion:this.Institucion_Derivacion,
                Motivo_Ingreso :this.Motivo_Ingreso,
                Perfil_Ingreso_P:this.Perfil_Ingreso_P,
                Perfil_Ingreso_S:this.Perfil_Ingreso_S,
                Tipo_Doc:this.Tipo_Doc,
                Numero_Doc:this.Numero_Doc,
                Situacion_Legal:this.Situacion_Legal,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
            console.log(valores);
            this.$http.post('insertar_datos?view',{tabla:'NNAAdmisionResidente', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNAAdmisionResidente', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Movimiento_Poblacional = response.body.atributos[0]["MOVIMIENTO_POBLACIONAL"];
                    this.Fecha_Ingreso =  moment(response.body.atributos[0]["FECHA_INGRESO"],"YY-MMM-DD").format("YYYY-MM-DD");
                    this.Fecha_Registro =  moment(response.body.atributos[0]["FECHA_REGISTRO"],"YY-MMM-DD").format("YYYY-MM-DD");
                    this.Institucion_Derivacion = response.body.atributos[0]["INSTITUCION_DERIVACION"];
                    this.Motivo_Ingreso = response.body.atributos[0]["MOTIVO_INGRESO"];
                    this.Perfil_Ingreso_P = response.body.atributos[0]["PERFIL_INGRESO_P"];
                    this.Perfil_Ingreso_S = response.body.atributos[0]["PERFIL_INGRESO_S"];
                    this.Tipo_Doc = response.body.atributos[0]["TIPO_DOC"];
                    this.Numero_Doc = response.body.atributos[0]["NUMERO_DOC"];
                    this.Situacion_Legal = response.body.atributos[0]["SITUACION_LEGAL"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             });

        },

        buscar_instituciones(){
            this.$http.post('buscar?view',{tabla:'nna_instituciones'}).then(function(response){
                if( response.body.data ){
                    this.instituciones= response.body.data;
                }

            });
        },

        buscar_motivosingreso(){
            this.$http.post('buscar?view',{tabla:'nna_motivos_ingreso'}).then(function(response){
                if( response.body.data ){
                    this.motivosingreso= response.body.data;
                }

            });
        },
        buscar_nna_perfiles_ingreso(){
            this.$http.post('buscar?view',{tabla:'nna_perfiles_ingreso'}).then(function(response){
                if( response.body.data ){
                    this.perfilesingreso1= response.body.data;
                    this.perfilesingreso2= response.body.data;
                }

            });
        },
        mostrar_lista_residentes(){

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

            this.Movimiento_Poblacional= null;
            this.Fecha_Ingreso = null;
            this.Fecha_Registro= null;
            this.Institucion_Derivacion = null;
            this.Motivo_Ingreso= null;
            this.Perfil_Ingreso_P= null;
            this.Perfil_Ingreso_S= null;
            this.Tipo_Doc  = null;
            this.Numero_Doc= null;
            this.Situacion_Legal = null;
            this.id = null;

            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'NNAAdmisionResidente', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Movimiento_Poblacional = response.body.atributos[0]["MOVIMIENTO_POBLACIONAL"];
                    this.Fecha_Ingreso =  moment(response.body.atributos[0]["FECHA_INGRESO"],"DD-MMM-YY").format("YYYY-MM-DD");
                    this.Fecha_Registro =  moment(response.body.atributos[0]["FECHA_REGISTRO"],"DD-MMM-YY").format("YYYY-MM-DD");
                    this.Institucion_Derivacion = response.body.atributos[0]["INSTITUCION_DERIVACION"];
                    this.Motivo_Ingreso = response.body.atributos[0]["MOTIVO_INGRESO"];
                    this.Perfil_Ingreso_P = response.body.atributos[0]["PERFIL_INGRESO_P"];
                    this.Perfil_Ingreso_S = response.body.atributos[0]["PERFIL_INGRESO_S"];
                    this.Tipo_Doc = response.body.atributos[0]["TIPO_DOC"];
                    this.Numero_Doc = response.body.atributos[0]["NUMERO_DOC"];
                    this.Situacion_Legal = response.body.atributos[0]["SITUACION_LEGAL"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];


                }
             });

        }
    }
  })
