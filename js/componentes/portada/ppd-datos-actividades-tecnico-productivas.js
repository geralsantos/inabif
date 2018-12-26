Vue.component('ppd-datos-actividades-tecnico-productivas', {
    template:'#ppd-datos-actividades-tecnico-productivas',
    data:()=>({
        CarNumBiohuerto:null,
        CarNumManualidades:null,
        CarNumReposteria:null,
        CarNumPaseos:null,
        CarNumCulturales:null,
        CarNumCivicas:null,
        CarNumFutbol:null,
        CarNumNatacion:null,
        CarNumDeportes:null,
        CArNumDinero:null,
        CarNumDecisiones:null,
    }),
    created:function(){
    },
    mounted:function(){
    },
    updated:function(){
    },
    methods:{
        guardar(){
            let valores = { CarNumBiohuerto: this.CarNumBiohuerto,
                CarNumManualidades: this.CarNumManualidades,
                CarNumReposteria: this.CarNumReposteria,
                CarNumPaseos: this.CarNumPaseos,
                CarNumCulturales: this.CarNumCulturales,
                CarNumCivicas: this.CarNumCivicas,
                CarNumFutbol: this.CarNumFutbol,
                CarNumNatacion: this.CarNumNatacion,
                CarNumDeportes: this.CarNumDeportes,
                CArNumDinero: this.CArNumDinero,
                CarNumDecisiones: this.CarNumDecisiones
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
