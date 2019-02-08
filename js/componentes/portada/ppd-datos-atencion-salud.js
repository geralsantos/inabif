var ppd_datos_atencion_salud= {
    template: '#ppd-datos-atencion-salud',
    data:()=>({
        CarNumAtencionesMG:null,
        CarSalidaMes:null,
        CarNunSalidas:null,
        CarNumACardiovascular:null,
        CarANefrologia:null,
        CarAOncologia:null,
        CarANeurocirugia:null,
        CarNumDermatologia:null,
        CarAEncornologia:null,
        CarAGastroenterologia:null,
        CarAGinecoObstretica:null,
        CarAInfectoContagiosas:null,
        CarACardiovascular:null,
        CarAInmunologia:null,
        CarAMedicinaFisica:null,
        CarANeumologia:null,
        CarAnutricion:null,
        CarANeurologia:null,
        CarAOftamologia:null,
        CarAOtorrinoloringologia:null,
        CarAPedriatria:null,
        CarAPsiquiatria:null,
        CarAQuirurgica:null,
        CarATraumologia:null,
        CarAUrologia:null,
        CarAOdontologia:null,
        CarAServicios:null,
        CarTratamientoPsicofarmaco:null,
        CarHopitalizadoP:null,
        CarNumHospitalizaciones:null,
        CarMotivoHospitalizacion:null,
        CarAEndocrinologia :null,
        CarAHematologia:null,
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
            this.CarNumAtencionesMG = null;
            this.CarSalidaMes = null;
            this.CarNunSalidas = null;
            this.CarNumACardiovascular = null;
            this.CarANefrologia = null;
            this.CarAOncologia = null;
            this.CarANeurocirugia = null;
            this.CarNumDermatologia = null;
            this.CarAEndocrinologia = null;
            this.CarAGastroenterologia = null;
            this.CarAGinecoObstretica = null;
            this.CarAInfectoContagiosas = null;
            this.CarAHematologia = null;
            this.CarAInmunologia = null;
            this.CarAMedicinaFisica = null;
            this.CarANeumologia = null;
            this.CarAnutricion = null;
            this.CarANeurologia = null;
            this.CarAOftamologia = null;
            this.CarAOtorrinoloringologia = null;
            this.CarAPedriatria = null;
            this.CarAPsiquiatria = null;
            this.CarAQuirurgica = null;
            this.CarATraumologia = null;
            this.CarAUrologia = null;
            this.CarAOdontologia = null;
            this.CarAServicios = null;
            this.CarTratamientoPsicofarmaco = null;
            this.CarHopitalizadoP = null;
            this.CarNumHospitalizaciones = null;
            this.CarMotivoHospitalizacion = null;
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


                Num_MedicinaG:this.CarNumAtencionesMG,
                Salida_Hospitales:this.CarSalidaMes,
                NumSalidasHospital:this.CarNunSalidas,
                Num_Cardiovascular:this.CarNumACardiovascular,
                Num_Nefrologia:this.CarANefrologia,
                Num_Oncologia:this.CarAOncologia,
                Num_Neurocirugia:this.CarANeurocirugia,
                Num_Dermatologia:this.CarNumDermatologia,
                Num_Endocrinologia:this.CarAEndocrinologia,
                Num_Gastroenterologia:this.CarAGastroenterologia,
                Num_Gineco_Obsterica:this.CarAGinecoObstretica,
                Num_Infec_contagiosa:this.CarAInfectoContagiosas,
                Num_Hematologia:this.CarAHematologia,
                Num_Inmunologia:this.CarAInmunologia,
                Num_Medicina_fisica:this.CarAMedicinaFisica,
                Num_Neumologia:this.CarANeumologia,
                Num_Nutricion:this.CarAnutricion,
                Num_Neurologia:this.CarANeurologia,
                Num_Oftalmologia:this.CarAOftamologia,
                Num_Otorrinolarinlogia:this.CarAOtorrinoloringologia,
                Num_Pedriatria:this.CarAPedriatria,
                Num_Psiquiatria:this.CarAPsiquiatria,
                Num_Quirurgica:this.CarAQuirurgica,
                Num_Traumologia:this.CarATraumologia,
                Num_Urologia:this.CarAUrologia,
                Num_Odontologia:this.CarAOdontologia,
                Num_Otro:this.CarAServicios,
                Tratamiento_Psicofarmaco:this.CarTratamientoPsicofarmaco,
                Hopitalizado_Periodo:this.CarHopitalizadoP,
                Numero_Hospitalizaciones:this.CarNumHospitalizaciones,
                MotivoHospitalizacion:this.CarMotivoHospitalizacion,
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")
                        }
            this.$http.post('insertar_datos?view',{tabla:'CarAtencionSalud', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarAtencionSalud', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarNumAtencionesMG = response.body.atributos[0]["NUM_MEDICINAG"];
                    this.CarSalidaMes = response.body.atributos[0]["SALIDA_HOSPITALES"];
                    this.CarNunSalidas = response.body.atributos[0]["NUM_SALIDASHOSPITALES"];
                    this.CarNumACardiovascular = response.body.atributos[0]["NUM_CARDIOVASCULAR"];
                    this.CarANefrologia = response.body.atributos[0]["NUM_NEFROLOGIA"];
                    this.CarAOncologia = response.body.atributos[0]["NUM_ONCOLOGIA"];
                    this.CarANeurocirugia = response.body.atributos[0]["NUM_NEUROCIRUGIA"];
                    this.CarNumDermatologia = response.body.atributos[0]["NUM_DERMATOLOGIA"];
                    this.CarAEndocrinologia = response.body.atributos[0]["NUM_ENDOCRINOLOGIA"];
                    this.CarAGastroenterologia = response.body.atributos[0]["NUM_GASTROENTEROLOGIA"];
                    this.CarAGinecoObstretica = response.body.atributos[0]["NUM_GINECO_OBSTERICA"];
                    this.CarAInfectoContagiosas = response.body.atributos[0]["Num_Infec_contagiosa"];
                    this.CarAHematologia = response.body.atributos[0]["NUM_HEMATOLOGIA"];
                    this.CarAInmunologia = response.body.atributos[0]["NUM_INMUNOLOGIA"];
                    this.CarAMedicinaFisica = response.body.atributos[0]["NUM_MEDICINA_FISICA"];
                    this.CarANeumologia = response.body.atributos[0]["NUM_NEUMOLOGIA"];
                    this.CarAnutricion = response.body.atributos[0]["NUM_NUTRICION"];
                    this.CarANeurologia = response.body.atributos[0]["NUM_NEUROLOGIA"];
                    this.CarAOftamologia = response.body.atributos[0]["NUM_OFTALMOLOGIA"];
                    this.CarAOtorrinoloringologia = response.body.atributos[0]["NUM_OTORRINOLARINLOGIA"];
                    this.CarAPedriatria = response.body.atributos[0]["NUM_PEDRIATRIA"];
                    this.CarAPsiquiatria = response.body.atributos[0]["NUM_PSIQUIATRIA"];
                    this.CarAQuirurgica = response.body.atributos[0]["NUM_QUIRURGICA"];
                    this.CarATraumologia = response.body.atributos[0]["NUM_TRAUMOLOGIA"];
                    this.CarAUrologia = response.body.atributos[0]["NUM_UROLOGIA"];
                    this.CarAOdontologia = response.body.atributos[0]["NUM_ODONTOLOGIA"];
                    this.CarAServicios = response.body.atributos[0]["NUM_OTRO"];
                    this.CarTratamientoPsicofarmaco = response.body.atributos[0]["TRATAMIENTO_PSICOFARMACO"];
                    this.CarHopitalizadoP = response.body.atributos[0]["HOPITALIZADO_PERIODO"];
                    this.CarNumHospitalizaciones = response.body.atributos[0]["NUMERO_HOSPITALIZACIONES"];
                    this.CarMotivoHospitalizacion = response.body.atributos[0]["MOTIVO_HOSPITALIZACION"];
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

            this.CarNumAtencionesMG = null;
            this.CarSalidaMes = null;
            this.CarNunSalidas = null;
            this.CarNumACardiovascular = null;
            this.CarANefrologia = null;
            this.CarAOncologia = null;
            this.CarANeurocirugia = null;
            this.CarNumDermatologia = null;
            this.CarAEndocrinologia = null;
            this.CarAGastroenterologia = null;
            this.CarAGinecoObstretica = null;
            this.CarAInfectoContagiosas = null;
            this.CarAHematologia = null;
            this.CarAInmunologia = null;
            this.CarAMedicinaFisica = null;
            this.CarANeumologia = null;
            this.CarAnutricion = null;
            this.CarANeurologia = null;
            this.CarAOftamologia = null;
            this.CarAOtorrinoloringologia = null;
            this.CarAPedriatria = null;
            this.CarAPsiquiatria = null;
            this.CarAQuirurgica = null;
            this.CarATraumologia = null;
            this.CarAUrologia = null;
            this.CarAOdontologia = null;
            this.CarAServicios = null;
            this.CarTratamientoPsicofarmaco = null;
            this.CarHopitalizadoP = null;
            this.CarNumHospitalizaciones = null;
            this.CarMotivoHospitalizacion = null;
            this.id = null;

            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarAtencionSalud', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarNumAtencionesMG = response.body.atributos[0]["NUM_MEDICINAG"];
                    this.CarSalidaMes = response.body.atributos[0]["SALIDA_HOSPITALES"];
                    this.CarNunSalidas = response.body.atributos[0]["NUM_SALIDASHOSPITALES"];
                    this.CarNumACardiovascular = response.body.atributos[0]["NUM_CARDIOVASCULAR"];
                    this.CarANefrologia = response.body.atributos[0]["NUM_NEFROLOGIA"];
                    this.CarAOncologia = response.body.atributos[0]["NUM_ONCOLOGIA"];
                    this.CarANeurocirugia = response.body.atributos[0]["NUM_NEUROCIRUGIA"];
                    this.CarNumDermatologia = response.body.atributos[0]["NUM_DERMATOLOGIA"];
                    this.CarAEndocrinologia = response.body.atributos[0]["NUM_ENDOCRINOLOGIA"];
                    this.CarAGastroenterologia = response.body.atributos[0]["NUM_GASTROENTEROLOGIA"];
                    this.CarAGinecoObstretica = response.body.atributos[0]["NUM_GINECO_OBSTERICA"];
                    this.CarAInfectoContagiosas = response.body.atributos[0]["Num_Infec_contagiosa"];
                    this.CarAHematologia = response.body.atributos[0]["NUM_HEMATOLOGIA"];
                    this.CarAInmunologia = response.body.atributos[0]["NUM_INMUNOLOGIA"];
                    this.CarAMedicinaFisica = response.body.atributos[0]["NUM_MEDICINA_FISICA"];
                    this.CarANeumologia = response.body.atributos[0]["NUM_NEUMOLOGIA"];
                    this.CarAnutricion = response.body.atributos[0]["NUM_NUTRICION"];
                    this.CarANeurologia = response.body.atributos[0]["NUM_NEUROLOGIA"];
                    this.CarAOftamologia = response.body.atributos[0]["NUM_OFTALMOLOGIA"];
                    this.CarAOtorrinoloringologia = response.body.atributos[0]["NUM_OTORRINOLARINLOGIA"];
                    this.CarAPedriatria = response.body.atributos[0]["NUM_PEDRIATRIA"];
                    this.CarAPsiquiatria = response.body.atributos[0]["NUM_PSIQUIATRIA"];
                    this.CarAQuirurgica = response.body.atributos[0]["NUM_QUIRURGICA"];
                    this.CarATraumologia = response.body.atributos[0]["NUM_TRAUMOLOGIA"];
                    this.CarAUrologia = response.body.atributos[0]["NUM_UROLOGIA"];
                    this.CarAOdontologia = response.body.atributos[0]["NUM_ODONTOLOGIA"];
                    this.CarAServicios = response.body.atributos[0]["NUM_OTRO"];
                    this.CarTratamientoPsicofarmaco = response.body.atributos[0]["TRATAMIENTO_PSICOFARMACO"];
                    this.CarHopitalizadoP = response.body.atributos[0]["HOPITALIZADO_PERIODO"];
                    this.CarNumHospitalizaciones = response.body.atributos[0]["NUMERO_HOSPITALIZACIONES"];
                    this.CarMotivoHospitalizacion = response.body.atributos[0]["MOTIVO_HOSPITALIZACION"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             });

        }
    }
  }
