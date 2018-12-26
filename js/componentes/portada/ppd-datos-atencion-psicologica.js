Vue.component('ppd-datos-atencion-psicologica', {
    template: '#ppd-datos-atencion-psicologica',
    data:()=>({
        CarNumHabilidadesBasicas:null,
        CarNumHabilidadesConceptuales:null,
        CarNumHabilidadesSociales:null,
        CarNumHablidadesPracticas:null,
        CarNumModificacionConducta:null,



    }),
    created:function(){
    },
    mounted:function(){
    },
    updated:function(){
    },
    methods:{
        insertar_datos(){
            let valores = { CarNumHabilidadesBasicas: CarNumHabilidadesBasicas,
                CarNumHabilidadesConceptuales: CarNumHabilidadesConceptuales,
                CarNumHabilidadesSociales: CarNumHabilidadesSociales,
                CarNumHablidadesPracticas: CarNumHablidadesPracticas,
                CarNumModificacionConducta: CarNumModificacionConducta
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
