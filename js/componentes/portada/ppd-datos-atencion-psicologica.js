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
        guardar(){
            let valores = { CarNumHabilidadesBasicas: this.CarNumHabilidadesBasicas,
                CarNumHabilidadesConceptuales: this.CarNumHabilidadesConceptuales,
                CarNumHabilidadesSociales: this.CarNumHabilidadesSociales,
                CarNumHablidadesPracticas: this.CarNumHablidadesPracticas,
                CarNumModificacionConducta: this.CarNumModificacionConducta
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
