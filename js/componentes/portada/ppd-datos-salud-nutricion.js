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
        mes:moment().format("MM"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null


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
                swal('Error', 'Residente no existe', 'success');
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

                    this.CarDiscapacidad = response.body.atributos[0]["Discapacidad"];
                    this.CarDiscapacidadFisica = response.body.atributos[0]["Discapacidad_Fisica"];
                    this.CarDiscapacidadIntelectual = response.body.atributos[0]["Discapacidad_Intelectual"];
                    this.CarDiscapacidadSensorial = response.body.atributos[0]["Discapacidad_Sensorial"];
                    this.CarDiscapacidadMental = response.body.atributos[0]["Discapacidad_mental"];
                    this.CarDxCertificado = response.body.atributos[0]["Certificacdo_Dx"];
                    this.CarCarnetConadis = response.body.atributos[0]["Carnet_CONADIS"];
                    this.CarMovilidad = response.body.atributos[0]["Movilidad"];
                    this.CarDificultadDesplazamiento = response.body.atributos[0]["Motivo_Movilidad"];
                    this.CarDificultadBrazoCuerpo = response.body.atributos[0]["Dificultad_Movilidad"];
                    this.CarPatologica1 = response.body.atributos[0]["Patologia1"];
                    this.CarTipoPatologia1 = response.body.atributos[0]["Tipo_Patologia1"];
                    this.CarEspecifiquePato1 = response.body.atributos[0]["Especifique1"];
                    this.CarPatologia2 = response.body.atributos[0]["Patologia2"];
                    this.CarTipoPatologia2 = response.body.atributos[0]["Tipo_Patologia2"];
                    this.CarEspecifiquePato2 = response.body.atributos[0]["Especifique2"];
                    this.CarNivelHemoglobina = response.body.atributos[0]["Nivel_Hemoglobina"];
                    this.CarAnemia = response.body.atributos[0]["Anemia"];
                    this.CarPeso = response.body.atributos[0]["Peso"];
                    this.CarTalla = response.body.atributos[0]["Talla"];
                    this.CarEstadoNutricional = response.body.atributos[0]["Estado_Nutricional"];
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
        }

    }
  })
