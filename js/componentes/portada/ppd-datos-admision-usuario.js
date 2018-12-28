Vue.component('ppd-datos-admision-usuario', {
    template:'#ppd-datos-admision-usuario',
    data:()=>({
        CarMPoblacional:null,
        CarFIngreso:null,
        CarFReingreso:null,
        CarIDerivo:null,
        CarMotivoI:null,
        CarTipoDoc:null,
        CarNumDoc:null,

        instituciones:[],
        documentos:[],

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
        this.buscar_tipo_documento_ingreso();
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
                Admision_Id: 1,
                Mov_Poblacional: this.CarMPoblacional,
                Fecha_Ingreso:  moment(this.CarFIngreso, "YYYY-MM-DD").format("YY-MM-DD"),
                Fecha_Reingreso:moment(this.CarFReingreso, "YYYY-MM-DD").format("YY-MM-DD"),
                Institucion_derivado: this.CarIDerivo,
                Motivo_Ingreso: this.CarMotivoI,
                Tipo_Documento: this.CarTipoDoc,
                Numero_Documento: this.CarNumDoc,
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

                        }
            this.$http.post('insertar_datos?view',{tabla:'CarDatosAdmision', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarDatosAdmision', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarMPoblacional = response.body.atributos[0]["MOV_POBLACIONAL"];
                    this.CarFIngreso = response.body.atributos[0]["FECHA_INGRESO"];
                    this.CarFReingreso = response.body.atributos[0]["FECHA_REINGRESO"];
                    this.CarIDerivo = response.body.atributos[0]["INSTITUCION_DERIVADO"];
                    this.CarMotivoI = response.body.atributos[0]["INSTITUCION_DERIVADO"];
                    this.CarTipoDoc = response.body.atributos[0]["MOTIVO_INGRESO"];
                    this.CarNumDoc = response.body.atributos[0]["NUMERO_DOCUMENTO"];

                }
             });

        },
        buscar_instituciones(){
            this.$http.post('buscar?view',{tabla:'pam_instituciones'}).then(function(response){
                if( response.body.data ){
                    this.instituciones= response.body.data;
                }

            });
        },

        buscar_tipo_documento_ingreso(){
            this.$http.post('buscar?view',{tabla:'tipo_documento_ingreso'}).then(function(response){
                if( response.body.data ){
                    this.documentos= response.body.data;
                }

            });
        }
    }
  })
