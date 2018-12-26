Vue.component('nna-actividades-sociorecreativas', {
    template:'#nna-actividades-sociorecreativas',
    data:()=>({
        NNAArte:null,
        NNABiohuerto:null,
        NNAZapateria:null,
        NNACarpinteria:null,
        NNACeramica:null,
        NNACrianzaAnimales:null,
        NNAPintura:null,
        NNATejidos:null,
        NNADeportes:null,
        NNATalleres:null

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
                Nro_Arte:this.NNAArte,
                Nro_BioHuerto:this.NNABiohuerto,
                Nro_Zapateria:this.NNAZapateria,
                Nro_Carpinteria:this.NNACarpinteria,
                Nro_Ceramica:this.NNACeramica,
                Nro_Crianza:this.NNACrianzaAnimales,
                Nro_Dibujo:this.NNAPintura,
                Nro_Tejido:this.NNATejidos,
                Nro_Deportes:this.NNADeportes,
                Nro_Taller_Pro:this.NNATalleres
                        }
            this.$http.post('insertar_datos?view',{tabla:'ActividadesSociorecreativas', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    swal('', 'Registro Guardado', 'success');

                }else{
                  swal("", "Un error ha ocurrido", "error");
                }
            });
        }
    }
  })
