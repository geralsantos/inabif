Vue.component('nna-datos-familiares-sociales-residente', {
    template: '#nna-datos-familiares-sociales-residente',
    data:()=>({

        Familiares:null,
        Parentesco:null,
        Tipo_Familia:null,
        Problematica_Fami:null,
        id:null,

        problematicas:[],
        parentescos:[],
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
        this.cargar_problematicas();
        this.tipo_parentesco();
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

                Familiares:this.Familiares,
                Parentesco:this.Parentesco,
                Tipo_Familia:this.Tipo_Familia,
                Problematica_Fami:this.Problematica_Fami,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }

            this.$http.post('insertar_datos?view',{tabla:'NNAFamiliaresResidente', valores:valores}).then(function(response){

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
            this.id_residente = coincidencia.ID;               this.id=coincidencia.ID;
            let nombre=(coincidencia.NOMBRE==undefined)?'':coincidencia.NOMBRE;
            let apellido_p = (coincidencia.APELLIDO_P==undefined)?'':coincidencia.APELLIDO_P;
            let apellido_m = (coincidencia.APELLIDO_M==undefined)?'':coincidencia.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'NNAFamiliaresResidente', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Familiares = response.body.atributos[0]["FAMILIARES"];
                    this.Parentesco = response.body.atributos[0]["PARENTESCO"];
                    this.Tipo_Familia = response.body.atributos[0]["TIPO_FAMILIA"];
                    this.Problematica_Fami = response.body.atributos[0]["PROBLEMATICA_FAMI"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             });

        },
        tipo_parentesco(){
            this.$http.post('buscar?view',{tabla:'pam_tipo_parentesco',codigo:'ppd'}).then(function(response){
                if( response.body.data ){
                    this.parentescos= response.body.data;
                }
            });
        },
        cargar_problematicas(){
            this.$http.post('buscar?view',{tabla:'Nnaproblematica_familiar'}).then(function(response){
                if( response.body.data ){
                    this.problematicas= response.body.data;
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

            this.Familiares = null;
            this.Parentesco = null;
            this.Tipo_Familia = null;
            this.Problematica_Fami = null;
            this.id = null;

            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'NNAFamiliaresResidente', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Familiares = response.body.atributos[0]["FAMILIARES"];
                    this.Parentesco = response.body.atributos[0]["PARENTESCO"];
                    this.Tipo_Familia = response.body.atributos[0]["TIPO_FAMILIA"];
                    this.Problematica_Fami = response.body.atributos[0]["PROBLEMATICA_FAMI"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             });

        }

    }
  })
