Vue.component('ppd-datos-centro-servicios', {
    template: '#ppd-datos-centro-servicios',
    data:()=>({
        CarCodEntidad:null,
        CarNomEntidad:null,
        CarCodLinea:null,
        CarLineaI:null,
        CarCodServicio:null,
        CarNomServicio:null,
        CarDepart:null,
        CarProv:null,
        areaResidencia:null,
        CarDistrito:null,
        codigoCentroAtencion:null,
        nombreCentroAtencion:null,

    }),
    created:function(){
    },
    mounted:function(){
    },
    updated:function(){
    },
    methods:{
        guardar(){
            let valores = { CarCodEntidad:this.CarCodEntidad,
                CarNomEntidad:this.CarNomEntidad,
                CarCodLinea:this.CarCodLinea,
                CarLineaI:this.CarLineaI,
                CarCodServicio:this.CarCodServicio,
                CarNomServicio:this.CarNomServicio,
                CarDepart:this.CarDepart,
                CarProv:this.CarProv,
                areaResidencia:this.areaResidencia,
                CarDistrito:this.CarDistrito,
                codigoCentroAtencion:this.codigoCentroAtencion,
                nombreCentroAtencion:this.nombreCentroAtencion,
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
