var nna_seguimientos_trabajo_social ={
    template: '#nna-seguimientos-trabajo-social',
    data:()=>({

        Plan_Intervencion:null,
        Meta_PAI :null,
        Informe_Tecnico :null,
        Cumple_Intervencion:null,
        ParticipacionF_Activa:null,
        Reinsercion_Familiar:null,
        FamiliaR_Soporte:null,
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
            this.Plan_Intervencion = null;
            this.Meta_PAI = null;
            this.Informe_Tecnico = null;
            this.Cumple_Intervencion = null;
            this.ParticipacionF_Activa = null;
            this.Reinsercion_Familiar = null;
            this.FamiliaR_Soporte = null;
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

                Plan_Intervencion:this.Plan_Intervencion,
                Meta_PAI :this.Meta_PAI,
                Informe_Tecnico :this.Informe_Tecnico,
                Cumple_Intervencion:this.Cumple_Intervencion,
                ParticipacionF_Activa:this.ParticipacionF_Activa,
                Reinsercion_Familiar:this.Reinsercion_Familiar,
                FamiliaR_Soporte:this.FamiliaR_Soporte,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }

            this.$http.post('insertar_datos?view',{tabla:'NNAtrabajoSocial_Semestral', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNAtrabajoSocial_Semestral', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Plan_Intervencion = response.body.atributos[0]["PLAN_INTERVENCION"];
                    this.Meta_PAI = response.body.atributos[0]["META_PAI"];
                    this.Informe_Tecnico = response.body.atributos[0]["INFORME_TECNICO"];
                    this.Cumple_Intervencion = response.body.atributos[0]["CUMPLE_INTERVENCION"];
                    this.ParticipacionF_Activa = response.body.atributos[0]["PARTICIPACIONF_ACTIVA"];
                    this.Reinsercion_Familiar = response.body.atributos[0]["REINSERCION_FAMILIAR"];
                    this.FamiliaR_Soporte = response.body.atributos[0]["FAMILIAR_SOPORTE"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             })

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

            this.Plan_Intervencion = null;
            this.Meta_PAI = null;
            this.Informe_Tecnico = null;
            this.Cumple_Intervencion = null;
            this.ParticipacionF_Activa = null;
            this.Reinsercion_Familiar = null;
            this.FamiliaR_Soporte = null;
            this.id = null;

            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'NNAtrabajoSocial_Semestral', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Plan_Intervencion = response.body.atributos[0]["PLAN_INTERVENCION"];
                    this.Meta_PAI = response.body.atributos[0]["META_PAI"];
                    this.Informe_Tecnico = response.body.atributos[0]["INFORME_TECNICO"];
                    this.Cumple_Intervencion = response.body.atributos[0]["CUMPLE_INTERVENCION"];
                    this.ParticipacionF_Activa = response.body.atributos[0]["PARTICIPACIONF_ACTIVA"];
                    this.Reinsercion_Familiar = response.body.atributos[0]["REINSERCION_FAMILIAR"];
                    this.FamiliaR_Soporte = response.body.atributos[0]["FAMILIAR_SOPORTE"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             })

        }

    }
  }
