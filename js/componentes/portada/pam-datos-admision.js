Vue.component('pam-datos-admision', {
    template:'#pam-datos-admision',
    data:()=>({
        movimiento_poblacional:null,
        fecha_ingreso_usuario:null,
        institucion_deriva:null,
        motivo_ingreso_principal:null,
        motivo_ingreso_secundario:null,
        perfil_ingreso:null,
        tipo_documento_ingreo_car:null,
        numero_documento_ingreo_car:null,
              
        instituciones:[],
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
        this.buscar_instituciones();
        this.buscar_motivos();
        this.buscar_motivos2();
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
               
                movimiento_poblacional:this.movimiento_poblacional,
                fecha_ingreso_usuario:moment(this.fecha_ingreso_usuario).format("YY-MMM-DD"),
                institucion_deriva:this.institucion_deriva,
                motivo_ingreso_principal:this.motivo_ingreso_principal,
                motivo_ingreso_secundario:this.motivo_ingreso_secundario,
                perfil_ingreso:(this.perfil_ingreso).join(),
                tipo_documento_ingreo_car:this.tipo_documento_ingreo_car,
                numero_documento_ingreo_car:this.numero_documento_ingreo_car,
                
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                     
            this.$http.post('insertar_datos?view',{tabla:'pam_datos_admision_usuario', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_datos_admision_usuario', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.movimiento_poblacional = response.body.atributos[0]["MOVIMIENTO_POBLACIONAL"];
                    this.fecha_ingreso_usuario = moment(response.body.atributos[0]["FECHA_INGRESO_USUARIO"]).format("YYYY-MM-DD");
                    this.institucion_deriva = response.body.atributos[0]["INSTITUCION_DERIVA"];
                    this.motivo_ingreso_principal = response.body.atributos[0]["MOTIVO_INGRESO_PRINCIPAL"];
                    this.motivo_ingreso_secundario = response.body.atributos[0]["MOTIVO_INGRESO_SECUNDARIO"];
                    this.perfil_ingreso = response.body.atributos[0]["PERFIL_INGRESO"];
                    this.tipo_documento_ingreo_car = response.body.atributos[0]["TIPO_DOCUMENTO_INGREO_CAR"];
                    this.numero_documento_ingreo_car = response.body.atributos[0]["NUMERO_DOCUMENTO_INGREO_CAR"];

                }
             });

        },

        buscar_instituciones(){
            this.$http.post('buscar?view',{tabla:'pam_instituciones_deriva'}).then(function(response){
                if( response.body.data ){
                    this.instituciones= response.body.data;
                }

            });
        },
        buscar_motivos(){
            this.$http.post('buscar?view',{tabla:'pam_motivos_ingreso'}).then(function(response){
                if( response.body.data ){
                    this.motivos= response.body.data;
                }

            });
        },
        buscar_motivos2(){
            this.$http.post('buscar?view',{tabla:'pam_motivos_ingreso'}).then(function(response){
                if( response.body.data ){
                    this.motivos2= response.body.data;
                }

            });
        }


        
    }
  })
