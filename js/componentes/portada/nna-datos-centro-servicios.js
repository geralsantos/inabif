Vue.component('nna-datos-centro-servicios', {
    template: '#nna-datos-centro-servicios',
    data:()=>({
        NNACodEntidad:null,
        NNANomEntidad:null,
        NNACodLinea:null,
        NNANomLinea:null,
        NNACodLineaIntervencion:null,
        NNACodServicio:null,
        NNANombreServicio:null,
        NNADepartamentoA:null,
        NNAProvinciaAtencion:null,
        NNADistritoAtencion:null,
        NNAAreaResidencia:null,
        NNACodCentroA:null,
        NNANomCentroA:null

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
                Cod_Entidad:this.NNACodEntidad,
                Nom_Entidad:this.NNANomEntidad,
                Cod_Linea:this.NNACodLinea,
                Nom_Linea:this.NNANomLinea,
                Linea_Intervencion:this.NNACodLineaIntervencion,
                Cod_Servicio:this.NNACodServicio,
                NomC_Servicio:this.NNANombreServicio,
                Departamento_Centro:this.NNADepartamentoA,
                Provincia_centro:this.NNAProvinciaAtencion,
                Distrito_centro:this.NNADistritoAtencion,
                Area_Residencia:this.NNAAreaResidencia,
                CodigoC_Atencion:this.NNACodCentroA,
                NomC_Atencion:this.NNANomCentroA
                        }
            this.$http.post('insertar_datos?view',{tabla:'CentroServicios', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    swal('', 'Registro Guardado', 'success');

                }else{
                  swal("", "Un error ha ocurrido", "error");
                }
            });
        }
    }
  })
