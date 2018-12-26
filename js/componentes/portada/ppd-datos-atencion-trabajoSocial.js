Vue.component('ppd-datos-atencion-trabajoSocial', {
    template: '#ppd-datos-atencion-trabajoSocial',
    data:()=>({
        CarVisitaF:null,
        CarNumVisitaMes:null,
        CarResinsercionF:null,
        CarFamiliaRSoporte:null,
        CarDesPersonaV:null,
        CarRDni:null,
        CarRAus:null,
        CarRConadis:null,

    }),
    created:function(){
    },
    mounted:function(){
    },
    updated:function(){
    },
    methods:{
        guardar(){
            let valores = { CarVisitaF:this.CarVisitaF,
                CarNumVisitaMes:this.CarNumVisitaMes,
                CarResinsercionF:this.CarResinsercionF,
                CarFamiliaRSoporte:this.CarFamiliaRSoporte,
                CarDesPersonaV:this.CarDesPersonaV,
                CarRDni:this.CarRDni,
                CarRAus:this.CarRAus,
                CarRConadis:this.CarRConadis
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
