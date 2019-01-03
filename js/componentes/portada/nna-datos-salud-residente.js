Vue.component('nna-datos-salud-residente', {
    template: '#nna-datos-salud-residente',
    data:()=>({
        
        Discapacidad:null,
        Discapacidad_Fisica :null,
        Discapacidad_Sensorial:null,
        Discapaciada_Intelectual:null,
        Discapacidad_Mental:null,
        Certificado :null,
        Carnet_CANADIS :null,
        Transtornos_Neuro :null,
        Des_Transtorno_Neuro :null,
        CRED :null,
        Vacunas :null,
        Patologia_1 :null,
        Diagnostico_S1 :null,
        Patologia_2 :null,
        Diagnostico_S3 :null,
        Transtornos_Comportamiento :null,
        Tipo_Transtorno :null,
        Gestante :null,
        Semanas_Gestacion  :null,
        Control_Prenatal :null,
        Hijos  :null,
        Nro_Hijos :null,
        Nivel_Hemoglobina  :null,
        Anemia  :null,
        Peso :null,
        Talla :null,
        Estado_Nutricional1  :null,
        Estado_Nutricional2  :null,

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
               
                Discapacidad:this.Discapacidad,
                Discapacidad_Fisica :this.Discapacidad_Fisica,
                Discapacidad_Sensorial:this.Discapacidad_Sensorial,
                Discapaciada_Intelectual:this.Discapaciada_Intelectual,
                Discapacidad_Mental:this.Discapacidad_Mental,
                Certificado :this.Certificado,
                Carnet_CANADIS :this.Carnet_CANADIS,
                Transtornos_Neuro :this.Transtornos_Neuro,
                Des_Transtorno_Neuro :this.Des_Transtorno_Neuro,
                CRED :this.CRED,
                Vacunas :this.Vacunas,
                Patologia_1 :this.Patologia_1,
                Diagnostico_S1 :this.Diagnostico_S1,
                Patologia_2 :this.Patologia_2,
                Diagnostico_S3 :this.Diagnostico_S3,
                Transtornos_Comportamiento :this.Transtornos_Comportamiento,
                Tipo_Transtorno :this.Tipo_Transtorno,
                Gestante :this.Gestante,
                Semanas_Gestacion  :this.Semanas_Gestacion,
                Control_Prenatal :this.Control_Prenatal,
                Hijos  :this.Hijos,
                Nro_Hijos :this.Nro_Hijos,
                Nivel_Hemoglobina  :this.Nivel_Hemoglobina,
                Anemia  :this.Anemia,
                Peso :this.Peso,
                Talla :this.Talla,
                Estado_Nutricional1  :this.Estado_Nutricional1,
                Estado_Nutricional2  :this.Estado_Nutricional2,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                
            this.$http.post('insertar_datos?view',{tabla:'NNADatosSaludResi', valores:valores}).then(function(response){

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
            let nombre=(coincidencia.NOMBRE==undefined)?'':coincidencia.NOMBRE;
let apellido = (coincidencia.APELLIDO==undefined)?'':coincidencia.APELLIDO;
 this.nombre_residente=nombre + ' ' + apellido;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'NNADatosSaludResi', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Discapacidad = response.body.atributos[0]["DISCAPACIDAD"];
                    this.Discapacidad_Fisica = response.body.atributos[0]["DISCAPACIDAD_FISICA"];
                    this.Discapacidad_Sensorial = response.body.atributos[0]["DISCAPACIDAD_SENSORIAL"];
                    this.Discapaciada_Intelectual = response.body.atributos[0]["DISCAPACIADA_INTELECTUAL"];
                    this.Discapacidad_Mental = response.body.atributos[0]["DISCAPACIDAD_MENTAL"];
                    this.Certificado = response.body.atributos[0]["CERTIFICADO"];
                    this.Carnet_CANADIS = response.body.atributos[0]["CARNET_CANADIS"];
                    this.Transtornos_Neuro = response.body.atributos[0]["TRANSTORNOS_NEURO"];
                    this.Des_Transtorno_Neuro = response.body.atributos[0]["DES_TRANSTORNO_NEURO"];
                    this.CRED = response.body.atributos[0]["CRED"];
                    this.Vacunas = response.body.atributos[0]["VACUNAS"];
                    this.Patologia_1 = response.body.atributos[0]["PATOLOGIA_1"];
                    this.Diagnostico_S1 = response.body.atributos[0]["DIAGNOSTICO_S1"];
                    this.Patologia_2 = response.body.atributos[0]["PATOLOGIA_2"];
                    this.Diagnostico_S3 = response.body.atributos[0]["DIAGNOSTICO_S3"];
                    this.Transtornos_Comportamiento = response.body.atributos[0]["TRANSTORNOS_COMPORTAMIENTO"];
                    this.Tipo_Transtorno = response.body.atributos[0]["TIPO_TRANSTORNO"];
                    this.Gestante = response.body.atributos[0]["GESTANTE"];
                    this.Semanas_Gestacion = response.body.atributos[0]["SEMANAS_GESTACION"];
                    this.Control_Prenatal = response.body.atributos[0]["CONTROL_PRENATAL"];
                    this.Hijos = response.body.atributos[0]["HIJOS"];
                    this.Nro_Hijos = response.body.atributos[0]["NRO_HIJOS"];
                    this.Nivel_Hemoglobina = response.body.atributos[0]["NIVEL_HEMOGLOBINA"];
                    this.Anemia = response.body.atributos[0]["ANEMIA"];
                    this.Peso = response.body.atributos[0]["PESO"];
                    this.Talla = response.body.atributos[0]["TALLA"];
                    this.Estado_Nutricional1 = response.body.atributos[0]["ESTADO_NUTRICIONAL1"];
                    this.Estado_Nutricional2 = response.body.atributos[0]["ESTADO_NUTRICIONAL2"];
                                    
                }
             });

        },
        mostrar_lista_residentes(){
         
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

            this.Discapacidad = null;
            this.Discapacidad_Fisica = null;
            this.Discapacidad_Sensorial = null;
            this.Discapaciada_Intelectual = null;
            this.Discapacidad_Mental = null;
            this.Certificado = null;
            this.Carnet_CANADIS = null;
            this.Transtornos_Neuro = null;
            this.Des_Transtorno_Neuro = null;
            this.CRED = null;
            this.Vacunas = null;
            this.Patologia_1 = null;
            this.Diagnostico_S1 = null;
            this.Patologia_2 = null;
            this.Diagnostico_S3 = null;
            this.Transtornos_Comportamiento = null;
            this.Tipo_Transtorno = null;
            this.Gestante = null;
            this.Semanas_Gestacion = null;
            this.Control_Prenatal = null;
            this.Hijos = null;
            this.Nro_Hijos = null;
            this.Nivel_Hemoglobina = null;
            this.Anemia = null;
            this.Peso = null;
            this.Talla = null;
            this.Estado_Nutricional1 = null;
            this.Estado_Nutricional2 = null;

            this.id_residente = residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido = (residente.APELLIDO==undefined)?'':residente.APELLIDO;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'NNADatosSaludResi', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Discapacidad = response.body.atributos[0]["DISCAPACIDAD"];
                    this.Discapacidad_Fisica = response.body.atributos[0]["DISCAPACIDAD_FISICA"];
                    this.Discapacidad_Sensorial = response.body.atributos[0]["DISCAPACIDAD_SENSORIAL"];
                    this.Discapaciada_Intelectual = response.body.atributos[0]["DISCAPACIADA_INTELECTUAL"];
                    this.Discapacidad_Mental = response.body.atributos[0]["DISCAPACIDAD_MENTAL"];
                    this.Certificado = response.body.atributos[0]["CERTIFICADO"];
                    this.Carnet_CANADIS = response.body.atributos[0]["CARNET_CANADIS"];
                    this.Transtornos_Neuro = response.body.atributos[0]["TRANSTORNOS_NEURO"];
                    this.Des_Transtorno_Neuro = response.body.atributos[0]["DES_TRANSTORNO_NEURO"];
                    this.CRED = response.body.atributos[0]["CRED"];
                    this.Vacunas = response.body.atributos[0]["VACUNAS"];
                    this.Patologia_1 = response.body.atributos[0]["PATOLOGIA_1"];
                    this.Diagnostico_S1 = response.body.atributos[0]["DIAGNOSTICO_S1"];
                    this.Patologia_2 = response.body.atributos[0]["PATOLOGIA_2"];
                    this.Diagnostico_S3 = response.body.atributos[0]["DIAGNOSTICO_S3"];
                    this.Transtornos_Comportamiento = response.body.atributos[0]["TRANSTORNOS_COMPORTAMIENTO"];
                    this.Tipo_Transtorno = response.body.atributos[0]["TIPO_TRANSTORNO"];
                    this.Gestante = response.body.atributos[0]["GESTANTE"];
                    this.Semanas_Gestacion = response.body.atributos[0]["SEMANAS_GESTACION"];
                    this.Control_Prenatal = response.body.atributos[0]["CONTROL_PRENATAL"];
                    this.Hijos = response.body.atributos[0]["HIJOS"];
                    this.Nro_Hijos = response.body.atributos[0]["NRO_HIJOS"];
                    this.Nivel_Hemoglobina = response.body.atributos[0]["NIVEL_HEMOGLOBINA"];
                    this.Anemia = response.body.atributos[0]["ANEMIA"];
                    this.Peso = response.body.atributos[0]["PESO"];
                    this.Talla = response.body.atributos[0]["TALLA"];
                    this.Estado_Nutricional1 = response.body.atributos[0]["ESTADO_NUTRICIONAL1"];
                    this.Estado_Nutricional2 = response.body.atributos[0]["ESTADO_NUTRICIONAL2"];
                                    
                }
             });


        }
        
    }
  })
