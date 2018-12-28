Vue.component('ppd-datos-atencion-salud', {
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
            let valores = {

                CarNumAtencionesMG:this.CarNumAtencionesMG,
                CarSalidaMes:this.CarSalidaMes,
                CarNunSalidas:this.CarNunSalidas,
                CarNumACardiovascular:this.CarNumACardiovascular,
                CarANefrologia:this.CarANefrologia,
                CarAOncologia:this.CarAOncologia,
                CarANeurocirugia:this.CarANeurocirugia,
                CarNumDermatologia:this.CarNumDermatologia,
                CarAEncornologia:this.CarAEncornologia,
                CarAGastroenterologia:this.CarAGastroenterologia,
                CarAGinecoObstretica:this.CarAGinecoObstretica,
                CarAInfectoContagiosas:this.CarAInfectoContagiosas,
                CarACardiovascular:this.CarACardiovascular,
                CarAInmunologia:this.CarAInmunologia,
                CarAMedicinaFisica:this.CarAMedicinaFisica,
                CarANeumologia:this.CarANeumologia,
                CarAnutricion:this.CarAnutricion,
                CarANeurologia:this.CarANeurologia,
                CarAOftamologia:this.CarAOftamologia,
                CarAOtorrinoloringologia:this.CarAOtorrinoloringologia,
                CarAPedriatria:this.CarAPedriatria,
                CarAPsiquiatria:this.CarAPsiquiatria,
                CarAQuirurgica:this.CarAQuirurgica,
                CarATraumologia:this.CarATraumologia,
                CarAUrologia:this.CarAUrologia,
                CarAOdontologia:this.CarAOdontologia,
                CarAServicios:this.CarAServicios,
                CarTratamientoPsicofarmaco:this.CarTratamientoPsicofarmaco,
                CarHopitalizadoP:this.CarHopitalizadoP,
                CarNumHospitalizaciones:this.CarNumHospitalizaciones,
                CarMotivoHospitalizacion:this.CarMotivoHospitalizacion
                        }
            this.$http.post('insertar_datos?view',{tabla:'', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    swal('', 'Registro Guardado', 'success');

                }else{
                  swal("", "Un error ha ocurrido", "error");
                }
            });
        }
    }
  })
