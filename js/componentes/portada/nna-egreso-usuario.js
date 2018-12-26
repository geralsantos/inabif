Vue.component('nna-egreso-usuario', {
    template: '#nna-egreso-usuario',
    data:()=>({
        NNAFEgreso:null,
        NNAMotivoEgreso:null,
        NNADetalleMotivoEgreso:null,
        NNASaludAUS:null,
        NNAPartidaNacimiento:null,
        NNATieneDNI:null,
        NNAEducacion:null,
        NNAReinsercionFamiliar:null

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
                Fecha_Egreso:this.NNAFEgreso,
                MotivoEgreso:this.NNAMotivoEgreso,
                Detalle_Motivo:this.NNADetalleMotivoEgreso,
                Salud_AUS:this.NNASaludAUS,
                Partida_Naci:this.NNAPartidaNacimiento,
                DNI:this.NNATieneDNI,
                Educacion:this.NNAEducacion,
                Reinsecion_Familiar:this.NNAReinsercionFamiliar

                        }
            this.$http.post('insertar_datos?view',{tabla:'EgresoUsuario', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    swal('', 'Registro Guardado', 'success');

                }else{
                  swal("", "Un error ha ocurrido", "error");
                }
            });
        }
    }
  })
