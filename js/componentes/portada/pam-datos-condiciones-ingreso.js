Vue.component('pam-datos-condiciones-ingreso', {
    template:'#pam-datos-condiciones-ingreso',
    data:()=>({
        documento_entidad:null,
        tipo_documento_entidad:null,
        numero_documento_ingreso:null,
        leer_escribir:null,
        aseguramiento_salud:null,
        tipo_pension:null,
        SISFOH:null,
        familiar_ubicados:null,
        tipo_parentesco:null,
              
        nivel_educativo:[],
        motivos:[],
        motivos2:[],

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
       this.buscar_niveleducativo();
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
                     
            this.$http.post('insertar_datos?view',{tabla:'pam_datos_condiciones_ingreso', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_datos_condiciones_ingreso', residente_id:this.id_residente }).then(function(response){

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
                }
             });

        },

        buscar_niveleducativo(){
            this.$http.post('buscar?view',{tabla:'pam_nivel_educativo'}).then(function(response){
                if( response.body.data ){
                    this.nivel_educativo= response.body.data;
                }

            });
        },
        buscar_motivos(){
            this.$http.post('buscar?view',{tabla:''}).then(function(response){
                if( response.body.data ){
                    this.motivos= response.body.data;
                }

            });
        },
        buscar_motivos2(){
            this.$http.post('buscar?view',{tabla:''}).then(function(response){
                if( response.body.data ){
                    this.motivos2= response.body.data;
                }

            });
        }


        
    }
  })
