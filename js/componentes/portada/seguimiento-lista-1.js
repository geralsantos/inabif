Vue.component('seguimiento-lista-1', {
    template:'#seguimiento-lista-1',
    data:()=>({
        periodo:moment().format('MMMM YYYY'),
        matriz:false,
        completado:false,
        completo:false,
       centros:[],

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
        this.buscar_centros();
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

                   
                    
                }
             });

        },
        traer_datos_usuario(){
            this.$http.post('traer_datos_usuario?view',{}).then(function(response){

                if( response.body.data != undefined){
                    this.usuario = response.body.data[0]["ID"]
                    this.buscar_centros(this.usuario);
                }
            });
        },
        buscar_centros(){

            this.$http.post('buscar_centros?view',{}).then(function(response){

                if( response.body.data != undefined){
                    this.centros = response.body.data;
                    
                }
            });

        },

        completar_matriz(id_centro){
            this.$http.post('completar_matriz?view',{id_centro:id_centro}).then(function(response){

                if( response.body.data != undefined){
                    this.centros = response.body.data;
                    
                }
            });
        }
     

    }
  })
