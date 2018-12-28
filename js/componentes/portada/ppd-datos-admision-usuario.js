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
        buscar_instituciones();
        buscar_tipo_documento_ingreso();
    },
    updated:function(){
    },
    methods:{
        guardar(){
            let valores = { Mov_Poblacional: this.CarMPoblacional,
                Fecha_Ingreso: this.CarFIngreso,
                Fecha_Reingreso: this.CarFReingreso,
                Institucion_derivado: this.CarIDerivo,
                Motivo_Ingreso: this.CarMotivoI,
                Tipo_Documento: this.CarTipoDoc,
                Numero_Documento: this.CarNumDoc

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

            let word = this.nombre_residente;
            if( word.length >= 4){
                this.coincidencias = [];
                this.bloque_busqueda = true;
                this.isLoading = true;
                this.$http.post('ejecutar_consulta?view',{tabla:'', campo:'coincidencia', like:word }).then(function(response){

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
        actualizar(id){
            this.id_residente = id;
            this.coincidencias = [];
            this.bloque_busqueda = false;
            let where = {"residente_id": this.id_residente, "estado": 1}
            this.$http.post('cargar_datos_residente?view',{tabla:'CarDatosAdmision', where:where }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarMPoblacional= response.body.atributos[0]["Mov_Poblacional"];
                    this.CarFIngreso= response.body.atributos[0]["Mov_Poblacional"];
                    this.CarFReingreso= response.body.atributos[0]["Fecha_Reingreso"];
                    this.CarIDerivo= response.body.atributos[0]["Institucion_derivado"];
                    this.CarMotivoI= response.body.atributos[0]["Motivo_Ingreso"];
                    this.CarTipoDoc= response.body.atributos[0]["Tipo_Documento"];
                    this.CarNumDoc= response.body.atributos[0]["Numero_Documento"];

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
