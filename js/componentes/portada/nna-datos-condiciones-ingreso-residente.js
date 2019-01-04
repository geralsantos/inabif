Vue.component('nna-datos-condiciones-ingreso-residente', {
    template: '#nna-datos-condiciones-ingreso-residente',
    data:()=>({

        Tipo_Doc:null,
        Numero_Doc:null,
        Lee_Escribe:null,
        Nivel_Educativo:null,
        Tipo_Seguro:null,
        SISFOH:null,
        id:null,

        tipos_seguros:[],
        niveles_educativos:[],
        clasif_socioeconomica:[],

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
        this.buscar_niveleducativo();
        this.buscar_clasif_socioeconomica();
        this.buscar_pam_tipo_seguro_salud();
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

                Tipo_Doc:this.Tipo_Doc,
                Numero_Doc:this.Numero_Doc,
                Lee_Escribe :this.Lee_Escribe,
                Nivel_Educativo:this.Nivel_Educativo,
                Tipo_Seguro:this.Tipo_Seguro,
                SISFOH:this.SISFOH,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }

            this.$http.post('insertar_datos?view',{tabla:'NNACondicionIResidente', valores:valores}).then(function(response){

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
            let apellido_p = (coincidencia.APELLIDO_P==undefined)?'':coincidencia.APELLIDO_P;
            let apellido_m = (coincidencia.APELLIDO_M==undefined)?'':coincidencia.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;             this.id = coincidencia.ID;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'NNACondicionIResidente', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){
                    console.log(response.body.atributos)
                    this.Tipo_Doc = response.body.atributos[0]["TIPO_DOC"];
                    this.Numero_Doc = response.body.atributos[0]["NUMERO_DOC"];
                    this.Lee_Escribe = response.body.atributos[0]["LEE_ESCRIBE"];
                    this.Nivel_Educativo = response.body.atributos[0]["NIVEL_EDUCATIVO"];
                    this.Tipo_Seguro = response.body.atributos[0]["TIPO_SEGURO"];
                    this.SISFOH = response.body.atributos[0]["SISFOH"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];


                }
             });

        },
        buscar_niveleducativo(){
            this.$http.post('buscar?view',{tabla:'pam_nivel_educativo',codigo:'pam'}).then(function(response){
                if( response.body.data ){
                    this.niveles_educativos= response.body.data;
                }

            });
        },
        buscar_clasif_socioeconomica(){
            this.$http.post('buscar?view',{tabla:'pam_clasif_socioeconomico'}).then(function(response){
                if( response.body.data ){
                    this.clasif_socioeconomica= response.body.data;
                }

            });
        },
        buscar_pam_tipo_seguro_salud(){
            this.$http.post('buscar?view',{tabla:'pam_tipo_seguro_salud'}).then(function(response){
                if( response.body.data ){
                    this.tipos_seguros= response.body.data;
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

            this.Tipo_Doc = null;
            this.Numero_Doc = null;
            this.Lee_Escribe = null;
            this.Nivel_Educativo = null;
            this.Tipo_Seguro = null;
            this.SISFOH = null;
            this.id = null;

            this.id_residente = residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;             this.id = coincidencia.ID;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'NNACondicionIResidente', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Tipo_Doc = response.body.atributos[0]["TIPO_DOC"];
                    this.Numero_Doc = response.body.atributos[0]["NUMERO_DOC"];
                    this.Lee_Escribe = response.body.atributos[0]["LEE_ESCRIBE"];
                    this.Nivel_Educativo = response.body.atributos[0]["NIVEL_EDUCATIVO"];
                    this.Tipo_Seguro = response.body.atributos[0]["TIPO_SEGURO"];
                    this.SISFOH = response.body.atributos[0]["SISFOH"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];


                }
             });

        }

    }
  })
