Vue.component('nna-datos-condiciones-ingreso-residente', {
    template: '#nna-datos-condiciones-ingreso-residente',
    data:()=>({
        NNATipoDoc:null,
        NNANumDoc:null,
        NNALeeEscribe:null,
        NNANivelEducativo:null,
        NNATipoSeguro:null,
        NNAClasificacionSocioeconomica:null

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
                Tipo_Doc:this.NNATipoDoc,
                Numero_Doc:this.NNANumDoc,
                Lee_Escribe:this.NNALeeEscribe,
                Nivel_Educativo:this.NNANivelEducativo,
                Tipo_Seguro:this.NNATipoSeguro,
                SISFOH:this.NNAClasificacionSocioeconomica

                        }
            this.$http.post('insertar_datos?view',{tabla:'CondicionIResidente', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    swal('', 'Registro Guardado', 'success');

                }else{
                  swal("", "Un error ha ocurrido", "error");
                }
            });
        }
    }
  })
