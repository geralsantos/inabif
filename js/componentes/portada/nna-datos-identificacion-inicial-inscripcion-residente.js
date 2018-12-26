Vue.component('nna-datos-identificacion-inicial-inscripcion-residente', {
    template: '#nna-datos-identificacion-inicial-inscripcion-residente',
    data:()=>({
        NNAApellidoPaterno:null,
        NNAApellidoMaterno:null,
        NNANombre:null,
        NNAPaisProcedencia:null,
        NNADepatamentoProcedencia:null,
        NNADepartamentoNacimiento:null,
        NNAProvinciaNacimiento:null,
        NNADistritoNacimiento:null,
        NNASexo:null,
        NNAFNacimiento:null,
        NNAEdad:null,
        NNALenguaMaterna:null,
        NNANumDoc:null,
        NNAMovPoblacional:null

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
                Apellido_Paterno:this.NNAApellidoPaterno,
                Apellido_Materno:this.NNAApellidoMaterno,
                Nombres:this.NNANombre,
                Pais_Procedencia:this.NNAPaisProcedencia,
                Departamento_Procedencia:this.NNADepatamentoProcedencia,
                Departamento_Naci:this.NNADepartamentoNacimiento,
                Provincia_Naci:this.NNAProvinciaNacimiento,
                Distrito_Naci:this.NNADistritoNacimiento,
                Sexo:this.NNASexo,
                Fecha_Naci:this.NNAFNacimiento,
                Edad:this.NNAEdad,
                Lengua_Materna:this.NNALenguaMaterna,
                Numero_Doc:this.NNANumDoc,
                Movimiento_Poblacional:this.NNAMovPoblacional
                        }
            this.$http.post('insertar_datos?view',{tabla:'InscripcionResidente', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    swal('', 'Registro Guardado', 'success');

                }else{
                  swal("", "Un error ha ocurrido", "error");
                }
            });
        }
    }
  })
