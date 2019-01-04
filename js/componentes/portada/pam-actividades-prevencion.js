Vue.component('pam-actividades-prevencion', {
    template:'#pam-actividades-prevencion',
    data:()=>({
        Atencion_Psicologica:null,
        Habilidades_Sociales:null,
        Nro_Participa:null,
        Taller_Autoestima:null,
        Nro_Participa_Autoestima:null,
        ManejoSituacionesDivergentes:null,
        Nro_Participa_Divergentes:null,
        Taller_Control_Emociones:null,
        Nro_Participa_Emociones:null,
        ConservacionHabilidadCognitiva:null,
        Nro_Participa_Cognitivas:null,
        Otros:null,
        Nro_Participa_Otros:null,
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
        guardar(){
            if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'warning');
                return false;
            }
            let valores = {

                Atencion_Psicologica:this.Atencion_Psicologica,
                Habilidades_Sociales:this.Habilidades_Sociales,
                Nro_Participa:this.Nro_Participa,
                Taller_Autoestima:this.Taller_Autoestima,
                Nro_Participa_Autoestima:this.Nro_Participa_Autoestima,
                ManejoSituacionesDivergentes:this.ManejoSituacionesDivergentes,
                Nro_Participa_Divergentes:this.Nro_Participa_Divergentes,
                Taller_Control_Emociones:this.Taller_Control_Emociones,
                Nro_Participa_Emociones:this.Nro_Participa_Emociones,
                ConservacionHabilidadCognitiva:this.ConservacionHabilidadCognitiva,
                Nro_Participa_Cognitivas:this.Nro_Participa_Cognitivas,
                Otros:this.Otros,
                Nro_Participa_Otros:this.Nro_Participa_Otros,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

                        }
                        console.log(valores)
            this.$http.post('insertar_datos?view',{tabla:'pam_ActividadPrevencion', valores:valores}).then(function(response){

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
            let apellido_p = (coincidencia.APELLIDO_P==undefined)?'':coincidencia.APELLIDO_P;
            let apellido_m = (coincidencia.APELLIDO_M==undefined)?'':coincidencia.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_ActividadPrevencion', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Atencion_Psicologica = response.body.atributos[0]["ATENCION_PSICOLOGICA"];
                    this.Habilidades_Sociales = response.body.atributos[0]["HABILIDADES_SOCIALES"];
                    this.Nro_Participa = response.body.atributos[0]["NRO_PARTICIPA"];
                    this.Taller_Autoestima = response.body.atributos[0]["TALLER_AUTOESTIMA"];
                    this.Nro_Participa_Autoestima = response.body.atributos[0]["NRO_PARTICIPA_AUTOESTIMA"];
                    this.ManejoSituacionesDivergentes = response.body.atributos[0]["MANEJOSITUACIONESDIVERGENTES"];
                    this.Nro_Participa_Divergentes = response.body.atributos[0]["NRO_PARTICIPA_DIVERGENTES"];
                    this.Taller_Control_Emociones = response.body.atributos[0]["TALLER_CONTROL_EMOCIONES"];
                    this.Nro_Participa_Emociones = response.body.atributos[0]["NRO_PARTICIPA_EMOCIONES"];
                    this.ConservacionHabilidadCognitiva = response.body.atributos[0]["CONSERVACIONHABILIDADCOGNITIVA"];
                    this.Nro_Participa_Cognitivas = response.body.atributos[0]["NRO_PARTICIPA_COGNITIVAS"];
                    this.Otros = response.body.atributos[0]["OTROS"];
                    this.Nro_Participa_Otros = response.body.atributos[0]["NRO_PARTICIPA_OTROS"];
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

            this.Atencion_Psicologica = null;
            this.Habilidades_Sociales = null;
            this.Nro_Participa = null;
            this.Taller_Autoestima = null;
            this.Nro_Participa_Autoestima = null;
            this.ManejoSituacionesDivergentes = null;
            this.Nro_Participa_Divergentes = null;
            this.Taller_Control_Emociones = null;
            this.Nro_Participa_Emociones = null;
            this.ConservacionHabilidadCognitiva = null;
            this.Nro_Participa_Cognitivas = null;
            this.Otros = null;
            this.Nro_Participa_Otros = null;
            this.id = null;


            this.id_residente = residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido = (residente.APELLIDO==undefined)?'':residente.APELLIDO;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_ActividadPrevencion', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Atencion_Psicologica = response.body.atributos[0]["ATENCION_PSICOLOGICA"];
                    this.Habilidades_Sociales = response.body.atributos[0]["HABILIDADES_SOCIALES"];
                    this.Nro_Participa = response.body.atributos[0]["NRO_PARTICIPA"];
                    this.Taller_Autoestima = response.body.atributos[0]["TALLER_AUTOESTIMA"];
                    this.Nro_Participa_Autoestima = response.body.atributos[0]["NRO_PARTICIPA_AUTOESTIMA"];
                    this.ManejoSituacionesDivergentes = response.body.atributos[0]["MANEJOSITUACIONESDIVERGENTES"];
                    this.Nro_Participa_Divergentes = response.body.atributos[0]["NRO_PARTICIPA_DIVERGENTES"];
                    this.Taller_Control_Emociones = response.body.atributos[0]["TALLER_CONTROL_EMOCIONES"];
                    this.Nro_Participa_Emociones = response.body.atributos[0]["NRO_PARTICIPA_EMOCIONES"];
                    this.ConservacionHabilidadCognitiva = response.body.atributos[0]["CONSERVACIONHABILIDADCOGNITIVA"];
                    this.Nro_Participa_Cognitivas = response.body.atributos[0]["NRO_PARTICIPA_COGNITIVAS"];
                    this.Otros = response.body.atributos[0]["OTROS"];
                    this.Nro_Participa_Otros = response.body.atributos[0]["NRO_PARTICIPA_OTROS"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];


                }
             });

        }

    }
  })
