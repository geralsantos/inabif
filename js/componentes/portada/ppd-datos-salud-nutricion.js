Vue.component('ppd-datos-salud-nutricion', {
    template:'#ppd-datos-salud-nutricion',
    data:()=>({
        CarDiscapacidad:null,
        CarDiscapacidadFisica:null,
        CarDiscapacidadIntelectual:null,
        CarDiscapacidadSensorial:null,
        CarDiscapacidadMental:null,
        CarDxCertificado:null,
        CarCarnetConadis:null,
        CarMovilidad:null,
        CarDificultadDesplazamiento:null,
        CarDificultadBrazoCuerpo:null,
        CarPatologica1:null,
        CarTipoPatologia1:null,
        CarEspecifiquePato1:null,
        CarPatologia2:null,
        CarTipoPatologia2:null,
        CarEspecifiquePato2:null,
        CarNivelHemoglobina:null,
        CarAnemia:null,
        CarPeso:null,
        CarTalla:null,
        CarEstadoNutricional:null,

        dificultades:[],
        patologias:[],
        patologias2:[],
        nutricionales:[],

        nombre_residente:null,
        isLoading:false,
        mes:moment().format("M"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null,
        modal_lista:false,
        pacientes:[]


    }),
    created:function(){
    },
    mounted:function(){
        this.buscar_dificultades();
        this.buscar_patologias();
        this.buscar_patologias2();
    },
    updated:function(){
    },
    methods:{
        guardar(){
            if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'warning');
                return false;
            }
            let valores = {
                Discapacidad: this.CarDiscapacidad,
                Discapacidad_Fisica: this.CarDiscapacidadFisica,
                Discapacidad_Intelectual: this.CarDiscapacidadIntelectual,
                Discapacidad_Sensorial: this.CarDiscapacidadSensorial,
                Discapacidad_mental: this.CarDiscapacidadMental,
                Certificacdo_Dx: this.CarDxCertificado,
                Carnet_CONADIS: this.CarCarnetConadis,
                Movilidad: this.CarMovilidad,
                Motivo_Movilidad: this.CarDificultadDesplazamiento,
                Dificultad_Movilidad: this.CarDificultadBrazoCuerpo,
                Patologia1: this.CarPatologica1,
                Tipo_Patologia1: this.CarTipoPatologia1,
                Especifique1: this.CarEspecifiquePato1,
                Patologia2: this.CarPatologia2,
                Tipo_Patologia2: this.CarTipoPatologia2,
                Especifique2: this.CarEspecifiquePato2,
                Nivel_Hemoglobina: this.CarNivelHemoglobina,
                Anemia: this.CarAnemia,
                Peso: this.CarPeso,
                Talla: this.CarTalla,
                Estado_Nutricional: this.CarEstadoNutricional,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }

            this.$http.post('insertar_datos?view',{tabla:'CarSaludNutricion', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    swal('', 'Registro Guardado', 'success');

                }else{
                  swal("", "Un error ha ocurrido", "error");
                }
            });
        },
        buscar_residente(){
            this.id_residente = null;

            var word = this.nombre_residente;
            if( word.length >= 4){
                this.coincidencias = [];
                this.bloque_busqueda = true;
                this.isLoading = true;

                this.$http.post('ejecutar_consulta?view',{like:word }).then(function(response){

                    if( response.body.data != undefined){
                        this.isLoading = false;
                        this.coincidencias = response.body.data;
                    }else{
                        this.bloque_busqueda = false;
                        this.isLoading = false;
                        this.coincidencias = [];
                    }
                 });
            }else{
                this.bloque_busqueda = false;
                this.isLoading = false;
                this.coincidencias = [];
            }
        },
        actualizar(coincidencia){
            this.id_residente = coincidencia.ID;
            this.nombre_residente=coincidencia.NOMBRE;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarSaludNutricion', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarDiscapacidad = response.body.atributos[0]["DISCAPACIDAD"];
                    this.CarDiscapacidadFisica = response.body.atributos[0]["DISCAPACIDAD_FISICA"];
                    this.CarDiscapacidadIntelectual = response.body.atributos[0]["DISCAPACIDAD_INTELECTUAL"];
                    this.CarDiscapacidadSensorial = response.body.atributos[0]["DISCAPACIDAD_SENSORIAL"];
                    this.CarDiscapacidadMental = response.body.atributos[0]["DISCAPACIDAD_MENTAL"];
                    this.CarDxCertificado = response.body.atributos[0]["CERTIFICACDO_DX"];
                    this.CarCarnetConadis = response.body.atributos[0]["CARNET_CONADIS"];
                    this.CarMovilidad = response.body.atributos[0]["MOVILIDAD"];
                    this.CarDificultadDesplazamiento = response.body.atributos[0]["MOTIVO_MOVILIDAD"];
                    this.CarDificultadBrazoCuerpo = response.body.atributos[0]["DIFICULTAD_MOVILIDAD"];
                    this.CarPatologica1 = response.body.atributos[0]["PATOLOGIA1"];
                    this.CarTipoPatologia1 = response.body.atributos[0]["TIPO_PATOLOGIA1"];
                    this.CarEspecifiquePato1 = response.body.atributos[0]["ESPECIFIQUE1"];
                    this.CarPatologia2 = response.body.atributos[0]["PATOLOGIA2"];
                    this.CarTipoPatologia2 = response.body.atributos[0]["TIPO_PATOLOGIA2"];
                    this.CarEspecifiquePato2 = response.body.atributos[0]["ESPECIFIQUE2"];
                    this.CarNivelHemoglobina = response.body.atributos[0]["NIVEL_HEMOGLOBINA"];
                    this.CarAnemia = response.body.atributos[0]["ANEMIA"];
                    this.CarPeso = response.body.atributos[0]["PESO"];
                    this.CarTalla = response.body.atributos[0]["TALLA"];
                    this.CarEstadoNutricional = response.body.atributos[0]["ESTADO_NUTRICIONAL"];
                }
             });

        },
        buscar_dificultades(){
            this.$http.post('buscar?view',{tabla:'dificultades_cuerpo'}).then(function(response){
                if( response.body.data ){
                    this.dificultades= response.body.data;
                }

            });
        },
        buscar_patologias(){
            this.$http.post('buscar?view',{tabla:'pam_tipo_patologia'}).then(function(response){
                if( response.body.data ){
                    this.patologias= response.body.data;
                }

            });
        },
        buscar_patologias2(){
            this.$http.post('buscar?view',{tabla:'pam_tipo_patologia'}).then(function(response){
                if( response.body.data ){
                    this.patologias2= response.body.data;
                }

            });
        },mostrar_lista_residentes(){
         
            this.id_residente = null;
            this.isLoading = true;
                this.$http.post('ejecutar_consulta_lista?view',{}).then(function(response){

                    if( response.body.data != undefined){
                        this.modal_lista = true;
                        this.isLoading = false;
                        this.pacientes = response.body.data;
                    }else{
                        swal("", "No existe ningún residente", "error")
                    }
                 });
            
        },
        elegir_residente(residente){

            this.CarDiscapacidad = null;
            this.CarDiscapacidadFisica = null;
            this.CarDiscapacidadIntelectual = null;
            this.CarDiscapacidadSensorial = null;
            this.CarDiscapacidadMental = null;
            this.CarDxCertificado = null;
            this.CarCarnetConadis = null;
            this.CarMovilidad = null;
            this.CarDificultadDesplazamiento = null;
            this.CarDificultadBrazoCuerpo = null;
            this.CarPatologica1 = null;
            this.CarTipoPatologia1 = null;
            this.CarEspecifiquePato1 = null;
            this.CarPatologia2 = null;
            this.CarTipoPatologia2 = null;
            this.CarEspecifiquePato2 = null;
            this.CarNivelHemoglobina = null;
            this.CarAnemia = null;
            this.CarPeso = null;
            this.CarTalla = null;
            this.CarEstadoNutricional = null;


            this.id_residente = residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido = (residente.APELLIDO==undefined)?'':residente.APELLIDO;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarSaludNutricion', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarDiscapacidad = response.body.atributos[0]["DISCAPACIDAD"];
                    this.CarDiscapacidadFisica = response.body.atributos[0]["DISCAPACIDAD_FISICA"];
                    this.CarDiscapacidadIntelectual = response.body.atributos[0]["DISCAPACIDAD_INTELECTUAL"];
                    this.CarDiscapacidadSensorial = response.body.atributos[0]["DISCAPACIDAD_SENSORIAL"];
                    this.CarDiscapacidadMental = response.body.atributos[0]["DISCAPACIDAD_MENTAL"];
                    this.CarDxCertificado = response.body.atributos[0]["CERTIFICACDO_DX"];
                    this.CarCarnetConadis = response.body.atributos[0]["CARNET_CONADIS"];
                    this.CarMovilidad = response.body.atributos[0]["MOVILIDAD"];
                    this.CarDificultadDesplazamiento = response.body.atributos[0]["MOTIVO_MOVILIDAD"];
                    this.CarDificultadBrazoCuerpo = response.body.atributos[0]["DIFICULTAD_MOVILIDAD"];
                    this.CarPatologica1 = response.body.atributos[0]["PATOLOGIA1"];
                    this.CarTipoPatologia1 = response.body.atributos[0]["TIPO_PATOLOGIA1"];
                    this.CarEspecifiquePato1 = response.body.atributos[0]["ESPECIFIQUE1"];
                    this.CarPatologia2 = response.body.atributos[0]["PATOLOGIA2"];
                    this.CarTipoPatologia2 = response.body.atributos[0]["TIPO_PATOLOGIA2"];
                    this.CarEspecifiquePato2 = response.body.atributos[0]["ESPECIFIQUE2"];
                    this.CarNivelHemoglobina = response.body.atributos[0]["NIVEL_HEMOGLOBINA"];
                    this.CarAnemia = response.body.atributos[0]["ANEMIA"];
                    this.CarPeso = response.body.atributos[0]["PESO"];
                    this.CarTalla = response.body.atributos[0]["TALLA"];
                    this.CarEstadoNutricional = response.body.atributos[0]["ESTADO_NUTRICIONAL"];
                }
             });

        }

    }
  })
