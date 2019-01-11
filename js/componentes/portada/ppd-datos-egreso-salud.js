Vue.component('ppd-datos-egreso-salud', {
    template:'#ppd-datos-egreso-salud',
    data:()=>({
        CarPlanIntervencion:null,
        CarDesMetaPII:null,
        CarInformeTecnico:null,
        CarDesInforme:null,
        CarCumplePlan:null,
        CarEnfermedadesCronicas:null,
        CarEspecificarEnfermedad:null,
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
    },
    methods:{
        inicializar(){
            this.CarPlanIntervencion = null;
            this.CarDesMetaPII = null;
            this.CarInformeTecnico = null;
            this.CarDesInforme = null;
            this.CarCumplePlan = null;
            this.CarEnfermedadesCronicas = null;
            this.CarEspecificarEnfermedad = null;
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
                Plan_Medico: this.CarPlanIntervencion,
                Meta_PII: this.CarDesMetaPII,
                Informe_Tecnico: this.CarInformeTecnico,
                Des_Informe: this.CarDesInforme,
                Cumple_Plan: this.CarCumplePlan,
                Enfermedades_Cronicas: this.CarEnfermedadesCronicas,
                Especificar: this.CarEspecificarEnfermedad,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }

            this.$http.post('insertar_datos?view',{tabla:'CarEgresoSalud', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarEgresoSalud', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarPlanIntervencion = response.body.atributos[0]["PLAN_MEDICO"];
                    this.CarDesMetaPII = response.body.atributos[0]["META_PII"];
                    this.CarInformeTecnico = response.body.atributos[0]["INFORME_TECNICO"];
                    this.CarDesInforme = response.body.atributos[0]["DES_INFORME"];
                    this.CarCumplePlan = response.body.atributos[0]["CUMPLE_PLAN"];
                    this.CarEnfermedadesCronicas = response.body.atributos[0]["ENFERMEDADES_CRONICAS"];
                    this.CarEspecificarEnfermedad = response.body.atributos[0]["ESPECIFICAR"];
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

            this.CarPlanIntervencion = null;
            this.CarDesMetaPII = null;
            this.CarInformeTecnico = null;
            this.CarDesInforme = null;
            this.CarCumplePlan = null;
            this.CarEnfermedadesCronicas = null;
            this.CarEspecificarEnfermedad = null;
            this.id = null;


            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarEgresoSalud', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarPlanIntervencion = response.body.atributos[0]["PLAN_MEDICO"];
                    this.CarDesMetaPII = response.body.atributos[0]["META_PII"];
                    this.CarInformeTecnico = response.body.atributos[0]["INFORME_TECNICO"];
                    this.CarDesInforme = response.body.atributos[0]["DES_INFORME"];
                    this.CarCumplePlan = response.body.atributos[0]["CUMPLE_PLAN"];
                    this.CarEnfermedadesCronicas = response.body.atributos[0]["ENFERMEDADES_CRONICAS"];
                    this.CarEspecificarEnfermedad = response.body.atributos[0]["ESPECIFICAR"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];


                }
             });

        }

    }
  })
