Vue.component('ppd-datos-terapia', {
    template:'#ppd-datos-terapia',
    data:()=>({
        CarNumReeducaion:null,
        CarParticipaPsicomotricidad:null,
        CarFisioterapia:null,
        CarDeportesAdaptados:null,
        CarComunicacion:null,
        CarReeducacionOrofacial:null,
        CarTerapiaLenguaje:null,
        CarDesarrolloLenguaje:null,
        CarTipoLenguajeAlternativo:null,
        CarDesrrolloActividadesBasicas:null,
        CarInstrumentalesBasicas:null,
        CarInstrumentalesComplejas:null,
        CarIntervensionSensorial:null,
        CarSensoReceptivas:null,
        CarElavoracionOrteticos:null,
        CarAdaptacionSilla:null,
        id:null,


        lenguajes:[],

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
        this.buscar_lenguajes();
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
                Num_TMotriz: this.CarNumReeducaion,
                Num_TPsicomotricidad: this.CarParticipaPsicomotricidad,
                Num_TFisioterapia: this.CarFisioterapia,
                Num_TDeportes: this.CarDeportesAdaptados,
                Num_TComunicacion: this.CarComunicacion,
                Num_TOrofacial: this.CarReeducacionOrofacial,
                Num_TLenguaje: this.CarTerapiaLenguaje,
                Num_TLenguajeA: this.CarDesarrolloLenguaje,
                Tipo_LenguajeA: this.CarTipoLenguajeAlternativo,
                Num_TABVD: this.CarDesrrolloActividadesBasicas,
                Num_TInstrumentalesB: this.CarInstrumentalesBasicas,
                Num_TInstrumentalesC: this.CarInstrumentalesComplejas,
                Num_TSensoriales: this.CarIntervensionSensorial,
                Num_TReceptivas: this.CarSensoReceptivas,
                Num_TOrteticos: this.CarElavoracionOrteticos,
                Num_TSoillaR: this.CarAdaptacionSilla,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }

            this.$http.post('insertar_datos?view',{tabla:'CarTerapia', valores:valores}).then(function(response){

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
 this.nombre_residente=nombre + ' ' + apellido;             this.id = coincidencia.ID;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarTerapia', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarNumReeducaion = response.body.atributos[0]["NUM_TMOTRIZ"];
                    this.CarParticipaPsicomotricidad = response.body.atributos[0]["NUM_TPSICOMOTRICIDAD"];
                    this.CarFisioterapia = response.body.atributos[0]["NUM_TFISIOTERAPIA"];
                    this.CarDeportesAdaptados = response.body.atributos[0]["NUM_TDEPORTES"];
                    this.CarComunicacion = response.body.atributos[0]["NUM_TCOMUNICACION"];
                    this.CarReeducacionOrofacial = response.body.atributos[0]["NUM_TOROFACIAL"];
                    this.CarTerapiaLenguaje = response.body.atributos[0]["NUM_TLENGUAJE"];
                    this.CarDesarrolloLenguaje = response.body.atributos[0]["NUM_TLENGUAJEA"];
                    this.CarTipoLenguajeAlternativo = response.body.atributos[0]["TIPO_LENGUAJEA"];
                    this.CarDesrrolloActividadesBasicas = response.body.atributos[0]["NUM_TABVD"];
                    this.CarInstrumentalesBasicas = response.body.atributos[0]["NUM_TINSTRUMENTALESB"];
                    this.CarInstrumentalesComplejas = response.body.atributos[0]["NUM_TINSTRUMENTALESC"];
                    this.CarIntervensionSensorial = response.body.atributos[0]["NUM_TSENSORIALES"];
                    this.CarSensoReceptivas = response.body.atributos[0]["NUM_TRECEPTIVAS"];
                    this.CarElavoracionOrteticos = response.body.atributos[0]["NUM_TORTETICOS"];
                    this.CarAdaptacionSilla = response.body.atributos[0]["NUM_TSOILLAR"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];


                }
             });

        },
        buscar_lenguajes(){
            this.$http.post('buscar?view',{tabla:'pam_tipo_lenguaje_alterna'}).then(function(response){
                if( response.body.data ){
                    this.lenguajes= response.body.data;
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

            this.CarNumReeducaion = null;
            this.CarParticipaPsicomotricidad = null;
            this.CarFisioterapia = null;
            this.CarDeportesAdaptados = null;
            this.CarComunicacion = null;
            this.CarReeducacionOrofacial = null;
            this.CarTerapiaLenguaje = null;
            this.CarDesarrolloLenguaje = null;
            this.CarTipoLenguajeAlternativo = null;
            this.CarDesrrolloActividadesBasicas = null;
            this.CarInstrumentalesBasicas = null;
            this.CarInstrumentalesComplejas = null;
            this.CarIntervensionSensorial = null;
            this.CarSensoReceptivas = null;
            this.CarElavoracionOrteticos = null;
            this.CarAdaptacionSilla = null;
            this.id = null;


            this.id_residente = residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;             this.id = coincidencia.ID;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarTerapia', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarNumReeducaion = response.body.atributos[0]["NUM_TMOTRIZ"];
                    this.CarParticipaPsicomotricidad = response.body.atributos[0]["NUM_TPSICOMOTRICIDAD"];
                    this.CarFisioterapia = response.body.atributos[0]["NUM_TFISIOTERAPIA"];
                    this.CarDeportesAdaptados = response.body.atributos[0]["NUM_TDEPORTES"];
                    this.CarComunicacion = response.body.atributos[0]["NUM_TCOMUNICACION"];
                    this.CarReeducacionOrofacial = response.body.atributos[0]["NUM_TOROFACIAL"];
                    this.CarTerapiaLenguaje = response.body.atributos[0]["NUM_TLENGUAJE"];
                    this.CarDesarrolloLenguaje = response.body.atributos[0]["NUM_TLENGUAJEA"];
                    this.CarTipoLenguajeAlternativo = response.body.atributos[0]["TIPO_LENGUAJEA"];
                    this.CarDesrrolloActividadesBasicas = response.body.atributos[0]["NUM_TABVD"];
                    this.CarInstrumentalesBasicas = response.body.atributos[0]["NUM_TINSTRUMENTALESB"];
                    this.CarInstrumentalesComplejas = response.body.atributos[0]["NUM_TINSTRUMENTALESC"];
                    this.CarIntervensionSensorial = response.body.atributos[0]["NUM_TSENSORIALES"];
                    this.CarSensoReceptivas = response.body.atributos[0]["NUM_TRECEPTIVAS"];
                    this.CarElavoracionOrteticos = response.body.atributos[0]["NUM_TORTETICOS"];
                    this.CarAdaptacionSilla = response.body.atributos[0]["NUM_TSOILLAR"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];


                }
             });

        }


    }
  })
