Vue.component('nna-datos-admision-residente', {
    template:'#nna-datos-admision-residente',
    data:()=>({
        NNAMovimientoPoblacional:null,
        NNAApellidoMaterno:null,
        NNANombre:null,
        NNAPaisProcedencia:null,
        NNADepartementoProcedencia:null,
        NNADepartamentoNacimiento:null,
        NNAProvinciaNacimiento:null,
        NNADistritoNacimiento:null,
        NNASexo:null,
        NNAFNacimiento:null,
        NNAEdad:null,
        NNALenguaMAterna:null,
        NNACodigoDocumento:null

    }),
    created:function(){
    },
    mounted:function(){
    },
    updated:function(){
    },
    methods:{
        guardar(){
           /*CORRGIR */
            this.$http.post('insertar_datos?view',{tabla:'AdmisionResidente', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    swal('', 'Registro Guardado', 'success');

                }else{
                  swal("", "Un error ha ocurrido", "error");
                }
            });
        }
    }
  })
