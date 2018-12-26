Vue.component('ppd-datos-educacion-participacionLaboral', {
    template: '#ppd-datos-educacion-participacionLaboral',
    data:()=>({
        CarTipoIIEE:null,
        CarInsertadoLaboralmente:null,
        CarDesParticipacionLa:null,
        CarFortalecimientoHabilidades:null,
        CarFIActividades:null,
        CarFFActividades:null,
        CarNNAConcluyoHP:null,
        CarNNAFortaliceHP:null

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
                CarTipoIIEE:this.CarTipoIIEE,
                CarInsertadoLaboralmente:this.CarInsertadoLaboralmente,
                CarDesParticipacionLa:this.CarDesParticipacionLa,
                CarFortalecimientoHabilidades:this.CarFortalecimientoHabilidades,
                CarFIActividades:this.CarFIActividades,
                CarFFActividades:this.CarFFActividades,
                CarNNAConcluyoHP:this.CarNNAConcluyoHP,
                CarNNAFortaliceHP:this.CarNNAFortaliceHP
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
