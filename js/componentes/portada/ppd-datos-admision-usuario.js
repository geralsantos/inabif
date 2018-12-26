Vue.component('ppd-datos-admision-usuario', {
    template:'#ppd-datos-admision-usuario',
    data:()=>({
        CarMPoblacional:null,
        CarFIngreso:null,
        CarFReingreso:null,
        CarIDerivo:null,
        CarMotivoI:null,
        CarTipoDoc:null,
        CarNumDoc:null,

    }),
    created:function(){
    },
    mounted:function(){
    },
    updated:function(){
    },
    methods:{
        guardar(){
            let valores = { CarMPoblacional: this.CarMPoblacional,
                CarFIngreso: this.CarFIngreso,
                CarFReingreso: this.CarFReingreso,
                CarIDerivo: this.CarIDerivo,
                CarMotivoI: this.CarMotivoI,
                CarTipoDoc: this.CarTipoDoc,
                CarNumDoc: this.CarNumDoc

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
