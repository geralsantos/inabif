Vue.component('ppd-datos-admision-usuario', {
    template:'#ppd-datos-admision-usuario',
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

        lenguajes:[],

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
        //this.buscar_lenguajes();
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
                Terapia_Id: 1,
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
            this.nombre_residente=coincidencia.NOMBRE;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarTerapia', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarNumReeducaion = response.body.atributos[0]["Num_TMotriz"];
                    this.CarParticipaPsicomotricidad = response.body.atributos[0]["Num_TPsicomotricidad"];
                    this.CarFisioterapia = response.body.atributos[0]["Num_TFisioterapia"];
                    this.CarDeportesAdaptados = response.body.atributos[0]["Num_TDeportes"];
                    this.CarComunicacion = response.body.atributos[0]["Num_TComunicacion"];
                    this.CarReeducacionOrofacial = response.body.atributos[0]["Num_TOrofacial"];
                    this.CarTerapiaLenguaje = response.body.atributos[0]["Num_TLenguaje"];
                    this.CarDesarrolloLenguaje = response.body.atributos[0]["Num_TLenguajeA"];
                    this.CarTipoLenguajeAlternativo = response.body.atributos[0]["Tipo_LenguajeA"];
                    this.CarDesrrolloActividadesBasicas = response.body.atributos[0]["Num_TABVD"];
                    this.CarInstrumentalesBasicas = response.body.atributos[0]["Num_TInstrumentalesB"];
                    this.CarInstrumentalesComplejas = response.body.atributos[0]["Num_TInstrumentalesC"];
                    this.CarIntervensionSensorial = response.body.atributos[0]["Num_TSensoriales"];
                    this.CarSensoReceptivas = response.body.atributos[0]["Num_TReceptivas"];
                    this.CarElavoracionOrteticos = response.body.atributos[0]["Num_TOrteticos"];
                    this.CarAdaptacionSilla = response.body.atributos[0]["Num_TSoillaR"];


                }
             });

        },
        buscar_lenguajes(){
            this.$http.post('buscar?view',{tabla:''}).then(function(response){
                if( response.body.data ){
                    this.lenguajes= response.body.data;
                }

            });
        }


    }
  })
