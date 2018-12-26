Vue.component('nna-datos-salud-residente', {
    template: '#nna-datos-salud-residente',
    data:()=>({
        NNADiscapacidad:null,
        NNADiscapacidadFisica:null,
        NNADiscapacidadIntelectual:null,
        NNADiscapacidadSensorial:null,
        NNADiscapacidadMental:null,
        NNADxCertificado:null,
        NNACarnetConadis:null,
        NNATranstornoNeurologico:null,
        NNAEspecificaTranstornoNeurologico:null,
        NNACRED:null,
        NNAVacunas:null,
        NNAPatologia1:null,
        NNADesPatologia1:null,
        NNAPatologia2:null,
        NNADiagnostico3:null,
        NNATrastornoComportamiento:null,
        NNaTipoTranstorno:null,
        NNAGestante:null,
        NNASemanaGestacion:null,
        NNAControlParental:null,
        NNATieneHijos:null,
        NNANumHijos:null,
        NNANivelHemoglobina:null,
        NNAAnemia:null,
        NNAPeso:null,
        NNATalla:null,
        NNAEstadoNutricionalPeso:null,
        NNAEstadoNutricionalTalla:null

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
                Discapacidad:this.NNADiscapacidad,
                Discapacidad_Fisica:this.NNADiscapacidadFisica,
                Discapacidad_Intelectual:this.NNADiscapacidadIntelectual,
                Discapacidad_Sensorial:this.NNADiscapacidadSensorial,
                Discapacidad_Mental:this.NNADiscapacidadMental,
                Certificado:this.NNADxCertificado,
                Carnet_CANADIS:this.NNACarnetConadis,
                Transtornos_Neuro:this.NNATranstornoNeurologico,
                Des_Transtorno_Neuro:this.NNAEspecificaTranstornoNeurologico,
                CRED:this.NNACRED,
                Vacunas:this.NNAVacunas,
                Patologia_1:this.NNAPatologia1,
                Diagnostico_S1:this.NNADesPatologia1,
                Patologia_2:this.NNAPatologia2,
                Diagnostico_S3:this.NNADiagnostico3,
                Transtornos_Comportamiento:this.NNATrastornoComportamiento,
                Tipo_Transtorno:this.NNaTipoTranstorno,
                Gestante:this.NNAGestante,
                Semanas_Gestacion:this.NNASemanaGestacion,
                Control_Prenatal:this.NNAControlParental,
                Hijos:this.NNATieneHijos,
                Nro_Hijos:this.NNANumHijos,
                Nivel_Hemoglobina:this.NNANivelHemoglobina,
                Anemia:this.NNAAnemia,
                Peso:this.NNAPeso,
                Talla:this.NNATalla,
                Estado_Nutricional1:this.NNAEstadoNutricionalPeso,
                Estado_Nutricional2:this.NNAEstadoNutricionalTalla

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
