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
        id:null,

        patologias:[],

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
        this.buscar_patologias();

    },
    updated:function(){
    },
    methods:{
        inicializar(){
            this.discapacidad = null;
            this.discapacidad_fisica = null;
            this.discapacidad_intelectual = null;
            this.discapacidad_sensorial = null;
            this.presenta_discapacidad_mental = null;
            this.dx_certificado = null;
            this.carnet_conadis = null;
            this.grado_dependencia_pam = null;
            this.motivo_dif_desplazamiento = null;
            this.enfermedad_ingreso_1 = null;
            this.tipo_patologia = null;
            this.tipo_patologia_2 = null;
            this.enfermedad_ingreso_2 = null;
            this.nivel_hemoglobina = null;
            this.presenta_anema = null;
            this.peso = null;
            this.talla = null;
            this.estado_nutricional = null;
            this.id = null;

            this.patologias=[];

            this.nombre_residente=null;
            this.isLoading=false;
            this.mes=moment().format("M");
            this.anio=(new Date()).getFullYear();
            this.coincidencias=[];
            this.bloque_busqueda=false;
            this.id_residente=null;
            this.modal_lista=false;
            this.pacientes = [];

            this.buscar_patologias();
        },
        guardar(){
            if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'warning');
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
                        estado_nutricional:this.estado_nutricional,
                        Residente_Id: this.id_residente,
                        Periodo_Mes: moment().format("MM"),
                        Periodo_Anio:moment().format("YYYY")

                    }

            this.$http.post('insertar_datos?view',{tabla:'pam_datos_saludnutric', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    this.inicializar();
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
            this.id_residente = coincidencia.ID;               this.id=coincidencia.ID;
            let nombre=(coincidencia.NOMBRE==undefined)?'':coincidencia.NOMBRE;
            let apellido_p = (coincidencia.APELLIDO_P==undefined)?'':coincidencia.APELLIDO_P;
            let apellido_m = (coincidencia.APELLIDO_M==undefined)?'':coincidencia.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_datos_saludnutric', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.discapacidad = response.body.atributos[0]["DISCAPACIDAD"];
                    this.discapacidad_fisica = response.body.atributos[0]["DISCAPACIDAD_FISICA"];
                    this.discapacidad_intelectual = response.body.atributos[0]["DISCAPACIDAD_INTELECTUAL"];
                    this.discapacidad_sensorial = response.body.atributos[0]["DISCAPACIDAD_SENSORIAL"];
                    this.presenta_discapacidad_mental = response.body.atributos[0]["PRESENTA_DISCAPACIDAD_MENTAL"];
                    this.dx_certificado = response.body.atributos[0]["DX_CERTIFICADO"];
                    this.carnet_conadis = response.body.atributos[0]["CARNET_CONADIS"];
                    this.grado_dependencia_pam = response.body.atributos[0]["GRADO_DEPENDENCIA_PAM"];
                    this.motivo_dif_desplazamiento = response.body.atributos[0]["MOTIVO_DIF_DESPLAZAMIENTO"];
                    this.enfermedad_ingreso_1 = response.body.atributos[0]["ENFERMEDAD_INGRESO_1"];
                    this.tipo_patologia = response.body.atributos[0]["TIPO_PATOLOGIA"];
                    this.tipo_patologia_2 = response.body.atributos[0]["TIPO_PATOLOGIA_2"];
                    this.enfermedad_ingreso_2 = response.body.atributos[0]["ENFERMEDAD_INGRESO_2"];
                    this.nivel_hemoglobina = response.body.atributos[0]["NIVEL_HEMOGLOBINA"];
                    this.presenta_anema = response.body.atributos[0]["PRESENTA_ANEMA"];
                    this.peso = response.body.atributos[0]["PESO"];
                    this.talla = response.body.atributos[0]["TALLA"];
                    this.estado_nutricional = response.body.atributos[0]["ESTADO_NUTRICIONAL"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];
                }
             });

        },
        buscar_patologias(){
            this.$http.post('buscar?view',{tabla:'pam_tipo_patologia'}).then(function(response){
                if( response.body.data ){
                    this.patologias= response.body.data;
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

            this.discapacidad = null;
            this.discapacidad_fisica = null;
            this.discapacidad_intelectual = null;
            this.discapacidad_sensorial = null;
            this.presenta_discapacidad_mental = null;
            this.dx_certificado = null;
            this.carnet_conadis = null;
            this.grado_dependencia_pam = null;
            this.motivo_dif_desplazamiento = null;
            this.enfermedad_ingreso_1 = null;
            this.tipo_patologia = null;
            this.tipo_patologia_2 = null;
            this.enfermedad_ingreso_2 = null;
            this.nivel_hemoglobina = null;
            this.presenta_anema = null;
            this.peso = null;
            this.talla = null;
            this.estado_nutricional = null;
            this.id = null;


            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_datos_saludnutric', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.discapacidad = response.body.atributos[0]["DISCAPACIDAD"];
                    this.discapacidad_fisica = response.body.atributos[0]["DISCAPACIDAD_FISICA"];
                    this.discapacidad_intelectual = response.body.atributos[0]["DISCAPACIDAD_INTELECTUAL"];
                    this.discapacidad_sensorial = response.body.atributos[0]["DISCAPACIDAD_SENSORIAL"];
                    this.presenta_discapacidad_mental = response.body.atributos[0]["PRESENTA_DISCAPACIDAD_MENTAL"];
                    this.dx_certificado = response.body.atributos[0]["DX_CERTIFICADO"];
                    this.carnet_conadis = response.body.atributos[0]["CARNET_CONADIS"];
                    this.grado_dependencia_pam = response.body.atributos[0]["GRADO_DEPENDENCIA_PAM"];
                    this.motivo_dif_desplazamiento = response.body.atributos[0]["MOTIVO_DIF_DESPLAZAMIENTO"];
                    this.enfermedad_ingreso_1 = response.body.atributos[0]["ENFERMEDAD_INGRESO_1"];
                    this.tipo_patologia = response.body.atributos[0]["TIPO_PATOLOGIA"];
                    this.tipo_patologia_2 = response.body.atributos[0]["TIPO_PATOLOGIA_2"];
                    this.enfermedad_ingreso_2 = response.body.atributos[0]["ENFERMEDAD_INGRESO_2"];
                    this.nivel_hemoglobina = response.body.atributos[0]["NIVEL_HEMOGLOBINA"];
                    this.presenta_anema = response.body.atributos[0]["PRESENTA_ANEMA"];
                    this.peso = response.body.atributos[0]["PESO"];
                    this.talla = response.body.atributos[0]["TALLA"];
                    this.estado_nutricional = response.body.atributos[0]["ESTADO_NUTRICIONAL"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];
                }
             });

        }


    }
  })
