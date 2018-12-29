Vue.component('pam-datos-nutricion-salud', {
    template:'#pam-datos-nutricion-salud',
    data:()=>({
        
        discapacidad:null,
        discapacidad_fisica:null,
        discapacidad_intelectual:null,
        discapacidad_sensorial:null,
        presenta_discapacidad_mental:null,
        dx_certificado:null,
        carnet_conadis:null,
        grado_dependencia_pam:null,
        motivo_dif_desplazamiento:null,
        enfermedad_ingreso_1:null,
        tipo_patologia:null,
        enfermedad_ingreso_2:null,
        tipo_patologia_2:null,
        nivel_hemoglobina:null,
        presenta_anema:null,
        peso:null,
        talla:null,
        estado_nutricional:null,

        patologias:[],
     
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
        this.buscar_patologias();

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
                
                        discapacidad:this.discapacidad,
                        discapacidad_fisica:this.discapacidad_fisica,
                        discapacidad_intelectual:this.discapacidad_intelectual,
                        discapacidad_sensorial:this.discapacidad_sensorial,
                        presenta_discapacidad_mental:this.presenta_discapacidad_mental,
                        dx_certificado:this.dx_certificado,
                        carnet_conadis:this.carnet_conadis,
                        grado_dependencia_pam:this.grado_dependencia_pam,
                        motivo_dif_desplazamiento:this.motivo_dif_desplazamiento,
                        enfermedad_ingreso_1:this.enfermedad_ingreso_1,
                        tipo_patologia:this.tipo_patologia,
                        enfermedad_ingreso_2:this.enfermedad_ingreso_2,
                        tipo_patologia_2:this.tipo_patologia_2,
                        nivel_hemoglobina:this.nivel_hemoglobina,
                        presenta_anema:this.presenta_anema,
                        peso:this.peso,
                        talla:this.talla,
                        estado_nutricional:this.estado_nutricional
    
                    }
                        console.log(valores)
            this.$http.post('insertar_datos?view',{tabla:'pam_datos_saludnutric', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_datos_saludnutric', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.discapacidad = response.body.atributos[0]["discapacidad"];
                    this.discapacidad_fisica = response.body.atributos[0]["discapacidad_fisica"];
                    this.discapacidad_intelectual = response.body.atributos[0]["discapacidad_intelectual"];
                    this.discapacidad_sensorial = response.body.atributos[0]["discapacidad_sensorial"];
                    this.presenta_discapacidad_mental = response.body.atributos[0]["presenta_discapacidad_mental"];
                    this.dx_certificado = response.body.atributos[0]["dx_certificado"];
                    this.carnet_conadis = response.body.atributos[0]["carnet_conadis"];
                    this.grado_dependencia_pam = response.body.atributos[0]["grado_dependencia_pam"];
                    this.motivo_dif_desplazamiento = response.body.atributos[0]["motivo_dif_desplazamiento"];
                    this.enfermedad_ingreso_1 = response.body.atributos[0]["enfermedad_ingreso_1"];
                    this.tipo_patologia = response.body.atributos[0]["tipo_patologia"];
                    this.enfermedad_ingreso_2 = response.body.atributos[0]["enfermedad_ingreso_2"];
                    this.nivel_hemoglobina = response.body.atributos[0]["nivel_hemoglobina"];
                    this.presenta_anema = response.body.atributos[0]["presenta_anema"];
                    this.peso = response.body.atributos[0]["peso"];
                    this.talla = response.body.atributos[0]["talla"];
                    this.estado_nutricional = response.body.atributos[0]["estado_nutricional"];
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

        
    }
  })
