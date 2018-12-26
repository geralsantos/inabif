Vue.component('ppd-datos-condicion-ingreso', {
    template: '#ppd-datos-condicion-ingreso',
    data:()=>({
        CarDocIngreso:null,
        CarTipoDoc:null,
        CarNumDoc:null,
        CarULeeEscribe:null,
        CarInstitucionEducativa:null,
        CarTipoSeguro:null,
        CarCSocioeconomica:null,
        CarFamiliaresUbicados:null,
        CarTipoParentesco:null


    }),
    created:function(){
    },
    mounted:function(){
    },
    updated:function(){
    },
    methods:{
        guardar(){
            let valores = { CarDocIngreso:this.CarDocIngreso,
                CarTipoDoc:this.CarTipoDoc,
                CarNumDoc:this.CarNumDoc,
                CarULeeEscribe:this.CarULeeEscribe,
                CarInstitucionEducativa:this.CarInstitucionEducativa,
                CarTipoSeguro:this.CarTipoSeguro,
                CarCSocioeconomica:this.CarCSocioeconomica,
                CarFamiliaresUbicados:this.CarFamiliaresUbicados,
                CarTipoParentesco:this.CarTipoParentesco
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
