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
       
        nombre_residente:null,
        isLoading:false,
        mes:moment().format("MM"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null


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
                swal('Error', 'Residente no existe', 'success');
                return false;
            }
            let valores = {
                Id: 1,
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
            this.nombre_residente=coincidencia.NOMBRE;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_ActividadPrevencion', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Atencion_Psicologica = response.body.atributos[0]["Atencion_Psicologica"];
                    this.Habilidades_Sociales = response.body.atributos[0]["Habilidades_Sociales"];
                    this.Nro_Participa = response.body.atributos[0]["Nro_Participa"];
                    this.Taller_Autoestima = response.body.atributos[0]["Taller_Autoestima"];
                    this.Nro_Participa_Autoestima = response.body.atributos[0]["Nro_Participa_Autoestima"];
                    this.ManejoSituacionesDivergentes = response.body.atributos[0]["ManejoSituacionesDivergentes"];
                    this.Nro_Participa_Divergentes = response.body.atributos[0]["Nro_Participa_Divergentes"];
                    this.Taller_Control_Emociones = response.body.atributos[0]["Taller_Control_Emociones"];
                    this.Nro_Participa_Emociones = response.body.atributos[0]["Nro_Participa_Emociones"];
                    this.ConservacionHabilidadCognitiva = response.body.atributos[0]["ConservacionHabilidadCognitiva"];
                    this.Nro_Participa_Cognitivas = response.body.atributos[0]["Nro_Participa_Cognitivas"];
                    this.Otros = response.body.atributos[0]["Otros"];
                    this.Nro_Participa_Otros = response.body.atributos[0]["Nro_Participa_Otros"];


                }
             });

        },
        
    }
  })
