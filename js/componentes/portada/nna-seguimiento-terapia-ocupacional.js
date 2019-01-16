Vue.component('nna-seguimiento-terapia-ocupacional', {
    template: '#nna-seguimiento-terapia-ocupacional',
    data:()=>({

        Nro_Talleres_E:null,
        Nro_Campanas:null,
        Nro_Atencion_Fisi  :null,
        Nro_Atencon_Ocupa:null,
        Nro_Atencion_Lengua:null,
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
            this.Nro_Talleres_E = null;
            this.Nro_Campanas = null;
            this.Nro_Atencion_Fisi = null;
            this.Nro_Atencon_Ocupa = null;
            this.Nro_Atencion_Lengua = null;
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

                Nro_Talleres_E:this.Nro_Talleres_E,
                Nro_Campanas:this.Nro_Campanas,
                Nro_Atencion_Fisi  :this.Nro_Atencion_Fisi,
                Nro_Atencon_Ocupa:this.Nro_Atencon_Ocupa,
                Nro_Atencion_Lengua:this.Nro_Atencion_Lengua,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }

            this.$http.post('insertar_datos?view',{tabla:'NNATerapiasOcupacionalL', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNATerapiasOcupacionalL', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Nro_Talleres_E = response.body.atributos[0]["NRO_TALLERES_E"];
                    this.Nro_Campanas = response.body.atributos[0]["NRO_CAMPANAS"];
                    this.Nro_Atencion_Fisi = response.body.atributos[0]["NRO_ATENCION_FISI"];
                    this.Nro_Atencon_Ocupa = response.body.atributos[0]["NRO_ATENCON_OCUPA"];
                    this.Nro_Atencion_Lengua = response.body.atributos[0]["NRO_ATENCION_LENGUA"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

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

            this.Nro_Talleres_E = null;
            this.Nro_Campanas = null;
            this.Nro_Atencion_Fisi = null;
            this.Nro_Atencon_Ocupa = null;
            this.Nro_Atencion_Lengua = null;
            this.id = null;

            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'NNATerapiasOcupacionalL', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Nro_Talleres_E = response.body.atributos[0]["NRO_TALLERES_E"];
                    this.Nro_Campanas = response.body.atributos[0]["NRO_CAMPANAS"];
                    this.Nro_Atencion_Fisi = response.body.atributos[0]["NRO_ATENCION_FISI"];
                    this.Nro_Atencon_Ocupa = response.body.atributos[0]["NRO_ATENCON_OCUPA"];
                    this.Nro_Atencion_Lengua = response.body.atributos[0]["NRO_ATENCION_LENGUA"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             });

        }

    }
  })
