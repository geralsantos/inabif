Vue.component('nna-datos-familiares-sociales-residente', {
    template: '#nna-datos-familiares-sociales-residente',
    data:()=>({
        NNACuentaFamilia:null,
        NNATipoParentesco:null,
        NNATipoFamilia:null,
        NNAProblematicaFamiliar:null


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
                Familiares:this.NNACuentaFamilia,
                Parentesco:this.NNATipoParentesco,
                Tipo_Familia:this.NNATipoFamilia,
                Problematica_Fami :this.NNAProblematicaFamiliar

                        }
            this.$http.post('insertar_datos?view',{tabla:'FamiliaresResidente', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    swal('', 'Registro Guardado', 'success');

                }else{
                  swal("", "Un error ha ocurrido", "error");
                }
            });
        }
    }
  })
