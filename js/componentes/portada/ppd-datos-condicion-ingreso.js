Vue.component('ppd-datos-condicion-ingreso', {
    template: '#ppd-datos-condicion-ingreso',
    data:()=>({
        CarDocIngreso:null,
        CarTipoDoc:null,
        CarNumDoc:null,
        CarPoseePension:null,
        CarTipoPension:null,
        CarULeeEscribe:null,
        CarNivelEducativo:null,
        CarInstitucionEducativa:null,
        CarTipoSeguro:null,
        CarCSocioeconomica:null,
        CarFamiliaresUbicados:null,
        CarTipoParentesco:null,
        CarProblematicaFam:null,

        pensiones:[],
        educativos:[],
        instituciones:[],
        seguros:[],
        socioeconomicos:[],
        parentescos:[],
        familiares:[],
        tipoDocumentos:[],

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
        this.tipo_pension();
        this.nivel_educativo();
        this.institucion_educativa();
        this.tipo_seguro();
        this.clasificacion_socioeconomica();
        this.tipo_parentesco();
        this.problematica_familiar();
        this.tipo_documento_identidad();
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
                Condicion_Id :1,
                DNI:this.CarDocIngreso,
                Tipo_Documento:this.CarTipoDoc,
                Numero_Documento:this.CarNumDoc,
                Posee_Pension :this.CarPoseePension,
                Tipo_Pension:this.CarTipoPension,
                Lee_Escribe:this.CarULeeEscribe,
                Nivel_Educativo:this.CarNivelEducativo,
                Institucion_Educativa:this.CarInstitucionEducativa,
                Tipo_Seguro:this.CarTipoSeguro,
                Clasficacion_Socioeconomica:this.CarCSocioeconomica,
                Familiares:this.CarFamiliaresUbicados,
                Parentesco:this.CarTipoParentesco,
                Problematica_Familiar:this.CarProblematicaFam,
                Residente_Id: this.id_residente,
                Periodo_Mes: parseFloat(moment().format("MM")),
                Periodo_Anio: parseFloat(moment().format("YYYY"))
                        }
            this.$http.post('insertar_datos?view',{tabla:'CarCondicionIngreso', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarCondicionIngreso', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarDocIngreso = response.body.atributos[0]["DNI"];
                    this.CarTipoDoc = response.body.atributos[0]["TIPO_DOCUMENTO"];
                    this.CarNumDoc = response.body.atributos[0]["NUMERO_DOCUMENTO"];
                    this.CarPoseePension = response.body.atributos[0]["POSEE_PENSION"];
                    this.CarTipoPension = response.body.atributos[0]["TIPO_PENSION"];
                    this.CarULeeEscribe = response.body.atributos[0]["LEE_ESCRIBE"];
                    this.CarNivelEducativo = response.body.atributos[0]["NIVEL_EDUCATIVO"];
                    this.CarInstitucionEducativa = response.body.atributos[0]["INSTITUCION_EDUCATIVA"];
                    this.CarTipoSeguro = response.body.atributos[0]["TIPO_SEGURO"];
                    this.CarCSocioeconomica = response.body.atributos[0]["CLASFICACION_SOCIOECONOMICA"];
                    this.CarFamiliaresUbicados = response.body.atributos[0]["FAMILIARES"];
                    this.CarTipoParentesco = response.body.atributos[0]["PARENTESCO"];
                    this.CarProblematicaFam = response.body.atributos[0]["PROBLEMATICA_FAMILIAR"];

                }
             });

        },
        tipo_pension(){
            this.$http.post('buscar?view',{tabla:'pam_tipo_pension'}).then(function(response){
                if( response.body.data ){
                    this.pensiones= response.body.data;
                }
            });
        },
        tipo_documento_identidad(){
            this.$http.post('buscar?view',{tabla:'pam_tipo_documento_identidad'}).then(function(response){
                console.log("tipo_documento_identidad");
                console.log(response.body);
                if( response.body.data ){
                    this.tipoDocumentos= response.body.data;
                }
            });
        },
        nivel_educativo(){
            this.$http.post('buscar?view',{tabla:'pam_nivel_educativo',codigo:'ppd'}).then(function(response){
                if( response.body.data ){
                    this.educativos= response.body.data;
                }
            });
        },
        institucion_educativa(){
            this.$http.post('buscar?view',{tabla:'pam_institucion_educativa'}).then(function(response){
                if( response.body.data ){
                    this.instituciones= response.body.data;
                }
            });
        },
        tipo_seguro(){
            this.$http.post('buscar?view',{tabla:'pam_tipo_seguro_salud'}).then(function(response){
                if( response.body.data ){
                    this.seguros= response.body.data;
                }
            });
        },
        clasificacion_socioeconomica(){
            this.$http.post('buscar?view',{tabla:'pam_clasif_socioeconomico'}).then(function(response){
                if( response.body.data ){
                    this.socioeconomicos= response.body.data;
                }
            });
        },
        tipo_parentesco(){
            this.$http.post('buscar?view',{tabla:'tipo_parentesco'}).then(function(response){
                if( response.body.data ){
                    this.parentescos= response.body.data;
                }
            });
        },
        problematica_familiar(){
            this.$http.post('buscar?view',{tabla:'problematica_familiar',codigo:'ppd'}).then(function(response){
                if( response.body.data ){
                    this.familiares= response.body.data;
                }
            });
        },
    }
  })
