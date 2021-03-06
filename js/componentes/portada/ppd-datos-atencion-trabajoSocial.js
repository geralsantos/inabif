var ppd_datos_atencion_trabajoSocial= {
    template: '#ppd-datos-atencion-trabajoSocial',
    data:()=>({
        CarVisitaF:null,
        CarNumVisitaMes:null,
        CarResinsercionF:null,
        CarFamiliaRSoporte:null,
        CarDesPersonaV:null,
        CarRDni:null,
        CarRAus:null,
        CarRConadis:null,
        id:null,

        CarTipoParentesco:null,
        CarProblematicaFam:null,

        nombre_residente:null,
        isLoading:false,
        mes:moment().format("M"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null,
        modal_lista:false,
        pacientes:[],
        parentescos:[],
        familiares:[],

    }),
    created:function(){
    },
    mounted:function(){
        this.tipo_parentesco();
        this.problematica_familiar();
    },
    updated:function(){
    },
    methods:{
        inicializar(){
            this.CarVisitaF = null;
            this.CarNumVisitaMes = null;
            this.CarResinsercionF = null;
            this.CarFamiliaRSoporte = null;
            this.CarDesPersonaV = null;
            this.CarRDni = null;
            this.CarRAus = null;
            this.CarRConadis = null;
            this.id = null;

            this.CarTipoParentesco= null;
            this.CarProblematicaFam= null;

            this.nombre_residente=null;
            this.isLoading=false;
            this.mes=moment().format("M");
            this.anio=(new Date()).getFullYear();
            this.coincidencias=[];
            this.bloque_busqueda=false;
            this.id_residente=null;
            this.modal_lista=false;
            this.pacientes = [];

            this.tipo_parentesco();
            this.problematica_familiar();
        },
        guardar(){
            if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'warning');
                return false;
            }
            let valores = {

                Visitas:this.CarVisitaF,
                Num_Visitas:this.CarNumVisitaMes,
                Reinsercion_Familiar:this.CarResinsercionF,
                Familia_RedesS:this.CarFamiliaRSoporte,
                Des_Persona_Visita:this.CarDesPersonaV,
                DNI:this.CarRDni,
                AUS:this.CarRAus,
                CONADIS:this.CarRConadis,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")
            }
            this.$http.post('insertar_datos?view',{tabla:'CarTrabajoSocial', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarTrabajoSocial', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarVisitaF = response.body.atributos[0]["VISITAS"];
                    this.CarNumVisitaMes = response.body.atributos[0]["NUM_VISITAS"];
                    this.CarResinsercionF = response.body.atributos[0]["REINSERCION_FAMILIAR"];
                    this.CarFamiliaRSoporte = response.body.atributos[0]["FAMILIA_REDESS"];
                    this.CarDesPersonaV = response.body.atributos[0]["DES_PERSONA_VISITA"];
                    this.CarRDni = response.body.atributos[0]["DNI"];
                    this.CarRAus = response.body.atributos[0]["AUS"];
                    this.CarRConadis = response.body.atributos[0]["CONADIS"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             });

        },
        tipo_parentesco(){
            this.$http.post('buscar?view',{tabla:'pam_tipo_parentesco',codigo:'ppd'}).then(function(response){
                if( response.body.data ){
                    this.parentescos= response.body.data;
                }
            });
        },
        problematica_familiar(){
            this.$http.post('buscar?view',{tabla:'Carproblematica_familiar'}).then(function(response){
                if( response.body.data ){
                    this.familiares= response.body.data;
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

            this.CarVisitaF = null;
            this.CarNumVisitaMes = null;
            this.CarResinsercionF = null;
            this.CarFamiliaRSoporte = null;
            this.CarDesPersonaV = null;
            this.CarRDni = null;
            this.CarRAus = null;
            this.CarRConadis = null;
            this.id = null;

            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarTrabajoSocial', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarVisitaF = response.body.atributos[0]["VISITAS"];
                    this.CarNumVisitaMes = response.body.atributos[0]["NUM_VISITAS"];
                    this.CarResinsercionF = response.body.atributos[0]["REINSERCION_FAMILIAR"];
                    this.CarFamiliaRSoporte = response.body.atributos[0]["FAMILIA_REDESS"];
                    this.CarDesPersonaV = response.body.atributos[0]["DES_PERSONA_VISITA"];
                    this.CarRDni = response.body.atributos[0]["DNI"];
                    this.CarRAus = response.body.atributos[0]["AUS"];
                    this.CarRConadis = response.body.atributos[0]["CONADIS"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             });

        }
    }
  }
