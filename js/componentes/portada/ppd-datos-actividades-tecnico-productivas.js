Vue.component('ppd-datos-actividades-tecnico-productivas', {
    template: '#ppd-datos-actividades-tecnico-productivas',
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
        insertar_datos(){
            let valores = { CarNumBiohuerto: CarNumBiohuerto,
                CarNumManualidades: CarNumManualidades,
                CarNumReposteria: CarNumReposteria,
                CarNumPaseos: CarNumPaseos,
                CarNumCulturales: CarNumCulturales,
                CarNumCivicas: CarNumCivicas,
                CarNumFutbol: CarNumFutbol,
                CarNumNatacion: CarNumNatacion,
                CarNumDeportes: CarNumDeportes,
                CArNumDinero: CArNumDinero,
                CarNumDecisiones: CarNumDecisiones
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
