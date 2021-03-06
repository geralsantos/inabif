var pam_datos_condiciones_ingreso =  {
    template:'#pam-datos-condiciones-ingreso',
    data:()=>({
        documento_entidad:null,
        tipo_documento_entidad:null,
        numero_documento_ingreso:null,
        leer_escribir:null,
        nivel_educativo:null,
        aseguramiento_salud:null,
        tipo_pension:null,
        SISFOH:null,
        familiar_ubicados:null,
        tipo_parentesco:null,
        id:null,

        niveles_educativos:[],
        clasif_socioeconomica:[],
        tipos_parentescos:[],

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
       this.buscar_tipoparentesco();
    },
    updated:function(){
    },
    methods:{
        inicializar(){
            this.documento_entidad = null;
            this.tipo_documento_entidad = null;
            this.numero_documento_ingreso = null;
            this.leer_escribir = null;
            this.nivel_educativo = null;
            this.aseguramiento_salud = null;
            this.tipo_pension = null;
            this.SISFOH = null;
            this.familiar_ubicados = null;
            this.tipo_parentesco = null;
            this.id = null;

            this.niveles_educativos=[];
            this.clasif_socioeconomica=[];
            this.tipos_parentescos=[];

            this.nombre_residente=null;
            this.isLoading=false;
            this.mes=moment().format("M");
            this.anio=(new Date()).getFullYear();
            this.coincidencias=[];
            this.bloque_busqueda=false;
            this.id_residente=null;
            this.modal_lista=false;
            this.pacientes = [];

            this.buscar_niveleducativo();
            this.buscar_clasif_socioeconomica();
           // this.buscar_tipoparentesco();

        },
        guardar(){
            if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'warning');
                return false;
            }
            let valores = {

                documento_entidad:this.documento_entidad,
                tipo_documento_entidad:this.tipo_documento_entidad,
                numero_documento_ingreso:this.numero_documento_ingreso,
                leer_escribir:this.leer_escribir,
                nivel_educativo:this.nivel_educativo,
                aseguramiento_salud:this.aseguramiento_salud,
                tipo_pension:this.tipo_pension,
                SISFOH:this.SISFOH,
                familiar_ubicados:this.familiar_ubicados,
                tipo_parentesco:this.tipo_parentesco,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }

            this.$http.post('insertar_datos?view',{tabla:'pam_datosCondicionIngreso', valores:valores}).then(function(response){

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
            if( word.length >= 2){
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

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_datosCondicionIngreso', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.documento_entidad = response.body.atributos[0]["DOCUMENTO_ENTIDAD"];
                    this.tipo_documento_entidad = response.body.atributos[0]["TIPO_DOCUMENTO_ENTIDAD"];
                    this.numero_documento_ingreso = response.body.atributos[0]["NUMERO_DOCUMENTO_INGRESO"];
                    this.leer_escribir = response.body.atributos[0]["LEER_ESCRIBIR"];
                    this.nivel_educativo = response.body.atributos[0]["NIVEL_EDUCATIVO"];
                    this.aseguramiento_salud = response.body.atributos[0]["ASEGURAMIENTO_SALUD"];
                    this.tipo_pension = response.body.atributos[0]["TIPO_PENSION"];
                    this.SISFOH = response.body.atributos[0]["SISFOH"];
                    this.familiar_ubicados = response.body.atributos[0]["FAMILIAR_UBICADOS"];
                    this.tipo_parentesco = response.body.atributos[0]["TIPO_PARENTESCO"];
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
        buscar_tipoparentesco(){
            this.$http.post('buscar?view',{tabla:'pam_tipo_parentesco ',codigo:'pam'}).then(function(response){
                if( response.body.data ){
                    this.tipos_parentescos= response.body.data;
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

            this.documento_entidad = null;
            this.tipo_documento_entidad = null;
            this.numero_documento_ingreso = null;
            this.leer_escribir = null;
            this.nivel_educativo = null;
            this.aseguramiento_salud = null;
            this.tipo_pension = null;
            this.SISFOH = null;
            this.familiar_ubicados = null;
            this.tipo_parentesco = null;
            this.id = null;


            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_datosCondicionIngreso', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.documento_entidad = response.body.atributos[0]["DOCUMENTO_ENTIDAD"];
                    this.tipo_documento_entidad = response.body.atributos[0]["TIPO_DOCUMENTO_ENTIDAD"];
                    this.numero_documento_ingreso = response.body.atributos[0]["NUMERO_DOCUMENTO_INGRESO"];
                    this.leer_escribir = response.body.atributos[0]["LEER_ESCRIBIR"];
                    this.nivel_educativo = response.body.atributos[0]["NIVEL_EDUCATIVO"];
                    this.aseguramiento_salud = response.body.atributos[0]["ASEGURAMIENTO_SALUD"];
                    this.tipo_pension = response.body.atributos[0]["TIPO_PENSION"];
                    this.SISFOH = response.body.atributos[0]["SISFOH"];
                    this.familiar_ubicados = response.body.atributos[0]["FAMILIAR_UBICADOS"];
                    this.tipo_parentesco = response.body.atributos[0]["TIPO_PARENTESCO"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];
                }
             });

        }



    }
  }
